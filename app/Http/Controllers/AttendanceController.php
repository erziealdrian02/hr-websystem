<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function attendance(Request $request)
    {
        $tile = 'Attendance - HRIS';
        $month = $request->input('month', date('Y-m'));
        $parsedDate = \Carbon\Carbon::parse($month);

        $attendances = Attendance::with('corrections')->where('user_id', Auth::id())
            ->where('employee_id', Auth::user()->employee_id)
            ->whereMonth('attendance_date', $parsedDate->month)
            ->whereYear('attendance_date', $parsedDate->year)
            ->latest('attendance_date')
            ->get();

        return view('page-attendance.attendance', compact(
            'tile',
            'attendances',
            'month'
        ));
    }

    public function store(Request $request)
    {
        $loginEmployee = Auth::user()->employee_id;
        $employee = Employee::findOrFail($loginEmployee);

        if (!$employee || !$employee->placement || !$employee->placement->clientLocation) {
            return redirect()->back()->with('error', 'No client location assigned to you.');
        }

        $clientLocation = $employee->placement->clientLocation;

        $type = $request->input('attendance_type', 'office');
        $notes = $request->input('notes');

        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        $workStartTime = \Carbon\Carbon::parse($clientLocation->work_start_time);
        $now = now();

        $status = 'on_time';
        $locationNote = '';

        if ($type === 'office') {
            if (!$lat || !$lng) {
                return redirect()->back()->with('error', 'Location is required.');
            }

            // Haversine formula
            $earthRadius = 6371000; // in meters
            $latFrom = deg2rad($lat);
            $lonFrom = deg2rad($lng);
            $latTo = deg2rad($clientLocation->latitude);
            $lonTo = deg2rad($clientLocation->longitude);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            $distance = $angle * $earthRadius;

            if ($distance > $clientLocation->attendance_radius_meter) {
                return redirect()->back()->with('error', 'Out of range. Distance: ' . round($distance) . 'm. Max: ' . $clientLocation->attendance_radius_meter . 'm.');
            }

            $status = $now->format('H:i') > $workStartTime->format('H:i') ? 'late_in' : 'on_time';
            $locationNote = 'Within radius (' . round($distance) . 'm)';
        } elseif ($type === 'wfh') {
            $status = 'wfh';
            $locationNote = 'WFH: ' . $notes;
        } elseif ($type === 'leave') {
            $status = 'leave';
            $locationNote = trim('Leave/Sick: ' . $notes);
        }

        $exists = Attendance::where('employee_id', $employee->id)
            ->where('attendance_date', date('Y-m-d'))
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already clocked in today.');
        }

        $uuid = Str::uuid();

        $attendance = new Attendance();
        $attendance->id = $uuid;
        $attendance->employee_id = $employee->id;
        $attendance->user_id = Auth::id();
        $attendance->attendance_date = $now->format('Y-m-d');
        $attendance->clock_in = $now->format('H:i:s');
        $attendance->status = $status;
        $attendance->location_note = $locationNote;
        $attendance->ip_address = $request->ip();
        $attendance->created_by = Auth::id();

        $attendance->save();

        return redirect()->back()->with('success', 'Clock in successful at ' . $attendance->clock_in);
    }

    /**
     * Update the specified resource in storage (Clock Out).
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->clock_out !== null) {
            return redirect()->back()->with('error', 'You have already clocked out.');
        }

        $clockInTime = \Carbon\Carbon::parse($attendance->attendance_date . ' ' . $attendance->clock_in);
        $now = now();

        $hoursWorked = $clockInTime->diffInHours($now);

        if ($hoursWorked < 9) {
            return redirect()->back()->with('error', 'Cannot clock out yet. You must work at least 9 hours. You have worked ' . $clockInTime->diff($now)->format('%h hours %i minutes') . '.');
        }

        $attendance->update([
            'clock_out' => $now->format('H:i:s'),
            'working_minutes' => $clockInTime->diffInMinutes($now),
            'updated_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Clock out successful at ' . $attendance->clock_out);
    }

    public function storeCorrection(Request $request)
    {
        // $request->validate([
        //     'attendance_id' => 'required',
        //     'corrected_clock_in' => 'required',
        //     'corrected_clock_out' => 'required',
        //     'reason' => 'required',
        //     'proof_file' => 'nullable|file|mimes:pdf|max:2048'
        // ]);

        $path = null;
        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('corrections', 'public');
        }

        $attendanceCorrection = new AttendanceCorrection();
        $attendanceCorrection->attendance_id = $request->attendance_id;
        $attendanceCorrection->corrected_clock_in = $request->corrected_clock_in;
        $attendanceCorrection->corrected_clock_out = $request->corrected_clock_out;
        $attendanceCorrection->reason = $request->reason;
        $attendanceCorrection->proof_file_path = $path;
        $attendanceCorrection->status = 'pending';
        $attendanceCorrection->created_by = Auth::id();

        $attendanceCorrection->save();

        return redirect()->back()->with('success', 'Correction request submitted successfully.');
    }
}
