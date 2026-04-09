<?php

namespace App\Http\Controllers;

use App\Models\ClientLocation;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function division()
    {
        $title = 'Division - HRIS';
        $divisions = Division::with('employee')->get();

        return view('page-division.division', compact(
            'title',
            'divisions'
        ));
    }

    public function divisionForm()
    {
        $title = 'Division Form - HRIS';
        $clientLocations = ClientLocation::get();
        $managers = Employee::all();

        return view('page-division.division-form', compact(
            'title',
            'clientLocations',
            'managers'
        ));
    }

    public function store(Request $request)
    {
        $division = new Division();
        $division->division_code = $request->division_code;
        $division->name = $request->name;
        $division->client_location_id = $request->client_location_id;
        $division->head_employee_id = $request->head_employee_id;
        $division->head_title = $request->head_title;
        $division->is_active = $request->has('is_active');
        $division->updated_by = Auth::id();
        $division->created_by = Auth::id();

        $division->save();

        return redirect()->route('division.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $title = 'Edit Division - HRIS';
        $division = Division::with('manager_division')->findOrFail($id);
        $clientLocations = ClientLocation::get();
        $managers = Employee::all();

        return view('page-division.division-form', compact(
            'title',
            'clientLocations',
            'division',
            'managers'
        ));
    }

    public function update(Request $request, $id)
    {
        $division = Division::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'division_code' => 'required|string|max:20|unique:divisions,division_code,' . $division->id,
            'client_location_id' => 'nullable|exists:client_locations,id',
            'head_employee_id' => 'nullable|exists:employees,id',
            'head_title' => 'required|string|max:100',
            'is_active' => 'boolean'
        ]);

        $validated['updated_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $division->update($validated);

        return redirect()->route('division.index')->with('success', 'Divisi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        return redirect()->route('division.index')->with('success', 'Divisi berhasil dihapus!');
    }

    public function generateCode(Request $request)
    {
        $divisionName = $request->query('division_name');
        $clientId = $request->query('client_id');

        if (!$divisionName) {
            return response()->json(['code' => '']);
        }

        // Generate initials from division name
        $nameWords = explode(' ', trim($divisionName));
        $nameInitials = '';
        foreach ($nameWords as $word) {
            if (!empty($word)) {
                $nameInitials .= strtoupper(substr($word, 0, 1));
            }
        }
        // Limit initials if it gets too long, maybe to 3-4 chars, or just use all
        // Usually 2-3 characters is good. We'll use up to 3.
        $nameInitials = substr($nameInitials, 0, 3);

        $clientInitials = '';
        if ($clientId) {
            $client = ClientLocation::find($clientId);
            if ($client) {
                // Generate initials from client name
                $clientWords = explode(' ', trim($client->client_name));
                foreach ($clientWords as $word) {
                    if (!empty($word)) {
                        $clientInitials .= strtoupper(substr($word, 0, 1));
                    }
                }
                $clientInitials = substr($clientInitials, 0, 3);
            }
        }

        $baseCode = $nameInitials;
        if (!empty($clientInitials)) {
            $baseCode .= '-' . $clientInitials;
        }

        // Check if code with this prefix exists, then increment
        $existingDivisions = Division::where('division_code', 'like', $baseCode . '%')
            ->orderBy('division_code', 'desc')
            ->get();

        if ($existingDivisions->isEmpty()) {
            $finalCode = $baseCode . '-1';
        } else {
            // Find max number
            $maxNum = 0;
            foreach ($existingDivisions as $div) {
                $parts = explode('-', $div->division_code);
                $num = end($parts);
                if (is_numeric($num) && $num > $maxNum) {
                    $maxNum = (int)$num;
                }
            }
            $finalCode = $baseCode . '-' . ($maxNum + 1);
        }

        return response()->json(['code' => $finalCode]);
    }
}
