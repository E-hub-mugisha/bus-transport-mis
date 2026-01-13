<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@busmis.com',
                'role' => 'super_admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@busmis.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@busmis.com',
                'role' => 'manager',
            ],
            [
                'name' => 'Driver',
                'email' => 'driver@busmis.com',
                'role' => 'driver',
            ],
            [
                'name' => 'Normal User',
                'email' => 'user@busmis.com',
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}
