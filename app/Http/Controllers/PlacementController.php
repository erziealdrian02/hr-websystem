<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Placement;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function placement()
    {
        $title = 'Placement - HRIS';
        $employees = Employee::with('placement')->whereNotNull('work_location')->get();
        // dd($employees->placement->get());

        return view('page-placement.placement', compact('title', 'employees'));
    }

    public function placementForm()
    {
        $title = 'Placement Form - HRIS';
        return view('page-placement.placement-form', compact('title'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Placement $placement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Placement $placement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Placement $placement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Placement $placement)
    {
        //
    }
}
