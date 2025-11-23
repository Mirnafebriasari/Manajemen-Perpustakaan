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
              <a href="{{ route('books.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 shadow-md inline-flex items-center">
    <!-- icon svg -->
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
    </svg>
    Katalog Buku
</a>

            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Buku Dipinjam -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm mb-1">Buku Dipinjam</p>
                        <p class="text-3xl font-bold">{{ $activeLoans->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>

            <!-- Denda -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm mb-1">Total Denda</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($totalFine, 0, ',', '.') }}</p>
                    </div>
                    <svg class="w-12 h-12 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Notifikasi -->
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm mb-1">Notifikasi</p>
                        <p class="text-3xl font-bold">{{ $notifications->count() }}</p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
            </div>

            <!-- Reservasi -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm mb-1">Reservasi</p>
                        <p class="text-3xl font-bold">{{ isset($reservations) ? $reservations->count() : 0 }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Buku yang Dipinjam -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-3">Buku yang Dipinjam</h2>
                    </div>

                    @if ($activeLoans->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-gray-500 text-lg">Anda belum meminjam buku</p>
                            <a href="{{ route('books.index') }}" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                                Jelajahi Buku
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b">
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Judul Buku</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tgl Pinjam</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Jatuh Tempo</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($activeLoans as $loan)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $loan->book->title }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $loan->loan_date ? $loan->loan_date->format('d M Y') : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $loan->due_date ? $loan->due_date->format('d M Y') : 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            @if ($loan->fine_amount > 0)
                                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                                    Denda Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                                    On Time
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            @if (!$loan->is_extended && now()->lt($loan->due_date))
                                                <form method="POST" action="{{ route('mahasiswa.loans.extend', $loan->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200">
                                                        Perpanjang
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-l-4 border-purple-500 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800">{{ $loan->book->title }}</h3>
                                            <div class="flex items-center text-sm text-gray-600 mt-2 space-x-4">
                                                <span>📅 Dipinjam: {{ $loan->loan_date ? $loan->loan_date->format('d M Y') : 'N/A' }}</span>
                                                <span>✅ Dikembalikan: {{ $loan->return_date ? $loan->return_date->format('d M Y') : 'Belum dikembalikan' }}</span>
                                            </div>
                                        </div>
                                        @if ($loan->return_date)
                                            @if (!$loan->review)
                                                <a href="{{ route('loans.review', $loan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 ml-4">
                                                    ⭐ Beri Ulasan
                                                </a>
                                            @else
                                                <span class="text-green-600 text-sm font-semibold ml-4">✓ Sudah diulas</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Rekomendasi Buku -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 ml-3">Rekomendasi Buku</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($recommendations as $book)
                            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 hover:shadow-md transition duration-200 border border-indigo-100">
                                <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-600 mb-1">👤 {{ $book->author }}</p>
                                <p class="text-sm text-gray-600 mb-1">📚 {{ $book->category }}</p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-yellow-500 font-semibold">⭐ {{ $book->average_rating ?? 'Belum ada' }}/5</span>
                                    <a href="{{ route('mahasiswa.books.show', $book->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Status Denda -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 ml-3">Status Denda</h2>
                    </div>

                    @if ($totalFine > 0)
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <p class="text-red-700 font-bold text-xl mb-2">
                                Rp {{ number_format($totalFine, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-red-600">
                                ⚠️ Peminjaman baru diblokir hingga denda dilunasi
                            </p>
                        </div>
                    @else
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg text-center">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-green-700 font-semibold">Tidak ada denda</p>
                        </div>
                    @endif
                </div>

                <!-- Reservasi -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 ml-3">Reservasi</h2>
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
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 ml-3">Notifikasi</h2>
                    </div>

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

                <!-- Profil & Pengaturan -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 ml-3">Akun</h2>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('profile.edit') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-3 rounded-lg font-semibold transition duration-200 text-center">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Profil
                        </a>
                        <a href="{{ route('password.change') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-3 rounded-lg font-semibold transition duration-200 text-center">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection