@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">
    
    <h1 class="text-2xl font-bold mb-4">Edit Profil</h1>

    {{-- Notifikasi sukses --}}
    @if(session('status'))
        <div class="mb-4 bg-green-100 text-green-700 p-2 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Lengkap</label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', auth()->user()->name) }}" 
                class="border p-2 w-full rounded"
            >
            @error('name')
            <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email', auth()->user()->email) }}" 
                class="border p-2 w-full rounded"
            >
            @error('email')
            <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Password Baru (opsional)</label>
            <input 
                type="password" 
                name="password" 
                class="border p-2 w-full rounded"
            >
            @error('password')
            <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Konfirmasi Password Baru</label>
            <input 
                type="password" 
                name="password_confirmation" 
                class="border p-2 w-full rounded"
            >
        </div>

        <button 
            type="submit" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            Simpan Perubahan
        </button>

    </form>

</div>
@endsection
