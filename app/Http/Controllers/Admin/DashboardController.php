<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $totalStaff = User::where('role', 'staff')->count();

        $activeStaff = User::where('role', 'staff')
            ->where('is_active', true)
            ->count();

        $totalCategories = Category::count();
        $totalProducts = Product::count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $totalSuppliers = Supplier::count();

        $totalPurchases = Purchase::where(
            'status',
            '!=',
            'cancelled'
        )->count();

        // Penjualan langsung yang selesai.
        $directSales = DB::table('sales')
            ->where('status', 'completed');

        // Pesanan online yang pembayarannya sudah diverifikasi.
        $paidOrders = DB::table('customer_orders')
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled');

        // Total transaksi dan nilai penjualan gabungan.
        $totalSales = (clone $directSales)->count()
            + (clone $paidOrders)->count();

        $totalSalesAmount = (float) (clone $directSales)
            ->sum('total_amount')
            + (float) (clone $paidOrders)->sum('total');

        // Produk yang perlu segera diperiksa stoknya.
        $lowStockList = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get();

        // Grafik penjualan 7 hari terakhir:
        // penjualan langsung + pesanan online yang telah dibayar.
        $salesChart = [];
        $chartMax = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateString = $date->toDateString();

            $directAmount = (float) DB::table('sales')
                ->whereDate('sale_date', $dateString)
                ->where('status', 'completed')
                ->sum('total_amount');

            $onlineAmount = (float) DB::table('customer_orders')
                ->whereDate('created_at', $dateString)
                ->where('payment_status', 'paid')
                ->where('status', '!=', 'cancelled')
                ->sum('total');

            $amount = $directAmount + $onlineAmount;

            $salesChart[] = [
                'label' => $date->translatedFormat('D'),
                'date' => $date->format('d/m'),
                'amount' => $amount,
            ];

            $chartMax = max($chartMax, $amount);
        }

        // Lima penjualan langsung terbaru.
        $recentDirectSales = DB::table('sales')
            ->selectRaw("
                'langsung' AS source_type,
                id,
                sale_number,
                sale_date,
                customer_name,
                total_amount,
                status,
                payment_method,
                NULL AS payment_status,
                (
                    SELECT COALESCE(SUM(quantity), 0)
                    FROM sale_items
                    WHERE sale_items.sale_id = sales.id
                ) AS items_count
            ")
            ->where('status', 'completed')
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Lima pesanan online terbaru yang telah dibayar.
        $recentOnlineOrders = DB::table('customer_orders')
            ->selectRaw("
                'online' AS source_type,
                id,
                order_number AS sale_number,
                DATE(created_at) AS sale_date,
                customer_name,
                total AS total_amount,
                status,
                payment_method,
                payment_status,
                (
                    SELECT COALESCE(SUM(quantity), 0)
                    FROM customer_order_items
                    WHERE customer_order_items.customer_order_id
                        = customer_orders.id
                ) AS items_count
            ")
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Gabungkan hanya untuk tampilan Dashboard.
        $recentSales = $recentDirectSales
            ->concat($recentOnlineOrders)
            ->sortByDesc(function ($transaction) {
                return Carbon::parse($transaction->sale_date)
                    ->format('Ymd')
                    . str_pad((string) $transaction->id, 10, '0', STR_PAD_LEFT);
            })
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalStaff',
            'activeStaff',
            'totalCategories',
            'totalProducts',
            'lowStockProducts',
            'totalSuppliers',
            'totalPurchases',
            'totalSales',
            'totalSalesAmount',
            'lowStockList',
            'salesChart',
            'chartMax',
            'recentSales'
        ));
    }
}
