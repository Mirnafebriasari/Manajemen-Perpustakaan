@extends('layouts.app')

@section('title', $book->title)

@section('content')
<h1 class="text-3xl font-bold mb-4">{{ $book->title }}</h1>

<p><strong>Penulis:</strong> {{ $book->author }}</p>
<p><strong>Penerbit:</strong> {{ $book->publisher }}</p>
<p><strong>Tahun Terbit:</strong> {{ $book->publication_year }}</p>
<p><strong>Kategori:</strong> {{ $book->category }}</p>
<p><strong>Stok:</strong> {{ $book->stock }}</p>
<p><strong>Rating:</strong> {{ number_format($book->rating ?? 0, 1) }}</p>
<p><strong>Maksimal Waktu Pinjam:</strong> {{ $book->max_loan_days }} hari</p>
<p><strong>Denda per Hari:</strong> Rp {{ number_format($book->fine_per_day, 0, ',', '.') }}</p>
@if($book->description)
    <p><strong>Deskripsi:</strong> {{ $book->description }}</p>
@endif

{{-- Tombol Pinjam (khusus mahasiswa, stok > 0) --}}
@auth
    @if(auth()->user()->role === 'mahasiswa' && $book->stock > 0)
        <form action="{{ route('mahasiswa.loans.store') }}" method="POST" class="mt-4 max-w-xs">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">
             <input type="hidden" name="quantity" value="1">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Pinjam Buku</button>
        </form>
    @elseif($book->stock == 0)
        <p class="text-red-600 font-semibold mt-4">Stok buku habis, tidak bisa dipinjam saat ini.</p>
    @endif
@endauth

{{-- Ulasan Buku --}}
<h2 class="text-2xl font-semibold mt-8 mb-4">Ulasan</h2>
@if($reviews->isEmpty())
    <p>Belum ada ulasan untuk buku ini.</p>
@else
    @foreach($reviews as $review)
        <div class="border p-3 rounded mb-3">
            <p><strong>{{ $review->user->name }}</strong> ({{ $review->created_at->format('d M Y') }})</p>
            <p>Rating: {{ number_format($review->rating, 1) }}</p>
            <p>{{ $review->comment }}</p>
        </div>
    @endforeach
@endif

@endsection