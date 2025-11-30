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
    

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();       
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
}
