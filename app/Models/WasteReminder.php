<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteReminder extends Model
{
    /** @use HasFactory<\Database\Factories\WasteReminderFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'reminder_time',
        'frequency',
        'is_active',
    ];
}
