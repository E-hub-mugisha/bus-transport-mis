<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buses = [
            [
                'bus_number'   => 'BUS-001',
                'capacity'     => '45',
                'plate_number' => 'RAB-123A',
                'status'       => 'active',
            ],
            [
                'bus_number'   => 'BUS-002',
                'capacity'     => '30',
                'plate_number' => 'RAB-456B',
                'status'       => 'active',
            ],
            [
                'bus_number'   => 'BUS-003',
                'capacity'     => '50',
                'plate_number' => 'RAB-789C',
                'status'       => 'maintenance',
            ],
            [
                'bus_number'   => 'BUS-004',
                'capacity'     => '40',
                'plate_number' => 'RAB-321D',
                'status'       => 'inactive',
            ],
            [
                'bus_number'   => 'BUS-005',
                'capacity'     => '35',
                'plate_number' => 'RAB-654E',
                'status'       => 'active',
            ],
        ];

        foreach ($buses as $bus) {
            Bus::updateOrCreate(
                ['bus_number' => $bus['bus_number']],
                $bus
            );
        }
    }
}
