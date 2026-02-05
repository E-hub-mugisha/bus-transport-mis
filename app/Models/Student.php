<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'reg_number',
        'parent_id',
        'bus_id',   // ✅ important
    ];


    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function trips()
    {
        return $this->hasMany(StudentTrip::class);
    }
}
