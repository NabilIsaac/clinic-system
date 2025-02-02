<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string'
        ]);

        $user = auth()->user();
        $role = Role::findByName($request->role);
        // dd($role);
        if ($user->hasRole($role)) {
            session(['current_role' => $request->role]);
            return redirect()->back()->with('success', 'Role switched successfully');
        }

        return redirect()->back()->with('error', 'Unauthorized role switch attempt');
    }
}
