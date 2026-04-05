<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <a href="{{ route('employees.form') }}"
                class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Employees
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Employee</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Fill in all required information to
                register a new employee</p>
        </div>
        <div class="flex gap-2">
            <button onclick="saveDraft()"
                class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center text-sm">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Save Draft
            </button>
            <button onclick="submitForm()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                Submit
            </button>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="fade-in mb-6" style="animation-delay:0.05s">
        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">
            <span id="progress-label">Step 1 of 5 — Profile & Position</span>
            <span id="progress-pct">20%</span>
        </div>
        <div class="h-1.5 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
            <div id="progress-bar" class="h-full bg-blue-600 rounded-full" style="width:20%"></div>
        </div>
    </div>

    <!-- Step Tabs -->
    <div class="fade-in mb-6 overflow-x-auto" style="animation-delay:0.1s">
        <div class="flex gap-2 min-w-max">
            <button onclick="goToStep(1)" id="tab-1"
                class="tab-btn active flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                <span
                    class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
                Profile & Position
            </button>
            <button onclick="goToStep(2)" id="tab-2"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                <span
                    class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0"
                    id="badge-2">2</span>
                Official ID
            </button>
            <button onclick="goToStep(3)" id="tab-3"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                <span
                    class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0"
                    id="badge-3">3</span>
                Personal Info
            </button>
            <button onclick="goToStep(4)" id="tab-4"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                <span
                    class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0"
                    id="badge-4">4</span>
                Payroll & Bank
            </button>
            <button onclick="goToStep(5)" id="tab-5"
                class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-sm font-medium transition-all bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300">
                <span
                    class="w-6 h-6 rounded-full bg-gray-300 dark:bg-slate-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold flex-shrink-0"
                    id="badge-5">5</span>
                Emergency Contact
            </button>
        </div>
    </div>

    <!-- ===================== STEP 1: Profile & Position ===================== -->
    <div id="step-1" class="form-section active fade-in" style="animation-delay:0.15s">
        <!-- Photo Upload Card -->
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-6 info-card">
            <h3
                class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Employee Photo
            </h3>
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div id="photo-preview-wrap"
                    class="w-28 h-28 rounded-xl bg-gray-100 dark:bg-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-gray-200 dark:border-gray-600">
                    <svg id="photo-icon" class="w-10 h-10 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <img id="photo-preview" class="hidden w-full h-full object-cover" src=""
                        alt="Preview">
                </div>
                <div class="flex-1 w-full">
                    <label
                        class="photo-upload rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer text-center block"
                        for="photo-input">
                        <svg class="w-8 h-8 text-blue-400 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Click to upload
                            photo</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG, PNG, WEBP — Max 2MB •
                            Recommended: 400×400px</p>
                    </label>
                    <input type="file" id="photo-input" accept="image/*" class="hidden"
                        onchange="previewPhoto(this)">
                </div>
            </div>
        </div>

        <!-- Basic Info & Position -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                    </svg>
                    Employee Record
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Employee
                            ID</label>
                        <input type="text" placeholder="e.g. EMP-1026"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Employment
                            Status</label>
                        <select
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition">
                            <option value="">Select status...</option>
                            <option>Active Employee</option>
                            <option>Probation</option>
                            <option>Contract</option>
                            <option>Internship</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Join
                            Date</label>
                        <input type="date"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Contract
                            End Date</label>
                        <input type="date"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition">
                        <p class="text-xs text-gray-400 mt-1">Leave empty for permanent employees</p>
                    </div>
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Remote Work</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Employee works remotely</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Position & Reporting
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Full
                            Name</label>
                        <input type="text" placeholder="e.g. Sarah Williams"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Job
                            Title / Position</label>
                        <input type="text" placeholder="e.g. Senior Frontend Developer"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Department</label>
                        <select
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition">
                            <option value="">Select department...</option>
                            <option>Engineering / Tech</option>
                            <option>Human Resources</option>
                            <option>Finance & Accounting</option>
                            <option>Marketing</option>
                            <option>Sales</option>
                            <option>Operations</option>
                            <option>Legal & Compliance</option>
                            <option>Product</option>
                            <option>Customer Support</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Reporting
                            To (Direct Manager)</label>
                        <input type="text" placeholder="Search manager name..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Work
                            Email</label>
                        <input type="email" placeholder="sarah.williams@company.com"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-400 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Work
                            Location / Office</label>
                        <select
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 transition">
                            <option value="">Select office...</option>
                            <option>Head Office — Jakarta Pusat</option>
                            <option>Branch — Bandung</option>
                            <option>Branch — Surabaya</option>
                            <option>Remote</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== STEP 2: Official ID ===================== -->
    <div id="step-2" class="form-section">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
            <h3
                class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
                Official Identification
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">NIK
                        (KTP)</label>
                    <input type="text" maxlength="16" placeholder="16-digit NIK number"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                    <p class="text-xs text-gray-400 mt-1">Must be exactly 16 digits</p>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">NPWP</label>
                    <input type="text" placeholder="xx.xxx.xxx.x-xxx.xxx"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">BPJS
                        Ketenagakerjaan</label>
                    <input type="text" placeholder="BPJS Ketenagakerjaan number"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">BPJS
                        Kesehatan</label>
                    <input type="text" placeholder="BPJS Kesehatan number"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Passport
                        Number</label>
                    <input type="text" placeholder="e.g. B1234567"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-wider">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Passport
                        Expiry</label>
                    <input type="date"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Tax
                        Status (PTKP)</label>
                    <select
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select PTKP status...</option>
                        <option value="TK0">TK/0 — Single, no dependents</option>
                        <option value="TK1">TK/1 — Single, 1 dependent</option>
                        <option value="TK2">TK/2 — Single, 2 dependents</option>
                        <option value="TK3">TK/3 — Single, 3 dependents</option>
                        <option value="K0">K/0 — Married, no dependents</option>
                        <option value="K1">K/1 — Married, 1 dependent</option>
                        <option value="K2">K/2 — Married, 2 dependents</option>
                        <option value="K3">K/3 — Married, 3 dependents</option>
                        <option value="KI0">K/I/0 — Combined income, no dependents</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tax
                        Method</label>
                    <select
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select method...</option>
                        <option>Gross (employer bears tax)</option>
                        <option>Net (employee bears tax)</option>
                        <option>Gross Up</option>
                    </select>
                </div>
            </div>

            <!-- KTP Upload -->
            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Document Uploads
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">KTP
                            Scan / Photo</label>
                        <label
                            class="photo-upload rounded-lg p-4 flex items-center gap-3 cursor-pointer block">
                            <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01" />
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Upload KTP
                                </p>
                                <p class="text-xs text-gray-400">JPG, PNG, PDF — Max 5MB</p>
                            </div>
                            <input type="file" class="hidden" accept="image/*,.pdf">
                        </label>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">NPWP
                            Document</label>
                        <label
                            class="photo-upload rounded-lg p-4 flex items-center gap-3 cursor-pointer block">
                            <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div>
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Upload NPWP
                                </p>
                                <p class="text-xs text-gray-400">JPG, PNG, PDF — Max 5MB</p>
                            </div>
                            <input type="file" class="hidden" accept="image/*,.pdf">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== STEP 3: Personal Information ===================== -->
    <div id="step-3" class="form-section">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
            <h3
                class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Personal Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Gender</label>
                    <div class="flex gap-3">
                        <label
                            class="flex-1 flex items-center gap-2 p-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 transition">
                            <input type="radio" name="gender" value="male" class="accent-blue-600">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Male</span>
                        </label>
                        <label
                            class="flex-1 flex items-center gap-2 p-3 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 transition">
                            <input type="radio" name="gender" value="female" class="accent-blue-600">
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">Female</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Religion</label>
                    <select
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select religion...</option>
                        <option>Islam</option>
                        <option>Kristen Protestan</option>
                        <option>Kristen Katolik</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Konghucu</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Place
                        of Birth</label>
                    <input type="text" placeholder="e.g. Jakarta"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Date
                        of Birth</label>
                    <input type="date"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Marital
                        Status</label>
                    <select
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select status...</option>
                        <option>Single (Lajang)</option>
                        <option>Married (Menikah)</option>
                        <option>Divorced (Cerai)</option>
                        <option>Widowed (Duda/Janda)</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Number
                        of Dependents</label>
                    <input type="number" min="0" max="20" placeholder="0"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Personal
                        Email</label>
                    <input type="email" placeholder="e.g. sarah@gmail.com"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Phone
                        Number</label>
                    <div class="flex gap-2">
                        <span
                            class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium whitespace-nowrap">+62</span>
                        <input type="tel" placeholder="812 3344 5566"
                            class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">ID
                        Card Address (KTP Address)</label>
                    <textarea rows="2" placeholder="Address as written on KTP..."
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Current
                            / Domicile Address</label>
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" id="same-address" class="accent-blue-600 w-3 h-3"
                                onchange="toggleSameAddress(this)">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Same as KTP</span>
                        </label>
                    </div>
                    <textarea id="domicile-address" rows="2" placeholder="Current domicile address..."
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Last
                        Education</label>
                    <select
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select education...</option>
                        <option>SMA / SMK / Sederajat</option>
                        <option>D1 / D2 / D3</option>
                        <option>S1 / D4</option>
                        <option>S2 (Master)</option>
                        <option>S3 (Doktor)</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Field
                        of Study / Major</label>
                    <input type="text" placeholder="e.g. Computer Science"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Blood
                        Type</label>
                    <select
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select...</option>
                        <option>A</option>
                        <option>B</option>
                        <option>AB</option>
                        <option>O</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Nationality</label>
                    <input type="text" placeholder="e.g. Indonesian" value="Indonesian"
                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== STEP 4: Payroll & Bank ===================== -->
    <div id="step-4" class="form-section">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Salary Structure
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Basic
                            Salary (Gaji Pokok)</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                            <input type="text" placeholder="0" oninput="formatCurrency(this)"
                                class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan
                            Jabatan (Position Allowance)</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                            <input type="text" placeholder="0" oninput="formatCurrency(this)"
                                class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan
                            Makan (Meal Allowance)</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                            <input type="text" placeholder="0" oninput="formatCurrency(this)"
                                class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan
                            Transport</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                            <input type="text" placeholder="0" oninput="formatCurrency(this)"
                                class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tunjangan
                            Lainnya (Other)</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">Rp</span>
                            <input type="text" placeholder="0" oninput="formatCurrency(this)"
                                class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                    </div>
                    <div
                        class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/40">
                        <div class="flex justify-between items-center">
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 uppercase">
                                Total Salary Package</p>
                            <p class="text-base font-bold text-blue-700 dark:text-blue-300 font-mono"
                                id="total-salary">Rp 0</p>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Pay
                            Frequency</label>
                        <select
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option>Monthly</option>
                            <option>Bi-weekly</option>
                            <option>Weekly</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Payroll
                            Notes</label>
                        <textarea rows="2" placeholder="Additional payroll notes..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Bank Account Details
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Bank
                            Name</label>
                        <select
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                            <option value="">Select bank...</option>
                            <option>BCA (Bank Central Asia)</option>
                            <option>Bank Mandiri</option>
                            <option>BNI (Bank Negara Indonesia)</option>
                            <option>BRI (Bank Rakyat Indonesia)</option>
                            <option>CIMB Niaga</option>
                            <option>Danamon</option>
                            <option>Bank Permata</option>
                            <option>Bank OCBC NISP</option>
                            <option>BTN</option>
                            <option>Bank Syariah Indonesia (BSI)</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Branch</label>
                        <input type="text" placeholder="e.g. KCU Thamrin"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Account
                            Number</label>
                        <input type="text" placeholder="e.g. 8210123456"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono tracking-widest">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Account
                            Holder Name</label>
                        <input type="text" placeholder="Must match bank records (uppercase)"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition uppercase">
                        <p class="text-xs text-gray-400 mt-1">Must exactly match the name on the bank
                            account</p>
                    </div>
                    <!-- Bank card preview -->
                    <div
                        class="mt-2 rounded-xl p-4 bg-gradient-to-br from-blue-600 to-blue-800 text-white relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full bg-white/10"></div>
                        <div class="absolute -right-2 bottom-0 w-16 h-16 rounded-full bg-white/5"></div>
                        <p class="text-xs text-blue-200 uppercase tracking-widest mb-3">Bank Salary Account
                        </p>
                        <p class="text-lg font-mono font-bold tracking-widest mb-3">•••• •••• ••••</p>
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-xs text-blue-200">Account Holder</p>
                                <p class="text-sm font-bold uppercase tracking-wide">—</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-blue-200">Bank</p>
                                <p class="text-sm font-bold">—</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================== STEP 5: Emergency Contact ===================== -->
    <div id="step-5" class="form-section">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card mb-6">
            <h3
                class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Emergency Contacts
                <span class="ml-auto text-xs font-normal text-gray-500 dark:text-gray-400">Add at least 1
                    contact</span>
            </h3>

            <div id="emergency-contacts-list" class="space-y-4">
                <!-- Contact 1 -->
                <div
                    class="emergency-contact-card bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <p
                            class="text-sm font-bold text-red-700 dark:text-red-400 flex items-center gap-2">
                            <span
                                class="w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-bold">1</span>
                            Primary Contact
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Full
                                Name</label>
                            <input type="text" placeholder="Contact's full name"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Relationship</label>
                            <select
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-red-400 transition">
                                <option value="">Select relationship...</option>
                                <option>Husband (Suami)</option>
                                <option>Wife (Istri)</option>
                                <option>Father (Ayah)</option>
                                <option>Mother (Ibu)</option>
                                <option>Brother (Kakak/Adik Laki-laki)</option>
                                <option>Sister (Kakak/Adik Perempuan)</option>
                                <option>Son (Anak Laki-laki)</option>
                                <option>Daughter (Anak Perempuan)</option>
                                <option>Friend (Teman)</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Phone
                                Number</label>
                            <div class="flex gap-2">
                                <span
                                    class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                                <input type="tel" placeholder="812 xxxx xxxx"
                                    class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Alternative
                                Phone</label>
                            <div class="flex gap-2">
                                <span
                                    class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                                <input type="tel" placeholder="Optional"
                                    class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Address</label>
                            <textarea rows="2" placeholder="Contact's address..."
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-red-400 transition resize-none"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button onclick="addEmergencyContact()"
                class="mt-4 w-full py-3 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Add Another Emergency Contact
            </button>
        </div>

        <!-- Review Summary -->
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
            <h3
                class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Final Confirmation
            </h3>
            <div class="space-y-3">
                <div
                    class="flex items-start gap-3 p-3 bg-yellow-50 dark:bg-yellow-900/10 rounded-lg border border-yellow-100 dark:border-yellow-900/30">
                    <svg class="w-4 h-4 text-yellow-500 mt-0.5 flex-shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xs text-yellow-700 dark:text-yellow-400">Please review all information
                        carefully. Some fields cannot be easily changed after submission (NIK, Employee ID,
                        Bank Account).</p>
                </div>
                <label
                    class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                    <input type="checkbox" id="confirm-data" class="accent-blue-600 w-4 h-4">
                    <span class="text-sm text-gray-700 dark:text-gray-300">I confirm that all information
                        provided is accurate and complete</span>
                </label>
                <label
                    class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                    <input type="checkbox" id="confirm-consent" class="accent-blue-600 w-4 h-4">
                    <span class="text-sm text-gray-700 dark:text-gray-300">The employee has given consent
                        for their data to be stored and processed</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Step Navigation Buttons -->
    <div class="flex justify-between mt-8 fade-in" style="animation-delay:0.2s">
        <button id="btn-prev" onclick="prevStep()"
            class="hidden bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 19l-7-7 7-7" />
            </svg>
            Previous
        </button>
        <div class="flex-1"></div>
        <button id="btn-next" onclick="nextStep()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
            Next
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <button id="btn-submit" onclick="submitForm()"
            class="hidden bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            Save Employee
        </button>
    </div>
    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div
            class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <svg id="toast-icon" class="w-4 h-4 text-green-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-msg">Draft saved!</span>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 5;
        const stepLabels = ['Profile & Position', 'Official ID', 'Personal Info', 'Payroll & Bank', 'Emergency Contact'];

        function goToStep(step) {
            // Hide current
            document.getElementById('step-' + currentStep).classList.remove('active');
            document.getElementById('tab-' + currentStep).classList.remove('active');

            // Mark completed
            const badge = document.getElementById('badge-' + currentStep);
            if (badge) {
                badge.innerHTML = '✓';
                badge.classList.remove('bg-gray-300', 'dark:bg-slate-600', 'text-gray-600', 'dark:text-gray-300');
                badge.classList.add('bg-green-500', 'text-white');
            }

            currentStep = step;

            // Show new
            document.getElementById('step-' + currentStep).classList.add('active');
            document.getElementById('tab-' + currentStep).classList.add('active');

            // Update progress
            const pct = Math.round((currentStep / totalSteps) * 100);
            document.getElementById('progress-bar').style.width = pct + '%';
            document.getElementById('progress-pct').textContent = pct + '%';
            document.getElementById('progress-label').textContent = 'Step ' + currentStep + ' of ' + totalSteps + ' — ' +
                stepLabels[currentStep - 1];

            // Nav buttons
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
            if (currentStep > 1) goToStep(currentStep - 1);
        }

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

        function formatCurrency(input) {
            let val = input.value.replace(/\D/g, '');
            input.value = val ? parseInt(val).toLocaleString('id-ID') : '';
            updateTotalSalary();
        }

        function updateTotalSalary() {
            const inputs = document.querySelectorAll('#step-4 input[type="text"]');
            let total = 0;
            inputs.forEach(inp => {
                const raw = inp.value.replace(/\./g, '').replace(/,/g, '');
                const n = parseInt(raw);
                if (!isNaN(n)) total += n;
            });
            document.getElementById('total-salary').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function toggleSameAddress(cb) {
            const domicile = document.getElementById('domicile-address');
            if (cb.checked) {
                domicile.disabled = true;
                domicile.classList.add('opacity-50');
                domicile.placeholder = 'Same as KTP address';
            } else {
                domicile.disabled = false;
                domicile.classList.remove('opacity-50');
                domicile.placeholder = 'Current domicile address...';
            }
        }

        let contactCount = 1;

        function addEmergencyContact() {
            contactCount++;
            const container = document.getElementById('emergency-contacts-list');
            const div = document.createElement('div');
            div.className =
                'emergency-contact-card bg-gray-50 dark:bg-slate-700/50 rounded-xl border border-gray-200 dark:border-gray-600 p-5';
            div.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm font-bold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-gray-400 dark:bg-gray-500 text-white text-xs flex items-center justify-center font-bold">${contactCount}</span>
                    Secondary Contact
                </p>
                <button onclick="this.closest('.emergency-contact-card').remove()" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Remove
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Full Name</label>
                    <input type="text" placeholder="Contact's full name" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Relationship</label>
                    <select class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        <option value="">Select relationship...</option>
                        <option>Husband (Suami)</option><option>Wife (Istri)</option>
                        <option>Father (Ayah)</option><option>Mother (Ibu)</option>
                        <option>Brother (Kakak/Adik Laki-laki)</option>
                        <option>Sister (Kakak/Adik Perempuan)</option>
                        <option>Friend (Teman)</option><option>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Phone Number</label>
                    <div class="flex gap-2">
                        <span class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                        <input type="tel" placeholder="812 xxxx xxxx" class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Alternative Phone</label>
                    <div class="flex gap-2">
                        <span class="px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-gray-700 dark:text-gray-300 font-medium">+62</span>
                        <input type="tel" placeholder="Optional" class="flex-1 px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Address</label>
                    <textarea rows="2" placeholder="Contact's address..." class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                </div>
            </div>`;
            container.appendChild(div);
            showToast('Emergency contact added', 'info');
        }

        function showToast(msg, type = 'success') {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toast-icon');
            document.getElementById('toast-msg').textContent = msg;
            if (type === 'success') icon.setAttribute('d', 'M5 13l4 4L19 7');
            else icon.setAttribute('d', 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z');
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        function saveDraft() {
            showToast('Draft saved successfully!', 'success');
        }

        function submitForm() {
            const c1 = document.getElementById('confirm-data');
            const c2 = document.getElementById('confirm-consent');
            if (currentStep < 5) {
                goToStep(5);
                return;
            }
            if (!c1 || !c1.checked || !c2 || !c2.checked) {
                showToast('Please confirm both checkboxes', 'info');
                return;
            }
            showToast('Employee saved successfully! ✓', 'success');
        }
    </script>
</x-app-layout>