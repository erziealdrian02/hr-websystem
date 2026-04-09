<x-app-layout :title="$title">
    <div class="js-datatable-container" data-per-page="10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reimbursement Claims</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Submit and track your expense and medical claims.</p>
            </div>
            <button data-modal-target="newClaimModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Reimbursement
            </button>
        </div>

        <!-- Stats summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Reimbursed This Month</p>
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">Rp 1,500,000</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Limit</p>
                    <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">Rp 200,000</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between">
                <div class="w-full">
                    <div class="flex justify-between mb-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Medical Limit (Annual)</p>
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Rp 3M / 5M</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Table Area -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-slate-700/30">
                <h2 class="font-bold text-gray-900 dark:text-white">Recent Claims</h2>
                <input type="text" class="js-search-input py-1.5 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 outline-none" placeholder="Search ID or description...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs uppercase text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Claim ID</th>
                            <th class="px-6 py-4 font-semibold">Date Submitted</th>
                            <th class="px-6 py-4 font-semibold">Type</th>
                            <th class="px-6 py-4 font-semibold">Description</th>
                            <th class="px-6 py-4 font-semibold">Amount</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260402</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">02 Apr 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-semibold">Transport</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Taxi to Client Meeting at SCBD</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 200,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260328</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">28 Mar 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 text-xs font-semibold">Medical</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Eye checkup at RS Mata Nusantara</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 750,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260320</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">20 Mar 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-semibold">Meal</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Client dinner at Hotel Mulia</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 500,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260315</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">15 Mar 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-semibold">Office Supplies</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">USB Hub & Keyboard for WFH</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 350,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260308</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">08 Mar 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-semibold">Transport</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Grab to Airport - business trip</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 180,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260301</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">01 Mar 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 text-xs font-semibold">Medical</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Dental cleaning & checkup</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 1,200,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260220</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">20 Feb 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-semibold">Meal</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Team lunch during sprint release</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 450,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260210</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">10 Feb 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-semibold">Office Supplies</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Printer ink & A4 paper stock</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 280,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260128</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">28 Jan 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-semibold">Transport</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Parking fee - Sudirman office visit</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 50,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260115</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">15 Jan 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 text-xs font-semibold">Medical</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Flu medication & doctor visit</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 300,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20260105</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">05 Jan 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-semibold">Meal</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">New Year team outing dinner</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 800,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-20251218</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">18 Dec 2025</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-semibold">Transport</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Airport shuttle - Surabaya trip</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp 150,000</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="js-pagination-controls"></div>
        </div>

        <!-- Modals -->
        <div id="newClaimModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Submit Reimbursement</h3>
                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form class="js-simulated-form p-5 space-y-4" data-callback="onNewClaim">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Claim Type</label>
                        <select name="type" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 outline-none focus:ring dark:text-white">
                            <option>Medical</option>
                            <option>Transport</option>
                            <option>Office Supplies</option>
                            <option>Meal / Client Entertainment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <input type="text" name="desc" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 outline-none focus:ring dark:text-white" placeholder="E.g., Taxi to Airport">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount (Rp)</label>
                        <input type="number" name="amount" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 outline-none focus:ring dark:text-white" placeholder="500000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Attachment (Receipt)</label>
                        <input type="file" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-sm text-gray-500 cursor-pointer outline-none">
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300 rounded-lg font-medium transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Submit Claim</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            window.onNewClaim = function(formData) {
                const type = formData.get('type');
                const desc = formData.get('desc');
                const amount = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(formData.get('amount'));

                const html = `
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">#RM-NEW</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Just Now</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300 text-xs font-semibold">${type}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${desc}</td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">${amount}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Pending</span>
                    </td>
                </tr>
            `;
                document.querySelector('.js-datatable-container').addNewRow(html);
            };
        </script>
    </div>
</x-app-layout>