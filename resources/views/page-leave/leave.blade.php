<x-app-layout>
<div class="js-datatable-container" data-per-page="10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Leave Management (Cuti)</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Request time off, view your leave balance, and track approval status.</p>
        </div>
        <button data-modal-target="requestLeaveModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Request New Leave
        </button>
    </div>

    <!-- Leave Balances -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-blue-50 dark:bg-blue-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Annual Leave</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">8</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">/ 12 Days</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-4">
                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 66%"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-green-50 dark:bg-green-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Sick Leave</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-green-600 dark:text-green-400">14</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Days Left</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-4">
                <div class="bg-green-600 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-purple-50 dark:bg-purple-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Unpaid Leave</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-purple-600 dark:text-purple-400">5</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Days Available</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-4">
                <div class="bg-purple-600 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!-- History Table Area -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-gray-900 dark:text-white">Leave Request History</h2>
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg></span>
                <input type="text" class="js-search-input w-full py-1.5 pl-9 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search reason or type...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Type</th>
                        <th class="px-6 py-4 font-semibold">Date Range</th>
                        <th class="px-6 py-4 font-semibold">Duration</th>
                        <th class="px-6 py-4 font-semibold">Reason</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">12 May - 14 May 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">3 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Family vacation out of town</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-red-500 hover:text-red-700 font-medium">Cancel</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Sick Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">20 Feb - 21 Feb 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Severe Flu (MC attached)</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">10 Jan - 12 Jan 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">3 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">New Year holiday extension</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Unpaid Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">05 Dec - 06 Dec 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Personal matters - house moving</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">15 Nov - 16 Nov 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Wedding ceremony - sibling</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Sick Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">22 Oct 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">1 Day</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Dental surgery follow-up</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">01 Sep - 05 Sep 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">5 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Family vacation to Bali</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Sick Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">15 Aug 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">1 Day</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Migraine - work from home not possible</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">20 Jul - 21 Jul 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Attending seminar out of city</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Unpaid Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">01 Jun - 03 Jun 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">3 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Visa processing - overseas travel</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">10 May - 11 May 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Child graduation event</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Sick Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">02 Apr - 03 Apr 2025</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">COVID recovery quarantine</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 font-medium">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="js-pagination-controls"></div>
    </div>

    <!-- Modals -->
    <div id="requestLeaveModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Request Time Off</h3>
                <button data-modal-close class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form class="js-simulated-form p-5 space-y-4" data-callback="onRequestLeave">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Leave Type</label>
                    <select name="type" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                        <option>Annual Leave</option>
                        <option>Sick Leave</option>
                        <option>Unpaid Leave</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                        <input type="date" name="start" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                        <input type="date" name="end" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason</label>
                    <textarea name="reason" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white h-24 focus:ring outline-none" placeholder="Provide details..."></textarea>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                    <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.onRequestLeave = function(formData) {
            const type = formData.get('type');
            const start = formData.get('start');
            const end = formData.get('end');
            const reason = formData.get('reason');

            const html = `
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">${type}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${start} - ${end}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Pending Calc</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">${reason}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-red-500 hover:text-red-700 font-medium">Cancel</button>
                    </td>
                </tr>
            `;
            document.querySelector('.js-datatable-container').addNewRow(html);
        };
    </script>
</div>
</x-app-layout>