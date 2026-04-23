<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\EmployeeIndentities;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profile()
    {
        $title = 'My Profile - HRIS';
        $user = Auth::user();
        $employee = $user->employee()->with(['identity', 'bank', 'emergency', 'division', 'manager', 'payroll'])->first();
        $emergencies = $employee?->emergency ?? collect();
        return view('page-profile.profile', compact(
            'title',
            'user',
            'employee',
            'emergencies'
        ));
    }

    public function updateEmployeeData(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return Redirect::back()->with('error', 'Employee data not found.');
        }

        $validated = $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'personal_email' => 'nullable|email|max:255',
            'ktp_address' => 'nullable|string|max:500',
            'domicile_address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:Male,Female',
            'place_of_birth' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'dependents_count' => 'nullable|integer|min:0',
            'religion' => 'nullable|in:Islam,Protestant,Catholic,Hindu,Buddhist,Confucian,Other',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'nationality' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'background_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($employee->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($employee->profile_photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        } else {
            unset($validated['profile_photo']);
        }

        if ($request->hasFile('background_photo')) {
            if ($employee->background_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($employee->background_photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->background_photo);
            }
            $validated['background_photo'] = $request->file('background_photo')->store('profile-photos', 'public');
        } else {
            unset($validated['background_photo']);
        }

        $employee->update($validated);

        return Redirect::route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function updateIdentity(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return Redirect::back()->with('error', 'Employee data not found.');
        }

        if ($request->hasFile('ktp_document')) {
            $path = $request->file('ktp_document')->store('employees/docs/' . $employee->id, 'public');
            $identityData['ktp_document_path'] = $path;
        }

        // Handle NPWP document
        if ($request->hasFile('npwp_document')) {
            $path = $request->file('npwp_document')->store('employees/docs/' . $employee->id, 'public');
            $identityData['npwp_document_path'] = $path;
        }

        EmployeeIndentities::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'nik_ktp'               => $identityData['nik_ktp'],
                'npwp'                  => $identityData['npwp'],
                'bpjs_ketenagakerjaan'  => $identityData['bpjs_ketenagakerjaan'],
                'bpjs_kesehatan'        => $identityData['bpjs_kesehatan'],
                'passport_number'       => $identityData['passport_number'],
                'tax_status_ptkp'       => $identityData['tax_status_ptkp'],
                'ktp_document_path'     => $identityData['ktp_document_path'] ?? null,
                'npwp_document_path'    => $identityData['npwp_document_path'] ?? null,
            ]
        );

        return Redirect::route('profile.index')->with('success', 'Identity updated successfully.');
    }

    public function updateBank()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return Redirect::back()->with('error', 'Employee data not found.');
        }

        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',
        ]);

        $employee->update($validated);

        return Redirect::route('profile.index')->with('success', 'Bank updated successfully.');
    }

    public function storeEmergency() {}

    public function updateEmergency() {}

    public function destroyEmergency() {}

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $title = 'My Profile - HRIS';

        return view('profile.edit', [
            'user' => $request->user(),
            'title' => $title,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
