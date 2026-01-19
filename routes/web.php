<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\BusStudentController;
use App\Http\Controllers\Driver\DriverDashboardController;
use App\Http\Controllers\Driver\DriverGPSController;
use App\Http\Controllers\Driver\DriverLivePickupController;
use App\Http\Controllers\Driver\DriverStudentController;
use App\Http\Controllers\Driver\DriverTripController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentParentController;
use App\Http\Controllers\StudentPickupPointController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\TripHistoryController;
use App\Http\Controllers\UserBusTrackingController;
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

    Route::get('/student-parents', [StudentParentController::class, 'index'])->name('student-parents.index');
    Route::post('/student-parents', [StudentParentController::class, 'store'])->name('student-parents.store');
    Route::put('/student-parents/{student_parent}', [StudentParentController::class, 'update'])->name('student-parents.update');
    Route::delete('/student-parents/{student_parent}', [StudentParentController::class, 'destroy'])->name('student-parents.destroy');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/bus-students', [BusStudentController::class, 'index'])
        ->name('bus-students.index');

    Route::post('/bus-students/assign', [BusStudentController::class, 'assign'])
        ->name('bus-students.assign');

    Route::delete('/bus-students/{bus}/{student}', [BusStudentController::class, 'remove'])
        ->name('bus-students.remove');

    Route::get('/pickup-points', [StudentPickupPointController::class, 'index'])
        ->name('pickup-points.index');

    Route::post('/pickup-points', [StudentPickupPointController::class, 'store'])
        ->name('pickup-points.store');

    Route::put('/pickup-points/{pickup}', [StudentPickupPointController::class, 'update'])
        ->name('pickup-points.update');

    Route::delete('/pickup-points/{pickup}', [StudentPickupPointController::class, 'destroy'])
        ->name('pickup-points.destroy');

    // ADMIN – Live pickup monitoring
    Route::get('/gps/live-pickups', function () {
        return view('gps.live_pickups');
    })->name('gps.live.pickups.view');

    // DATA API
    Route::get(
        '/gps/live-pickups/data',
        [GpsController::class, 'liveBusWithPickupPoints']
    )->name('gps.live.pickups');

    // DRIVER VIEW
    Route::get('/driver/pickups', function () {
        return view('driver.pickups_live');
    })->name('driver.pickups.live');

    // USER / PARENT VIEW
    Route::get('/bus/tracking', function () {
        return view('user.bus_tracking');
    })->name('user.bus.tracking');

    Route::get('/reports', [BusStudentController::class, 'index'])
        ->name('reports.index');
});

Route::middleware(['auth', 'role:driver'])->prefix('driver')->group(function () {

    Route::get('/dashboard', [DriverDashboardController::class, 'index'])
        ->name('driver.dashboard');

    Route::get('/trips', [DriverTripController::class, 'myTrips'])
        ->name('driver.trips');

    Route::get('/student/pickups/live', [DriverLivePickupController::class, 'index'])
        ->name('driver.pickups.student.live');

    Route::post('/bus/location', [DriverGPSController::class, 'update'])
        ->name('driver.bus.location');

    Route::get('/students', [DriverStudentController::class, 'index'])
        ->name('driver.students');

    Route::get('/students/{student}', [DriverStudentController::class, 'show'])
        ->name('driver.students.show');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/bus-tracking', [UserBusTrackingController::class, 'index'])
        ->name('user.bus.tracking');

    Route::get('/bus-tracking/data', [UserBusTrackingController::class, 'data'])
        ->name('user.bus.tracking.data');

    Route::get('/trip-history', [TripHistoryController::class, 'index'])
        ->name('trip.history');

    Route::get('/trip-history/data', [TripHistoryController::class, 'data'])
        ->name('trip.history.data');
});

require __DIR__ . '/auth.php';
