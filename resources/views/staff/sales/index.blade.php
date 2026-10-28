@extends('staff.layout')

@section('title', 'Penjualan')
@section('page-heading', 'Penjualan')
@section(
    'page-description',
    'Catat penjualan langsung; harga dan total dihitung ulang oleh server.'
)

@section('content')

<style>
    .sales-card {
        background: #fff;
        padding: 22px;
        border: 1px solid #eadbd6;
        border-radius: 12px;
        margin-bottom: 22px;
    }

    .sales-card h3 {
        margin: 0 0 18px;
        color: #57222f;
        font-size: 17px;
    }

    .sales-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .sales-field {
        display: block;
        min-width: 0;
        color: #57222f;
        font-size: 13px;
        font-weight: 500;
    }

    .sales-field input,
    .sales-field select,
    .sales-field textarea,
    .sale-row input,
    .sale-row select {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        padding: 10px;
        margin-top: 6px;
        border: 1px solid #eadbd6;
        border-radius: 7px;
        background: #fff;
        color: #39202a;
        font: inherit;
    }

    .sale-row {
        display: grid;
        grid-template-columns: minmax(0, 2fr)
            minmax(75px, 0.65fr)
            minmax(120px, 1fr)
            minmax(135px, 1fr)
            auto;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .sale-price,
    .sale-line-total {
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .sale-price {
        color: #99878b;
    }

    .sale-line-total {
        color: #57222f;
        font-weight: 700;
    }

    .sales-button {
        padding: 10px 16px;
        border: 0;
        border-radius: 7px;
        background: #57222f;
        color: #fff;
        cursor: pointer;
        font-weight: 600;
    }

    .sales-button-secondary {
        background: #fff;
        color: #57222f;
        border: 1px solid #57222f;
    }

    .sales-button-delete {
        background: #f5e5e5;
        color: #57222f;
    }

    .sales-summary {
        margin-top: 18px;
        padding: 16px;
        background: #fcf8f5;
        border-radius: 8px;
    }

    .sales-summary p {
        margin: 5px 0 10px;
    }

    .sales-grand-total {
        color: #57222f;
        font-size: 21px;
        font-weight: 700;
    }

    .sales-note {
        color: #99878b;
        font-size: 12px;
        line-height: 1.6;
    }

    .sales-table-wrap {
        overflow-x: auto;
    }

    .sales-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .sales-table th,
    .sales-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #f1e8e4;
        white-space: nowrap;
    }

    .sales-table th {
        background: #fcf8f5;
        color: #57222f;
    }

    .sales-alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .sales-alert-success {
        background: #e7f6ec;
        color: #216e39;
    }

    .sales-alert-error {
        background: #fff0f0;
        color: #9c2525;
    }

    @media (max-width: 950px) {
        .sales-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .sale-row {
            grid-template-columns: minmax(0, 1fr) minmax(80px, 0.5fr);
            padding: 12px;
            border: 1px solid #eadbd6;
            border-radius: 8px;
        }

        .sale-row > * {
            min-width: 0;
        }
    }

    @media (max-width: 600px) {
        .sales-card {
            padding: 15px;
        }

        .sales-grid {
            grid-template-columns: 1fr;
        }

        .sale-row {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Pesan jika penjualan berhasil disimpan --}}
@if (session('success'))
    <div class="sales-alert sales-alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Pesan jika data tidak valid --}}
@if ($errors->any())
    <div class="sales-alert sales-alert-error">
        <strong>Periksa kembali data penjualan:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- FORM INPUT PENJUALAN --}}
