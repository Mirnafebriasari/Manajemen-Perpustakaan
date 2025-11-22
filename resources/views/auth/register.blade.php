@extends('layouts.app')

@section('title', 'Register Mahasiswa')

@section('content')
<h1 class="text-2xl font-bold mb-4">Register Mahasiswa</h1>

<form method="POST" action="{{ route('register') }}" class="max-w-md">
    @csrf

    {{-- Nama Lengkap --}}
    <label class="block mb-2">Nama Lengkap</label>
    <input
        type="text"
        name="name"
        value="{{ old('name') }}"
        required
        class="border p-2 w-full mb-4 @error('name') border-red-600 @enderror"
    />
    @error('name')
        <p class="text-red-600">{{ $message }}</p>
    @enderror

    {{-- Email --}}
    <label class="block mb-2">Email (harus domain universitas.ac.id)</label>
    <input
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        class="border p-2 w-full mb-4 @error('email') border-red-600 @enderror"
        placeholder="contoh@universitas.ac.id"
    />
    @error('email')
        <p class="text-red-600">{{ $message }}</p>
    @enderror

    {{-- Password --}}
    <label class="block mb-2">Password</label>
    <input
        type="password"
        name="password"
        required
        class="border p-2 w-full mb-4 @error('password') border-red-600 @enderror"
    />
    @error('password')
        <p class="text-red-600">{{ $message }}</p>
    @enderror

    {{-- Konfirmasi Password --}}
    <label class="block mb-2">Konfirmasi Password</label>
    <input
        type="password"
        name="password_confirmation"
        required
        class="border p-2 w-full mb-6"
    />

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Daftar
    </button>
</form>
@endsection
