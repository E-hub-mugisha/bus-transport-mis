<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalBuses    = Bus::count();
        $totalRoutes   = Route::count();
        $totalParents  = User::where('role', 'parent')->count(); // adjust if needed

        // Students per bus (for chart)
        $buses = Bus::withCount('students')->get();
        $busLabels = $buses->pluck('plate_number');
        $busCounts = $buses->pluck('students_count');

        // Route usage (example: students per route via bus)
        $routes = \App\Models\Route::withCount('bus')->get(); 
        $routeLabels = $routes->pluck('name');
        $routeCounts = $routes->pluck('bus_count');

        // Recent students
        $recentStudents = Student::with(['parent', 'bus'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalBuses',
            'totalRoutes',
            'totalParents',
            'busLabels',
            'busCounts',
            'routeLabels',
            'routeCounts',
            'recentStudents'
        ));
    }
}
