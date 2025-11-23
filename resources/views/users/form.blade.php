@extends('layouts.app')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
<h1 class="text-3xl font-bold mb-6">
    {{ isset($user) ? 'Edit' : 'Tambah' }} Pengguna
</h1>

<form 
    action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" 
    method="POST" 
    class="max-w-md"
>
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    {{-- Nama Lengkap --}}
    <label class="block mb-2 font-semibold">Nama Lengkap</label>
    <input 
        type="text" 
        name="name" 
        value="{{ old('name', $user->name ?? '') }}" 
        required 
        class="border p-2 w-full mb-4 @error('name') border-red-600 @enderror"
    />
    @error('name')
        <p class="text-red-600">{{ $message }}</p>
    @enderror

    {{-- Email --}}
    <label class="block mb-2 font-semibold">Email</label>
    <input 
        type="email" 
        name="email" 
        value="{{ old('email', $user->email ?? '') }}" 
        required 
        class="border p-2 w-full mb-4 @error('email') border-red-600 @enderror"
        placeholder="contoh@universitas.ac.id"
    />
    @error('email')
        <p class="text-red-600">{{ $message }}</p>
    @enderror

    {{-- Password --}}
    @if(!isset($user))
        {{-- Create User --}}
        <label class="block mb-2 font-semibold">Password</label>
        <input 
            type="password" 
            name="password" 
            required 
            class="border p-2 w-full mb-4 @error('password') border-red-600 @enderror"
        />
        @error('password')
            <p class="text-red-600">{{ $message }}</p>
        @enderror

        <label class="block mb-2 font-semibold">Konfirmasi Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            required 
            class="border p-2 w-full mb-4"
        />
        @error('password_confirmation')
            <p class="text-red-600">{{ $message }}</p>
        @enderror
    @else
        {{-- Edit User --}}
        <label class="block mb-2 font-semibold">Password Baru (Opsional)</label>
        <input 
            type="password" 
            name="password" 
            class="border p-2 w-full mb-4 @error('password') border-red-600 @enderror"
        />
        <label class="block mb-2 font-semibold">Konfirmasi Password Baru</label>
        <input 
            type="password" 
            name="password_confirmation" 
            class="border p-2 w-full mb-4"
        />
        @error('password')
            <p class="text-red-600">{{ $message }}</p>
        @enderror
        @error('password_confirmation')
            <p class="text-red-600">{{ $message }}</p>
        @enderror
    @endif

    {{-- Role --}}
    <label class="block mb-2 font-semibold">Role</label>

    @php
        $roleNames = $user ? $user->getRoleNames() : collect();
        $currentRole = old('role', $roleNames->first() ?? '');
    @endphp

    <select name="role" required class="border p-2 w-full mb-4 @error('role') border-red-600 @enderror">
        <option value="">-- Pilih Role --</option>
        <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="pegawai" {{ $currentRole == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
        <option value="mahasiswa" {{ $currentRole == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
    </select>

    @error('role')
        <p class="text-red-600">{{ $message }}</p>
    @enderror

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        {{ isset($user) ? 'Update' : 'Simpan' }}
    </button>

    <a href="{{ route('users.index') }}" class="ml-4 text-gray-600">Batal</a>
</form>
@endsection
