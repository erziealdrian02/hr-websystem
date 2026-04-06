<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeBank;
use App\Models\EmployeeEmergency;
use App\Models\EmployeeIndentities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

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
        $divisions = Division::all();

        return view('page-employee.employee-form', compact('title'));
    }

    public function employeeStore(Request $request)
    {
        // ----------------------------------------------------------
        // 1. VALIDASI SERVER-SIDE
        //    Semua field required dicek di sini agar aman
        //    meski JS validation di-bypass
        // ----------------------------------------------------------
        $request->validate([
            // --- Employee ---
            'employee_number'   => 'required|string|unique:employees,employee_number',
            'employment_status' => 'required|string',
            'join_date'         => 'required|date',
            'contract_end_date' => 'nullable|date|after:join_date',
            'full_name'         => 'required|string|max:255',
            'job_title'         => 'required|string|max:255',
            'division_id'       => 'required|string',
            'manager_id'        => 'nullable|string',
            'work_email'        => 'nullable|email',
            'work_location'     => 'nullable|string',
            'is_remote'         => 'nullable|boolean',
            'profile_photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // --- Personal Info ---
            'gender'            => 'required|in:male,female',
            'religion'          => 'required|string',
            'place_of_birth'    => 'required|string',
            'date_of_birth'     => 'required|date',
            'marital_status'    => 'nullable|string',
            'dependents_count'  => 'nullable|integer|min:0',
            'personal_email'    => 'required|email',
            'phone_number'      => 'required|string',
            'ktp_address'       => 'required|string',
            'domicile_address'  => 'nullable|string',
            'last_education'    => 'nullable|string',
            'field_of_study'    => 'nullable|string',
            'blood_type'        => 'nullable|string',
            'nationality'       => 'nullable|string',

            // --- Identity ---
            'identity.nik_ktp'         => 'required|string|size:16|unique:employee_identities,nik_ktp',
            'identity.npwp'            => 'nullable|string',
            'identity.bpjs_ketenagakerjaan' => 'nullable|string',
            'identity.bpjs_kesehatan'  => 'nullable|string',
            'identity.passport_number' => 'nullable|string',
            'identity.passport_expiry' => 'nullable|date',
            'identity.tax_status_ptkp' => 'required|string',
            'identity.tax_method'      => 'nullable|string',
            'ktp_document'             => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'npwp_document'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            // --- Bank ---
            'bank.bank_name'           => 'required|string',
            'bank.bank_branch'         => 'nullable|string',
            'bank.account_number'      => 'required|string',
            'bank.account_holder_name' => 'required|string',

            // --- Salary ---
            'salary.basic_salary'      => 'required|numeric|min:0',

            // --- Emergency Contacts (array) ---
            'emergency'                    => 'required|array|min:1',
            'emergency.*.contact_name'     => 'required|string',
            'emergency.*.relationship'     => 'required|string',
            'emergency.*.phone_number'     => 'required|string',
            'emergency.*.is_primary'       => 'nullable|boolean',
            'emergency.*.address'          => 'nullable|string',
        ], [
            // Custom pesan error (opsional, bisa dihapus)
            'employee_number.unique'       => 'Employee ID sudah digunakan.',
            'identity.nik_ktp.unique'      => 'NIK ini sudah terdaftar di sistem.',
            'identity.nik_ktp.size'        => 'NIK harus tepat 16 digit.',
            'salary.basic_salary.required' => 'Basic salary wajib diisi.',
            'emergency.required'           => 'Minimal 1 kontak darurat harus diisi.',
        ]);

        // ----------------------------------------------------------
        // 2. BUAT RECORD EMPLOYEE (tabel: employees)
        // ----------------------------------------------------------

        $uuid = (string) \Illuminate\Support\Str::uuid();

        $employeeData = new Employee();
        $employeeData->id = $uuid;
        $employeeData->employee_number = $request->employee_number;
        $employeeData->employment_status = $request->employment_status;
        $employeeData->join_date = $request->join_date;
        $employeeData->contract_end_date = $request->contract_end_date;
        $employeeData->full_name = $request->full_name;
        $employeeData->job_title = $request->job_title;
        $employeeData->division_id = $request->division_id;
        $employeeData->manager_id = $request->manager_id;
        $employeeData->work_email = $request->work_email;
        $employeeData->work_location = $request->work_location;
        $employeeData->gender = $request->gender;
        $employeeData->religion = $request->religion;
        $employeeData->place_of_birth = $request->place_of_birth;
        $employeeData->date_of_birth = $request->date_of_birth;
        $employeeData->marital_status = $request->marital_status;
        $employeeData->dependents_count = $request->dependents_count;
        $employeeData->personal_email = $request->personal_email;
        $employeeData->phone_number = $request->phone_number;
        $employeeData->ktp_address = $request->ktp_address;
        $employeeData->domicile_address = $request->domicile_address;
        $employeeData->last_education = $request->last_education;
        $employeeData->field_of_study = $request->field_of_study;
        $employeeData->blood_type = $request->blood_type;
        $employeeData->nationality = $request->nationality;

        // $employeeData = $request->only([
        //     'employee_number',
        //     'employment_status',
        //     'join_date',
        //     'contract_end_date',
        //     'full_name',
        //     'job_title',
        //     'division_id',
        //     'manager_id',
        //     'work_email',
        //     'work_location',
        //     'gender',
        //     'religion',
        //     'place_of_birth',
        //     'date_of_birth',
        //     'marital_status',
        //     'dependents_count',
        //     'personal_email',
        //     'phone_number',
        //     'ktp_address',
        //     'domicile_address',
        //     'last_education',
        //     'field_of_study',
        //     'blood_type',
        //     'nationality',
        // ]);

        // Checkbox is_remote: jika tidak dicentang tidak terkirim → default 0
        $employeeData['is_remote'] = $request->boolean('is_remote');

        // Handle upload foto profil
        if ($request->hasFile('profile_photo')) {
            $employeeData['profile_photo'] = $request
                ->file('profile_photo')
                ->store(
                    'profile-photos/' . $uuid,
                    'public'
                );
        }

        $employeeData->save();

        // ----------------------------------------------------------
        // 3. IDENTITY (tabel: employee_identities)
        // ----------------------------------------------------------
        $identityData = $request->input('identity', []);

        // Handle upload dokumen KTP
        if ($request->hasFile('ktp_document')) {
            $identityData['ktp_document_path'] = $request
                ->file('ktp_document')
                ->store('employees/docs', 'public');
        }

        // Handle upload dokumen NPWP
        if ($request->hasFile('npwp_document')) {
            $identityData['npwp_document_path'] = $request
                ->file('npwp_document')
                ->store('employees/docs', 'public');
        }

        EmployeeIndentities::create(
            array_merge(
                ['id' => (string) \Illuminate\Support\Str::uuid(), 'employee_id' => $employee->id],
                $identityData
            )
        );

        // ----------------------------------------------------------
        // 4. BANK ACCOUNT (tabel: employee_bank_accounts)
        // ----------------------------------------------------------
        EmployeeBank::create(
            array_merge(
                ['id' => (string) \Illuminate\Support\Str::uuid(), 'employee_id' => $employee->id],
                $request->input('bank', [])
            )
        );

        // ----------------------------------------------------------
        // 5. SALARY / PAYROLL (tabel: payrolls)
        //    Hitung allowance_total dari semua tunjangan
        // ----------------------------------------------------------
        $salaryInput = $request->input('salary', []);

        // Bersihkan format angka (kalau ada titik ribuan dari JS)
        $cleanNumber = fn($v) => (float) str_replace(['.', ','], ['', '.'], $v ?? 0);

        $basicSalary      = $cleanNumber($salaryInput['basic_salary'] ?? 0);
        $allowPosition    = $cleanNumber($salaryInput['allowance_position'] ?? 0);
        $allowMeal        = $cleanNumber($salaryInput['allowance_meal'] ?? 0);
        $allowTransport   = $cleanNumber($salaryInput['allowance_transport'] ?? 0);
        $allowOther       = $cleanNumber($salaryInput['allowance_other'] ?? 0);
        $allowanceTotal   = $allowPosition + $allowMeal + $allowTransport + $allowOther;
        $grossPay         = $basicSalary + $allowanceTotal;

        \App\Models\Payroll::create([
            'id'               => (string) \Illuminate\Support\Str::uuid(),
            'employee_id'      => $employee->id,
            'period_year'      => now()->year,
            'period_month'     => now()->month,
            'basic_salary'     => $basicSalary,
            'allowance_total'  => $allowanceTotal,
            'gross_pay'        => $grossPay,
            'net_pay'          => $grossPay, // akan dihitung ulang saat proses payroll
            'status'           => 'draft',
            'notes'            => $salaryInput['notes'] ?? null,
        ]);

        // ----------------------------------------------------------
        // 6. EMERGENCY CONTACTS (tabel: emergency_contacts)
        //    Support multiple contact via emergency[][] array
        // ----------------------------------------------------------
        $emergencyContacts = $request->input('emergency', []);

        foreach ($emergencyContacts as $contact) {
            // Skip jika nama kosong (bisa terjadi jika ada input kosong)
            if (empty(trim($contact['contact_name'] ?? ''))) continue;

            EmployeeEmergency::create([
                'id'           => (string) \Illuminate\Support\Str::uuid(),
                'employee_id'  => $employee->id,
                'contact_name' => $contact['contact_name'],
                'relationship' => $contact['relationship'],
                'phone_number' => $contact['phone_number'],
                'is_primary'   => (bool) ($contact['is_primary'] ?? false),
                'address'      => $contact['address'] ?? null,
            ]);
        }

        // ----------------------------------------------------------
        // 7. REDIRECT
        // ----------------------------------------------------------
        return redirect()
            ->route('employees.index')
            ->with('success', "Employee {$employee->full_name} has been created successfully.");
    }
}
