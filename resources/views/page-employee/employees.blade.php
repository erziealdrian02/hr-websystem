<x-app-layout :title="$title">
    <div class="js-datatable-container" data-per-page="10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 fade-in gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Active Employees</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage and view all employee records across the organization.</p>
            </div>
            <div class="flex gap-2">
                <button class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
                <a href="{{ route('employees.form') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Employee
                </a>
            </div>
        </div>

        <form action="{{ route('employees.index') }}" method="GET" class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6 flex flex-col md:flex-row gap-4 fade-in" style="animation-delay: 0.1s;">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ $search ?? '' }}" class="w-full py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-slate-700 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" placeholder="Search by name, ID, or job title...">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors shadow-sm">
                Search
            </button>
            @if(request('search') || request('per_page'))
            <a href="{{ route('employees.index') }}" class="bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm text-center flex items-center justify-center">
                Clear
            </a>
            @endif
        </form>

        <!-- Employee Grid -->
        @if($employees->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 fade-in js-grid-body" style="animation-delay: 0.2s;">
            @foreach ($employees as $employee)
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
                @php
                $gradients = [
                'from-blue-500 to-indigo-600',
                'from-purple-500 to-pink-500',
                'from-green-400 to-emerald-600',
                'from-orange-400 to-red-500',
                'from-cyan-400 to-blue-500',
                ];

                $randomGradient = $gradients[array_rand($gradients)];

                $hasCover = $employee?->background_photo;

                $coverStyle = $hasCover
                ? "background-image: url('" . asset('storage/' . $employee->background_photo) . "');"
                : "";

                $coverClass = $hasCover
                ? "bg-cover bg-center"
                : "bg-gradient-to-r $randomGradient";
                @endphp
                <div class="h-24 {{ $coverClass }} relative" style="{{ $coverStyle }}">
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this employee?')" class="p-1.5 bg-white/20 hover:bg-red-600 text-white rounded-lg backdrop-blur-md transition-all border border-white/30" title="Delete Employee">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="px-6 pb-6 relative -mt-12 text-center">
                    @if($employee->profile_photo)
                    <img src="{{ asset('storage/' . $employee->profile_photo) }}" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->full_name) }}&background=random&color=fff&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                    @endif
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3 line-clamp-1">{{ $employee->full_name }}</h3>
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400 line-clamp-1">{{ $employee->job_title }}</p>
                    <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center justify-center gap-1">{{ $employee->employee_number }}</div>
                        <div class="flex items-center justify-center gap-1">{{ $employee->division->name ?? 'No Division' }}</div>
                    </div>
                    <a href="{{ route('employees.detail', $employee->id) }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination & Entry Info -->
        <div class="flex flex-col gap-4 mt-8 bg-white dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm fade-in">

            <!-- TOP BAR -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <form action="{{ route('employees.index') }}" method="GET">
                    <select
                        name="per_page"
                        onchange="this.form.submit()"
                        class="py-2 pl-3 pr-10 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-slate-700 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 min-w-[90px]">
                        <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="30" {{ ($perPage ?? 10) == 30 ? 'selected' : '' }}>30</option>
                        <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>

                <div class="flex justify-center md:justify-end">
                    {{ $employees->links() }}
                </div>

                <!-- RIGHT: DROPDOWN -->
            </div>

        </div>
        @else
        <div class="flex flex-col items-center justify-center py-12 bg-white dark:bg-slate-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 fade-in">
            <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">No employees found</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-center">We couldn't find any employees matching your search criteria.</p>
            <a href="{{ route('employees.index') }}" class="mt-4 text-blue-600 hover:underline font-medium">Clear search and view all</a>
        </div>
        @endif

        <!-- Modals -->
        <div id="addEmployeeModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-2xl mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Register New Employee</h3>
                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="max-h-[70vh] overflow-y-auto">
                    <form class="js-simulated-form p-5 space-y-5" data-callback="onCreateEmployee">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring focus:ring-blue-300 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee ID (NIK)</label>
                                <input type="text" name="empId" value="EMP-1026" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white bg-gray-50 focus:ring outline-none" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Title</label>
                                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                                <select name="dept" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                                    <option>Engineering</option>
                                    <option>Marketing</option>
                                    <option>HR</option>
                                    <option>Finance</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6 mt-4">
                            <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Register Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Form callback implementation
            window.onCreateEmployee = function(formData) {
                const employeeId = responseData?.id ?? '';
                const detailUrl = employeeId ? `/employees/${employeeId}/detail` : '#';
                const name = formData.get('name');
                const title = formData.get('title');
                const dept = formData.get('dept');
                const empId = formData.get('empId');

                const html = `
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
                    <div class="h-24 bg-gradient-to-r from-purple-500 to-pink-500 relative"></div>
                    <div class="px-6 pb-6 relative -mt-12 text-center">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">${name}</h3>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">${title}</p>
                        <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                            <div>${empId}</div>
                            <div>${dept}</div>
                        </div>
                        <a href="${detailUrl}" class="...">View Full Profile</a>
                    </div>
                </div>
            `;

                document.querySelector('.js-datatable-container').addNewRow(html);
            };
        </script>
    </div>
</x-app-layout>