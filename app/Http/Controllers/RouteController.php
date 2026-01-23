<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Route as ModelsRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        return view('routes.index', [
            'routes' => ModelsRoute::with('bus')->latest()->get(),
            'buses'  => Bus::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bus_id' => 'required|exists:buses,id',
            'pickup_points' => 'required',
            'dropoff_points' => 'required',
        ]);

        Route::create([
            'name' => $request->name,
            'bus_id' => $request->bus_id,
            'pickup_points' => array_map('trim', explode(',', $request->pickup_points)),
            'dropoff_points' => array_map('trim', explode(',', $request->dropoff_points)),
        ]);

        return back()->with('success', 'Route created successfully');
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required',
            'bus_id' => 'required|exists:buses,id',
        ]);

        $route->update([
            'name' => $request->name,
            'bus_id' => $request->bus_id,
            'pickup_points' => array_map('trim', explode(',', $request->pickup_points)),
            'dropoff_points' => array_map('trim', explode(',', $request->dropoff_points)),
        ]);

        return back()->with('success', 'Route updated successfully');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return back()->with('success', 'Route deleted');
    }
}
