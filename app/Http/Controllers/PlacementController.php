<?php

namespace App\Http\Controllers;

use App\Models\ClientLocation;
use App\Models\Employee;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PlacementController extends Controller
{
    public function placement()
    {
        $title = 'Placement - HRIS';
        $employees = Employee::with('placement')->whereNotNull('work_location')->get();
        $locationClients = ClientLocation::all();
        $allEmployees = Employee::all();

        $totalEmployees = count($employees);
        $totalThisMonthContract = Placement::whereBetween('start_date', [
            Carbon::now()->subDays(30),
            Carbon::now()->addDays(30)
        ])->count();
        $totalClient = count($locationClients);
        $totalExpiredContract = Placement::whereBetween('end_date', [
            Carbon::now(),
            Carbon::now()->addDays(30)
        ])->count();

        $skNumber = 'SK/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . strtoupper(Str::random(4));

        return view('page-placement.placement', compact(
            'title',
            'employees',
            'allEmployees',
            'locationClients',
            'totalEmployees',
            'totalClient',
            'totalExpiredContract',
            'totalThisMonthContract'
        ));
    }

    public function placementForm()
    {
        $title = 'Placement Form - HRIS';
        return view('page-placement.placement-form', compact(
            'title'
        ));
    }

    public function store(Request $request)
    {
        $placement = new Placement();
        $placement->id = (string) Str::uuid();
        $placement->employee_id = $request->employee_id;
        $placement->client_location_id = $request->client_location_id;
        $placement->position_at_client = $request->position_at_client;
        $placement->start_date = $request->start_date;
        $placement->end_date = $request->end_date;
        $placement->sk_number = $request->sk_number;
        $placement->placement_type = $request->placement_type;
        $placement->notes = $request->notes;
        $placement->status = 'active';
        $placement->created_by = Auth::id();

        $emploating = Employee::find($request->employee_id);
        $emploating->work_location = $placement->id;
        $emploating->contract_end_date = $placement->end_date;


        if (empty($validated['sk_number'])) {
            $placement->sk_number = 'SK/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . strtoupper(Str::random(4));
        }

        $emploating->save();
        $placement->save();

        return redirect()->route('placement.index')->with('success', 'Penempatan karyawan berhasil disimpan!');
    }

    public function update(Request $request, Placement $placement)
    {
        $placement->employee_id = $request->employee_id;
        $placement->client_location_id = $request->client_location_id;
        $placement->position_at_client = $request->position_at_client;
        $placement->start_date = $request->start_date;
        $placement->end_date = $request->end_date;
        $placement->sk_number = $request->sk_number;
        $placement->placement_type = $request->placement_type;
        $placement->notes = $request->notes;
        $placement->status = 'active';
        $placement->updated_by = Auth::id();

        $emploating = Employee::find($request->employee_id);
        $emploating->work_location = $placement->id;
        $emploating->contract_end_date = $placement->end_date;

        $emploating->save();
        $placement->save();

        return redirect()->route('placement.index')->with('success', 'Data penempatan berhasil diperbarui!');
    }

    public function destroy(Placement $placement)
    {
        $emploating = Employee::find($placement->employee_id);
        $emploating->work_location = null;
        $emploating->save();

        $placement->delete();

        return redirect()->route('placement.index')->with('success', 'Data penempatan berhasil dihapus!');
    }
}
