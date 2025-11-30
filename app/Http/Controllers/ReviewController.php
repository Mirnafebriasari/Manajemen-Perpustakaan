<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class ReviewController extends Controller
{
    public function create($loanId)
{
    $loan = \App\Models\Loan::findOrFail($loanId);
    
    if ($loan->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    $book = $loan->book;

    return view('reviews.create', compact('loan', 'book'));
}

   public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);


        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $request->book_id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        $avgRating = Review::where('book_id', $request->book_id)->avg('rating');

        Book::where('id', $request->book_id)
            ->update(['rating' => $avgRating]);

        return back()->with('success', 'Ulasan dan rating berhasil disimpan.');
    }
}