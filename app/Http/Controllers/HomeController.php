<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class HomeController extends Controller
{
public function index(Request $request)
{
    $latestBooks = Book::orderBy('created_at', 'desc')->limit(5)->get();
    $popularBooks = Book::orderBy('stock', 'asc')->limit(5)->get();
    $personalizedRecommendations = collect();
    if (Auth::check() && Auth::user()->hasRole('mahasiswa')) {
        // Rekomendasi berdasarkan kategori yang sering dipinjam
        $userCategories = Auth::user()->loans()
            ->with('book')
            ->get()
            ->pluck('book.category')
            ->unique()
            ->values();
        if ($userCategories->isNotEmpty()) {
            $personalizedRecommendations = Book::whereIn('category', $userCategories)
                ->where('stock', '>', 0)
                ->inRandomOrder()
                ->limit(5)
                ->get();
        }
    }
        // Search bar (search berdasarkan judul atau penulis)
        $search = $request->input('search');
        $searchResults = collect();
        if ($search) {
            $searchResults = Book::where('title', 'like', "%$search%")
                                ->orWhere('author', 'like', "%$search%")
                                ->limit(10)
                                ->get();
        }

        return view('home', compact('latestBooks', 'popularBooks', 'search', 'searchResults'));
    }
}
