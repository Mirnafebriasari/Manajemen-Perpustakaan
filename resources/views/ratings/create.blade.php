@extends('layouts.app')

@section('title', 'Berikan Rating dan Ulasan')

@section('content')
<div class="max-w-lg mx-auto mt-8 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Berikan Rating dan Ulasan untuk: <br>{{ $book->title }}</h1>  {{-- Ganti judul → title --}}

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('reviews.store') }}" method="POST">  {{-- Asumsi route reviews.store, sesuai controller ReviewController --}}
        @csrf

        <div class="mb-4">
            <label for="rating" class="block font-semibold mb-1">Rating (1-5):</label>
            <select name="rating" id="rating" class="w-full border rounded p-2 @error('rating') border-red-500 @enderror" required>
                <option value="">Pilih rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                @endfor
            </select>
            @error('rating')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="comment" class="block font-semibold mb-1">Ulasan (opsional):</label>  {{-- Ganti review → comment, sesuai model Review --}}
            <textarea name="comment" id="comment" rows="4" class="w-full border rounded p-2 @error('comment') border-red-500 @enderror" placeholder="Tulis ulasan kamu di sini...">{{ old('comment') }}</textarea>
            @error('comment')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kirim Rating & Ulasan
        </button>
    </form>
</div>
@endsection