<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeBank;
use App\Models\EmployeeEmergency;
use App\Models\EmployeeIndentities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function employees()
    {
        $title = 'All Employees - HRIS';
        $employees = Employee::all();

        return view('page-employee.employees', compact('employees', 'title'));
    }

    public function employeeDetail($id)
    {
        $title = 'Employee Detail - HRIS';
        $employee = Employee::findOrFail($id);
        // dd($employee->identity->nik_ktp);

        return view('page-employee.employee-detail', compact('title', 'employee'));
    }

    public function employeeEdit($id)
    {
        $title = 'Employee Edit - HRIS';
        $employee = Employee::findOrFail($id);
        $managers = Employee::all();
        $divisions = Division::all();

        return view('page-employee.employee-form-update', compact('title', 'employee', 'divisions', 'managers'));
    }

    public function employeeUpdate(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // --- Update main employee fields ---
        $employee->full_name          = $request->full_name;
        $employee->job_title          = $request->job_title;
        $employee->employee_number    = $request->employee_number;
        $employee->employment_status  = $request->employment_status;
        $employee->gender             = $request->gender;
        $employee->place_of_birth     = $request->place_of_birth;
        $employee->date_of_birth      = $request->date_of_birth;
        $employee->religion           = $request->religion;
        $employee->domicile_address   = $request->domicile_address;
        $employee->personal_email     = $request->personal_email;
        $employee->phone_number       = $request->phone_number;
        $employee->division_id        = $request->division_id;
        $employee->manager_id         = $request->manager_id;

        // --- Profile photo ---
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($employee->profile_photo) {
                Storage::disk('public')->delete($employee->profile_photo);
            }
            // Simpan ke folder berdasarkan ID employee
            $path = $request->file('profile_photo')->store(
                'profile-photos/' . $employee->id,
                'public'
            );
            $employee->profile_photo = $path;
        }

        $employee->save();

        // --- Identity ---
        if ($request->has('identity')) {
            EmployeeIndentities::updateOrCreate(
                ['employee_id' => $id],
                [
                    'nik_ktp'               => $request->input('identity.nik_ktp'),
                    'npwp'                  => $request->input('identity.npwp'),
                    'bpjs_ketenagakerjaan'  => $request->input('identity.bpjs_ketenagakerjaan'),
                    'bpjs_kesehatan'        => $request->input('identity.bpjs_kesehatan'),
                    'passport_number'       => $request->input('identity.passport_number'),
                    'tax_status_ptkp'       => $request->input('identity.tax_status_ptkp'),
                ]
            );
        }

        // --- Bank ---
        if ($request->has('bank')) {
            EmployeeBank::updateOrCreate(
                ['employee_id' => $id],
                [
                    'bank_name'           => $request->input('bank.bank_name'),
                    'bank_branch'         => $request->input('bank.bank_branch'),
                    'account_number'      => $request->input('bank.account_number'),
                    'account_holder_name' => $request->input('bank.account_holder_name'),
                ]
            );
        }

        // --- Emergency Contact ---
        if ($request->has('emergency')) {
            EmployeeEmergency::updateOrCreate(
                ['employee_id' => $id],
                [
                    'contact_name'  => $request->input('emergency.contact_name'),
                    'relationship'  => $request->input('emergency.relationship'),
                    'phone_number'  => $request->input('emergency.phone_number'),
                    'address'       => $request->input('emergency.address'),
                ]
            );
        }

        return redirect()->route('employees.detail', $id)->with('success', 'Employee updated successfully');
    }

    public function employeeForm()
    {
        $title = 'Form Employee - HRIS';
        return view('page-employee.employee-form', compact('title'));
    }
}
