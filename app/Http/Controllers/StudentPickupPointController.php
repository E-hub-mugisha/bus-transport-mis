<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentPickupPoint;
use Illuminate\Http\Request;

class StudentPickupPointController extends Controller
{
    public function index()
    {
        $students = Student::with('pickupPoint')->get();
        return view('admin.pickup_points.index', compact('students'));
    }

    public function store(Request $request)
    {
        StudentPickupPoint::updateOrCreate(
            ['student_id' => $request->student_id],
            $request->only('latitude', 'longitude')
        );

        return back()->with('success', 'Pickup point saved successfully');
    }

    public function update(Request $request, StudentPickupPoint $pickup)
    {
        $pickup->update($request->only('latitude', 'longitude'));
        return back()->with('success', 'Pickup point updated');
    }

    public function destroy(StudentPickupPoint $pickup)
    {
        $pickup->delete();
        return back()->with('success', 'Pickup point removed');
    }
}
