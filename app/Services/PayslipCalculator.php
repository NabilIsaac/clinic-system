<?php

namespace App\Services;

class PayslipCalculator
{
    public function calculateOvertime($basicSalary, $overtimeHours, $overtimeRate)
    {
        $hourlyRate = $basicSalary / 176; // Assuming 22 working days * 8 hours
        return $overtimeHours * $hourlyRate * $overtimeRate;
    }

    public function calculatePerformanceBonus($basicSalary, $performanceScore)
    {
        $bonusPercentage = match(true) {
            $performanceScore >= 90 => 0.15, // 15% bonus
            $performanceScore >= 80 => 0.10, // 10% bonus
            $performanceScore >= 70 => 0.05, // 5% bonus
            default => 0
        };
        
        return $basicSalary * $bonusPercentage;
    }

    public function calculateAttendanceBonus($daysPresent, $totalWorkingDays)
    {
        $attendancePercentage = ($daysPresent / $totalWorkingDays) * 100;
        return $attendancePercentage >= 98 ? 500 : 0; // Example: $500 bonus for 98% attendance
    }
}
