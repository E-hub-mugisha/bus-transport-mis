<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusStop extends Model
{
    // BusStop.php
    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
