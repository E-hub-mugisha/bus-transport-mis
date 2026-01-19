<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['bus_number', 'plate_number', 'capacity', 'status'];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function locations()
    {
        return $this->hasMany(BusLocation::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'bus_students');
    }
}
