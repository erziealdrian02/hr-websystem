<x-app-layout :title="$title">

    <div x-data="{ openModals: { editInfo: false, editCover: false } }">
        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @php
            $defaultCover = 'bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-800';
            $coverClass = $employee?->background_photo ? 'h-40 md:h-56 relative bg-cover bg-center' : 'h-40 md:h-56 relative ' . $defaultCover;
            
            $avatarUrl = $employee?->profile_photo ? Storage::url($employee->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&size=200';
        @endphp

        <!-- Cover & Avatar Profile Header -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8 fade-in">
            <div class="{{ $coverClass }}" @if($employee?->background_photo) style="background-image: url('{{ Storage::url($employee->background_photo) }}');" @endif>
                <!-- Cover Edit Button -->
                <button @click="$dispatch('open-modal', 'edit-photos')" class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Edit Photos
                </button>
            </div>

            <div class="px-6 pb-6 relative flex flex-col md:flex-row md:items-end gap-6 md:-mt-12">
                <!-- Avatar -->
                <div class="relative mx-auto md:mx-0 -mt-16 md:mt-0 z-10">
                    <img src="{{ $avatarUrl }}" class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white dark:border-slate-800 object-cover shadow-md" alt="Profile">
                    <button @click="$dispatch('open-modal', 'edit-photos')" class="absolute bottom-2 right-2 bg-blue-600 text-white rounded-full p-2.5 shadow-lg hover:bg-blue-700 transition hover-scale">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Name & Title -->
                <div class="text-center md:text-left flex-1 mt-2 md:mt-0 pt-2">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $employee?->full_name ?? $user->name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">{{ $employee?->job_title ?? 'Employee' }} • {{ $employee?->division?->name ?? 'N/A' }}</p>

                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-3 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Employee ID: {{ $employee?->employee_number ?? '-' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ ucfirst($employee?->work_location ?? 'Global') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Joined {{ $employee?->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('M Y') : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs & Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-in" style="animation-delay: 0.1s;">
            <!-- Sidebar Tabs -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-2 flex flex-col gap-1">
                    <button class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 transition-colors">
                        Personal Information
                    </button>
                    <a href="{{ route('profile.edit') }}" class="w-full block text-left px-4 py-3 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        Account Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors mt-4">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Basic Information</h2>
                        <button @click="$dispatch('open-modal', 'edit-info')" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Edit Info</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->full_name ?? $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Personal Email</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->personal_email ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Phone Number</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->phone_number ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Date of Birth</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d F Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Gender</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->gender ?? '-' }}</p>
                        </div>
						<div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Religion</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->religion ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Marital Status</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->marital_status ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Blood Type</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->blood_type ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Domicile Address</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->domicile_address ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Work Details</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Department</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->division?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Direct Manager</label>
                            <div class="flex items-center mt-1">
                                @if($employee?->manager)
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->manager->full_name) }}&background=random" class="w-6 h-6 rounded-full mr-2" alt="avatar">
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee->manager->full_name }}</p>
                                @else
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">-</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Employment Type</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ ucfirst(str_replace('_', ' ', $employee?->employment_status ?? 'Unknown')) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Work Email</label>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $employee?->work_email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <x-modal name="edit-info" focusable>
            <form method="POST" action="{{ route('profile.data.update') }}" class="p-6">
                @csrf
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Edit Personal Information</h2>
                
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
                        <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $employee?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $employee?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="religion" value="Religion" />
                        <select id="religion" name="religion" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select</option>
                            @foreach(['Islam', 'Protestant', 'Catholic', 'Hindu', 'Buddhist', 'Confucian', 'Other'] as $r)
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
                        <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Status</option>
                            @foreach(['Single', 'Married', 'Divorced', 'Widowed'] as $s)
                                <option value="{{ $s }}" {{ old('marital_status', $employee?->marital_status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="blood_type" value="Blood Type" />
                        <select id="blood_type" name="blood_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Type</option>
                            @foreach(['A', 'B', 'AB', 'O'] as $b)
                                <option value="{{ $b }}" {{ old('blood_type', $employee?->blood_type) === $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="domicile_address" value="Domicile Address" />
                        <textarea id="domicile_address" name="domicile_address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('domicile_address', $employee?->domicile_address) }}</textarea>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="ktp_address" value="KTP Address" />
                        <textarea id="ktp_address" name="ktp_address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('ktp_address', $employee?->ktp_address) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button class="ml-3">
                        Save
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <x-modal name="edit-photos" focusable>
            <form method="POST" action="{{ route('profile.data.update') }}" enctype="multipart/form-data" class="p-6">
                @csrf
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Edit Profile Photos</h2>
                
                <div class="mt-4">
                    <x-input-label for="profile_photo" value="Avatar Image" />
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="mt-6">
                    <x-input-label for="background_photo" value="Cover Background Image" />
                    <input type="file" id="background_photo" name="background_photo" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button class="ml-3">
                        Upload
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>