<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">All Employee Leave Requests</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Review, approve, or reject employee time off applications.</p>
        </div>
    </div>

    <!-- Admin Status Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-yellow-50 dark:bg-yellow-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Pending Requests</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-yellow-600 dark:text-yellow-400">12</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Needs Approval</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-blue-50 dark:bg-blue-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Approved This Month</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">34</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Requests</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-red-50 dark:bg-red-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Rejected This Month</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-red-600 dark:text-red-400">2</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Requests</span>
            </div>
        </div>
    </div>

    <!-- Master Table Area -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-gray-900 dark:text-white">Central Leave Master Data</h2>
            <div class="relative max-w-sm w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg></span>
                <input type="text" class="js-search-input w-full py-1.5 pl-9 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search employee, reason or type...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Employee</th>
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
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Alex+Carter&background=random" class="w-8 h-8 rounded-full">
                            Alex Carter
                        </td>
                        <td class="px-6 py-4">Annual Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">12 May - 14 May 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">3 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Family vacation out of town</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span></td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-green-600 hover:text-green-700 font-medium mr-3">Approve</button>
                            <button class="text-red-500 hover:text-red-700 font-medium">Reject</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=random" class="w-8 h-8 rounded-full">
                            Sarah Smith
                        </td>
                        <td class="px-6 py-4">Sick Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">20 Feb - 21 Feb 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">2 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Severe Flu (MC attached)</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 hover:text-blue-800 font-medium">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="w-8 h-8 rounded-full">
                            John Doe
                        </td>
                        <td class="px-6 py-4">Unpaid Leave</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">01 Jun - 03 Jun 2026</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">3 Days</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">Visa processing</td>
                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span></td>
                        <td class="px-6 py-4 text-right"><button class="text-blue-600 hover:text-blue-800 font-medium">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="js-pagination-controls"></div>
    </div>
</x-app-layout>