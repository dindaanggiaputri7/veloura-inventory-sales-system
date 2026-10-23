<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        $startDate = $validated['start_date']
            ?? now()->startOfMonth()->toDateString();

        $endDate = $validated['end_date']
            ?? now()->toDateString();

        // Penjualan langsung yang selesai.
        $directSalesQuery = Sale::query()
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed');

        // Pembelian yang tidak dibatalkan.
        $purchasesQuery = Purchase::query()
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled');

        // Seluruh pesanan Customer yang tidak dibatalkan.
        // Pesanan belum dibayar tetap terlihat pada tabel pesanan.
        $ordersQuery = DB::table('customer_orders')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', '!=', 'cancelled');

        // Hanya pesanan yang sudah dibayar masuk total penjualan.
        $paidOrdersQuery = (clone $ordersQuery)
            ->where('payment_status', 'paid');

        $totalDirectSales = (clone $directSalesQuery)->count();

        $directSalesAmount = (float) (clone $directSalesQuery)
            ->sum('total_amount');

        $paidCustomerOrdersCount = (clone $paidOrdersQuery)->count();

        $customerOrdersAmount = (float) (clone $paidOrdersQuery)
            ->sum('total');

        // Gabungan penjualan langsung + Customer yang sudah dibayar.
        $totalSales = $totalDirectSales + $paidCustomerOrdersCount;

        $salesAmount = $directSalesAmount + $customerOrdersAmount;

        $totalPurchases = (clone $purchasesQuery)->count();

        $purchasesAmount = (float) (clone $purchasesQuery)
            ->sum('total_amount');

        // Daftar riwayat penjualan langsung.
        $sales = (clone $directSalesQuery)
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'sales_page')
            ->withQueryString();

        // Daftar pembelian yang dicatat Staff.
        $purchases = (clone $purchasesQuery)
            ->with('supplier')
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'purchases_page')
            ->withQueryString();

        // Riwayat pesanan Customer, termasuk yang belum dibayar.
        $customerOrdersCount = (clone $ordersQuery)->count();

        $customerOrders = (clone $ordersQuery)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'orders_page')
            ->withQueryString();

        // Grafik gabungan, maksimum 31 hari.
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        $days = min($start->diffInDays($end) + 1, 31);

        $dailySales = [];
        $chartMax = 0;

        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $dateString = $date->toDateString();

            $directAmount = (float) Sale::query()
                ->whereDate('sale_date', $dateString)
                ->where('status', 'completed')
                ->sum('total_amount');

            $onlineAmount = (float) DB::table('customer_orders')
                ->whereDate('created_at', $dateString)
                ->where('payment_status', 'paid')
                ->where('status', '!=', 'cancelled')
                ->sum('total');

            $amount = $directAmount + $onlineAmount;

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
            'totalDirectSales',
            'directSalesAmount',
            'totalPurchases',
            'purchasesAmount',
            'paidCustomerOrdersCount',
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
