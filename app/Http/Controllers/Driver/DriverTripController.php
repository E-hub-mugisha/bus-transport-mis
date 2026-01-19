<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class DriverTripController extends Controller
{
    public function myTrips()
    {
        $trips = Trip::with([
            'bus.students.pickupPoint',
            'route'
        ])
            ->where('driver_id', auth()->user()->driver->id)
            ->where('status', 'ongoing')
            ->first();

        return view('drivers.trips.index', compact('trips'));
    }
}
