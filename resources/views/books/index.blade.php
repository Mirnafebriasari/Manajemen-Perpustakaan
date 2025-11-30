@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-indigo-50">
    <div class="container mx-auto px-4 py-12 max-w-7xl">

        {{-- Modern Hero Header --}}
        <div class="relative mb-16">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-600/10 to-red-600/10 rounded-3xl blur-3xl"></div>
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-tr from-orange-600 via-red-600 to-pink-600 rounded-2xl rotate-6 shadow-2xl mb-6 hover:rotate-12 transition-transform duration-500">
                    <svg class="w-12 h-12 text-white -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-6xl md:text-7xl font-black mb-4">
                    <span class="bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 bg-clip-text text-transparent">
                        Katalog Buku
                    </span>
                </h1>
                <p class="text-xl text-gray-600 font-medium max-w-2xl mx-auto">
                    Temukan buku impianmu dari ribuan koleksi terbaik
                </p>
            </div>
        </div>

        {{-- AUTO SELECT ROUTE INDEX SESUAI ROLE --}}
        @php
            if (auth()->check()) {
                if (auth()->user()->hasRole('admin')) {
                    $indexRoute = 'admin.books.index';
                } elseif (auth()->user()->hasRole('pegawai')) {
                    $indexRoute = 'pegawai.books.index';
                } elseif (auth()->user()->hasRole('mahasiswa')) {
                    $indexRoute = 'mahasiswa.books.index';
                } else {
                    $indexRoute = 'books.index';
                }
            } else {
                $indexRoute = 'books.index';
            }
        @endphp

        {{-- Ultra Modern Filter Card --}}
        <div class="relative mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 to-red-500/20 rounded-3xl blur-2xl"></div>
            <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-8">
                <form method="GET" action="{{ route($indexRoute) }}" class="space-y-6">

                    {{-- Premium Search Bar --}}
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="relative flex items-center">
                            <div class="absolute left-5 pointer-events-none">
                                <svg class="w-7 h-7 text-gray-400 group-focus-within:text-orange-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Ketik untuk mencari buku..."
                                value="{{ request('search') }}"
                                class="w-full pl-16 pr-6 py-5 bg-white border-2 border-gray-200 rounded-2xl focus:border-orange-500 focus:ring-4 focus:ring-orange-200/50 transition-all duration-300 text-lg font-medium placeholder:text-gray-400"
                            >
                        </div>
                    </div>

                    {{-- Modern Filter Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Category Select --}}
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Kategori Buku</label>
                            <div class="relative">
                                <select name="category" 
                                    class="w-full px-5 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-red-500 focus:ring-4 focus:ring-red-200/50 transition-all duration-300 appearance-none font-medium cursor-pointer">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Sort Select --}}
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Urutkan</label>
                            <div class="relative">
                                <select name="sort" 
                                    class="w-full px-5 py-4 bg-white border-2 border-gray-200 rounded-2xl focus:border-pink-500 focus:ring-4 focus:ring-pink-200/50 transition-all duration-300 appearance-none font-medium cursor-pointer">
                                    <option value="">Urutkan Berdasarkan</option>
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                                    <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Penulis A-Z</option>
                                    <option value="publication_year" {{ request('sort') == 'publication_year' ? 'selected' : '' }}>Tahun Terbit</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                                </select>
                                <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-pink-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-4 pt-2">
                        {{-- Apply Button --}}
                        <button type="submit" 
                            class="group relative px-8 py-4 bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 hover:from-orange-700 hover:via-red-700 hover:to-pink-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300">
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari Sekarang
                            </span>
                        </button>

                        {{-- Reset Button --}}
                        @if(request()->hasAny(['search', 'category', 'sort']))
                            <a href="{{ route($indexRoute) }}" 
                               class="group px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl shadow-md hover:shadow-lg transform hover:scale-105 active:scale-95 transition-all duration-300">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Reset
                                </span>
                            </a>
                        @endif

                        {{-- Dashboard Button --}}
                        @auth
                            @php
                                $dashboardRoute = match(true) {
                                    auth()->user()->hasRole('admin') => route('admin.dashboard'),
                                    auth()->user()->hasRole('pegawai') => route('pegawai.dashboard'),
                                    auth()->user()->hasRole('mahasiswa') => route('mahasiswa.dashboard'),
                                    default => url('/')
                                };
                            @endphp
                            
                            <a href="{{ $dashboardRoute }}" 
                                class="group px-8 py-4 bg-orange-600 hover:from-orange-700 hover:to-orange-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Dashboard
                                </span>
                            </a>
                        @else
                            <a href="{{ url('/') }}" 
                                class="group px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Kembali
                                </span>
                            </a>
                        @endauth
                    </div>
                </form>
            </div>
        </div>

        {{-- Books Grid or Empty State --}}
        @if($books->isEmpty())
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-500/10 to-gray-600/10 rounded-3xl blur-2xl"></div>
                <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/50 p-20 text-center">
                    <div class="inline-flex items-center justify-center w-28 h-28 bg-gradient-to-tr from-gray-200 to-gray-300 rounded-3xl mb-8 rotate-6">
                        <svg class="w-16 h-16 text-gray-400 -rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 mb-4">Tidak Ada Hasil</h3>
                    <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">Maaf, kami tidak menemukan buku yang sesuai dengan pencarian Anda</p>
                    <a href="{{ route($indexRoute) }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Tampilkan Semua Buku
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($books as $book)
                    @php
                        if (auth()->check()) {
                            if (auth()->user()->hasRole('admin')) $showRoute = 'admin.books.show';
                            elseif (auth()->user()->hasRole('pegawai')) $showRoute = 'pegawai.books.show';
                            elseif (auth()->user()->hasRole('mahasiswa')) $showRoute = 'mahasiswa.books.show';
                            else $showRoute = 'books.show';
                        } else {
                            $showRoute = 'books.show';
                        }
                    @endphp

                    <div class="group relative">
                        {{-- Glow Effect --}}
                        <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-20 blur-xl transition-all duration-500"></div>
                        
                        <div class="relative bg-white rounded-3xl shadow-xl overflow-hidden transform group-hover:-translate-y-3 group-hover:shadow-2xl transition-all duration-500 border border-gray-100">
                            
                            {{-- Book Cover --}}
                            <div class="relative h-72 overflow-hidden">
                                <img 
                                    src="{{ $book->photo ? asset('storage/book_photos/' . $book->photo) : asset('images/book-placeholder.png') }}"
                                    alt="{{ $book->title }}" 
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                    onerror="this.src='{{ asset('images/book-placeholder.png') }}'"
                                >
                                
                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
                                {{-- Stock Badge --}}
                                <div class="absolute top-4 right-4">
                                    @if($book->stock > 0)
                                        <div class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-black rounded-full shadow-lg backdrop-blur-sm">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $book->stock }} Stok
                                            </span>
                                        </div>
                                    @else
                                        <div class="px-4 py-2 bg-gradient-to-r from-red-500 to-rose-500 text-white text-xs font-black rounded-full shadow-lg backdrop-blur-sm">
                                            Habis
                                        </div>
                                    @endif
                                </div>

                                {{-- Quick View Button --}}
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <a href="{{ route($showRoute, $book->id) }}" 
                                       class="px-6 py-3 bg-white text-gray-900 font-bold rounded-2xl shadow-2xl transform scale-90 group-hover:scale-100 transition-transform duration-300 hover:bg-gray-50">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                            {{-- Book Info --}}
                            <div class="p-6 space-y-4">
                                {{-- Category Badge --}}
                                <span class="inline-block px-4 py-1 bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 text-xs font-bold rounded-full">
                                    Kategori: {{ $book->category }}
                                </span>

                                {{-- Title & Author --}}
                                <div>
                                    <h3 class="font-black text-lg text-gray-900 line-clamp-2 mb-2 group-hover:text-orange-600 transition-colors">
                                      Judul: {{ $book->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600 font-medium">Penulis: {{ $book->author }}</p>
                                </div>

                                {{-- Meta Info --}}
                                <div class="flex items-center justify-between text-sm">
                                    <span class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                       {{ $book->publication_year }}
                                    </span>
                                    <span class="flex items-center font-bold text-yellow-600">
                                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($book->rating ?? 0, 1) }}
                                    </span>
                                </div>

                                {{-- Admin/Pegawai Actions --}}
                                @if(auth()->check() && auth()->user()->hasAnyRole(['admin','pegawai']))
                                    @php
                                        if (auth()->user()->hasRole('admin')) {
                                            $editRoute = route('admin.books.edit', $book->id);
                                            $deleteRoute = route('admin.books.destroy', $book->id);
                                        } else {
                                            $editRoute = route('pegawai.books.edit', $book->id);
                                            $deleteRoute = route('pegawai.books.destroy', $book->id);
                                        }
                                    @endphp

                                    <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-100">
                                        <a href="{{ $editRoute }}" 
                                            class="flex items-center justify-center px-4 py-2.5 bg-orange-50 hover:bg-orange-100 text-orange-700 font-bold rounded-xl transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>

                                        <form action="{{ $deleteRoute }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus buku {{ $book->title }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-bold rounded-xl transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Pagination --}}
        @if($books->hasPages())
            <div class="mt-16">
                {{ $books->withQueryString()->links() }}
            </div>
        @endif

    </div>
</div>
@endsection