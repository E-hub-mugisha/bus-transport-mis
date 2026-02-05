<?php

namespace App\Http\Controllers;

use App\Models\BusLocation;
use App\Models\BusTrip;
use Illuminate\Http\Request;

class BusLocationController extends Controller
{
    // Store GPS location from driver
    public function store(Request $request)
    {
        $request->validate([
            'bus_id'    => 'required|exists:buses,id',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Check if there's an active trip for this bus
        $activeTrip = BusTrip::where('bus_id', $request->bus_id)
            ->where('status', 'started')
            ->latest()
            ->first();

        if (!$activeTrip) {
            return response()->json(['error' => 'No active trip'], 403);
        }

        // Save bus location
        $location = BusLocation::create([
            'bus_id'      => $request->bus_id,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'recorded_at' => now(),
        ]);

        return response()->json([
            'status' => 'ok',
            'location' => $location
        ]);
    }

    // Get latest location for a bus
    public function latest($busId)
    {
        $location = BusLocation::where('bus_id', $busId)
            ->latest()
            ->first();

        return response()->json($location);
    }
}
