<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'pickup_points',
        'bus_id'
    ];

    protected $casts = [
        'pickup_points' => 'array',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
