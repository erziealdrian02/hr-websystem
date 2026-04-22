<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reimburse;
use App\Models\ReimburseBalance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminReimburseController extends Controller
{
    public function reimburseAdmin()
    {
        $title = 'All Reimburse - HRIS';

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Metrics
        $pendingTotal = Reimburse::where('status', 'pending')->sum('amount');
        
        $approvedThisMonth = Reimburse::where('status', 'approved')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');
            
        $pendingRequests = Reimburse::where('status', 'pending')->count();

        $reimburses = Reimburse::with('employee')->orderBy('created_at', 'desc')->get();

        return view('page-admin.admin-reimburse', compact(
            'title',
            'pendingTotal',
            'approvedThisMonth',
            'pendingRequests',
            'reimburses'
        ));
    }

    public function approve($id)
    {
        $reimburse = Reimburse::findOrFail($id);

        if ($reimburse->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to approve.']);
        }

        $reimburse->update([
            'status' => 'approved',
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Reimbursement request approved successfully.']);
    }

    public function reject($id)
    {
        $reimburse = Reimburse::findOrFail($id);

        if ($reimburse->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Status must be pending to reject.']);
        }

        // Restore balance
        $balance = ReimburseBalance::where('employee_id', $reimburse->employee_id)
            ->where('category', $reimburse->category)
            ->first();

        if ($balance) {
            $balance->increment('amount', $reimburse->amount);
        }

        $reimburse->update([
            'status' => 'rejected',
            'updated_by' => Auth::id()
        ]);

        return response()->json(['success' => true, 'message' => 'Reimbursement request rejected and balance restored.']);
    }
}
