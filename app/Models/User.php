<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // BARIS INI DIHILANGKAN

class User extends Authenticatable implements MustVerifyEmail 
{
    // HANYA MENGGUNAKAN TRAIT YANG DIPERLUKAN
    use HasFactory, Notifiable; 

    protected $fillable = [
        'name',
        'username',
        'email', 
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELATIONSHIPS ---
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    // --- ROLE & HELPER METHODS ---
    
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->role === 'admin' || $this->role === 'moderator';
    }

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->username, 0, 2));
    }
}