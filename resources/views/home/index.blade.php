@extends('layouts.app') 

@section('content')
    <div class="container text-center">
        <header class="py-5 bg-light">
            <h1>Selamat Datang di Projek PWeb</h1>
            <p class="lead">Ini adalah halaman utama Anda, berhasil dimuat melalui HomeController.</p>
            <a href="{{ route('products.list') }}" class="btn btn-primary btn-lg mt-3">Jelajahi Produk</a>
        </header>

        <section class="mt-5">
            <h2>Bagaimana Cara Kerjanya?</h2>
            <p>Rute **/** memanggil **`HomeController@index`**, yang kemudian memuat View ini (**`home/index.blade.php`**).</p>
        </section>
        
        {{-- Di sini kamu bisa menampilkan data produk terbaru --}}
        {{-- @if(isset($products))
            ... tampilkan looping data produk ...
        @endif --}}

    </div>
@endsection