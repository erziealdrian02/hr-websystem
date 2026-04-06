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
                    <p class="text-gray-900 dark:text-white font-medium mt-1">{{ $employee->division->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold">Reporting To</p>
                    <p class="text-gray-900 dark:text-white font-medium mt-1 flex items-center">
                        <img src="https://ui-avatars.com/api/?name=Alex+Tech&background=random" class="w-5 h-5 rounded-full mr-2" alt="">
                        Alex Tech Lead
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

        <!-- Emergency Contact -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Emergency Contacts
            </h3>
            <div class="space-y-4">
                <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $employee->emergency->contact_name ?? 'N/A'}}</p>
                            <p class="text-xs text-red-600 dark:text-red-400 font-semibold uppercase mt-1">{{ $employee->emergency->relationship ?? 'N/A'}}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 dark:text-white">{{ $employee->emergency->phone_number ?? 'N/A'}}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $employee->emergency->address ?? 'N/A'}}</p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>