<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function contract()
    {
        $title = 'Contract - HRIS';
        $contracts = Contract::with('employee')->orderBy('created_at', 'desc')->get();
        $employees = Employee::all();

        $expiringCount = Contract::where('status', 'active')
            ->whereNotNull('end_date')
            ->where('end_date', '<=', \Carbon\Carbon::now()->addDays(30))
            ->where('end_date', '>=', \Carbon\Carbon::now())
            ->count();

        return view('page-contract.contract', compact(
            'title',
            'contracts',
            'employees',
            'expiringCount'
        ));
    }

    public function store(Request $request)
    {
        $uuid = \Illuminate\Support\Str::uuid();

        $contract = new Contract();
        $contract->id = (string) $uuid;
        $contract->employee_id = $request->employee_id;
        $contract->contract_type = $request->contract_type;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->status = $request->status ?? 'active';
        $contract->created_by = Auth::id();
        $contract->updated_by = Auth::id();

        $contract->save();

        return redirect()->route('contract.index')->with('success', 'Contract drafted successfully.');
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        $contract->employee_id = $request->employee_id;
        $contract->contract_type = $request->contract_type;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->status = $request->status ?? 'active';
        $contract->updated_by = Auth::id();

        $contract->save();

        return redirect()->route('contract.index')->with('success', 'Contract updated successfully.');
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->status = 'terminated';
        $contract->updated_by = Auth::id();
        $contract->save();

        return redirect()->back()->with('success', 'Contract status changed to Terminated.');
    }
}
