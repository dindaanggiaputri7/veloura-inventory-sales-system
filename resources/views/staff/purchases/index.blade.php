
@extends('staff.layout')

@section('title', 'Pembelian')
@section('page-heading', 'Pembelian')
@section(
    'page-description',
    'Catat pembelian dari supplier dan kelola penambahan stok produk.'
)

@section('content')
<style>
    .purchase-page {
        color: #3c292e;
    }

    .purchase-card {
        background: #fff;
        border: 1px solid #eadbd6;
        border-radius: 15px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 5px 18px rgba(65, 35, 43, .035);
    }

    .purchase-card h2 {
        margin: 0 0 7px;
        color: #57222f;
        font-size: 19px;
    }

    .purchase-help {
        color: #99878b;
        line-height: 1.6;
        margin: 0 0 22px;
    }

    .purchase-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .purchase-field {
        min-width: 0;
    }

    .purchase-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .purchase-field input,
    .purchase-field select,
    .purchase-field textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 12px;
        border: 1px solid #eadbd6;
        border-radius: 9px;
        background: #fffdfb;
        color: #3c292e;
        font: inherit;
    }

    .purchase-field input:focus,
    .purchase-field select:focus,
    .purchase-field textarea:focus {
        outline: 2px solid #f0dce0;
        border-color: #7a414b;
    }

    .purchase-field input[readonly] {
        background: #f8f3ee;
        font-weight: 700;
        color: #57222f;
    }

    .purchase-items {
        display: grid;
        gap: 15px;
        margin: 20px 0;
    }

    .purchase-row {
        border: 1px solid #eadbd6;
        border-radius: 12px;
        padding: 17px;
        background: #fffcfa;
    }

    .purchase-row-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 15px;
        color: #57222f;
        font-weight: 700;
    }

    .purchase-row-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1.3fr;
        gap: 13px;
    }

    .purchase-subtotal {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border-top: 1px solid #eadbd6;
        padding-top: 13px;
        margin-top: 15px;
        font-size: 13px;
        color: #99878b;
    }

    .purchase-subtotal strong {
        color: #57222f;
        font-size: 15px;
    }

    .purchase-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 9px;
        border: 1px solid transparent;
        padding: 11px 16px;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
    }

    .purchase-primary {
        background: #57222f;
        color: #fff;
    }

    .purchase-primary:hover {
        background: #7a414b;
    }

    .purchase-secondary {
        color: #57222f;
        background: #fff;
        border-color: #eadbd6;
    }

    .purchase-danger {
        padding: 7px 10px;
        background: #fff0f0;
        color: #a52d3c;
        border-color: #f0d0ce;
        font-size: 12px;
    }

    .purchase-danger:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    .purchase-summary {
        max-width: 430px;
        margin-left: auto;
        padding: 20px;
        background: #f8f3ee;
        border: 1px solid #eadbd6;
        border-radius: 12px;
    }

    .purchase-summary-label {
        color: #99878b;
        font-size: 13px;
    }

    .purchase-summary-total {
        display: block;
        margin-top: 8px;
        color: #57222f;
        font-size: 27px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .purchase-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .purchase-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border-radius: 10px;
        line-height: 1.6;
    }

    .purchase-success {
        background: #edf8ef;
        color: #256537;
    }

    .purchase-error {
        background: #fff0f0;
        color: #a12626;
    }

    .purchase-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .purchase-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
    }

    .purchase-table th,
    .purchase-table td {
        padding: 13px 12px;
        text-align: left;
        border-bottom: 1px solid #f0e6e2;
        font-size: 13px;
    }

    .purchase-table th {
        color: #57222f;
        background: #fcf8f5;
    }

    .purchase-table td {
        color: #5b464c;
    }

    .purchase-empty {
        text-align: center !important;
        padding: 25px !important;
        color: #99878b !important;
    }

    .purchase-pagination {
        margin-top: 18px;
    }

    @media (max-width: 760px) {
        .purchase-card {
            padding: 18px 15px;
        }

        .purchase-grid,
        .purchase-row-grid {
            grid-template-columns: 1fr;
        }

        .purchase-actions {
            flex-direction: column;
        }

        .purchase-actions .purchase-button {
            width: 100%;
        }

        .purchase-summary {
            max-width: none;
        }
    }
