<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSlider extends Model
{
    /** @use HasFactory<\Database\Factories\HomepageSliderFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'order_number',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
