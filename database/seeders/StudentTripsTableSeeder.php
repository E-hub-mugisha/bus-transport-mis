<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentTripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = DB::table('students')->get();
        $buses = DB::table('buses')->pluck('id')->toArray();

        if ($students->isEmpty() || empty($buses)) {
            $this->command->info("No students or buses found. Please seed them first.");
            return;
        }

        $records = [];

        foreach ($students as $index => $student) {
            $busId = $buses[$index % count($buses)];

            // Randomly assign pickup and drop-off statuses
            $pickedUpAt = now()->subMinutes(rand(30, 60));
            $droppedOffAt = now()->subMinutes(rand(1, 29));

            $records[] = [
                'student_id'  => $student->id,
                'bus_id'      => $busId,
                'status'      => 'picked_up',
                'recorded_at' => $pickedUpAt,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            $records[] = [
                'student_id'  => $student->id,
                'bus_id'      => $busId,
                'status'      => 'dropped_off',
                'recorded_at' => $droppedOffAt,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('student_trips')->insert($records);

        $this->command->info(count($records) . " student trips created successfully.");
    }
}
