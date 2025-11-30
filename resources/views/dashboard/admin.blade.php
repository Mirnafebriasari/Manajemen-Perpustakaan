@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-12 max-w-7xl">

        {{-- Modern Hero Header --}}
        <div class="relative mb-16">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-600/10 to-red-600/10 rounded-3xl blur-3xl"></div>
            <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-10 overflow-hidden">
                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-amber-500/20 to-orange-500/20 rounded-full blur-3xl"></div>
                
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-tr from-orange-600 via-red-600 to-pink-600 rounded-2xl shadow-2xl transform rotate-6 hover:rotate-12 transition-transform duration-500">
                            <svg class="w-10 h-10 text-white -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-5xl font-black mb-2">
                                <span class="bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 bg-clip-text text-transparent">
                                    Dashboard Administrator
                                </span>
                            </h1>
                            <p class="text-lg text-gray-600">
                                Selamat datang kembali! <span class="font-bold text-orange-600">{{ auth()->user()->name }}</span>
                            </p>
                        </div>
                    </div>
                    
                    {{-- Current Time Widget --}}
                    <div class="hidden lg:block text-right">
                        <div class="bg-gradient-to-r from-orange-100 to-red-100 rounded-2xl px-6 py-3">
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-wide">{{ now()->format('l') }}</p>
                            <p class="text-2xl font-black text-orange-600">{{ now()->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modern Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            {{-- Total Pengguna --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 to-red-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-6 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl">
                            <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                {{ $totalUsers }}
                            </p>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Total Pengguna</h3>
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center text-orange-600 font-bold text-sm hover:text-orange-700 transition-colors group/link">
                        Kelola Pengguna
                        <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Total Buku --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-6 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                {{ $totalBooks }}
                            </p>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Total Buku</h3>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.books.index') }}" 
                           class="inline-flex items-center text-blue-600 font-bold text-sm hover:text-blue-700 transition-colors group/link">
                            Kelola
                            <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <span class="text-gray-300">•</span>
                        <a href="{{ route('admin.books.create') }}" 
                           class="inline-flex items-center text-purple-600 font-bold text-sm hover:text-purple-700 transition-colors">
                            + Tambah
                        </a>
                    </div>
                </div>
            </div>

            {{-- Peminjaman Hari Ini --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-amber-600 to-yellow-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-6 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-amber-100 to-yellow-100 rounded-2xl">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black bg-gradient-to-r from-amber-600 to-yellow-600 bg-clip-text text-transparent">
                                {{ $loansToday }}
                            </p>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Pinjaman Hari Ini</h3>
                    <a href="{{ route('loans.index') }}" 
                       class="inline-flex items-center text-amber-600 font-bold text-sm hover:text-amber-700 transition-colors group/link">
                        Lihat Transaksi
                        <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Daftar Reservasi --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 to-rose-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-6 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl">
                            <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                                {{ $totalReservasi ?? 0 }}
                            </p>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Daftar Reservasi</h3>
                    <a href="{{ url('/admin/reservations') }}" 
                       class="inline-flex items-center text-pink-600 font-bold text-sm hover:text-pink-700 transition-colors group/link">
                        Lihat Reservasi
                        <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Analytics CTA Section --}}
        <div class="relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-orange-600/20 to-red-600/20 rounded-3xl blur-2xl"></div>
            <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-10 overflow-hidden">
                {{-- Decorative Pattern --}}
                <div class="absolute top-0 right-0 w-64 h-64 opacity-5">
                    <svg class="w-full h-full text-orange-600" fill="currentColor" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40"/>
                        <circle cx="20" cy="20" r="15"/>
                        <circle cx="80" cy="80" r="15"/>
                    </svg>
                </div>
                
                <div class="relative grid lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-100 to-red-100 rounded-full mb-4">
                            <span class="flex items-center text-orange-700 font-bold text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                Analytics & Report
                            </span>
                        </div>
                        <h2 class="text-4xl font-black text-gray-900 mb-4">
                            Analisis & Pelaporan 
                            <span class="bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                Sistem
                            </span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            Akses statistik lengkap, tren peminjaman, dan laporan detail operasional perpustakaan dalam satu dashboard terintegrasi.
                        </p>
                        <div class="flex flex-wrap gap-3">
                           

                    <div class="flex justify-center lg:justify-end">
                        <a href="{{ route('admin.analytics') }}"
                           class="group relative inline-flex items-center px-10 py-5 bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 hover:from-orange-700 hover:via-red-700 hover:to-pink-700 text-white font-black text-lg rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 active:scale-95 transition-all duration-300">
                            <svg class="w-6 h-6 mr-3 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>Lihat Analytics</span>
                            <svg class="w-5 h-5 ml-3 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection