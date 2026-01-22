<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusTrip;
use App\Models\Bus;

class TripController extends Controller
{
    // Show all trips for this driver
    public function index()
    {
        $driver = auth()->user();
        $trips = BusTrip::with('bus')->where('driver_id', $driver->id)
                    ->orderBy('created_at','desc')->get();

        return view('driver.trips.index', compact('trips'));
    }

    // Start a trip
    public function start(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
        ]);

        $trip = BusTrip::create([
            'bus_id' => $request->bus_id,
            'driver_id' => auth()->id(),
            'status' => 'started',
            'start_time' => now()
        ]);

        return redirect()->back()->with('success','Trip started');
    }

    // End a trip
    public function end(BusTrip $trip)
    {
        if($trip->driver_id != auth()->id()) {
            abort(403);
        }

        $trip->update([
            'status' => 'ended',
            'end_time' => now()
        ]);

        return redirect()->back()->with('success','Trip ended');
    }
}
