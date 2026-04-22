<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Reimburse;
use App\Models\ReimburseBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReimburseController extends Controller
{
    /**
     * Display the reimburse page for the logged-in employee.
     */
    public function reimburse()
    {
        $title = 'Reimburse - HRIS';

        $user = Auth::user();

        // Get employee tied to logged-in user
        $employee = Employee::where('user_id', $user->id)->first();

        if (!$employee) {
            abort(403, 'Employee data not found for current user.');
        }

        $employeeId = $employee->id;

        // ReimburseBalance per category
        $reimburses_balance = ReimburseBalance::where('employee_id', $employeeId)->get();

        // Reimburse claims history
        $reimburses = Reimburse::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('page-reimbuse.reimburse', compact(
            'title',
            'reimburses_balance',
            'reimburses',
            'employee'
        ));
    }

    /**
     * Store a new reimburse claim (AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'category'       => 'required|in:glasses,Inpatient,outpatient',
            'reimburse_date'  => 'required|date',
            'description'    => 'required|string|max:1000',
            'amount'         => 'required|numeric|min:1',
            'receipt'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Data employee tidak ditemukan.',
            ], 422);
        }

        // Check balance for this category
        $balance = ReimburseBalance::where('employee_id', $employee->id)
            ->where('category', $request->category)
            ->first();

        if (!$balance || $balance->amount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo reimburse untuk kategori ini sudah habis.',
            ], 422);
        }

        if ($request->amount > $balance->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah klaim (Rp ' . number_format($request->amount, 0, ',', '.') . ') melebihi sisa saldo (Rp ' . number_format($balance->amount, 0, ',', '.') . ').',
            ], 422);
        }

        // Handle receipt upload
        $receiptPath = null;
        if ($request->hasFile('receipt') && $request->file('receipt')->isValid()) {
            $fileName = time() . '_' . $request->file('receipt')->getClientOriginalName();
            $receiptPath = $request->file('receipt')->storeAs(
                "reimburses/{$employee->id}",
                $fileName,
                'public'
            );
        }

        $reimburse = new Reimburse;
        $reimburse->id = (string) Str::uuid();
        $reimburse->employee_id = $employee->id;
        $reimburse->reimburse_date = $request->reimburse_date;
        $reimburse->category = $request->category;
        $reimburse->description = $request->description;
        $reimburse->amount = $request->amount;
        $reimburse->receipt_path = $receiptPath;
        $reimburse->status = 'pending';
        $reimburse->created_by = (string) $user->id;
        $reimburse->updated_by = (string) $user->id;
        $reimburse->save();

        // Deduct balance
        $balance->decrement('amount', $request->amount);
        $balance->refresh();

        // Rebuild all balances for response
        $allBalances = ReimburseBalance::where('employee_id', $employee->id)->get();
        $balanceResponse = [];
        foreach ($allBalances as $b) {
            $balanceResponse[$b->category] = $b->amount;
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Klaim reimburse berhasil diajukan!',
            'reimburse' => [
                'id'             => $reimburse->id,
                'reimburse_date' => $reimburse->reimburse_date,
                'category'       => $reimburse->category,
                'description'    => $reimburse->description,
                'amount'         => $reimburse->amount,
                'status'         => $reimburse->status,
                'has_receipt'    => !is_null($receiptPath),
            ],
            'balances'  => $balanceResponse,
        ]);
    }

    /**
     * Cancel a pending reimburse claim (AJAX).
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        $reimburse = Reimburse::where('id', $id)
            ->where('employee_id', $employee->id)
            ->first();

        if (!$reimburse) {
            return response()->json(['success' => false, 'message' => 'Klaim tidak ditemukan.'], 404);
        }

        if (strtolower($reimburse->status) !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membatalkan klaim yang sudah ' . ucfirst($reimburse->status) . '.',
            ], 422);
        }

        // Restore balance
        $balance = ReimburseBalance::where('employee_id', $employee->id)
            ->where('category', $reimburse->category)
            ->first();

        if ($balance) {
            $balance->increment('amount', $reimburse->amount);
        }

        // Delete receipt file
        if ($reimburse->receipt_path && Storage::disk('public')->exists($reimburse->receipt_path)) {
            Storage::disk('public')->delete($reimburse->receipt_path);
        }

        $reimburse->delete();

        // Rebuild all balances for response
        $allBalances = ReimburseBalance::where('employee_id', $employee->id)->get();
        $balanceResponse = [];
        foreach ($allBalances as $b) {
            $balanceResponse[$b->category] = $b->amount;
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Klaim reimburse berhasil dibatalkan.',
            'balances' => $balanceResponse,
        ]);
    }
}
