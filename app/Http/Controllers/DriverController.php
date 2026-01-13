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
        $drivers = Driver::with('user')->orderBy('id', 'desc')->get();
        return view('drivers.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'license_number' => 'required|string|unique:drivers,license_number',
            'phone' => 'required|string',
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

        // Create driver
        Driver::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'phone' => $request->phone,
        ]);

        // Send email with credentials
        Mail::to($user->email)->send(new DriverCredentialsMail($user->name, $user->email, $password));

        return redirect()->back()->with('success', 'Driver created successfully. Login credentials have been emailed.');
    }


    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($driver->user_id)],
            'license_number' => ['required', 'string', Rule::unique('drivers', 'license_number')->ignore($driver->id)],
            'phone' => 'required|string',
        ]);

        // Update user
        $driver->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update driver
        $driver->update([
            'license_number' => $request->license_number,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete(); // user will also be deleted due to cascade
        return redirect()->back()->with('success', 'Driver deleted successfully.');
    }
}
