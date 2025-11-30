<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\LoanNotification;

class LoanController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasAnyRole(['admin', 'pegawai'])) {
            $loans = Loan::with(['user', 'book'])->latest()->paginate(15);
        } else {
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
        $user = auth()->user();

    $hasUnpaidFines = Loan::where('user_id', $user->id)
        ->where('fine_amount', '>', 0)
        ->whereIn('status', ['late', 'borrowed'])
        ->exists();

    if ($hasUnpaidFines) {
        return back()->withErrors(['error' => 'Anda tidak dapat meminjam buku baru karena memiliki denda tertunggak. Silakan lunasi terlebih dahulu.']);
    }

    $request->validate([
        'book_id' => 'required|exists:books,id',
        'quantity' => 'required|integer|min:1|max:10',
    ]);

    $book = Book::findOrFail($request->book_id);
    $existingLoan = Loan::where('user_id', auth()->id())
        ->where('book_id', $book->id)
        ->whereIn('status', ['borrowed', 'renewed'])
        ->first();

    if ($existingLoan) {
        return back()->withErrors(['book_id' => 'Anda sudah meminjam buku ini dan belum mengembalikannya.'])->withInput();
    }

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

    foreach ($loans as $loan) {
        $loan->user->notify(new LoanNotification($loan, 'borrowed'));
    }

    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.loans.index')->with('success', 'Buku berhasil dipinjam');
    } elseif ($user->hasRole('pegawai')) {
        return redirect()->route('loans.index')->with('success', 'Buku berhasil dipinjam');
    } else {
        return redirect()->route('books.show', $book->id)->with('success', 'Buku berhasil dipinjam');
    }
}

   public function update(Request $request, Loan $loan)
{
    if ($loan->status !== 'borrowed') {
        return back()->withErrors('Peminjaman sudah selesai atau dibatalkan');
    }

    $loan->return_date = now();

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
    app(\App\Http\Controllers\ReservationController::class)->processReservation($loan->book);
    return redirect()->back()->with('success', 'Pengembalian buku berhasil diproses');
}


   public function renew(Request $request, Loan $loan)
{
    if ($loan->user_id !== Auth::id()) {
        return back()->withErrors('Akses ditolak.');
    }

    if ($loan->status !== 'borrowed') {
        return back()->withErrors('Tidak bisa diperpanjang karena status peminjaman bukan aktif.');
    }

    if (now()->greaterThan($loan->due_date)) {
        return back()->withErrors('Tidak bisa diperpanjang karena sudah melewati tanggal jatuh tempo.');
    }
    if ($loan->extension_count >= 2) {
        return back()->withErrors('Masa perpanjangan sudah mencapai batas maksimal.');
    }
    $loan->due_date = $loan->due_date->addDays($loan->book->max_loan_days);
    $loan->extension_count = ($loan->extension_count ?? 0) + 1;
    $loan->save();
    $loan->user->notify(new LoanNotification($loan, 'renewed'));
    return back()->with('success', 'Peminjaman berhasil diperpanjang selama ' . $loan->book->max_loan_days . ' hari.');
}

  public function extend(Request $request, Loan $loan)
{
    if ($loan->return_date !== null) {
        return redirect()->back()->with('error', 'Loan sudah dikembalikan.');
    }

    $loan->due_date = $loan->due_date->addDays($loan->book->max_loan_days); 
    $loan->is_extended = true;
    $loan->save();

    return redirect()->back()->with('success', 'Loan berhasil diperpanjang.');
}

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

    public function returnBook($id)
{
    $loan = Loan::findOrFail($id);
    $book = $loan->book;


    $loan->update([
        'status' => 'returned',
        'return_date' => now()
    ]);

    $book->increment('stock');
    app(\App\Http\Controllers\ReservationController::class)->processReservation($book);
    return back()->with('success', 'Buku berhasil dikembalikan.');
}

public function destroy(Loan $loan)
{
    $user = auth()->user();
    if ($user->hasRole('admin') || $user->hasRole('pegawai')) {
        $loan->delete();
        return redirect()->back()->with('success', 'Riwayat peminjaman berhasil dihapus.');
    } elseif ($user->hasRole('mahasiswa')) {
        if ($loan->user_id === $user->id) {
            $loan->delete();
            return redirect()->back()->with('success', 'Riwayat peminjaman berhasil dihapus.');
        } else {
            return redirect()->back()->withErrors('Anda tidak berhak menghapus riwayat peminjaman ini.');
        }
    }

    return redirect()->back()->withErrors('Akses ditolak.');
}

}

