<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Apply role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->role);
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);
        $roles = Role::all();

        return view('admin.employee.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $departments = Department::all();

        return view('admin.employee.create', compact('roles', 'permissions', 'departments'));
    }

    public function store(StoreUserRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();
    
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'address' => $validated['address'],
                'gender' => $validated['gender'],
                'occupation' => $validated['occupation'] ?? null,
                'marital_status' => $validated['marital_status'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'password' => Hash::make('password'),
            ]);
    
            // Create employee record
            $user->employee()->create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'joining_date' => $validated['joining_date'],
                'salary' => $validated['salary'],
                'account_name' => $validated['account_name'] ?? null,
                'account_number' => $validated['account_number'] ?? null,
                'bank_name' => $validated['bank_name'] ?? null,
                'bank_branch' => $validated['bank_branch'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_number' => $validated['emergency_contact_number'] ?? null,
                'relationship' => $validated['relationship'] ?? null,
                'qualifications' => $validated['qualifications'] ?? null,
                'specialization' => $validated['specialization'] ?? null
            ]);
    
            // Assign roles
            $user->assignRole($validated['roles']);
    
            // Assign additional permissions if any
            if (isset($validated['permissions'])) {
                $user->givePermissionTo($validated['permissions']);
            }
    
            return redirect()->route('admin.users.index')
                ->with('success', 'Employee created successfully');
        });
    }

    public function show(User $user)
    {
        return view('admin.employee.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.employee.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        // Sync roles
        $user->syncRoles($validated['roles']);

        // Sync permissions
        if (isset($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        } else {
            $user->syncPermissions([]); // Remove all direct permissions if none selected
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
