@extends('layouts.app') 

@section('content')
    <h2>Daftar Produk</h2>
    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-item">
                <h3>{{ $product->name }}</h3> 
                <p>{{ Str::limit($product->description, 100) }}</p> 
                <a href="{{ route('products.show', ['slug' => $product->slug]) }}">Lihat Detail</a>
            </div>
        @endforeach
    </div>

    {{-- Menampilkan link pagination --}}
    {{ $products->links() }} 
@endsection