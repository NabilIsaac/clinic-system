<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeePortalController extends Controller
{
    public function payroll()
    {
        return view('admin.employee.payroll');
    }

    public function leaveRequests()
    {
        return view('admin.employee.leave-requests');
    }

    public function schedule()
    {
        return view('admin.employee.schedule');
    }

    public function documents()
    {
        return view('admin.employee.documents');
    }

    public function payslips()
    {
        return view('admin.employee.documents.payslips');
    }

    public function contracts()
    {
        return view('admin.employee.documents.contracts');
    }

    public function taxDocuments()
    {
        return view('admin.employee.documents.tax-documents');
    }
}
