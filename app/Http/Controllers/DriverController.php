<?php

namespace App\Http\Controllers;

use App\Mail\DriverCredentialsMail;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')->orderBy('id', 'desc')->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);

        // Generate random password
        $password = Str::random(10);

        // Auto-create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'driver'
        ]);


        // Send email with credentials
        Mail::to($user->email)->send(new DriverCredentialsMail($user->name, $user->email, $password));

        return redirect()->back()->with('success', 'Driver created successfully. Login credentials have been emailed.');
    }


    public function edit(User $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->names)],
            
        ]);

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        

        return redirect()->back()->with('success', 'Driver updated successfully.');
    }

    public function destroy(User $driver)
    {
        $driver->delete(); // user will also be deleted due to cascade
        return redirect()->back()->with('success', 'Driver deleted successfully.');
    }
}
