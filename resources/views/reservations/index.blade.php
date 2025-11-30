@extends('layouts.app')

@section('title', 'Daftar Reservasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 font-medium border border-gray-200 dark:border-gray-700">
            ← Kembali
        </a>
    </div>

    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
            Daftar Reservasi Buku
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Kelola dan pantau semua reservasi buku Anda
        </p>
    </div>

    @if($reservations->isEmpty())
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-orange-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-12 text-center border border-orange-100 dark:border-gray-700">
            <div class="mb-6 text-8xl text-gray-300 dark:text-gray-600">
                ∅
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-3">
                Belum Ada Reservasi
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Anda belum memiliki reservasi buku saat ini. Mulai jelajahi koleksi kami dan reservasi buku favorit Anda!
            </p>
            <a href="{{ route('books.index') }}" 
               class="inline-block px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                Jelajahi Buku
            </a>
        </div>
    @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            @php
                $stats = [
                    'pending' => $reservations->where('status', 'pending')->count(),
                    'fulfilled' => $reservations->where('status', 'fulfilled')->count(),
                    'cancelled' => $reservations->where('status', 'cancelled')->count(),
                ];
            @endphp
            
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-6 border border-yellow-200 dark:border-yellow-800">
                <p class="text-yellow-600 dark:text-yellow-400 text-sm font-medium mb-2">Pending</p>
                <p class="text-4xl font-bold text-yellow-700 dark:text-yellow-300">{{ $stats['pending'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                <p class="text-green-600 dark:text-green-400 text-sm font-medium mb-2">Fulfilled</p>
                <p class="text-4xl font-bold text-green-700 dark:text-green-300">{{ $stats['fulfilled'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-6 border border-red-200 dark:border-red-800">
                <p class="text-red-600 dark:text-red-400 text-sm font-medium mb-2">Cancelled</p>
                <p class="text-4xl font-bold text-red-700 dark:text-red-300">{{ $stats['cancelled'] }}</p>
            </div>
        </div>

        <!-- Reservations Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Judul Buku
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal Reservasi
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($reservations as $res)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-6 py-5">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $res->book->title }}
                                        </p>
                                        @if($res->book->author)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $res->book->author }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                        <span class="font-medium">{{ $res->reserved_at->format('d M Y') }}</span>
                                        <span class="text-gray-400 mx-1">•</span>
                                        <span class="text-gray-500 dark:text-gray-400">{{ $res->reserved_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
                                                'text' => 'text-yellow-800 dark:text-yellow-300',
                                                'border' => 'border-yellow-300 dark:border-yellow-700'
                                            ],
                                            'fulfilled' => [
                                                'bg' => 'bg-green-100 dark:bg-green-900/30',
                                                'text' => 'text-green-800 dark:text-green-300',
                                                'border' => 'border-green-300 dark:border-green-700'
                                            ],
                                            'cancelled' => [
                                                'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                'text' => 'text-red-800 dark:text-red-300',
                                                'border' => 'border-red-300 dark:border-red-700'
                                            ],
                                        ];
                                        $config = $statusConfig[$res->status] ?? [
                                            'bg' => 'bg-gray-100 dark:bg-gray-900/30',
                                            'text' => 'text-gray-800 dark:text-gray-300',
                                            'border' => 'border-gray-300 dark:border-gray-700'
                                        ];
                                    @endphp
                                    <span class="inline-block px-3 py-1.5 rounded-full text-xs font-semibold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $user = auth()->user();
                                        $canCancel = $res->status === 'pending' && (
                                            $user->hasRole(['admin', 'pegawai']) || $res->user_id === $user->id
                                        );
                                    @endphp

                                    @if($canCancel)
                                        <form action="{{ route('reservations.destroy', $res->id) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?');" 
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm italic select-none">
                                            Tidak dapat dibatalkan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination if needed -->
        @if(method_exists($reservations, 'links'))
            <div class="mt-6">
                {{ $reservations->links() }}
            </div>
        @endif
    @endif
</div>
@endsection