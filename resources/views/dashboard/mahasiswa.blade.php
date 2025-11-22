@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="mb-4">
    <p>Halo, {{ $user->name }} ({{ $user->role }}) | 
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-blue-600 hover:underline">Logout</button>
        </form>
    </p>
</div>

<h1 class="text-3xl font-bold mb-6">Dashboard Mahasiswa</h1>

{{-- =======================
    BUKU YANG DIPINJAM
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-4">Buku yang Dipinjam</h2>

    @if ($activeLoans->isEmpty())
        <p>Anda belum meminjam buku.</p>
    @else
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Judul Buku</th>
                    <th class="border p-2">Tanggal Pinjam</th>
                    <th class="border p-2">Tanggal Kembali</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeLoans as $loan)
                <tr>
                    <td class="border p-2">{{ $loan->book->title }}</td>
                    <td class="border p-2">{{ $loan->loan_date ? $loan->loan_date->format('d-m-Y') : 'N/A' }}</td>
                    <td class="border p-2">{{ $loan->due_date ? $loan->due_date->format('d-m-Y') : 'N/A' }}</td>
                    <td class="border p-2">
                        @if ($loan->fine_amount > 0)
                            <span class="text-red-600 font-bold">
                                Denda Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-green-600">On Time</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        @if (!$loan->is_extended && now()->lt($loan->due_date))
                            <form method="POST" action="{{ route('mahasiswa.loans.extend', $loan->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">
                                    Perpanjang
                                </button>
                            </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</section>

{{-- =======================
    RIWAYAT PEMINJAMAN
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-4">Riwayat Peminjaman</h2>

    @if ($loanHistory->isEmpty())
        <p>Belum ada riwayat peminjaman.</p>
    @else
        <ul>
            @foreach ($loanHistory as $loan)
                <li class="mb-2">
                    {{ $loan->book->title }} — 
                    Dipinjam: {{ $loan->loan_date ? $loan->loan_date->format('d-m-Y') : 'N/A' }}, 
                    Dikembalikan: {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : 'Belum dikembalikan' }}

                    @if ($loan->return_date)
                        @if (!$loan->review)
                            <a href="{{ route('loans.review', $loan->id) }}" class="text-blue-600 hover:underline ml-2">
                                Berikan Ulasan
                            </a>
                        @else
                            <span class="text-gray-500">(Sudah diulas)</span>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</section>

{{-- =======================
    RESERVASI TERBARU (RINGKASAN)
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-2">Reservasi Terbaru</h2>

    @if (isset($reservations) && $reservations->isEmpty())
        <p>Anda belum memiliki reservasi.</p>
    @elseif(isset($reservations))
        <ul>
            @foreach ($reservations as $res)
                <li class="mb-1">
                    {{ $res->book->title }} — 
                    {{ $res->reserved_at->format('d M Y H:i') }} — 
                    Status: {{ ucfirst($res->status) }}
                </li>
            @endforeach
        </ul>
        <a href="{{ route('mahasiswa.reservations.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
            Lihat semua reservasi
        </a>
    @else
        <p><em>Data reservasi tidak tersedia.</em></p>
    @endif
</section>

{{-- =======================
    DENDA
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-2">Status Denda</h2>

    @if ($totalFine > 0)
        <p class="text-red-600 font-bold">
            Anda memiliki denda tertunggak sebesar Rp {{ number_format($totalFine, 0, ',', '.') }}.
        </p>
        <p class="text-sm text-gray-600">
            Peminjaman baru akan diblokir hingga denda dilunasi.
        </p>
    @else
        <p>Tidak ada denda tertunggak.</p>
    @endif
</section>

{{-- =======================
    NOTIFIKASI
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-2">Notifikasi</h2>

    @if ($notifications->isEmpty())
        <p>Tidak ada notifikasi.</p>
    @else
        <ul class="list-disc pl-5">
            @foreach ($notifications as $notification)
                <li>
                    {{ $notification->data['message'] ?? $notification->message }}
                    <small class="text-gray-500">({{ $notification->created_at->diffForHumans() }})</small>
                </li>
            @endforeach
        </ul>
    @endif
</section>

{{-- =======================
    REKOMENDASI BUKU
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-2">Rekomendasi Buku</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($recommendations as $book)
            <div class="border p-4 rounded shadow">
                <h3 class="font-bold text-lg">{{ $book->title }}</h3>
                <p>Penulis: {{ $book->author }}</p>
                <p>Kategori: {{ $book->category }}</p>
                <p>Rating: {{ $book->average_rating ?? 'Belum ada' }}/5</p>
                <a href="{{ route('mahasiswa.books.show', $book->id) }}" class="text-blue-600 hover:underline">Detail Buku</a>
            </div>
        @endforeach
    </div>
</section>

{{-- =======================
    PROFIL
======================= --}}
<section class="mb-8">
    <h2 class="text-xl font-semibold mb-2">Profil & Pengaturan Akun</h2>
    <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline mr-4">Edit Profil</a>
    <a href="{{ route('password.change') }}" class="text-blue-600 hover:underline">Ganti Password</a>
</section>
@endsection
