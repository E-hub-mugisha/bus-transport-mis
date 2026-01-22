<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\Bus;

class RouteSeeder extends Seeder
{
    public function run()
    {
        $routes = [
            ['name'=>'Kigali City Route', 'pickup'=>['Kimironko','Remera','Gikondo'], 'dropoff'=>['IRERERO Academy']],
            ['name'=>'Kanombe Route', 'pickup'=>['Kanombe','Nyamirambo','Kicukiro'], 'dropoff'=>['IRERERO Academy']],
            ['name'=>'Gatsata Route', 'pickup'=>['Gatsata','Masoro','Nyarutarama'], 'dropoff'=>['IRERERO Academy']],
            ['name'=>'Kamonyi Route', 'pickup'=>['Runda','Kamonyi Centre','Ruyenzi'], 'dropoff'=>['IRERERO Academy']],
            ['name'=>'Kacyiru Route', 'pickup'=>['Kacyiru','Kimironko','Nyarutarama'], 'dropoff'=>['IRERERO Academy']],
        ];

        $buses = Bus::all();

        foreach($routes as $route){
            Route::create([
                'name' => $route['name'],
                'bus_id' => $buses->random()->id,
                'pickup_points' => json_encode($route['pickup']),
                'dropoff_points' => json_encode($route['dropoff'])
            ]);
        }
    }
}
