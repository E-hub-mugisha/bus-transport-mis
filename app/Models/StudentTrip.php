<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTrip extends Model
{
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'student_bus');
    }

    public function trips()
    {
        return $this->hasMany(StudentTrip::class);
    }
}
