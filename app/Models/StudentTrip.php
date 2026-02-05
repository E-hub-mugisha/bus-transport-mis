<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTrip extends Model
{
    protected $fillable = [
        'student_id',
        'bus_id',
        'status',
        'recorded_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
