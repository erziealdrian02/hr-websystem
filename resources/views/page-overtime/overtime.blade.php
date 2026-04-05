<x-app-layout>
<div class="js-datatable-container" data-per-page="10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Overtime Requests</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Log and track extra working hours.</p>
        </div>
        <button data-modal-target="logOvertimeModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Log Overtime
        </button>
    </div>

    <!-- Stats summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Hours (This Month)</p>
            <h3 class="text-3xl font-bold mt-1 text-gray-900 dark:text-white">16h 30m</h3>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Requests</p>
            <h3 class="text-3xl font-bold mt-1 text-yellow-600 dark:text-yellow-400">3</h3>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Approved Requests</p>
            <h3 class="text-3xl font-bold mt-1 text-green-600 dark:text-green-400">9</h3>
        </div>
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimated Pay</p>
            <h3 class="text-3xl font-bold mt-1 text-blue-600 dark:text-blue-400">Rp 2.4M</h3>
        </div>
    </div>

    <!-- History Table Area -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-700/30">
            <h2 class="font-bold text-gray-900 dark:text-white">History</h2>
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Wed, 02 Apr 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 22:30</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">4.5 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Deployment & Server Maint.</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Fri, 27 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 20:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">2.0 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Urgent Client Meeting</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Wed, 25 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 21:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">3.0 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Sprint Planning Preparation</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Mon, 23 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 19:30</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">1.5 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Bug Fix - Production Critical</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Sat, 21 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">09:00 - 15:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">6.0 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Weekend Release Rollout</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Thu, 19 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 20:30</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">2.5 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Database Migration Script</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Tue, 17 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 22:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">4.0 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Quarterly Report Compilation</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Mon, 16 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 19:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">1.0 Hr</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Emergency Support Call</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Fri, 13 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 21:30</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">3.5 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">API Integration Testing</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Wed, 11 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 20:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">2.0 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Security Patch Deployment</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Mon, 09 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18:00 - 20:30</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">2.5 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Code Review Backlog</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Sat, 07 Mar 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">10:00 - 14:00</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">4.0 Hrs</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Inventory System Audit</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="js-pagination-controls"></div>
    </div>

    <!-- Modals -->
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

            <form class="js-simulated-form p-5 space-y-4" data-callback="onLogOvertime">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                        <input type="time" name="start" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                        <input type="time" name="end" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Task / Project</label>
                    <input type="text" name="task" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                    <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors dark:bg-slate-700 dark:text-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.onLogOvertime = function(formData) {
            const date = formData.get('date');
            const start = formData.get('start');
            const end = formData.get('end');
            const task = formData.get('task');

            const html = `
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">${date}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${start} - ${end}</td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Pending Calc</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${task}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span>
                    </td>
                </tr>
            `;
            document.querySelector('.js-datatable-container').addNewRow(html);
        };
    </script>
</div>
</x-app-layout>