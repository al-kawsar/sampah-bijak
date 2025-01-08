<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteReport extends Model
{
    use HasFactory;

    protected $table = 'waste_reports';
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena menggunakan UUID
    protected $keyType = 'string'; // UUID adalah string

    protected $fillable = [
        'id',
        'user_id',
        'location_id',
        'category_id',
        'quantity',
        'description',
        'status',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model WasteLocation
     */
    public function location()
    {
        return $this->belongsTo(WasteLocation::class, 'location_id');
    }

    /**
     * Relasi ke model WasteCategory
     */
    public function category()
    {
        return $this->belongsTo(WasteCategory::class, 'category_id');
    }
}
