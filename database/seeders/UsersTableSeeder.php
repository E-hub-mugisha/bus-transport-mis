<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'kabosierik@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Drivers
        $drivers = [
            ['Jean Pierre', 'driver1@eduride.rw'],
            ['Emmanuel', 'driver2@eduride.rw'],
            ['Patrick', 'driver3@eduride.rw']
        ];
        foreach($drivers as $d){
            User::create([
                'name' => $d[0],
                'email' => $d[1],
                'password' => Hash::make('password'),
                'role' => 'driver'
            ]);
        }

        // Parents
        $parents = [
            ['Alice Uwase','parent1@eduride.rw'],
            ['Jean Bosco','parent2@eduride.rw'],
            ['Marie Chantal','parent3@eduride.rw']
        ];
        foreach($parents as $p){
            User::create([
                'name' => $p[0],
                'email' => $p[1],
                'password' => Hash::make('password'),
                'role' => 'parent'
            ]);
        }
    }
}
