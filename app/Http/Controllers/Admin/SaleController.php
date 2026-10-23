<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        // Penjualan langsung.
        $directSales = DB::table('sales')
            ->selectRaw("
                'langsung' AS source_type,
                id AS source_id,
                sale_number AS transaction_number,
                sale_date AS transaction_date,
                COALESCE(customer_name, 'Pelanggan umum') AS customer_name,
                total_amount AS amount,
                payment_method,
                status,
                NULL AS payment_status
            ");

        // Pesanan Customer.
        $onlineOrders = DB::table('customer_orders')
            ->selectRaw("
                'online' AS source_type,
                id AS source_id,
                order_number AS transaction_number,
                DATE(created_at) AS transaction_date,
                customer_name,
                total AS amount,
                payment_method,
                status,
                payment_status
            ");

        // Gabungkan untuk dibaca sebagai satu daftar.
        // Data asli tetap berada di tabel masing-masing.
        $union = $directSales->unionAll($onlineOrders);

        $transactionsQuery = DB::query()
            ->fromSub($union, 'transactions');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $transactionsQuery->where(function ($query) use ($search) {
                $query->where(
                    'transaction_number',
                    'like',
                    "%{$search}%"
                )->orWhere(
                    'customer_name',
                    'like',
                    "%{$search}%"
                );
            });
        }

        if ($request->filled('date')) {
            $transactionsQuery->whereDate(
                'transaction_date',
                $request->input('date')
            );
        }

        $transactions = $transactionsQuery
            ->orderByDesc('transaction_date')
            ->orderByDesc('source_id')
            ->paginate(10)
            ->withQueryString();

        // Hitung jumlah item per transaksi pada halaman yang sedang dibuka.
        $rows = collect($transactions->items());

        $directIds = $rows
            ->where('source_type', 'langsung')
            ->pluck('source_id')
            ->values()
            ->all();

        $onlineIds = $rows
            ->where('source_type', 'online')
            ->pluck('source_id')
            ->values()
            ->all();

        $directCounts = collect();

        if (!empty($directIds)) {
            $directCounts = DB::table('sale_items')
                ->select(
                    'sale_id',
                    DB::raw('SUM(quantity) AS total_items')
                )
                ->whereIn('sale_id', $directIds)
                ->groupBy('sale_id')
                ->pluck('total_items', 'sale_id');
        }

        $onlineCounts = collect();

        if (!empty($onlineIds)) {
            $onlineCounts = DB::table('customer_order_items')
                ->select(
                    'customer_order_id',
                    DB::raw('SUM(quantity) AS total_items')
                )
                ->whereIn('customer_order_id', $onlineIds)
                ->groupBy('customer_order_id')
                ->pluck('total_items', 'customer_order_id');
        }

        foreach ($rows as $row) {
            $row->items_count = $row->source_type === 'langsung'
                ? (int) $directCounts->get($row->source_id, 0)
                : (int) $onlineCounts->get($row->source_id, 0);
        }

        return view('admin.sales.index', compact('transactions'));
    }

    public function show(Sale $sale)
    {
        $this->ensureAdmin();

        $sale->load('items.product');

        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Batalkan penjualan langsung tanpa menghapus riwayatnya.
     */
    public function destroy(Sale $sale)
    {
        $this->ensureAdmin();

        DB::transaction(function () use ($sale) {
            $lockedSale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedSale->status === 'cancelled') {
                throw ValidationException::withMessages([
                    'sale' => 'Transaksi ini sudah dibatalkan sebelumnya.',
                ]);
            }

            if ($lockedSale->status !== 'completed') {
                throw ValidationException::withMessages([
                    'sale' => 'Hanya penjualan yang selesai yang dapat dibatalkan.',
                ]);
            }

            $lockedSale->load('items');

            foreach ($lockedSale->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $product->increment(
                    'stock',
                    (int) $item->quantity
                );
            }

            $lockedSale->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('admin.sales.index')
            ->with(
                'success',
                'Penjualan dibatalkan. Stok dikembalikan dan riwayat transaksi tetap disimpan.'
            );
    }
}
