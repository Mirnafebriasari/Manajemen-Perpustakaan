<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'category',
        'stock',
        'max_loan_days',
        'fine_per_day',
        'description',
        'status',
    ];
    

    // Relasi ke Loan
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    // Relasi ke Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
