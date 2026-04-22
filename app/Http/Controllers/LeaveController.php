<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LeaveController extends Controller
{
    // Maps display label → DB enum value
    const TYPE_MAP = [
        'Annual Leave' => 'annual',
        'Sick Leave'   => 'sick',
        'Unpaid Leave' => 'unpaid',
    ];

    // Maps DB enum → balance field names
    const BALANCE_MAP = [
        'annual' => ['quota' => 'annual_leave_quota', 'used' => 'annual_leave_used'],
        'sick'   => ['quota' => 'sick_leave_quota',   'used' => 'sick_leave_used'],
        'unpaid' => ['quota' => 'unpaid_leave_quota', 'used' => 'unpaid_leave_used'],
    ];

    /**
     * Display the leave page.
     */
    public function leave()
    {
        $tile         = 'Leave - HRIS';
        $user         = Auth::user();
        $leaves       = Leave::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $leaveBalance = LeaveBalance::where('user_id', $user->id)->first();

        return view('page-leave.leave', compact('tile', 'leaves', 'leaveBalance'));
    }

    /**
     * Store a new leave request (AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type'  => 'required|in:Annual Leave,Sick Leave,Unpaid Leave',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'reason'      => 'required|string|max:1000',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $user = Auth::user();

        // Get leave balance
        $leaveBalance = LeaveBalance::where('user_id', $user->id)->first();
        if (!$leaveBalance) {
            return response()->json([
                'success' => false,
                'message' => 'Data leave balance tidak ditemukan. Hubungi HR.',
            ], 422);
        }

        // Calculate duration
        $startDate    = \Carbon\Carbon::parse($request->start_date);
        $endDate      = \Carbon\Carbon::parse($request->end_date);
        $durationDays = $startDate->diffInDays($endDate) + 1;

        // Map display type → DB enum
        $dbType      = self::TYPE_MAP[$request->leave_type] ?? null;
        $balanceField = self::BALANCE_MAP[$dbType] ?? null;

        if (!$dbType || !$balanceField) {
            return response()->json(['success' => false, 'message' => 'Tipe cuti tidak valid.'], 422);
        }

        $remaining = $leaveBalance->{$balanceField['quota']} - $leaveBalance->{$balanceField['used']};

        if ($remaining <= 0) {
            return response()->json([
                'success' => false,
                'message' => "Sisa jatah {$request->leave_type} kamu sudah habis (0 hari tersisa).",
            ], 422);
        }

        if ($durationDays > $remaining) {
            return response()->json([
                'success' => false,
                'message' => "Durasi cuti ({$durationDays} hari) melebihi sisa jatah {$request->leave_type} ({$remaining} hari).",
            ], 422);
        }

        // Get employee record
        $employee = Employee::where('user_id', $user->id)->first();

        // Handle file upload → storage/app/public/leaves/{employee_id}/
        $attachmentPath = null;
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $employeeId     = $employee ? $employee->id : (string) $user->id;
            $fileName       = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $attachmentPath = $request->file('attachment')->storeAs(
                "leaves/{$employeeId}",
                $fileName,
                'public'
            );
        }

        // Create leave
        $leave = Leave::create([
            'id'            => (string) Str::uuid(),
            'employee_id'   => $employee ? $employee->id : $user->id,
            'user_id'       => (string) $user->id,
            'leave_type'    => $dbType,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'duration_days' => $durationDays,
            'reason'        => $request->reason,
            'attachment'    => $attachmentPath,
            'status'        => 'pending',
            'created_by'    => (string) $user->id,
            'updated_by'    => (string) $user->id,
        ]);

        // Deduct balance
        $leaveBalance->increment($balanceField['used'], $durationDays);
        $leaveBalance->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Leave request berhasil diajukan!',
            'leave'   => [
                'id'             => $leave->id,
                'leave_type_db'  => $leave->leave_type,
                'leave_type'     => $request->leave_type,
                'start_date'     => $leave->start_date,
                'end_date'       => $leave->end_date,
                'duration_days'  => $leave->duration_days,
                'reason'         => $leave->reason,
                'status'         => $leave->status,
                'has_attachment' => !is_null($attachmentPath),
            ],
            'balance' => $this->buildBalanceResponse($leaveBalance),
        ]);
    }

    /**
     * Cancel (destroy) a pending leave request (AJAX).
     */
    public function destroy($id)
    {
        $user  = Auth::user();
        $leave = Leave::where('id', $id)->where('user_id', $user->id)->first();

        if (!$leave) {
            return response()->json(['success' => false, 'message' => 'Leave request tidak ditemukan.'], 404);
        }

        if (strtolower($leave->status) !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat membatalkan leave yang sudah " . ucfirst($leave->status) . ".",
            ], 422);
        }

        // Restore balance
        $leaveBalance = LeaveBalance::where('user_id', $user->id)->first();
        if ($leaveBalance) {
            $balanceField = self::BALANCE_MAP[$leave->leave_type]['used'] ?? null;
            if ($balanceField) {
                $leaveBalance->decrement($balanceField, $leave->duration_days);
            }
        }

        // Delete attachment
        if ($leave->attachment && Storage::disk('public')->exists($leave->attachment)) {
            Storage::disk('public')->delete($leave->attachment);
        }

        $leave->delete();

        $leaveBalance?->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Leave request berhasil dibatalkan.',
            'balance' => $leaveBalance ? $this->buildBalanceResponse($leaveBalance) : null,
        ]);
    }

    /**
     * Build balance response array.
     */
    private function buildBalanceResponse(LeaveBalance $leaveBalance): array
    {
        return [
            'annual_remaining' => $leaveBalance->annual_leave_quota - $leaveBalance->annual_leave_used,
            'sick_remaining'   => $leaveBalance->sick_leave_quota   - $leaveBalance->sick_leave_used,
            'unpaid_remaining' => $leaveBalance->unpaid_leave_quota - $leaveBalance->unpaid_leave_used,
            'annual_quota'     => $leaveBalance->annual_leave_quota,
            'sick_quota'       => $leaveBalance->sick_leave_quota,
            'unpaid_quota'     => $leaveBalance->unpaid_leave_quota,
        ];
    }
}
