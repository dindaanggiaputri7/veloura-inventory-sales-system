<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $purchases = Purchase::with('supplier')
            ->withCount('items')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('purchase_number', 'like', "%{$search}%")
                        ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                            $supplierQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->orderByDesc('purchase_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view(
            'admin.purchases.create',
            compact('suppliers', 'products')
        );
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'supplier_id' => [
                'required',
                'exists:suppliers,id',
            ],
            'purchase_date' => [
                'required',
                'date',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
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
            ],
            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999',
            ],
        ]);

        $purchase = DB::transaction(function () use ($validated) {
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'purchase_number' => 'PB-'
                    . now()->format('YmdHis')
                    . '-'
                    . Str::upper(Str::random(4)),
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => 0,
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $subtotal = round($quantity * $unitPrice, 2);

                if ($subtotal > 999999999999.99) {
                    throw ValidationException::withMessages([
                        'items' => 'Subtotal salah satu produk terlalu besar.',
                    ]);
                }

                // Stok bertambah saat pembelian berhasil.
                $product->increment('stock', $quantity);

                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            if ($total > 999999999999.99) {
                throw ValidationException::withMessages([
                    'items' => 'Total pembelian terlalu besar.',
                ]);
            }

            $purchase->update([
                'total_amount' => $total,
            ]);

            return $purchase;
        });

        return redirect()
            ->route('admin.purchases.show', $purchase)
            ->with(
                'success',
                'Pembelian berhasil disimpan dan stok produk telah diperbarui.'
            );
    }

    public function show(Purchase $purchase)
    {
        $this->ensureAdmin();

        $purchase->load([
            'supplier',
            'items.product',
        ]);

        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $this->ensureAdmin();

        return redirect()
            ->route('admin.purchases.show', $purchase)
            ->with(
                'info',
                'Data pembelian yang sudah selesai tidak dapat diedit.'
            );
    }

    public function update(
        Request $request,
        Purchase $purchase
    ) {
        $this->ensureAdmin();

        return redirect()
            ->route('admin.purchases.show', $purchase)
            ->with(
                'info',
                'Data pembelian yang sudah selesai tidak dapat diedit.'
            );
    }

    /**
     * Batalkan pembelian tanpa menghapus catatan transaksi.
     * Stok dikurangi kembali satu kali jika masih mencukupi.
     */
    public function destroy(Purchase $purchase)
    {
        $this->ensureAdmin();

        DB::transaction(function () use ($purchase) {
            $lockedPurchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPurchase->status === 'cancelled') {
                throw ValidationException::withMessages([
                    'purchase' => 'Pembelian ini sudah dibatalkan sebelumnya.',
                ]);
            }

            if ($lockedPurchase->status !== 'completed') {
                throw ValidationException::withMessages([
                    'purchase' => 'Hanya pembelian berstatus selesai yang dapat dibatalkan.',
                ]);
            }

            $lockedPurchase->load('items');

            foreach ($lockedPurchase->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ((int) $product->stock < (int) $item->quantity) {
                    throw ValidationException::withMessages([
                        'purchase' => "Pembelian tidak dapat dibatalkan karena stok {$product->name} sudah lebih sedikit daripada jumlah yang masuk pada transaksi ini.",
                    ]);
                }

                // Kembalikan stok ke kondisi sebelum pembelian.
                $product->decrement(
                    'stock',
                    (int) $item->quantity
                );
            }

            // Transaksi tetap tersimpan sebagai jejak audit.
            $lockedPurchase->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('admin.purchases.index')
            ->with(
                'success',
                'Pembelian dibatalkan. Stok disesuaikan dan catatan transaksi tetap disimpan.'
            );
    }
}