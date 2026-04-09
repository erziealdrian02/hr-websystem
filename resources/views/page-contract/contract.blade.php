<x-app-layout>
    <div class="js-datatable-container" data-per-page="10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Contract Management</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage employee working contracts and monitor expiration dates (PKWT/PKWTT).</p>
            </div>
            <button data-modal-target="contractModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Contract
            </button>
        </div>

        <!-- Expiring Alert -->
        <div class="bg-orange-50 border-l-4 border-orange-500 dark:bg-orange-900/20 p-4 mb-6 rounded-r-lg shadow-sm fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-orange-800 dark:text-orange-300">Contracts expiring in 30 days</h3>
                    <p class="text-sm text-orange-700 dark:text-orange-400 mt-1">There are 2 employment contracts that need review before expiry.</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <input type="text" class="js-search-input w-full md:w-1/3 py-2 px-4 shadow-sm text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search employee or type...">
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.1s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Employee</th>
                            <th class="px-6 py-4 font-semibold">Contract Type</th>
                            <th class="px-6 py-4 font-semibold">Start Date</th>
                            <th class="px-6 py-4 font-semibold">End Date</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors bg-orange-50/50 dark:bg-orange-900/10">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">John Doe</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-semibold">PKWT (Contract)</span></td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">01 May 2025</td>
                            <td class="px-6 py-4 text-orange-600 dark:text-orange-400 font-bold">30 Apr 2026</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-500">Expiring Soon</span></td>
                            <td class="px-6 py-4 text-right"><button class="text-blue-600 hover:underline text-sm font-medium">Review</button></td>
                        </tr>
                        @foreach ( $contracts as $contract )
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $contract->employee->full_name ?? 'N/A'}}</td>
                            @php
                            $typeMap = [
                            'PKWTT' => [
                            'label' => 'PKWTT (Permanent)',
                            'class' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                            ],
                            'PKWT' => [
                            'label' => 'PKWT (Contract)',
                            'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
                            ],
                            'Internship' => [
                            'label' => 'Internship',
                            'class' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400'
                            ],
                            'Expired' => [
                            'label' => 'Expired',
                            'class' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                            ],
                            ];

                            $type = $typeMap[$contract->contract_type] ?? [
                            'label' => $contract->contract_type,
                            'class' => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400'
                            ];
                            @endphp

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $type['class'] }}">
                                    {{ $type['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $contract->start_date }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $contract->end_date }}</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span></td>
                            <td class="px-6 py-4 text-right"><button class="text-blue-600 hover:underline text-sm font-medium">View</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="js-pagination-controls"></div>
        </div>

        <!-- Modals -->
        <div id="contractModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Draft New Contract</h3>
                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form class="js-simulated-form p-5 space-y-4" data-callback="onNewContract">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                            Nama Pegawai
                        </label>
                        <div class="relative">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 z-10 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <select id="client-location" name="employee_id" class="tom-select w-full has-icon" onchange="triggerGenerateCode()">
                                <option value="">Cari Nama Pegawai</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $employee->employee_id ?? '') == $employee->employee_id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract Type</label>
                        <select name="type" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                            <option>PKWT (Contract)</option>
                            <option>PKWTT (Permanent)</option>
                            <option>Internship</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                            <input type="date" name="start" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                            <input type="date" name="end" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Save Contract</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            window.onNewContract = function(formData) {
                const emp = formData.get('emp');
                const type = formData.get('type');
                const start = formData.get('start');
                const end = formData.get('end') || '-';

                const html = `
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">${emp}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-semibold">${type}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${start}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">${end}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-blue-600 hover:underline text-sm font-medium">View</button>
                    </td>
                </tr>
            `;
                document.querySelector('.js-datatable-container').addNewRow(html);
            };

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.tom-select').forEach(el => {
                    let ts = new TomSelect(el, {
                        create: false,
                        dropdownParent: 'body',
                        sortField: {
                            field: 'text',
                            direction: 'asc'
                        }
                    });
                });
            });
        </script>
    </div>
</x-app-layout>