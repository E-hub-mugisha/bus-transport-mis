<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPickupPoint extends Model
{
    protected $fillable = ['student_id', 'latitude', 'longitude'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
