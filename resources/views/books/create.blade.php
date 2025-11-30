@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 py-12 px-4">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            <h1 class="text-4xl font-bold text-orange-600 mb-2">Tambah Buku Baru</h1>
            <p class="text-gray-600">Lengkapi informasi buku untuk menambahkan ke koleksi perpustakaan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Informasi Buku Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-orange-600 mb-6 pb-2 border-b-2 border-orange-200">
                        Informasi Buku
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Judul Buku <span class="text-orange-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('title') border-red-500 @enderror" 
                                   placeholder="Masukkan judul buku"
                                   required>
                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Penulis <span class="text-orange-500">*</span>
                                </label>
                                <input type="text" 
                                       name="author" 
                                       value="{{ old('author') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('author') border-red-500 @enderror" 
                                       placeholder="Nama penulis"
                                       required>
                                @error('author')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Penerbit <span class="text-orange-500">*</span>
                                </label>
                                <input type="text" 
                                       name="publisher" 
                                       value="{{ old('publisher') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('publisher') border-red-500 @enderror" 
                                       placeholder="Nama penerbit"
                                       required>
                                @error('publisher')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tahun Terbit <span class="text-orange-500">*</span>
                                </label>
                                <input type="number" 
                                       name="publication_year" 
                                       value="{{ old('publication_year') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('publication_year') border-red-500 @enderror" 
                                       placeholder="2024"
                                       required>
                                @error('publication_year')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kategori <span class="text-orange-500">*</span>
                                </label>
                                <input type="text" 
                                       name="category" 
                                       value="{{ old('category') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('category') border-red-500 @enderror" 
                                       placeholder="Fiksi, Non-Fiksi, dll"
                                       required>
                                @error('category')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none resize-none @error('description') border-red-500 @enderror" 
                                      placeholder="Deskripsi singkat tentang buku...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Foto Buku -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Foto Buku
                            </label>
                            <input type="file" 
                                   name="photo" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('photo') border-red-500 @enderror" />
                            @error('photo')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Peminjaman Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-orange-600 mb-6 pb-2 border-b-2 border-orange-200">
                        Informasi Peminjaman
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok <span class="text-orange-500">*</span>
                            </label>
                            <input type="number" 
                                   name="stock" 
                                   value="{{ old('stock') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('stock') border-red-500 @enderror" 
                                   placeholder="0"
                                   required>
                            @error('stock')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Maks. Hari Pinjam <span class="text-orange-500">*</span>
                            </label>
                            <input type="number" 
                                   name="max_loan_days" 
                                   value="{{ old('max_loan_days') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('max_loan_days') border-red-500 @enderror" 
                                   placeholder="7"
                                   required>
                            @error('max_loan_days')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Denda/Hari (Rp) <span class="text-orange-500">*</span>
                            </label>
                            <input type="number" 
                                   name="fine_per_day" 
                                   value="{{ old('fine_per_day') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none @error('fine_per_day') border-red-500 @enderror" 
                                   placeholder="5000"
                                   required>
                            @error('fine_per_day')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t-2 border-gray-100">
                    @auth
                        @php
                            if(auth()->user()->hasRole('admin')) {
                                $backRoute = route('admin.dashboard');
                            } elseif(auth()->user()->hasRole('pegawai')) {
                                $backRoute = route('pegawai.dashboard');
                            } elseif(auth()->user()->hasRole('mahasiswa')) {
                                $backRoute = route('mahasiswa.dashboard');
                            } else {
                                $backRoute = url('/');
                            }
                        @endphp
                    @else
                        @php
                            $backRoute = url('/');
                        @endphp
                    @endauth

                    <a href="{{ $backRoute }}" 
                       class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg shadow transition duration-200">
                        ← Kembali
                    </a>

                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-orange-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Simpan Buku
                    </button>
                </div>

            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-4">
            <p class="text-sm text-orange-800">
                <span class="font-semibold">Catatan:</span> Pastikan semua informasi yang dimasukkan sudah benar sebelum menyimpan data buku.
            </p>
        </div>
    </div>
</div>
@endsection
