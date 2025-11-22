@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Buku</h1>

<form action="{{ route('books.store') }}" method="POST" class="max-w-lg">
    @csrf

    <label class="block mb-2">Judul Buku</label>
    <input type="text" name="title" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Penulis</label>
    <input type="text" name="author" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Penerbit</label>
    <input type="text" name="publisher" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Tahun Terbit</label>
    <input type="number" name="publication_year" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Kategori</label>
    <input type="text" name="category" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Stok</label>
    <input type="number" name="stock" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Maksimal Hari Pinjam</label>
    <input type="number" name="max_loan_days" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Denda per Hari (Rp)</label>
    <input type="number" name="fine_per_day" class="border p-2 w-full mb-4" required>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>
</form>
@endsection
