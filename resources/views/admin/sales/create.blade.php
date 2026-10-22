
@extends('admin.layout')

@section('content')
<style>
    .sale-create {
        max-width: 1100px;
        margin: 0 auto;
        color: #39242a;
    }

    .sale-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .sale-heading h1 {
        margin: 0 0 7px;
        color: #39242a;
        font-size: 30px;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .sale-heading p {
        margin: 0;
        color: #88777d;
        font-size: 14px;
        line-height: 1.7;
    }

    .sale-btn {
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
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .sale-btn:hover {
        transform: translateY(-1px);
    }

    .sale-btn-primary {
        color: #fff;
        background: #5b2632;
        border-color: #5b2632;
    }

    .sale-btn-primary:hover {
        background: #763746;
    }

    .sale-btn-secondary {
        color: #5b2632;
        background: #fff;
        border-color: #e8d8d3;
    }

    .sale-btn-secondary:hover {
        background: #faf1ed;
    }

    .sale-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.7;
    }

    .sale-alert-danger {
        color: #a52d3c;
        background: #fff1f0;
        border-color: #f0d0ce;
    }

    .sale-alert-info {
        color: #73551c;
        background: #fff8e7;
        border-color: #f1e2b9;
    }

    .sale-form-card {
        padding: 28px;
        margin-bottom: 22px;
        background: #fff;
        border: 1px solid #eee1dc;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(65, 35, 43, .035);
    }

    .sale-section-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 22px;
    }

    .sale-section-number {
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

    .sale-section-heading h2 {
        margin: 0 0 4px;
        color: #4f2530;
        font-size: 18px;
        font-weight: 700;
    }

    .sale-section-heading p {
        margin: 0;
        color: #88777d;
        font-size: 13px;
        line-height: 1.6;
    }

    .sale-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .sale-field {
        min-width: 0;
    }

    .sale-field-full {
        grid-column: 1 / -1;
    }

    .sale-field label {
        display: block;
        margin-bottom: 8px;
        color: #49363c;
        font-size: 13px;
        font-weight: 650;
    }

    .sale-field input:not([type="checkbox"]),
    .sale-field select,
    .sale-field textarea {
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

    .sale-field textarea {
        min-height: 100px;
        resize: vertical;
    }

    .sale-field input:focus,
    .sale-field select:focus,
    .sale-field textarea:focus {
        outline: none;
        border-color: #7a3443;
        box-shadow: 0 0 0 3px rgba(122, 52, 67, .10);
    }

    .sale-field small {
        display: block;
        margin-top: 7px;
        color: #88777d;
        font-size: 12px;
        line-height: 1.6;
    }

    .sale-items-list {
        display: grid;
        gap: 16px;
    }

    .sale-item {
        padding: 20px;
        background: #fffcfa;
        border: 1px solid #eee1dc;
        border-radius: 13px;
    }

    .sale-item-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .sale-item-heading strong {
        color: #5b2632;
        font-size: 14px;
    }

    .sale-remove {
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

    .sale-item-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(110px, .7fr) minmax(150px, .9fr);
        gap: 16px;
    }

    .sale-line-total {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding-top: 15px;
        margin-top: 16px;
        border-top: 1px solid #eee1dc;
        color: #88777d;
        font-size: 13px;
    }

    .sale-line-total strong {
        color: #4f2530;
        font-size: 14px;
    }

    .sale-payment-summary {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(260px, .8fr);
        gap: 24px;
        align-items: start;
    }

    .sale-summary-box {
        padding: 22px;
        background: #faf4f0;
        border: 1px solid #eee1dc;
        border-radius: 13px;
    }

    .sale-summary-box h3 {
        margin: 0 0 18px;
        color: #4f2530;
        font-size: 16px;
        font-weight: 700;
    }

    .sale-summary-row {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
        color: #796a70;
        font-size: 13px;
    }

    .sale-summary-row strong {
        color: #4f2530;
        text-align: right;
    }

    .sale-summary-total {
        padding-top: 16px;
        margin-top: 4px;
        border-top: 1px solid #e5d5cf;
    }

    .sale-summary-total span {
        color: #5b2632;
        font-size: 14px;
        font-weight: 700;
    }

    .sale-summary-total strong {
        color: #5b2632;
        font-size: 22px;
        font-weight: 800;
    }

    .sale-payment-input {
        margin-top: 18px;
    }

    .sale-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    @media (max-width: 850px) {
        .sale-item-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .sale-item-grid .sale-field:first-child {
            grid-column: 1 / -1;
        }

        .sale-payment-summary {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .sale-heading h1 {
            font-size: 25px;
        }

        .sale-heading > a {
            width: 100%;
        }

        .sale-form-card {
            padding: 19px 16px;
            border-radius: 13px;
        }

        .sale-fields,
        .sale-item-grid {
            grid-template-columns: 1fr;
        }

        .sale-item-grid .sale-field:first-child {
            grid-column: auto;
        }

        .sale-item {
            padding: 15px;
        }

        .sale-form-actions {
            flex-direction: column-reverse;
        }

        .sale-form-actions .sale-btn {
            width: 100%;
        }
    }
</style>

<div class="sale-create">
    <div class="sale-heading">
        <div>
            <h1>Tambah Penjualan</h1>
            <p>Catat transaksi dan perbarui stok produk secara otomatis.</p>
        </div>

        <a href="{{ route('admin.sales.index') }}"
           class="sale-btn sale-btn-secondary">
            ← Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="sale-alert sale-alert-danger">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="sale-alert sale-alert-info">
            Belum ada produk yang tersedia. Tambahkan produk terlebih dahulu sebelum membuat penjualan.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.sales.store') }}" id="saleForm">
        @csrf

        <section class="sale-form-card">
            <div class="sale-section-heading">
                <div class="sale-section-number">01</div>
                <div>
                    <h2>Informasi Transaksi</h2>
                    <p>Masukkan tanggal, pelanggan, dan metode pembayaran.</p>
                </div>
            </div>

            <div class="sale-fields">
                <div class="sale-field">
                    <label for="sale_date">Tanggal Penjualan *</label>
                    <input type="date" name="sale_date" id="sale_date"
                           value="{{ old('sale_date', now()->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="sale-field">
                    <label for="customer_name">Nama Pelanggan</label>
                    <input type="text" name="customer_name" id="customer_name"
                           value="{{ old('customer_name') }}"
                           maxlength="255"
                           placeholder="Pelanggan umum (opsional)">
                </div>

                <div class="sale-field">
                    <label for="payment_method">Metode Pembayaran *</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="cash" @selected(old('payment_method', 'cash') === 'cash')>
                            Tunai
                        </option>
                        <option value="transfer" @selected(old('payment_method') === 'transfer')>
                            Transfer Bank
                        </option>
                        <option value="qris" @selected(old('payment_method') === 'qris')>
                            QRIS
                        </option>
                        <option value="debit" @selected(old('payment_method') === 'debit')>
                            Kartu Debit
                        </option>
                    </select>
                </div>

                <div class="sale-field sale-field-full">
                    <label for="notes">Catatan</label>
                    <textarea name="notes" id="notes"
                              placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                </div>
            </div>
        </section>

        <section class="sale-form-card">
            <div class="sale-section-heading">
                <div class="sale-section-number">02</div>
                <div style="flex:1">
                    <h2>Daftar Produk</h2>
                    <p>Pilih produk dan jumlah barang yang dijual.</p>
                </div>

                <button type="button" id="addItem" class="sale-btn sale-btn-secondary">
                    + Tambah Produk
                </button>
            </div>

            <div id="itemsContainer" class="sale-items-list"></div>
        </section>

        <section class="sale-form-card">
            <div class="sale-section-heading">
                <div class="sale-section-number">03</div>
                <div>
                    <h2>Ringkasan Pembayaran</h2>
                    <p>Periksa diskon, total penjualan, dan uang yang diterima.</p>
                </div>
            </div>

            <div class="sale-payment-summary">
                <div class="sale-fields">
                    <div class="sale-field sale-field-full">
                        <label for="discount">Diskon (Rp)</label>
                        <input type="number" name="discount" id="discount"
                               min="0" max="999999999999" step="0.01"
                               value="{{ old('discount', 0) }}" required>
                        <small>Masukkan nominal diskon, bukan persentase.</small>
                    </div>

                    <div class="sale-field sale-field-full">
                        <label for="payment_amount">Jumlah Pembayaran (Rp) *</label>
                        <input type="number" name="payment_amount" id="payment_amount"
                               min="0" max="999999999999" step="0.01"
                               value="{{ old('payment_amount', 0) }}" required>
                        <small>Jumlah pembayaran harus sama dengan atau lebih besar dari total penjualan.</small>
                    </div>
                </div>

                <div class="sale-summary-box">
                    <h3>Rincian Total</h3>

                    <div class="sale-summary-row">
                        <span>Subtotal</span>
                        <strong id="subtotalDisplay">Rp 0</strong>
                    </div>

                    <div class="sale-summary-row">
                        <span>Diskon</span>
                        <strong id="discountDisplay">Rp 0</strong>
                    </div>

                    <div class="sale-summary-row sale-summary-total">
                        <span>Total Bayar</span>
                        <strong id="grandTotal">Rp 0</strong>
                    </div>

                    <div class="sale-summary-row" style="margin-top:18px;margin-bottom:0">
                        <span>Kembalian</span>
                        <strong id="changeDisplay">Rp 0</strong>
                    </div>
                </div>
            </div>

            <div class="sale-form-actions">
                <a href="{{ route('admin.sales.index') }}"
                   class="sale-btn sale-btn-secondary">
                    Batal
                </a>

                <button type="submit" class="sale-btn sale-btn-primary"
                        @disabled($products->isEmpty())>
                    Simpan Penjualan
                </button>
            </div>
        </section>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('itemsContainer');
    const addButton = document.getElementById('addItem');
    const discountInput = document.getElementById('discount');
    const paymentInput = document.getElementById('payment_amount');
    const form = document.getElementById('saleForm');

    const products = {{ Illuminate\Support\Js::from(
        $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => (float) $product->selling_price,
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
        let subtotal = 0;

        container.querySelectorAll('.sale-item').forEach(function (row) {
            const quantity = Number(row.querySelector('.quantity').value) || 0;
            const price = Number(row.querySelector('.unit-price').value) || 0;
            const lineTotal = quantity * price;

            row.querySelector('.line-total').textContent = rupiah(lineTotal);
            subtotal += lineTotal;
        });

        const discount = Math.max(0, Number(discountInput.value) || 0);
        const total = Math.max(0, subtotal - discount);
        const payment = Math.max(0, Number(paymentInput.value) || 0);

        document.getElementById('subtotalDisplay').textContent = rupiah(subtotal);
        document.getElementById('discountDisplay').textContent = rupiah(discount);
        document.getElementById('grandTotal').textContent = rupiah(total);
        document.getElementById('changeDisplay').textContent =
            rupiah(Math.max(0, payment - total));
    }

    function addItem() {
        if (!products.length) return;

        const index = nextIndex++;
        const row = document.createElement('div');
        row.className = 'sale-item';

        const options = products.map(function (product) {
            return `<option value="${product.id}"
                data-price="${product.price}"
                data-stock="${product.stock}"
                ${product.stock < 1 ? 'disabled' : ''}>
                ${escapeHtml(product.name)} (${escapeHtml(product.sku)})
                — Stok: ${product.stock}
            </option>`;
        }).join('');

        row.innerHTML = `
            <div class="sale-item-heading">
                <strong>Produk yang dijual</strong>
                <button type="button" class="sale-remove">Hapus</button>
            </div>

            <div class="sale-item-grid">
                <div class="sale-field">
                    <label>Produk *</label>
                    <select name="items[${index}][product_id]"
                            class="product-select" required>
                        <option value="">-- Pilih Produk --</option>
                        ${options}
                    </select>
                </div>

                <div class="sale-field">
                    <label>Jumlah *</label>
                    <input type="number" name="items[${index}][quantity]"
                           class="quantity" min="1" step="1" value="1" required>
                    <small class="stock-hint">Pilih produk untuk melihat stok.</small>
                </div>

                <div class="sale-field">
                    <label>Harga Jual per Unit</label>
                    <input type="text" class="unit-price" value=""
                           placeholder="Otomatis" readonly>
                </div>
            </div>

            <div class="sale-line-total">
                <span>Subtotal Produk</span>
                <strong class="line-total">Rp 0</strong>
            </div>
        `;

        container.appendChild(row);

        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity');
        const priceInput = row.querySelector('.unit-price');
        const stockHint = row.querySelector('.stock-hint');

        select.addEventListener('change', function () {
            const product = products.find(p => String(p.id) === select.value);

            if (product) {
                priceInput.value = rupiah(product.price);
                quantityInput.max = product.stock;
                stockHint.textContent = 'Stok tersedia: ' + product.stock;

                if (product.stock > 0 &&
                    Number(quantityInput.value) > product.stock) {
                    quantityInput.value = product.stock;
                }
            } else {
                priceInput.value = '';
                quantityInput.removeAttribute('max');
                stockHint.textContent = 'Pilih produk untuk melihat stok.';
            }

            calculate();
        });

        quantityInput.addEventListener('input', calculate);

        row.querySelector('.sale-remove').addEventListener('click', function () {
            row.remove();
            calculate();
        });

        calculate();
    }

    addButton.addEventListener('click', addItem);
    discountInput.addEventListener('input', calculate);
    paymentInput.addEventListener('input', calculate);

    form.addEventListener('submit', function (event) {
        const rows = container.querySelectorAll('.sale-item');

        if (!rows.length) {
            event.preventDefault();
            alert('Tambahkan minimal satu produk.');
            return;
        }

        const selected = [];

        for (const row of rows) {
            const select = row.querySelector('.product-select');
            const quantity = Number(row.querySelector('.quantity').value);
            const product = products.find(p => String(p.id) === select.value);

            if (!product) {
                event.preventDefault();
                alert('Pilih produk untuk setiap baris.');
                return;
            }

            if (!Number.isInteger(quantity) ||
                quantity < 1 || quantity > product.stock) {
                event.preventDefault();
                alert('Jumlah harus minimal 1 dan tidak boleh melebihi stok ' + product.name + '.');
                return;
            }

            selected.push(String(product.id));
        }

        if (new Set(selected).size !== selected.length) {
            event.preventDefault();
            alert('Produk yang sama tidak boleh dimasukkan dua kali. Ubah jumlah pada baris produk tersebut.');
            return;
        }

        const subtotal = Array.from(rows).reduce(function (sum, row) {
            const quantity = Number(row.querySelector('.quantity').value) || 0;
            const select = row.querySelector('.product-select');
            const product = products.find(p => String(p.id) === select.value);
            return sum + quantity * (product ? product.price : 0);
        }, 0);

        const discount = Number(discountInput.value) || 0;
        const total = Math.max(0, subtotal - discount);
        const payment = Number(paymentInput.value) || 0;

        if (discount < 0 || discount > subtotal) {
            event.preventDefault();
            alert('Diskon tidak boleh melebihi subtotal.');
            return;
        }

        if (payment < total) {
            event.preventDefault();
            alert('Jumlah pembayaran harus minimal sebesar total penjualan.');
        }
    });

    addItem();
});
</script>
@endsection
