<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard: summary of assigned buses and students
    public function dashboard()
    {
        $parent = auth()->user();

        $students = Student::with('buses','trips')->where('parent_id', $parent->id)->get();

        return view('parent.dashboard', compact('students'));
    }

    // Live bus tracking view
    public function trackBus()
    {
        $parent = auth()->user();
        $students = Student::with('buses')->where('parent_id', $parent->id)->get();

        // Collect assigned bus IDs
        $busIds = $students->pluck('buses')->flatten()->pluck('id')->unique();

        return view('parent.track', compact('busIds'));
    }
}
