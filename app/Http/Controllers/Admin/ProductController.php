<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $search = $request->string('search')->trim()->toString();
        $categoryId = $request->input('category_id');

        $products = Product::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, fn ($query) =>
                $query->where('category_id', $categoryId)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products', 'categories', 'search', 'categoryId'
        ));
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product): View
    {
        $this->authorizeAdmin();

        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => [
                'required', 'string', 'max:255',
                Rule::unique('products', 'sku')->ignore($product->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeAdmin();

        $hasTransactions =
            $product->purchaseItems()->exists()
            || $product->saleItems()->exists()
            || $product->customerOrderItems()->exists();

        if ($hasTransactions) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah tercatat dalam transaksi.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
