<x-app-layout>
    <div class="js-datatable-container" data-per-page="10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Overtime Requests</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Log and track extra working hours.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Month Filter -->
                <form id="monthFilterForm" method="GET" action="{{ route('overtime.index') }}">
                    <input type="month" name="month" id="monthFilter"
                        class="px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-gray-200 focus:ring focus:ring-blue-300 focus:outline-none"
                        value="{{ $month ?? date('Y-m') }}"
                        onchange="document.getElementById('monthFilterForm').submit()">
                </form>
                <button data-modal-target="logOvertimeModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Log Overtime
                </button>
            </div>
        </div>

        @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
            <p class="text-red-700 text-sm">{{ session('error') }}</p>
        </div>
        @endif
        @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
            <p class="text-green-700 text-sm">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Stats summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Hours (This Month)</p>
                <h3 class="text-3xl font-bold mt-1 text-gray-900 dark:text-white">{{ $stats['total_hours'] }}</h3>
            </div>
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Requests</p>
                <h3 class="text-3xl font-bold mt-1 text-yellow-600 dark:text-yellow-400">{{ $stats['pending_count'] }}</h3>
            </div>
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Approved Requests</p>
                <h3 class="text-3xl font-bold mt-1 text-green-600 dark:text-green-400">{{ $stats['approved_count'] }}</h3>
            </div>
            <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimated Pay</p>
                <h3 class="text-3xl font-bold mt-1 text-blue-600 dark:text-blue-400">Rp {{ number_format($stats['estimated_pay'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- History Table Area -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-700/30">
                <h2 class="font-bold text-gray-900 dark:text-white">History — {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</h2>
                <input type="text" class="js-search-input py-1.5 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 outline-none" placeholder="Search tasks...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left font-sm">
                    <thead class="text-xs uppercase text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold">Time Range</th>
                            <th class="px-6 py-4 font-semibold">Duration</th>
                            <th class="px-6 py-4 font-semibold">Task/Project</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($overtimes as $overtime)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ Carbon\Carbon::parse($overtime->overtime_date)->format('D, d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ substr($overtime->start_time, 0, 5) }} - {{ substr($overtime->end_time, 0, 5) }}
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">
                                {{ intdiv($overtime->duration_minutes, 60) }}h {{ $overtime->duration_minutes % 60 }}m
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 max-w-[200px] truncate" title="{{ $overtime->description }}">{{ $overtime->description }}</td>
                            <td class="px-6 py-4">
                                @if ($overtime->status === 'approved')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                                @elseif ($overtime->status === 'pending')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($overtime->status === 'pending')
                                <div class="flex items-center gap-2">
                                    <button onclick="openEditModal('{{ $overtime->id }}', '{{ $overtime->overtime_date }}', '{{ substr($overtime->start_time, 0, 5) }}', '{{ substr($overtime->end_time, 0, 5) }}', '{{ addslashes($overtime->description) }}')"
                                        class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('overtime.destroy', $overtime->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this overtime request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-gray-500">
                                    <svg class="w-12 h-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                    </svg>
                                    <p class="text-sm font-medium">No overtime records found</p>
                                    <p class="text-xs">No overtime logged for this month.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="js-pagination-controls"></div>
        </div>

        <!-- Log Overtime Modal (CREATE) -->
        <div id="logOvertimeModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Log Overtime</h3>
                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('overtime.store') }}" method="POST" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                        <input type="date" name="overtime_date" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                            <input type="time" name="start_time" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                            <input type="time" name="end_time" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Task / Project</label>
                        <input type="text" name="description" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring" placeholder="Describe the overtime work...">
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors dark:bg-slate-700 dark:text-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Overtime Modal -->
        <div id="editOvertimeModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Overtime</h3>
                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editOvertimeForm" method="POST" class="p-5 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                        <input type="date" name="overtime_date" id="edit_overtime_date" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                            <input type="time" name="start_time" id="edit_start_time" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                            <input type="time" name="end_time" id="edit_end_time" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Task / Project</label>
                        <input type="text" name="description" id="edit_description" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors dark:bg-slate-700 dark:text-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openEditModal(id, date, start, end, description) {
                const form = document.getElementById('editOvertimeForm');
                form.action = `/overtime/update/${id}`;
                document.getElementById('edit_overtime_date').value = date;
                document.getElementById('edit_start_time').value = start;
                document.getElementById('edit_end_time').value = end;
                document.getElementById('edit_description').value = description;

                const modal = document.getElementById('editOvertimeModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.querySelector('.modal-overlay').classList.remove('opacity-0');
                    modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
                }, 10);
            }
        </script>
    </div>
</x-app-layout>