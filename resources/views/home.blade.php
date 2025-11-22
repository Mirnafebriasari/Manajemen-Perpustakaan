@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<h1 class="text-3xl font-bold mb-6">Beranda</h1>

{{-- Search Bar --}}
<form method="GET" action="{{ route('home') }}" class="mb-6 max-w-lg flex gap-2">
    <input 
        type="text" 
        name="search" 
        placeholder="Cari buku berdasarkan judul atau penulis..."
        value="{{ old('search', $search ?? '') }}"
        class="border p-2 rounded w-full"
    >
    <button class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
</form>

@if(!empty($search))
    <h2 class="text-xl font-semibold mb-4">Hasil pencarian untuk "{{ $search }}"</h2>
    @if(isset($searchResults) && $searchResults->isEmpty())
        <p>Tidak ada buku ditemukan.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @foreach ($searchResults as $book)
                <div class="border p-4 rounded shadow">
                    <h3 class="font-bold text-lg">{{ $book->title }}</h3>
                    <p>Penulis: {{ $book->author }}</p>
                    <p>Kategori: {{ $book->category }}</p>
                    <p>Stok: {{ $book->stock }}</p>
                    <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline">Detail Buku</a>
                </div>
            @endforeach
        </div>
    @endif
@endif

<h2 class="text-2xl font-semibold mb-4">Buku Terbaru</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @foreach ($latestBooks ?? [] as $book)
        <div class="border p-4 rounded shadow">
            <h3 class="font-bold text-lg">{{ $book->title }}</h3>
            <p>Penulis: {{ $book->author }}</p>
            <p>Stok: {{ $book->stock }}</p>
            <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline">Detail Buku</a>
        </div>
    @endforeach
</div>

<h2 class="text-2xl font-semibold mb-4">Buku Populer</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @foreach ($popularBooks ?? [] as $book)
        <div class="border p-4 rounded shadow">
            <h3 class="font-bold text-lg">{{ $book->title }}</h3>
            <p>Penulis: {{ $book->author }}</p>
            <p>Stok: {{ $book->stock }}</p>
            <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline">Detail Buku</a>
        </div>
    @endforeach
</div>

@if(isset($personalizedRecommendations) && $personalizedRecommendations->isNotEmpty())
    <h2 class="text-2xl font-semibold mb-4">Rekomendasi untuk Anda</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @foreach($personalizedRecommendations as $book)
            <div class="border p-4 rounded shadow">
                <h3 class="font-bold text-lg">{{ $book->title }}</h3>
                <p>Penulis: {{ $book->author }}</p>
                <p>Stok: {{ $book->stock }}</p>
                <a href="{{ route('books.show', $book->id) }}" class="text-blue-600 hover:underline">Detail Buku</a>
            </div>
        @endforeach
    </div>
@endif

{{-- Link Login / Dashboard --}}
<div class="mt-8">
    @guest
        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Login</a>
    @else
        @if(auth()->user()->role == 'pegawai')
            <a href="{{ route('pegawai.dashboard') }}" class="bg-green-600 text-white px-4 py-2 rounded">Dashboard Pegawai</a>
        @elseif(auth()->user()->role == 'mahasiswa')
            <a href="{{ route('loans.index') }}" class="bg-green-600 text-white px-4 py-2 rounded">Dashboard Mahasiswa</a>
        @endif
    @endguest
</div>

@endsection
