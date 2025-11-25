<?php
// app/Models/UserProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bio', 'website', 'twitter', 'github', 
        'avatar', 'location', 'signature'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}