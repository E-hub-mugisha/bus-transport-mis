<?php

namespace Database\Seeders;

use App\Models\BusLocation;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get ongoing trips only
        $trips = Trip::where('status', 'ongoing')->get();

        foreach ($trips as $trip) {

            // Starting coordinates (example – Kigali area)
            $latitude  = -1.9500000;
            $longitude = 30.0588000;

            // Generate multiple GPS points per trip
            for ($i = 0; $i < 5; $i++) {

                BusLocation::create([
                    'bus_id'      => $trip->bus_id,
                    'trip_id'     => $trip->id,
                    'latitude'    => $latitude + ($i * 0.0005),
                    'longitude'   => $longitude + ($i * 0.0005),
                    'recorded_at' => Carbon::now()->subMinutes(5 - $i),
                ]);
            }
        }
    }
}
