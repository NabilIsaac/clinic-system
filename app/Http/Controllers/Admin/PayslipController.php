<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payslip;
use App\Services\PayslipService;
use Illuminate\Http\Request;
use App\Models\Department;

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
        \Log::info('Bulk create method called');
        return view('admin.employee.payslips.bulk-create');
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'issue_date' => 'required|date'
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
            'issue_date' => $validated['issue_date'],
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
            'issue_date' => 'required|date',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0'
        ]);

        $payslips = $this->payslipService->generateBulkPayslips(
            $validated['employee_ids'],
            $validated
        );

        foreach ($payslips as $payslip) {
            $payslip->employee->notify(new PayslipGenerated($payslip));
        }

        return redirect()->route('admin.employee.payslips.index')
            ->with('success', count($payslips) . ' payslips generated successfully');
    }

    public function show()
    {
        //
    }

    public function downloadPDF(Payslip $payslip)
    {
        $pdf = $this->payslipService->generatePDF($payslip);
        return $pdf->download("payslip-{$payslip->employee->id}-{$payslip->period_start->format('Y-m')}.pdf");
    }
}
