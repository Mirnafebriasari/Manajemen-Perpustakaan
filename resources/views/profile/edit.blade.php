@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 flex justify-center items-center py-10 px-4">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl">

        <h1 class="text-3xl font-bold text-orange-600 mb-6 text-center">
            Edit Profil
        </h1>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">
                    Nama Lengkap
                </label>
                <input 
                    id="name"
                    type="text" 
                    name="name" 
                    value="{{ old('name', auth()->user()->name) }}" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm 
                           focus:ring-2 focus:ring-orange-400 focus:outline-none transition"
                >
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">
                    Email
                </label>
                <input 
                    id="email"
                    type="email" 
                    name="email" 
                    value="{{ old('email', auth()->user()->email) }}" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm 
                           focus:ring-2 focus:ring-orange-400 focus:outline-none transition"
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Saat Ini --}}
            <div>
                <label for="current_password" class="block text-gray-700 font-semibold mb-2">
                    Password Saat Ini
                </label>
                <input 
                    id="current_password"
                    type="password" 
                    name="current_password" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm 
                           focus:ring-2 focus:ring-orange-400 focus:outline-none transition"
                    required
                >
                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Simpan --}}
            <button 
                type="submit" 
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl shadow-md transition duration-200"
            >
                Simpan Perubahan
            </button>
        </form>

        {{-- Tombol Kembali di bawah tombol simpan --}}
        <div class="mt-6 flex justify-center">
            <a href="{{ url()->previous() }}" 
               class="inline-block px-6 py-3 border border-orange-500 text-orange-600 font-semibold rounded-xl 
                      hover:bg-orange-50 transition duration-200 shadow-sm">
                ← Kembali
            </a>
        </div>

    </div>
</div>
@endsection
