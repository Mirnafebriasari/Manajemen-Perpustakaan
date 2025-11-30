@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-10 border-b pb-4">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Dashboard Administrator</h1>
        <p class="text-gray-600">Selamat datang kembali! Pak Prabowo nitip pesan jangan lupan makan mbg</p>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">

        {{-- TOTAL PENGGUNA --}}
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-xl shadow-xl border-b-4 border-orange-700 hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-users fa-2x text-white"></i>
                </div>
                <span class="text-4xl font-black text-white drop-shadow-md">{{ $totalUsers }}</span>
            </div>
            <h2 class="text-white text-xl font-bold mb-3 uppercase tracking-wider">Total Pengguna</h2>
            <a href="{{ route('users.index') }}" class="inline-flex items-center text-white text-sm font-semibold hover:text-orange-100 transition duration-150">
                Kelola Pengguna
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
        </div>

        {{-- TOTAL BUKU --}}
        <div class="bg-white p-6 rounded-xl shadow-xl border-l-4 border-orange-500 hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-book fa-2x text-orange-600"></i>
                </div>
                <span class="text-4xl font-black text-gray-800">{{ $totalBooks }}</span>
            </div>
            <h2 class="text-gray-800 text-xl font-bold mb-3 uppercase tracking-wider">Total Buku</h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.books.index') }}" class="inline-flex items-center text-orange-600 text-sm font-semibold hover:text-orange-700 transition duration-150">
                    Kelola Buku
                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
                <span class="text-gray-400">|</span>
                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center text-orange-600 text-sm font-semibold hover:text-orange-700 transition duration-150">
                    + Tambah Baru
                </a>
            </div>
        </div>

        {{-- PEMINJAMAN HARI INI --}}
        <div class="bg-gradient-to-br from-orange-400 to-amber-500 p-6 rounded-xl shadow-xl border-b-4 border-amber-600 hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-calendar-day fa-2x text-white"></i>
                </div>
                <span class="text-4xl font-black text-white drop-shadow-md">{{ $loansToday }}</span>
            </div>
            <h2 class="text-white text-xl font-bold mb-3 uppercase tracking-wider">Peminjaman Hari Ini</h2>
            <a href="{{ route('loans.index') }}" class="inline-flex items-center text-white text-sm font-semibold hover:text-orange-100 transition duration-150">
                Lihat Transaksi
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
        </div>

        {{-- DAFTAR RESERVASI --}}
        <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 rounded-xl shadow-xl border-b-4 border-red-700 hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-clipboard-list fa-2x text-white"></i>
                </div>
                <span class="text-4xl font-black text-white drop-shadow-md">{{ $totalReservasi ?? 0 }}</span>
            </div>
            <h2 class="text-white text-xl font-bold mb-3 uppercase tracking-wider">Daftar Reservasi</h2>
            <a href="{{ url('/admin/reservations') }}" class="inline-flex items-center text-white text-sm font-semibold hover:text-red-100 transition duration-150">
                Lihat Reservasi
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </a>
        </div>

    </div>

    
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <h3 class="text-2xl font-bold text-gray-900 mb-1">Analisis & Pelaporan Sistem</h3>
                <p class="text-gray-600 text-base">Akses statistik lengkap, tren, dan laporan detail operasional perpustakaan.</p>
            </div>
            <a href="{{ route('admin.analytics') }}"
               class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-500 to-orange-600 text-white font-bold rounded-full shadow-lg hover:from-red-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-chart-line mr-3"></i>
                Lihat Analytics
            </a>
        </div>
    </div>
</div>

@endsection
