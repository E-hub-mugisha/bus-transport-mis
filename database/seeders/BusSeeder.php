<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use Illuminate\Support\Facades\DB;

class BusSeeder extends Seeder
{
    public function run()
    {
        // Get some driver IDs from users table
        $drivers = DB::table('users')->where('role', 'driver')->pluck('id')->toArray();

        if (empty($drivers)) {
            $this->command->info("No drivers found. Please seed users first.");
            return;
        }

        DB::table('buses')->insert([
            [
                'bus_number'   => 'BUS-001',
                'plate_number' => 'RAB-100A',
                'capacity'     => 40,
                'driver_id'    => $drivers[0] ?? 1,
                'status'       => 'active',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'bus_number'   => 'BUS-002',
                'plate_number' => 'RAB-101B',
                'capacity'     => 35,
                'driver_id'    => $drivers[1] ?? 1,
                'status'       => 'active',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'bus_number'   => 'BUS-003',
                'plate_number' => 'RAB-102C',
                'capacity'     => 50,
                'driver_id'    => $drivers[0] ?? 1,
                'status'       => 'maintenance',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'bus_number'   => 'BUS-004',
                'plate_number' => 'RAB-103D',
                'capacity'     => 45,
                'driver_id'    => $drivers[1] ?? 1,
                'status'       => 'inactive',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'bus_number'   => 'BUS-005',
                'plate_number' => 'RAB-104E',
                'capacity'     => 40,
                'driver_id'    => $drivers[0] ?? 1,
                'status'       => 'active',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
