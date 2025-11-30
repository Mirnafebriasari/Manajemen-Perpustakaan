@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

{{-- Hero Section dengan Background Image --}}
<div class="relative min-h-screen">
    {{-- Background Image --}}
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('assets/katalog.jpg') }}" 
             alt="Library Background" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/40"></div>
    </div>

    {{-- Content Container --}}
    <div class="relative z-10">
        {{-- Header Section --}}
        <div class="container mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 animate-fade-in drop-shadow-2xl">
                    Perpustakaan Digital
                </h1>
                <p class="text-xl text-white/90 mb-8 drop-shadow-lg">Temukan Buku Favoritmu Disini</p>
                
                {{-- Search Bar --}}
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('home') }}" method="GET" class="relative">
                        <input type="text" 
                               name="search" 
                               placeholder="Cari judul buku, penulis, atau kategori..." 
                               value="{{ $search ?? '' }}"
                               class="w-full px-6 py-4 pr-32 text-lg rounded-full bg-white/90 backdrop-blur-md border-2 border-white/30 focus:border-white focus:ring-4 focus:ring-white/30 transition-all duration-300 shadow-2xl text-gray-800 placeholder-gray-500">
                        <button type="submit" 
                                class="absolute right-2 top-2 px-8 py-2 bg-white/90 backdrop-blur-sm text-gray-800 rounded-full hover:bg-white transition-all duration-300 font-semibold shadow-lg">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            {{-- Search Results Section --}}
            @if(!empty($search))
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-white mb-6 drop-shadow-lg">
                    Hasil pencarian untuk "<span class="text-yellow-300">{{ $search }}</span>"
                </h2>
                
                @if(isset($searchResults) && $searchResults->isEmpty())
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-white/10 backdrop-blur-md rounded-full mb-6 border border-white/20">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-xl text-white drop-shadow-lg">Tidak ada buku ditemukan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($searchResults as $book)
                        <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 overflow-hidden group border border-white/20 hover:bg-white/15">
                            <div class="h-56 relative overflow-hidden rounded-t-xl">
                                @if($book->photo)
                                    <img src="{{ asset('storage/book_photos/' . $book->photo) }}" alt="Cover {{ $book->title }}" class="object-cover object-center w-full h-full group-hover:scale-105 transition-transform duration-300" />
                                @else
                                    <div class="h-56 bg-gradient-to-br from-indigo-500/80 to-purple-600/80 flex items-center justify-center">
                                        <span class="text-white font-bold text-5xl">{{ substr($book->title, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-yellow-300 transition-colors drop-shadow-lg">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-white/90 mb-1 drop-shadow-md"><span class="font-semibold">Penulis:</span> {{ $book->author }}</p>
                                <p class="text-white/90 mb-1 drop-shadow-md"><span class="font-semibold">Kategori:</span> {{ $book->category }}</p>
                                <p class="text-white/90 mb-4 drop-shadow-md">
                                    <span class="font-semibold">Stok:</span> 
                                    <span class="{{ $book->stock == 0 ? 'text-red-300 font-bold' : '' }}">
                                        {{ $book->stock == 0 ? 'Stok Habis' : $book->stock }}
                                    </span>
                                </p>
                                <a href="{{ route('books.show', $book->id) }}" 
                                   class="block w-full text-center px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-800 rounded-lg hover:bg-white transition-all duration-300 font-semibold shadow-lg">
                                    Detail Buku
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

            {{-- Latest Books Section --}}
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-6 drop-shadow-lg">Buku Terbaru</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($latestBooks ?? [] as $book)
                    <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-2 border border-white/20 hover:bg-white/15">
                        <div class="h-56 relative overflow-hidden rounded-t-xl">
                            @if($book->photo)
                                <img src="{{ asset('storage/book_photos/' . $book->photo) }}" alt="Cover {{ $book->title }}" class="object-cover object-center w-full h-full group-hover:scale-105 transition-transform duration-300" />
                            @else
                                <div class="h-56 bg-gradient-to-br from-gray-500/80 to-cyan-600/80 flex items-center justify-center">
                                    <span class="text-white font-bold text-5xl">{{ substr($book->title, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-300 transition-colors line-clamp-2 drop-shadow-lg">
                                {{ $book->title }}
                            </h3>
                            <p class="text-white/90 mb-1 text-sm drop-shadow-md">{{ $book->author }}</p>
                            <p class="text-white/90 mb-3 text-sm drop-shadow-md">
                                <span class="font-semibold">Stok:</span> 
                                <span class="{{ $book->stock == 0 ? 'text-red-300 font-bold' : '' }}">
                                    {{ $book->stock == 0 ? 'Stok Habis' : $book->stock }}
                                </span>
                            </p>
                            <a href="{{ route('books.show', $book->id) }}" 
                               class="block w-full text-center px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-800 rounded-lg hover:bg-white transition-all duration-300 text-sm font-semibold shadow-lg">
                                Detail Buku
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Popular Books Section --}}
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-6 drop-shadow-lg">Buku Populer</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($popularBooks ?? [] as $book)
                    <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-2 border border-white/20 hover:bg-white/15">
                        <div class="h-56 relative overflow-hidden rounded-t-xl">
                            @if($book->photo)
                                <img src="{{ asset('storage/book_photos/' . $book->photo) }}" alt="Cover {{ $book->title }}" class="object-cover object-center w-full h-full group-hover:scale-105 transition-transform duration-300" />
                            @else
                                <div class="h-56 bg-gradient-to-br from-orange-500/80 to-red-600/80 flex items-center justify-center">
                                    <span class="text-white font-bold text-5xl">{{ substr($book->title, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-orange-300 transition-colors line-clamp-2 drop-shadow-lg">
                                {{ $book->title }}
                            </h3>
                            <p class="text-white/90 mb-1 text-sm drop-shadow-md">{{ $book->author }}</p>
                            <p class="text-orange-300 mb-1 text-sm font-semibold drop-shadow-md">Dipinjam: {{ $book->loans_count }} kali</p>
                            <p class="text-white/90 mb-3 text-sm drop-shadow-md">
                                <span class="font-semibold">Stok:</span> 
                                <span class="{{ $book->stock == 0 ? 'text-red-300 font-bold' : '' }}">
                                    {{ $book->stock == 0 ? 'Stok Habis' : $book->stock }}
                                </span>
                            </p>
                            <a href="{{ route('books.show', $book->id) }}" 
                               class="block w-full text-center px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-800 rounded-lg hover:bg-white transition-all duration-300 text-sm font-semibold shadow-lg">
                                Detail Buku
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Personalized Recommendations Section --}}
            @if(isset($personalizedRecommendations) && $personalizedRecommendations->isNotEmpty())
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-6 drop-shadow-lg">Rekomendasi untuk Anda</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($personalizedRecommendations as $book)
                    <div class="bg-white/10 backdrop-blur-md rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-2 border border-white/20 hover:bg-white/15">
                        <div class="h-56 relative overflow-hidden rounded-t-xl">
                            @if($book->photo)
                                <img src="{{ asset('storage/book_photos/' . $book->photo) }}" alt="Cover {{ $book->title }}" class="object-cover object-center w-full h-full group-hover:scale-105 transition-transform duration-300" />
                            @else
                                <div class="h-56 bg-gradient-to-br from-purple-500/80 to-pink-600/80 flex items-center justify-center">
                                    <span class="text-white font-bold text-5xl">{{ substr($book->title, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-pink-300 transition-colors line-clamp-2 drop-shadow-lg">
                                {{ $book->title }}
                            </h3>
                            <p class="text-white/90 mb-1 text-sm drop-shadow-md">{{ $book->author }}</p>
                            <p class="text-white/90 mb-3 text-sm drop-shadow-md">
                                <span class="font-semibold">Stok:</span> 
                                <span class="{{ $book->stock == 0 ? 'text-red-300 font-bold' : '' }}">
                                    {{ $book->stock == 0 ? 'Stok Habis' : $book->stock }}
                                </span>
                            </p>
                            <a href="{{ route('books.show', $book->id) }}" 
                               class="block w-full text-center px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-800 rounded-lg hover:bg-white transition-all duration-300 text-sm font-semibold shadow-lg">
                                Detail Buku
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

@endsection
