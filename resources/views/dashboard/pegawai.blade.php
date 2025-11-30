@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-10 border-t-8 border-orange-500">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 dark:text-white mb-2 tracking-tight">
                <i class="fas fa-chart-line mr-3 text-orange-500"></i> Dashboard Pegawai
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Selamat datang di pusat kendali, <span class="font-bold text-orange-600 dark:text-orange-400">{{ auth()->user()->name }}</span>.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 transition duration-500 ease-in-out transform hover:scale-[1.02] border-l-4 border-orange-500">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Peminjaman</p>
                        <p class="text-5xl font-extrabold text-orange-600 dark:text-orange-400">
                            {{ \App\Models\Loan::count() }}
                        </p>
                    </div>
                    <div class="bg-orange-100 dark:bg-orange-900 rounded-xl p-3">
                        <i class="fas fa-book-reader fa-2x text-orange-500 dark:text-orange-300"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-600 mt-4">Keseluruhan transaksi peminjaman.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 transition duration-500 ease-in-out transform hover:scale-[1.02] border-l-4 border-green-500">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Buku</p>
                        <p class="text-5xl font-extrabold text-green-600 dark:text-green-400">
                            {{ \App\Models\Book::count() }}
                        </p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 rounded-xl p-3">
                        <i class="fas fa-book fa-2x text-green-500 dark:text-green-300"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-600 mt-4">Keseluruhan koleksi buku perpustakaan.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 transition duration-500 ease-in-out transform hover:scale-[1.02] border-l-4 border-yellow-500">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Notifikasi Baru</p>
                        <p class="text-5xl font-extrabold text-yellow-600 dark:text-yellow-400">
                            {{ $notifications->count() }}
                        </p>
                    </div>
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-xl p-3">
                        <i class="fas fa-bell fa-2x text-yellow-500 dark:text-yellow-300"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-600 mt-4">Pemberitahuan penting yang belum dibaca.</p>
            </div>
        </div>

        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 transition duration-300 hover:shadow-2xl">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 dark:bg-green-900 rounded-full p-3 mr-4">
                        <i class="fas fa-exchange-alt fa-lg text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Manajemen Peminjaman</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-5 text-sm">Kelola peminjaman dan pengembalian buku.</p>
                <div class="space-y-3">
                    <a href="{{ url('/pegawai/loans/create') }}"
                        class="block w-full text-center py-3 rounded-xl font-semibold bg-green-500 text-white hover:bg-green-600 transition duration-200 shadow-md shadow-green-300/50">
                        Buat Peminjaman Baru
                    </a>
                    <a href="{{ url('/pegawai/loans') }}"
                        class="block w-full text-center py-3 rounded-xl font-semibold bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition duration-200">
                        Lihat Daftar Peminjaman
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 transition duration-300 hover:shadow-2xl">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 dark:bg-orange-900 rounded-full p-3 mr-4">
                        <i class="fas fa-warehouse fa-lg text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Kelola Koleksi Buku</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-5 text-sm">Tambah, ubah, dan kelola data koleksi buku.</p>
                <div class="space-y-3">
                    <a href="{{ route('pegawai.books.create') }}"
                        class="block w-full text-center py-3 rounded-xl font-semibold bg-orange-500 text-white hover:bg-orange-600 transition duration-200 shadow-md shadow-orange-300/50">
                        Tambah Buku Baru
                    </a>
                    <a href="{{ route('pegawai.books.index') }}"
                        class="block w-full text-center py-3 rounded-xl font-semibold bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition duration-200">
                        Lihat Daftar Buku
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 flex flex-col items-center justify-center transition duration-300 hover:shadow-2xl">
                <div class="text-center mb-5">
                    <div class="bg-purple-100 dark:bg-purple-900 rounded-full p-4 mx-auto w-16 h-16 flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-check fa-2x text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Reservasi Buku</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Lihat daftar reservasi buku.</p>
                </div>
                <a href="{{ url('/pegawai/reservations') }}"
                    class="block w-full text-center py-3 rounded-xl font-extrabold bg-purple-500 text-white hover:bg-purple-600 transition duration-200 shadow-lg shadow-purple-400/50 transform hover:scale-[1.03]">
                    Daftar Reservasi
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-6 sm:p-8">
            <div class="mb-6 flex items-center justify-between border-b pb-4 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-full p-3 mr-4">
                        <i class="fas fa-exclamation-triangle fa-lg text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Notifikasi Sistem</h2>
                </div>
                @if($notifications->isNotEmpty())
                <form action="{{ route('pegawai.notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-300 font-semibold transition duration-200">
                        Tandai Semua Dibaca
                    </button>
                </form>
                @endif
            </div>

            <div class="space-y-4">
                @forelse($notifications as $notif)
                    <div class="bg-gray-50 dark:bg-gray-700 border-l-4 border-orange-500 rounded-xl p-5 transition duration-300 hover:shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-info-circle fa-lg text-orange-500"></i>
                            </div>
                            <div class="flex-1 ml-4">
                                <p class="text-gray-800 dark:text-white font-semibold text-base mb-1">{{ $notif->data['message'] ?? 'Notifikasi Tanpa Pesan' }}</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <i class="far fa-clock mr-1"></i>
                                    <span>{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-gray-100 dark:bg-gray-700 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                        <i class="fas fa-inbox fa-3x text-gray-300 dark:text-gray-500 mx-auto mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-300 text-xl font-semibold mb-2">Tidak ada notifikasi baru</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm">Semua pemberitahuan penting akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection