<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buses   = Bus::pluck('id')->toArray();
        $drivers = Driver::pluck('id')->toArray();
        $routes  = Route::pluck('id')->toArray();

        // Safety check
        if (empty($buses) || empty($drivers) || empty($routes)) {
            $this->command->warn('Trips not seeded: missing buses, drivers, or routes.');
            return;
        }

        $trips = [
            [
                'bus_id' => $buses[0],
                'driver_id' => $drivers[0],
                'route_id' => $routes[0],
                'trip_date' => Carbon::today(),
                'departure_time' => '07:00:00',
                'arrival_time' => '08:30:00',
                'status' => 'completed',
            ],
            [
                'bus_id' => $buses[1] ?? $buses[0],
                'driver_id' => $drivers[1] ?? $drivers[0],
                'route_id' => $routes[1] ?? $routes[0],
                'trip_date' => Carbon::today(),
                'departure_time' => '09:00:00',
                'arrival_time' => null,
                'status' => 'ongoing',
            ],
            [
                'bus_id' => $buses[2] ?? $buses[0],
                'driver_id' => $drivers[2] ?? $drivers[0],
                'route_id' => $routes[2] ?? $routes[0],
                'trip_date' => Carbon::tomorrow(),
                'departure_time' => '06:30:00',
                'arrival_time' => null,
                'status' => 'scheduled',
            ],
            [
                'bus_id' => $buses[3] ?? $buses[0],
                'driver_id' => $drivers[3] ?? $drivers[0],
                'route_id' => $routes[3] ?? $routes[0],
                'trip_date' => Carbon::tomorrow(),
                'departure_time' => '07:30:00',
                'arrival_time' => null,
                'status' => 'delayed',
            ],
            [
                'bus_id' => $buses[4] ?? $buses[0],
                'driver_id' => $drivers[4] ?? $drivers[0],
                'route_id' => $routes[4] ?? $routes[0],
                'trip_date' => Carbon::tomorrow(),
                'departure_time' => '16:00:00',
                'arrival_time' => '17:30:00',
                'status' => 'completed',
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
