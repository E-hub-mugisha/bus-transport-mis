<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['name', 'start_point', 'end_point'];

    // Route.php
    public function busStops()
    {
        return $this->hasMany(BusStop::class);
    }
}
