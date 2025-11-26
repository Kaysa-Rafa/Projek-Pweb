@extends('layouts.app')

@section('title', 'Categories - Hive Workshop Community')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Resource Categories</h1>
    <p class="text-gray-600 text-lg">Browse high-quality resources by category</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

    @foreach($categories as $category)
        <a href="{{ route('categories.show', $category->slug) }}" 
           class="block bg-white rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 border border-gray-100">

            <div class="p-6 flex flex-col items-center text-center">

                {{-- Icon --}}
                <div class="text-5xl mb-4">
                    {{ $category->icon ?? '📁' }}
                </div>

                {{-- Name --}}
                <h3 class="text-2xl font-bold text-gray-800">
                    {{ $category->name }}
                </h3>

                {{-- Description --}}
                <p class="text-gray-600 mt-2 mb-6">
                    {{ $category->description }}
                </p>

                {{-- Button --}}
                <span class="px-5 py-2 rounded-lg text-white font-semibold bg-{{ $category->color }}-600 hover:bg-{{ $category->color }}-500 transition">
                    Explore Resources →
                </span>

            </div>

        </a>
    @endforeach

</div>
@endsection
