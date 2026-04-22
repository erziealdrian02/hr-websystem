<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminAttendanceController extends Controller
{
    public function attendanceAdmin()
    {
        $title = 'Daily Attendance Roster - HRIS';
        $today = Carbon::today()->format('Y-m-d');

        // Metrics Calculation
        $totalPresent = Attendance::where('attendance_date', $today)
            ->whereIn('status', ['present', 'late', 'half_day', 'wfh'])
            ->count();

        $lateToday = Attendance::where('attendance_date', $today)
            ->where('status', 'late')
            ->count();

        $onLeave = Leave::where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();
            
        $absent = Attendance::where('attendance_date', $today)
            ->where('status', 'absent')
            ->count();
            
        $remoteWorkers = Attendance::where('attendance_date', $today)
            ->where('status', 'wfh')
            ->count();

        // Get All attendances for today to display in roster
        $attendances = Attendance::with('employee')
            ->where('attendance_date', $today)
            ->orderBy('clock_in', 'asc')
            ->get();

        // Get Pending Corrections
        $pendingCorrections = AttendanceCorrection::with('attendance.employee')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('page-admin.admin-attendance', compact(
            'title',
            'totalPresent',
            'lateToday',
            'onLeave',
            'absent',
            'remoteWorkers',
            'attendances',
            'pendingCorrections'
        ));
    }

    public function approveCorrection($id)
    {
        $correction = AttendanceCorrection::findOrFail($id);

        if ($correction->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to approve.']);
        }

        $attendance = $correction->attendance;

        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Linked attendance record not found.']);
        }

        // Apply correction to the base attendance record
        $updateData = [];
        if ($correction->corrected_clock_in) {
            $updateData['clock_in'] = $correction->corrected_clock_in;
        }
        if ($correction->corrected_clock_out) {
            $updateData['clock_out'] = $correction->corrected_clock_out;
            
            // Recalculate duration if both are present
            $in = Carbon::parse($updateData['clock_in'] ?? $attendance->clock_in);
            $out = Carbon::parse($correction->corrected_clock_out);
            $updateData['working_minutes'] = $in->diffInMinutes($out);
        }

        $attendance->update($updateData);

        // Update correction status
        $correction->update([
            'status' => 'approved',
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Attendance correction approved successfully.']);
    }

    public function rejectCorrection($id)
    {
        $correction = AttendanceCorrection::findOrFail($id);

        if ($correction->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to reject.']);
        }

        // Update correction status
        $correction->update([
            'status' => 'rejected',
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Attendance correction rejected.']);
    }
}
