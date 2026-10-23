<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\SaleItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private function ensureStaff(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'staff', 403);
    }

    public function index(): View
    {
        $this->ensureStaff();

        // Ringkasan inventaris.
        $totalProducts = Product::count();

        $lowStockQuery = Product::whereColumn('stock', '<=', 'minimum_stock');
        $lowStockProducts = (clone $lowStockQuery)->count();
        $lowStockList = (clone $lowStockQuery)
            ->with('category')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get();

        // Penjualan langsung: hanya transaksi berstatus selesai.
        $directSales = DB::table('sales')->where('status', 'completed');

        // Pesanan Customer online: hanya yang pembayarannya sudah lunas/diverifikasi.
        $paidOrders = DB::table('customer_orders')
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled');

        $totalDirectSalesCount = (clone $directSales)->count();
        $totalDirectSalesAmount = (float) (clone $directSales)->sum('total_amount');
        $totalOnlineOrdersCount = (clone $paidOrders)->count();
        $totalOnlineOrdersAmount = (float) (clone $paidOrders)->sum('total');

        // Total penjualan Staff dibuat sama dengan cara Admin menghitungnya:
        // penjualan langsung selesai + pesanan online yang sudah dibayar.
        $totalSales = $totalDirectSalesCount + $totalOnlineOrdersCount;
        $totalSalesAmount = $totalDirectSalesAmount + $totalOnlineOrdersAmount;

        $todayDirectSales = DB::table('sales')
            ->whereDate('sale_date', today())
            ->where('status', 'completed');
        $todayOnlineOrders = DB::table('customer_orders')
            ->whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled');

        $todaySalesCount = (clone $todayDirectSales)->count()
            + (clone $todayOnlineOrders)->count();
        $todaySalesAmount = (float) (clone $todayDirectSales)->sum('total_amount')
            + (float) (clone $todayOnlineOrders)->sum('total');

        // Pesanan yang masih membutuhkan tindakan Staff.
        $pendingOrders = DB::table('customer_orders')
            ->whereNotIn('status', ['completed', 'delivered', 'cancelled'])
            ->count();
        $unpaidOrders = DB::table('customer_orders')
            ->where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->count();

        // Pembelian stok dari supplier, tidak menghitung transaksi yang dibatalkan.
        $totalPurchases = Purchase::where('status', '!=', 'cancelled')->count();
        $totalPurchasesAmount = (float) Purchase::where('status', '!=', 'cancelled')
            ->sum('total_amount');
        $recentPurchases = Purchase::with('supplier')
            ->where('status', '!=', 'cancelled')
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Lima penjualan langsung terbaru, mengikuti struktur data Dashboard Admin.
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
                    WHERE customer_order_items.customer_order_id = customer_orders.id
                ) AS items_count
            ")
            ->where('payment_status', 'paid')
            ->where('status', '!=', 'cancelled')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Gabungkan hanya untuk daftar terbaru; sumber transaksi tetap diberi label.
        $recentSales = $recentDirectSales
            ->concat($recentOnlineOrders)
            ->sortByDesc(function ($transaction) {
                return sprintf(
                    '%010d%010d',
                    Carbon::parse($transaction->sale_date)->timestamp,
                    (int) $transaction->id
                );
            })
            ->take(5)
            ->values();

        $recentOrders = DB::table('customer_orders')
            ->whereNotIn('status', ['completed', 'delivered', 'cancelled'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Produk terlaris dari transaksi penjualan langsung.
        $bestSellingProducts = SaleItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Grafik tujuh hari: tiga kategori yang berbeda agar tidak tercampur.
        $chartDays = collect();

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

            $purchaseAmount = (float) Purchase::whereDate('purchase_date', $dateString)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');

            $chartDays->push([
                'label' => $date->translatedFormat('D'),
                'date' => $date->format('d/m'),
                'sales' => $directAmount,
                'orders' => $onlineAmount,
                'purchases' => $purchaseAmount,
            ]);
        }

        $chartMax = max(
            1,
            (float) $chartDays->max('sales'),
            (float) $chartDays->max('orders'),
            (float) $chartDays->max('purchases')
        );

        return view('staff.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'lowStockList',
            'totalDirectSalesCount',
            'totalDirectSalesAmount',
            'totalOnlineOrdersCount',
            'totalOnlineOrdersAmount',
            'totalSales',
            'totalSalesAmount',
            'todaySalesCount',
            'todaySalesAmount',
            'pendingOrders',
            'unpaidOrders',
            'totalPurchases',
            'totalPurchasesAmount',
            'recentPurchases',
            'recentSales',
            'recentOrders',
            'bestSellingProducts',
            'chartDays',
            'chartMax'
        ));
    }

    public function products(): View
    {
        $this->ensureStaff();

        $products = Product::with('category')
            ->orderBy('name')
            ->paginate(10);

        return view('staff.products.index', compact('products'));
    }

    public function sales()
    {
        $this->ensureStaff();

        return redirect()->route('staff.sales.index');
    }

    public function transactions(): View
    {
        $this->ensureStaff();

        // Riwayat penjualan langsung.
        $sales = DB::table('sales')
            ->selectRaw("
                sale_number AS transaction_number,
                sale_date AS transaction_date,
                COALESCE(customer_name, 'Pelanggan umum') AS customer,
                total_amount AS total,
                status,
                payment_method,
                'Penjualan langsung' AS type
            ")
            ->get();

        // Riwayat semua pesanan online, baik lunas maupun belum lunas.
        $orders = DB::table('customer_orders')
            ->selectRaw("
                order_number AS transaction_number,
                created_at AS transaction_date,
                COALESCE(customer_name, '-') AS customer,
                total,
                status,
                payment_method,
                CASE
                    WHEN payment_status = 'paid' THEN 'Pesanan Customer (Lunas)'
                    ELSE 'Pesanan Customer (Belum Lunas)'
                END AS type
            ")
            ->get();

        $all = $sales->concat($orders)
            ->sortByDesc('transaction_date')
            ->values();

        $page = max(1, (int) request()->query('page', 1));
        $perPage = 10;

        $transactions = new LengthAwarePaginator(
            $all->slice(($page - 1) * $perPage, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('staff.transactions.index', compact('transactions'));
    }
}
