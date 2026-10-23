<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $search = trim((string) $request->input('search'));

                $query->where(function ($q) use ($search) {
                    $q->where(
                        'purchase_number',
                        'like',
                        "%{$search}%"
                    )->orWhereHas('supplier', function ($supplierQuery) use ($search) {
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

    public function show(Purchase $purchase)
    {
        $this->ensureAdmin();

        $purchase->load([
            'supplier',
            'items.product',
        ]);

        return view('admin.purchases.show', compact('purchase'));
    }

    /**
     * Batalkan pembelian tanpa menghapus riwayatnya.
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
                    'purchase' => 'Hanya pembelian selesai yang dapat dibatalkan.',
                ]);
            }

            $lockedPurchase->load('items');

            foreach ($lockedPurchase->items as $item) {
                $product = Product::whereKey($item->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ((int) $product->stock < (int) $item->quantity) {
                    throw ValidationException::withMessages([
                        'purchase' => "Pembelian tidak dapat dibatalkan karena stok {$product->name} tidak mencukupi untuk penyesuaian.",
                    ]);
                }

                $product->decrement(
                    'stock',
                    (int) $item->quantity
                );
            }

            $lockedPurchase->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('admin.purchases.index')
            ->with(
                'success',
                'Pembelian dibatalkan. Stok disesuaikan dan riwayat transaksi tetap disimpan.'
            );
    }
}
