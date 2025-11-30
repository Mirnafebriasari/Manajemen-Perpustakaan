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

        $popularBooks = Book::withCount('loans')
    ->where('stock', '>', 0)
    ->orderByDesc('loans_count')
    ->limit(5)
    ->get();


        $personalizedRecommendations = collect();
        if (Auth::check() && Auth::user()->hasRole('mahasiswa')) {
            $userCategories = Auth::user()->loans()
                ->with('book')
                ->get()
                ->pluck('book.category')
                ->unique()
                ->values();

            if ($userCategories->isNotEmpty()) {
                foreach ($userCategories as $category) {
                    $totalBooksInCategory = Book::where('category', $category)->count();

                    if ($totalBooksInCategory === 0) {
                        continue;
                    }

                    $borrowedBooksCount = Book::where('category', $category)
                        ->whereHas('loans')
                        ->count();

                    if ($borrowedBooksCount >= ceil(0.6 * $totalBooksInCategory)) {
                        $books = Book::withCount('loans')
                            ->where('category', $category)
                            ->where('stock', '>', 0)
                            ->where('status', 'active')
                            ->orderBy('loans_count', 'desc')
                            ->limit(5)
                            ->get();

                        $personalizedRecommendations = $personalizedRecommendations->merge($books);
                    }
                }

                $personalizedRecommendations = $personalizedRecommendations->unique('id')->take(5);
            }
        }

        $search = $request->input('search');
        $searchResults = collect();
        if ($search) {
            $searchResults = Book::where('title', 'like', "%$search%")
                ->orWhere('author', 'like', "%$search%")
                ->limit(10)
                ->get();
        }

        return view('home', compact('latestBooks', 'popularBooks', 'search', 'searchResults', 'personalizedRecommendations'));
    }
}


