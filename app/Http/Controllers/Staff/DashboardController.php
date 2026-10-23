<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    private function ensureStaff(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'staff',
            403
        );
    }

    public function index(): View
    {
        $this->ensureStaff();

        /*
        |--------------------------------------------------------------------------
        | Ringkasan dashboard
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        // Pesanan online yang belum selesai atau dibatalkan.
        $pendingOrders = DB::table('customer_orders')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->count();

        // Penjualan langsung saja, tidak termasuk pesanan online.
        $todaySales = Sale::whereDate('sale_date', today());

        $todaySalesCount = (clone $todaySales)->count();

        $todaySalesAmount = (float) (clone $todaySales)
            ->sum('total_amount');

        $totalSales = Sale::count();

        $totalSalesAmount = (float) Sale::sum('total_amount');

        // Pembelian stok dari supplier.
        $totalPurchases = Purchase::count();

        $totalPurchasesAmount = (float) Purchase::sum('total_amount');

        // Pesanan online yang belum dibayar.
        $unpaidOrders = DB::table('customer_orders')
            ->where('payment_status', 'unpaid')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Produk dengan stok menipis
        |--------------------------------------------------------------------------
        */

        $lowStockList = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )
            ->orderBy('stock')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Transaksi terbaru
        |--------------------------------------------------------------------------
        */

        $recentSales = Sale::orderByDesc('sale_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $recentPurchases = Purchase::with('supplier')
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Hanya pesanan yang masih perlu ditangani staff.
        $recentOrders = DB::table('customer_orders')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Produk terlaris dari penjualan langsung
        |--------------------------------------------------------------------------
        */

        $bestSellingProducts = SaleItem::selectRaw(
            'product_id, SUM(quantity) as total_sold'
        )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Grafik penjualan langsung dan pembelian stok tujuh hari
        |--------------------------------------------------------------------------
        */

        $chartDays = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $chartDays->push([
                'label' => $date->translatedFormat('D'),
                'date' => $date->toDateString(),

                // Hanya transaksi penjualan langsung.
                'sales' => (float) Sale::whereDate(
                    'sale_date',
                    $date
                )->sum('total_amount'),

                // Hanya pembelian stok.
                'purchases' => (float) Purchase::whereDate(
                    'purchase_date',
                    $date
                )->sum('total_amount'),
            ]);
        }

        $chartMax = max(
            1,
            (float) $chartDays->max('sales'),
            (float) $chartDays->max('purchases')
        );

        /*
        |--------------------------------------------------------------------------
        | Data untuk tampilan dashboard
        |--------------------------------------------------------------------------
        */

        return view('staff.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'pendingOrders',
            'todaySalesCount',
            'todaySalesAmount',
            'totalSales',
            'totalSalesAmount',
            'totalPurchases',
            'totalPurchasesAmount',
            'unpaidOrders',
            'lowStockList',
            'recentSales',
            'recentPurchases',
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

        // Jenis pertama: penjualan langsung.
        $sales = Sale::orderByDesc('sale_date')
            ->orderByDesc('id')
            ->get()
            ->map(function ($sale) {
                return (object) [
                    'transaction_number' => $sale->sale_number,
                    'transaction_date' => $sale->sale_date,
                    'customer' => $sale->customer_name ?: 'Pelanggan umum',
                    'total' => $sale->total_amount,
                    'status' => $sale->status,
                    'type' => 'Penjualan langsung',
                ];
            });

        // Jenis kedua: pesanan customer online.
        $orders = DB::table('customer_orders')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                return (object) [
                    'transaction_number' => $order->order_number,
                    'transaction_date' => $order->created_at,
                    'customer' => $order->customer_name ?: '-',
                    'total' => $order->total,
                    'status' => $order->status,
                    'type' => 'Pesanan Customer',
                ];
            });

        // Gabungkan untuk riwayat, tetapi jenis transaksinya tetap dibedakan.
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

        return view(
            'staff.transactions.index',
            compact('transactions')
        );
    }
}
