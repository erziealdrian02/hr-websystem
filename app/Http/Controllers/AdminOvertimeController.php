<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminOvertimeController extends Controller
{
    public function overtimeAdmin()
    {
        $title = 'All Overtime Claims - HRIS';
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $pendingClaims = Overtime::where('status', 'pending')->count();
        
        // Duration is in minutes, so we sum and divide by 60 for hours
        $totalMinutesThisMonth = Overtime::where('status', 'approved')
            ->whereMonth('overtime_date', $currentMonth)
            ->whereYear('overtime_date', $currentYear)
            ->sum('duration_minutes');
            
        $totalHoursThisMonth = floor($totalMinutesThisMonth / 60) . 'h ' . ($totalMinutesThisMonth % 60) . 'm';
        
        // Sum overtime_pay (if exists/calculated) for approved requests this month
        $estCostImpact = Overtime::where('status', 'approved')
            ->whereMonth('overtime_date', $currentMonth)
            ->whereYear('overtime_date', $currentYear)
            ->sum('overtime_pay');

        $overtimes = Overtime::with('employee')->orderBy('overtime_date', 'desc')->get();

        return view('page-admin.admin-overtime', compact(
            'title',
            'overtimes',
            'pendingClaims',
            'totalHoursThisMonth',
            'estCostImpact'
        ));
    }

    public function approve($id)
    {
        $overtime = Overtime::findOrFail($id);
        
        if ($overtime->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to approve.']);
        }

        $overtime->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Overtime request approved successfully.']);
    }

    public function reject($id)
    {
        $overtime = Overtime::findOrFail($id);
        
        if ($overtime->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to reject.']);
        }

        $overtime->update([
            'status' => 'rejected',
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Overtime request rejected.']);
    }
}