<div class="sales-card">
    <h3>Input Penjualan Langsung</h3>

    <form method="POST" action="{{ route('staff.sales.store') }}">
        @csrf

        {{-- Informasi utama penjualan --}}
        <div class="sales-grid">
            <label class="sales-field">
                Tanggal

                <input
                    type="date"
                    name="sale_date"
                    value="{{ old('sale_date', date('Y-m-d')) }}"
                    required
                >
            </label>

            <label class="sales-field">
                Nama pelanggan

                <input
                    type="text"
                    name="customer_name"
                    value="{{ old('customer_name') }}"
                    maxlength="255"
                    placeholder="Nama pelanggan (opsional)"
                >
            </label>

            <label class="sales-field">
                Metode pembayaran

                <select name="payment_method" required>
                    <option value="cash"
                        @selected(old('payment_method', 'cash') === 'cash')>
                        Tunai
                    </option>

                    <option value="transfer"
                        @selected(old('payment_method') === 'transfer')>
                        Transfer
                    </option>

                    <option value="qris"
                        @selected(old('payment_method') === 'qris')>
                        QRIS
                    </option>

                    <option value="debit"
                        @selected(old('payment_method') === 'debit')>
                        Debit
                    </option>
                </select>
            </label>
        </div>


        {{-- Daftar produk yang dijual --}}
        <h4 style="margin: 24px 0 12px; color: #57222f;">
            Produk
        </h4>

        <div id="sale-items">
            <div class="sale-row">

                {{-- Pilihan produk beserta harga jual --}}
                <select
                    class="sale-product"
                    name="items[0][product_id]"
                    required
                    aria-label="Pilih produk"
                >
                    <option value="">Pilih produk</option>

                    @foreach ($products as $product)
                        <option
                            value="{{ $product->id }}"
                            data-price="{{ (float) $product->selling_price }}"
                            @selected(
                                (string) old('items.0.product_id') ===
                                (string) $product->id
                            )
                        >
                            {{ $product->name }}
                            — stok {{ $product->stock }}
                            — Rp {{ number_format(
                                (float) $product->selling_price,
                                0,
                                ',',
                                '.'
                            ) }}
                        </option>
                    @endforeach
                </select>

                {{-- Jumlah produk --}}
                <input
                    class="sale-quantity"
                    type="number"
                    name="items[0][quantity]"
                    min="1"
                    max="4294967295"
                    value="{{ old('items.0.quantity', 1) }}"
                    required
                    aria-label="Jumlah produk"
                    placeholder="Jumlah"
                >

                {{-- Harga satuan --}}
                <div class="sale-price">
                    Harga satuan: Rp 0
                </div>

                {{-- Total harga untuk baris ini --}}
                <div class="sale-line-total">
                    Subtotal: Rp 0
                </div>

                <button
                    type="button"
                    class="sales-button sales-button-delete remove-row"
                >
                    Hapus
                </button>
            </div>
        </div>

        <button
            type="button"
            id="add-item"
            class="sales-button sales-button-secondary"
        >
            + Tambah Produk
        </button>


        {{-- Ringkasan harga otomatis --}}
        <div class="sales-summary">
            <p>
                Subtotal semua produk:
                <strong id="sale-subtotal">Rp 0</strong>
            </p>

            <p>
                Diskon:
                <strong id="sale-discount-display">Rp 0</strong>
            </p>

            <p style="margin-top: 14px;">
                Total setelah diskon:
            </p>

            <div
                id="sale-grand-total"
                class="sales-grand-total"
            >
                Rp 0
            </div>
        </div>


        {{-- Diskon dan jumlah pembayaran --}}
        <div
            class="sales-grid"
            style="margin-top: 18px;"
        >
            <label class="sales-field">
                Diskon (Rp)

                <input
                    type="number"
                    id="sale-discount"
                    name="discount"
                    min="0"
                    step="0.01"
                    value="{{ old('discount', 0) }}"
                    required
                >
            </label>

            <label class="sales-field">
                Jumlah dibayar (Rp)

                <input
                    type="number"
                    name="payment_amount"
                    min="0"
                    step="0.01"
                    value="{{ old('payment_amount') }}"
                    required
                >
            </label>
        </div>

        <p class="sales-note">
            Harga produk dan total transaksi dihitung kembali oleh server.
            Jumlah pembayaran minimal harus sama dengan total setelah diskon.
            Masukkan jumlah uang yang benar-benar dibayarkan pelanggan.
        </p>


        {{-- Catatan transaksi --}}
        <label
            class="sales-field"
            style="margin-top: 16px;"
        >
            Catatan

            <textarea
                name="notes"
                rows="3"
                maxlength="2000"
                placeholder="Catatan tambahan (opsional)"
            >{{ old('notes') }}</textarea>
        </label>

        <button
            type="submit"
            class="sales-button"
            style="margin-top: 16px;"
        >
            Simpan Penjualan
        </button>
    </form>
</div>


