@extends('layouts.app')

@section('title', 'Daftar Reservasi')

@section('content')
<h1 class="text-3xl font-bold mb-6">Daftar Reservasi Buku</h1>

@if($reservations->isEmpty())
    <p>Anda belum memiliki reservasi.</p>
@else
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-3 py-2">Judul Buku</th>
                <th class="border px-3 py-2">Tanggal Reservasi</th>
                <th class="border px-3 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $res)
                <tr>
                    <td class="border px-3 py-2">{{ $res->book->title }}</td>
                    <td class="border px-3 py-2">{{ $res->reserved_at->format('d M Y H:i') }}</td>
                    <td class="border px-3 py-2 capitalize">{{ $res->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
