<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusTripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buses = DB::table('buses')->pluck('id')->toArray();
        $drivers = DB::table('users')->where('role', 'driver')->pluck('id')->toArray();

        if (empty($buses) || empty($drivers)) {
            $this->command->info("No buses or drivers found. Please seed them first.");
            return;
        }

        $trips = [];

        // Create 5 trips for demo
        for ($i = 0; $i < 5; $i++) {
            $busId = $buses[$i % count($buses)];
            $driverId = $drivers[$i % count($drivers)];

            // Randomly set some trips as started or ended
            $status = rand(0,1) ? 'started' : 'ended';
            $startTime = now()->subMinutes(rand(10, 120));
            $endTime = $status === 'ended' ? now()->subMinutes(rand(1, 9)) : null;

            $trips[] = [
                'bus_id'     => $busId,
                'driver_id'  => $driverId,
                'status'     => $status,
                'start_time' => $startTime,
                'end_time'   => $endTime,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('bus_trips')->insert($trips);

        $this->command->info(count($trips) . " bus trips created successfully.");
    }
}
