<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusLocation;
use App\Models\Bus;

class BusLocationSeeder extends Seeder
{
    public function run()
    {
        $busCoords = [
            [-1.944, 30.061],
            [-1.950, 30.058],
            [-1.945, 30.065],
            [-2.000, 29.980],
            [-1.970, 30.100]
        ];

        $buses = Bus::all();

        foreach($buses as $i => $bus){
            BusLocation::create([
                'bus_id' => $bus->id,
                'latitude' => $busCoords[$i][0],
                'longitude' => $busCoords[$i][1],
                'recorded_at' => now()
            ]);
        }
    }
}
