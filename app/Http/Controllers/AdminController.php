<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Loan;

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
}
