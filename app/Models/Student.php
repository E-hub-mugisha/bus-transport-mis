<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['names', 'reg_number', 'student_parent_id'];

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'student_parent_id');
    }
    // Student.php
    public function pickupPoint()
    {
        return $this->hasOne(StudentPickupPoint::class);
    }
    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'bus_students');
    }
}
