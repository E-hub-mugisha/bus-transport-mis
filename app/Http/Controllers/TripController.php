<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusTrip;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $busTrips = BusTrip::with(['bus', 'driver'])->latest()->get();
        $buses    = Bus::all();
        $drivers  = User::where('role', 'driver')->get(); // adjust if needed

        return view('admin.trips.index', compact('busTrips', 'buses', 'drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id'    => 'required|exists:buses,id',
            'driver_id' => 'required|exists:users,id',
            'status'    => 'required|in:started,ended',
            'start_time'=> 'nullable|date',
            'end_time'  => 'nullable|date|after_or_equal:start_time',
        ]);

        BusTrip::create($request->all());

        return back()->with('success', 'Trip created successfully');
    }

    public function update(Request $request, BusTrip $busTrip)
    {
        $request->validate([
            'bus_id'    => 'required|exists:buses,id',
            'driver_id' => 'required|exists:users,id',
            'status'    => 'required|in:started,ended',
            'start_time'=> 'nullable|date',
            'end_time'  => 'nullable|date|after_or_equal:start_time',
        ]);

        $busTrip->update($request->all());

        return back()->with('success', 'Trip updated successfully');
    }

    public function destroy(BusTrip $busTrip)
    {
        $busTrip->delete();
        return back()->with('success', 'Trip deleted successfully');
    }

    public function dailyTrips()
    {
        $trips = BusTrip::with('bus', 'driver')
            ->whereDate('created_at', now())
            ->orderBy('start_time', 'desc')->get();

        return view('admin.trips.daily_trips', compact('trips'));
    }
}
