<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ContactMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'subject', 
        'message', 
        'status'
    ];

    // Mengatur tipe data kolom dalam model
    protected $casts = [
        'status' => 'string', // Status sudah dalam bentuk enum, bisa cast ke string
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
