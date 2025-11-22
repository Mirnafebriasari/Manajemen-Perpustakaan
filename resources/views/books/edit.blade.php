@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Buku</h1>

@php
    if (auth()->user()->hasRole('admin')) {
        $updateRoute = route('admin.books.update', $book->id);
    } else {
        $updateRoute = route('pegawai.books.update', $book->id);
    }
@endphp

<form action="{{ $updateRoute }}" method="POST" class="max-w-lg">
    @csrf
    @method('PUT')

    <label class="block mb-2">Judul Buku</label>
    <input type="text" name="title" value="{{ old('title', $book->title) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Penulis</label>
    <input type="text" name="author" value="{{ old('author', $book->author) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Penerbit</label>
    <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Tahun Terbit</label>
    <input type="number" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Kategori</label>
    <input type="text" name="category" value="{{ old('category', $book->category) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Jumlah Stok</label>
    <input type="number" name="stock" value="{{ old('stock', $book->stock) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Maksimal Waktu Pinjam (hari)</label>
    <input type="number" name="max_loan_days" value="{{ old('max_loan_days', $book->max_loan_days) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Denda per Hari</label>
    <input type="number" name="fine_per_day" value="{{ old('fine_per_day', $book->fine_per_day) }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Deskripsi</label>
    <textarea name="description" class="border p-2 w-full mb-3">{{ old('description', $book->description) }}</textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
</form>
@endsection
