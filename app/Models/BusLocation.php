<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusLocation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'bus_id',
        'trip_id',
        'latitude',
        'longitude',
        'recorded_at',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
