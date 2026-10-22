<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_code',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function seminars()
    {
        return $this->hasMany(Seminar::class, 'created_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
