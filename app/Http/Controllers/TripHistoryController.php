<?php

namespace App\Http\Controllers;

use App\Models\BusStudent;
use App\Models\Student;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripHistoryController extends Controller
{
    public function index()
    {
        return view('user.trip-history.index');
    }

    public function data()
    {
        $user = auth()->user();

        // Parent → Student
        $student = Student::where('parent_id', $user->id)->first();

        if (!$student) {
            return response()->json([]);
        }

        // Bus assigned to student
        $busId = BusStudent::where('student_id', $student->id)
            ->value('bus_id');

        if (!$busId) {
            return response()->json([]);
        }

        // Completed trips
        $trips = Trip::with(['bus', 'route'])
            ->where('bus_id', $busId)
            ->whereIn('status', ['completed', 'delayed'])
            ->orderBy('trip_date', 'desc')
            ->get();

        return response()->json($trips);
    }
}
