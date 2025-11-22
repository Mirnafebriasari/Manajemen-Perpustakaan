<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Book;
 use App\Models\Reservation;  // jangan lupa import model Reservation di atas
 
class MahasiswaController extends Controller
{
   

public function dashboard()
{
    $user = Auth::user();

    $activeLoans = Loan::with('book')
        ->where('user_id', $user->id)
        ->whereNull('return_date')
        ->get();

    $loanHistory = Loan::with('book')
        ->where('user_id', $user->id)
        ->whereNotNull('return_date')
        ->orderBy('return_date', 'desc')
        ->get();

    $totalFine = $activeLoans->sum(fn($loan) => $loan->fine_amount ?? 0);

    $notifications = $user->notifications()->latest()->get();

    $recommendations = Book::withCount('loans')
        ->orderBy('loans_count', 'desc')
        ->limit(5)
        ->get();

    // **Tambahan: ambil reservasi terbaru 5 data saja**
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
        'reservations',   // pastikan ini disertakan
        'user'
    ));
}

}