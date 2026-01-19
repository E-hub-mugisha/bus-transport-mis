<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;

class DriverStudentController extends Controller
{
    public function index()
    {
        $driver = auth()->user()->driver;

        if (!$driver) {
            abort(403, 'Driver profile missing');
        }

        $trip = Trip::with('bus.students.pickupPoint')
            ->where('driver_id', $driver->id)
            ->where('status', 'ongoing')
            ->first();

        return view('drivers.students.index', compact('trip'));
    }

    public function show(Student $student)
    {
        $student->load('pickupPoint');

        return view('drivers.students.show', compact('student'));
    }
}
