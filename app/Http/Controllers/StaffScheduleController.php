<?php

namespace App\Http\Controllers;

use App\Models\StaffSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffScheduleController extends Controller
{
    public function index(Request $request)
    {
        $viewType = $request->get('view_type', 'grid');
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : now()->startOfWeek();
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : now()->endOfWeek();

        $staff = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['doctor', 'staff']);
        })->get();

        $query = StaffSchedule::with('user.roles');

        if ($viewType === 'list') {
            // For list view, get all schedules within date range
            $schedules = $query
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();
        } else {
            // For grid view, get all schedules grouped by user
            $schedules = $query->get()->groupBy('user_id');
        }

        return view('admin.schedules.index', compact('schedules', 'staff', 'viewType', 'startDate', 'endDate'));
    }

    public function create()
    {
        $staff = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['doctor', 'staff']);
        })->get();
        
        $daysOfWeek = StaffSchedule::$daysOfWeek;
        
        return view('admin.schedules.create', compact('staff', 'daysOfWeek'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_active' => 'boolean',
                'notes' => 'nullable|string'
            ]);

            // Check if schedule already exists for this user and day
            $existingSchedule = StaffSchedule::where('user_id', $validated['user_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->first();

            if ($existingSchedule) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'A schedule already exists for this staff member on ' . $validated['day_of_week']]);
            }

            StaffSchedule::create($validated);

            return redirect()->route('admin.staff-schedules.index')
                ->with('success', 'Schedule created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while creating the schedule. Please try again.']);
        }
    }

    public function edit(StaffSchedule $schedule)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'id' => $schedule->id,
                'user_id' => $schedule->user_id,
                'day_of_week' => $schedule->day_of_week,
                'start_time' => $schedule->start_time->format('H:i'),
                'end_time' => $schedule->end_time->format('H:i'),
                'is_active' => $schedule->is_active,
                'notes' => $schedule->notes,
            ]);
        }

        $staff = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['doctor', 'staff']);
        })->get();
        
        $daysOfWeek = StaffSchedule::$daysOfWeek;
        
        return view('admin.schedules.edit', compact('schedule', 'staff', 'daysOfWeek'));
    }

    public function update(Request $request, StaffSchedule $staffSchedule)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_active' => 'boolean',
                'notes' => 'nullable|string'
            ]);

            // Check if schedule already exists for this user and day, excluding current schedule
            $existingSchedule = StaffSchedule::where('user_id', $validated['user_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('id', '!=', $staffSchedule->id)
                ->first();

            if ($existingSchedule) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'A schedule already exists for this staff member on ' . $validated['day_of_week']]);
            }

            $staffSchedule->update($validated);

            return redirect()->route('admin.staff-schedules.index')
                ->with('success', 'Schedule updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while updating the schedule. Please try again.']);
        }
    }

    public function destroy(StaffSchedule $staffSchedule)
    {
        $staffSchedule->delete();

        return redirect()->route('admin.staff-schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
