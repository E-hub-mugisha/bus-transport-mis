<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Bus;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $studentsData = [
            ['Eric', 'Mugisha','parent1@eduride.rw'],
            ['Fabrice','Ndayishimiye','parent2@eduride.rw'],
            ['Alice','Uwimana','parent3@eduride.rw'],
            ['Jean','Mutoni','parent1@eduride.rw'],
            ['Marie','Mukamana','parent2@eduride.rw'],
            ['Patrick','Nshimiyimana','parent3@eduride.rw']
        ];

        $buses = Bus::all();

        foreach($studentsData as $i => $s){
            $parent = User::where('email',$s[2])->first();

            $student = Student::create([
                'first_name' => $s[0],
                'last_name' => $s[1],
                'parent_id' => $parent->id
            ]);

            // Assign a bus randomly
            $student->buses()->attach($buses->random()->id);
        }
    }
}
