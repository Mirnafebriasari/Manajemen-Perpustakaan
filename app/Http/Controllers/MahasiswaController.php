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
     $user->notifications()
        ->where('created_at', '<', now()->subDay())
        ->delete();

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


        $recommendations = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->limit(5)
            ->get();

        $reservations = Reservation::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
   
        $notifications = auth()->user()->unreadNotifications ?? collect();

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
        public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
}
