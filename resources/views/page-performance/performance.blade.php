<x-app-layout :title="$title">
    <div class="js-datatable-container" data-per-page="10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Performance Appraisals</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Track employee KPIs and review cycles.</p>
            </div>
            <button data-modal-target="cycleModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                Start New Review Cycle
            </button>
        </div>

        <div class="mb-6 fade-in">
            <input type="text" class="js-search-input w-full md:w-1/2 py-2 px-4 shadow-sm text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search employee name or KPI project...">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in js-grid-body" style="animation-delay: 0.1s;">
            <!-- KPI Card -->
            <div class="bg-white dark:bg-slate-800 p-6 flex flex-col rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover-scale">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">Sales Target Q1 2026</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Budi Santoso</p>
                    </div>
                    <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs px-2 py-1 rounded font-bold">Score: 4.8 / 5.0</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-auto">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 95%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-2 text-right">Completed</p>
            </div>

            <!-- KPI Card -->
            <div class="bg-white dark:bg-slate-800 p-6 flex flex-col rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover-scale border-l-4 border-l-blue-500">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg">Platform Rewrite Project</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sarah Williams</p>
                    </div>
                    <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs px-2 py-1 rounded font-bold">In Progress</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-auto">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 65%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-2 text-right">Mid-Year Review due Next Month</p>
            </div>
        </div>

        <div class="js-pagination-controls mt-6"></div>

        <!-- Modals -->
        <div id="cycleModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Start New KPI</h3>
                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form class="js-simulated-form p-5 space-y-4" data-callback="onNewKPI">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee Name</label>
                        <input type="text" name="emp" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">KPI Goals / Target</label>
                        <input type="text" name="goal" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring" placeholder="E.g., Q2 Lead Generation">
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Create KPI</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            window.onNewKPI = function(formData) {
                const emp = formData.get('emp');
                const goal = formData.get('goal');

                const html = `
                <div class="bg-white dark:bg-slate-800 p-6 flex flex-col rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm hover-scale border-l-4 border-l-yellow-500">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">${goal}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">${emp}</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 text-xs px-2 py-1 rounded font-bold">New</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-auto">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 text-right">0% Progress</p>
                </div>
            `;
                document.querySelector('.js-datatable-container').addNewRow(html);
            };
        </script>
    </div>
</x-app-layout>