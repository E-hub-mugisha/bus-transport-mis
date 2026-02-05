<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            BusSeeder::class,
            RouteSeeder::class,
            StudentsTableSeeder::class,
            BusTripsTableSeeder::class,
            StudentTripsTableSeeder::class,
            BusLocationsTableSeeder::class,
        ]);
    }
}
