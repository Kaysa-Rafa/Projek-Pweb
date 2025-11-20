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

    // Relationships
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

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isModerator()
    {
        return $this->role === 'admin' || $this->role === 'moderator';
    }

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->username, 0, 2));
    }
}