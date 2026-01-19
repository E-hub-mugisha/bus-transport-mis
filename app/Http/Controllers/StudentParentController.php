<?php

namespace App\Http\Controllers;

use App\Models\StudentParent;
use Illuminate\Http\Request;

class StudentParentController extends Controller
{
    public function index()
    {
        $parents = StudentParent::all();
        return view('student_parents.index', compact('parents'));
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        StudentParent::create($request->only('name'));
        return redirect()->route('student-parents.index')->with('success', 'Parent added successfully!');
    }
    public function update(Request $request, StudentParent $student_parent)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $student_parent->update($request->only('name'));
        return redirect()->route('student-parents.index')->with('success', 'Parent updated successfully!');
    }
    public function destroy(StudentParent $student_parent)
    {
        $student_parent->delete();
        return redirect()->route('student-parents.index')->with('success', 'Parent deleted successfully!');
    }
}
