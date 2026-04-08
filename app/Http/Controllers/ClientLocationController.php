<?php

namespace App\Http\Controllers;

use App\Models\ClientLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClientLocationController extends Controller
{
    public function index()
    {
        $title = 'Client Location - HRIS';
        $clientLocations = ClientLocation::orderBy('created_at', 'desc')->get();
        return view('page-client-location.index', compact('title', 'clientLocations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_code' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:255',
            'pic_email' => 'nullable|email|max:255',
            'building_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'floor_unit' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'attendance_radius_meter' => 'required|integer|min:1',
            'work_start_time' => 'nullable',
            'work_end_time' => 'nullable',
            'work_days' => 'nullable|array',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $validated['work_days'] = isset($validated['work_days']) ? json_encode($validated['work_days']) : null;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['created_by'] = Auth::user()->id ?? 'system';
        $validated['updated_by'] = Auth::user()->id ?? 'system';

        ClientLocation::create($validated);

        return redirect()->route('client-locations.index')->with('success', 'Lokasi klien berhasil ditambahkan!');
    }

    public function edit(ClientLocation $clientLocation)
    {
        return response()->json($clientLocation);
    }

    public function update(Request $request, ClientLocation $clientLocation)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_code' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'pic_phone' => 'nullable|string|max:255',
            'pic_email' => 'nullable|email|max:255',
            'building_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'floor_unit' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'attendance_radius_meter' => 'required|integer|min:1',
            'work_start_time' => 'nullable',
            'work_end_time' => 'nullable',
            'work_days' => 'nullable|array',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $validated['work_days'] = isset($validated['work_days']) ? json_encode($validated['work_days']) : null;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['updated_by'] = Auth::user()->id ?? 'system';

        $clientLocation->update($validated);

        return redirect()->route('client-locations.index')->with('success', 'Lokasi klien berhasil diperbarui!');
    }

    public function destroy(ClientLocation $clientLocation)
    {
        $clientLocation->delete();
        return redirect()->route('client-locations.index')->with('success', 'Lokasi klien berhasil dihapus!');
    }
}
