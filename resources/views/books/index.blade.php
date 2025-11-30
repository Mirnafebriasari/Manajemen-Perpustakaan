@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Katalog Buku</h1>
        <p class="text-gray-600">Temukan buku favorit Anda di perpustakaan kami</p>
    </div>

    {{-- ================================
        AUTO SELECT ROUTE INDEX SESUAI ROLE
    ================================ --}}
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
            $indexRoute = 'books.index'; // guest
        }
    @endphp

    {{-- FORM FILTER --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form method="GET" action="{{ route($indexRoute) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Search Input --}}
            <div class="md:col-span-2">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari judul, penulis, atau kategori..."
                        value="{{ request('search') }}"
                        class="block w-full pl-4 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200"
                    >
                </div>
            </div>

            {{-- Category Filter --}}
            <div>
                <select name="category" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 transition duration-200">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sort --}}
            <div>
                <select name="sort" 
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 transition duration-200">
                    <option value="">Urutkan</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                    <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Penulis A-Z</option>
                    <option value="publication_year" {{ request('sort') == 'publication_year' ? 'selected' : '' }}>Tahun Terbit</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                </select>
            </div>

            <div class="md:col-span-4 flex flex-wrap gap-2">

                {{-- Tombol Terapkan Filter --}}
                <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg shadow-lg transition duration-200">
                    Terapkan Filter
                </button>

                {{-- Tombol Reset --}}
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route($indexRoute) }}" 
                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition duration-200">
                        Reset Filter
                    </a>
                @endif

                {{-- Tombol KEMBALI (diletakkan dekat filter) --}}
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" 
                            class="px-6 py-3 bg-orange-400 hover:bg-orange-500 text-white font-semibold rounded-lg transition duration-200">
                            ← Kembali
                        </a>
                    @elseif(auth()->user()->hasRole('pegawai'))
                        <a href="{{ route('pegawai.dashboard') }}" 
                            class="px-6 py-3 bg-orange-400 hover:bg-orange-500 text-white font-semibold rounded-lg transition duration-200">
                            ← Kembali
                        </a>
                    @elseif(auth()->user()->hasRole('mahasiswa'))
                        <a href="{{ route('mahasiswa.dashboard') }}" 
                            class="px-6 py-3 bg-orange-400 hover:bg-orange-500 text-white font-semibold rounded-lg transition duration-200">
                            ← Kembali
                        </a>
                    @endif
                @else
                    <a href="{{ url('/') }}" 
                        class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition duration-200">
                        ← Kembali
                    </a>
                @endauth

            </div>
        </form>
    </div>

    {{-- GRID LIST BUKU --}}
    @if($books->isEmpty())
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada buku ditemukan</h3>
            <p class="text-gray-600 mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
            <a href="{{ route($indexRoute) }}" class="inline-block text-orange-600 hover:text-orange-700 font-medium">
                Reset Filter
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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

                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-4 text-white">
                        <span class="inline-block px-2 py-1 bg-white bg-opacity-30 rounded text-xs font-semibold mb-2">
                            {{ $book->category }}
                        </span>
                        <h2 class="font-bold text-lg leading-tight line-clamp-2">{{ $book->title }}</h2>
                    </div>

                    <div class="p-4">
                        <p class="text-sm text-gray-600">{{ $book->author }}</p>
                        <p class="text-sm text-gray-600">Tahun {{ $book->publication_year }}</p>

                        <div class="flex items-center justify-between mt-3">
                            <span class="text-sm text-gray-600">Stok:</span>
                            <span class="font-semibold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $book->stock > 0 ? $book->stock . ' buku' : 'Habis' }}
                            </span>
                        </div>

                        <a href="{{ route($showRoute, $book->id) }}" 
                           class="block w-full text-center mt-4 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg">
                            Lihat Detail
                        </a>

                        {{-- Tombol Edit & Delete --}}
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

                            <div class="flex gap-2 mt-3">
                                <a href="{{ $editRoute }}" 
                                    class="flex-1 text-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg">
                                    Edit
                                </a>

                                <form action="{{ $deleteRoute }}" method="POST" class="flex-1"
                                    onsubmit="return confirm('Yakin ingin menghapus buku {{ $book->title }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>

            @endforeach
        </div>
    @endif

    {{-- Pagination --}}
    @if($books->hasPages())
        <div class="mt-8">
            {{ $books->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection
