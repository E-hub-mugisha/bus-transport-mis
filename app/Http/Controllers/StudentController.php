<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('parent')->get();
        $parents = StudentParent::all();
        return view('admin.students.index', compact('students', 'parents'));
    }
    public function store(Request $request)
    {
        $request->validate(['names' => 'required|string|max:255', 'student_parent_id' => 'required|exists:student_parents,id',]);
        $lastId = Student::max('id') ?? 0;
        $regNumber = 'STU-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        Student::create(['names' => $request->names, 'student_parent_id' => $request->student_parent_id, 'reg_number' => $regNumber,]);
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }
    public function update(Request $request, Student $student)
    {
        $request->validate(['names' => 'required|string|max:255', 'student_parent_id' => 'required|exists:student_parents,id',]);
        $student->update($request->only('names', 'student_parent_id'));
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
