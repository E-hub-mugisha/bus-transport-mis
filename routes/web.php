<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::get('buses', [BusController::class, 'index'])->name('buses.index');
    Route::post('buses', [BusController::class, 'store'])->name('buses.store');
    Route::get('buses/{bus}/edit', [BusController::class, 'edit'])->name('buses.edit');
    Route::put('buses/{bus}', [BusController::class, 'update'])->name('buses.update');
    Route::delete('buses/{bus}', [BusController::class, 'destroy'])->name('buses.destroy');

    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::post('drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');

    Route::get('routes', [RouteController::class, 'index'])->name('routes.index');
    Route::post('routes', [RouteController::class, 'store'])->name('routes.store');
    Route::get('routes/{route}/edit', [RouteController::class, 'edit'])->name('routes.edit');
    Route::put('routes/{route}', [RouteController::class, 'update'])->name('routes.update');
    Route::delete('routes/{route}', [RouteController::class, 'destroy'])->name('routes.destroy');

    Route::get('trips', [TripController::class, 'index'])->name('trips.index');
    Route::post('trips', [TripController::class, 'store'])->name('trips.store');
    Route::put('trips/{trip}', [TripController::class, 'update'])->name('trips.update');
    Route::delete('trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

    Route::post('/gps/update', [GpsController::class, 'update']);

    /* GPS MAP PAGE */
    Route::get('/gps', [GpsController::class, 'liveView'])->name('gps.live.view');

    Route::get('/gps/all', [GpsController::class, 'allBusLocationsWithRoute'])->name('gps.all');
    /* GPS LIVE DATA (JSON) */
    Route::get('/gps/live', [GpsController::class, 'live'])
        ->name('gps.live.data');

    // Start trip & auto-save location
    Route::post('/gps/start-trip', [GpsController::class, 'startTrip'])
        ->name('gps.start.trip');

    Route::get('/bus-tracking', [GpsController::class, 'userTracking'])
        ->name('user.bus.tracking');

    Route::get('/bus-tracking/data', [GpsController::class, 'dataTracking'])
        ->name('user.bus.tracking.data');
});


require __DIR__ . '/auth.php';
