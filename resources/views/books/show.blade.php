@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">

    {{-- Tombol Kembali --}}
    @auth
        <div class="mb-6">
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.books.index') }}" 
                   class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">
                    ← Kembali ke Daftar Buku Admin
                </a>
            @elseif(auth()->user()->hasRole('pegawai'))
                <a href="{{ route('pegawai.books.index') }}" 
                   class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">
                    ← Kembali ke Daftar Buku Pegawai
                </a>
            @elseif(auth()->user()->hasRole('mahasiswa'))
                <a href="{{ route('mahasiswa.books.index') }}" 
                   class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">
                    ← Kembali ke Daftar Buku Mahasiswa
                </a>
            @else
                <a href="{{ url()->previous() }}" 
                   class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                    ← Kembali
                </a>
            @endif
        </div>
    @endauth

    {{-- Book Header --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                <p class="text-lg text-gray-600">{{ $book->author }}</p>
            </div>
            <div class="text-center bg-orange-100 rounded-lg px-4 py-2">
                <div class="flex items-center text-orange-600">
                    <span class="text-xl mr-1"></span>
                    <span class="font-bold text-xl">{{ number_format($book->rating ?? 0, 1) }}</span>
                </div>
                <p class="text-xs text-gray-600">Rating</p>
            </div>
        </div>
    </div>

    {{-- Book Details --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Penerbit</p>
                <p class="font-semibold text-gray-900">{{ $book->publisher }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tahun Terbit</p>
                <p class="font-semibold text-gray-900">{{ $book->publication_year }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Kategori</p>
                <p class="font-semibold text-gray-900">{{ $book->category }}</p>
            </div>

            {{-- Stok Awal --}}
            <div>
                <p class="text-sm text-gray-600">Stok Awal</p>
                <p class="font-semibold text-gray-900">{{ $stokAwal ?? $book->stock }} buku</p>
            </div>

            {{-- Jumlah Dipinjam --}}
            <div>
                <p class="text-sm text-gray-600">Jumlah Dipinjam</p>
                <p class="font-semibold text-gray-900">{{ $stokDipinjam ?? 0 }} buku</p>
            </div>

            {{-- Stok Saat Ini --}}
            <div>
                <p class="text-sm text-gray-600">Stok Saat Ini</p>
                <p class="font-semibold text-gray-900">{{ $stokSaatIni ?? $book->stock }} buku</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Maksimal Pinjam</p>
                <p class="font-semibold text-gray-900">{{ $book->max_loan_days }} hari</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Denda per Hari</p>
                <p class="font-semibold text-gray-900">Rp {{ number_format($book->fine_per_day, 0, ',', '.') }}</p>
            </div>
        </div>

        @if($book->description)
            <div class="mt-6 pt-6 border-t">
                <p class="text-sm text-gray-600 mb-2">Deskripsi</p>
                <p class="text-gray-700">{{ $book->description }}</p>
            </div>
        @endif
    </div>

    {{-- Loan/Reservation Actions --}}
    @auth
        @if(auth()->user()->hasRole('mahasiswa'))
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                @if(($stokSaatIni ?? $book->stock) > 0)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800 font-semibold mb-3">✓ Buku Tersedia</p>
                        <form action="{{ route('mahasiswa.loans.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                                Pinjam Buku
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800 font-semibold mb-3">✗ Stok Buku Habis</p>

                        @php
                            $alreadyReserved = \App\Models\Reservation::where('user_id', auth()->id())
                                ->where('book_id', $book->id)
                                ->where('status', 'pending')
                                ->first();
                        @endphp

                        @if($alreadyReserved)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <p class="text-blue-800 text-sm">
                                    ✓ Anda sudah melakukan reservasi pada {{ $alreadyReserved->reserved_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        @else
                            <form action="{{ route('mahasiswa.reservations.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                                    Reservasi Buku
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    @endauth

    {{-- Reviews Section --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Ulasan</h2>

        @if($reviews->isEmpty())
            <p class="text-gray-500 text-center py-8">Belum ada ulasan untuk buku ini</p>
        @else
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                            <div class="flex items-center text-orange-600">
                                <span class="mr-1"></span>
                                <span class="font-semibold">{{ number_format($review->rating, 1) }}</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">{{ $review->created_at->format('d M Y') }}</p>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
