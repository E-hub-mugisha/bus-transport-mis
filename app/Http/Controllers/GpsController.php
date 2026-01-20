<?php

namespace App\Http\Controllers;

use App\Models\BusLocation;
use App\Models\Trip;
use App\Models\TripLog;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    public function startTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'bus_id' => 'required|exists:buses,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $trip = Trip::findOrFail($request->trip_id);

        // Update trip status
        $trip->update(['status' => 'ongoing']);

        // Save first GPS location
        BusLocation::create([
            'bus_id' => $request->bus_id,
            'trip_id' => $trip->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
        ]);

        foreach ($trip->bus->students as $student) {
            TripLog::create([
                'trip_id' => $trip->id,
                'student_id' => $student->id,
                'bus_id' => $trip->bus_id,
                'driver_id' => $trip->driver_id
            ]);
        }

        return redirect()->back()->with('success', 'Trip started and location saved!');
    }

    // Store GPS coordinates
    public function update(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $trip = Trip::where('id', $request->trip_id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        BusLocation::create([
            'bus_id' => $trip->bus_id,
            'trip_id' => $trip->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Location updated']);
    }
    public function liveView()
    {
        // Get all ongoing trips
        $trips = Trip::where('status', 'ongoing')->with('bus')->get();

        // Get distinct buses from ongoing trips
        $buses = $trips->pluck('bus')->unique('id');

        return view('admin.gps.live', compact('buses'));
    }
    // Fetch live locations
    public function live()
    {
        return Trip::with(['bus', 'route', 'latestLocation'])
            ->where('status', 'ongoing')
            ->get();
    }

    public function allBusLocationsWithRoute()
    {
        $locations = BusLocation::with(['bus', 'trip', 'trip.route'])
            ->orderBy('recorded_at', 'desc')
            ->get()
            ->unique('bus_id') // only latest per bus
            ->values();

        return response()->json($locations);
    }

    public function userTracking()
    {
        return view('users.bus-tracking');
    }

    public function dataTracking()
    {
        $trips = Trip::with([
            'bus',
            'route',
            'latestLocation'
        ])
            ->where('status', 'ongoing')
            ->get();

        return response()->json($trips);
    }

    public function liveBusWithPickupPoints()
    {
        $trips = Trip::with([
            'bus.students.pickupPoint',
            'route',
            'latestLocation'
        ])
            ->where('status', 'ongoing')
            ->get();

        return response()->json($trips);
    }
}
