
@extends('staff.layout')

@section('title', 'Produk & Stok')
@section('page-heading', 'Produk & Stok')
@section('page-description', 'Informasi produk dan ketersediaan stok.')

@section('content')
<div style="background:white;padding:22px;border:1px solid #eadbd6;border-radius:12px">
    <h3 style="margin-top:0">Daftar Produk</h3>

    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:12px">
            <thead>
                <tr style="background:#fcf8f5;text-align:left">
                    <th style="padding:12px">No.</th>
                    <th style="padding:12px">SKU</th>
                    <th style="padding:12px">Nama Produk</th>
                    <th style="padding:12px">Stok</th>
                    <th style="padding:12px">Stok Minimum</th>
                    <th style="padding:12px">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom:1px solid #f1e8e4">
                        <td style="padding:12px">{{ $products->firstItem() + $loop->index }}</td>
                        <td style="padding:12px">{{ $product->sku ?? '-' }}</td>
                        <td style="padding:12px;font-weight:600">{{ $product->name }}</td>
                        <td style="padding:12px">{{ $product->stock }}</td>
                        <td style="padding:12px">{{ $product->minimum_stock }}</td>
                        <td style="padding:12px">
                            @if($product->stock <= 0)
                                <span style="color:#b42332">Habis</span>
                            @elseif($product->stock <= $product->minimum_stock)
                                <span style="color:#b06b25">Menipis</span>
                            @else
                                <span style="color:#28784b">Tersedia</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:20px;text-align:center">
                            Belum ada data produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px">
        {{ $products->links() }}
    </div>
</div>
@endsection
