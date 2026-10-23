<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        $sales = Sale::withCount('items')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('sale_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('sale_date', $request->date);
            })
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $products = Product::orderBy('name')->get();

        return view('admin.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'sale_date' => ['required', 'date'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:999999999999'],
            'payment_amount' => ['required', 'numeric', 'min:0', 'max:999999999999'],
            'payment_method' => ['required', 'in:cash,transfer,qris,debit'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:4294967295',
            ],
        ]);

        $sale = DB::transaction(function () use ($validated) {
            $preparedItems = [];
            $subtotalTotal = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Stok produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}.",
                    ]);
                }

                $unitPrice = (float) $product->selling_price;
                $subtotal = round($quantity * $unitPrice, 2);

                $preparedItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];

                $subtotalTotal += $subtotal;
            }

            $subtotalTotal = round($subtotalTotal, 2);
            $discount = round((float) ($validated['discount'] ?? 0), 2);

            if ($discount > $subtotalTotal) {
                throw ValidationException::withMessages([
                    'discount' => 'Diskon tidak boleh melebihi subtotal penjualan.',
                ]);
            }

            $total = round($subtotalTotal - $discount, 2);
            $paymentAmount = round((float) $validated['payment_amount'], 2);

            if ($paymentAmount < $total) {
                throw ValidationException::withMessages([
                    'payment_amount' => 'Jumlah pembayaran tidak boleh kurang dari total penjualan.',
                ]);
            }

            $sale = Sale::create([
                'sale_number' => 'PJ-'
                    . now()->format('YmdHis')
                    . '-'
                    . Str::upper(Str::random(4)),
                'sale_date' => $validated['sale_date'],
                'customer_name' => $validated['customer_name'] ?? null,
                'total_amount' => $total,
                'discount' => $discount,
                'payment_amount' => $paymentAmount,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($preparedItems as $item) {
                $item['product']->decrement(
                    'stock',
                    $item['quantity']
                );

                $sale->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $sale;
        });

        return redirect()
            ->route('admin.sales.show', $sale)
            ->with(
                'success',
                'Penjualan berhasil disimpan dan stok produk telah diperbarui.'
            );
    }

    public function show(Sale $sale)
    {
        $this->ensureAdmin();

        $sale->load('items.product');

        return view('admin.sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $this->ensureAdmin();

        return redirect()
            ->route('admin.sales.show', $sale)
            ->with(
                'info',
                'Transaksi yang sudah selesai tidak dapat diedit.'
            );
    }

    public function update(Request $request, Sale $sale)
    {
        $this->ensureAdmin();

        return redirect()
            ->route('admin.sales.show', $sale)
            ->with(
                'info',
                'Transaksi yang sudah selesai tidak dapat diedit.'
            );
    }

    /**
     * Batalkan penjualan tanpa menghapus catatan transaksi.
     * Stok dikembalikan hanya satu kali.
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

            // Simpan transaksi sebagai riwayat, jangan hapus permanen.
            $lockedSale->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('admin.sales.index')
            ->with(
                'success',
                'Penjualan dibatalkan. Stok dikembalikan dan catatan transaksi tetap disimpan.'
            );
    }
}