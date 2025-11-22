@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<h1 class="text-3xl font-bold mb-6">Daftar Peminjaman</h1>

<table class="table-auto w-full bg-white rounded shadow">
    <thead>
        <tr>
            <th class="border px-4 py-2">Mahasiswa</th>
            <th class="border px-4 py-2">Judul Buku</th>
            <th class="border px-4 py-2">Tanggal Pinjam</th>
            <th class="border px-4 py-2">Tanggal Kembali</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Denda</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($loans as $loan)
        <tr>
            <td class="border px-4 py-2">{{ $loan->user->name ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $loan->book->title ?? '-' }}</td>
            <td class="border px-4 py-2">{{ $loan->loan_date ? $loan->loan_date->format('d M Y') : '-' }}</td>
            <td class="border px-4 py-2">{{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}</td>
            <td class="border px-4 py-2">{{ ucfirst($loan->status) }}</td>
            <td class="border px-4 py-2">Rp {{ number_format($loan->fine_amount ?? 0, 0, ',', '.') }}</td>

            <td class="border px-4 py-2 space-x-2">

                {{-- ADMIN & PEGAWAI: Tombol Konfirmasi Pengembalian --}}
                @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('pegawai')) && $loan->status === 'borrowed')
                    <form action="{{ route('loans.update', $loan->id) }}" method="POST" 
                          onsubmit="return confirm('Konfirmasi pengembalian?')" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">
                            Konfirmasi Pengembalian
                        </button>
                    </form>
                @endif

                {{-- MAHASISWA: Tombol Perpanjang --}}
                @if(auth()->check() && auth()->user()->hasRole('mahasiswa') 
                    && $loan->status === 'borrowed' 
                    && now()->lt($loan->due_date))
                    <form action="{{ route('mahasiswa.loans.renew', $loan->id) }}" method="POST" 
                          onsubmit="return confirm('Konfirmasi perpanjangan pinjaman?')" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">
                            Perpanjang
                        </button>
                    </form>
                @endif

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="p-4 text-center">Belum ada peminjaman.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Pagination --}}
@if(method_exists($loans, 'links'))
<div class="mt-4">
    {{ $loans->links() }}
</div>
@endif

@endsection
