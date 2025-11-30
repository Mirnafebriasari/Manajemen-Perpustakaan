@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-12 max-w-7xl">

        {{-- Modern Hero Header --}}
        <div class="relative mb-16">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10 rounded-3xl blur-3xl"></div>
            <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-10 overflow-hidden">
                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-pink-500/20 to-orange-500/20 rounded-full blur-3xl"></div>
                
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-tr from-blue-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl transform rotate-6 hover:rotate-12 transition-transform duration-500">
                            <svg class="w-10 h-10 text-white -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-5xl font-black mb-2">
                                <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    Dashboard Pegawai
                                </span>
                            </h1>
                            <p class="text-lg text-gray-600">
                                Selamat datang kembali, 
                                <span class="font-bold text-blue-600">{{ auth()->user()->name }}</span>
                            </p>
                        </div>
                    </div>
                    
                    {{-- Current Time Widget --}}
                    <div class="hidden lg:block text-right">
                        <div class="bg-gradient-to-r from-blue-100 to-purple-100 rounded-2xl px-6 py-3">
                            <p class="text-sm font-bold text-gray-600 uppercase tracking-wide">{{ now()->format('l') }}</p>
                            <p class="text-2xl font-black text-blue-600">{{ now()->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modern Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            {{-- Total Peminjaman --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-8 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Total Peminjaman</p>
                            <p class="text-5xl font-black bg-gradient-to-r from-orange-600 to-pink-600 bg-clip-text text-transparent">
                                {{ \App\Models\Loan::count() }}
                            </p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-100 to-pink-100 rounded-2xl">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Buku --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-green-600 to-emerald-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-8 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Total Buku</p>
                            <p class="text-5xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                {{ \App\Models\Book::count() }}
                            </p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notifikasi --}}
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-600 to-orange-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                <div class="relative bg-white rounded-3xl shadow-xl p-8 transform group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Notifikasi Baru</p>
                            <p class="text-5xl font-black bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                                {{ $notifications->count() }}
                            </p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions Section --}}
       
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Manajemen Peminjaman --}}
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white rounded-3xl shadow-xl p-8 border border-gray-100 transform group-hover:-translate-y-1 transition-all duration-500 flex flex-col min-h-[300px]">
                        <div class="flex items-start mb-6 flex-1">
                            <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-2xl mr-5 flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-black text-gray-900 mb-2">Manajemen Peminjaman</h3>
                                <p class="text-gray-600 leading-relaxed">Kelola peminjaman dan pengembalian buku dengan sistem yang efisien</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ url('/pegawai/loans') }}"
                               class="group/btn relative overflow-hidden px-6 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-2xl font-bold text-gray-800 text-center transition-all duration-300 shadow-md hover:shadow-lg">
                                <span class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Daftar Pinjaman
                                </span>
                            </a>
                            <a href="{{ url('/pegawai/reservations') }}"
                               class="group/btn relative overflow-hidden px-6 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 rounded-2xl font-bold text-white text-center transition-all duration-300 shadow-lg hover:shadow-xl">
                                <span class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Reservasi
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kelola Buku --}}
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 to-pink-600 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white rounded-3xl shadow-xl p-8 border border-gray-100 transform group-hover:-translate-y-1 transition-all duration-500 flex flex-col min-h-[300px]">
                        <div class="flex items-start mb-6 flex-1">
                            <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-100 to-pink-100 rounded-2xl mr-5 flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-black text-gray-900 mb-2">Kelola Koleksi Buku</h3>
                                <p class="text-gray-600 leading-relaxed">Tambah, edit, dan kelola data buku perpustakaan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('pegawai.books.create') }}"
                               class="group/btn relative overflow-hidden px-6 py-4 bg-gradient-to-r from-orange-600 to-pink-600 hover:from-orange-700 hover:to-pink-700 rounded-2xl font-bold text-white text-center transition-all duration-300 shadow-lg hover:shadow-xl">
                                <span class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Buku
                                </span>
                            </a>
                            <a href="{{ route('pegawai.books.index') }}"
                               class="group/btn relative overflow-hidden px-6 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-2xl font-bold text-gray-800 text-center transition-all duration-300 shadow-md hover:shadow-lg">
                                <span class="relative flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    Daftar Buku
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifikasi Modern --}}
        <div class="relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-yellow-600/20 to-orange-600/20 rounded-3xl blur-2xl"></div>
            <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-8">
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl">
                            <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-black text-gray-900">Notifikasi Sistem</h2>
                    </div>
                    @if($notifications->isNotEmpty())
                        <form action="{{ route('pegawai.notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @forelse($notifications as $notif)
                        <div class="group relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-orange-600/20 to-pink-600/20 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
                            <div class="relative bg-gradient-to-r from-orange-50 to-pink-50 border-l-4 border-orange-500 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-pink-500 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-900 font-bold text-base mb-2">{{ $notif->data['message'] ?? 'Notifikasi Tanpa Pesan' }}</p>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border-2 border-dashed border-gray-200">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <p class="text-gray-900 text-xl font-black mb-2">Tidak Ada Notifikasi</p>
                            <p class="text-gray-500 text-sm">Semua pemberitahuan penting akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection