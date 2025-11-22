@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block font-semibold">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="border p-2 w-full" required>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="border p-2 w-full" required>
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Password (kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="border p-2 w-full">
        </div>

        <div class="mb-3">
            <label class="block font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="border p-2 w-full">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('users.index') }}" class="ml-4 text-gray-600">Batal</a>
    </form>
</div>
@endsection
