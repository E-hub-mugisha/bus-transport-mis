<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusLocation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusLocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        BusLocation::create([
            'bus_id' => $request->bus_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Location updated',
        ]);
    }
}
