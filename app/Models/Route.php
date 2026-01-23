<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
   
    protected $fillable = [
        'name',
        'bus_id',
        'pickup_points',
        'dropoff_points'
    ];

    protected $casts = [
        'pickup_points' => 'array',
        'dropoff_points' => 'array',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}


