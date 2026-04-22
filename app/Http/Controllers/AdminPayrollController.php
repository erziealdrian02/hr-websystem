<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminPayrollController extends Controller
{
    public function payrollAdmin()
    {
        $title = 'Company Payroll Overview - HRIS';
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Metrics Calculation
        // Assuming 'processed' or 'draft' status means it's ready, 'transferred' means done.
        $totalProcessed = Payroll::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->whereIn('status', ['draft', 'approved', 'transferred'])
            ->count();

        $pendingDisbursal = Payroll::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->whereIn('status', ['draft', 'approved'])
            ->count();

        $totalNetPay = Payroll::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->sum('net_pay');

        $totalBpjs = Payroll::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->sum('deduction_bpjs_kes') 
            + Payroll::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->sum('deduction_bpjs_jht')
            + Payroll::where('period_month', $currentMonth)
            ->where('period_year', $currentYear)
            ->sum('deduction_bpjs_jp');

        // Fetch payrolls
        $payrolls = Payroll::with('employee')
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->paginate(20);

        return view('page-admin.admin-payroll', compact(
            'title',
            'currentMonth',
            'currentYear',
            'totalProcessed',
            'pendingDisbursal',
            'totalNetPay',
            'totalBpjs',
            'payrolls'
        ));
    }

    public function runPayroll(Request $request)
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Get active employees
        // Assuming all employees in table are active if they don't have a specific inactive flag.
        $employees = Employee::all();
        
        $count = 0;

        foreach ($employees as $employee) {
            // Check if payroll already generated for this period
            $exists = Payroll::where('employee_id', $employee->id)
                ->where('period_month', $currentMonth)
                ->where('period_year', $currentYear)
                ->exists();

            if (!$exists) {
                // Determine a basic base salary based on the prompt's instructions or defaults.
                // Normally this comes from an EmployeeSalary table or similar contract details.
                // We mock it for the demo.
                $baseSalary = rand(5, 15) * 1000000;
                
                $bpjsKes = $baseSalary * 0.01;
                $bpjsJht = $baseSalary * 0.02;
                $totalDeductions = $bpjsKes + $bpjsJht;
                $netPay = $baseSalary - $totalDeductions;

                Payroll::create([
                    'id' => Str::uuid(),
                    'employee_id' => $employee->id,
                    'period_year' => $currentYear,
                    'period_month' => $currentMonth,
                    'basic_salary' => $baseSalary,
                    'allowance_total' => 0,
                    'overtime_pay' => 0,
                    'bonus' => 0,
                    'gross_pay' => $baseSalary,
                    'deduction_pph21' => 0,
                    'deduction_bpjs_kes' => $bpjsKes,
                    'deduction_bpjs_jht' => $bpjsJht,
                    'deduction_bpjs_jp' => 0,
                    'deduction_other' => 0,
                    'total_deductions' => $totalDeductions,
                    'net_pay' => $netPay,
                    'status' => 'draft',
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id()
                ]);
                
                $count++;
            }
        }

        return redirect()->back()->with('success', "$count payroll records generated successfully for " . Carbon::now()->format('F Y'));
    }
}
