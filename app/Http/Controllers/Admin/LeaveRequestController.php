<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:annual,sick,personal,unpaid',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        $leaveRequest = LeaveRequest::create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('admin.employee.leave-requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.employee.leave-requests', compact('leaveRequests'));
    }
}
