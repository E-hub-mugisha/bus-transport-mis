<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Bus;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all parent IDs
        $parents = DB::table('users')->where('role', 'parent')->pluck('id')->toArray();
        // Get all bus IDs
        $buses = DB::table('buses')->pluck('id')->toArray();

        if (empty($parents) || empty($buses)) {
            $this->command->info("No parents or buses found. Please seed them first.");
            return;
        }

        $students = [
            ['first_name' => 'John', 'last_name' => 'Doe'],
            ['first_name' => 'Alice', 'last_name' => 'Smith'],
            ['first_name' => 'Michael', 'last_name' => 'Brown'],
            ['first_name' => 'Emily', 'last_name' => 'Johnson'],
            ['first_name' => 'David', 'last_name' => 'Williams'],
        ];

        $insertData = [];

        foreach ($students as $index => $student) {
            $regNumber = 'STU-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            // Assign parent and bus round-robin
            $parentId = $parents[$index % count($parents)];
            $busId = $buses[$index % count($buses)];

            $insertData[] = [
                'first_name' => $student['first_name'],
                'last_name'  => $student['last_name'],
                'reg_number' => $regNumber,
                'parent_id'  => $parentId,
                'bus_id'     => $busId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('students')->insert($insertData);

        $this->command->info(count($students) . " students created successfully.");
    }
}
