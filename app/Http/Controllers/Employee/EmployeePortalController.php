<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeePortalController extends Controller
{
    public function payroll()
    {
        return view('employee.payroll');
    }

    public function leaveRequests()
    {
        return view('employee.leave-requests');
    }

    public function schedule()
    {
        return view('employee.schedule');
    }

    public function documents()
    {
        return view('employee.documents');
    }

    public function payslips()
    {
        return view('employee.documents.payslips');
    }

    public function contracts()
    {
        return view('employee.documents.contracts');
    }

    public function taxDocuments()
    {
        return view('employee.documents.tax-documents');
    }
}
