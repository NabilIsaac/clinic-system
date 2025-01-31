<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->latest()->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    // public function create()
    // {
    //     return view('admin.departments.create');
    // }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:departments,name',
                'description' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $department = Department::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department created successfully',
                    'department' => $department
                ]);
            }

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department created successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    $errors = collect($e->errors())->flatten()->first();
                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the department'
                ], 500);
            }

            return back()->withErrors(['error' => 'An error occurred while creating the department'])
                ->withInput();
        }
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->exists()) {
            return back()->with('error', 'Cannot delete department with associated employees.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
