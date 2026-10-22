<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'staff', 403);

        $totalProducts = Product::count();

        $todaySalesCount = Sale::whereDate(
            'sale_date',
            today()
        )->count();

        $totalSales = Sale::count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $lowStockList = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )
            ->orderBy('stock')
            ->limit(5)
            ->get();

        $recentSales = Sale::latest('sale_date')
            ->limit(5)
            ->get();

        $bestSellingProducts = SaleItem::selectRaw(
            'product_id, SUM(quantity) as total_sold'
        )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('staff.dashboard', compact(
            'totalProducts',
            'todaySalesCount',
            'totalSales',
            'lowStockProducts',
            'lowStockList',
            'recentSales',
            'bestSellingProducts'
        ));
    }

    public function products(): View
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'staff', 403);

        $products = Product::orderBy('name')->paginate(10);

        return view('staff.products.index', compact('products'));
    }

    public function sales(): View
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'staff', 403);

        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('staff.sales.index', compact('products'));
    }

    public function transactions(): View
    {
        abort_unless(auth()->check(), 403);
        abort_unless(auth()->user()->role === 'staff', 403);

        $sales = Sale::latest('sale_date')->paginate(10);

        return view('staff.transactions.index', compact('sales'));
    }
}
