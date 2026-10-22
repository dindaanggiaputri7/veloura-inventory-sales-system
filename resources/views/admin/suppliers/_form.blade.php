
<div class="field">
    <label for="name">Nama Supplier *</label>
    <input id="name" name="name" value="{{ old('name', $supplier?->name) }}" required maxlength="255">
    @error('name') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="contact_person">Nama Kontak</label>
    <input id="contact_person" name="contact_person"
           value="{{ old('contact_person', $supplier?->contact_person) }}" maxlength="255">
    @error('contact_person') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="phone">Nomor Telepon</label>
    <input id="phone" name="phone" value="{{ old('phone', $supplier?->phone) }}" maxlength="20">
    @error('phone') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="address">Alamat</label>
    <textarea id="address" name="address" maxlength="3000">{{ old('address', $supplier?->address) }}</textarea>
    @error('address') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="actions">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light">Batal</a>
</div>
