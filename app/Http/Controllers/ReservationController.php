<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function index()
{
    $reservations = Reservation::with('book')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('reservations.index', compact('reservations'));
}

   public function store(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
    ]);

    $user = Auth::user();
    $book = Book::findOrFail($request->book_id);

    if ($book->stock > 0) {
        return back()->withErrors('Stok buku masih tersedia, tidak perlu reservasi.');
    }

    if ($user->total_fine > 0) {
        return back()->withErrors('Anda memiliki denda tertunggak. Tidak dapat reservasi.');
    }

    $isBorrowing = Loan::where('user_id', $user->id)
                        ->where('book_id', $book->id)
                        ->where('status', 'borrowed')
                        ->exists();

    if ($isBorrowing) {
        return back()->withErrors('Anda sedang meminjam buku ini.');
    }

    $existing = Reservation::where('user_id', $user->id)
        ->where('book_id', $book->id)
        ->whereIn('status', ['pending', 'notified'])
        ->first();

    if ($existing) {
        return back()->withErrors('Anda sudah memiliki reservasi aktif untuk buku ini.');
    }

    Reservation::create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'reserved_at' => now(),  // <== PENTING: tambahkan ini
        'status'  => 'pending',
    ]);

    return back()->with('success', 'Reservasi berhasil dibuat. Anda akan mendapat notifikasi saat buku tersedia.');
}
}
