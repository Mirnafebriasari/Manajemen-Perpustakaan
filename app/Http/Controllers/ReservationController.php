<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $existing = Reservation::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->withErrors('Anda sudah melakukan reservasi untuk buku ini.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'reserved_at' => Carbon::now(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Reservasi berhasil dibuat');
    }
}
