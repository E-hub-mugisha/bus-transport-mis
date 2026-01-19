<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;

class UserBusTrackingController extends Controller
{
    public function index()
    {
        return view('user.bus-tracking.index');
    }

    public function data()
    {
        $user = auth()->user();

        // Student linked to this parent/user
        $student = Student::where('parent_id', $user->id)->first();

        if (!$student) {
            return response()->json([]);
        }

        $trip = Trip::with([
                'bus',
                'route',
                'latestLocation'
            ])
            ->where('bus_id', function ($q) use ($student) {
                $q->select('bus_id')
                  ->from('bus_students')
                  ->where('student_id', $student->id)
                  ->limit(1);
            })
            ->where('status', 'ongoing')
            ->first();

        return response()->json($trip ? [$trip] : []);
    }
}
