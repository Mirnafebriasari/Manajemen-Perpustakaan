@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Buku</h1>

<form action="{{ route('books.update', $book->id) }}" method="POST" class="max-w-lg">
    @csrf
    @method('PUT')

    <label class="block mb-2">Judul Buku</label>
    <input type="text" name="title" value="{{ $book->title }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Penulis</label>
    <input type="text" name="author" value="{{ $book->author }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Penerbit</label>
    <input type="text" name="publisher" value="{{ $book->publisher }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Tahun Terbit</label>
    <input type="number" name="year" value="{{ $book->year }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Kategori</label>
    <input type="text" name="category" value="{{ $book->category }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Jumlah Stok</label>
    <input type="number" name="stock" value="{{ $book->stock }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Waktu Maksimal Peminjaman (hari)</label>
    <input type="number" name="max_loan_days" value="{{ $book->max_loan_days }}" class="border p-2 w-full mb-3">

    <label class="block mb-2">Denda Per Hari</label>
    <input type="number" name="fine_per_day" value="{{ $book->fine_per_day }}" class="border p-2 w-full mb-3">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
</form>
@endsection
