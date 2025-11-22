@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Jumlah Pengguna</h2>
        <p>{{ $totalUsers }}</p>

        <a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">Kelola Pengguna</a>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Jumlah Buku</h2>
        <p>{{ $totalBooks }}</p>

        <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:underline">Kelola Buku</a>
        <a href="{{ route('admin.books.create') }}" class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 mt-2">
            + Tambah Buku
        </a>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Transaksi Peminjaman Hari Ini</h2>
        <p>{{ $loansToday }}</p>

        <a href="{{ route('loans.index') }}" class="text-blue-600 hover:underline">Kelola Peminjaman</a>
    </div>

</div>

{{-- Tombol akses analytics --}}
<div class="mt-8">
    <a href="{{ route('admin.analytics') }}" 
       class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
        Lihat Analytics & Reporting
    </a>
</div>

@endsection
