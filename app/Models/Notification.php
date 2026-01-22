<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'message',
        'read',
    ];

    // Optional: automatically cast 'read' to boolean
    protected $casts = [
        'read' => 'boolean',
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
