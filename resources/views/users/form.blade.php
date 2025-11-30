@extends('layouts.app')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-orange-600 text-center">
    {{ isset($user) ? 'Edit' : 'Tambah' }} Pengguna
</h1>

<form 
    action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" 
    method="POST" 
    class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg border border-orange-200"
>
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    {{-- Nama Lengkap --}}
    <label class="block mb-2 font-semibold text-gray-700">Nama Lengkap</label>
    <input 
        type="text" 
        name="name" 
        value="{{ old('name', $user->name ?? '') }}" 
        required 
        class="border rounded-lg p-3 w-full mb-5 transition 
               focus:outline-none focus:ring-2 focus:ring-orange-400
               @error('name') border-red-600 @enderror"
    />
    @error('name')
        <p class="text-red-600 mb-4">{{ $message }}</p>
    @enderror

    {{-- Email --}}
    <label class="block mb-2 font-semibold text-gray-700">Email</label>
    <input 
        type="email" 
        name="email" 
        value="{{ old('email', $user->email ?? '') }}" 
        required 
        placeholder="contoh@universitas.ac.id"
        class="border rounded-lg p-3 w-full mb-5 transition 
               focus:outline-none focus:ring-2 focus:ring-orange-400
               @error('email') border-red-600 @enderror"
    />
    @error('email')
        <p class="text-red-600 mb-4">{{ $message }}</p>
    @enderror

    @if(isset($user))
        {{-- Password Saat Ini --}}
        <label class="block mb-2 font-semibold text-gray-700">Password Saat Ini</label>
        <input 
            type="password" 
            name="current_password" 
            required 
            class="border rounded-lg p-3 w-full mb-5 transition 
                   focus:outline-none focus:ring-2 focus:ring-orange-400
                   @error('current_password') border-red-600 @enderror"
        />
        @error('current_password')
            <p class="text-red-600 mb-4">{{ $message }}</p>
        @enderror

        {{-- Password Baru (Opsional) --}}
        <label class="block mb-2 font-semibold text-gray-700">Password Baru (Opsional)</label>
        <input 
            type="password" 
            name="password" 
            class="border rounded-lg p-3 w-full mb-5 transition 
                   focus:outline-none focus:ring-2 focus:ring-orange-400
                   @error('password') border-red-600 @enderror"
        />
        <label class="block mb-2 font-semibold text-gray-700">Konfirmasi Password Baru</label>
        <input 
            type="password" 
            name="password_confirmation" 
            class="border rounded-lg p-3 w-full mb-5 transition 
                   focus:outline-none focus:ring-2 focus:ring-orange-400"
        />
        @error('password')
            <p class="text-red-600 mb-4">{{ $message }}</p>
        @enderror
        @error('password_confirmation')
            <p class="text-red-600 mb-4">{{ $message }}</p>
        @enderror
    @else
        {{-- Create User --}}
        <label class="block mb-2 font-semibold text-gray-700">Password</label>
        <input 
            type="password" 
            name="password" 
            required 
            class="border rounded-lg p-3 w-full mb-5 transition 
                   focus:outline-none focus:ring-2 focus:ring-orange-400
                   @error('password') border-red-600 @enderror"
        />
        @error('password')
            <p class="text-red-600 mb-4">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold text-gray-700">Konfirmasi Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            required 
            class="border rounded-lg p-3 w-full mb-5 transition 
                   focus:outline-none focus:ring-2 focus:ring-orange-400"
        />
        @error('password_confirmation')
            <p class="text-red-600 mb-4">{{ $message }}</p>
        @enderror
    @endif

    {{-- Role --}}
    <label class="block mb-2 font-semibold text-gray-700">Role</label>

    @php
        $roleNames = $user ? $user->getRoleNames() : collect();
        $currentRole = old('role', $roleNames->first() ?? '');
    @endphp

    <select name="role" required
        class="border rounded-lg p-3 w-full mb-6 transition
               focus:outline-none focus:ring-2 focus:ring-orange-400
               @error('role') border-red-600 @enderror"
    >
        <option value="">-- Pilih Role --</option>
        <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="pegawai" {{ $currentRole == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
        <option value="mahasiswa" {{ $currentRole == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
    </select>

    @error('role')
        <p class="text-red-600 mb-4">{{ $message }}</p>
    @enderror

    {{-- Tombol Submit dan Kembali side by side --}}
    <div class="flex gap-4">
        <button type="submit" 
            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
            {{ isset($user) ? 'Update' : 'Simpan' }}
        </button>

        <a href="{{ url()->previous() }}" 
            class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg shadow-sm font-semibold transition flex items-center justify-center">
            ← Kembali
        </a>
    </div>
</form>
@endsection
