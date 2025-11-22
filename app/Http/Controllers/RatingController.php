<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    // Menampilkan form rating untuk buku tertentu
    public function create($bookId)
    {
        $book = Book::findOrFail($bookId);
        return view('ratings.create', compact('book'));
    }

    // Menyimpan rating dan ulasan
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $book = Book::findOrFail($bookId);

        // Cek apakah user sudah memberi rating sebelumnya, bisa update jika mau
        $existing = Rating::where('user_id', Auth::id())->where('book_id', $bookId)->first();

        if ($existing) {
            $existing->rating = $request->rating;
            $existing->review = $request->review;
            $existing->save();
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
        }

        return redirect()->route('books.show', $bookId)->with('success', 'Terima kasih telah memberikan rating!');
    }
}
