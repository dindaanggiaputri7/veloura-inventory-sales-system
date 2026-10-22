
<div class="field">
    <label for="category_id">Kategori *</label>
    <select id="category_id" name="category_id" required
            style="width:100%;padding:12px;border:1px solid #e4d8d2;border-radius:8px;background:#fffdfb">
        <option value="">Pilih kategori</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @selected((string)old('category_id', $product?->category_id) === (string)$category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="sku">SKU *</label>
    <input id="sku" name="sku" value="{{ old('sku', $product?->sku) }}" required maxlength="255">
    @error('sku') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="name">Nama Produk *</label>
    <input id="name" name="name" value="{{ old('name', $product?->name) }}" required maxlength="255">
    @error('name') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description" maxlength="3000">{{ old('description', $product?->description) }}</textarea>
    @error('description') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="detail-grid">
    <div class="field">
        <label for="purchase_price">Harga Beli (Rp) *</label>
        <input id="purchase_price" name="purchase_price" type="number" min="0" step="0.01"
               value="{{ old('purchase_price', $product?->purchase_price) }}" required>
        @error('purchase_price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="selling_price">Harga Jual (Rp) *</label>
        <input id="selling_price" name="selling_price" type="number" min="0" step="0.01"
               value="{{ old('selling_price', $product?->selling_price) }}" required>
        @error('selling_price') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="stock">Stok Saat Ini *</label>
        <input id="stock" name="stock" type="number" min="0" step="1"
               value="{{ old('stock', $product?->stock ?? 0) }}" required>
        @error('stock') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="field">
        <label for="minimum_stock">Stok Minimum *</label>
        <input id="minimum_stock" name="minimum_stock" type="number" min="0" step="1"
               value="{{ old('minimum_stock', $product?->minimum_stock ?? 5) }}" required>
        @error('minimum_stock') <div class="error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="actions">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-light">Batal</a>
</div>
