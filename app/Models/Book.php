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
        'rating',
        'photo', 
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'stock' => 'integer',
        'max_loan_days' => 'integer',
        'fine_per_day' => 'decimal:2',
        'rating' => 'float',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
