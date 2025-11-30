<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
        use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'university_email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
