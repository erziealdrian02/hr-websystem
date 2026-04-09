<x-app-layout>
    <!-- Header -->
    <div class="mb-6 fade-in">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daily Attendance</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Clock in and out of your working hours directly from here.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

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

                <div class="mt-8 space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Shift: <span class="font-bold text-gray-900 dark:text-white">Regular 09:00 - 18:00</span></p>

                    <div class="flex gap-4">
                        <button onclick="handleClock('in')" id="btn-clock-in" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all hover-scale">
                            Clock In
                        </button>
                        <button onclick="handleClock('out')" id="btn-clock-out" class="flex-1 bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-gray-500 font-bold py-3 rounded-xl cursor-not-allowed transition-all" disabled>
                            Clock Out
                        </button>
                    </div>
                    <p id="location-status" class="text-xs text-green-600 dark:text-green-400 flex items-center justify-center mt-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Location: Office Network (Verified)
                    </p>
                </div>
            </div>

            <!-- Today's Record -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mt-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Today's Record</h3>
                <div class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 dark:before:via-gray-700 before:to-transparent">

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full border border-white dark:border-slate-800 bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="w-[calc(100%-3rem)] md:w-[calc(50%-1.5rem)] p-3 rounded bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 dark:text-white text-sm" id="record-in">--:--</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Clock In</div>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full border border-white dark:border-slate-800 bg-gray-100 text-gray-500 dark:bg-slate-700 dark:text-gray-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="w-[calc(100%-3rem)] md:w-[calc(50%-1.5rem)] p-3 rounded bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 dark:text-white text-sm" id="record-out">--:--</span>
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
                    <input type="month" class="px-3 py-1.5 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-gray-200 focus:ring focus:ring-blue-300 focus:outline-none" value="2026-04">
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-xs uppercase text-gray-500 dark:text-gray-400">
                                <th class="pb-3 font-semibold">Date</th>
                                <th class="pb-3 font-semibold text-center">Clock In</th>
                                <th class="pb-3 font-semibold text-center">Clock Out</th>
                                <th class="pb-3 font-semibold text-center">Working Hrs</th>
                                <th class="pb-3 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ( $attendances as $attendance )
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $attendance->attendance_date }}</p>
                                </td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">{{ $attendance->clock_in }}</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">{{ $attendance->clock_out }}</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">{{ $attendance->working_minutes }}</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ $attendance->status }}</span>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">Wed, 02 Apr 2026</p>
                                </td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">08:50</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">18:05</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">9h 15m</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">On Time</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">Tue, 01 Apr 2026</p>
                                </td>
                                <td class="py-4 text-center font-medium text-red-600 dark:text-red-400">09:15</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">18:30</td>
                                <td class="py-4 text-center font-medium text-gray-700 dark:text-gray-300">9h 15m</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Late In</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-4">
                                    <p class="font-medium text-gray-900 dark:text-white">Mon, 31 Mar 2026</p>
                                </td>
                                <td class="py-4 text-center text-gray-400 dark:text-gray-500">--:--</td>
                                <td class="py-4 text-center text-gray-400 dark:text-gray-500">--:--</td>
                                <td class="py-4 text-center text-gray-400 dark:text-gray-500">-</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">Annual Leave</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert (Hidden by default) -->
    <div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-xl transition-all duration-300 z-50 flex items-center gap-3">
        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <h4 class="font-bold text-sm" id="toast-title">Clock In Successful</h4>
            <p class="text-xs text-gray-300" id="toast-msg">Time recorded at 09:00 AM</p>
        </div>
    </div>

    <script>
        // Interactive Clock In/Out Simulation
        let hasClockedIn = false;

        function handleClock(action) {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            const btnIn = document.getElementById('btn-clock-in');
            const btnOut = document.getElementById('btn-clock-out');
            const recordIn = document.getElementById('record-in');
            const recordOut = document.getElementById('record-out');

            const toast = document.getElementById('toast');
            const toastTitle = document.getElementById('toast-title');
            const toastMsg = document.getElementById('toast-msg');

            if (action === 'in' && !hasClockedIn) {
                // Update buttons state
                hasClockedIn = true;
                btnIn.disabled = true;
                btnIn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                btnIn.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-blue-500', 'text-white', 'shadow-lg');

                btnOut.disabled = false;
                btnOut.classList.remove('bg-gray-100', 'text-gray-400', 'dark:bg-slate-700', 'dark:text-gray-500', 'cursor-not-allowed');
                btnOut.classList.add('bg-gradient-to-r', 'from-orange-500', 'to-red-500', 'text-white', 'shadow-lg', 'shadow-red-500/30');

                recordIn.innerText = timeStr;
                recordIn.classList.add('text-blue-600', 'dark:text-blue-400');

                toastTitle.innerText = "Clock In Successful";
                toastMsg.innerText = "Enjoy your work today!";
            } else if (action === 'out' && hasClockedIn) {
                btnOut.disabled = true;
                btnOut.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                btnOut.classList.remove('bg-gradient-to-r', 'from-orange-500', 'to-red-500', 'text-white', 'shadow-lg', 'shadow-red-500/30');

                recordOut.innerText = timeStr;
                recordOut.classList.add('text-red-500');

                toastTitle.innerText = "Clock Out Successful";
                toastMsg.innerText = "Thanks for your hard work!";
            }

            // Show Toast
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }
    </script>
</x-app-layout>