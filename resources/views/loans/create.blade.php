@extends('layouts.app')

@section('title', 'Pinjam Buku')

@section('content')
<h1 class="text-3xl font-bold mb-6">Pinjam Buku</h1>

<form action="{{ auth()->user()->hasRole('pegawai') ? route('loans.store') : route('mahasiswa.loans.store') }}" method="POST" class="max-w-md">
    @csrf
    <label class="block mb-2">Buku</label>
    <select name="book_id" required class="border p-2 w-full mb-4">
        @foreach($books as $book)
            <option value="{{ $book->id }}" {{ (old('book_id') == $book->id) ? 'selected' : '' }}>
                {{ $book->title }} (stok: {{ $book->stock }})
            </option>
        @endforeach
    </select>
    @error('book_id') <p class="text-red-600">{{ $message }}</p> @enderror

    <label class="block mb-2">Jumlah Pinjam</label>
    <input 
        type="number" 
        name="quantity" 
        value="{{ old('quantity', 1) }}" 
        min="1" 
        max="10" 
        required 
        class="border p-2 w-full mb-4"
        placeholder="Masukkan jumlah buku yang ingin dipinjam"
    >
    @error('quantity') <p class="text-red-600">{{ $message }}</p> @enderror

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Pinjam</button>
</form>

@endsection