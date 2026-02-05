<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Student;
use App\Models\StudentTrip;

class StudentTripController extends Controller
{
    public function index()
    {
        $studentTrips = StudentTrip::with(['student', 'bus'])->latest()->get();
        $students = Student::all();
        $buses = Bus::all();

        return view('admin.student_trips.index', compact('studentTrips', 'students', 'buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'bus_id'      => 'required|exists:buses,id',
            'status'      => 'nullable|in:picked_up,dropped_off',
            'recorded_at' => 'nullable|date',
        ]);

        StudentTrip::create($request->all());

        return back()->with('success', 'Student trip recorded successfully');
    }

    public function update(Request $request, StudentTrip $studentTrip)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'bus_id'      => 'required|exists:buses,id',
            'status'      => 'nullable|in:picked_up,dropped_off',
            'recorded_at' => 'nullable|date',
        ]);

        $studentTrip->update($request->all());

        return back()->with('success', 'Student trip updated successfully');
    }

    public function destroy(StudentTrip $studentTrip)
    {
        $studentTrip->delete();
        return back()->with('success', 'Student trip deleted');
    }
}
