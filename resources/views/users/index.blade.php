@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
<h1 class="text-3xl font-bold mb-6">Daftar Pengguna</h1>

<a href="{{ route('users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
    Tambah Pengguna
</a>

<table class="table-auto w-full bg-white rounded shadow">
    <thead>
        <tr>
            <th class="border px-4 py-2">Nama</th>
            <th class="border px-4 py-2">Email</th>
            <th class="border px-4 py-2">Role</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="border px-4 py-2">{{ $user->name }}</td>
            <td class="border px-4 py-2">{{ $user->email }}</td>

            {{-- PERBAIKAN DI SINI --}}
            <td class="border px-4 py-2">
                {{ $user->getRoleNames()->implode(', ') }} 
            </td>

            <td class="border px-4 py-2">
                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                <form action="{{ route('users.destroy', $user->id) }}" 
                      method="POST" 
                      class="inline" 
                      onsubmit="return confirm('Yakin hapus pengguna ini?')">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
