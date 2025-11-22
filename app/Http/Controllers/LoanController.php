<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LoanNotification;

class LoanController extends Controller
{
    // Mahasiswa: lihat daftar pinjaman (tapi admin/pegawai juga butuh list semua)
    public function index()
    {
        // Jika admin atau pegawai -> tampilkan semua peminjaman (dengan pagination)
        if (auth()->user()->hasAnyRole(['admin', 'pegawai'])) {
            $loans = Loan::with(['user', 'book'])->latest()->paginate(15);
        } else {
            // Mahasiswa -> hanya pinjaman miliknya sendiri
            $loans = Loan::where('user_id', Auth::id())->with('book')->latest()->paginate(10);
        }

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        return view('loans.create', compact('books'));
    }

public function store(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'quantity' => 'required|integer|min:1|max:10',
    ]);

    $book = Book::findOrFail($request->book_id);

    if ($request->quantity > $book->stock) {
        return back()->withErrors(['quantity' => 'Jumlah pinjam melebihi stok yang tersedia'])->withInput();
    }

    $loans = [];
    for ($i = 0; $i < $request->quantity; $i++) {
        $loans[] = Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays($book->max_loan_days),
            'status' => 'borrowed',
        ]);
    }

    $book->decrement('stock', $request->quantity);

    // Kirim notifikasi sekali saja (atau bisa per loan, sesuai kebutuhan)
    foreach ($loans as $loan) {
        $loan->user->notify(new LoanNotification($loan, 'borrowed'));
    }

    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.loans.index')->with('success', 'Buku berhasil dipinjam');
    } elseif ($user->hasRole('pegawai')) {
        return redirect()->route('loans.index')->with('success', 'Buku berhasil dipinjam');
    } else {
        return redirect()->route('mahasiswa.loans.index')->with('success', 'Buku berhasil dipinjam');
    }
}

    // Pegawai/Administrator menandai pengembalian
    public function update(Request $request, Loan $loan)
    {
        // Pastikan hanya yang berstatus 'borrowed' bisa diproses
        if ($loan->status !== 'borrowed') {
            return back()->withErrors('Peminjaman sudah selesai atau dibatalkan');
        }

        $loan->return_date = now();

        // Jika sekarang lewat due_date, maka terlambat
        if (now()->greaterThan($loan->due_date)) {
            $daysLate = now()->diffInDays($loan->due_date);
            $loan->fine_amount = $daysLate * ($loan->book->fine_per_day ?? 0);
            $loan->status = 'late';
        } else {
            $loan->fine_amount = 0;
            $loan->status = 'returned';
        }

        $loan->save();

        if ($loan->status === 'returned') {
            $loan->user->notify(new LoanNotification($loan, 'returned'));
        } elseif ($loan->status === 'late') {
            $loan->user->notify(new LoanNotification($loan, 'fine'));
        }

        $loan->book->increment('stock');

        return redirect()->back()->with('success', 'Pengembalian buku berhasil diproses');
    }

    // Perpanjangan oleh mahasiswa (renew)
    public function renew(Request $request, Loan $loan)
    {
        if ($loan->user_id !== Auth::id()) {
            return back()->withErrors('Akses ditolak.');
        }

        if ($loan->status !== 'borrowed' || now()->greaterThan($loan->due_date)) {
            return back()->withErrors('Tidak bisa diperpanjang karena sudah terlambat atau dikembalikan.');
        }

        // Perpanjang sesuai kebijakan buku
        $loan->due_date = $loan->due_date->addDays($loan->book->max_loan_days);
        $loan->save();

        $loan->user->notify(new LoanNotification($loan, 'renewed'));

        return back()->with('success', 'Peminjaman berhasil diperpanjang.');
    }

    // Extend (jika kamu punya mekanisme extend terpisah)
    public function extend(Request $request, Loan $loan)
    {
        // Jika extend hanya oleh pegawai/admin atau sesuai aturan, sesuaikan pengecekan
        if ($loan->return_date !== null) {
            return redirect()->back()->with('error', 'Loan sudah dikembalikan.');
        }

        $loan->due_date = $loan->due_date->addDays(7); // sesuaikan kebijakan
        $loan->is_extended = true; // pastikan kolom is_extended ada di db jika ingin disimpan
        $loan->save();

        return redirect()->back()->with('success', 'Loan berhasil diperpanjang.');
    }

    // Pengirim reminder (bisa dipanggil via scheduler)
    public function sendDueReminders()
    {
        $loans = Loan::where('status', 'borrowed')
            ->where('due_date', '<=', now()->addDays(2))
            ->where('due_date', '>', now())
            ->with(['user', 'book'])
            ->get();

        foreach ($loans as $loan) {
            $loan->user->notify(new LoanNotification($loan, 'due_soon'));
        }
    }
}
