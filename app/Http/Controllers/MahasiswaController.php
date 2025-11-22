<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Book;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Pinjaman aktif (belum dikembalikan) - Ubah 'returned_at' ke 'return_date'
        $activeLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->whereNull('return_date')  // Perbaiki nama field
            ->get();

        // Riwayat peminjaman (sudah dikembalikan) - Ubah 'returned_at' ke 'return_date'
        $loanHistory = Loan::with('book')
            ->where('user_id', $user->id)
            ->whereNotNull('return_date')  // Perbaiki nama field
            ->orderBy('return_date', 'desc')  // Perbaiki nama field
            ->get();

        // Hitung total denda tertunggak - Ubah 'fine' ke 'fine_amount'
        $totalFine = $activeLoans->sum(function ($loan) {
            return $loan->fine_amount ?? 0;  // Perbaiki nama field
        });

        // Notifikasi terbaru
        $notifications = $user->notifications()->latest()->get();

        // Rekomendasi buku (5 buku populer)
        $recommendations = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.mahasiswa', compact(
            'activeLoans',
            'loanHistory',
            'totalFine',
            'notifications',
            'recommendations',
            'user'
        ));
    }
}