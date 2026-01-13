<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'bus_id',
        'driver_id',
        'route_id',
        'trip_date',
        'departure_time',
        'arrival_time',
        'status'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function locations()
    {
        return $this->hasMany(BusLocation::class);
    }

    public function latestLocation()
    {
        return $this->hasOne(BusLocation::class)->latestOfMany('recorded_at');
    }
}
