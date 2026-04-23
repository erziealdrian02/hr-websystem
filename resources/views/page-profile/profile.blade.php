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

                                {{-- Modal Header --}}
                                <div class="-mx-6 -mt-6 px-6 py-4 mb-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Emergency Contact</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update this emergency contact's details</p>
                                    </div>
                                </div>

                                {{-- Contact Name & Relationship --}}
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="space-y-1.5">
                                        <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Contact Name</label>
                                        <div class="relative group">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="contact_name_{{ $emergency->id }}" name="contact_name" required
                                                value="{{ old('contact_name', $emergency->contact_name) }}"
                                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                        </div>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Relationship</label>
                                        <div class="relative group">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <select id="relationship_{{ $emergency->id }}" name="relationship"
                                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                                                @foreach(['Spouse','Parent','Sibling','Child','Friend','Other'] as $rel)
                                                <option value="{{ $rel }}" {{ old('relationship', $emergency->relationship) === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Phone Number --}}
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Phone Number</label>
                                    <div class="relative group">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="phone_number_{{ $emergency->id }}" name="phone_number" required
                                            value="{{ old('phone_number', $emergency->phone_number) }}"
                                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="space-y-1.5">
                                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Address</label>
                                    <textarea id="address_{{ $emergency->id }}" name="address" rows="2"
                                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none">{{ old('address', $emergency->address) }}</textarea>
                                </div>

                                {{-- Footer --}}
                                <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 !mt-8">
                                    <button type="button" x-on:click="$dispatch('close')"
                                        class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="relative group px-6 py-2.5 text-sm font-semibold text-white overflow-hidden rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 hover:-translate-y-0.5">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition-all"></div>
                                        <span class="relative">Save Changes</span>
                                    </button>
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

            <!-- Modal Header -->
            <div class="-mx-6 -mt-6 px-6 py-4 mb-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Emergency Contact</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update information</p>
                </div>
            </div>

            {{-- Phone & Email --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Phone Number</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="text" id="phone_number" name="phone_number"
                            value="{{ old('phone_number', $employee?->phone_number) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Personal Email</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" id="personal_email" name="personal_email"
                            value="{{ old('personal_email', $employee?->personal_email) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- Gender & Religion --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Gender</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <select id="gender" name="gender" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select Gender</option>
                            @foreach(['Male','Female'] as $g)
                            <option value="{{ $g }}" {{ old('gender', $employee?->gender) === $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Religion</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <select id="religion" name="religion" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select Religion</option>
                            @foreach(['Islam','Protestant','Catholic','Hindu','Buddhist','Confucian','Other'] as $r)
                            <option value="{{ $r }}" {{ old('religion', $employee?->religion) === $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Place of Birth & Date of Birth --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Place of Birth</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" id="place_of_birth" name="place_of_birth"
                            value="{{ old('place_of_birth', $employee?->place_of_birth) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Date of Birth</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                            value="{{ old('date_of_birth', $employee?->date_of_birth) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- Marital Status & Blood Type --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Marital Status</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <select id="marital_status" name="marital_status" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select Status</option>
                            @foreach(['Single','Married','Divorced','Widowed'] as $s)
                            <option value="{{ $s }}" {{ old('marital_status', $employee?->marital_status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Blood Type</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <select id="blood_type" name="blood_type" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select Type</option>
                            @foreach(['A','B','AB','O'] as $b)
                            <option value="{{ $b }}" {{ old('blood_type', $employee?->blood_type) === $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Domicile Address --}}
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Domicile Address</label>
                <textarea id="domicile_address" name="domicile_address" rows="2"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none">{{ old('domicile_address', $employee?->domicile_address) }}</textarea>
            </div>

            {{-- KTP Address --}}
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">KTP Address</label>
                <textarea id="ktp_address" name="ktp_address" rows="2"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none">{{ old('ktp_address', $employee?->ktp_address) }}</textarea>
            </div>

            {{-- Footer --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 !mt-8">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                    Cancel
                </button>
                <button type="submit"
                    class="relative group px-6 py-2.5 text-sm font-semibold text-white overflow-hidden rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 hover:-translate-y-0.5">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition-all"></div>
                    <span class="relative">Save Changes</span>
                </button>
            </div>

        </form>
    </x-modal>

    {{-- ════ EDIT IDENTITY MODAL ════ --}}
    <x-modal name="edit-identity" focusable>
        <form method="POST" action="{{ route('profile.identity.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')

            {{-- Modal Header --}}
            <div class="-mx-6 -mt-6 px-6 py-4 mb-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Official Identification</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update your identity documents below</p>
                </div>
            </div>

            {{-- NIK & NPWP --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">NIK (KTP)</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                            </svg>
                        </div>
                        <input type="text" id="nik_ktp" name="nik_ktp"
                            value="{{ old('nik_ktp', $employee?->identity?->nik_ktp) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">NPWP</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                            </svg>
                        </div>
                        <input type="text" id="npwp" name="npwp"
                            value="{{ old('npwp', $employee?->identity?->npwp) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- BPJS Ketenagakerjaan & BPJS Kesehatan --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">BPJS Ketenagakerjaan</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <input type="text" id="bpjs_ketenagakerjaan" name="bpjs_ketenagakerjaan"
                            value="{{ old('bpjs_ketenagakerjaan', $employee?->identity?->bpjs_ketenagakerjaan) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">BPJS Kesehatan</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <input type="text" id="bpjs_kesehatan" name="bpjs_kesehatan"
                            value="{{ old('bpjs_kesehatan', $employee?->identity?->bpjs_kesehatan) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- Passport & Tax Status --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Passport Number</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <input type="text" id="passport_number" name="passport_number"
                            value="{{ old('passport_number', $employee?->identity?->passport_number) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Tax Status (PTKP)</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <select id="tax_status_ptkp" name="tax_status_ptkp"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select PTKP</option>
                            @foreach(['TK/0','TK/1','TK/2','TK/3','K/0','K/1','K/2','K/3','K/I/0','K/I/1','K/I/2','K/I/3'] as $ptkp)
                            <option value="{{ $ptkp }}" {{ old('tax_status_ptkp', $employee?->identity?->tax_status_ptkp) === $ptkp ? 'selected' : '' }}>{{ $ptkp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Document Uploads --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">KTP Document</label>
                    <div class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl transition-all">
                        <input type="file" id="ktp_document" name="ktp_document" accept="image/*,.pdf"
                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                    </div>
                    @if($employee?->identity?->ktp_document_path)
                    <p class="text-xs text-green-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        File already uploaded
                    </p>
                    @endif
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">NPWP Document</label>
                    <div class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl transition-all">
                        <input type="file" id="npwp_document" name="npwp_document" accept="image/*,.pdf"
                            class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                    </div>
                    @if($employee?->identity?->npwp_document_path)
                    <p class="text-xs text-green-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        File already uploaded
                    </p>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 !mt-8">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                    Cancel
                </button>
                <button type="submit"
                    class="relative group px-6 py-2.5 text-sm font-semibold text-white overflow-hidden rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 hover:-translate-y-0.5">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition-all"></div>
                    <span class="relative">Save Changes</span>
                </button>
            </div>
        </form>
    </x-modal>


    {{-- ════ EDIT BANK MODAL ════ --}}
    <x-modal name="edit-bank" focusable>
        <form method="POST" action="{{ route('profile.bank.update') }}" class="p-6">
            @csrf @method('PUT')

            {{-- Modal Header --}}
            <div class="-mx-6 -mt-6 px-6 py-4 mb-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Bank Details</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update your bank account information</p>
                </div>
            </div>

            {{-- Bank Name & Branch --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Bank Name</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18" />
                            </svg>
                        </div>
                        <select id="bank_name" name="bank_name"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select Bank</option>
                            @foreach(['BCA','BRI','BNI','Mandiri','BTN','CIMB Niaga','Danamon','Permata','Maybank','BRI Syariah','BSI','Other'] as $bank)
                            <option value="{{ $bank }}" {{ old('bank_name', $employee?->bank?->bank_name) === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Branch</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" id="bank_branch" name="bank_branch"
                            value="{{ old('bank_branch', $employee?->bank?->bank_branch) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- Account Number & Holder Name --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Account Number</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <input type="text" id="account_number" name="account_number" required
                            value="{{ old('account_number', $employee?->bank?->account_number) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white font-mono placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Account Holder Name</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" id="account_holder_name" name="account_holder_name" required
                            value="{{ old('account_holder_name', $employee?->bank?->account_holder_name) }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white uppercase placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Harus sesuai dengan nama di buku tabungan</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 !mt-8">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                    Cancel
                </button>
                <button type="submit"
                    class="relative group px-6 py-2.5 text-sm font-semibold text-white overflow-hidden rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 hover:-translate-y-0.5">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition-all"></div>
                    <span class="relative">Save Changes</span>
                </button>
            </div>
        </form>
    </x-modal>


    {{-- ════ ADD EMERGENCY MODAL ════ --}}
    <x-modal name="add-emergency" focusable>
        <form method="POST" action="{{ route('profile.emergency.store') }}" class="p-6">
            @csrf

            {{-- Modal Header --}}
            <div class="-mx-6 -mt-6 px-6 py-4 mb-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add Emergency Contact</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Add a new emergency contact person</p>
                </div>
            </div>

            {{-- Contact Name & Relationship --}}
            <div class="grid grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Contact Name</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" id="new_contact_name" name="contact_name" required
                            value="{{ old('contact_name') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Relationship</label>
                    <div class="relative group">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <select id="new_relationship" name="relationship"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none">
                            <option value="">Select Relationship</option>
                            @foreach(['Spouse','Parent','Sibling','Child','Friend','Other'] as $rel)
                            <option value="{{ $rel }}" {{ old('relationship') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Phone Number --}}
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Phone Number</label>
                <div class="relative group">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10 text-gray-400 transition-colors group-focus-within:text-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <input type="text" id="new_phone_number" name="phone_number" required
                        value="{{ old('phone_number') }}"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            {{-- Address --}}
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Address</label>
                <textarea id="new_address" name="address" rows="2"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none">{{ old('address') }}</textarea>
            </div>

            {{-- Footer --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 !mt-8">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                    Cancel
                </button>
                <button type="submit"
                    class="relative group px-6 py-2.5 text-sm font-semibold text-white overflow-hidden rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 hover:-translate-y-0.5">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition-all"></div>
                    <span class="relative">Add Contact</span>
                </button>
            </div>
        </form>
    </x-modal>


    {{-- ════ EDIT PHOTOS MODAL ════ --}}
    <x-modal name="edit-photos" focusable>
        <form method="POST" action="{{ route('profile.data.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            {{-- Modal Header --}}
            <div class="-mx-6 -mt-6 px-6 py-4 mb-2 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Profile Photos</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Upload your profile and cover photos</p>
                </div>
            </div>

            {{-- Profile Photo --}}
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Profile Photo</label>
                <p class="text-xs text-gray-400 dark:text-gray-500">Recommended: square, min 200×200px</p>
                <div class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl transition-all">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                </div>
            </div>

            {{-- Background Photo --}}
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Cover Background</label>
                <p class="text-xs text-gray-400 dark:text-gray-500">Recommended: landscape, min 1200×300px</p>
                <div class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-gray-600 rounded-xl transition-all">
                    <input type="file" id="background_photo" name="background_photo" accept="image/*"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50">
                </div>
            </div>

            {{-- Footer --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 !mt-8">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-6 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-xl transition-all active:scale-95">
                    Cancel
                </button>
                <button type="submit"
                    class="relative group px-6 py-2.5 text-sm font-semibold text-white overflow-hidden rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 hover:-translate-y-0.5">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 group-hover:from-blue-700 group-hover:to-indigo-700 transition-all"></div>
                    <span class="relative">Upload</span>
                </button>
            </div>
        </form>
    </x-modal>

</x-app-layout>