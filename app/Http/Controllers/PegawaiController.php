<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; 
use App\Models\User;  
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:pegawai']);
    }

  public function dashboard()
    {
        $notifications = auth()->user()->unreadNotifications ?? collect();
        return view('dashboard.pegawai', compact('notifications'));
    }
    

    public function createLoan()
    {
        $books = Book::where('status', 'available')->get();
        $borrowers = User::whereHas('roles', function ($query) {
            $query->where('name', 'mahasiswa');
            })->get();
        return view('loans.create', compact('books', 'borrowers'));
    }
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();       
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
}
