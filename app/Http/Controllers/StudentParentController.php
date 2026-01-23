<?php

namespace App\Http\Controllers;

use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentParentController extends Controller
{
    public function index()
    {
        $parents = User::where('role', 'parent')->get();
        return view('admin.student_parents.index', compact('parents'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'parent',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'parent created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->back()->with('success', 'User updated successfully.');
    }
    public function destroy(User $student_parent)
    {
        $student_parent->delete();
        return redirect()->route('student-parents.index')->with('success', 'Parent deleted successfully!');
    }
}
