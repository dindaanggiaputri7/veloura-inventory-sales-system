
@extends('admin.layout')

@section('content')
<style>
    .purchase-create {
        max-width: 1100px;
        margin: 0 auto;
        color: #39242a;
    }

    .purchase-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .purchase-heading h1 {
        margin: 0 0 7px;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .purchase-heading p {
        margin: 0;
        color: #88777d;
        font-size: 14px;
        line-height: 1.7;
    }

    .purchase-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 0 17px;
        border: 1px solid transparent;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .purchase-btn:hover {
        transform: translateY(-1px);
    }

    .purchase-btn-primary {
        color: #fff;
        background: #5b2632;
        border-color: #5b2632;
    }

    .purchase-btn-primary:hover {
        background: #763746;
    }

    .purchase-btn-secondary {
        color: #5b2632;
        background: #fff;
        border-color: #e8d8d3;
    }

    .purchase-btn-secondary:hover {
        background: #faf1ed;
    }

    .purchase-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.7;
    }

    .purchase-alert-danger {
        color: #a52d3c;
        background: #fff1f0;
        border-color: #f0d0ce;
    }

    .purchase-alert-info {
        color: #73551c;
        background: #fff8e7;
        border-color: #f1e2b9;
    }

    .purchase-form-card {
        padding: 28px;
        margin-bottom: 22px;
        background: #fff;
        border: 1px solid #eee1dc;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(65, 35, 43, .035);
    }

    .purchase-section-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 24px;
    }

    .purchase-section-number {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        color: #713543;
        background: #f8efec;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 750;
    }

    .purchase-section-heading h2 {
        margin: 0 0 4px;
        color: #4f2530;
        font-size: 18px;
        font-weight: 700;
    }

    .purchase-section-heading p {
        margin: 0;
        color: #88777d;
        font-size: 13px;
        line-height: 1.6;
    }

    .purchase-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .purchase-field {
        min-width: 0;
    }

    .purchase-field-full {
        grid-column: 1 / -1;
    }

    .purchase-field label {
        display: block;
        margin-bottom: 8px;
        color: #49363c;
        font-size: 13px;
        font-weight: 650;
    }

    .purchase-field input,
    .purchase-field select,
    .purchase-field textarea {
        box-sizing: border-box;
        display: block;
        width: 100%;
        min-height: 46px;
        padding: 11px 13px;
        color: #39242a;
        background: #fffdfb;
        border: 1px solid #e6d8d3;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .purchase-field textarea {
        min-height: 100px;
        resize: vertical;
    }

    .purchase-field input:focus,
    .purchase-field select:focus,
    .purchase-field textarea:focus {
        outline: none;
        border-color: #7a3443;
        box-shadow: 0 0 0 3px rgba(122, 52, 67, .10);
    }

    .purchase-field small {
        display: block;
        margin-top: 7px;
        color: #88777d;
        font-size: 12px;
        line-height: 1.6;
    }

    .purchase-items-list {
        display: grid;
        gap: 16px;
    }

    .purchase-item {
        padding: 20px;
        background: #fffcfa;
        border: 1px solid #eee1dc;
        border-radius: 13px;
    }

    .purchase-item-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .purchase-item-heading strong {
        color: #5b2632;
        font-size: 14px;
    }

    .purchase-remove {
        min-height: 34px;
        padding: 0 11px;
        color: #a52d3c;
        background: #fff1f0;
        border: 1px solid #f0d0ce;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 650;
        cursor: pointer;
    }

    .purchase-item-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(110px, .7fr) minmax(150px, .9fr);
        gap: 16px;
    }

    .purchase-line-total {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding-top: 15px;
        margin-top: 16px;
        border-top: 1px solid #eee1dc;
        color: #88777d;
        font-size: 13px;
    }

    .purchase-line-total strong {
        color: #4f2530;
        font-size: 14px;
    }

    .purchase-summary {
        max-width: 460px;
        margin-left: auto;
        padding: 23px;
        background: #faf4f0;
        border: 1px solid #eee1dc;
        border-radius: 13px;
    }

    .purchase-summary h3 {
        margin: 0 0 18px;
        color: #4f2530;
        font-size: 16px;
        font-weight: 700;
    }

    .purchase-summary-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        color: #796a70;
        font-size: 13px;
    }

    .purchase-summary-total {
        padding-top: 16px;
        margin-top: 14px;
        border-top: 1px solid #e5d5cf;
    }

    .purchase-summary-total span {
        color: #5b2632;
        font-size: 14px;
        font-weight: 700;
    }

    .purchase-summary-total strong {
        color: #5b2632;
        font-size: 22px;
        font-weight: 800;
    }

    .purchase-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    @media (max-width: 850px) {
        .purchase-item-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .purchase-item-grid .purchase-field:first-child {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 600px) {
        .purchase-heading h1 {
            font-size: 25px;
        }

        .purchase-heading > a {
            width: 100%;
        }

        .purchase-form-card {
            padding: 19px 16px;
            border-radius: 13px;
        }

        .purchase-fields,
        .purchase-item-grid {
            grid-template-columns: 1fr;
        }

        .purchase-item-grid .purchase-field:first-child {
            grid-column: auto;
        }

        .purchase-item {
            padding: 15px;
        }

        .purchase-form-actions {
            flex-direction: column-reverse;
        }

        .purchase-form-actions .purchase-btn {
            width: 100%;
        }

        .purchase-summary {
            max-width: none;
        }
    }
</style>

<div class="purchase-create">
    <div class="purchase-heading">
        <div>
            <h1>Tambah Pembelian</h1>
            <p>Catat barang masuk dari supplier dan perbarui stok produk.</p>
        </div>

        <a href="{{ route('admin.purchases.index') }}"
           class="purchase-btn purchase-btn-secondary">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="purchase-alert purchase-alert-danger">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($suppliers->isEmpty())
        <div class="purchase-alert purchase-alert-info">
            Belum ada supplier. Daftarkan supplier terlebih dahulu sebelum mencatat pembelian.
            <a href="{{ route('admin.suppliers.create') }}">Tambah supplier</a>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="purchase-alert purchase-alert-info">
            Belum ada produk. Tambahkan produk terlebih dahulu sebelum mencatat pembelian.
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.purchases.store') }}"
          id="purchaseForm">
        @csrf

        <section class="purchase-form-card">
            <div class="purchase-section-heading">
                <div class="purchase-section-number">01</div>
                <div>
                    <h2>Informasi Pembelian</h2>
                    <p>Lengkapi supplier, tanggal, dan catatan pembelian.</p>
                </div>
            </div>

            <div class="purchase-fields">
                <div class="purchase-field">
                    <label for="supplier_id">Supplier *</label>
                    <select name="supplier_id" id="supplier_id" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                @selected((string) old('supplier_id') === (string) $supplier->id)>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>

                    @if($suppliers->isEmpty())
                        <small>
                            <a href="{{ route('admin.suppliers.create') }}">
                                Tambahkan data supplier terlebih dahulu.
                            </a>
                        </small>
                    @endif
                </div>

                <div class="purchase-field">
                    <label for="purchase_date">Tanggal Pembelian *</label>
                    <input type="date" name="purchase_date" id="purchase_date"
                           value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="purchase-field purchase-field-full">
                    <label for="notes">Catatan</label>
                    <textarea name="notes" id="notes"
                              placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                </div>
            </div>
        </section>

        <section class="purchase-form-card">
            <div class="purchase-section-heading">
                <div class="purchase-section-number">02</div>
                <div style="flex:1">
                    <h2>Daftar Produk</h2>
                    <p>Pilih produk dan jumlah barang yang masuk ke inventaris.</p>
                </div>

                <button type="button" id="addItem"
                        class="purchase-btn purchase-btn-secondary"
                        @disabled($products->isEmpty())>
                    + Tambah Produk
                </button>
            </div>

            <div id="itemsContainer" class="purchase-items-list"></div>
        </section>

        <section class="purchase-form-card">
            <div class="purchase-section-heading">
                <div class="purchase-section-number">03</div>
                <div>
                    <h2>Ringkasan Pembelian</h2>
                    <p>Periksa total biaya barang sebelum menyimpan transaksi.</p>
                </div>
            </div>

            <div class="purchase-summary">
                <h3>Rincian Total</h3>

                <div class="purchase-summary-row">
                    <span>Jumlah jenis produk</span>
                    <strong id="itemCount">0 produk</strong>
                </div>

                <div class="purchase-summary-row" style="margin-top:14px">
                    <span>Total unit barang</span>
                    <strong id="unitCount">0 unit</strong>
                </div>

                <div class="purchase-summary-row purchase-summary-total">
                    <span>Total Pembelian</span>
                    <strong id="grandTotal">Rp 0</strong>
                </div>
            </div>

            <div class="purchase-form-actions">
                <a href="{{ route('admin.purchases.index') }}"
                   class="purchase-btn purchase-btn-secondary">
                    Batal
                </a>

                <button type="submit"
                        class="purchase-btn purchase-btn-primary"
                        @disabled($suppliers->isEmpty() || $products->isEmpty())>
                    Simpan Pembelian
                </button>
            </div>
        </section>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('itemsContainer');
    const addButton = document.getElementById('addItem');
    const form = document.getElementById('purchaseForm');

    const products = {{ Illuminate\Support\Js::from(
        $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => (float) $product->purchase_price,
                'stock' => (int) $product->stock,
            ];
        })->values()
    ) }};

    let nextIndex = 0;

    function rupiah(value) {
        return 'Rp ' + Math.round(value).toLocaleString('id-ID');
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function calculate() {
        let total = 0;
        let units = 0;
        let count = 0;

        container.querySelectorAll('.purchase-item').forEach(function (row) {
            const select = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity');
            const priceInput = row.querySelector('.unit-price');

            const product = products.find(
                p => String(p.id) === select.value
            );

            const quantity = Number(quantityInput.value) || 0;
            const price = product ? product.price : 0;
            const subtotal = quantity * price;

            row.querySelector('.line-total').textContent = rupiah(subtotal);

            if (product) {
                count++;
                units += quantity;
                total += subtotal;
            }
        });

        document.getElementById('itemCount').textContent = count + ' produk';
        document.getElementById('unitCount').textContent = units + ' unit';
        document.getElementById('grandTotal').textContent = rupiah(total);
    }

    function addItem() {
        if (!products.length) return;

        const index = nextIndex++;
        const row = document.createElement('div');
        row.className = 'purchase-item';

        const options = products.map(function (product) {
            return `<option value="${product.id}"
                data-price="${product.price}">
                ${escapeHtml(product.name)} (${escapeHtml(product.sku)})
                — Stok saat ini: ${product.stock}
            </option>`;
        }).join('');

        row.innerHTML = `
            <div class="purchase-item-heading">
                <strong>Produk yang dibeli</strong>
                <button type="button" class="purchase-remove">Hapus</button>
            </div>

            <div class="purchase-item-grid">
                <div class="purchase-field">
                    <label>Produk *</label>
                    <select name="items[${index}][product_id]"
                            class="product-select" required>
                        <option value="">-- Pilih Produk --</option>
                        ${options}
                    </select>
                </div>

                <div class="purchase-field">
                    <label>Jumlah *</label>
                    <input type="number" name="items[${index}][quantity]"
                           class="quantity" min="1" step="1"
                           value="1" required>
                </div>

                <div class="purchase-field">
                    <label>Harga Beli per Unit (Rp) *</label>
                    <input type="number" name="items[${index}][unit_price]"
                           class="unit-price" min="0" max="999999999999"
                           step="0.01" required placeholder="Masukkan harga beli">
                </div>
            </div>

            <div class="purchase-line-total">
                <span>Subtotal Produk</span>
                <strong class="line-total">Rp 0</strong>
            </div>
        `;

        container.appendChild(row);

        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity');
        const priceInput = row.querySelector('.unit-price');

        select.addEventListener('change', function () {
            const product = products.find(p => String(p.id) === select.value);

            if (product) {
                priceInput.value = product.price;
            } else {
                priceInput.value = '';
            }

            calculate();
        });

        quantityInput.addEventListener('input', calculate);
        priceInput.addEventListener('input', calculate);

        row.querySelector('.purchase-remove').addEventListener('click', function () {
            row.remove();
            calculate();
        });

        calculate();
    }

    addButton.addEventListener('click', addItem);

    form.addEventListener('submit', function (event) {
        const rows = container.querySelectorAll('.purchase-item');

        if (!document.getElementById('supplier_id').value) {
            event.preventDefault();
            alert('Pilih supplier terlebih dahulu.');
            return;
        }

        if (!rows.length) {
            event.preventDefault();
            alert('Tambahkan minimal satu produk.');
            return;
        }

        const selected = [];

        for (const row of rows) {
            const select = row.querySelector('.product-select');
            const quantity = Number(row.querySelector('.quantity').value);
            const price = Number(row.querySelector('.unit-price').value);
            const product = products.find(p => String(p.id) === select.value);

            if (!product) {
                event.preventDefault();
                alert('Pilih produk untuk setiap baris.');
                return;
            }

            if (!Number.isInteger(quantity) || quantity < 1) {
                event.preventDefault();
                alert('Jumlah produk harus berupa bilangan bulat minimal 1.');
                return;
            }

            if (!Number.isFinite(price) || price < 0) {
                event.preventDefault();
                alert('Harga beli harus berupa angka nol atau lebih.');
                return;
            }

            selected.push(String(product.id));
        }

        if (new Set(selected).size !== selected.length) {
            event.preventDefault();
            alert('Produk yang sama tidak boleh dimasukkan dua kali. Ubah jumlah pada baris produk tersebut.');
        }
    });

    addItem();
});
</script>
@endsection
