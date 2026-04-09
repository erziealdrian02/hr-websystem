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

        @if(isset($expiringCount) && $expiringCount > 0)
        <!-- Expiring Alert -->
        <div class="bg-orange-50 border-l-4 border-orange-500 dark:bg-orange-900/20 p-4 mb-6 rounded-r-lg shadow-sm fade-in">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-orange-800 dark:text-orange-300">Contracts expiring in 30 days</h3>
                    <p class="text-sm text-orange-700 dark:text-orange-400 mt-1">There are {{ $expiringCount }} employment contracts that need review before expiry.</p>
                </div>
            </div>
        </div>
        @endif

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
                            'Terminated' => [
                            'label' => 'Terminated',
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
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 {{ $contract->end_date && now()->diffInDays(\Carbon\Carbon::parse($contract->end_date), false) <= 30 && now()->diffInDays(\Carbon\Carbon::parse($contract->end_date), false) >= 0 ? 'text-orange-600 dark:text-orange-400 font-bold' : 'text-gray-400' }}">{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d M Y') : '-' }}</td>

                            @php
                            $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                            $statusLabel = 'Active';

                            if ($contract->status === 'terminated') {
                            $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                            $statusLabel = 'Terminated';
                            } elseif ($contract->status === 'active' && $contract->end_date) {
                            $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($contract->end_date), false);
                            if ($daysLeft <= 30 && $daysLeft >= 0) {
                                $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-500';
                                $statusLabel = 'Expiring Soon';
                                } elseif ($daysLeft < 0) {
                                    $statusClass='bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' ;
                                    $statusLabel='Expired' ;
                                    }
                                    }
                                    @endphp

                                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                    <!-- View Icon -->
                                    <button class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="View details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    <!-- Edit Icon -->
                                    <button data-modal-target="editContractModal-{{ $contract->id }}" class="p-1.5 text-gray-500 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg transition-colors" title="Edit contract">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    @if($contract->status !== 'terminated')
                                    <!-- Terminate Icon -->
                                    <form action="{{ route('contract.destroy', $contract->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to terminate this contract?')" class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Terminate contract">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div id="editContractModal-{{ $contract->id }}" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
                            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
                            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
                                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Contract</h3>
                                    <button data-modal-close class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>

                                <form action="{{ route('contract.update', $contract->id) }}" method="POST" class="p-5 space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Nama Pegawai</label>
                                        <div class="relative">
                                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 z-10 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            <select name="employee_id" class="tom-select w-full has-icon">
                                                @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ $contract->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract Type</label>
                                        <select name="contract_type" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                                            <option value="PKWT" {{ $contract->contract_type == 'PKWT' ? 'selected' : '' }}>PKWT (Contract)</option>
                                            <option value="PKWTT" {{ $contract->contract_type == 'PKWTT' ? 'selected' : '' }}>PKWTT (Permanent)</option>
                                            <option value="Internship" {{ $contract->contract_type == 'Internship' ? 'selected' : '' }}>Internship</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                                            <input type="date" name="start_date" required value="{{ $contract->start_date }}" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                                            <input type="date" name="end_date" value="{{ $contract->end_date }}" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                                        </div>
                                    </div>

                                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">Cancel</button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Update Contract</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

                <form action="{{ route('contract.store') }}" method="POST" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                            Nama Pegawai
                        </label>
                        <div class="relative">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 z-10 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <select name="employee_id" class="tom-select w-full has-icon">
                                <option value="">Cari Nama Pegawai</option>
                                @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contract Type</label>
                        <select name="contract_type" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                            <option value="PKWT">PKWT (Contract)</option>
                            <option value="PKWTT">PKWTT (Permanent)</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                            <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                            <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white outline-none focus:ring">
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