<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = [
            [
                'name' => 'Route 1 – City Center',
                'start_point' => 'City Center',
                'end_point' => 'University Campus',
            ],
            [
                'name' => 'Route 2 – East Zone',
                'start_point' => 'East Market',
                'end_point' => 'University Campus',
            ],
            [
                'name' => 'Route 3 – West Zone',
                'start_point' => 'West Terminal',
                'end_point' => 'University Campus',
            ],
            [
                'name' => 'Route 4 – North Zone',
                'start_point' => 'North Station',
                'end_point' => 'University Campus',
            ],
            [
                'name' => 'Route 5 – South Zone',
                'start_point' => 'South Park',
                'end_point' => 'University Campus',
            ],
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate(
                [
                    'name' => $route['name'],
                    'start_point' => $route['start_point'],
                    'end_point' => $route['end_point'],
                ]
            );
        }
    }
}
