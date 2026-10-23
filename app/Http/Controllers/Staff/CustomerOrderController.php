<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CustomerOrderController extends Controller
{
    private function ensureStaff(): void
    {
        abort_unless(auth()->user()?->role === 'staff', 403);
    }

    public function index()
    {
        $this->ensureStaff();
        $orders = DB::table('customer_orders')->orderByDesc('created_at')->paginate(10);
        return view('staff.customer-orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $this->ensureStaff();
        $order = DB::table('customer_orders')->where('id', $id)->first();
        abort_unless($order, 404);
        $items = DB::table('customer_order_items')->where('customer_order_id', $id)->get();
        return view('staff.customer-orders.show', compact('order', 'items'));
    }

    public function update(Request $request, int $id)
    {
        $this->ensureStaff();
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'delivered', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['unpaid', 'paid'])],
        ]);

        DB::transaction(function () use ($id, $data) {
            $order = DB::table('customer_orders')->where('id', $id)->lockForUpdate()->first();
            if (!$order) {
                throw ValidationException::withMessages(['status' => 'Pesanan tidak ditemukan.']);
            }

            $allowed = [
                'pending' => ['pending', 'processing', 'cancelled'],
                'processing' => ['processing', 'completed', 'delivered', 'cancelled'],
                'completed' => ['completed', 'delivered'],
                'delivered' => ['delivered'],
                'cancelled' => ['cancelled'],
            ];

            if (!in_array($data['status'], $allowed[$order->status] ?? [], true)) {
                throw ValidationException::withMessages(['status' => 'Perubahan status tidak diizinkan.']);
            }

            if (in_array($data['status'], ['completed', 'delivered'], true) && $data['payment_status'] !== 'paid') {
                throw ValidationException::withMessages(['payment_status' => 'Verifikasi pembayaran sebelum menyelesaikan pesanan.']);
            }

            if ($data['status'] === 'cancelled' && $order->status !== 'cancelled') {
                $items = DB::table('customer_order_items')->where('customer_order_id', $id)->get();
                foreach ($items as $item) {
                    $product = DB::table('products')->where('id', $item->product_id)->lockForUpdate()->first();
                    if ($product) {
                        DB::table('products')->where('id', $item->product_id)->increment('stock', (int) $item->quantity);
                    }
                }
            }

            DB::table('customer_orders')->where('id', $id)->update([
                'status' => $data['status'],
                'payment_status' => $data['payment_status'],
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('staff.customer-orders.show', $id)->with('success', 'Status pesanan dan pembayaran diperbarui.');
    }
}
