<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\BusLocation;
use Illuminate\Http\Request;

class DriverGPSController extends Controller
{
    public function update(Request $request)
    {
        BusLocation::create([
            'bus_id' => $request->bus_id,
            'trip_id' => $request->trip_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
        ]);

        return response()->json(['status' => 'ok']);
    }
}
