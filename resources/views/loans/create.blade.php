@extends('layouts.app')

@section('title', 'Pinjam Buku')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-4xl font-bold text-orange-600">
                    Pinjam Buku
                </h1>
            </div>

            <p class="text-gray-600 mt-2">
                Pilih buku yang ingin Anda pinjam dari koleksi perpustakaan
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ auth()->user()->hasRole('pegawai') ? route('loans.store') : route('mahasiswa.loans.store') }}" method="POST">
                @csrf

                <!-- Pilih Buku -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilih Buku <span class="text-orange-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="book_id" 
                                required 
                                class="w-full px-4 py-3 pr-10 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none appearance-none bg-white text-gray-800">
                            <option value="" disabled selected>-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" 
                                        {{ old('book_id') == $book->id ? 'selected' : '' }}
                                        {{ $book->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $book->title }} 
                                    @if($book->stock > 0)
                                        (Stok: {{ $book->stock }})
                                    @else
                                        (Stok Habis)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <!-- Custom Arrow -->
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <div class="w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-gray-600"></div>
                        </div>
                    </div>
                    @error('book_id') 
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Jumlah Pinjam -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Jumlah Pinjam <span class="text-orange-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="quantity" 
                        value="{{ old('quantity', 1) }}" 
                        min="1" 
                        max="10" 
                        required 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 outline-none"
                        placeholder="Masukkan jumlah (1-10)"
                    >
                    <p class="mt-2 text-xs text-gray-500">Maksimal 10 buku per peminjaman</p>
                    @error('quantity') 
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="mb-8 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-orange-800 mb-2">Ketentuan Peminjaman</h3>
                    <ul class="text-xs text-orange-700 space-y-1">
                        <li>• Maksimal peminjaman sesuai dengan stok yang tersedia</li>
                        <li>• Pastikan mengembalikan buku tepat waktu</li>
                        <li>• Denda akan dikenakan untuk keterlambatan</li>
                        <li>• Buku yang dipinjam harus dalam kondisi baik</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between gap-4">

                    {{-- Tombol Kembali khusus pegawai di bawah --}}
                    @auth
                        @if(auth()->user()->hasRole('pegawai'))
                            <a href="{{ route('pegawai.dashboard') }}"
                               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold shadow transition">
                               ← Kembali
                            </a>
                        @endif
                    @endauth

                    {{-- Tombol submit --}}
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-orange-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Pinjam Sekarang
                    </button>
                </div>

            </form>
        </div>

        <!-- Additional Info Cards -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-orange-500">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Total Buku Tersedia</h3>
                <p class="text-3xl font-bold text-orange-600">{{ $books->where('stock', '>', 0)->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Buku siap dipinjam</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-blue-500">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Total Stok</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $books->sum('stock') }}</p>
                <p class="text-xs text-gray-500 mt-1">Unit buku dalam koleksi</p>
            </div>
        </div>

    </div>
</div>

<style>
select option:disabled {
    color: #9ca3af;
    font-style: italic;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
}
</style>
@endsection
