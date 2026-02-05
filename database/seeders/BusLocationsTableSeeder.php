<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusLocationsTableSeeder extends Seeder
{
    public function run()
    {
        $buses = DB::table('buses')->pluck('id')->toArray();

        if (empty($buses)) {
            $this->command->info("No buses found. Please seed buses first.");
            return;
        }

        $locations = [];

        foreach ($buses as $busId) {
            // Generate 5 random locations per bus (for demo purposes)
            for ($i = 0; $i < 5; $i++) {
                $latitude = -2.0 + mt_rand(-5000, 5000)/10000;  // Random near Rwanda
                $longitude = 29.3 + mt_rand(-5000, 5000)/10000;

                $locations[] = [
                    'bus_id' => $busId,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'recorded_at' => now()->subMinutes(5 * (5-$i)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('bus_locations')->insert($locations);

        $this->command->info(count($locations) . " bus locations created successfully.");
    }
}
