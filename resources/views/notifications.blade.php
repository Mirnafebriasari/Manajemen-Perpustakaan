@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<h1 class="text-3xl font-bold mb-6">Notifikasi</h1>

@if($notifications->count())
    <ul>
    @foreach($notifications as $notif)
        <li class="border p-3 mb-2 rounded bg-white">
            {{ $notif->data['message'] ?? 'Notifikasi' }} <br>
            <small class="text-gray-600">{{ $notif->created_at->format('d M Y H:i') }}</small>
        </li>
    @endforeach
    </ul>
@else
    <p>Tidak ada notifikasi.</p>
@endif

@endsection
