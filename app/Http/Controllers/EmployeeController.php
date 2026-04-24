<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeeBank;
use App\Models\EmployeeEmergency;
use App\Models\EmployeeIndentities;
use App\Models\EmployeePayroll;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employees(Request $request)
    {
        $title = 'All Employees - HRIS';

        $managers = Employee::all();
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        if (!in_array($perPage, [10, 30, 50, 100])) {
            $perPage = 10;
        }

        $employees = Employee::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('employee_number', 'like', "%{$search}%")
                        ->orWhere('job_title', 'like', "%{$search}%");
                });
            })
            ->where(function ($query) {
                $query->where('is_deleted', '0')
                    ->orWhereNull('is_deleted');
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('page-employee.employees', compact('employees', 'title', 'search', 'perPage', 'managers'));
    }

    public function employeeDetail($id)
    {
        $title = 'Employee Detail - HRIS';
        $employee = Employee::with(['identity', 'bank', 'emergency', 'division', 'manager'])->findOrFail($id);
        $emergencies = $employee->emergency;

        return view('page-employee.employee-detail', compact('title', 'employee', 'emergencies'));
    }

    public function employeeEdit($id)
    {
        $title = 'Employee Edit - HRIS';
        $employee = Employee::with(['identity', 'bank', 'emergency', 'division'])->findOrFail($id);
        $managers = Employee::all();
        $divisions = Division::all();
        $payroll = EmployeePayroll::where('employee_id', $id)->first();

        return view('page-employee.employee-form-update', compact('title', 'employee', 'divisions', 'managers', 'payroll'));
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
            $identityData = $request->input('identity');

            // Handle KTP document
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
                ['employee_id' => $id],
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

        // --- Payroll ---
        if ($request->has('salary')) {
            $salaryData = $request->input('salary');
            $cleanNumber = fn($v) => (float) str_replace(['.', ','], ['', '.'], $v ?? 0);

            $basicSalary    = $cleanNumber($salaryData['basic_salary'] ?? 0);
            $allowPosition  = $cleanNumber($salaryData['allowance_position'] ?? 0);
            $allowMeal      = $cleanNumber($salaryData['allowance_meal'] ?? 0);
            $allowTransport = $cleanNumber($salaryData['allowance_transport'] ?? 0);
            $allowOther     = $cleanNumber($salaryData['allowance_other'] ?? 0);

            $allowanceTotal = $allowPosition + $allowMeal + $allowTransport + $allowOther;
            $grossPay       = $basicSalary + $allowanceTotal;

            $bpjsBase = $basicSalary;
            $deductionBpjsKes = $bpjsBase * 0.01;
            $deductionBpjsJht = $bpjsBase * 0.02;
            $deductionBpjsJp  = $bpjsBase * 0.01;
            $deductionTotal = $deductionBpjsJp + $deductionBpjsJht + $deductionBpjsKes;

            EmployeePayroll::updateOrCreate(
                ['employee_id' => $id],
                [
                    'id'                   => (string) \Illuminate\Support\Str::uuid(),
                    'basic_salary'         => $basicSalary,
                    'allowance_position'   => $allowPosition,
                    'allowance_meal'       => $allowMeal,
                    'allowance_transport'  => $allowTransport,
                    'allowance_other'      => $allowOther,
                    'allowance_total'      => $allowanceTotal,
                    'gross_pay'            => $grossPay,
                    'deduction_bpjs_kes'   => $deductionBpjsKes,
                    'deduction_bpjs_jht'   => $deductionBpjsJht,
                    'deduction_bpjs_jp'    => $deductionBpjsJp,
                    'total_deductions'     => $deductionTotal,
                    'net_pay'              => $grossPay - $deductionTotal,
                    'updated_by'           => Auth::user()->id,
                ]
            );
        }

        // --- Emergency Contact ---
        if ($request->has('emergency')) {
            $emergencyContacts = $request->input('emergency', []);

            // Simple sync: delete and recreate
            EmployeeEmergency::where('employee_id', $id)->delete();

            foreach ($emergencyContacts as $contact) {
                if (empty(trim($contact['contact_name'] ?? ''))) continue;

                $employeeEmergency = new EmployeeEmergency();
                $employeeEmergency->id = (string) \Illuminate\Support\Str::uuid();
                $employeeEmergency->employee_id = $employee->id;
                $employeeEmergency->contact_name = $contact['contact_name'];
                $employeeEmergency->relationship = $contact['relationship'];
                $employeeEmergency->phone_number = $contact['phone_number'];
                $employeeEmergency->is_primary = $contact['is_primary'] ?? 0;
                $employeeEmergency->address = $contact['address'];
                $employeeEmergency->created_by = Auth::user()->id;
                $employeeEmergency->updated_by = Auth::user()->id;

                $employeeEmergency->save();
            }
        }

        return redirect()->route('employees.detail', $id)->with('success', 'Employee updated successfully');
    }

    public function employeeForm()
    {
        $title = 'Form Employee - HRIS';
        $divisions = Division::all();
        $managers = Employee::all();

        $today = Carbon::now()->format('ymd');

        $lastEmployee = Employee::where('employee_number', 'like', $today . '%')
            ->orderBy('employee_number', 'desc')
            ->first();

        if ($lastEmployee) {
            $lastNumber = (int) substr($lastEmployee->employee_number, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }
        $employeeNumber = $today . $nextNumber;

        return view('page-employee.employee-form', compact('title', 'divisions', 'managers', 'employeeNumber'));
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
        $employeeData['is_remote'] = $request->boolean('is_remote');
        $employeeData->created_by = Auth::user()->id;
        $employeeData->updated_by = Auth::user()->id;

        $userData = new User();
        $userData->id = (string) \Illuminate\Support\Str::uuid();
        $userData->employee_id = $uuid;
        $userData->name = $request->full_name;
        $userData->email = $request->work_email;
        $userData->password = Hash::make('12345678');
        $userData->role = 'employee';
        $userData->created_by = Auth::user()->id;
        $userData->updated_by = Auth::user()->id;

        // Handle upload foto profil
        if ($request->hasFile('profile_photo')) {
            $employeeData['profile_photo'] = $request
                ->file('profile_photo')
                ->store(
                    'profile-photos/' . $uuid,
                    'public'
                );
        }

        // ----------------------------------------------------------
        // 3. IDENTITY (tabel: employee_identities)
        // ----------------------------------------------------------
        $identityData = $request->input('identity', []);

        // Handle upload dokumen KTP
        if ($request->hasFile('ktp_document')) {
            $identityData['ktp_document_path'] = $request
                ->file('ktp_document')
                ->store('employees/docs' . $uuid, 'public');
        }

        // Handle upload dokumen NPWP
        if ($request->hasFile('npwp_document')) {
            $identityData['npwp_document_path'] = $request
                ->file('npwp_document')
                ->store('employees/docs' . $uuid, 'public');
        }

        $employeeIdentity = new EmployeeIndentities();
        $employeeIdentity->id = (string) \Illuminate\Support\Str::uuid();
        $employeeIdentity->employee_id = $uuid;
        $employeeIdentity->nik_ktp = $identityData['nik_ktp'];
        $employeeIdentity->npwp = $identityData['npwp'];
        $employeeIdentity->bpjs_ketenagakerjaan = $identityData['bpjs_ketenagakerjaan'];
        $employeeIdentity->bpjs_kesehatan = $identityData['bpjs_kesehatan'];
        $employeeIdentity->passport_number = $identityData['passport_number'];
        $employeeIdentity->passport_expiry = $identityData['passport_expiry'];
        $employeeIdentity->tax_status_ptkp = $identityData['tax_status_ptkp'];
        $employeeIdentity->tax_method = $identityData['tax_method'];
        $employeeIdentity->ktp_document_path = $identityData['ktp_document_path'];
        $employeeIdentity->npwp_document_path = $identityData['npwp_document_path'];
        $employeeIdentity->created_by = Auth::user()->id;
        $employeeIdentity->updated_by = Auth::user()->id;

        // ----------------------------------------------------------
        // 4. BANK ACCOUNT (tabel: employee_bank_accounts)
        // ----------------------------------------------------------
        $bankData = $request->input('bank', []);

        // dd($bankData);
        $employeeBank = new EmployeeBank();
        $employeeBank->id = (string) \Illuminate\Support\Str::uuid();
        $employeeBank->employee_id = $uuid;
        $employeeBank->bank_name = $bankData['bank_name'];
        $employeeBank->bank_branch = $bankData['bank_branch'];
        $employeeBank->account_number = $bankData['account_number'];
        $employeeBank->account_holder_name = $bankData['account_holder_name'];
        $employeeBank->is_primary = $bankData['is_primary'];
        $employeeBank->created_by = Auth::user()->id;
        $employeeBank->updated_by = Auth::user()->id;

        // ----------------------------------------------------------
        // 5. SALARY / PAYROLL (tabel: payrolls)
        //    Hitung allowance_total dari semua tunjangan
        // ----------------------------------------------------------
        $salaryData = $request->input('salary', []);

        // Bersihkan format angka (kalau ada titik ribuan dari JS)
        $cleanNumber = fn($v) => (float) str_replace(['.', ','], ['', '.'], $v ?? 0);
        $basicSalary    = $cleanNumber($salaryData['basic_salary'] ?? 0);

        $allowPosition  = $cleanNumber($salaryData['allowance_position'] ?? 0);
        $allowMeal      = $cleanNumber($salaryData['allowance_meal'] ?? 0);
        $allowTransport = $cleanNumber($salaryData['allowance_transport'] ?? 0);
        $allowOther     = $cleanNumber($salaryData['allowance_other'] ?? 0);

        $allowanceTotal = $allowPosition + $allowMeal + $allowTransport + $allowOther;
        $grossPay       = $basicSalary + $allowanceTotal;

        $bpjsBase = $basicSalary;

        $deductionBpjsKes = $bpjsBase * 0.01; // 1%  
        $deductionBpjsJht = $bpjsBase * 0.02; // 2%  
        $deductionBpjsJp  = $bpjsBase * 0.01; // 
        $deductionTotal = $deductionBpjsJp + $deductionBpjsJht + $deductionBpjsKes;

        $employeePayroll = new EmployeePayroll();
        $employeePayroll->id = (string) \Illuminate\Support\Str::uuid();
        $employeePayroll->employee_id = $uuid;
        $employeePayroll->basic_salary = $basicSalary;
        $employeePayroll->allowance_position = $allowPosition;
        $employeePayroll->allowance_meal = $allowMeal;
        $employeePayroll->allowance_transport = $allowTransport;
        $employeePayroll->allowance_other = $allowOther;
        $employeePayroll->allowance_total = $allowanceTotal;
        $employeePayroll->gross_pay = $grossPay;
        $employeePayroll->deduction_bpjs_kes = $deductionBpjsKes;
        $employeePayroll->deduction_bpjs_jht = $deductionBpjsJht;
        $employeePayroll->deduction_bpjs_jp = $deductionBpjsJp;
        $employeePayroll->total_deductions = $deductionTotal;
        $employeePayroll->net_pay = $grossPay - $deductionTotal;
        $employeePayroll->created_by = Auth::user()->id;
        $employeePayroll->updated_by = Auth::user()->id;

        // ----------------------------------------------------------
        // 6. EMERGENCY CONTACTS (tabel: emergency_contacts)
        //    Support multiple contact via emergency[][] array
        // ----------------------------------------------------------
        $emergencyContacts = $request->input('emergency', []);

        foreach ($emergencyContacts as $contact) {
            // Skip jika nama kosong (bisa terjadi jika ada input kosong)
            if (empty(trim($contact['contact_name'] ?? ''))) continue;

            $employeeEmergency = new EmployeeEmergency();
            $employeeEmergency->id = (string) \Illuminate\Support\Str::uuid();
            $employeeEmergency->employee_id = $uuid;
            $employeeEmergency->contact_name = $contact['contact_name'];
            $employeeEmergency->relationship = $contact['relationship'];
            $employeeEmergency->phone_number = $contact['phone_number'];
            $employeeEmergency->is_primary = $contact['is_primary'];
            $employeeEmergency->address = $contact['address'];
            $employeeEmergency->created_by = Auth::user()->id;
            $employeeEmergency->updated_by = Auth::user()->id;

            $employeeEmergency->save();
        }

        $userData->save();
        $employeePayroll->save();
        $employeeBank->save();
        $employeeIdentity->save();
        $employeeData->save();

        // ----------------------------------------------------------
        // 7. REDIRECT
        // ----------------------------------------------------------
        return redirect()
            ->route('employees.index')
            ->with('success', "Employee {$employeeData->full_name} has been created successfully.");
    }

    public function employeeDestroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->is_deleted = '1';
        $employee->deleted_at = now();
        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
