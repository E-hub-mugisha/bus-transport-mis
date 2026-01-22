<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     * Send notification to a specific user
     */
    public static function send($userId, $message)
    {
        Notification::create([
            'user_id' => $userId,
            'message' => $message,
            'read' => false
        ]);
    }

    /**
     * Send bus-related notifications to parents of students on this bus
     */
    public static function notifyBusParents($busId, $message)
    {
        $students = Student::whereHas('buses', function($q) use ($busId){
            $q->where('buses.id', $busId);
        })->get();

        foreach($students as $student){
            self::send($student->parent_id, "[Bus {$busId}] " . $message);
        }
    }
}
