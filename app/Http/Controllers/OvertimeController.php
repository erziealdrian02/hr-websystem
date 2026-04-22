<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function overtime(Request $request)
    {
        $title = 'Overtime - HRIS';
        $employeeId = Auth::id();
        $month = $request->input('month', date('Y-m'));
        $parsedDate = Carbon::parse($month);

        $query = Overtime::with('employee')
            ->where('employee_id', $employeeId)
            ->whereMonth('overtime_date', $parsedDate->month)
            ->whereYear('overtime_date', $parsedDate->year);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('overtime_date', 'like', "%{$search}%");
            });
        }

        $overtimes = $query->orderByDesc('overtime_date')->get();

        // Stats for the selected month
        $stats = $this->getStats($employeeId, $parsedDate);

        return view('page-overtime.overtime', compact(
            'title',
            'overtimes',
            'stats',
            'month'
        ));
    }

    /**
     * Store a newly created overtime.
     */
    public function overtimeStore(Request $request)
    {
        $start = Carbon::createFromFormat('H:i', $request->start_time);
        $end   = Carbon::createFromFormat('H:i', $request->end_time);

        if ($end->lessThan($start)) {
            $end->addDay();
        }

        $durationMinutes = $start->diffInMinutes($end);

        if ($end->lessThan($start)) {
            return back()->withErrors(['end_time' => 'End time harus lebih besar dari start time']);
        }

        $overtime = new Overtime();
        $overtime->id = Str::uuid();
        $overtime->employee_id = Auth::id();
        $overtime->overtime_date = $request->overtime_date;
        $overtime->start_time = $request->start_time;
        $overtime->end_time = $request->end_time;
        $overtime->duration_minutes = $durationMinutes;
        $overtime->description = $request->description;
        $overtime->overtime_pay = '0';
        $overtime->status = 'pending';
        $overtime->created_by = Auth::id();
        $overtime->updated_by = Auth::id();

        $overtime->save();

        return redirect()->route('overtime.index')
            ->with('success', 'Overtime request submitted successfully.');
    }

    /**
     * Update the specified overtime.
     */
    public function overtimeUpdate(Request $request, $id)
    {
        $overtime = Overtime::findOrFail($id);
        $this->authorizeAccess($overtime);

        abort_if($overtime->status !== 'pending', 403, 'Only pending requests can be updated.');

        $validated = $request->validate([
            'overtime_date' => 'required|date',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'description'   => 'required|string|max:255',
        ]);

        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end   = Carbon::createFromFormat('H:i', $validated['end_time']);
        $durationMinutes = $end->diffInMinutes($start);

        $overtime->update([
            'overtime_date'    => $validated['overtime_date'],
            'start_time'       => $validated['start_time'],
            'end_time'         => $validated['end_time'],
            'duration_minutes' => $durationMinutes,
            'description'      => $validated['description'],
            'updated_by'       => Auth::id(),
        ]);

        return redirect()->route('overtime.index')
            ->with('success', 'Overtime request updated successfully.');
    }

    /**
     * Remove the specified overtime.
     */
    public function overtimeDestroy($id)
    {
        $overtime = Overtime::findOrFail($id);
        $this->authorizeAccess($overtime);

        abort_if($overtime->status !== 'pending', 403, 'Only pending requests can be deleted.');

        $overtime->delete();

        return redirect()->route('overtime.index')
            ->with('success', 'Overtime request deleted successfully.');
    }

    /**
     * Approve an overtime request (manager/admin only).
     */
    public function overtimeApprove(Overtime $overtime)
    {
        abort_if($overtime->status !== 'pending', 422, 'Only pending requests can be approved.');

        $overtime->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'updated_by'  => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Overtime approved.');
    }

    /**
     * Reject an overtime request (manager/admin only).
     */
    public function overtimeReject(Overtime $overtime)
    {
        abort_if($overtime->status !== 'pending', 422, 'Only pending requests can be rejected.');

        $overtime->update([
            'status'     => 'rejected',
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Overtime rejected.');
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Ensure the authenticated user owns this overtime record.
     */
    private function authorizeAccess(Overtime $overtime): void
    {
        abort_if(
            $overtime->employee_id !== Auth::id(),
            403,
            'You are not authorized to access this record.'
        );
    }

    /**
     * Build summary stats for the current employee filtered by month.
     */
    private function getStats(string $employeeId, Carbon $date): array
    {
        $monthQuery = Overtime::where('employee_id', $employeeId)
            ->whereMonth('overtime_date', $date->month)
            ->whereYear('overtime_date', $date->year);

        $totalMinutes = (clone $monthQuery)->sum('duration_minutes');
        $hours   = intdiv($totalMinutes, 60);
        $minutes = $totalMinutes % 60;

        return [
            'total_hours'    => "{$hours}h {$minutes}m",
            'pending_count'  => (clone $monthQuery)->where('status', 'pending')->count(),
            'approved_count' => (clone $monthQuery)->where('status', 'approved')->count(),
            'estimated_pay'  => (clone $monthQuery)->whereNotNull('overtime_pay')->sum('overtime_pay'),
        ];
    }
}
