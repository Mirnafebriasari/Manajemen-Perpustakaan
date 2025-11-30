<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'fine_amount',
        'status',
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getIsLateAttribute()
    {
        return $this->status === 'borrowed' && now()->greaterThan($this->due_date);
    }

    public function getIsExtendedAttribute()
    {
        return $this->attributes['is_extended'] ?? false; 
    }

    public function extendForPegawai(Request $request, Loan $loan)
{
    $user = auth()->user();

    // Hanya admin & pegawai yang boleh extend lewat sini
    if (!$user->hasAnyRole(['admin', 'pegawai'])) {
        return redirect()->back()->withErrors('Akses ditolak.');
    }

    // Cek apakah buku sudah dikembalikan
    if ($loan->return_date !== null) {
        return redirect()->back()->with('error', 'Loan sudah dikembalikan.');
    }

    // Cek apakah sudah diperpanjang sebelumnya
    if ($loan->is_extended) {
        return redirect()->back()->with('error', 'Peminjaman sudah pernah diperpanjang.');
    }

    // Lakukan perpanjangan
    $loan->due_date = $loan->due_date->addDays(7); 
    $loan->is_extended = true;
    $loan->save();

    return redirect()->back()->with('success', 'Peminjaman berhasil diperpanjang oleh pegawai.');
}

}