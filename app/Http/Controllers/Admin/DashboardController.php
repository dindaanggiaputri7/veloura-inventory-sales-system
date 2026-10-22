<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
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
        $totalPurchases = Purchase::count();
        $totalSales = Sale::count();

        $totalSalesAmount = Sale::sum('total_amount');

        // Produk yang perlu segera diperiksa stoknya.
        $lowStockList = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get();

        // Grafik penjualan selama tujuh hari, termasuk hari ini.
        $salesChart = [];
        $chartMax = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $amount = (float) Sale::whereDate('sale_date', $date)
                ->where('status', 'completed')
                ->sum('total_amount');

            $salesChart[] = [
                'label' => $date->translatedFormat('D'),
                'date' => $date->format('d/m'),
                'amount' => $amount,
            ];

            $chartMax = max($chartMax, $amount);
        }

        // Transaksi penjualan terbaru.
        $recentSales = Sale::query()
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $saleIds = $recentSales->pluck('id');

        $itemCounts = SaleItem::query()
            ->whereIn('sale_id', $saleIds)
            ->select('sale_id', DB::raw('SUM(quantity) as total_items'))
            ->groupBy('sale_id')
            ->pluck('total_items', 'sale_id');

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
            'recentSales',
            'itemCounts'
        ));
    }
}
