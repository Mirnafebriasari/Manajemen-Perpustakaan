@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 py-8">
    <div class="container mx-auto px-4">

        <!-- Header with User Info -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h1>
                        <p class="text-gray-600">{{ ucfirst($user->role ?? 'Mahasiswa') }}</p>
                    </div>
                </div>
                <a href="{{ route('books.index') }}" 
                   class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 shadow-md inline-flex items-center">
                    Pinjam Buku
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Buku Dipinjam -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover:scale-105 transition duration-300">
                <p class="text-blue-100 text-sm mb-1 font-semibold">Buku Dipinjam</p>
                <p class="text-3xl font-bold">{{ $activeLoans->count() }}</p>
            </div>

            <!-- Denda -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white hover:scale-105 transition duration-300">
                <p class="text-red-100 text-sm mb-1 font-semibold">Total Denda</p>
                <p class="text-2xl font-bold">Rp {{ number_format($totalFine, 0, ',', '.') }}</p>
            </div>

            <!-- Notifikasi -->
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white hover:scale-105 transition duration-300">
                <p class="text-yellow-100 text-sm mb-1 font-semibold">Notifikasi</p>
                <p class="text-3xl font-bold">{{ $notifications->count() }}</p>
            </div>

            <!-- Reservasi -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:scale-105 transition duration-300">
                <p class="text-green-100 text-sm mb-1 font-semibold">Reservasi</p>
                <p class="text-3xl font-bold">{{ isset($reservations) ? $reservations->count() : 0 }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Left Column (Main Content) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Buku yang Dipinjam -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="mb-6 flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg font-semibold text-blue-600">
                            Buku yang Dipinjam
                        </div>
                    </div>

                    @if ($activeLoans->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <p>Anda belum meminjam buku</p>
                            <a href="{{ route('books.index') }}" 
                               class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                                Jelajahi Buku
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($activeLoans as $loan)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition duration-200">
                                    <div class="flex gap-4 p-4">
                                        <!-- Foto Buku dengan style katalog -->
                                        <div class="flex-shrink-0">
                                            <div class="h-40 w-28 overflow-hidden rounded-lg shadow-md">
                                              <img src="{{ $loan->book->photo ? asset('storage/book_photos/' . $loan->book->photo) : asset('images/book-placeholder.png') }}" 
                                                     alt="Cover {{ $loan->book->title }}"
                                                     class="object-cover w-full h-full transition-transform duration-300 hover:scale-105"
                                                     onerror="this.src='{{ asset('images/book-placeholder.png') }}'">
                                            </div>
                                        </div>

                                        <!-- Info Buku -->
                                        <div class="flex-grow">
                                            <div class="mb-2">
                                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                                    {{ $loan->book->category }}
                                                </span>
                                            </div>
                                            <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $loan->book->title }}</h3>
                                            <p class="text-sm text-gray-600 mb-1">Penulis: {{ $loan->book->author }}</p>
                                            <div class="text-sm text-gray-600 space-y-1">
                                                <p><span class="font-semibold">Tanggal Pinjam:</span> {{ $loan->loan_date ? $loan->loan_date->format('d M Y') : 'N/A' }}</p>
                                                <p><span class="font-semibold">Jatuh Tempo:</span> {{ $loan->due_date ? $loan->due_date->format('d M Y') : 'N/A' }}</p>
                                            </div>
                                            
                                            <div class="mt-3 flex items-center justify-between">
                                                <div>
                                                    @if ($loan->fine_amount > 0)
                                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                                            Denda Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                                            Tepat Waktu
                                                        </span>
                                                    @endif
                                                </div>

                                                <div>
                                                    @if (!$loan->is_extended && now()->lt($loan->due_date))
                                                        <form method="POST" action="{{ route('mahasiswa.loans.extend', $loan->id) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200">
                                                                Perpanjang
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Riwayat Peminjaman -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-3">Riwayat Peminjaman</h2>
                    </div>

                    @if ($loanHistory->isEmpty())
                        <p class="text-gray-500 text-center py-8">Belum ada riwayat peminjaman</p>
                    @else
                        <div class="space-y-3">
                            @foreach ($loanHistory as $loan)
                                <div class="border rounded-lg overflow-hidden">
                                    <div class="flex gap-4 p-4">
                                        <!-- Foto Buku -->
                                        <div class="flex-shrink-0">
                                            <div class="h-32 w-24 overflow-hidden rounded-lg shadow-md">
                                                <img src="{{ $loan->book->photo ? asset('storage/book_photos/' . $loan->book->photo) : asset('images/book-placeholder.png') }}"
                                                     alt="Cover {{ $loan->book->title }}"
                                                     class="object-cover w-full h-full transition-transform duration-300 hover:scale-105"
                                                     onerror="this.src='{{ asset('images/book-placeholder.png') }}'">
                                            </div>
                                        </div>

                                        <!-- Info & Aksi -->
                                        <div class="flex-grow flex justify-between items-start">
                                            <div>
                                                <div class="mb-2">
                                                    <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-semibold">
                                                        {{ $loan->book->category }}
                                                    </span>
                                                </div>
                                                <h3 class="font-semibold text-gray-800 mb-1">{{ $loan->book->title }}</h3>
                                                <p class="text-sm text-gray-600 mb-2">{{ $loan->book->author }}</p>
                                                <div class="text-sm text-gray-600">
                                                    <p>Dipinjam: {{ $loan->loan_date ? $loan->loan_date->format('d M Y') : 'N/A' }}</p>
                                                    <p>Dikembalikan: {{ $loan->return_date ? $loan->return_date->format('d M Y') : 'Belum dikembalikan' }}</p>
                                                </div>
                                            </div>

                                            <div class="flex flex-col space-y-2">
                                                @if ($loan->return_date)
                                                    @if (!$loan->review)
                                                        <a href="{{ route('loans.review', $loan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 text-center">
                                                            Beri Ulasan
                                                        </a>
                                                    @else
                                                        <span class="text-green-600 text-sm font-semibold text-center">Sudah diulas</span>
                                                    @endif
                                                @endif

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus riwayat peminjaman ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Rekomendasi Buku -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="mb-6 flex items-center">
                        <div class="p-2 bg-indigo-100 rounded-lg font-semibold text-indigo-600">
                            Rekomendasi Buku
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($recommendations as $book)
                            <div class="bg-white rounded-lg border border-indigo-100 overflow-hidden hover:shadow-lg transition duration-200">
                                <!-- Cover Image dengan style katalog -->
                                <div class="h-48 w-full overflow-hidden">
                                    <img src="{{ $book->photo ? asset('storage/book_photos/' . $book->photo) : asset('images/book-placeholder.png') }}"
                                         alt="Cover {{ $book->title }}"
                                         class="object-cover w-full h-full transition-transform duration-300 hover:scale-105"
                                         onerror="this.src='{{ asset('images/book-placeholder.png') }}'">
                                </div>

                                <!-- Header dengan gradient -->
                                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-3 text-white">
                                    <span class="inline-block px-2 py-1 bg-white bg-opacity-30 rounded text-xs font-semibold mb-1">
                                        {{ $book->category }}
                                    </span>
                                    <h3 class="font-bold text-base leading-tight line-clamp-2">{{ $book->title }}</h3>
                                </div>

                                <!-- Info Buku -->
                                <div class="p-3">
                                    <p class="text-sm text-gray-600 mb-1">{{ $book->author }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-yellow-600 font-semibold text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ $book->average_rating ?? 'N/A' }}/5
                                        </span>
                                        <a href="{{ route('mahasiswa.books.show', $book->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs font-semibold transition duration-200">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Column (Side Info) -->
            <div class="space-y-6">

                <!-- Status Denda -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="mb-4 flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg font-semibold text-red-600">
                            Status Denda
                        </div>
                    </div>

                    @if ($totalFine > 0)
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <p class="text-red-700 font-bold text-xl mb-2">
                                Rp {{ number_format($totalFine, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-red-600">
                                Peminjaman baru diblokir hingga denda dilunasi
                            </p>
                        </div>
                    @else
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg text-center text-green-700 font-semibold">
                            Tidak ada denda
                        </div>
                    @endif
                </div>

                <!-- Reservasi -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="mb-4 flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg font-semibold text-green-600">
                            Reservasi
                        </div>
                    </div>

                    @if (isset($reservations) && $reservations->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada reservasi</p>
                    @elseif(isset($reservations))
                        <div class="space-y-2">
                            @foreach ($reservations->take(3) as $res)
                                <div class="bg-green-50 border-l-4 border-green-500 rounded p-3">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $res->book->title }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $res->reserved_at->format('d M Y H:i') }}</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-green-200 text-green-800 rounded text-xs font-semibold">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('mahasiswa.reservations.index') }}" class="block text-center mt-4 text-green-600 hover:text-green-700 font-semibold text-sm">
                            Lihat Semua Reservasi →
                        </a>
                    @else
                        <p class="text-gray-500 text-center py-4">Data tidak tersedia</p>
                    @endif
                </div>

                <!-- Notifikasi -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="mb-4 flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg font-semibold text-yellow-600">
                            Notifikasi
                        </div>
                    </div>

                    @if($notifications->isNotEmpty())
                        <form action="{{ route('mahasiswa.notifications.markAllAsRead') }}" method="POST" class="mb-4">
                            @csrf
                            <button type="submit" 
                                class="text-sm text-blue-500 hover:text-blue-600 font-semibold transition duration-200">
                                Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif

                    @if ($notifications->isEmpty())
                        <p class="text-gray-500 text-center py-4">Tidak ada notifikasi</p>
                    @else
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach ($notifications as $notification)
                                <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded p-3">
                                    <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? $notification->message }}</p>
                                    <small class="text-xs text-gray-500 mt-1 block">{{ $notification->created_at->diffForHumans() }}</small>
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