<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payslip;
use App\Services\PayslipCalculator;
use PDF;

class PayslipService
{
    protected $calculator;

    public function __construct(PayslipCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    private function generatePayslipNumber()
    {
        $prefix = 'PSL';
        $year = date('Y');
        $month = date('m');
        $lastPayslip = Payslip::orderBy('id', 'desc')->first();
        $sequence = $lastPayslip ? ($lastPayslip->id + 1) : 1;
        
        return sprintf('%s%s%s%04d', $prefix, $year, $month, $sequence);
    }

    public function generatePDF(Payslip $payslip)
    {
        $pdf = PDF::loadView('admin.employee.payslips.pdf', [
            'payslip' => $payslip, 
            'employee' => $payslip->employee
        ]);
        return $pdf;
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
            'payslip_number' => $this->generatePayslipNumber(),
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

    /**
     * Generate payslips for multiple employees
     *
     * @param array $employeeIds
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function generateBulkPayslips(array $employeeIds, array $data)
    {
        $payslips = collect();
        $employees = Employee::whereIn('id', $employeeIds)->get();

        foreach ($employees as $employee) {
            // Calculate base salary based on days present
            $daysPresent = $data['days_present'] ?? 22;
            $totalDays = $data['total_working_days'] ?? 22;
            $baseSalary = ($daysPresent / $totalDays) * $employee->salary;

            // Calculate overtime
            $overtimeAmount = $this->calculator->calculateOvertime(
                $employee->salary,
                $data['overtime_hours'] ?? 0,
                $data['overtime_rate'] ?? 1.5
            );

            // Calculate net salary
            $netSalary = $baseSalary + 
                        $overtimeAmount + 
                        ($data['allowances'] ?? 0) - 
                        ($data['deductions'] ?? 0);

            // Create payslip
            $payslip = $employee->payslips()->create([
                'payslip_number' => $this->generatePayslipNumber(),
                'period_start' => $data['period_start'],
                'period_end' => $data['period_end'],
                'basic_salary' => $baseSalary,
                'overtime_hours' => $data['overtime_hours'] ?? 0,
                'overtime_rate' => $data['overtime_rate'] ?? 1.5,
                'overtime_amount' => $overtimeAmount,
                'allowances' => $data['allowances'] ?? 0,
                'deductions' => $data['deductions'] ?? 0,
                'net_salary' => $netSalary,
                'issue_date' => $data['issue_date'],
                'pay_date' => now(),
                'payment_method' => 'cash',
                'status' => 'draft'
            ]);

            $payslips->push($payslip);
        }

        return $payslips;
    }
}