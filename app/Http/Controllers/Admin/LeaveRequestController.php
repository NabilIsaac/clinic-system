<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $leaveRequest = new LeaveRequest();
    
        $leaveBalances = [
            'annual' => [
                'name' => 'Annual Leave',
                'total' => LeaveRequest::LEAVE_TYPES['annual']['days'],
                'remaining' => $leaveRequest->getRemainingLeaveDays($user->id, 'annual'),
                'color' => 'blue'
            ],
            'sick' => [
                'name' => 'Sick Leave',
                'total' => LeaveRequest::LEAVE_TYPES['sick']['days'],
                'remaining' => $leaveRequest->getRemainingLeaveDays($user->id, 'sick'),
                'color' => 'green'
            ],
            'personal' => [
                'name' => 'Personal Leave',
                'total' => LeaveRequest::LEAVE_TYPES['personal']['days'],
                'remaining' => $leaveRequest->getRemainingLeaveDays($user->id, 'personal'),
                'color' => 'purple'
            ],
            'unpaid' => [
                'name' => 'Unpaid Leave',
                'total' => 'Unlimited',
                'remaining' => 'Subject to approval',
                'color' => 'orange'
            ]
        ];
    
        $leaveTypes = LeaveRequest::LEAVE_TYPES;
        $leaveRequests = LeaveRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
    
        return view('admin.employee.leave-requests', compact('leaveBalances', 'leaveTypes', 'leaveRequests'));
    }
    
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

    public function getAll()
    {
        $leaves = LeaveRequest::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.leaves.index', compact('leaves'));
    }

    public function showAll(LeaveRequest $leave)
    {
        return view('admin.leaves.show', compact('leave'));
    }

    public function approve(LeaveRequest $leave, Request $request)
    {
        try {
            $leave->update([
                'status' => 'approved',
                'admin_comment' => $request->admin_comment
            ]);

            // You can add notification logic here
            // Notify::send($leave->user, new LeaveRequestStatusChanged($leave));

            return back()->with('success', 'Leave request approved successfully.');
        } catch (\Exception $e) {
            Log::error('Error approving leave request: ' . $e->getMessage());
            return back()->with('error', 'Failed to approve leave request.');
        }
    }

    public function reject(LeaveRequest $leave, Request $request)
    {
        try {
            $leave->update([
                'status' => 'rejected',
                'admin_comment' => $request->admin_comment
            ]);

            // You can add notification logic here
            // Notify::send($leave->user, new LeaveRequestStatusChanged($leave));

            return back()->with('success', 'Leave request rejected successfully.');
        } catch (\Exception $e) {
            Log::error('Error rejecting leave request: ' . $e->getMessage());
            return back()->with('error', 'Failed to reject leave request.');
        }
    }

    public function destroy(LeaveRequest $leave)
    {
        try {
            $leave->delete();
            return back()->with('success', 'Leave request deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting leave request: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete leave request.');
        }
    }

}
