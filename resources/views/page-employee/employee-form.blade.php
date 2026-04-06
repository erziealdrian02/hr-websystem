<x-app-layout>

    {{-- ============================================================
     SINGLE FORM — semua step ada di dalam 1 <form>
     Data baru di-POST saat tombol "Save Employee" di Step 5
     ============================================================ --}}
    <form
        action="{{ route('employees.store') }}"
        method="POST"
        enctype="multipart/form-data"
        id="employee-form"
        novalidate>

        @csrf

        {{-- ── Header ── --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
            <div>
                <a href="{{ route('employees.index') }}"
                    class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Employees
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Employee</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Fill in all required information to register a new employee</p>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="saveDraft()"
                    class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Save Draft
                </button>
            </div>
        </div>

        {{-- ── Progress Bar ── --}}
        <div class="fade-in mb-6" style="animation-delay:0.05s">
            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">
                <span id="progress-label">Step 1 of 5 — Profile & Position</span>
                <span id="progress-pct">20%</span>
            </div>
            <div class="h-1.5 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                <div id="progress-bar" class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width:20%"></div>
            </div>
        </div>

        {{-- ── Step Tabs ── --}}
        <div class="fade-in mb-6 overflow-x-auto" style="animation-delay:0.1s">
            <div class="flex gap-2 min-w-max">
                <button type="button" onclick="goToStep(1)" id="tab-1"
                    class="tab-btn active flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                    <span id="badge-1" class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
                    Profile & Position
                </button>
                <button type="button" onclick="goToStep(2)" id="tab-2"
                    class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                    <span id="badge-2" class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0">2</span>
                    Official ID
                </button>
                <button type="button" onclick="goToStep(3)" id="tab-3"
                    class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                    <span id="badge-3" class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0">3</span>
                    Personal Info
                </button>
                <button type="button" onclick="goToStep(4)" id="tab-4"
                    class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                    <span id="badge-4" class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0">4</span>
                    Payroll & Bank
                </button>
                <button type="button" onclick="goToStep(5)" id="tab-5"
                    class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                    <span id="badge-5" class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0">5</span>
                    Emergency Contact
                </button>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         STEP 1 — Profile & Position
         Fields: employees table (langsung, tanpa prefix)
    ══════════════════════════════════════════════ --}}
        <div id="step-1" class="form-section active fade-in" style="animation-delay:0.15s">

            {{-- Photo Upload --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-6 info-card">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Employee Photo
                </h3>
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div id="photo-preview-wrap"
                        class="w-28 h-28 rounded-xl bg-gray-100 dark:bg-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-600">
                        <svg id="photo-icon" class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <img id="photo-preview" class="hidden w-full h-full object-cover" src="" alt="Preview">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="photo-upload rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer text-center block" for="photo-input">
                            <svg class="w-8 h-8 text-blue-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Click to upload photo</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG, PNG, WEBP — Max 2MB • Recommended: 400×400px</p>
                        </label>
                        {{-- name="profile_photo" → disimpan ke employees.profile_photo --}}
                        <input type="file" id="photo-input" name="profile_photo" accept="image/*" class="hidden"
                            onchange="previewPhoto(this)">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Employee Record --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                        </svg>
                        Employee Record
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Employee ID</label>
                            <input type="text"
                                readonly
                                name="employee_number"
                                placeholder="e.g. EMP-1026"
                                value="{{ old('employee_number', $employeeNumber) }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition @error('employee_number') border-red-400 @enderror">
                            @error('employee_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Employment Status</label>
                            <select name="employment_status"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition @error('employment_status') border-red-400 @enderror">
                                <option value="">Select status...</option>
                                <option value="active" {{ old('employment_status') == 'active' ? 'selected' : '' }}>Active Employee</option>
                                <option value="probation" {{ old('employment_status') == 'probation' ? 'selected' : '' }}>Probation</option>
                                <option value="contract" {{ old('employment_status') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="internship" {{ old('employment_status') == 'internship' ? 'selected' : '' }}>Internship</option>
                                <option value="inactive" {{ old('employment_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('employment_status')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Join Date</label>
                            <input type="date"
                                name="join_date"
                                value="{{ old('join_date') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition @error('join_date') border-red-400 @enderror">
                            @error('join_date')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Contract End Date</label>
                            <input type="date"
                                name="contract_end_date"
                                value="{{ old('contract_end_date') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition">
                            <p class="text-xs text-gray-400 mt-1">Leave empty for permanent employees</p>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Remote Work</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Employee works remotely</p>
                            </div>
                            <label class="toggle-switch">
                                {{-- value="1" → is_remote = 1, jika tidak dicentang tidak terkirim (default 0 di controller) --}}
                                <input type="checkbox" name="is_remote" value="1" {{ old('is_remote') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Position & Reporting --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Position & Reporting
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Full Name</label>
                            <input type="text"
                                name="full_name"
                                placeholder="e.g. Sarah Williams"
                                value="{{ old('full_name') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition @error('full_name') border-red-400 @enderror">
                            @error('full_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Job Title / Position</label>
                            <input type="text"
                                name="job_title"
                                placeholder="e.g. Senior Frontend Developer"
                                value="{{ old('job_title') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition @error('job_title') border-red-400 @enderror">
                            @error('job_title')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Department</label>
                            {{-- division_id → relasi ke tabel divisions, idealnya diisi dari DB --}}
                            <select name="division_id"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition @error('division_id') border-red-400 @enderror">
                                <option value="">Select department...</option>
                                @foreach($divisions ?? [] as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                                @endforeach
                                {{-- Fallback jika $divisions belum dipass dari controller --}}
                                @if(empty($divisions))
                                <option value="engineering">Engineering / Tech</option>
                                <option value="hr">Human Resources</option>
                                <option value="finance">Finance & Accounting</option>
                                <option value="marketing">Marketing</option>
                                <option value="sales">Sales</option>
                                <option value="operations">Operations</option>
                                <option value="legal">Legal & Compliance</option>
                                <option value="product">Product</option>
                                <option value="cs">Customer Support</option>
                                @endif
                            </select>
                            @error('division_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Reporting To (Direct Manager)</label>
                            {{-- manager_id → ID employee yang jadi manager --}}
                            <input type="text"
                                name="manager_id"
                                placeholder="Search manager name..."
                                value="{{ old('manager_id') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Work Email</label>
                            <input type="email"
                                name="work_email"
                                placeholder="sarah.williams@company.com"
                                value="{{ old('work_email') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         STEP 2 — Official ID
         Fields: identity[] → tabel employee_identities
    ══════════════════════════════════════════════ --}}
        <div id="step-2" class="form-section">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    Official Identification
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">NIK (KTP)</label>
                        <input type="text"
                            name="identity[nik_ktp]"
                            maxlength="16"
                            placeholder="16-digit NIK number"
                            value="{{ old('identity.nik_ktp') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider @error('identity.nik_ktp') border-red-400 @enderror">
                        @error('identity.nik_ktp')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-1">Must be exactly 16 digits</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">NPWP</label>
                        <input type="text"
                            name="identity[npwp]"
                            placeholder="xx.xxx.xxx.x-xxx.xxx"
                            value="{{ old('identity.npwp') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">BPJS Ketenagakerjaan</label>
                        <input type="text"
                            name="identity[bpjs_ketenagakerjaan]"
                            placeholder="BPJS Ketenagakerjaan number"
                            value="{{ old('identity.bpjs_ketenagakerjaan') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">BPJS Kesehatan</label>
                        <input type="text"
                            name="identity[bpjs_kesehatan]"
                            placeholder="BPJS Kesehatan number"
                            value="{{ old('identity.bpjs_kesehatan') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Passport Number</label>
                        <input type="text"
                            name="identity[passport_number]"
                            placeholder="e.g. B1234567"
                            value="{{ old('identity.passport_number') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Passport Expiry</label>
                        <input type="date"
                            name="identity[passport_expiry]"
                            value="{{ old('identity.passport_expiry') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Tax Status (PTKP)</label>
                        <select name="identity[tax_status_ptkp]"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition @error('identity.tax_status_ptkp') border-red-400 @enderror">
                            <option value="">Select PTKP status...</option>
                            <option value="TK/0" {{ old('identity.tax_status_ptkp') == 'TK/0' ? 'selected' : '' }}>TK/0 — Single, no dependents</option>
                            <option value="TK/1" {{ old('identity.tax_status_ptkp') == 'TK/1' ? 'selected' : '' }}>TK/1 — Single, 1 dependent</option>
                            <option value="TK/2" {{ old('identity.tax_status_ptkp') == 'TK/2' ? 'selected' : '' }}>TK/2 — Single, 2 dependents</option>
                            <option value="TK/3" {{ old('identity.tax_status_ptkp') == 'TK/3' ? 'selected' : '' }}>TK/3 — Single, 3 dependents</option>
                            <option value="K/0" {{ old('identity.tax_status_ptkp') == 'K/0'  ? 'selected' : '' }}>K/0 — Married, no dependents</option>
                            <option value="K/1" {{ old('identity.tax_status_ptkp') == 'K/1'  ? 'selected' : '' }}>K/1 — Married, 1 dependent</option>
                            <option value="K/2" {{ old('identity.tax_status_ptkp') == 'K/2'  ? 'selected' : '' }}>K/2 — Married, 2 dependents</option>
                            <option value="K/3" {{ old('identity.tax_status_ptkp') == 'K/3'  ? 'selected' : '' }}>K/3 — Married, 3 dependents</option>
                        </select>
                        @error('identity.tax_status_ptkp')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tax Method</label>
                        <select name="identity[tax_method]"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option value="">Select method...</option>
                            <option value="gross" {{ old('identity.tax_method') == 'gross' ? 'selected' : '' }}>Gross (employer bears tax)</option>
                            <option value="net" {{ old('identity.tax_method') == 'net'   ? 'selected' : '' }}>Net (employee bears tax)</option>
                            <option value="gross_up" {{ old('identity.tax_method') == 'gross_up' ? 'selected' : '' }}>Gross Up</option>
                        </select>
                    </div>
                </div>

                {{-- Document Uploads --}}
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Document Uploads</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">KTP Scan / Photo</label>
                            <label class="photo-upload rounded-lg p-4 flex items-center gap-3 cursor-pointer block">
                                <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01" />
                                </svg>
                                <div>
                                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Upload KTP</p>
                                    <p class="text-xs text-gray-400">JPG, PNG, PDF — Max 5MB</p>
                                </div>
                                {{-- name="ktp_document" → dihandle terpisah di controller, path disimpan ke identity[ktp_document_path] --}}
                                <input type="file" name="ktp_document" class="hidden" accept="image/*,.pdf">
                            </label>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">NPWP Document</label>
                            <label class="photo-upload rounded-lg p-4 flex items-center gap-3 cursor-pointer block">
                                <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Upload NPWP</p>
                                    <p class="text-xs text-gray-400">JPG, PNG, PDF — Max 5MB</p>
                                </div>
                                {{-- name="npwp_document" → dihandle terpisah di controller --}}
                                <input type="file" name="npwp_document" class="hidden" accept="image/*,.pdf">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         STEP 3 — Personal Information
         Fields: langsung ke tabel employees
    ══════════════════════════════════════════════ --}}
        <div id="step-3" class="form-section">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Personal Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Gender</label>
                        <div class="flex gap-3">
                            <label class="flex-1 flex items-center gap-2 p-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 transition">
                                <input type="radio" name="gender" value="male" class="accent-blue-600" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Male</span>
                            </label>
                            <label class="flex-1 flex items-center gap-2 p-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 transition">
                                <input type="radio" name="gender" value="female" class="accent-blue-600" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Female</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Religion</label>
                        <select name="religion"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option value="">Select religion...</option>
                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen Protestan" {{ old('religion') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                            <option value="Kristen Katolik" {{ old('religion') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                            <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Place of Birth</label>
                        <input type="text"
                            name="place_of_birth"
                            placeholder="e.g. Jakarta"
                            value="{{ old('place_of_birth') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition @error('place_of_birth') border-red-400 @enderror">
                        @error('place_of_birth')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Date of Birth</label>
                        <input type="date"
                            name="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition @error('date_of_birth') border-red-400 @enderror">
                        @error('date_of_birth')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Marital Status</label>
                        <select name="marital_status"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option value="">Select status...</option>
                            <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single (Lajang)</option>
                            <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married (Menikah)</option>
                            <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced (Cerai)</option>
                            <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed (Duda/Janda)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Number of Dependents</label>
                        <input type="number"
                            name="dependents_count"
                            min="0" max="20"
                            placeholder="0"
                            value="{{ old('dependents_count', 0) }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Personal Email</label>
                        <input type="email"
                            name="personal_email"
                            placeholder="e.g. sarah@gmail.com"
                            value="{{ old('personal_email') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition @error('personal_email') border-red-400 @enderror">
                        @error('personal_email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Phone Number</label>
                        <div class="flex gap-2">
                            <span class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium whitespace-nowrap">+62</span>
                            <input type="tel"
                                name="phone_number"
                                placeholder="812 3344 5566"
                                value="{{ old('phone_number') }}"
                                class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition @error('phone_number') border-red-400 @enderror">
                        </div>
                        @error('phone_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">ID Card Address (KTP Address)</label>
                        <textarea rows="2"
                            name="ktp_address"
                            placeholder="Address as written on KTP..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none @error('ktp_address') border-red-400 @enderror">{{ old('ktp_address') }}</textarea>
                        @error('ktp_address')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-2 mb-2">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Current / Domicile Address</label>
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" id="same-address" class="accent-blue-600 w-3 h-3"
                                    onchange="toggleSameAddress(this)">
                                <span class="text-xs text-gray-500 dark:text-gray-400">Same as KTP</span>
                            </label>
                        </div>
                        <textarea id="domicile-address" rows="2"
                            name="domicile_address"
                            placeholder="Current domicile address..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none">{{ old('domicile_address') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Last Education</label>
                        <select name="last_education"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option value="">Select education...</option>
                            <option value="SMA/SMK" {{ old('last_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK / Sederajat</option>
                            <option value="D1/D2/D3" {{ old('last_education') == 'D1/D2/D3' ? 'selected' : '' }}>D1 / D2 / D3</option>
                            <option value="S1/D4" {{ old('last_education') == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                            <option value="S2" {{ old('last_education') == 'S2' ? 'selected' : '' }}>S2 (Master)</option>
                            <option value="S3" {{ old('last_education') == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Field of Study / Major</label>
                        <input type="text"
                            name="field_of_study"
                            placeholder="e.g. Computer Science"
                            value="{{ old('field_of_study') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Blood Type</label>
                        <select name="blood_type"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option value="">Select...</option>
                            <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Nationality</label>
                        <input type="text"
                            name="nationality"
                            placeholder="e.g. Indonesian"
                            value="{{ old('nationality', 'Indonesian') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         STEP 4 — Payroll & Bank
         bank[] → tabel employee_bank_accounts
         salary fields → tidak ada di EmployeeBank model,
         disimpan ke tabel payrolls via controller
    ══════════════════════════════════════════════ --}}
        <div id="step-4" class="form-section">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Salary Structure --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Salary Structure
                    </h3>
                    <div class="space-y-4">
                        {{-- salary[] prefix → disimpan ke payrolls di controller --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Basic Salary (Gaji Pokok)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                                <input type="text"
                                    name="salary[basic_salary]"
                                    placeholder="0"
                                    value="{{ old('salary.basic_salary') }}"
                                    oninput="formatCurrency(this)"
                                    class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono @error('salary.basic_salary') border-red-400 @enderror">
                            </div>
                            @error('salary.basic_salary')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan Jabatan (Position Allowance)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                                <input type="text"
                                    name="salary[allowance_position]"
                                    placeholder="0"
                                    value="{{ old('salary.allowance_position') }}"
                                    oninput="formatCurrency(this)"
                                    class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan Makan (Meal Allowance)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                                <input type="text"
                                    name="salary[allowance_meal]"
                                    placeholder="0"
                                    value="{{ old('salary.allowance_meal') }}"
                                    oninput="formatCurrency(this)"
                                    class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan Transport</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                                <input type="text"
                                    name="salary[allowance_transport]"
                                    placeholder="0"
                                    value="{{ old('salary.allowance_transport') }}"
                                    oninput="formatCurrency(this)"
                                    class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan Lainnya (Other)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                                <input type="text"
                                    name="salary[allowance_other]"
                                    placeholder="0"
                                    value="{{ old('salary.allowance_other') }}"
                                    oninput="formatCurrency(this)"
                                    class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                            </div>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/40">
                            <div class="flex justify-between items-center">
                                <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 uppercase">Total Salary Package</p>
                                <p class="text-base font-bold text-blue-700 dark:text-blue-300 font-mono" id="total-salary">Rp 0</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Pay Frequency</label>
                            <select name="salary[pay_frequency]"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                                <option value="monthly" {{ old('salary.pay_frequency', 'monthly') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="biweekly" {{ old('salary.pay_frequency') == 'biweekly' ? 'selected' : '' }}>Bi-weekly</option>
                                <option value="weekly" {{ old('salary.pay_frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Bank Account --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Bank Account Details
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Bank Name</label>
                            <select name="bank[bank_name]"
                                id="bank-name-select"
                                onchange="updateBankCard()"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition @error('bank.bank_name') border-red-400 @enderror">
                                <option value="">Select bank...</option>
                                <option value="BCA" {{ old('bank.bank_name') == 'BCA' ? 'selected' : '' }}>BCA (Bank Central Asia)</option>
                                <option value="Mandiri" {{ old('bank.bank_name') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                <option value="BNI" {{ old('bank.bank_name') == 'BNI' ? 'selected' : '' }}>BNI (Bank Negara Indonesia)</option>
                                <option value="BRI" {{ old('bank.bank_name') == 'BRI' ? 'selected' : '' }}>BRI (Bank Rakyat Indonesia)</option>
                                <option value="CIMB Niaga" {{ old('bank.bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                <option value="Danamon" {{ old('bank.bank_name') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                                <option value="Permata" {{ old('bank.bank_name') == 'Permata' ? 'selected' : '' }}>Bank Permata</option>
                                <option value="OCBC NISP" {{ old('bank.bank_name') == 'OCBC NISP' ? 'selected' : '' }}>Bank OCBC NISP</option>
                                <option value="BTN" {{ old('bank.bank_name') == 'BTN' ? 'selected' : '' }}>BTN</option>
                                <option value="BSI" {{ old('bank.bank_name') == 'BSI' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                                <option value="Other" {{ old('bank.bank_name') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('bank.bank_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Branch</label>
                            <input type="text"
                                name="bank[bank_branch]"
                                placeholder="e.g. KCU Thamrin"
                                value="{{ old('bank.bank_branch') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Account Number</label>
                            <input type="text"
                                name="bank[account_number]"
                                id="bank-account-input"
                                oninput="updateBankCard()"
                                placeholder="e.g. 8210123456"
                                value="{{ old('bank.account_number') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-widest @error('bank.account_number') border-red-400 @enderror">
                            @error('bank.account_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Account Holder Name</label>
                            <input type="text"
                                name="bank[account_holder_name]"
                                id="bank-holder-input"
                                oninput="updateBankCard()"
                                placeholder="Must match bank records (uppercase)"
                                value="{{ old('bank.account_holder_name') }}"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition uppercase @error('bank.account_holder_name') border-red-400 @enderror">
                            @error('bank.account_holder_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-400 mt-1">Must exactly match the name on the bank account</p>
                        </div>
                        {{-- Hidden is_primary — selalu 1 untuk data pertama --}}
                        <input type="hidden" name="bank[is_primary]" value="1">

                        {{-- Bank card preview --}}
                        <div class="mt-2 rounded-xl p-4 bg-gradient-to-br from-blue-600 to-blue-800 text-white relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full bg-white/10"></div>
                            <div class="absolute -right-2 bottom-0 w-16 h-16 rounded-full bg-white/5"></div>
                            <p class="text-xs text-blue-200 uppercase tracking-widest mb-3">Bank Salary Account</p>
                            <p class="text-lg font-mono font-bold tracking-widest mb-3" id="card-number">•••• •••• ••••</p>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-xs text-blue-200">Account Holder</p>
                                    <p class="text-sm font-bold uppercase tracking-wide" id="card-holder">—</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-blue-200">Bank</p>
                                    <p class="text-sm font-bold" id="card-bank">—</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         STEP 5 — Emergency Contact
         emergency[] → tabel emergency_contacts
         Support multiple contacts via emergency[][] array
    ══════════════════════════════════════════════ --}}
        <div id="step-5" class="form-section">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card mb-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Emergency Contacts
                    <span class="ml-auto text-xs font-normal text-gray-500 dark:text-gray-400">Add at least 1 contact</span>
                </h3>

                <div id="emergency-contacts-list" class="space-y-4">
                    {{-- Contact ke-0 (primary) — pakai emergency[0][field] --}}
                    <div class="emergency-contact-card bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30 p-5">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-sm font-bold text-red-700 dark:text-red-400 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-bold">1</span>
                                Primary Contact
                            </p>
                        </div>
                        <input type="hidden" name="emergency[0][is_primary]" value="1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Full Name</label>
                                <input type="text"
                                    name="emergency[0][contact_name]"
                                    placeholder="Contact's full name"
                                    value="{{ old('emergency.0.contact_name') }}"
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition @error('emergency.0.contact_name') border-red-400 @enderror">
                                @error('emergency.0.contact_name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Relationship</label>
                                <select name="emergency[0][relationship]"
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-red-400 transition @error('emergency.0.relationship') border-red-400 @enderror">
                                    <option value="">Select relationship...</option>
                                    <option value="Suami" {{ old('emergency.0.relationship') == 'Suami' ? 'selected' : '' }}>Husband (Suami)</option>
                                    <option value="Istri" {{ old('emergency.0.relationship') == 'Istri' ? 'selected' : '' }}>Wife (Istri)</option>
                                    <option value="Ayah" {{ old('emergency.0.relationship') == 'Ayah' ? 'selected' : '' }}>Father (Ayah)</option>
                                    <option value="Ibu" {{ old('emergency.0.relationship') == 'Ibu' ? 'selected' : '' }}>Mother (Ibu)</option>
                                    <option value="Kakak/Adik Laki-laki" {{ old('emergency.0.relationship') == 'Kakak/Adik Laki-laki' ? 'selected' : '' }}>Brother</option>
                                    <option value="Kakak/Adik Perempuan" {{ old('emergency.0.relationship') == 'Kakak/Adik Perempuan' ? 'selected' : '' }}>Sister</option>
                                    <option value="Anak Laki-laki" {{ old('emergency.0.relationship') == 'Anak Laki-laki' ? 'selected' : '' }}>Son</option>
                                    <option value="Anak Perempuan" {{ old('emergency.0.relationship') == 'Anak Perempuan' ? 'selected' : '' }}>Daughter</option>
                                    <option value="Teman" {{ old('emergency.0.relationship') == 'Teman' ? 'selected' : '' }}>Friend (Teman)</option>
                                    <option value="Lainnya" {{ old('emergency.0.relationship') == 'Lainnya' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('emergency.0.relationship')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Phone Number</label>
                                <div class="flex gap-2">
                                    <span class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                                    <input type="tel"
                                        name="emergency[0][phone_number]"
                                        placeholder="812 xxxx xxxx"
                                        value="{{ old('emergency.0.phone_number') }}"
                                        class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition @error('emergency.0.phone_number') border-red-400 @enderror">
                                </div>
                                @error('emergency.0.phone_number')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Address</label>
                                <textarea rows="2"
                                    name="emergency[0][address]"
                                    placeholder="Contact's address..."
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition resize-none">{{ old('emergency.0.address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="addEmergencyContact()"
                    class="mt-4 w-full py-3 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Another Emergency Contact
                </button>
            </div>

            {{-- Final Confirmation --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Final Confirmation
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-3 bg-yellow-50 dark:bg-yellow-900/10 rounded-lg border border-yellow-100 dark:border-yellow-900/30">
                        <svg class="w-4 h-4 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-xs text-yellow-700 dark:text-yellow-400">Please review all information carefully. Some fields cannot be easily changed after submission (NIK, Employee ID, Bank Account).</p>
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                        <input type="checkbox" id="confirm-data" class="accent-blue-600 w-4 h-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">I confirm that all information provided is accurate and complete</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                        <input type="checkbox" id="confirm-consent" class="accent-blue-600 w-4 h-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">The employee has given consent for their data to be stored and processed</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── Step Navigation Buttons ── --}}
        <div class="flex justify-between mt-8 fade-in" style="animation-delay:0.2s">
            <button type="button" id="btn-prev" onclick="prevStep()"
                class="hidden bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Previous
            </button>
            <div class="flex-1"></div>
            <button type="button" id="btn-next" onclick="nextStep()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                Next
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            {{-- Tombol submit HANYA muncul di step 5, type="submit" → POST ke server --}}
            <button type="submit" id="btn-submit"
                class="hidden bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Employee
            </button>
        </div>

    </form>{{-- ← tutup form di sini --}}

    {{-- ── Toast Notification ── --}}
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <svg id="toast-icon" class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-msg">Draft saved!</span>
        </div>
    </div>

    <script>
        /* ============================================================
   STEP NAVIGATION
   ============================================================ */
        let currentStep = 1;
        const totalSteps = 5;
        const stepLabels = [
            'Profile & Position',
            'Official ID',
            'Personal Info',
            'Payroll & Bank',
            'Emergency Contact'
        ];

        // Definisi field required per step untuk validasi client-side
        const stepRequiredFields = {
            1: [{
                    name: 'employee_number',
                    label: 'Employee ID'
                },
                {
                    name: 'employment_status',
                    label: 'Employment Status'
                },
                {
                    name: 'join_date',
                    label: 'Join Date'
                },
                {
                    name: 'full_name',
                    label: 'Full Name'
                },
                {
                    name: 'job_title',
                    label: 'Job Title'
                },
                {
                    name: 'division_id',
                    label: 'Department'
                },
            ],
            2: [{
                    name: 'identity[nik_ktp]',
                    label: 'NIK (KTP)'
                },
                {
                    name: 'identity[tax_status_ptkp]',
                    label: 'Tax Status (PTKP)'
                },
            ],
            3: [{
                    name: 'gender',
                    label: 'Gender',
                    type: 'radio'
                },
                {
                    name: 'religion',
                    label: 'Religion'
                },
                {
                    name: 'place_of_birth',
                    label: 'Place of Birth'
                },
                {
                    name: 'date_of_birth',
                    label: 'Date of Birth'
                },
                {
                    name: 'personal_email',
                    label: 'Personal Email'
                },
                {
                    name: 'phone_number',
                    label: 'Phone Number'
                },
                {
                    name: 'ktp_address',
                    label: 'KTP Address'
                },
            ],
            4: [{
                    name: 'salary[basic_salary]',
                    label: 'Basic Salary'
                },
                {
                    name: 'bank[bank_name]',
                    label: 'Bank Name'
                },
                {
                    name: 'bank[account_number]',
                    label: 'Account Number'
                },
                {
                    name: 'bank[account_holder_name]',
                    label: 'Account Holder Name'
                },
            ],
            5: [{
                    name: 'emergency[0][contact_name]',
                    label: 'Emergency Contact Name'
                },
                {
                    name: 'emergency[0][relationship]',
                    label: 'Relationship'
                },
                {
                    name: 'emergency[0][phone_number]',
                    label: 'Emergency Phone'
                },
            ],
        };

        /**
         * Validasi field required pada step tertentu.
         * Return array of error messages (kosong = valid)
         */
        function validateStep(step) {
            const fields = stepRequiredFields[step] || [];
            const errors = [];

            fields.forEach(field => {
                let el;
                if (field.type === 'radio') {
                    el = document.querySelector(`input[name="${field.name}"]:checked`);
                    if (!el) errors.push(field.label);
                } else {
                    el = document.querySelector(`[name="${CSS.escape(field.name)}"]`);
                    if (!el || el.value.trim() === '' || el.value === '') {
                        errors.push(field.label);
                    }
                }
            });

            // Validasi tambahan: NIK harus 16 digit
            if (step === 2) {
                const nik = document.querySelector('[name="identity[nik_ktp]"]');
                if (nik && nik.value.replace(/\D/g, '').length !== 16 && nik.value.trim() !== '') {
                    errors.push('NIK must be exactly 16 digits');
                }
            }

            return errors;
        }

        /**
         * Highlight field error di step aktif
         */
        function highlightErrors(step) {
            const fields = stepRequiredFields[step] || [];
            // Reset semua border dulu
            fields.forEach(field => {
                if (field.type === 'radio') return;
                const el = document.querySelector(`[name="${CSS.escape(field.name)}"]`);
                if (el) el.classList.remove('border-red-400');
            });

            fields.forEach(field => {
                if (field.type === 'radio') return;
                const el = document.querySelector(`[name="${CSS.escape(field.name)}"]`);
                if (el && (el.value.trim() === '' || el.value === '')) {
                    el.classList.add('border-red-400');
                }
            });
        }

        function goToStep(step, skipValidation = false) {
            // Validasi sebelum pindah ke depan
            if (!skipValidation && step > currentStep) {
                const errors = validateStep(currentStep);
                if (errors.length > 0) {
                    highlightErrors(currentStep);
                    showToast('Please fill: ' + errors.slice(0, 2).join(', ') + (errors.length > 2 ? '...' : ''), 'error');
                    return;
                }
            }

            // Hide step lama
            document.getElementById('step-' + currentStep).classList.remove('active');
            document.getElementById('tab-' + currentStep).classList.remove('active');

            // Tandai badge step lama sebagai completed (✓)
            const prevBadge = document.getElementById('badge-' + currentStep);
            if (prevBadge && step > currentStep) {
                prevBadge.innerHTML = '✓';
                prevBadge.classList.remove('bg-gray-300', 'dark:bg-slate-600', 'text-gray-600', 'dark:text-gray-300', 'bg-blue-600', 'text-white');
                prevBadge.classList.add('bg-green-500', 'text-white');
            }

            currentStep = step;

            // Aktifkan step baru
            const stepEl = document.getElementById('step-' + currentStep);
            stepEl.classList.add('active');
            document.getElementById('tab-' + currentStep).classList.add('active');

            // Update badge step aktif
            const activeBadge = document.getElementById('badge-' + currentStep);
            if (activeBadge && !activeBadge.innerHTML.includes('✓')) {
                activeBadge.innerHTML = currentStep;
                activeBadge.classList.remove('bg-gray-300', 'dark:bg-slate-600', 'text-gray-600', 'dark:text-gray-300', 'bg-green-500');
                activeBadge.classList.add('bg-blue-600', 'text-white');
            }

            // Update progress bar
            const pct = Math.round((currentStep / totalSteps) * 100);
            document.getElementById('progress-bar').style.width = pct + '%';
            document.getElementById('progress-pct').textContent = pct + '%';
            document.getElementById('progress-label').textContent =
                'Step ' + currentStep + ' of ' + totalSteps + ' — ' + stepLabels[currentStep - 1];

            // Tombol navigasi
            document.getElementById('btn-prev').classList.toggle('hidden', currentStep === 1);
            document.getElementById('btn-next').classList.toggle('hidden', currentStep === totalSteps);
            document.getElementById('btn-submit').classList.toggle('hidden', currentStep !== totalSteps);

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function nextStep() {
            if (currentStep < totalSteps) goToStep(currentStep + 1);
        }

        function prevStep() {
            if (currentStep > 1) goToStep(currentStep - 1, true); // tidak perlu validasi saat mundur
        }

        /* ============================================================
           FORM SUBMIT — validasi step 5 + checkbox konfirmasi
           type="submit" pada btn-submit sudah otomatis POST,
           kita intercept hanya untuk cek checkbox konfirmasi
           ============================================================ */
        document.getElementById('employee-form').addEventListener('submit', function(e) {
            // Validasi step 5 dulu
            const errors = validateStep(5);
            if (errors.length > 0) {
                e.preventDefault();
                highlightErrors(5);
                showToast('Please fill: ' + errors.slice(0, 2).join(', '), 'error');
                return;
            }

            const c1 = document.getElementById('confirm-data');
            const c2 = document.getElementById('confirm-consent');
            if (!c1.checked || !c2.checked) {
                e.preventDefault();
                showToast('Please check both confirmation boxes', 'error');
                return;
            }

            // Bersihkan angka salary dari format lokal sebelum POST
            // (karena "5.000.000" harus jadi "5000000" di database)
            document.querySelectorAll('[name^="salary["]').forEach(inp => {
                if (inp.type === 'text') {
                    inp.value = inp.value.replace(/\./g, '');
                }
            });
        });

        /* ============================================================
           PHOTO PREVIEW
           ============================================================ */
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                    document.getElementById('photo-preview').classList.remove('hidden');
                    document.getElementById('photo-icon').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        /* ============================================================
           CURRENCY FORMAT
           ============================================================ */
        function formatCurrency(input) {
            let val = input.value.replace(/\D/g, '');
            input.value = val ? parseInt(val).toLocaleString('id-ID') : '';
            updateTotalSalary();
        }

        function updateTotalSalary() {
            const salaryInputs = document.querySelectorAll('[name^="salary["]');
            let total = 0;
            salaryInputs.forEach(inp => {
                if (inp.type === 'text') {
                    const raw = inp.value.replace(/\./g, '').replace(/,/g, '');
                    const n = parseInt(raw);
                    if (!isNaN(n)) total += n;
                }
            });
            document.getElementById('total-salary').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        /* ============================================================
           BANK CARD PREVIEW
           ============================================================ */
        function updateBankCard() {
            const bankEl = document.getElementById('bank-name-select');
            const holderEl = document.getElementById('bank-holder-input');
            const accountEl = document.getElementById('bank-account-input');

            const bankName = bankEl ? (bankEl.options[bankEl.selectedIndex]?.text || '—') : '—';
            const holder = holderEl ? (holderEl.value.toUpperCase() || '—') : '—';
            const accNum = accountEl ? accountEl.value : '';

            // Mask account number: tampilkan 4 digit terakhir saja
            let maskedNum = '•••• •••• ••••';
            if (accNum.length >= 4) {
                maskedNum = '•••• •••• ' + accNum.slice(-4);
            }

            const cardBank = document.getElementById('card-bank');
            const cardHolder = document.getElementById('card-holder');
            const cardNumber = document.getElementById('card-number');

            if (cardBank) cardBank.textContent = bankName !== 'Select bank...' ? bankName : '—';
            if (cardHolder) cardHolder.textContent = holder || '—';
            if (cardNumber) cardNumber.textContent = maskedNum;
        }

        /* ============================================================
           SAME ADDRESS TOGGLE
           ============================================================ */
        function toggleSameAddress(cb) {
            const domicile = document.getElementById('domicile-address');
            const ktpAddr = document.querySelector('[name="ktp_address"]');
            if (cb.checked) {
                domicile.value = ktpAddr ? ktpAddr.value : '';
                domicile.disabled = true;
                domicile.classList.add('opacity-50');
            } else {
                domicile.disabled = false;
                domicile.classList.remove('opacity-50');
            }
        }

        // Sync domicile saat "same as KTP" aktif dan KTP berubah
        document.querySelector('[name="ktp_address"]')?.addEventListener('input', function() {
            const sameCheck = document.getElementById('same-address');
            if (sameCheck?.checked) {
                document.getElementById('domicile-address').value = this.value;
            }
        });

        /* ============================================================
           EMERGENCY CONTACTS — dynamic add
           ============================================================ */
        let contactCount = 1; // index sudah dimulai dari 0 (primary)

        function addEmergencyContact() {
            const idx = contactCount; // akan jadi emergency[1][...], emergency[2][...] dst
            contactCount++;

            const container = document.getElementById('emergency-contacts-list');
            const div = document.createElement('div');
            div.className = 'emergency-contact-card bg-gray-50 dark:bg-slate-700/50 rounded-xl border border-gray-200 dark:border-gray-600 p-5';
            div.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <p class="text-sm font-bold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-gray-400 dark:bg-gray-500 text-white text-xs flex items-center justify-center font-bold">${idx + 1}</span>
                Secondary Contact
            </p>
            <button type="button" onclick="this.closest('.emergency-contact-card').remove()"
                class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <input type="hidden" name="emergency[${idx}][is_primary]" value="0">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Full Name</label>
                <input type="text" name="emergency[${idx}][contact_name]" placeholder="Contact's full name"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Relationship</label>
                <select name="emergency[${idx}][relationship]"
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                    <option value="">Select relationship...</option>
                    <option value="Suami">Husband (Suami)</option>
                    <option value="Istri">Wife (Istri)</option>
                    <option value="Ayah">Father (Ayah)</option>
                    <option value="Ibu">Mother (Ibu)</option>
                    <option value="Kakak/Adik Laki-laki">Brother</option>
                    <option value="Kakak/Adik Perempuan">Sister</option>
                    <option value="Teman">Friend (Teman)</option>
                    <option value="Lainnya">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Phone Number</label>
                <div class="flex gap-2">
                    <span class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                    <input type="tel" name="emergency[${idx}][phone_number]" placeholder="812 xxxx xxxx"
                        class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Alternative Phone</label>
                <div class="flex gap-2">
                    <span class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                    <input type="tel" placeholder="Optional"
                        class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Address</label>
                <textarea rows="2" name="emergency[${idx}][address]" placeholder="Contact's address..."
                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
            </div>
        </div>`;
            container.appendChild(div);
            showToast('Emergency contact added', 'info');
        }

        /* ============================================================
           TOAST
           ============================================================ */
        function showToast(msg, type = 'success') {
            const toast = document.getElementById('toast');
            const iconPath = document.getElementById('toast-icon').querySelector('path') ||
                document.getElementById('toast-icon');

            document.getElementById('toast-msg').textContent = msg;

            const icon = document.getElementById('toast-icon');
            if (type === 'error') {
                icon.classList.replace('text-green-400', 'text-red-400');
            } else if (type === 'info') {
                icon.classList.replace('text-green-400', 'text-blue-400');
            } else {
                icon.classList.replace('text-red-400', 'text-green-400');
                icon.classList.replace('text-blue-400', 'text-green-400');
            }

            toast.classList.remove('hidden');
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        function saveDraft() {
            showToast('Draft saved successfully!', 'success');
        }
    </script>

</x-app-layout>