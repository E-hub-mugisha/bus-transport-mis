<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;

class BusSeeder extends Seeder
{
    public function run()
    {
        $plates = ['RAB-101A','RAB-102B','RAB-103C','RAB-104D','RAB-105E'];

        foreach($plates as $index => $plate){
            Bus::create([
                'plate_number' => $plate,
                'driver_id' => $index+1
            ]);
        }
    }
}
