<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
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

        $totalSuppliers = Supplier::count();

        $totalPurchases = Purchase::count();

        $totalSales = Sale::count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $totalSalesAmount = Sale::sum('total_amount');

        return view('admin.dashboard', compact(
            'totalStaff',
            'activeStaff',
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
