<x-app-layout :title="$title">
    <!-- Back Button & Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <a href="{{ route('employees.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Profile
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Employee Profile</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('employees.index') }}" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancel
            </a>
            <button type="submit" form="edit-employee-form" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Changes
            </button>
        </div>
    </div>

    <form id="edit-employee-form" action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-xl p-4 fade-in">
            <p class="font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Profile Header Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-8 flex flex-col md:flex-row gap-6 items-center md:items-start fade-in" style="animation-delay: 0.1s;">
            <!-- Profile Photo -->
            <div class="flex flex-col items-center gap-3">
                <div class="relative">
                    @if($employee->profile_photo)
                    <img id="photo-preview" src="{{ asset('storage/' . $employee->profile_photo) }}" class="w-32 h-32 rounded-lg object-cover shadow-sm" alt="Employee">
                    @else
                    <img id="photo-preview" src="https://ui-avatars.com/api/?name={{ urlencode($employee->full_name) }}&background=random&color=fff&size=200" class="w-32 h-32 rounded-lg object-cover shadow-sm" alt="Employee">
                    @endif
                </div>
                <label for="profile_photo" class="cursor-pointer text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                    Change Photo
                </label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden"
                    onchange="previewPhoto(this)">
                <p class="text-xs text-gray-400 dark:text-gray-500">JPG, PNG. Max 2MB</p>
            </div>

            <!-- Core Fields -->
            <div class="flex-1 w-full">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div class="flex-1">
                        <div class="mb-3">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Full Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $employee->full_name) }}"
                                class="w-full text-2xl font-bold rounded-lg text-gray-900 dark:text-white bg-transparent border-b-2 border-blue-300 dark:border-blue-700 focus:border-blue-600 dark:focus:border-blue-400 focus:outline-none pb-1 transition-colors"
                                placeholder="Employee Full Name" required>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Job Title</label>
                            <input type="text" name="job_title" value="{{ old('job_title', $employee->job_title) }}"
                                class="w-full rounded-lg text-blue-600 dark:text-blue-400  font-medium text-lg bg-transparent border-b-2 border-blue-300 dark:border-blue-700 focus:border-blue-600 dark:focus:border-blue-400 focus:outline-none pb-1 transition-colors"
                                placeholder="Job Title" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Employment Status</label>
                        <select name="employment_status"
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-black dark:bg-blue-700 dark:text-white border border-blue-200 dark:border-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="active" {{ strtolower($employee->employment_status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ strtolower($employee->employment_status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="probation" {{ strtolower($employee->employment_status) === 'probation' ? 'selected' : '' }}>Probation</option>
                            <option value="contract" {{ strtolower($employee->employment_status) === 'contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 w-full text-left">
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Employee ID</label>
                        <input type="text" name="employee_number" value="{{ old('employee_number', $employee->employee_number) }}"
                            class="w-full text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="EMP-001">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Department</label>
                        <select name="division_id"
                            class="w-full tom-select text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ $employee->division_id == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold mb-1">Reporting To</label>
                        <select name="manager_id"
                            class="w-full tom-select text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">— None —</option>
                            @foreach($managers as $manager)
                            <option value="{{ $manager->id }}" {{ $employee->manager_id == $manager->id ? 'selected' : '' }}>
                                {{ $manager->full_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 fade-in" style="animation-delay: 0.2s;">

            <!-- Official Identification -->
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
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">NIK (KTP)</label>
                            <input type="text" name="identity[nik_ktp]" value="{{ old('identity.nik_ktp', $employee->identity->nik_ktp ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="16-digit NIK">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">NPWP</label>
                            <input type="text" name="identity[npwp]" value="{{ old('identity.npwp', $employee->identity->npwp ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="NPWP Number">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">BPJS Ketenagakerjaan</label>
                            <input type="text" name="identity[bpjs_ketenagakerjaan]" value="{{ old('identity.bpjs_ketenagakerjaan', $employee->identity->bpjs_ketenagakerjaan ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="BPJS Ketenagakerjaan No.">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">BPJS Kesehatan</label>
                            <input type="text" name="identity[bpjs_kesehatan]" value="{{ old('identity.bpjs_kesehatan', $employee->identity->bpjs_kesehatan ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="BPJS Kesehatan No.">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Passport No.</label>
                            <input type="text" name="identity[passport_number]" value="{{ old('identity.passport_number', $employee->identity->passport_number ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Passport Number">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Tax Status (PTKP)</label>
                            <select name="identity[tax_status_ptkp]"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">— Select PTKP —</option>
                                @foreach(['TK/0','TK/1','TK/2','TK/3','K/0','K/1','K/2','K/3'] as $ptkp)
                                <option value="{{ $ptkp }}" {{ old('identity.tax_status_ptkp', $employee->identity->tax_status_ptkp ?? '') === $ptkp ? 'selected' : '' }}>
                                    {{ $ptkp }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-2 grid grid-cols-2 gap-4 pt-2 border-t border-gray-100 dark:border-gray-700 mt-2">
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">KTP Document (Upload)</label>
                            <input type="file" name="ktp_document" accept="image/*,.pdf"
                                class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" />
                            @if($employee->identity->ktp_document_path)
                            <a href="{{ asset('storage/' . $employee->identity->ktp_document_path) }}" target="_blank" class="inline-flex items-center mt-1 text-[10px] text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Current KTP
                            </a>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">NPWP Document (Upload)</label>
                            <input type="file" name="npwp_document" accept="image/*,.pdf"
                                class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition" />
                            @if($employee->identity->npwp_document_path)
                            <a href="{{ asset('storage/' . $employee->identity->npwp_document_path) }}" target="_blank" class="inline-flex items-center mt-1 text-[10px] text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Current NPWP
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
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
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Gender</label>
                            <select name="gender"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="male" {{ strtolower($employee->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ strtolower($employee->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Place of Birth</label>
                            <input type="text" name="place_of_birth" value="{{ old('place_of_birth', $employee->place_of_birth) }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="City">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Religion</label>
                            <select name="religion"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $religion)
                                <option value="{{ $religion }}" {{ $employee->religion === $religion ? 'selected' : '' }}>{{ $religion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="+62 812 XXXX XXXX">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Current Address</label>
                            <textarea name="domicile_address" rows="2"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                placeholder="Full domicile address">{{ old('domicile_address', $employee->domicile_address) }}</textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Personal Email</label>
                            <input type="email" name="personal_email" value="{{ old('personal_email', $employee->personal_email) }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="personal@email.com">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payroll & Bank Details -->
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
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Bank Name</label>
                            <input type="text" name="bank[bank_name]" value="{{ old('bank.bank_name', $employee->bank->bank_name ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g. BCA, Mandiri, BRI">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Branch</label>
                            <input type="text" name="bank[bank_branch]" value="{{ old('bank.bank_branch', $employee->bank->bank_branch ?? '') }}"
                                class="w-full text-sm font-semibold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Branch Name">
                        </div>
                        <div class="col-span-2 bg-gray-50 dark:bg-slate-700/50 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Account Number</label>
                                    <input type="text" name="bank[account_number]" value="{{ old('bank.account_number', $employee->bank->account_number ?? '') }}"
                                        class="w-full text-lg font-bold tracking-wider text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Account Number">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Account Holder Name</label>
                                    <input type="text" name="bank[account_holder_name]" value="{{ old('bank.account_holder_name', $employee->bank->account_holder_name ?? '') }}"
                                        class="w-full text-sm font-bold uppercase text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="ACCOUNT HOLDER NAME">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Allowance & Salary Details -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Allowance & Salary
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Basic Salary (Rp)</label>
                            <input type="text" name="salary[basic_salary]" value="{{ number_format($payroll->basic_salary ?? 0, 0, ',', '.') }}"
                                oninput="formatCurrency(this); calculateTotalSalary()"
                                class="salary-input w-full text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Position Allowance (Rp)</label>
                            <input type="text" name="salary[allowance_position]" value="{{ number_format($payroll->allowance_position ?? 0, 0, ',', '.') }}"
                                oninput="formatCurrency(this); calculateTotalSalary()"
                                class="salary-input w-full text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Meal Allowance (Rp)</label>
                            <input type="text" name="salary[allowance_meal]" value="{{ number_format($payroll->allowance_meal ?? 0, 0, ',', '.') }}"
                                oninput="formatCurrency(this); calculateTotalSalary()"
                                class="salary-input w-full text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Transport Allowance (Rp)</label>
                            <input type="text" name="salary[allowance_transport]" value="{{ number_format($payroll->allowance_transport ?? 0, 0, ',', '.') }}"
                                oninput="formatCurrency(this); calculateTotalSalary()"
                                class="salary-input w-full text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Other Allowances (Rp)</label>
                            <input type="text" name="salary[allowance_other]" value="{{ number_format($payroll->allowance_other ?? 0, 0, ',', '.') }}"
                                oninput="formatCurrency(this); calculateTotalSalary()"
                                class="salary-input w-full text-sm font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg border border-blue-100 dark:border-blue-800/40">
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 uppercase">Total Salary Package</p>
                                <p class="text-base font-bold text-blue-700 dark:text-blue-300 font-mono" id="total-salary-display">Rp {{ number_format($payroll->gross_pay ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contacts (Below the Grid) -->
        <div class="mt-8 fade-in" style="animation-delay: 0.25s;">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Emergency Contacts
                    </div>
                    <button type="button" onclick="addEmergencyContact()" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg transition-colors">
                        + Add More
                    </button>
                </h3>

                <div id="emergency-contacts-container" class="space-y-4 text-left">
                    @forelse($employee->emergency as $idx => $contact)
                    <div class="emergency-contact-item bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30 relative">
                        @if($idx > 0)
                        <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Contact Name</label>
                                <input type="text" name="emergency[{{ $idx }}][contact_name]" value="{{ $contact->contact_name }}"
                                    class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            </div>
                            <div>
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Relationship</label>
                                <input type="text" name="emergency[{{ $idx }}][relationship]" value="{{ $contact->relationship }}"
                                    class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            </div>
                            <div>
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Phone Number</label>
                                <input type="text" name="emergency[{{ $idx }}][phone_number]" value="{{ $contact->phone_number }}"
                                    class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                                <input type="hidden" name="emergency[{{ $idx }}][is_primary]" value="{{ $contact->is_primary }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Address</label>
                                <textarea name="emergency[{{ $idx }}][address]" rows="2"
                                    class="w-full text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none">{{ $contact->address }}</textarea>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="emergency-contact-item bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Contact Name</label>
                                <input type="text" name="emergency[0][contact_name]" value=""
                                    class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            </div>
                            <div>
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Relationship</label>
                                <input type="text" name="emergency[0][relationship]" value=""
                                    class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            </div>
                            <div>
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Phone Number</label>
                                <input type="text" name="emergency[0][phone_number]" value=""
                                    class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                                <input type="hidden" name="emergency[0][is_primary]" value="1">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Address</label>
                                <textarea name="emergency[0][address]" rows="2"
                                    class="w-full text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bottom Submit Bar -->
        <div class="mt-8 flex justify-end gap-3 pb-4 fade-in" style="animation-delay: 0.3s;">
            <a href="{{ route('employees.index') }}"
                class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm">
                Cancel
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Changes
            </button>
        </div>
    </form>

    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, "");
            input.value = new Intl.NumberFormat("id-ID").format(value);
        }

        function calculateTotalSalary() {
            let total = 0;
            document.querySelectorAll('.salary-input').forEach(input => {
                let val = parseInt(input.value.replace(/\D/g, "")) || 0;
                total += val;
            });
            document.getElementById('total-salary-display').textContent = 'Rp ' + new Intl.NumberFormat("id-ID").format(total);
        }

        function addEmergencyContact() {
            const container = document.getElementById('emergency-contacts-container');
            const idx = container.querySelectorAll('.emergency-contact-item').length;
            const html = `
                <div class="emergency-contact-item bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/30 relative mt-4">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-400 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Contact Name</label>
                            <input type="text" name="emergency[${idx}][contact_name]" 
                                class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                        </div>
                        <div>
                            <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Relationship</label>
                            <input type="text" name="emergency[${idx}][relationship]" 
                                class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                        </div>
                        <div>
                            <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Phone Number</label>
                            <input type="text" name="emergency[${idx}][phone_number]" 
                                class="w-full text-sm font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            <input type="hidden" name="emergency[${idx}][is_primary]" value="0">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] text-red-600 dark:text-red-400 font-semibold uppercase mb-1">Address</label>
                            <textarea name="emergency[${idx}][address]" rows="2"
                                class="w-full text-sm text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 border border-red-200 dark:border-red-800 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tom-select').forEach((el) => {
                new TomSelect(el, {
                    create: false,
                    dropdownParent: 'body',
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });
        });
    </script>
</x-app-layout>