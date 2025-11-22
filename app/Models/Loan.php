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

    // Tambahkan accessor untuk is_extended jika diperlukan (asumsi ada field 'is_extended' di database)
    public function getIsExtendedAttribute()
    {
        return $this->attributes['is_extended'] ?? false;  // Jika ada field di DB, atau logika lain
    }
}