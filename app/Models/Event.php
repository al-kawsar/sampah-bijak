<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    public $incrementing = false; // Disable auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'id', 
        'title', 
        'description', 
        'date', 
        'location', 
        'organizer_id', 
        'image', 
        'max_participants'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
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

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
}
