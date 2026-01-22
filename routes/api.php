<?php

use App\Http\Controllers\GpsController;
use App\Models\Bus;
use Illuminate\Support\Facades\Route;
use App\Models\BusLocation;

Route::post('/gps/update', [GpsController::class, 'store']);
Route::get('/gps/{bus}', [GPSController::class, 'getLatest']); // For live tracking

Route::get('/buses', function() {
    $buses = Bus::with('locations')->get()->map(function($bus) {
        $latest = $bus->locations()->latest('recorded_at')->first();
        return [
            'id' => $bus->id,
            'plate_number' => $bus->plate_number,
            'latitude' => $latest->latitude ?? null,
            'longitude' => $latest->longitude ?? null,
        ];
    });
    return response()->json($buses);
});