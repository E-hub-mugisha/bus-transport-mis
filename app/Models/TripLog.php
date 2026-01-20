<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripLog extends Model
{
    protected $fillable = [
        'trip_id','student_id','bus_id','driver_id',
        'pickup_time','drop_time',
        'pickup_lat','pickup_lng',
        'drop_lat','drop_lng','status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
