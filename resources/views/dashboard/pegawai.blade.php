@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
<h1 class="text-3xl font-bold mb-6">Dashboard Pegawai</h1>

<div class="mb-6">
    <h2 class="text-xl font-semibold mb-2">Proses Peminjaman & Pengembalian</h2>
    <a href="{{ route('loans.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">Pinjam Buku</a>
    <a href="{{ route('loans.index') }}" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded">Daftar Peminjaman</a>
</div>

<div class="mb-4">
    <h2 class="text-xl font-semibold mb-2">Kelola Koleksi Buku</h2>
    <a href="{{ route('books.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Tambah Buku Baru</a>
    <a href="{{ route('pegawai.books.index') }}" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded">Daftar Buku</a>
</div>

{{-- Notifikasi Pegawai --}}
<div class="mb-4">
    <h2 class="text-xl font-semibold mb-2">Notifikasi Sistem</h2>
    @forelse($notifications as $notif)
        <div class="border p-3 rounded mb-2">
            <p>{{ $notif->data['message'] ?? 'Notifikasi' }}</p>
            <small class="text-gray-600">{{ $notif->created_at->format('d M Y H:i') }}</small>
        </div>
    @empty
        <p>Tidak ada notifikasi.</p>
    @endforelse
</div>
@endsection
