<x-app-layout>
    <!-- Back Button & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <a href="{{ route('employees.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Employees
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Employee Profile</h1>
        </div>
        <div class="flex gap-2">
            <button class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Profile
            </button>
            <a href="{{ route('employees.edit', $employee->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee account?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-900/50 hover:bg-red-600 hover:text-white text-red-600 dark:text-red-400 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center h-full">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Profile Header Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-8 flex flex-col md:flex-row gap-6 items-center md:items-start fade-in" style="animation-delay: 0.1s;">
        @if($employee->profile_photo)
        <img src="{{ asset('storage/' . $employee->profile_photo) }}" class="w-32 h-32 rounded-lg object-cover shadow-sm" alt="Employee">
        @else
        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->full_name) }}&background=random&color=fff&size=200" class="w-32 h-32 rounded-lg object-cover shadow-sm" alt="Employee">
        @endif
        <div class="flex-1 text-center md:text-left">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $employee->full_name }}</h2>
                    <p class="text-blue-600 dark:text-blue-400 font-medium text-lg">{{ $employee->job_title }}</p>
                </div>
                <span class="inline-flex mt-2 md:mt-0 items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                    {{ ucfirst(strtolower($employee->employment_status)) }} Employee
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 w-full text-left">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Employee ID</p>
                    <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $employee->employee_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Department</p>
                    <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $employee->division->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Reporting To</p>
                    <p class="text-gray-900 dark:text-white font-medium mt-1 flex items-center">
                        @if($employee->manager)
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->manager->full_name) }}&background=random" class="w-5 h-5 rounded-full mr-2" alt="">
                        {{ $employee->manager->full_name }}
                        @else
                        —
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Information Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 fade-in" style="animation-delay: 0.2s;">

        <!-- Official ID Data -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
                Official Identification
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">NIK (KTP)</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->identity->nik_ktp ?? 'N/A'}}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">NPWP</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->identity->npwp ?? 'N/A'}}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">BPJS Ketenagakerjaan</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->identity->bpjs_ketenagakerjaan ?? 'N/A'}}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">BPJS Kesehatan</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->identity->bpjs_kesehatan ?? 'N/A'}}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Passport No.</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->identity->passport_number ?? 'N/A'}}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Tax Status (PTKP)</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->identity->tax_status_ptkp ?? 'N/A'}}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">KTP Document</p>
                        @if($employee->identity && $employee->identity->ktp_document_path)
                        <a href="{{ asset('storage/' . $employee->identity->ktp_document_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 text-xs hover:underline flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View File
                        </a>
                        @else
                        <p class="text-[10px] text-gray-400">Not uploaded</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">NPWP Document</p>
                        @if($employee->identity && $employee->identity->npwp_document_path)
                        <a href="{{ asset('storage/' . $employee->identity->npwp_document_path) }}" target="_blank" class="text-blue-600 dark:text-blue-400 text-xs hover:underline flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View File
                        </a>
                        @else
                        <p class="text-[10px] text-gray-400">Not uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Data -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Personal Information
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Full Name</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Gender</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst(strtolower($employee->gender)) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Place / Date of Birth</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->place_of_birth }}, {{ $employee->date_of_birth }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Religion</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->religion }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Current Address</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->domicile_address }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Personal Email</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->personal_email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Phone Number</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">+62 812 3344 5566</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial & Bank -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Payroll & Bank Details
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Bank Name</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->bank->bank_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Branch</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee->bank->bank_branch ?? 'N/A' }}</p>
                    </div>
                    <div class="col-span-2 flex justify-between bg-gray-50 dark:bg-slate-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Account Number</p>
                            <p class="text-lg font-bold tracking-wider text-gray-900 dark:text-white">{{ $employee->bank->account_number ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Account Holder</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white uppercase">{{ $employee->bank->account_holder_name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">

            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Allowance & Salary
            </h3>

            <div class="grid grid-cols-2 gap-4 text-sm">

                <!-- ITEM -->
                @php
                function rupiah($value) {
                return 'Rp ' . number_format($value ?? 0, 0, ',', '.');
                }
                @endphp

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Basic Salary</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ rupiah($employee->payroll->basic_salary ?? 0) }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Position Allowance</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ rupiah($employee->payroll->allowance_position ?? 0) }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Meal Allowance</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ rupiah($employee->payroll->allowance_meal ?? 0) }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Transport Allowance</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ rupiah($employee->payroll->allowance_transport ?? 0) }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Other Allowances</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ rupiah($employee->payroll->allowance_other ?? 0) }}</p>
                </div>

                <!-- TOTAL -->
                <div class="col-span-2 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-100 dark:border-blue-800/40 mt-2">
                    <div class="flex justify-between items-center">
                        <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 uppercase">
                            Total Salary Package
                        </p>
                        <p class="text-lg font-bold text-blue-700 dark:text-blue-300 font-mono">
                            {{ rupiah($employee->payroll->gross_pay ?? 0) }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="mt-8 fade-in" style="animation-delay: 0.25s;">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Emergency Contacts
            </h3>

            <div id="emergency-contacts-container" class="space-y-4 text-left">
                @forelse($emergencies as $emergency)
                <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $emergency->contact_name ?? 'N/A'}}</p>
                            <p class="text-xs text-red-600 dark:text-red-400 font-semibold uppercase mt-1">{{ $emergency->relationship ?? 'N/A'}}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 dark:text-white">0{{ $emergency->phone_number ?? 'N/A'}}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $emergency->address ?? 'N/A'}}</p>
                </div>
                @empty
                <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30">
                    <p class="text-sm text-gray-600 dark:text-gray-400">No emergency contacts found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>