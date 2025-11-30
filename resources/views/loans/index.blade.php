@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 to-orange-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-orange-600">Daftar Peminjaman</h1>
                    <p class="text-gray-600 mt-2">Kelola dan pantau semua transaksi peminjaman buku</p>
                </div>

                {{-- Tombol Kembali untuk Admin & Pegawai --}}
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow transition">
                            ← Kembali
                        </a>
                    @elseif(auth()->user()->hasRole('pegawai'))
                        <a href="{{ route('pegawai.dashboard') }}" 
                           class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow transition">
                            ← Kembali
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                            <th class="px-6 py-4 text-left text-sm font-semibold">Mahasiswa</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Judul Buku</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Pinjam</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Kembali</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Denda</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($loans as $loan)
                        <tr class="hover:bg-orange-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $loan->user->name ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $loan->book->title ?? '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-gray-600">{{ $loan->loan_date ? $loan->loan_date->format('d M Y') : '-' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-gray-600">{{ $loan->return_date ? $loan->return_date->format('d M Y') : '-' }}</div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php $status = strtolower($loan->status); @endphp

                                @if($status === 'borrowed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        Dipinjam
                                    </span>
                                @elseif($status === 'returned')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        Dikembalikan
                                    </span>
                                @elseif(in_array($status, ['overdue', 'late']))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if($loan->fine_amount > 0)
                                    <span class="font-semibold text-red-600">Rp {{ number_format($loan->fine_amount, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-gray-500">Rp 0</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Admin & Pegawai: Konfirmasi Pengembalian --}}
                                    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('pegawai')) && $status === 'borrowed')
                                        <form action="{{ route('loans.update', $loan->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Konfirmasi pengembalian buku?')" 
                                              class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm rounded-lg hover:from-green-600 hover:to-green-700 shadow-md">
                                                Konfirmasi Pengembalian
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Admin & Pegawai: Hapus --}}
                                    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('pegawai')) && in_array($status, ['returned', 'overdue', 'late']))
                                        <form action="{{ route('loans.destroy', $loan->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus data ini?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 shadow-md">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Mahasiswa: Perpanjang --}}
                                    @if(auth()->check() && auth()->user()->hasRole('mahasiswa') 
                                        && $status === 'borrowed' && now()->lt($loan->due_date))
                                        <form action="{{ route('mahasiswa.loans.renew', $loan->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Perpanjang peminjaman?')" 
                                              class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm rounded-lg hover:from-orange-600 hover:to-orange-700 shadow-md">
                                                Perpanjang
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tidak ada aksi --}}
                                    @if(
                                        !(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('pegawai')) && $status === 'borrowed') &&
                                        !(auth()->check() && auth()->user()->hasRole('mahasiswa') && $status === 'borrowed' && now()->lt($loan->due_date)) &&
                                        !(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('pegawai')) && in_array($status, ['returned', 'overdue', 'late']))
                                    )
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                                        <span class="text-4xl text-orange-400">📚</span>
                                    </div>
                                    <p class="text-gray-600 text-lg font-medium">Belum ada data peminjaman</p>
                                    <p class="text-gray-400 text-sm mt-1">Data peminjaman akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($loans, 'links') && $loans->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $loans->links() }}
            </div>
            @endif
        </div>

        {{-- Info Footer --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-blue-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Dipinjam</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $loans->where('status', 'borrowed')->count() }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-green-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Dikembalikan</h3>
                <p class="text-2xl font-bold text-green-600">{{ $loans->where('status', 'returned')->count() }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-red-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Terlambat</h3>
                <p class="text-2xl font-bold text-red-600">{{ $loans->whereIn('status', ['overdue', 'late'])->count() }}</p>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination .page-link {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
    color: #6b7280;
    transition: all 0.2s;
}

.pagination .page-link:hover {
    background-color: #fed7aa;
    color: #ea580c;
}

.pagination .active .page-link {
    background: linear-gradient(to right, #f97316, #ea580c);
    color: white;
    box-shadow: 0 4px 6px rgba(249, 115, 22, 0.3);
}
</style>
@endsection
