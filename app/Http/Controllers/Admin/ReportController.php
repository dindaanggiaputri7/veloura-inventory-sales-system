<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    public function index(Request $request): View
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = $validated['start_date'] ?? now()->startOfMonth()->toDateString();
        $endDate = $validated['end_date'] ?? now()->toDateString();

        $salesQuery = Sale::query()
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled');

        $purchasesQuery = Purchase::query()
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled');

        $totalSales = (clone $salesQuery)->count();
        $salesAmount = (float) (clone $salesQuery)->sum('total_amount');
        $totalPurchases = (clone $purchasesQuery)->count();
        $purchasesAmount = (float) (clone $purchasesQuery)->sum('total_amount');

        $ordersQuery = DB::table('customer_orders')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', '!=', 'cancelled');

        $customerOrdersCount = (clone $ordersQuery)->count();
        $customerOrdersAmount = (float) (clone $ordersQuery)->sum('total');

        $sales = (clone $salesQuery)
            ->orderByDesc('sale_date')->orderByDesc('id')
            ->paginate(10, ['*'], 'sales_page')
            ->withQueryString();

        $purchases = (clone $purchasesQuery)
            ->with('supplier')
            ->orderByDesc('purchase_date')->orderByDesc('id')
            ->paginate(10, ['*'], 'purchases_page')
            ->withQueryString();

        $customerOrders = (clone $ordersQuery)
            ->orderByDesc('created_at')->orderByDesc('id')
            ->paginate(10, ['*'], 'orders_page')
            ->withQueryString();

        $dailySales = [];
        $chartMax = 0;
        $start = \Illuminate\Support\Carbon::parse($startDate);
        $end = \Illuminate\Support\Carbon::parse($endDate);
        $days = min($start->diffInDays($end) + 1, 31);

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $amount = (float) Sale::whereDate('sale_date', $date->toDateString())
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
            $dailySales[] = [
                'label' => $date->format('d/m'),
                'amount' => $amount,
            ];
            $chartMax = max($chartMax, $amount);
        }

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalSales',
            'salesAmount',
            'totalPurchases',
            'purchasesAmount',
            'customerOrdersCount',
            'customerOrdersAmount',
            'sales',
            'purchases',
            'customerOrders',
            'dailySales',
            'chartMax',
            'days'
        ));
    }
}
