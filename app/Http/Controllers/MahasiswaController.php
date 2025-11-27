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
    ->whereNull('return_date')   // perbaikan
    ->get();

$loanHistory = Loan::with('book')
    ->where('user_id', $user->id)
    ->whereNotNull('return_date')   // perbaikan
    ->orderBy('return_date', 'desc')  // perbaikan
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
