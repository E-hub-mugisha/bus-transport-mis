<?php

namespace App\Console\Commands;

use App\Mail\BusAlert;
use App\Models\BusLocation;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckBusDelays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-bus-delays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $buses = BusLocation::latest('recorded_at')->get();

        foreach ($buses as $bus) {
            $lastUpdate = $bus->recorded_at;
            if ($lastUpdate->diffInMinutes(now()) > 10) {
                // Notify all parents of students on this bus
                $students = Student::whereHas('buses', function ($q) use ($bus) {
                    $q->where('buses.id', $bus->bus_id);
                })->get();

                foreach ($students as $student) {
                    $message = "Bus #{$bus->bus_id} is delayed. Please be patient.";
                    Mail::to($student->parent->email)->send(new BusAlert($message));
                }
            }
        }
    }
}
