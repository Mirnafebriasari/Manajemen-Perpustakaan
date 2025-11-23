<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Reservation;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $activeLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->whereNull('returned_at')  // ubah di sini
            ->get();

        $loanHistory = Loan::with('book')
            ->where('user_id', $user->id)
            ->whereNotNull('returned_at')  // ubah di sini
            ->orderBy('returned_at', 'desc')  // ubah di sini
            ->get();

        $totalFine = $activeLoans->sum(fn($loan) => $loan->fine_amount ?? 0);

        $notifications = $user->notifications()->latest()->get();

        $recommendations = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->limit(5)
            ->get();

        $reservations = Reservation::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.mahasiswa', compact(
            'activeLoans',
            'loanHistory',
            'totalFine',
            'notifications',
            'recommendations',
            'reservations',
            'user'
        ));
    }
}
