<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusLocation;
use App\Models\BusTrip;
use Illuminate\Http\Request;

class TripTrackingController extends Controller
{
    public function track(BusTrip $busTrip)
    {
        return view('driver.trips.track', compact('busTrip'));
    }

    // Update trip (Start / End)
    public function update(Request $request, BusTrip $busTrip)
    {
        $request->validate([
            'status' => 'required|in:started,ended',
        ]);

        if ($request->status === 'started') {
            $busTrip->update([
                'status' => 'started',
                'start_time' => now(),
                'end_time' => null,
            ]);
        } elseif ($request->status === 'ended') {
            $busTrip->update([
                'status' => 'ended',
                'end_time' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Trip status updated successfully');
    }

    public function show(Bus $bus)
    {
        // Get latest bus location for demo
        $locations = BusLocation::where('bus_id', $bus->id)
            ->orderBy('recorded_at', 'asc')
            ->get();

        return view('admin.buses.track', compact('bus', 'locations'));
    }

}
