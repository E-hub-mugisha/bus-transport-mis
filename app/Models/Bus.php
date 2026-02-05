<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['bus_number', 'plate_number', 'capacity', 'status', 'driver_id'];

    public function trips()
    {
        return $this->hasMany(BusTrip::class);
    }

    public function locations()
    {
        return $this->hasMany(BusLocation::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_trips', 'bus_id', 'student_id')
                    ->withTimestamps();
    }

    public function latestLocation()
    {
        return $this->hasOne(BusLocation::class)->latestOfMany();
    }
}
