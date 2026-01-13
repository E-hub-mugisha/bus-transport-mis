<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drivers = [
            [
                'name' => 'Driver One',
                'email' => 'driver1@busmis.com',
                'license_number' => 'DL-2001',
                'phone' => '0788000001',
            ],
            [
                'name' => 'Driver Two',
                'email' => 'driver2@busmis.com',
                'license_number' => 'DL-2002',
                'phone' => '0788000002',
            ],
            [
                'name' => 'Driver Three',
                'email' => 'driver3@busmis.com',
                'license_number' => 'DL-2003',
                'phone' => '0788000003',
            ],
            [
                'name' => 'Driver Four',
                'email' => 'driver4@busmis.com',
                'license_number' => 'DL-2004',
                'phone' => '0788000004',
            ],
            [
                'name' => 'Driver Five',
                'email' => 'driver5@busmis.com',
                'license_number' => 'DL-2005',
                'phone' => '0788000005',
            ],
        ];

        foreach ($drivers as $data) {

            // Create user
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'driver',
                ]
            );

            // Create driver
            Driver::updateOrCreate(
                ['license_number' => $data['license_number']],
                [
                    'user_id' => $user->id,
                    'phone' => $data['phone'],
                ]
            );
        }
    }
}
