<x-app-layout :title="$title">

    {{--
        CATATAN CONTROLLER - update profile() agar load relasi lengkap:

        public function profile()
        {
            $title = 'My Profile - HRIS';
            $user = Auth::user();
            $employee = $user->employee()->with(['identity', 'bank', 'emergency', 'division', 'manager', 'payroll'])->first();
            $emergencies = $employee?->emergency ?? collect();
            return view('page-profile.profile', compact('title', 'user', 'employee', 'emergencies'));
        }
    --}}

    <div x-data="{ activeTab: 'personal' }">

        <!-- Alerts -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @php
        $defaultCover = 'bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-800';
        $hasCover = $employee?->background_photo;
        $coverClass = $hasCover
        ? 'h-48 md:h-64 relative bg-cover bg-center'
        : 'h-48 md:h-64 relative ' . $defaultCover;
        $avatarUrl = $employee?->profile_photo
        ? Storage::url($employee->profile_photo)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=200';
        @endphp

        <!-- ════════════════════════════════════════
             COVER + AVATAR + TABS HEADER
        ════════════════════════════════════════ -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-6 fade-in">

            <!-- Cover -->
            <div class="{{ $coverClass }}"
                @if($hasCover) style="background-image: url('{{ Storage::url($employee->background_photo) }}');" @endif>
                <button @click="$dispatch('open-modal', 'edit-photos')"
                    class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Edit Photos
                </button>
            </div>

            <!-- Avatar + Name -->
            <div class="px-6 pb-0 relative flex flex-col md:flex-row md:items-end gap-5 md:-mt-14">
                <!-- Avatar -->
                <div class="relative mx-auto md:mx-0 -mt-16 md:mt-0 z-10 flex-shrink-0">
                    <img src="{{ $avatarUrl }}"
                        class="w-32 h-32 md:w-36 md:h-36 rounded-xl border-4 border-white dark:border-slate-800 object-cover shadow-md"
                        alt="Profile">
                    <button @click="$dispatch('open-modal', 'edit-photos')"
                        class="absolute -bottom-1 -right-1 bg-blue-600 text-white rounded-lg p-2 shadow-lg hover:bg-blue-700 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                </div>

                <!-- Name & meta -->
                <div class="text-center md:text-left flex-1 pb-4 md:pb-0">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $employee?->full_name ?? $user->name }}
                            </h1>
                            <p class="text-blue-600 dark:text-blue-400 font-medium mt-0.5">
                                {{ $employee?->job_title ?? 'Employee' }}
                                @if($employee?->division?->name)
                                <span class="text-gray-400"> · {{ $employee->division->name }}</span>
                                @endif
                            </p>
                        </div>
                        <span class="self-center inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            {{ ucfirst(str_replace('_', ' ', $employee?->employment_status ?? 'Active')) }}
                        </span>
                    </div>

                    <!-- Quick meta pills -->
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-4 gap-y-1.5 mt-2.5 text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $employee?->employee_number ?? '-' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ ucfirst($employee?->work_location ?? 'Office') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Joined {{ $employee?->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('M Y') : '-' }}
                        </span>
                        @if($employee?->manager)
                        <span class="flex items-center gap-1">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->manager->full_name) }}&background=random&size=40"
                                class="w-4 h-4 rounded-full" alt="">
                            {{ $employee->manager->full_name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab Nav -->
            <div class="border-t border-gray-100 dark:border-gray-700 px-4 md:px-6 mt-4">
                <nav class="flex gap-0 overflow-x-auto -mb-px scrollbar-hide">
                    @foreach([
                    ['personal', 'Personal', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['work', 'Work Details', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['identity', 'Identity', 'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2'],
                    ['payroll', 'Payroll & Bank', 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                    ['emergency', 'Emergency', 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'],
                    ] as [$key, $label, $icon])
                    <button
                        @click="activeTab = '{{ $key }}'"
                        :class="activeTab === '{{ $key }}'
                            ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400'
                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'"
                        class="flex items-center gap-1.5 whitespace-nowrap px-4 py-3.5 border-b-2 text-sm font-medium transition-colors flex-shrink-0">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                        </svg>
                        {{ $label }}
                    </button>
                    @endforeach
                </nav>
            </div>
        </div>

        <!-- ════════════════════════════════════════
             TAB PANELS
        ════════════════════════════════════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-2 flex flex-col gap-1">
                    <div class="px-4 py-3 rounded-lg text-sm font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                        Personal Information
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-3 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        Account Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors mt-2">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <!-- ── PERSONAL ── -->
                <div x-show="activeTab === 'personal'"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <!-- Content -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Basic Information
                            </h2>
                            <button @click="$dispatch('open-modal', 'edit-info')"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Edit Info</button>
                        </div>

                        @php
                        $personalFields = [
                        ['Full Name', $employee?->full_name ?? $user->name],
                        ['Personal Email', $employee?->personal_email ?? '-'],
                        ['Phone Number', $employee?->phone_number ?? '-'],
                        ['Place of Birth', $employee?->place_of_birth ?? '-'],
                        ['Date of Birth', $employee?->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d F Y') : '-'],
                        ['Gender', $employee?->gender ?? '-'],
                        ['Religion', $employee?->religion ?? '-'],
                        ['Marital Status', $employee?->marital_status ?? '-'],
                        ['Blood Type', $employee?->blood_type ?? '-'],
                        ];
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                            @foreach($personalFields as [$label, $val])
                            <div>
                                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">{{ $label }}</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $val }}</p>
                            </div>
                            @endforeach
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Domicile Address</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee?->domicile_address ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">KTP Address</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee?->ktp_address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── WORK DETAILS ── -->
                <div x-show="activeTab === 'work'"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Work Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Employee ID</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee?->employee_number ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Department</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee?->division?->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Direct Manager</p>
                                @if($employee?->manager)
                                <div class="flex items-center gap-2 mt-1">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->manager->full_name) }}&background=random&size=40"
                                        class="w-6 h-6 rounded-full" alt="">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee->manager->full_name }}</p>
                                </div>
                                @else
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">-</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Job Title</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee?->job_title ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Employment Status</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ ucfirst(str_replace('_', ' ', $employee?->employment_status ?? 'Unknown')) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Work Location</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ ucfirst($employee?->work_location ?? '-') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Work Email</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $employee?->work_email ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Join Date</p>
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ $employee?->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── IDENTITY ── -->
                <div x-show="activeTab === 'identity'"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                                Official Identification
                            </h2>
                            <button @click="$dispatch('open-modal', 'edit-identity')"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Edit Identity</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6 mb-6">
                            @php
                            $idFields = [
                            ['NIK (KTP)', $employee?->identity?->nik_ktp],
                            ['NPWP', $employee?->identity?->npwp],
                            ['BPJS Ketenagakerjaan', $employee?->identity?->bpjs_ketenagakerjaan],
                            ['BPJS Kesehatan', $employee?->identity?->bpjs_kesehatan],
                            ['Passport Number', $employee?->identity?->passport_number],
                            ['Tax Status (PTKP)', $employee?->identity?->tax_status_ptkp],
                            ];
                            @endphp
                            @foreach($idFields as [$label, $val])
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $label }}</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white font-mono tracking-wide">{{ $val ?? 'N/A' }}</p>
                            </div>
                            @endforeach
                        </div>

                        <!-- Documents -->
                        <div class="pt-5 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Documents</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach([
                                ['KTP Document', $employee?->identity?->ktp_document_path],
                                ['NPWP Document', $employee?->identity?->npwp_document_path],
                                ] as [$docLabel, $docPath])
                                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-slate-700/40">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $docLabel }}</p>
                                            <p class="text-xs {{ $docPath ? 'text-green-500' : 'text-gray-400' }}">
                                                {{ $docPath ? 'Uploaded' : 'Not uploaded' }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($docPath)
                                    <a href="{{ asset('storage/' . $docPath) }}" target="_blank"
                                        class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        View
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── PAYROLL & BANK ── -->
                <div x-show="activeTab === 'payroll'"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <!-- Bank Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                            <div class="flex justify-between items-center mb-5">
                                <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Bank Details
                                </h2>
                                <button @click="$dispatch('open-modal', 'edit-bank')"
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Edit Bank</button>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Bank Name</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee?->bank?->bank_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Branch</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $employee?->bank?->bank_branch ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-5 rounded-xl shadow">
                                <p class="text-xs font-semibold uppercase tracking-wider opacity-75 mb-1">Account Number</p>
                                <p class="text-2xl font-bold tracking-widest font-mono mb-4">
                                    {{ $employee?->bank?->account_number ?? '—' }}
                                </p>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-xs opacity-75 uppercase tracking-wider mb-0.5">Account Holder</p>
                                        <p class="font-bold uppercase text-sm">{{ $employee?->bank?->account_holder_name ?? '—' }}</p>
                                    </div>
                                    <p class="font-bold text-sm opacity-75">{{ $employee?->bank?->bank_name ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Salary Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-5">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Allowance & Salary
                            </h2>
                            @php
                            function rupiah($v) { return 'Rp ' . number_format($v ?? 0, 0, ',', '.'); }
                            $salaryRows = [
                            ['Basic Salary', $employee?->payroll?->basic_salary],
                            ['Position Allowance', $employee?->payroll?->allowance_position],
                            ['Meal Allowance', $employee?->payroll?->allowance_meal],
                            ['Transport Allowance', $employee?->payroll?->allowance_transport],
                            ['Other Allowances', $employee?->payroll?->allowance_other],
                            ];
                            @endphp
                            <div class="space-y-1">
                                @foreach($salaryRows as [$sLabel, $sVal])
                                <div class="flex justify-between items-center py-2.5 border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $sLabel }}</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white font-mono">{{ rupiah($sVal) }}</p>
                                </div>
                                @endforeach
                            </div>
                            <div class="flex justify-between items-center bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800/40 mt-4">
                                <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wider">Total Package</p>
                                <p class="text-lg font-bold text-blue-700 dark:text-blue-300 font-mono">{{ rupiah($employee?->payroll?->gross_pay) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── EMERGENCY ── -->
                <div x-show="activeTab === 'emergency'"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Emergency Contacts
                            </h2>
                            <button @click="$dispatch('open-modal', 'add-emergency')"
                                class="flex items-center gap-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Contact
                            </button>
                        </div>

                        @forelse($emergencies as $emergency)
                        <div class="mb-4 last:mb-0 bg-red-50 dark:bg-red-900/10 p-5 rounded-xl border border-red-100 dark:border-red-900/30">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $emergency->contact_name ?? 'N/A' }}</p>
                                    <span class="inline-block mt-1 text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wider bg-red-100 dark:bg-red-900/30 px-2 py-0.5 rounded-full">
                                        {{ $emergency->relationship ?? 'N/A' }}
                                    </span>
                                </div>
                                <div class="flex items-start gap-3 md:text-right">
                                    <div class="md:text-right">
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Phone</p>
                                        <p class="font-bold text-gray-900 dark:text-white font-mono">{{ $emergency->phone_number ?? 'N/A' }}</p>
                                    </div>
                                    <!-- Action buttons -->
                                    <div class="flex gap-1.5 flex-shrink-0 mt-1">
                                        <button
                                            @click="$dispatch('open-modal', 'edit-emergency-{{ $emergency->id }}')"
                                            class="p-1.5 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 text-gray-500 hover:text-blue-600 hover:border-blue-400 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <form method="POST" action="{{ route('profile.emergency.destroy', $emergency->id) }}"
                                            onsubmit="return confirm('Hapus kontak darurat ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 text-gray-500 hover:text-red-600 hover:border-red-400 transition-colors"
                                                title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($emergency->address)
                            <div class="mt-3 pt-3 border-t border-red-100 dark:border-red-900/20">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Address</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $emergency->address }}</p>
                            </div>
                            @endif
                        </div>

                        {{-- Edit Emergency Modal (per contact) --}}
                        <x-modal name="edit-emergency-{{ $emergency->id }}" focusable>
                            <form method="POST" action="{{ route('profile.emergency.update', $emergency->id) }}" class="p-6">
                                @csrf @method('PUT')
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Edit Emergency Contact</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="contact_name_{{ $emergency->id }}" value="Contact Name" />
                                        <x-text-input id="contact_name_{{ $emergency->id }}" name="contact_name" type="text" class="mt-1 block w-full"
                                            :value="old('contact_name', $emergency->contact_name)" required />
                                    </div>
                                    <div>
                                        <x-input-label for="relationship_{{ $emergency->id }}" value="Relationship" />
                                        <select id="relationship_{{ $emergency->id }}" name="relationship"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            @foreach(['Spouse','Parent','Sibling','Child','Friend','Other'] as $rel)
                                            <option value="{{ $rel }}" {{ old('relationship', $emergency->relationship) === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="phone_number_{{ $emergency->id }}" value="Phone Number" />
                                        <x-text-input id="phone_number_{{ $emergency->id }}" name="phone_number" type="text" class="mt-1 block w-full"
                                            :value="old('phone_number', $emergency->phone_number)" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <x-input-label for="address_{{ $emergency->id }}" value="Address" />
                                        <textarea id="address_{{ $emergency->id }}" name="address" rows="3"
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address', $emergency->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end gap-3">
                                    <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                    <x-primary-button>Save Changes</x-primary-button>
                                </div>
                            </form>
                        </x-modal>
                        @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-14 h-14 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-7 h-7 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No emergency contacts on file.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ════════════════════════════════════════
         MODALS
    ════════════════════════════════════════ -->

    <!-- Edit Info Modal -->
    <x-modal name="edit-info" focusable>
        <form method="POST" action="{{ route('profile.data.update') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Edit Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="phone_number" value="Phone Number" />
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $employee?->phone_number)" />
                </div>
                <div>
                    <x-input-label for="personal_email" value="Personal Email" />
                    <x-text-input id="personal_email" name="personal_email" type="email" class="mt-1 block w-full" :value="old('personal_email', $employee?->personal_email)" />
                </div>
                <div>
                    <x-input-label for="gender" value="Gender" />
                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Gender</option>
                        @foreach(['Male','Female'] as $g)
                        <option value="{{ $g }}" {{ old('gender', $employee?->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="religion" value="Religion" />
                    <select id="religion" name="religion" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Religion</option>
                        @foreach(['Islam','Protestant','Catholic','Hindu','Buddhist','Confucian','Other'] as $r)
                        <option value="{{ $r }}" {{ old('religion', $employee?->religion) === $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="place_of_birth" value="Place of Birth" />
                    <x-text-input id="place_of_birth" name="place_of_birth" type="text" class="mt-1 block w-full" :value="old('place_of_birth', $employee?->place_of_birth)" />
                </div>
                <div>
                    <x-input-label for="date_of_birth" value="Date of Birth" />
                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $employee?->date_of_birth)" />
                </div>
                <div>
                    <x-input-label for="marital_status" value="Marital Status" />
                    <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Status</option>
                        @foreach(['Single','Married','Divorced','Widowed'] as $s)
                        <option value="{{ $s }}" {{ old('marital_status', $employee?->marital_status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="blood_type" value="Blood Type" />
                    <select id="blood_type" name="blood_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Type</option>
                        @foreach(['A','B','AB','O'] as $b)
                        <option value="{{ $b }}" {{ old('blood_type', $employee?->blood_type) === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="domicile_address" value="Domicile Address" />
                    <textarea id="domicile_address" name="domicile_address" rows="3"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('domicile_address', $employee?->domicile_address) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="ktp_address" value="KTP Address" />
                    <textarea id="ktp_address" name="ktp_address" rows="3"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('ktp_address', $employee?->ktp_address) }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button>Save Changes</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- ════ EDIT IDENTITY MODAL ════ -->
    <x-modal name="edit-identity" focusable>
        <form method="POST" action="{{ route('profile.identity.update') }}" class="p-6">
            @csrf @method('PUT')
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Edit Official Identification</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="nik_ktp" value="NIK (KTP)" />
                    <x-text-input id="nik_ktp" name="nik_ktp" type="text" class="mt-1 block w-full"
                        :value="old('nik_ktp', $employee?->identity?->nik_ktp)" />
                </div>
                <div>
                    <x-input-label for="npwp" value="NPWP" />
                    <x-text-input id="npwp" name="npwp" type="text" class="mt-1 block w-full"
                        :value="old('npwp', $employee?->identity?->npwp)" />
                </div>
                <div>
                    <x-input-label for="bpjs_ketenagakerjaan" value="BPJS Ketenagakerjaan" />
                    <x-text-input id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan" type="text" class="mt-1 block w-full"
                        :value="old('bpjs_ketenagakerjaan', $employee?->identity?->bpjs_ketenagakerjaan)" />
                </div>
                <div>
                    <x-input-label for="bpjs_kesehatan" value="BPJS Kesehatan" />
                    <x-text-input id="bpjs_kesehatan" name="bpjs_kesehatan" type="text" class="mt-1 block w-full"
                        :value="old('bpjs_kesehatan', $employee?->identity?->bpjs_kesehatan)" />
                </div>
                <div>
                    <x-input-label for="passport_number" value="Passport Number" />
                    <x-text-input id="passport_number" name="passport_number" type="text" class="mt-1 block w-full"
                        :value="old('passport_number', $employee?->identity?->passport_number)" />
                </div>
                <div>
                    <x-input-label for="tax_status_ptkp" value="Tax Status (PTKP)" />
                    <select id="tax_status_ptkp" name="tax_status_ptkp"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select PTKP</option>
                        @foreach(['TK/0','TK/1','TK/2','TK/3','K/0','K/1','K/2','K/3','K/I/0','K/I/1','K/I/2','K/I/3'] as $ptkp)
                        <option value="{{ $ptkp }}" {{ old('tax_status_ptkp', $employee?->identity?->tax_status_ptkp) === $ptkp ? 'selected' : '' }}>{{ $ptkp }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Document uploads -->
                <div>
                    <x-input-label for="ktp_document" value="KTP Document (PDF/Image)" />
                    <input type="file" id="ktp_document" name="ktp_document" accept="image/*,.pdf"
                        class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @if($employee?->identity?->ktp_document_path)
                    <p class="text-xs text-green-500 mt-1">✓ File already uploaded</p>
                    @endif
                </div>
                <div>
                    <x-input-label for="npwp_document" value="NPWP Document (PDF/Image)" />
                    <input type="file" id="npwp_document" name="npwp_document" accept="image/*,.pdf"
                        class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @if($employee?->identity?->npwp_document_path)
                    <p class="text-xs text-green-500 mt-1">✓ File already uploaded</p>
                    @endif
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button>Save Changes</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- ════ EDIT BANK MODAL ════ -->
    <x-modal name="edit-bank" focusable>
        <form method="POST" action="{{ route('profile.bank.update') }}" class="p-6">
            @csrf @method('PUT')
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Edit Bank Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="bank_name" value="Bank Name" />
                    <select id="bank_name" name="bank_name"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Bank</option>
                        @foreach(['BCA','BRI','BNI','Mandiri','BTN','CIMB Niaga','Danamon','Permata','Maybank','BRI Syariah','BSI','Other'] as $bank)
                        <option value="{{ $bank }}" {{ old('bank_name', $employee?->bank?->bank_name) === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="bank_branch" value="Branch" />
                    <x-text-input id="bank_branch" name="bank_branch" type="text" class="mt-1 block w-full"
                        :value="old('bank_branch', $employee?->bank?->bank_branch)" />
                </div>
                <div>
                    <x-input-label for="account_number" value="Account Number" />
                    <x-text-input id="account_number" name="account_number" type="text" class="mt-1 block w-full font-mono"
                        :value="old('account_number', $employee?->bank?->account_number)" required />
                </div>
                <div>
                    <x-input-label for="account_holder_name" value="Account Holder Name" />
                    <x-text-input id="account_holder_name" name="account_holder_name" type="text" class="mt-1 block w-full uppercase"
                        :value="old('account_holder_name', $employee?->bank?->account_holder_name)" required />
                    <p class="text-xs text-gray-400 mt-1">Harus sesuai dengan nama di buku tabungan</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button>Save Changes</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- ════ ADD EMERGENCY MODAL ════ -->
    <x-modal name="add-emergency" focusable>
        <form method="POST" action="{{ route('profile.emergency.store') }}" class="p-6">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Add Emergency Contact</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="new_contact_name" value="Contact Name" />
                    <x-text-input id="new_contact_name" name="contact_name" type="text" class="mt-1 block w-full"
                        :value="old('contact_name')" required />
                </div>
                <div>
                    <x-input-label for="new_relationship" value="Relationship" />
                    <select id="new_relationship" name="relationship"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select Relationship</option>
                        @foreach(['Spouse','Parent','Sibling','Child','Friend','Other'] as $rel)
                        <option value="{{ $rel }}" {{ old('relationship') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="new_phone_number" value="Phone Number" />
                    <x-text-input id="new_phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                        :value="old('phone_number')" required />
                </div>
                <div class="md:col-span-2">
                    <x-input-label for="new_address" value="Address" />
                    <textarea id="new_address" name="address" rows="3"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button>Add Contact</x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Photos Modal -->
    <x-modal name="edit-photos" focusable>
        <form method="POST" action="{{ route('profile.data.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Edit Profile Photos</h2>
            <div class="space-y-5">
                <div>
                    <x-input-label for="profile_photo" value="Profile Photo" />
                    <p class="text-xs text-gray-400 mt-0.5 mb-2">Recommended: square, min 200×200px</p>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div>
                    <x-input-label for="background_photo" value="Cover Background" />
                    <p class="text-xs text-gray-400 mt-0.5 mb-2">Recommended: landscape, min 1200×300px</p>
                    <input type="file" id="background_photo" name="background_photo" accept="image/*"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button>Upload</x-primary-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>