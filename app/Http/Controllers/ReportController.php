<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalLoans = Loan::count();
        $loansThisMonth = Loan::whereMonth('created_at', now()->month)->count();
        $popularBooks = Book::withCount('loans')->orderBy('loans_count', 'desc')->limit(5)->get();

        return view('reports.index', compact('totalLoans', 'loansThisMonth', 'popularBooks'));
    }
}