<x-app-layout :title="$title">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Master Attendance Log</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Monitor company-wide employee presence, punctuality, and working hours.</p>
        </div>
    </div>

    <!-- Admin Status Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-green-50 dark:bg-green-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Total Present</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-green-600 dark:text-green-400">{{ $totalPresent }}</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Employees</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-yellow-50 dark:bg-yellow-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Late Today</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-yellow-600 dark:text-yellow-400">{{ $lateToday }}</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Employees</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-red-50 dark:bg-red-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Absent / Leave</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-red-600 dark:text-red-400">{{ $absent + $onLeave }}</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Employees</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-blue-50 dark:bg-blue-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Remote Workers</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">{{ $remoteWorkers }}</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Employees</span>
            </div>
        </div>
    </div>

    <!-- Master Table Area -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <h2 class="font-bold text-gray-900 dark:text-white">Daily Roster</h2>
                <input type="date" class="px-3 py-1.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
            </div>
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg></span>
                <input type="text" class="js-search-input w-full py-1.5 pl-9 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search employee name or ID...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Employee</th>
                        <th class="px-6 py-4 font-semibold">Clock In</th>
                        <th class="px-6 py-4 font-semibold">Clock Out</th>
                        <th class="px-6 py-4 font-semibold">Work Hours</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700" id="attendanceTableBody">
                    @forelse($attendances as $attendance)
                        @php
                            $statusClass = match($attendance->status) {
                                'present' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'late' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500',
                                'absent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                'wfh' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                            };
                            $employeeName = $attendance->employee ? $attendance->employee->first_name . ' ' . $attendance->employee->last_name : 'Unknown';
                            $employeeNumber = $attendance->employee ? $attendance->employee->employee_number : 'N/A';
                            
                            $hours = floor(($attendance->working_minutes ?? 0) / 60);
                            $minutes = ($attendance->working_minutes ?? 0) % 60;
                            $durationText = $hours > 0 ? "{$hours}h " : "";
                            $durationText .= $minutes > 0 ? "{$minutes}m" : "";
                            if(!$attendance->clock_out) $durationText = "In Progress";
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($employeeName) }}&background=random" class="w-8 h-8 rounded-full">
                                <div>
                                    {{ $employeeName }}
                                    <div class="text-xs text-gray-500 font-normal">{{ $employeeNumber }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">
                                {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '--:--' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '--:--' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $durationText }}</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ ucfirst($attendance->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm">No attendance records today.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="js-pagination-controls"></div>
    </div>

    <!-- Attendance Corrections Area -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in mt-8" style="animation-delay: 0.3s;">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-gray-900 dark:text-white">Pending Attendance Corrections</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Employee</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Proposed In</th>
                        <th class="px-6 py-4 font-semibold">Proposed Out</th>
                        <th class="px-6 py-4 font-semibold">Reason</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($pendingCorrections as $correction)
                        @php
                            $employee = $correction->attendance->employee;
                            $employeeName = $employee ? $employee->first_name . ' ' . $employee->last_name : 'Unknown';
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors" data-correction-id="{{ $correction->id }}">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($employeeName) }}&background=random" class="w-8 h-8 rounded-full">
                                {{ $employeeName }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($correction->attendance->attendance_date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium">
                                {{ $correction->corrected_clock_in ? \Carbon\Carbon::parse($correction->corrected_clock_in)->format('H:i') : '--:--' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 font-medium">
                                {{ $correction->corrected_clock_out ? \Carbon\Carbon::parse($correction->corrected_clock_out)->format('H:i') : '--:--' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs" title="{{ $correction->reason }}">{{ $correction->reason }}</td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="evaluateCorrection('{{ $correction->id }}', 'approve')" class="text-green-600 hover:text-green-700 font-medium mr-3 transition-colors">Approve</button>
                                <button onclick="evaluateCorrection('{{ $correction->id }}', 'reject')" class="text-red-500 hover:text-red-700 font-medium transition-colors">Reject</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <p class="text-sm">No pending corrections! Awesome!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- CSRF Token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        async function evaluateCorrection(id, action) {
            if (!confirm(`Are you sure you want to ${action} this attendance correction?`)) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/admin/attendance-correction/${id}/${action}`;

            try {
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    if (window.showToast) {
                        window.showToast('Success', data.message, false);
                    } else {
                        alert(data.message);
                    }

                    // Reload page after a short delay
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (window.showToast) {
                        window.showToast('Error', data.message, true);
                    } else {
                        alert(data.message);
                    }
                }
            } catch (err) {
                console.error(err);
                if (window.showToast) {
                    window.showToast('Error', 'Terjadi kesalahan sistem.', true);
                } else {
                    alert('Terjadi kesalahan sistem.');
                }
            }
        }
    </script>

</x-app-layout>