<x-app-layout :title="$title">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Employee Payroll Generation</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage global monthly payroll, generate slips, and disburse salaries.</p>
        </div>
        <form method="POST" action="/admin/payroll/run">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Run Monthly Payroll
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Admin Status Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-blue-50 dark:bg-blue-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Total Monthly Net Pay</h3>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">Rp {{ number_format($totalNetPay, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-green-50 dark:bg-green-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Processed</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-green-600 dark:text-green-400">{{ $totalProcessed }}</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Employees</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-yellow-50 dark:bg-yellow-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Pending Final Review</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-extrabold text-yellow-600 dark:text-yellow-400">{{ $pendingDisbursal }}</span>
                <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">Employees</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-full bg-purple-50 dark:bg-purple-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
            <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Total BPJS Deductions</h3>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-extrabold text-purple-600 dark:text-purple-400">Rp {{ number_format($totalBpjs, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Master Table Area -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-gray-900 dark:text-white">Master Payroll Roster</h2>
            <div class="flex items-center gap-3">
                <select class="px-3 py-1.5 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300">
                    <option>April 2026</option>
                    <option>March 2026</option>
                    <option>February 2026</option>
                </select>
                <div class="relative max-w-sm w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg></span>
                    <input type="text" class="js-search-input w-full py-1.5 pl-9 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search employee...">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Employee</th>
                        <th class="px-6 py-4 font-semibold">Title/Div</th>
                        <th class="px-6 py-4 font-semibold">Base Salary</th>
                        <th class="px-6 py-4 font-semibold text-green-600">Additions (OT/Alw)</th>
                        <th class="px-6 py-4 font-semibold text-red-500">Deductions (Tax/Abs)</th>
                        <th class="px-6 py-4 font-semibold">Net Pay</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($payrolls as $payroll)
                        @php
                            $statusClass = match($payroll->status) {
                                'transferred' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500'
                            };
                            $employeeName = $payroll->employee ? $payroll->employee->first_name . ' ' . $payroll->employee->last_name : 'Unknown';
                            $titleDiv = 'N/A'; // Need to map to a real title if the relation existed
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($employeeName) }}&background=random" class="w-8 h-8 rounded-full">
                                {{ $employeeName }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Staff</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-200">Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-green-600">+ Rp {{ number_format($payroll->allowance_total + $payroll->overtime_pay + $payroll->bonus, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-red-500">- Rp {{ number_format($payroll->total_deductions, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">Rp {{ number_format($payroll->net_pay, 0, ',', '.') }}</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ ucfirst($payroll->status) }}</span></td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-blue-600 hover:text-blue-700 font-medium mr-3">Review</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm">No payroll records generated for this period.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 js-pagination-controls">
            {{ $payrolls->links() }}
        </div>
    </div>
</x-app-layout>