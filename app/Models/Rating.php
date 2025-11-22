<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'review',
    ];

    // Relasi ke user yang memberi rating
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke buku yang dirating
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
