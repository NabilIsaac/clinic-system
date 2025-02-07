<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    const LEAVE_TYPES = [
        'annual' => ['name' => 'Annual Leave', 'days' => 15],
        'sick' => ['name' => 'Sick Leave', 'days' => 10],
        'personal' => ['name' => 'Personal Leave', 'days' => 5],
        'unpaid' => ['name' => 'Unpaid Leave', 'days' => null]
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
    // Add method to calculate remaining leave days
    public function getRemainingLeaveDays($userId, $leaveType)
    {
        $totalDays = self::LEAVE_TYPES[$leaveType]['days'];
        if ($totalDays === null) return null; // For unpaid leave
    
        $usedDays = self::where('user_id', $userId)
            ->where('type', $leaveType)
            ->where('status', 'approved')
            ->whereYear('created_at', date('Y'))
            ->get()
            ->sum(function($leave) {
                return Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
            });
    
        return $totalDays - $usedDays;
    }
}
