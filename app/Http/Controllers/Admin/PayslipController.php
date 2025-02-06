<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payslip;
use App\Services\PayslipService;
use Illuminate\Http\Request;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Number;

class PayslipController extends Controller
{
    protected $payslipService;

    public function __construct(PayslipService $payslipService)
    {
        $this->payslipService = $payslipService;
    }

    
    public function index(Request $request)
    {
        $query = Payslip::with(['employee.department'])
            ->when($request->period, function($q) use ($request) {
                return $q->whereMonth('period_start', Carbon::parse($request->period)->month)
                        ->whereYear('period_start', Carbon::parse($request->period)->year);
            })
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->department, function($q) use ($request) {
                return $q->whereHas('employee', function($q) use ($request) {
                    $q->where('department_id', $request->department);
                });
            })
            ->latest();

        $stats = [
            'total_payslips' => Payslip::whereMonth('created_at', now()->month)->count(),
            'total_paid' => Payslip::where('status', 'paid')->sum('net_salary'),
            'pending_approvals' => Payslip::where('status', 'draft')->count()
        ];

        $departments = Department::all();
        $payslips = $query->paginate(15);

        return view('admin.employee.payslips.index', compact('payslips', 'stats', 'departments'));
    }

    public function create(Employee $employee)
    {
        return view('admin.employee.payslips.create', compact('employee'));
    }

    public function bulkCreate()
    {
        $departments = Department::all();
        $employees = Employee::with('department')->get();
        return view('admin.employee.payslips.bulk-create', compact('departments', 'employees'));
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
        ]);

        $netSalary = $validated['basic_salary'] + 
                     ($validated['allowances'] ?? 0) - 
                     ($validated['deductions'] ?? 0);

        $employee->payslips()->create([
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'basic_salary' => $validated['basic_salary'],
            'allowances' => $validated['allowances'] ?? 0,
            'deductions' => $validated['deductions'] ?? 0,
            'net_salary' => $netSalary,
            'issue_date' => now(),
            'status' => 'draft'
        ]);

        return redirect()->route('admin.employee.payslips.index')
            ->with('success', 'Payslip created successfully');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0'
        ]);

        $validated['issue_date'] = now();

        $payslips = $this->payslipService->generateBulkPayslips(
            $validated['employee_ids'],
            $validated
        );

        // foreach ($payslips as $payslip) {
        //     $payslip->employee->notify(new PayslipGenerated($payslip));
        // }

        return redirect()->route('admin.employee.payslips.index')
            ->with('success', count($payslips) . ' payslips generated successfully');
    }

    public function show()
    {
        //
    }

    public function getEmployeePayslips()
    {
        $employee = auth()->user()->employee;
        // dd($employee);
        $payslips = $employee->payslips()->with('employee')->get();
        $baseSalary = Number::currency($employee->salary, in: 'GHS');
        return view('admin.employee.documents.payslips', compact('payslips', 'employee', 'baseSalary'));
    }

    public function showEmployeePayslip(Payslip $payslip)
    {
        // Ensure employee can only view their own payslips
        if ($payslip->employee_id !== auth()->user()->employee->id) {
            abort(403);
        }

        return view('admin.employee.documents.payslip-show', compact('payslip'));
    }

    public function downloadPDF(Payslip $payslip)
    {
        $pdf = $this->payslipService->generatePDF($payslip);
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="payslip-' . $payslip->employee->id . '-' . $payslip->created_at->format('Y-m') . '.pdf"'
        ]);
    }

    public function issue(Payslip $payslip)
    {
        $payslip->update(['status' => 'issued']);
        return redirect()->route('admin.employee.payslips.index')
            ->with('success', 'Payslip issued successfully');
    }
}
