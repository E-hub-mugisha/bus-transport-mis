<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::orderBy('id', 'desc')->get();
        return view('admin.buses.index', compact('buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|unique:buses,plate_number',
            'capacity' => 'required|string',
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
        ]);

        // Generate bus number automatically
        $latestBus = Bus::latest()->first();
        if ($latestBus) {
            $lastNumber = (int) Str::after($latestBus->bus_number, 'BUS-');
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        $busNumber = 'BUS-' . $nextNumber;

        Bus::create([
            'bus_number' => $busNumber,
            'plate_number' => $request->plate_number,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Bus created successfully.');
    }

    public function edit(Bus $bus)
    {
        return response()->json($bus);
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'bus_number' => ['required', 'string', Rule::unique('buses', 'bus_number')->ignore($bus->id)],
            'plate_number' => ['required', 'string', Rule::unique('buses', 'plate_number')->ignore($bus->id)],
            'capacity' => 'required|string',
            'status' => ['required', Rule::in(['active', 'inactive', 'maintenance'])],
        ]);

        $bus->update($request->only(['bus_number', 'plate_number', 'capacity', 'status']));

        return redirect()->back()->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->back()->with('success', 'Bus deleted successfully.');
    }
}
