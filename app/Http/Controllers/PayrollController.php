<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Display employee's payroll information and history
     */
    public function index()
    {
        // Get the authenticated user's employee record
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            abort(404, 'Employee record not found');
        }

        // Get payslips for the employee, ordered by period end date
        $payslips = Payslip::where('employee_id', $employee->id)
            ->orderBy('period_end', 'desc')
            ->get()
            ->map(function ($payslip) {
                // Calculate net pay
                $payslip->net_pay = $payslip->base_pay + $payslip->overtime_pay - $payslip->deductions;
                return $payslip;
            });

        return view('admin.employee.payroll', compact('employee', 'payslips'));
    }

    /**
     * Display detailed payslip information
     */
    public function showPayslip(Payslip $payslip)
    {
        // Ensure employee can only view their own payslips
        if ($payslip->employee_id !== auth()->user()->employee->id) {
            abort(403);
        }

        return view('admin.employee.payslip-details', compact('payslip'));
    }

    /**
     * Download payslip as PDF
     */
    public function downloadPayslip(Payslip $payslip)
    {
        // Ensure employee can only download their own payslips
        if ($payslip->employee_id !== auth()->user()->employee->id) {
            abort(403);
        }

        // Generate PDF (you'll need to implement this based on your PDF generation solution)
        $pdf = PDF::loadView('admin.employee.payslip-pdf', compact('payslip'));

        $fileName = "payslip-" . $payslip->period_end->format('Y-m') . ".pdf";
        
        return $pdf->download($fileName);
    }

    /**
     * Get current month's payroll summary
     */
    public function getCurrentMonthSummary()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            return response()->json(['error' => 'Employee record not found'], 404);
        }

        $currentMonth = Carbon::now();
        
        $payslip = Payslip::where('employee_id', $employee->id)
            ->whereYear('period_end', $currentMonth->year)
            ->whereMonth('period_end', $currentMonth->month)
            ->first();

        return response()->json([
            'base_salary' => $employee->base_salary,
            'current_month' => $currentMonth->format('F Y'),
            'payslip' => $payslip,
            'next_payment_date' => $currentMonth->endOfMonth()->format('M d, Y')
        ]);
    }
}