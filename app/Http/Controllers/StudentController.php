<?php

namespace App\Http\Controllers;

use App\Mail\BusAlert;
use App\Models\Bus;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentTrip;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('parent', 'buses')->get();
        $parents = User::where('role', 'parent')->get();
        $buses = Bus::all();
        return view('admin.students.index', compact('students', 'parents','buses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'parent_id' => 'required|exists:users,id',
            'bus_id' => 'required|exists:buses,id'
        ]);

        $lastId = Student::max('id') ?? 0;

        $regNumber = 'STU-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'parent_id' => $request->parent_id,
            'reg_number' => $regNumber,
        ]);

        // Assign student to bus
        $student->buses()->attach($request->bus_id);

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'names' => 'required|string|max:255',
            'student_parent_id' => 'required|exists:student_parents,id',
        ]);

        // Update bus assignment
        if ($request->bus_id) {
            $student->buses()->sync([$request->bus_id]);
        }

        $student->update($request->only('names', 'student_parent_id'));

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    public function show(Student $student)
    {
        $student->load([
            'trips.trip',
            'trips.driver',
            'buses'
        ]);

        return view('admin.students.show', compact('student'));
    }

    public function markTrip(Request $request, Student $student)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'status' => 'required|in:picked_up,dropped_off'
        ]);

        $trip = StudentTrip::create([
            'student_id' => $student->id,
            'bus_id' => $request->bus_id,
            'status' => $request->status,
            'recorded_at' => now()
        ]);

        // Notify parent
        $statusText = $request->status == 'picked_up' ? 'picked up' : 'dropped off';
        $message = "{$student->first_name} has been {$statusText} by bus #{$request->bus_id}";

        // Send email to parent
        Mail::to($student->parent->email)->send(new BusAlert($message));

        return response()->json(['message' => 'Student trip updated']);
    }
}
