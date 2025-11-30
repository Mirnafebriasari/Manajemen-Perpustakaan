@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 py-12 px-4 flex justify-center">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl">

        {{-- Tombol Kembali --}}
        <a 
            href="{{ route('mahasiswa.dashboard') }}" 
            class="inline-block mb-6 text-orange-600 font-semibold hover:text-orange-700 transition"
        >
            ← Kembali ke Dashboard
        </a>

        {{-- Header --}}
        <h1 class="text-3xl font-bold text-orange-600 mb-6">
            Beri Ulasan untuk Buku: 
            <span class="text-gray-800">{{ $book->title }}</span>
        </h1>

        {{-- Form --}}
        <form action="{{ route('loans.review.store', $loan->id) }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">

            {{-- Rating --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="rating">
                    Rating (1–5)
                </label>
                <select 
                    name="rating" 
                    id="rating" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required
                >
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Komentar --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="comment">
                    Komentar / Ulasan
                </label>
                <textarea 
                    name="comment" 
                    id="comment" 
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    placeholder="Ceritakan pengalamanmu membaca buku ini..."
                ></textarea>
            </div>

            {{-- Button --}}
            <button
                type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition duration-200"
            >
                Kirim Ulasan
            </button>
        </form>

    </div>
</div>
@endsection