</style>

<div class="purchase-page">

    @if(session('success'))
        <div class="purchase-alert purchase-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="purchase-alert purchase-error">
            <strong>Periksa kembali data pembelian:</strong>
            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="purchase-card">
        <h2>Input Pembelian</h2>
        <p class="purchase-help">
            Pilih supplier, produk, dan jumlah barang.
            Harga beli serta total pembelian dihitung otomatis.
        </p>

        <form
            method="POST"
            action="{{ route('staff.purchases.store') }}"
            id="purchase-form"
        >
            @csrf

            <div class="purchase-grid">
                <div class="purchase-field">
                    <label for="supplier_id">Supplier *</label>
                    <select id="supplier_id" name="supplier_id" required>
                        <option value="">Pilih supplier</option>

                        @foreach($suppliers as $supplier)
                            <option
                                value="{{ $supplier->id }}"
                                @selected(
                                    (string) old('supplier_id') ===
                                    (string) $supplier->id
                                )
                            >
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="purchase-field">
                    <label for="purchase_date">Tanggal Pembelian *</label>
                    <input
                        id="purchase_date"
                        type="date"
                        name="purchase_date"
                        value="{{ old('purchase_date', date('Y-m-d')) }}"
                        required
                    >
                </div>
            </div>

            <h3 style="color:#57222f;margin:28px 0 5px;">
                Rincian Produk
            </h3>

            <p class="purchase-help" style="margin-bottom:0;">
                Pilih produk untuk mengisi harga belinya secara otomatis.
            </p>

            @php
                $oldItems = old('items', [
                    ['product_id' => '', 'quantity' => 1]
                ]);
            @endphp

            <div class="purchase-items" id="purchase-items">
                @foreach($oldItems as $index => $line)
                    @php
                        $selectedProduct = $products->firstWhere(
                            'id',
                            (int) ($line['product_id'] ?? 0)
                        );
                    @endphp

                    <div class="purchase-row">
                        <div class="purchase-row-title">
                            <span class="row-title">
                                Produk {{ $loop->iteration }}
                            </span>

                            <button
                                type="button"
                                class="purchase-button purchase-danger remove-row"
                            >
                                Hapus
                            </button>
                        </div>

                        <div class="purchase-row-grid">
                            <div class="purchase-field">
                                <label>Nama Produk *</label>

                                <select
                                    name="items[{{ $index }}][product_id]"
                                    class="product-select"
                                    required
                                >
                                    <option value="" data-price="">
                                        Pilih produk
                                    </option>

                                    @foreach($products as $product)
                                        <option
                                            value="{{ $product->id }}"
                                            data-price="{{ $product->purchase_price }}"
                                            @selected(
                                                (int) ($line['product_id'] ?? 0)
                                                === (int) $product->id
                                            )
                                        >
                                            {{ $product->name }}
                                            (SKU: {{ $product->sku }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="purchase-field">
                                <label>Jumlah *</label>

                                <input
                                    type="number"
                                    name="items[{{ $index }}][quantity]"
                                    class="quantity-input"
                                    min="1"
                                    max="4294967295"
                                    value="{{ $line['quantity'] ?? 1 }}"
                                    required
                                >
                            </div>

                            <div class="purchase-field">
                                <label>Harga Beli per Unit</label>

                                <input
                                    type="number"
                                    class="price-input"
                                    value="{{ $selectedProduct ? $selectedProduct->purchase_price : '' }}"
                                    placeholder="Otomatis dari produk"
                                    min="0"
                                    step="0.01"
                                    readonly
                                >
                            </div>
                        </div>

                        <div class="purchase-subtotal">
                            <span>Subtotal produk</span>
                            <strong class="line-subtotal">Rp 0</strong>
                        </div>
                    </div>
                @endforeach
            </div>

            <button
                type="button"
                class="purchase-button purchase-secondary"
                id="add-purchase-item"
            >
                + Tambah Produk
            </button>

            <div class="purchase-field" style="margin-top:22px;">
                <label for="notes">Catatan Pembelian</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="3"
                    placeholder="Catatan tambahan (opsional)"
                >{{ old('notes') }}</textarea>
            </div>

            <div class="purchase-summary" style="margin-top:22px;">
                <span class="purchase-summary-label">
                    Total Pembelian
                </span>

                <strong
                    class="purchase-summary-total"
                    id="purchase-total"
                >
                    Rp 0
                </strong>

                <p class="purchase-summary-label" style="margin:8px 0 0;">
                    Total dihitung dari harga beli dikali jumlah setiap produk.
                </p>
            </div>

            <div class="purchase-actions">
                <button type="reset" class="purchase-button purchase-secondary">
                    Reset Form
                </button>

                <button
                    type="submit"
                    class="purchase-button purchase-primary"
                >
                    Simpan Pembelian
                </button>
            </div>
        </form>
    </section>

    <section class="purchase-card">
        <h2>Riwayat Pembelian</h2>
        <p class="purchase-help">
            Daftar transaksi pembelian yang telah disimpan.
        </p>

        <div class="purchase-table-wrap">
            <table class="purchase-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Pembelian</th>
                        <th>Supplier</th>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td>
                                {{ $purchases->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $purchase->purchase_number }}</td>

                            <td>
                                {{ $purchase->supplier->name ?? '-' }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Carbon::parse(
                                    $purchase->purchase_date
                                )->format('d/m/Y') }}
                            </td>

                            <td>{{ $purchase->items_count }}</td>

                            <td>
                                Rp {{ number_format(
                                    (float) $purchase->total_amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>{{ ucfirst($purchase->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="purchase-empty">
                                Belum ada transaksi pembelian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="purchase-pagination">
            {{ $purchases->links() }}
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('purchase-items');
    const addButton = document.getElementById('add-purchase-item');
    const totalOutput = document.getElementById('purchase-total');
    const form = document.getElementById('purchase-form');

    const rupiah = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    });

    function updateRemoveButtons() {
        const rows = container.querySelectorAll('.purchase-row');

        rows.forEach(function (row, index) {
            row.querySelector('.row-title').textContent =
                'Produk ' + (index + 1);

            row.querySelector('.remove-row').disabled = rows.length === 1;
        });
    }

    function updateRow(row) {
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        const subtotalOutput = row.querySelector('.line-subtotal');

        const option = select.selectedOptions[0];
        const hasProduct = Boolean(select.value);
        const price = hasProduct
            ? Number(option.dataset.price || 0)
            : 0;

        const quantity = Math.max(
            0,
            Number(quantityInput.value || 0)
        );

        priceInput.value = hasProduct ? price.toFixed(2) : '';

        const subtotal = price * quantity;

        subtotalOutput.textContent = rupiah.format(subtotal);

        return subtotal;
    }

    function updateSummary() {
        let total = 0;

        container.querySelectorAll('.purchase-row').forEach(function (row) {
            total += updateRow(row);
        });

        totalOutput.textContent = rupiah.format(total);

        updateRemoveButtons();
    }

    addButton.addEventListener('click', function () {
        const rows = container.querySelectorAll('.purchase-row');
        const newIndex = Date.now() + Math.floor(Math.random() * 1000);

        const newRow = rows[0].cloneNode(true);

        newRow.querySelectorAll('[name]').forEach(function (element) {
            element.name = element.name.replace(
                /items\[\d+\]/,
                'items[' + newIndex + ']'
            );
        });

        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.quantity-input').value = '1';
        newRow.querySelector('.price-input').value = '';
        newRow.querySelector('.line-subtotal').textContent = rupiah.format(0);

        container.appendChild(newRow);

        updateSummary();
    });

    container.addEventListener('click', function (event) {
        const button = event.target.closest('.remove-row');

        if (!button || button.disabled) {
            return;
        }

        const rows = container.querySelectorAll('.purchase-row');

        if (rows.length > 1) {
            button.closest('.purchase-row').remove();
            updateSummary();
        }
    });

    container.addEventListener('change', function (event) {
        if (
            event.target.matches('.product-select') ||
            event.target.matches('.quantity-input')
        ) {
            updateSummary();
        }
    });

    container.addEventListener('input', function (event) {
        if (event.target.matches('.quantity-input')) {
            updateSummary();
        }
    });

    form.addEventListener('reset', function () {
        setTimeout(function () {
            updateSummary();
        }, 0);
    });

    updateSummary();
});
</script>
@endsection
