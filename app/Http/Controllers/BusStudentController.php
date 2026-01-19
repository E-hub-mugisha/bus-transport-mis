<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Student;
use Illuminate\Http\Request;

class BusStudentController extends Controller
{
    public function index()
    {
        $buses = Bus::with('students')->get();
        $students = Student::all();

        return view('admin.bus_students.index', compact('buses', 'students'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $bus = Bus::findOrFail($request->bus_id);
        $bus->students()->syncWithoutDetaching([$request->student_id]);

        return back()->with('success', 'Student assigned to bus successfully');
    }

    public function remove(Bus $bus, Student $student)
    {
        $bus->students()->detach($student->id);

        return back()->with('success', 'Student removed from bus');
    }
}
