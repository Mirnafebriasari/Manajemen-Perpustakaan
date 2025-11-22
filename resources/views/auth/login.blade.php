@extends('layouts.app')

@section('title', 'Login')

@section('content')
<h1 class="text-2xl font-bold mb-4">Login</h1>

<form method="POST" action="{{ route('login') }}" class="max-w-md">
    @csrf

    <label class="block mb-2">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required class="border p-2 w-full mb-4" />
    @error('email') <p class="text-red-600">{{ $message }}</p> @enderror

    <label class="block mb-2">Password</label>
    <input type="password" name="password" required class="border p-2 w-full mb-4" />
    @error('password') <p class="text-red-600">{{ $message }}</p> @enderror

    <div class="mb-4">
        <label><input type="checkbox" name="remember"> Ingat saya</label>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Login</button>
</form>
@endsection
