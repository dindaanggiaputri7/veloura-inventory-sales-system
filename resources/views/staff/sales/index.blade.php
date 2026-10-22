
@extends('staff.layout')

@section('title', 'Penjualan')
@section('page-heading', 'Penjualan')
@section('page-description', 'Pilih produk yang tersedia untuk proses penjualan.')

@section('content')
<div style="background:white;padding:22px;border:1px solid #eadbd6;border-radius:12px">
    <h3 style="margin-top:0">Produk Tersedia</h3>

    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:12px">
            <thead>
                <tr style="background:#fcf8f5;text-align:left">
                    <th style="padding:12px">No.</th>
                    <th style="padding:12px">SKU</th>
                    <th style="padding:12px">Nama Produk</th>
                    <th style="padding:12px">Stok Tersedia</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom:1px solid #f1e8e4">
                        <td style="padding:12px">{{ $loop->iteration }}</td>
                        <td style="padding:12px">{{ $product->sku ?? '-' }}</td>
                        <td style="padding:12px;font-weight:600">{{ $product->name }}</td>
                        <td style="padding:12px">{{ $product->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:20px;text-align:center">
                            Belum ada produk dengan stok tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
