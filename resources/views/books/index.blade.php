@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<h1 class="text-3xl font-bold mb-4">Katalog Buku</h1>

{{-- ================================
    AUTO SELECT ROUTE INDEX SESUAI ROLE
================================ --}}
@php
    if (auth()->check()) {
        if (auth()->user()->hasRole('admin')) {
            $indexRoute = 'admin.books.index';
        } elseif (auth()->user()->hasRole('pegawai')) {
            $indexRoute = 'pegawai.books.index';
        } elseif (auth()->user()->hasRole('mahasiswa')) {
            $indexRoute = 'mahasiswa.books.index';
        } else {
            $indexRoute = 'books.index';
        }
    } else {
        $indexRoute = 'books.index'; // guest
    }
@endphp


{{-- ================================
        FORM FILTER
================================ --}}
<form method="GET" action="{{ route($indexRoute) }}"
      class="mb-4 max-w-lg flex gap-2 flex-wrap">

    <input 
        type="text" 
        name="search" 
        placeholder="Cari buku..."
        value="{{ request('search') }}"
        class="border p-2 rounded flex-grow min-w-[200px]"
    >

    <select name="category" class="border p-2 rounded">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                {{ $cat }}
            </option>
        @endforeach
    </select>

    <select name="sort" class="border p-2 rounded">
        <option value="">Urutkan</option>
        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul</option>
        <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Penulis</option>
        <option value="publication_year" {{ request('sort') == 'publication_year' ? 'selected' : '' }}>Tahun Terbit</option>
        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Ditambahkan</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
</form>


{{-- ================================
        GRID LIST BUKU
================================ --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

@foreach ($books as $book)

    @php
        // route detail otomatis berdasarkan role
        if (auth()->check()) {
            if (auth()->user()->hasRole('admin')) {
                $showRoute = 'admin.books.show';
            } elseif (auth()->user()->hasRole('pegawai')) {
                $showRoute = 'pegawai.books.show';
            } elseif (auth()->user()->hasRole('mahasiswa')) {
                $showRoute = 'mahasiswa.books.show';
            } else {
                $showRoute = 'books.show';
            }
        } else {
            $showRoute = 'books.show'; // guest
        }
    @endphp

    <div class="border p-4 rounded shadow">

        <h2 class="font-bold text-xl">{{ $book->title }}</h2>
        <p>Penulis: {{ $book->author }}</p>
        <p>Kategori: {{ $book->category }}</p>
        <p>Stok: {{ $book->stock }}</p>
        <p>Tahun: {{ $book->publication_year }}</p>
        <p>Rating: {{ number_format($book->rating ?? 0, 1) }}</p>

        <a href="{{ route($showRoute, $book->id) }}" 
           class="text-blue-600 hover:underline mt-2 inline-block">
            Detail Buku
        </a>


        {{-- ================================
            TOMBOL EDIT & DELETE
            HANYA ADMIN & PEGAWAI
        ================================= --}}
        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'pegawai']))

            @php
                if (auth()->user()->hasRole('admin')) {
                    $editRoute = route('admin.books.edit', $book->id);
                    $deleteRoute = route('admin.books.destroy', $book->id);
                } else {
                    $editRoute = route('pegawai.books.edit', $book->id);
                    $deleteRoute = route('pegawai.books.destroy', $book->id);
                }
            @endphp

            <div class="flex gap-2 mt-3">
                <a href="{{ $editRoute }}" 
                   class="px-3 py-1 bg-yellow-500 text-white rounded">
                    Edit
                </a>

                <form action="{{ $deleteRoute }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded">
                        Hapus
                    </button>
                </form>
            </div>

        @endif

    </div>

@endforeach

</div>


{{-- ================================
        PAGINATION
================================ --}}
<div class="mt-6">
    {{ $books->withQueryString()->links() }}
</div>

@endsection
