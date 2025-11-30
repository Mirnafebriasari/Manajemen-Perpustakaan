@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-orange-700">Edit Buku</h1>

    @php
        $updateRoute = auth()->user()->hasRole('admin') 
            ? route('admin.books.update', $book->id) 
            : route('pegawai.books.update', $book->id);
    @endphp

    <form action="{{ $updateRoute }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        {{-- Form fields tetap sama --}}
        <div>
            <label for="title" class="block mb-2 font-semibold text-gray-700">Judul Buku</label>
            <input 
                id="title" 
                type="text" 
                name="title" 
                value="{{ old('title', $book->title) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                required
            >
            @error('title')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="author" class="block mb-2 font-semibold text-gray-700">Penulis</label>
            <input 
                id="author" 
                type="text" 
                name="author" 
                value="{{ old('author', $book->author) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                required
            >
            @error('author')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publisher" class="block mb-2 font-semibold text-gray-700">Penerbit</label>
            <input 
                id="publisher" 
                type="text" 
                name="publisher" 
                value="{{ old('publisher', $book->publisher) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
            >
            @error('publisher')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publication_year" class="block mb-2 font-semibold text-gray-700">Tahun Terbit</label>
            <input 
                id="publication_year" 
                type="number" 
                name="publication_year" 
                value="{{ old('publication_year', $book->publication_year) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                min="0"
            >
            @error('publication_year')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category" class="block mb-2 font-semibold text-gray-700">Kategori</label>
            <input 
                id="category" 
                type="text" 
                name="category" 
                value="{{ old('category', $book->category) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
            >
            @error('category')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="stock" class="block mb-2 font-semibold text-gray-700">Jumlah Stok</label>
            <input 
                id="stock" 
                type="number" 
                name="stock" 
                value="{{ old('stock', $book->stock) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                min="0"
                required
            >
            @error('stock')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="max_loan_days" class="block mb-2 font-semibold text-gray-700">Maksimal Waktu Pinjam (hari)</label>
            <input 
                id="max_loan_days" 
                type="number" 
                name="max_loan_days" 
                value="{{ old('max_loan_days', $book->max_loan_days) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                min="0"
                required
            >
            @error('max_loan_days')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="fine_per_day" class="block mb-2 font-semibold text-gray-700">Denda per Hari</label>
            <input 
                id="fine_per_day" 
                type="number" 
                name="fine_per_day" 
                value="{{ old('fine_per_day', $book->fine_per_day) }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                min="0"
                step="0.01"
            >
            @error('fine_per_day')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none"
            >{{ old('description', $book->description) }}</textarea>
            @error('description')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Simpan --}}
        <button 
            type="submit" 
            class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 rounded-md shadow transition"
        >
            Simpan Perubahan
        </button>

        {{-- Tombol Kembali --}}
        <a href="{{ url()->previous() }}" 
           class="block text-center mt-3 text-orange-600 hover:text-orange-800 font-semibold">
           &larr; Kembali
        </a>
    </form>
</div>
@endsection
