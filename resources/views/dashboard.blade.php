<x-app-layout :title="$title">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Welcome back, Name! 👋</h1>
            <p class="text-gray-500 dark:text-gray-400">Here is what's happening in your organization today.</p>
        </div>
        <div class="flex bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 shadow-sm realtime-clock">
            <div class="flex flex-col text-right">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 time-display">--:--:--</span>
                <span class="text-xs text-gray-500 dark:text-gray-400 date-display">Loading date...</span>
            </div>
        </div>
    </div>

    <!-- Stats Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
        <!-- Total Employees -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover-scale group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Employees</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">248</h3>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-500 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    +12%
                </span>
                <span class="text-gray-400 ml-2">from last month</span>
            </div>
        </div>

        <!-- Attendance Today -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover-scale group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Present Today</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">215</h3>
                </div>
                <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 dark:bg-gray-700">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: 86%"></div>
                </div>
            </div>
            <span class="text-xs text-gray-400 mt-1 inline-block">86% Attendance Rate</span>
        </div>

        <!-- On Leave -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover-scale group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">On Leave</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">12</h3>
                </div>
                <div class="p-3 bg-orange-50 dark:bg-orange-900/30 rounded-lg text-orange-600 dark:text-orange-400 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-orange-500 font-medium">3 Pending Approvals</span>
            </div>
        </div>

        <!-- Open Positions -->
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm hover-scale group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Open Jobs</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">8</h3>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-400">42 Applicants evaluating</span>
            </div>
        </div>
    </div>

    <!-- Charts & Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in" style="animation-delay: 0.2s;">
        <!-- Monthly Attendance Trend -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 dark:text-white">Attendance Overview</h3>
                <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-slate-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity / Approvals -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-5 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 dark:text-white">Pending Actions</h3>
                <a href="#" class="text-sm text-blue-600 hover:underline dark:text-blue-400">View All</a>
            </div>

            <div class="flex-1 overflow-y-auto pr-2 space-y-4">
                <!-- Action Item -->
                <div class="flex gap-3 p-3 rounded-lg border border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="w-10 h-10 rounded-full" alt="avatar">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">John Doe</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Requested Annual Leave (3 days)</p>
                        <div class="mt-2 flex gap-2">
                            <button class="px-2 py-1 bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 text-xs rounded font-medium hover:bg-green-100 dark:hover:bg-green-900/50 transition-colors">Approve</button>
                            <button class="px-2 py-1 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 text-xs rounded font-medium hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">Reject</button>
                        </div>
                    </div>
                </div>

                <!-- Action Item -->
                <div class="flex gap-3 p-3 rounded-lg border border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=random" class="w-10 h-10 rounded-full" alt="avatar">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Sarah Smith</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Reimbursement (Rp500,000)</p>
                        <div class="mt-2 flex gap-2">
                            <button class="px-2 py-1 bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 text-xs rounded font-medium hover:bg-green-100 dark:hover:bg-green-900/50 transition-colors">Approve</button>
                            <button class="px-2 py-1 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 text-xs rounded font-medium hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">Reject</button>
                        </div>
                    </div>
                </div>

                <!-- Action Item -->
                <div class="flex gap-3 p-3 rounded-lg border border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold shrink-0">HR</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">Payroll Generation</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Due in 2 days</p>
                        <div class="mt-2 flex gap-2">
                            <a href="#" class="px-2 py-1 bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 text-xs rounded font-medium hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">Review Payroll</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            // Check current theme for chart styling
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#9ca3af' : '#6b7280';
            const gridColor = isDark ? '#374151' : '#f3f4f6';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                            label: 'Present',
                            data: [230, 225, 235, 215, 240, 45, 10],
                            backgroundColor: '#3b82f6',
                            borderRadius: 4
                        },
                        {
                            label: 'Absent/Leave',
                            data: [18, 23, 13, 33, 8, 203, 238],
                            backgroundColor: isDark ? '#475569' : '#cbd5e1',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: textColor
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor
                            }
                        },
                        y: {
                            stacked: true,
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>