{{-- RIWAYAT PENJUALAN --}}
<div class="sales-card">
    <h3>Riwayat Penjualan Langsung</h3>

    <div class="sales-table-wrap">
        <table class="sales-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nomor Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td>
                            {{ $sales->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $sale->sale_number }}
                        </td>

                        <td>
                            {{ \Illuminate\Support\Carbon::parse(
                                $sale->sale_date
                            )->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $sale->customer_name ?: 'Pelanggan umum' }}
                        </td>

                        <td>
                            Rp {{ number_format(
                                (float) $sale->total_amount,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>
                            {{ ucfirst($sale->status) }}
                        </td>

                        <td>
                            {{ strtoupper($sale->payment_method) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">
                            Belum ada penjualan langsung.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 18px;">
        {{ $sales->links() }}
    </div>
</div>


{{-- PERHITUNGAN HARGA OTOMATIS --}}
<script>
    let itemIndex = 1;

    const saleItems = document.getElementById('sale-items');
    const saleDiscount = document.getElementById('sale-discount');

    const saleCurrency = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 2
    });

    // Mengubah angka menjadi format mata uang Rupiah.
    function formatSaleMoney(amount) {
        return saleCurrency.format(amount || 0);
    }

    // Menghitung harga setiap produk dan total penjualan.
    function updateSaleTotals() {
        let subtotal = 0;

        document.querySelectorAll('#sale-items .sale-row')
            .forEach(function (row) {
                const productSelect =
                    row.querySelector('.sale-product');

                const quantityInput =
                    row.querySelector('.sale-quantity');

                const selectedOption =
                    productSelect.selectedOptions[0];

                const price = productSelect.value
                    ? Number(selectedOption.dataset.price || 0)
                    : 0;

                const quantity = Math.max(
                    0,
                    Number(quantityInput.value || 0)
                );

                const lineTotal = price * quantity;

                subtotal += lineTotal;

                row.querySelector('.sale-price').textContent =
                    'Harga satuan: ' + formatSaleMoney(price);

                row.querySelector('.sale-line-total').textContent =
                    'Subtotal: ' + formatSaleMoney(lineTotal);
            });

        const discount = Math.max(
            0,
            Number(saleDiscount.value || 0)
        );

        const grandTotal = Math.max(
            0,
            subtotal - discount
        );

        document.getElementById('sale-subtotal').textContent =
            formatSaleMoney(subtotal);

        document.getElementById('sale-discount-display').textContent =
            formatSaleMoney(discount);

        document.getElementById('sale-grand-total').textContent =
            formatSaleMoney(grandTotal);
    }

    // Menambahkan baris produk baru.
    document.getElementById('add-item')
        .addEventListener('click', function () {
            const firstSelect =
                saleItems.querySelector('.sale-product');

            const row = document.createElement('div');

            row.className = 'sale-row';

            row.innerHTML = `
                <select
                    class="sale-product"
                    name="items[${itemIndex}][product_id]"
                    required
                    aria-label="Pilih produk"
                >
                    ${firstSelect.innerHTML}
                </select>

                <input
                    class="sale-quantity"
                    type="number"
                    name="items[${itemIndex}][quantity]"
                    min="1"
                    max="4294967295"
                    value="1"
                    required
                    aria-label="Jumlah produk"
                    placeholder="Jumlah"
                >

                <div class="sale-price">
                    Harga satuan: Rp 0
                </div>

                <div class="sale-line-total">
                    Subtotal: Rp 0
                </div>

                <button
                    type="button"
                    class="sales-button sales-button-delete remove-row"
                >
                    Hapus
                </button>
            `;

            saleItems.appendChild(row);

            itemIndex++;

            updateSaleTotals();
        });

    // Menghitung ulang saat pilihan produk berubah.
    saleItems.addEventListener('change', function (event) {
        if (event.target.matches('.sale-product')) {
            updateSaleTotals();
        }
    });

    // Menghitung ulang saat jumlah produk diubah.
    saleItems.addEventListener('input', function (event) {
        if (event.target.matches('.sale-quantity')) {
            updateSaleTotals();
        }
    });

    // Menghapus baris produk.
    saleItems.addEventListener('click', function (event) {
        if (
            event.target.classList.contains('remove-row') &&
            saleItems.querySelectorAll('.sale-row').length > 1
        ) {
            event.target.closest('.sale-row').remove();

            updateSaleTotals();
        }
    });

    // Menghitung ulang saat diskon berubah.
    saleDiscount.addEventListener('input', updateSaleTotals);

    // Menghitung harga awal ketika halaman pertama kali dibuka.
    updateSaleTotals();
</script>

@endsection