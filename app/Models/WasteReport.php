<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
    /** @use HasFactory<\Database\Factories\WasteReportFactory> */
    use HasFactory;
    public $incrementing = false; // Disable auto increment
    protected $keyType = 'string';


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
}
