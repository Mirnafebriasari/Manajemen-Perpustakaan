@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 py-10 px-4">
    <div class="max-w-lg mx-auto">

        <div class="bg-white shadow-xl rounded-2xl p-8 border border-orange-200">
            <h1 class="text-3xl font-bold text-orange-700 mb-6 text-center">
                Ganti Password
            </h1>

            {{-- Notifikasi Berhasil --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                {{-- Password Saat Ini --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Password Saat Ini</label>
                    <input 
                        type="password" 
                        name="current_password" 
                        required
                        class="w-full p-3 rounded-lg border shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none @error('current_password') border-red-600 @enderror"
                    >
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Password Baru</label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full p-3 rounded-lg border shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none @error('password') border-red-600 @enderror"
                    >
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Konfirmasi Password Baru</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required
                        class="w-full p-3 rounded-lg border shadow-sm focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    >
                </div>

                {{-- Tombol Submit --}}
                <button 
                    type="submit" 
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2.5 rounded-lg shadow-md transition-all font-semibold"
                >
                    Ubah Password
                </button>
            </form>

            {{-- Tombol Kembali --}}
            <div class="mt-6">
                @if(auth()->user()->hasRole('mahasiswa'))
                    <a 
                        href="{{ route('mahasiswa.dashboard') }}" 
                        class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-2.5 rounded-lg shadow-sm transition-all font-semibold"
                    >
                        ← Kembali ke Dashboard
                    </a>
                @else
                    <a 
                        href="{{ url()->previous() }}" 
                        class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-2.5 rounded-lg shadow-sm transition-all font-semibold"
                    >
                        ← Kembali
                    </a>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
