<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Helper methods untuk cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isKonsumen(): bool
    {
        return $this->role === 'konsumen';
    }
}