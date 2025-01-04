<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    /** @use HasFactory<\Database\Factories\FAQFactory> */
    use HasFactory;
    protected $fillable = [
        'question',
        'answer',
        'order_number',
    ];

    protected $casts = [
        'order_number' => 'integer',
    ];
}
