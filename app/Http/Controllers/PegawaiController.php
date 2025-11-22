<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;  // Tambahkan ini untuk mengakses model Book
use App\Models\User;  // Tambahkan ini untuk mengakses model User (jika perlu untuk borrower)

class PegawaiController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya role pegawai yang bisa akses
        $this->middleware(['auth', 'role:pegawai']);
    }

    public function dashboard()
    {
        // Ambil notifikasi user
        $notifications = auth()->user()->notifications ?? collect();

        return view('dashboard.pegawai', compact('notifications'));
    }

    /**
     * Menampilkan formulir untuk membuat peminjaman baru (Pinjam Buku).
     */
    public function createLoan()
    {
        // Ambil daftar buku yang tersedia (sesuaikan query berdasarkan model Anda)
        // Asumsi: Buku dengan status 'available' bisa dipinjam. Jika tidak ada kolom status, gunakan Book::all()
        $books = Book::where('status', 'available')->get();
        
        // Ambil daftar borrower (peminjam), misalnya mahasiswa (sesuaikan role berdasarkan aplikasi Anda)
        $borrowers = User::whereHas('roles', function ($query) {
            $query->where('name', 'mahasiswa');  // Asumsi role mahasiswa bisa meminjam
        })->get();

        // Kembalikan view dengan data
        return view('loans.create', compact('books', 'borrowers'));
    }
}
