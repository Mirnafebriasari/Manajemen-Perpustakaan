<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\DB; 

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $loansToday = Loan::whereDate('created_at', today())->count();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalBooks',
            'loansToday'
        ));
    }
    public function analytics()
{
    $loansPerMonth = Loan::select(
        DB::raw("DATE_FORMAT(loan_date, '%Y-%m') as month"),
        DB::raw("COUNT(*) as total")
    )
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->limit(12)
        ->get();

    $booksPerCategory = Book::select('category', DB::raw('COUNT(*) as total'))
        ->groupBy('category')
        ->get();
        
    return view('analytics', compact('loansPerMonth', 'booksPerCategory'));
}

}
