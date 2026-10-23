<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    private function ensureStaff(): void
    {
        abort_unless(auth()->user()?->role === 'staff', 403);
    }

    public function index()
    {
        $this->ensureStaff();
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $sales = Sale::withCount('items')->orderByDesc('sale_date')->orderByDesc('id')->paginate(10);
        return view('staff.sales.index', compact('products', 'sales'));
    }

    public function store(Request $request)
    {
        $this->ensureStaff();

        $data = $request->validate([
            'sale_date' => ['required', 'date'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:999999999999'],
            'payment_amount' => ['required', 'numeric', 'min:0', 'max:999999999999'],
            'payment_method' => ['required', 'in:cash,transfer,qris,debit'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:4294967295'],
        ]);

        DB::transaction(function () use ($data) {
            $lines = [];
            $subtotalTotal = 0;

            foreach ($data['items'] as $line) {
                $product = Product::whereKey($line['product_id'])->lockForUpdate()->firstOrFail();
                $quantity = (int) $line['quantity'];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$product->name} tidak cukup. Tersedia {$product->stock}.",
                    ]);
                }

                $price = (float) $product->selling_price;
                $subtotal = round($price * $quantity, 2);
                $lines[] = ['product' => $product, 'quantity' => $quantity, 'price' => $price, 'subtotal' => $subtotal];
                $subtotalTotal += $subtotal;
            }

            $discount = round((float) ($data['discount'] ?? 0), 2);
            if ($discount > $subtotalTotal) {
                throw ValidationException::withMessages(['discount' => 'Diskon tidak boleh melebihi subtotal.']);
            }

            $total = round($subtotalTotal - $discount, 2);
            $payment = round((float) $data['payment_amount'], 2);
            if ($payment < $total) {
                throw ValidationException::withMessages(['payment_amount' => 'Pembayaran kurang dari total penjualan.']);
            }

            $sale = Sale::create([
                'sale_number' => 'PJ-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'sale_date' => $data['sale_date'],
                'customer_name' => $data['customer_name'] ?? null,
                'total_amount' => $total,
                'discount' => $discount,
                'payment_amount' => $payment,
                'payment_method' => $data['payment_method'],
                'status' => 'completed',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($lines as $line) {
                $line['product']->decrement('stock', $line['quantity']);
                $sale->items()->create([
                    'product_id' => $line['product']->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['price'],
                    'subtotal' => $line['subtotal'],
                ]);
            }
        });

        return redirect()->route('staff.sales.index')->with('success', 'Penjualan tersimpan dan stok diperbarui.');
    }
}
