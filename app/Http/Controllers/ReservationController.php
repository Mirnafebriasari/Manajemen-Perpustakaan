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
        $user = Auth::user();

        if ($user->hasRole(['admin', 'pegawai'])) {
            $reservations = Reservation::with('book', 'user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $reservations = Reservation::with('book')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

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
            ->whereIn('status', ['pending', 'fulfilled'])
            ->first();

        if ($existing) {
            return back()->withErrors('Anda sudah memiliki reservasi aktif untuk buku ini.');
        }

        Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reserved_at' => now(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Reservasi berhasil dibuat. Anda akan mendapat notifikasi saat buku tersedia.');
    }


    public function processReservation(Book $book)
    {
        if ($book->stock <= 0) {
            return;
        }

        $reservation = Reservation::where('book_id', $book->id)
            ->where('status', 'pending')
            ->orderBy('reserved_at', 'asc')
            ->first();

        if (!$reservation) {
            return;
        }

        Loan::create([
            'user_id' => $reservation->user_id,
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'borrowed',
        ]);

        $reservation->update([
            'status' => 'fulfilled'
        ]);

        $book->decrement('stock');
        return $reservation;
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->hasRole(['admin', 'pegawai'])) {
            $reservation = Reservation::findOrFail($id);
        } else {
            $reservation = Reservation::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        if ($reservation->status !== 'pending') {
            return back()->withErrors('Reservasi tidak dapat dibatalkan.');
        }

        $reservation->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}