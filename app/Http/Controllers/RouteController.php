<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::orderBy('id','desc')->get();
        return view('admin.routes.index', compact('routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:routes,name',
            'start_point' => 'required|string',
            'end_point' => 'required|string',
        ]);

        Route::create($request->only('name', 'start_point', 'end_point'));

        return redirect()->back()->with('success', 'Route created successfully.');
    }

    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|string|unique:routes,name,'.$route->id,
            'start_point' => 'required|string',
            'end_point' => 'required|string',
        ]);

        $route->update($request->only('name', 'start_point', 'end_point'));

        return redirect()->back()->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->back()->with('success', 'Route deleted successfully.');
    }
}
