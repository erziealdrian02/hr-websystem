<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminLeaveController extends Controller
{
    // Maps DB enum → balance field names for restoration
    const BALANCE_MAP = [
        'annual' => ['quota' => 'annual_leave_quota', 'used' => 'annual_leave_used'],
        'sick'   => ['quota' => 'sick_leave_quota',   'used' => 'sick_leave_used'],
        'unpaid' => ['quota' => 'unpaid_leave_quota', 'used' => 'unpaid_leave_used'],
    ];

    public function leaveAdmin()
    {
        $title = 'Leave Request - HRIS';
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $pendingCount = Leave::where('status', 'pending')->count();
        
        $approvedThisMonth = Leave::where('status', 'approved')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
            
        $rejectedThisMonth = Leave::where('status', 'rejected')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $leaves = Leave::with('employee')->orderBy('created_at', 'desc')->get();

        return view('page-admin.admin-leave', compact(
            'title',
            'leaves',
            'pendingCount',
            'approvedThisMonth',
            'rejectedThisMonth'
        ));
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to approve.']);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Leave request approved successfully.']);
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to reject.']);
        }

        // Restore balance
        $leaveBalance = LeaveBalance::where('user_id', $leave->user_id)->first();
        if ($leaveBalance) {
            $balanceField = self::BALANCE_MAP[$leave->leave_type]['used'] ?? null;
            if ($balanceField) {
                $leaveBalance->decrement($balanceField, $leave->duration_days);
            }
        }

        $leave->update([
            'status' => 'rejected',
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Leave request rejected and balance restored.']);
    }
}
