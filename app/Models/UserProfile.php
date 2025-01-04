<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'phone_number',
        'profile_picture',
    ];

    /**
     * Define relationship with User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
