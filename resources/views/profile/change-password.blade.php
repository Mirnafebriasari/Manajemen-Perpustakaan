@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<h1 class="text-2xl font-bold mb-4">Ganti Password</h1>

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <div class="mb-4">
        <label class="block mb-1">Password Saat Ini</label>
        <input type="password" name="current_password" class="border p-2 w-full" required>
        @error('current_password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Password Baru</label>
        <input type="password" name="password" class="border p-2 w-full" required>
        @error('password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label class="block mb-1">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" class="border p-2 w-full" required>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Ubah Password</button>
</form>
@endsection
