<?php

namespace App\Http\Controllers;

use App\Models\ClientLocation;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        return view('page-division.division-form', compact(
            'title',
            'clientLocations'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'division_code' => 'required|string|max:20|unique:divisions,division_code',
            'client_location_id' => 'nullable|exists:client_locations,id',
            'head_employee_id' => 'nullable|exists:employees,id',
            'head_title' => 'required|string|max:100',
            'is_active' => 'boolean'
        ]);

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Division::create($validated);

        return redirect()->route('division.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Edit Division - HRIS';
        $division = Division::with('manager_division')->findOrFail($id);
        $clientLocations = ClientLocation::get();
        return view('page-division.division-form', compact('title', 'clientLocations', 'division'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        return redirect()->route('division.index')->with('success', 'Divisi berhasil dihapus!');
    }

    /**
     * Generate division code based on division name and client location.
     */
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
