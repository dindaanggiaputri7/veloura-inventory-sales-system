<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SupplierController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $search = $request->string('search')->trim()->toString();

        $suppliers = Supplier::query()
            ->withCount('purchases')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('contact_person', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.suppliers.index', compact('suppliers', 'search'));
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        return view('admin.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:3000'],
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier): View
    {
        $this->authorizeAdmin();

        $supplier->loadCount('purchases');

        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        $this->authorizeAdmin();

        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:3000'],
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $this->authorizeAdmin();

        $hasPurchases = DB::table('purchases')
            ->where('supplier_id', $supplier->id)
            ->exists();

        if ($hasPurchases) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Supplier tidak dapat dihapus karena sudah memiliki riwayat pembelian.');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
