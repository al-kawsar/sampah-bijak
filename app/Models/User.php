<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    public $incrementing = false; // Disable auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'region_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                // Generate UUID v4 for the ID if it's not set
                $model->id = (string) str()->uuid(); // Use uuid4 for unique ID
            }
        });
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    public function wasteReports()
    {
        return $this->hasMany(WasteReport::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function pickupSchedules()
    {
        return $this->hasMany(PickupSchedule::class);
    }

    /**
     * Relasi ke model UserProfile (satu pengguna memiliki satu profil)
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

}
