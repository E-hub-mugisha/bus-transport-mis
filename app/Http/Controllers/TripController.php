<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['bus', 'driver.user', 'route'])->orderBy('trip_date','desc')->get();
        $buses = Bus::where('status','active')->get();
        $drivers = Driver::with('user')->get();
        $routes = Route::all();

        return view('admin.trips.index', compact('trips','buses','drivers','routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'driver_id' => 'required|exists:drivers,id',
            'route_id' => 'required|exists:routes,id',
            'trip_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'nullable',
            'status' => 'required|in:scheduled,ongoing,completed,delayed',
        ]);

        Trip::create($request->all());

        return redirect()->back()->with('success', 'Trip created successfully.');
    }

    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'driver_id' => 'required|exists:drivers,id',
            'route_id' => 'required|exists:routes,id',
            'trip_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'nullable',
            'status' => 'required|in:scheduled,ongoing,completed,delayed',
        ]);

        $trip->update($request->all());

        return redirect()->back()->with('success', 'Trip updated successfully.');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->back()->with('success', 'Trip deleted successfully.');
    }
}
