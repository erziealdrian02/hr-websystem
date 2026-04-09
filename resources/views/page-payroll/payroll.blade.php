<x-app-layout :title="$title">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payroll & Payslips</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">View your salary details and download past payslips.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Current Payslip Preview -->
        <div class="lg:col-span-2 fade-in" style="animation-delay: 0.1s;">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <!-- Payslip Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-1">Latest Payslip</p>
                        <h2 class="text-2xl font-bold">March 2026</h2>
                    </div>
                    <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-lg font-medium transition-colors flex items-center text-sm shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download PDF
                    </button>
                </div>

                <!-- Payslip Body -->
                <div class="p-6">
                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4 mb-4">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Account Name</p>
                            <p class="font-bold text-gray-900 dark:text-white">Admin HRistopher</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Transfer Date</p>
                            <p class="font-bold text-gray-900 dark:text-white">25 Mar 2026</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Earnings -->
                        <div>
                            <h3 class="text-green-600 dark:text-green-400 font-bold mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Earnings
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Basic Salary</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 15,000,000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Transport Allowance</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 1,000,000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Meal Allowance</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 1,500,000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Overtime</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 0</span>
                                </div>
                                <div class="pt-2 border-t border-gray-100 dark:border-gray-700 flex justify-between font-bold">
                                    <span class="text-gray-800 dark:text-gray-200">Gross Pay</span>
                                    <span class="text-gray-900 dark:text-white">Rp 17,500,000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Deductions -->
                        <div>
                            <h3 class="text-red-500 dark:text-red-400 font-bold mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                                </svg>
                                Deductions
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Income Tax (PPh 21)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 750,000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">BPJS Kesehatan (1%)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 120,000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">BPJS JHT (2%)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 300,000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">BPJS JP (1%)</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Rp 95,000</span>
                                </div>
                                <div class="pt-2 border-t border-gray-100 dark:border-gray-700 flex justify-between font-bold">
                                    <span class="text-gray-800 dark:text-gray-200">Total Deductions</span>
                                    <span class="text-gray-900 dark:text-white">Rp 1,265,000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Take Home Pay -->
                    <div class="mt-8 bg-blue-50 dark:bg-slate-700/50 p-4 rounded-xl border border-blue-100 dark:border-gray-600 flex justify-between items-center">
                        <span class="text-gray-700 dark:text-gray-300 font-medium">Net Take Home Pay</span>
                        <span class="text-2xl font-black text-blue-600 dark:text-blue-400">Rp 16,235,000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Past Payslips List -->
        <div class="lg:col-span-1 fade-in" style="animation-delay: 0.2s;">
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 dark:text-white mb-4">Payslip History</h2>

                <div class="space-y-3">
                    <!-- Item -->
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors border border-gray-50 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 dark:bg-blue-900/40 text-blue-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">February 2026</p>
                                <p class="text-xs text-gray-500">Paid 25 Feb</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <!-- Item -->
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors border border-gray-50 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 dark:bg-blue-900/40 text-blue-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">January 2026</p>
                                <p class="text-xs text-gray-500">Paid 25 Jan</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <!-- Item -->
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors border border-gray-50 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 dark:bg-blue-900/40 text-blue-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">December 2025</p>
                                <p class="text-xs text-green-500 font-medium">Includes Bonus</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>