@extends('layouts.app')
@section('content')
<h3>Data Produk</h3>
@if (auth()->user()->isAdmin())
    <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
@endif
<form method="GET" class="row g-2 my-3">
    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode, nama, merek">
    <select name="category_id" class="form-select">
        <option value="">Semua kategori</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" @selected(request('category_id')==$category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
    <button class="btn btn-outline-primary">Cari / Filter</button>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Kode</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Merek</th>
            <th>Harga</th>
            <th>Stok</th>
            @if (auth()->user()->isAdmin())
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar {{ $product->name }}"
                        class="img-thumbnail" style="max-width: 64px; max-height: 64px;">
                @else
                    <span class="text-secondary">-</span>
                @endif
            </td>
            <td>{{ $product->product_code }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->brand }}</td>
            <td>Rp {{ number_format((float)$product->price,0,',','.') }}</td>
            <td>{{ $product->stock }}</td>
            @if (auth()->user()->isAdmin())
                <td>
                    <a class="btn btn-sm btn-warning" href="{{ route('products.edit',$product) }}">Edit</a>
                    <form class="d-inline" method="POST" action="{{ route('products.destroy',$product) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk?')">Hapus</button>
                    </form>
                </td>
            @endif
        </tr>
        @empty <tr>
            <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}">Belum ada produk.</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $products->links() }}
@endsection