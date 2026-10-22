<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->role === 'staff', 403);

        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $totalPurchases = Purchase::count();
        $totalSales = Sale::count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $totalSalesAmount = Sale::sum('total_amount');

        return view('staff.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalSuppliers',
            'totalPurchases',
            'totalSales',
            'lowStockProducts',
            'totalSalesAmount'
        ));
    }
}
