<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with('bus')->get();
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $buses = Bus::all();
        return view('admin.routes.create', compact('buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_point' => 'required',
            'end_point' => 'required'
        ]);

        Route::create([
            'name' => $request->name,
            'start_point' => $request->start_point,
            'end_point' => $request->end_point,
            'pickup_points' => $request->pickup_points,
            'bus_id' => $request->bus_id
        ]);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully');
    }

    public function edit(Route $route)
    {
        $buses = Bus::all();
        return view('admin.routes.edit', compact('route', 'buses'));
    }

    public function update(Request $request, Route $route)
    {
        $route->update($request->all());

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully');
    }
}
