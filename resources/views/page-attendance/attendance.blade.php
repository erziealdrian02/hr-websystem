<x-app-layout>
    <!-- Header -->
    <div class="mb-6 fade-in flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daily Attendance</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Clock in and out of your working hours directly from here.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @php
        $todayLog = $attendances->where('attendance_date', date('Y-m-d'))->first();
        $hasClockedIn = $todayLog ? true : false;
        $hasClockedOut = ($todayLog && $todayLog->clock_out) ? true : false;
        @endphp

        <!-- Left Column: Clock In/Out Action -->
        <div class="lg:col-span-1 fade-in" style="animation-delay: 0.1s;">
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-md p-8 text-center relative overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-blue-500 rounded-full blur-3xl opacity-10"></div>
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-indigo-500 rounded-full blur-3xl opacity-10"></div>

                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Current Time</h2>

                <div class="relative w-48 h-48 mx-auto flex flex-col items-center justify-center realtime-clock">
                    <div class="clock-ring dark:border-blue-500/30"></div>
                    <div class="text-4xl font-black text-blue-600 dark:text-blue-400 time-display tracking-tight">--:--:--</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-1 date-display">Loading...</div>
                </div>

                <div class="mt-8 space-y-4 text-left">
                    <p class="text-sm text-center text-gray-600 dark:text-gray-400 mb-4">Shift: <span class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->employee->placement->clientLocation->work_start_time ?? '09:00' }} - {{ Auth::user()->employee->placement->clientLocation->work_end_time ?? '18:00' }}</span></p>

                    @if(!$hasClockedIn)
                    <form action="{{ route('attendance.store') }}" method="POST" id="clock-in-form" class="w-full relative space-y-3">
                        @csrf
                        <input type="hidden" name="latitude" id="in_lat">
                        <input type="hidden" name="longitude" id="in_lng">
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Attendance Type</label>
                            <select name="attendance_type" id="attendance_type" onchange="toggleNoteField()" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring focus:ring-blue-300 focus:outline-none">
                                <option value="office">Work from Office (WFO)</option>
                                <option value="wfh">Work from Home (WFH)</option>
                                <option value="leave">Sick / Leave</option>
                            </select>
                        </div>

                        <div id="note_field" class="hidden">
                            <label class="block text-xs font-bold text-gray-500 mb-1">Notes (Reason)</label>
                            <input type="text" name="notes" placeholder="E.g. Sakit Demam, WFH Approval..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:ring focus:ring-blue-300 focus:outline-none">
                        </div>

                        <button type="button" onclick="submitAttendance('in')" id="btn-clock-in" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all hover-scale mt-2">
                            Clock In
                        </button>
                    </form>
                    @elseif(!$hasClockedOut)
                    <div class="flex gap-4 items-center">
                        <button class="flex-1 bg-gray-100 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">Clocked In</button>
                        <form action="{{ route('attendance.update', $todayLog->id) }}" method="POST" id="clock-out-form" class="flex-1 relative">
                            @csrf
                            @method('PUT')
                            <button type="button" onclick="submitAttendance('out')" id="btn-clock-out" class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-red-500/30 transition-all hover-scale">
                                Clock Out
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="flex gap-4">
                        <button class="flex-1 bg-gray-100 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">Clocked In</button>
                        <button class="flex-1 bg-gray-100 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">Clocked Out</button>
                    </div>
                    @endif

                    <p id="location-status" class="text-xs text-gray-500 flex items-center justify-center mt-3">
                        <svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Determining location...
                    </p>
                </div>
            </div>

            <!-- Today's Record -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mt-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Today's Record</h3>
                <div class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 dark:before:via-gray-700 before:to-transparent">

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full border border-white dark:border-slate-800 {{ $hasClockedIn ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400' : 'bg-gray-100 text-gray-500' }} shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="w-[calc(100%-3rem)] md:w-[calc(50%-1.5rem)] p-3 rounded bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 dark:text-white text-sm" id="record-in">{{ $hasClockedIn ? \Carbon\Carbon::parse($todayLog->clock_in)->format('H:i') : '--:--' }}</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Clock In</div>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full border border-white dark:border-slate-800 {{ $hasClockedOut ? 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400' : 'bg-gray-100 text-gray-500' }} shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="w-[calc(100%-3rem)] md:w-[calc(50%-1.5rem)] p-3 rounded bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 dark:text-white text-sm" id="record-out">{{ $hasClockedOut ? \Carbon\Carbon::parse($todayLog->clock_out)->format('H:i') : '--:--' }}</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Clock Out</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Right Column: Attendance History -->
        <div class="lg:col-span-2 fade-in" style="animation-delay: 0.2s;">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Attendance Log</h2>
                    <form id="monthFilterForm" method="GET" action="{{ route('attendance.index') }}">
                        <input type="month" name="month" id="monthFilter" class="px-3 py-1.5 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-gray-200 focus:ring focus:ring-blue-300 focus:outline-none" value="{{ $month ?? date('Y-m') }}" onchange="document.getElementById('monthFilterForm').submit()">
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-xs uppercase text-gray-500 dark:text-gray-400">
                                <th class="pb-3 font-semibold">Date</th>
                                <th class="pb-3 font-semibold text-center">Clock In</th>
                                <th class="pb-3 font-semibold text-center">Clock Out</th>
                                <th class="pb-3 font-semibold text-center">Working Hrs</th>
                                <th class="pb-3 font-semibold">Status / Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ( $attendances as $attendance )
                            @php
                            $statusClass = 'bg-gray-100 text-gray-700';
                            $statusLabel = ucwords(str_replace('_', ' ', $attendance->status));
                            if($attendance->status == 'on_time') $statusClass = 'bg-green-100 text-green-700';
                            if($attendance->status == 'late_in') $statusClass = 'bg-orange-100 text-orange-700';
                            if($attendance->status == 'incomplete') $statusClass = 'bg-red-100 text-red-700';
                            if(in_array($attendance->status, ['wfh', 'leave', 'absent'])) $statusClass = 'bg-indigo-100 text-indigo-700';

                            $workingStr = '-';
                            if($attendance->working_minutes) {
                            $h = floor($attendance->working_minutes / 60);
                            $m = $attendance->working_minutes % 60;
                            $workingStr = "{$h}h {$m}m";
                            }

                            $hasCorrection = $attendance->corrections->isNotEmpty();
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-4 whitespace-nowrap">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('D, d M Y') }}</p>
                                    @if($attendance->status == 'leave' || $attendance->status == 'wfh')
                                    <p class="text-[10px] text-gray-500 italic mt-0.5 max-w-[120px] truncate" title="{{ $attendance->location_note }}">Note: {{ $attendance->location_note }}</p>
                                    @endif
                                </td>
                                <td class="py-4 text-center font-medium {{$attendance->status == 'late_in' ? 'text-orange-600' : 'text-gray-700 dark:text-gray-300'}}">{{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '--:--' }}</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">{{ $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '--:--' }}</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">{{ $workingStr }}</td>
                                <td class="py-4 flex gap-2 items-center">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClass }} whitespace-nowrap">{{ $statusLabel }}</span>
                                    @if(in_array($attendance->status, ['incomplete', 'late_in']) && !$hasCorrection)
                                    <button onclick="openCorrectionModal('{{ $attendance->id }}')" class="p-1 px-2 text-[10px] uppercase bg-red-50 text-red-600 hover:bg-red-100 font-bold rounded shadow-sm border border-red-200 whitespace-nowrap">Correction</button>
                                    @elseif($hasCorrection)
                                    <span class="p-1 px-2 text-[10px] uppercase bg-blue-50 text-blue-600 font-bold rounded shadow-sm border border-blue-200 whitespace-nowrap">Req Sent</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">No attendance records found for this month.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Correction Modal -->
    <div id="correctionModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-md opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-700/30">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Attendance Correction</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Submit request for forgotten check out/in</p>
                </div>
                <button data-modal-close class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('attendance.correction') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="attendance_id" id="correction_attendance_id">

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Corrected In</label>
                        <input type="time" name="corrected_clock_in" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase">Corrected Out</label>
                        <input type="time" name="corrected_clock_out" required class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Reason</label>
                    <textarea name="reason" rows="2" required placeholder="Forgot to punch out due to..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm"></textarea>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase">Proof File (PDF)</label>
                    <input type="file" name="proof_file" accept=".pdf" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-blue-50 file:text-blue-700">
                </div>

                <!-- Footer -->
                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-6">
                    <button type="button" data-modal-close class="px-5 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all">Cancel</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all shadow-md shadow-blue-500/20">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Geolocation setup
        let currentLat = null;
        let currentLng = null;
        const statusEl = document.getElementById('location-status');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    currentLat = position.coords.latitude;
                    currentLng = position.coords.longitude;

                    statusEl.innerHTML = '<svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> <span class="text-green-600">Location GPS Verified</span>';

                    const inLatMap = document.getElementById('in_lat');
                    const inLngMap = document.getElementById('in_lng');
                    if (inLatMap) {
                        inLatMap.value = currentLat;
                        inLngMap.value = currentLng;
                    }
                },
                function(error) {
                    statusEl.innerHTML = '<svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> <span class="text-red-500">Location Access Denied! Please allow GPS.</span>';
                }, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        } else {
            statusEl.innerText = "Geolocation is not supported by your browser.";
            statusEl.classList.add('text-red-500');
        }

        function toggleNoteField() {
            const type = document.getElementById('attendance_type').value;
            const noteField = document.getElementById('note_field');
            if (type === 'wfh' || type === 'leave') {
                noteField.classList.remove('hidden');
            } else {
                noteField.classList.add('hidden');
            }
        }

        function submitAttendance(action) {
            if (action === 'in') {
                if (!currentLat || !currentLng) {
                    alert("We are still getting your location. Please ensure you allowed Geolocation tracking in your browser and try again.");
                    return;
                }
                const btn = document.getElementById('btn-clock-in');
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.2"></circle><path d="M12 2A10 10 0 0122 12" stroke-opacity="1"></path></svg> Validating Location...';
                document.getElementById('clock-in-form').submit();
            } else if (action === 'out') {
                const btn = document.getElementById('btn-clock-out');
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.2"></circle><path d="M12 2A10 10 0 0122 12" stroke-opacity="1"></path></svg> Submitting...';
                document.getElementById('clock-out-form').submit();
            }
        }

        function openCorrectionModal(id) {
            document.getElementById('correction_attendance_id').value = id;
            const modal = document.getElementById('correctionModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.modal-overlay').classList.remove('opacity-0');
                modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
            }, 10);
        }
    </script>
</x-app-layout>