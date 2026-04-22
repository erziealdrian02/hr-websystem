<x-app-layout :title="$title">
        <div class="js-datatable-container" data-per-page="10">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Leave Management (Cuti)</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Request time off, view your leave balance, and track approval status.</p>
                </div>
                <button id="btnOpenLeaveModal" onclick="openLeaveModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Request New Leave
                </button>
            </div>

        <!-- Leave Balance Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
            <!-- Annual Leave -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-full bg-blue-50 dark:bg-blue-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
                <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Annual Leave</h3>
                <div class="flex items-end gap-2">
                    @php $annualRemaining = $leaveBalance ? ($leaveBalance->annual_leave_quota - $leaveBalance->annual_leave_used) : 0; @endphp
                    <span id="balance-annual" class="text-4xl font-extrabold text-blue-600 dark:text-blue-400">{{ $annualRemaining }}</span>
                    <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">/ <span id="quota-annual">{{ $leaveBalance ? $leaveBalance->annual_leave_quota : 0 }}</span> Days</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-4">
                    @php $annualPct = $leaveBalance && $leaveBalance->annual_leave_quota > 0 ? round(($annualRemaining / $leaveBalance->annual_leave_quota) * 100) : 0; @endphp
                    <div id="bar-annual" class="bg-blue-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $annualPct }}%"></div>
                </div>
            </div>

            <!-- Sick Leave -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-full bg-green-50 dark:bg-green-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
                <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Sick Leave</h3>
                <div class="flex items-end gap-2">
                    @php $sickRemaining = $leaveBalance ? ($leaveBalance->sick_leave_quota - $leaveBalance->sick_leave_used) : 0; @endphp
                    <span id="balance-sick" class="text-4xl font-extrabold text-green-600 dark:text-green-400">{{ $sickRemaining }}</span>
                    <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">/ <span id="quota-sick">{{ $leaveBalance ? $leaveBalance->sick_leave_quota : 0 }}</span> Days</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-4">
                    @php $sickPct = $leaveBalance && $leaveBalance->sick_leave_quota > 0 ? round(($sickRemaining / $leaveBalance->sick_leave_quota) * 100) : 0; @endphp
                    <div id="bar-sick" class="bg-green-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $sickPct }}%"></div>
                </div>
            </div>

            <!-- Unpaid Leave -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-full bg-purple-50 dark:bg-purple-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
                <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider mb-2">Unpaid Leave</h3>
                <div class="flex items-end gap-2">
                    @php $unpaidRemaining = $leaveBalance ? ($leaveBalance->unpaid_leave_quota - $leaveBalance->unpaid_leave_used) : 0; @endphp
                    <span id="balance-unpaid" class="text-4xl font-extrabold text-purple-600 dark:text-purple-400">{{ $unpaidRemaining }}</span>
                    <span class="text-gray-500 dark:text-gray-400 font-medium pb-1">/ <span id="quota-unpaid">{{ $leaveBalance ? $leaveBalance->unpaid_leave_quota : 0 }}</span> Days</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-4">
                    @php $unpaidPct = $leaveBalance && $leaveBalance->unpaid_leave_quota > 0 ? round(($unpaidRemaining / $leaveBalance->unpaid_leave_quota) * 100) : 0; @endphp
                    <div id="bar-unpaid" class="bg-purple-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $unpaidPct }}%"></div>
                </div>
            </div>
        </div>

        <!-- History Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="font-bold text-gray-900 dark:text-white">Leave Request History</h2>
                <div class="relative max-w-sm w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
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
                            <th class="px-6 py-4 font-semibold">Attachment</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody" class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                        @php
                            $typeLabels = [
                                'annual'     => 'Annual Leave',
                                'sick'       => 'Sick Leave',
                                'unpaid'     => 'Unpaid Leave',
                                'maternity'  => 'Maternity Leave',
                                'paternity'  => 'Paternity Leave',
                                'special'    => 'Special Leave',
                            ];
                        @endphp
                        @forelse ($leaves as $leave)
                        @php
                            $statusConfig = match(strtolower($leave->status)) {
                                'approved'  => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'rejected'  => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                'cancelled' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                default     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500',
                            };
                            $typeLabel = $typeLabels[$leave->leave_type] ?? ucfirst($leave->leave_type);
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors" data-leave-id="{{ $leave->id }}">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $typeLabel }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $leave->start_date }} — {{ $leave->end_date }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $leave->duration_days }} Days</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">{{ $leave->reason }}</td>
                            <td class="px-6 py-4">
                                @if ($leave->attachment)
                                    <a href="{{ Storage::url($leave->attachment) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:underline text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        View
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if (strtolower($leave->status) === 'pending')
                                    <button onclick="cancelLeave('{{ $leave->id }}')" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">Cancel</button>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm">No leave requests found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="js-pagination-controls"></div>
        </div>

        <!-- Request Leave Modal -->
        <div id="requestLeaveModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" onclick="closeLeaveModal()"></div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-slate-800 z-10">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Request Time Off</h3>
                    <button onclick="closeLeaveModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="leaveForm" enctype="multipart/form-data" class="p-5 space-y-4" onsubmit="submitLeaveRequest(event)">
                    @csrf

                    <!-- Leave Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Leave Type</label>
                        <select id="leaveType" name="leave_type" required onchange="updateBalanceHint(); updateDurationPreview();"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                            <option value="Annual Leave">Annual Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Unpaid Leave">Unpaid Leave</option>
                        </select>
                        <!-- Balance Hint -->
                        <div id="balanceHint" class="mt-1.5 text-xs flex items-center gap-1.5"></div>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                            <input type="date" id="startDate" name="start_date" required onchange="updateDurationPreview()"
                                class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                            <input type="date" id="endDate" name="end_date" required onchange="updateDurationPreview()"
                                class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                        </div>
                    </div>

                    <!-- Duration Preview -->
                    <div id="durationPreview" class="hidden text-xs font-medium flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span id="durationText"></span>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason</label>
                        <textarea name="reason" required
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white h-24 focus:ring outline-none"
                            placeholder="Provide details about your leave..."></textarea>
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Attachment <span class="text-gray-400 font-normal text-xs">(optional · jpg, png, pdf · max 5MB)</span>
                        </label>
                        <label id="fileDropZone" for="attachmentInput"
                            class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all">
                            <div id="fileDropLabel" class="flex flex-col items-center text-gray-400 text-sm gap-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span>Click to upload or drag & drop</span>
                            </div>
                        </label>
                        <input type="file" id="attachmentInput" name="attachment" accept=".jpg,.jpeg,.png,.pdf" class="hidden" onchange="previewFile(this)">
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-2">
                        <button type="button" onclick="closeLeaveModal()"
                            class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" id="submitLeaveBtn"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                            <span id="submitLeaveText">Submit Request</span>
                            <svg id="submitLeaveSpinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Hidden element carrying server data; keeps script tag Blade-free --}}
        <div id="leavePageData" class="hidden"
            data-annual-remaining="{{ $leaveBalance ? max(0, $leaveBalance->annual_leave_quota - $leaveBalance->annual_leave_used) : 0 }}"
            data-annual-quota="{{ $leaveBalance ? $leaveBalance->annual_leave_quota : 0 }}"
            data-sick-remaining="{{ $leaveBalance ? max(0, $leaveBalance->sick_leave_quota - $leaveBalance->sick_leave_used) : 0 }}"
            data-sick-quota="{{ $leaveBalance ? $leaveBalance->sick_leave_quota : 0 }}"
            data-unpaid-remaining="{{ $leaveBalance ? max(0, $leaveBalance->unpaid_leave_quota - $leaveBalance->unpaid_leave_used) : 0 }}"
            data-unpaid-quota="{{ $leaveBalance ? $leaveBalance->unpaid_leave_quota : 0 }}"
            data-store-url="{{ route('leave.store') }}"
            data-cancel-url="{{ url('/leave/cancel') }}"
        ></div>
        <script>
            // ── Balance data read from hidden data element ────────────────────
            const _d = document.getElementById('leavePageData').dataset;
            let leaveBalances = {
                'Annual Leave': { remaining: parseInt(_d.annualRemaining), quota: parseInt(_d.annualQuota) },
                'Sick Leave':   { remaining: parseInt(_d.sickRemaining),   quota: parseInt(_d.sickQuota)   },
                'Unpaid Leave': { remaining: parseInt(_d.unpaidRemaining),  quota: parseInt(_d.unpaidQuota)  },
            };

            const storeUrl  = _d.storeUrl;
            const cancelUrl = _d.cancelUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ── Modal open/close ─────────────────────────────────────────────
            function openLeaveModal() {
                const modal = document.getElementById('requestLeaveModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                requestAnimationFrame(() => {
                    modal.querySelector('.modal-overlay').classList.add('opacity-100');
                    const content = modal.querySelector('.modal-content');
                    content.classList.remove('opacity-0', 'scale-95');
                    content.classList.add('opacity-100', 'scale-100');
                });
                updateBalanceHint();
            }

            function closeLeaveModal() {
                const modal   = document.getElementById('requestLeaveModal');
                const overlay = modal.querySelector('.modal-overlay');
                const content = modal.querySelector('.modal-content');
                overlay.classList.remove('opacity-100');
                content.classList.add('opacity-0', 'scale-95');
                content.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.getElementById('leaveForm').reset();
                    resetFileDropZone();
                    document.getElementById('durationPreview').classList.add('hidden');
                }, 300);
            }

            function resetFileDropZone() {
                document.getElementById('fileDropLabel').innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <span>Click to upload or drag & drop</span>`;
            }

            // ── Balance hint ─────────────────────────────────────────────────
            function updateBalanceHint() {
                const type      = document.getElementById('leaveType').value;
                const remaining = leaveBalances[type]?.remaining ?? 0;
                const hint      = document.getElementById('balanceHint');

                if (remaining <= 0) {
                    hint.innerHTML = `<span class="inline-flex items-center gap-1 text-red-500 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Jatah habis — tidak bisa mengajukan tipe cuti ini
                    </span>`;
                } else {
                    hint.innerHTML = `<span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Sisa jatah: <strong>${remaining} hari</strong>
                    </span>`;
                }
            }

            // ── Duration preview ─────────────────────────────────────────────
            function updateDurationPreview() {
                const start   = document.getElementById('startDate').value;
                const end     = document.getElementById('endDate').value;
                const preview = document.getElementById('durationPreview');

                if (!start || !end) { preview.classList.add('hidden'); return; }
                const diff = Math.floor((new Date(end) - new Date(start)) / 86400000) + 1;
                if (diff <= 0) { preview.classList.add('hidden'); return; }

                const type     = document.getElementById('leaveType').value;
                const remain   = leaveBalances[type]?.remaining ?? 0;
                const exceeded = diff > remain;

                preview.className = `text-xs font-medium flex items-center gap-1.5 ${exceeded ? 'text-red-500 dark:text-red-400' : 'text-blue-600 dark:text-blue-400'}`;
                document.getElementById('durationText').textContent =
                    `${diff} hari dipilih${exceeded ? ` — melebihi sisa balance (${remain} hari)!` : ''}`;
                preview.classList.remove('hidden');
            }

            // ── File preview ─────────────────────────────────────────────────
            function previewFile(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    document.getElementById('fileDropLabel').innerHTML = `
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-blue-600 dark:text-blue-400 font-medium text-xs">${file.name}</span>
                        <span class="text-gray-400 text-xs">${(file.size / 1024).toFixed(1)} KB</span>`;
                }
            }

            // ── Submit leave ─────────────────────────────────────────────────
            async function submitLeaveRequest(e) {
                e.preventDefault();

                const type   = document.getElementById('leaveType').value;
                const remain = leaveBalances[type]?.remaining ?? 0;

                // Front-end guard: balance habis
                if (remain <= 0) {
                    window.showToast('Jatah Habis', `Sisa jatah ${type} kamu sudah 0 hari. Pilih tipe lain atau hubungi HR.`, true);
                    return;
                }

                const btn     = document.getElementById('submitLeaveBtn');
                const spinner = document.getElementById('submitLeaveSpinner');
                const text    = document.getElementById('submitLeaveText');

                btn.disabled = true;
                spinner.classList.remove('hidden');
                text.textContent = 'Submitting...';

                const formData = new FormData(document.getElementById('leaveForm'));

                try {
                    const res  = await fetch(storeUrl, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        body: formData,
                    });
                    const data = await res.json();

                    if (data.success) {
                        window.showToast('Berhasil!', data.message, false);
                        closeLeaveModal();
                        appendLeaveRow(data.leave);
                        updateBalanceCards(data.balance);
                        const empty = document.getElementById('emptyRow');
                        if (empty) empty.remove();
                    } else {
                        window.showToast('Gagal', data.message, true);
                    }
                } catch (err) {
                    window.showToast('Error', 'Terjadi kesalahan jaringan. Coba lagi.', true);
                } finally {
                    btn.disabled = false;
                    spinner.classList.add('hidden');
                    text.textContent = 'Submit Request';
                }
            }

            // ── Append new row ────────────────────────────────────────────────
            function appendLeaveRow(leave) {
                const tbody = document.getElementById('leaveTableBody');
                const tr    = document.createElement('tr');
                tr.className     = 'hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors new-row';
                tr.dataset.leaveId = leave.id;
                tr.innerHTML = `
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">${leave.leave_type}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${leave.start_date} — ${leave.end_date}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${leave.duration_days} Days</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">${leave.reason}</td>
                    <td class="px-6 py-4">
                        ${leave.has_attachment
                            ? `<span class="text-xs text-blue-600 dark:text-blue-400 font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Uploaded</span>`
                            : '<span class="text-gray-400 text-xs">—</span>'}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">
                            Pending
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="cancelLeave('${leave.id}')" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">Cancel</button>
                    </td>`;
                tbody.insertBefore(tr, tbody.firstChild);
            }

            // ── Cancel leave ─────────────────────────────────────────────────
            async function cancelLeave(id) {
                if (!confirm('Yakin ingin membatalkan permohonan cuti ini? Balance akan dikembalikan.')) return;

                try {
                    const res  = await fetch(`${cancelUrl}/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    });
                    const data = await res.json();

                    if (data.success) {
                        window.showToast('Dibatalkan', data.message, false);
                        const row = document.querySelector(`tr[data-leave-id="${id}"]`);
                        if (row) {
                            row.style.opacity    = '0';
                            row.style.transition = 'opacity 0.3s';
                            setTimeout(() => row.remove(), 300);
                        }
                        if (data.balance) updateBalanceCards(data.balance);
                    } else {
                        window.showToast('Gagal', data.message, true);
                    }
                } catch (err) {
                    window.showToast('Error', 'Terjadi kesalahan. Coba lagi.', true);
                }
            }

            // ── Update balance cards ─────────────────────────────────────────
            function updateBalanceCards(balance) {
                leaveBalances['Annual Leave'].remaining = balance.annual_remaining;
                leaveBalances['Sick Leave'].remaining   = balance.sick_remaining;
                leaveBalances['Unpaid Leave'].remaining = balance.unpaid_remaining;

                document.getElementById('balance-annual').textContent = balance.annual_remaining;
                document.getElementById('balance-sick').textContent   = balance.sick_remaining;
                document.getElementById('balance-unpaid').textContent = balance.unpaid_remaining;

                const ap = balance.annual_quota > 0 ? Math.round((balance.annual_remaining / balance.annual_quota) * 100) : 0;
                const sp = balance.sick_quota   > 0 ? Math.round((balance.sick_remaining   / balance.sick_quota)   * 100) : 0;
                const up = balance.unpaid_quota > 0 ? Math.round((balance.unpaid_remaining / balance.unpaid_quota) * 100) : 0;

                document.getElementById('bar-annual').style.width  = ap + '%';
                document.getElementById('bar-sick').style.width    = sp + '%';
                document.getElementById('bar-unpaid').style.width  = up + '%';

                updateBalanceHint();
            }

            // Drag & drop support on file zone
            const dropZone = document.getElementById('fileDropZone');
            if (dropZone) {
                dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('border-blue-400', 'bg-blue-50/30'); });
                dropZone.addEventListener('dragleave', ()  => dropZone.classList.remove('border-blue-400', 'bg-blue-50/30'));
                dropZone.addEventListener('drop', e  => {
                    e.preventDefault();
                    dropZone.classList.remove('border-blue-400', 'bg-blue-50/30');
                    const input = document.getElementById('attachmentInput');
                    input.files = e.dataTransfer.files;
                    previewFile(input);
                });
            }

            document.addEventListener('DOMContentLoaded', () => updateBalanceHint());
        </script>
    </div>
</x-app-layout>