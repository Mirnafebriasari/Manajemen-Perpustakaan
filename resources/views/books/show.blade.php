@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-pink-50 to-purple-50 py-8">
    <div class="container mx-auto px-4 max-w-6xl">

        {{-- Tombol Kembali ke Dashboard --}}
        <div class="mb-6">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center bg-orange-400 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                @elseif(auth()->user()->hasRole('pegawai'))
                    <a href="{{ route('pegawai.dashboard') }}" 
                       class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                @elseif(auth()->user()->hasRole('mahasiswa'))
                    <a href="{{ route('mahasiswa.dashboard') }}" 
                       class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                @endif
            @else
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            @endauth
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
        <div class="lg:col-span-1">
            <div class="bg-transparent rounded-xl shadow-lg overflow-hidden sticky top-6">
                {{-- Cover Image --}}
                <div class="h-96 w-full overflow-hidden">
                    <img src="{{ $book->photo ? asset('storage/book_photos/' . $book->photo) : asset('images/book-placeholder.png') }}"
                        alt="Cover {{ $book->title }}"
                        class="object-cover w-full h-full"
                        onerror="this.src='{{ asset('images/book-placeholder.png') }}'">
                </div>
        
        {{-- Category Badge --}}
        <div class="bg-transparent p-4 text-black">
            <span class="inline-block px-3 py-1 bg-orange-400 rounded-full text-sm font-semibold mb-2">
               Kategori: {{ $book->category }}
            </span>
            <h2 class="font-bold text-xl">Judul: {{ $book->title }}</h2>
            <p class="text-black-100 mt-1">Penulis: {{ $book->author }}</p>
        </div>

        {{-- Rating --}}
        <div class="p-4 bg-orange-100 text-center">
            <div class="flex items-center justify-center text-orange-600 mb-1">
                <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="font-bold text-3xl">{{ number_format($book->rating ?? 0, 1) }}</span>
            </div>
            <p class="text-sm text-gray-600">Rating Buku</p>
        </div>
    </div>
</div>


            {{-- Right Column - Book Details & Actions --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Book Information --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Buku
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1">Penerbit</p>
                            <p class="font-semibold text-gray-900">{{ $book->publisher }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1">Tahun Terbit</p>
                            <p class="font-semibold text-gray-900">{{ $book->publication_year }}</p>
                        </div>
                      
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-green-600 mb-1">Stok Saat Ini</p>
                            <p class="font-bold text-green-900 text-xl">{{ $stokSaatIni ?? $book->stock }} buku</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-sm text-purple-600 mb-1">Maksimal Pinjam</p>
                            <p class="font-bold text-purple-900 text-xl">{{ $book->max_loan_days }} hari</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4 md:col-span-2">
                            <p class="text-sm text-red-600 mb-1">Denda per Hari</p>
                            <p class="font-bold text-red-900 text-xl">Rp {{ number_format($book->fine_per_day, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($book->description)
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Deskripsi
                            </h3>
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    @endif
                </div>

                {{-- Loan/Reservation Actions --}}
                @auth
                @if(auth()->user()->hasRole('mahasiswa'))

                @php
                    $userHasFine = auth()->user()->loans()->where('fine_amount', '>', 0)->exists();
                @endphp

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Aksi Peminjaman
                    </h2>

                    @if(($stokSaatIni ?? $book->stock) > 0)
                        @if($userHasFine)
                            {{-- Jika ada denda, tombol disable dan muncul pesan --}}
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6">
                                <div class="flex items-center mb-4">
                                    <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M6.343 6.343l12.728 12.728"/>
                                    </svg>
                                    <div>
                                        <p class="text-yellow-800 font-bold text-lg">Tidak Bisa Meminjam</p>
                                        <p class="text-yellow-600 text-sm">Anda tidak bisa meminjam buku karena masih memiliki denda yang belum lunas.</p>
                                    </div>
                                </div>
                                <button type="button" disabled
                                    class="w-full bg-yellow-400 text-white font-bold px-6 py-4 rounded-lg cursor-not-allowed opacity-60 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Pinjam Buku Sekarang
                                </button>
                            </div>
                        @else
                            {{-- Jika tidak ada denda, tombol aktif --}}
                            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg p-6">
                                <div class="flex items-center mb-4">
                                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-green-800 font-bold text-lg">Buku Tersedia</p>
                                        <p class="text-green-600 text-sm">Anda dapat meminjam buku ini sekarang</p>
                                    </div>
                                </div>
                                <form action="{{ route('mahasiswa.loans.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold px-6 py-4 rounded-lg transition duration-200 shadow-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        Pinjam Buku Sekarang
                                    </button>
                                </form>
                            </div>
                        @endif

                    @else
                        {{-- Jika stok habis --}}
                        <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-red-800 font-bold text-lg">Stok Buku Habis</p>
                                    <p class="text-red-600 text-sm">Semua buku sedang dipinjam</p>
                                </div>
                            </div>

                            @php
                                $alreadyReserved = \App\Models\Reservation::where('user_id', auth()->id())
                                    ->where('book_id', $book->id)
                                    ->where('status', 'pending')
                                    ->first();
                            @endphp

                            @if($alreadyReserved)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <p class="text-blue-800 font-semibold">Reservasi Sudah Dibuat</p>
                                            <p class="text-blue-600 text-sm">{{ $alreadyReserved->reserved_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('mahasiswa.reservations.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold px-6 py-4 rounded-lg transition duration-200 shadow-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
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
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Ulasan Buku
                    </h2>

                    @if($reviews->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <p class="text-gray-500 font-semibold">Belum ada ulasan untuk buku ini</p>
                            <p class="text-gray-400 text-sm mt-1">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($reviews as $review)
                                <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center bg-orange-100 px-3 py-1 rounded-full">
                                            <svg class="w-5 h-5 text-orange-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="font-bold text-orange-700">{{ number_format($review->rating, 1) }}</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection