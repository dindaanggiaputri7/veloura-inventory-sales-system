<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    private function ensureStaff(): void
    {
        abort_unless(auth()->user()?->role === 'staff', 403);
    }

    public function index()
    {
        $this->ensureStaff();
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $purchases = Purchase::with('supplier')->withCount('items')
            ->orderByDesc('purchase_date')->orderByDesc('id')->paginate(10);

        return view('staff.purchases.index', compact('suppliers', 'products', 'purchases'));
    }

    public function store(Request $request)
    {
        $this->ensureStaff();
        $data = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchase_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0', 'max:9999999999'],
        ]);

        DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'purchase_number' => 'PB-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'purchase_date' => $data['purchase_date'],
                'total_amount' => 0,
                'status' => 'completed',
                'notes' => $data['notes'] ?? null,
            ]);

            $total = 0;
            foreach ($data['items'] as $line) {
                $product = Product::whereKey($line['product_id'])->lockForUpdate()->firstOrFail();
                $quantity = (int) $line['quantity'];
                $price = (float) $line['unit_price'];
                $subtotal = round($quantity * $price, 2);

                $product->increment('stock', $quantity);
                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            $purchase->update(['total_amount' => round($total, 2)]);
        });

        return redirect()->route('staff.purchases.index')->with('success', 'Pembelian tersimpan dan stok bertambah.');
    }
}
