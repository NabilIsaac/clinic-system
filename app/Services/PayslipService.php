<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payslip;
use App\Services\PayslipCalculator;
use Carbon\Carbon;
use PDF;

class PayslipService
{
    protected $calculator;

    public function __construct(PayslipCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function generatePayslip(Employee $employee, array $data)
    {
        // Calculate overtime
        $overtimeAmount = $this->calculator->calculateOvertime(
            $employee->basic_salary,
            $data['overtime_hours'] ?? 0,
            $data['overtime_rate'] ?? 1.5
        );

        // Calculate performance bonus
        $performanceBonus = $this->calculator->calculatePerformanceBonus(
            $employee->basic_salary,
            $data['performance_score'] ?? 0
        );

        // Calculate attendance bonus
        $attendanceBonus = $this->calculator->calculateAttendanceBonus(
            $data['days_present'] ?? 0,
            $data['total_working_days'] ?? 22
        );

        // Calculate net salary
        $netSalary = $employee->basic_salary +
                     $overtimeAmount +
                     $performanceBonus +
                     $attendanceBonus +
                     ($data['other_bonuses'] ?? 0) +
                     ($data['allowances'] ?? 0) -
                     ($data['deductions'] ?? 0);

        return Payslip::create([
            'employee_id' => $employee->id,
            'period_start' => $data['period_start'],
            'period_end' => $data['period_end'],
            'basic_salary' => $employee->basic_salary,
            'overtime_hours' => $data['overtime_hours'] ?? 0,
            'overtime_rate' => $data['overtime_rate'] ?? 1.5,
            'overtime_amount' => $overtimeAmount,
            'performance_bonus' => $performanceBonus,
            'attendance_bonus' => $attendanceBonus,
            'other_bonuses' => $data['other_bonuses'] ?? 0,
            'bonus_description' => $data['bonus_description'] ?? null,
            'allowances' => $data['allowances'] ?? 0,
            'deductions' => $data['deductions'] ?? 0,
            'net_salary' => $netSalary,
            'issue_date' => $data['issue_date'],
            'status' => 'draft'
        ]);
    }
}