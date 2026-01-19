<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;

class DriverLivePickupController extends Controller
{
    public function index()
    {
        $driver = auth()->user()->driver;

        $trip = Trip::with('bus')
            ->where('driver_id', $driver->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        $students = Student::whereHas('buses', function ($q) use ($trip) {
            $q->where('bus_id', $trip->bus_id);
        })->with('pickupPoint')->get();

        return view('drivers.pickups.live', compact('trip', 'students'));
    }
}
