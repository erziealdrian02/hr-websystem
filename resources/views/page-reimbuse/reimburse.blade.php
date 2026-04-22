<x-app-layout :title="$title">
    <div class="js-datatable-container" data-per-page="10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reimbursement Claims</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Submit and track your expense and medical claims.</p>
            </div>
            <button id="btnOpenReimburseModal" onclick="openReimburseModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Reimbursement
            </button>
        </div>

        <!-- Stats Summary (ReimburseBalance) -->
        @php
        $balanceMap = [];
        foreach ($reimburses_balance as $bal) {
        $balanceMap[$bal->category] = $bal->amount;
        }
        $glassesBalance = $balanceMap['glasses'] ?? 0;
        $inpatientBalance = $balanceMap['Inpatient'] ?? 0;
        $outpatientBalance = $balanceMap['outpatient'] ?? 0;
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in" style="animation-delay: 0.1s;">
            <!-- Glasses Balance -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-full bg-blue-50 dark:bg-blue-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider">Glasses</h3>
                </div>
                <span id="balance-glasses" class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">Rp {{ number_format($glassesBalance, 0, ',', '.') }}</span>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Remaining balance</p>
            </div>

            <!-- Inpatient Balance -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-full bg-green-50 dark:bg-green-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider">Inpatient</h3>
                </div>
                <span id="balance-inpatient" class="text-3xl font-extrabold text-green-600 dark:text-green-400">Rp {{ number_format($inpatientBalance, 0, ',', '.') }}</span>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Remaining balance</p>
            </div>

            <!-- Outpatient Balance -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-full bg-purple-50 dark:bg-purple-900/20 -skew-x-12 transform origin-top translate-x-4"></div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium text-sm uppercase tracking-wider">Outpatient</h3>
                </div>
                <span id="balance-outpatient" class="text-3xl font-extrabold text-purple-600 dark:text-purple-400">Rp {{ number_format($outpatientBalance, 0, ',', '.') }}</span>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Remaining balance</p>
            </div>
        </div>

        <!-- History Table Area -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in" style="animation-delay: 0.2s;">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50 dark:bg-slate-700/30">
                <h2 class="font-bold text-gray-900 dark:text-white">Recent Claims</h2>
                <div class="relative max-w-sm w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" class="js-search-input w-full py-1.5 pl-9 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 text-gray-700 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search description or category...">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold">Category</th>
                            <th class="px-6 py-4 font-semibold">Description</th>
                            <th class="px-6 py-4 font-semibold">Amount</th>
                            <th class="px-6 py-4 font-semibold">Receipt</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Notes</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="reimburseTableBody" class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                        @php
                        $categoryConfig = [
                        'glasses' => ['label' => 'Glasses', 'bg' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'],
                        'Inpatient' => ['label' => 'Inpatient', 'bg' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'],
                        'outpatient' => ['label' => 'Outpatient', 'bg' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400'],
                        ];
                        @endphp
                        @forelse ($reimburses as $reimburse)
                        @php
                        $statusConfig = match(strtolower($reimburse->status)) {
                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        'paid' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400',
                        default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500',
                        };
                        $catConf = $categoryConfig[$reimburse->category] ?? ['label' => ucfirst($reimburse->category), 'bg' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'];
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors" data-reimburse-id="{{ $reimburse->id }}">
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($reimburse->reimburse_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold {{ $catConf['bg'] }}">{{ $catConf['label'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">{{ $reimburse->description }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">Rp {{ number_format($reimburse->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if ($reimburse->receipt_path)
                                <a href="{{ Storage::url($reimburse->receipt_path) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:underline text-xs font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    View
                                </a>
                                @else
                                <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig }}">
                                    {{ ucfirst($reimburse->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs truncate max-w-[150px]">{{ $reimburse->notes ?? '—' }}</td>
                            <td class="px-6 py-4 text-right">
                                @if (strtolower($reimburse->status) === 'pending')
                                <button onclick="cancelReimburse('{{ $reimburse->id }}')" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">Cancel</button>
                                @else
                                <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                    </svg>
                                    <p class="text-sm">No reimbursement claims found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="js-pagination-controls"></div>
        </div>

        <!-- Submit Reimburse Modal -->
        <div id="reimburseModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" onclick="closeReimburseModal()"></div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-slate-800 z-10">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Submit Reimbursement</h3>
                    <button onclick="closeReimburseModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="reimburseForm" enctype="multipart/form-data" class="p-5 space-y-4" onsubmit="submitReimburse(event)">
                    @csrf

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select id="reimburseCategory" name="category" required onchange="updateBalanceHint()"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                            <option value="glasses">Glasses</option>
                            <option value="Inpatient">Inpatient</option>
                            <option value="outpatient">Outpatient</option>
                        </select>
                        <div id="balanceHint" class="mt-1.5 text-xs flex items-center gap-1.5"></div>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reimburse Date</label>
                        <input type="date" id="reimburseDate" name="reimburse_date" required
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea name="description" required
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white h-24 focus:ring outline-none"
                            placeholder="Describe the expense..."></textarea>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 dark:text-gray-400 font-medium">Rp</span>
                            <input type="text" id="amountDisplay" required
                                class="w-full pl-9 pr-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none"
                                placeholder="500.000" oninput="formatAmountInput(this)">
                            <input type="text" name="amount" id="amountRaw" class="hidden" required>
                        </div>
                    </div>

                    <!-- Receipt Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Receipt <span class="text-gray-400 font-normal text-xs">(optional · jpg, png, pdf · max 5MB)</span>
                        </label>
                        <label id="fileDropZone" for="receiptInput"
                            class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all">
                            <div id="fileDropLabel" class="flex flex-col items-center text-gray-400 text-sm gap-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span>Click to upload or drag & drop</span>
                            </div>
                        </label>
                        <input type="file" id="receiptInput" name="receipt" accept=".jpg,.jpeg,.png,.pdf" class="hidden" onchange="previewFile(this)">
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-2">
                        <button type="button" onclick="closeReimburseModal()"
                            class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" id="submitReimburseBtn"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                            <span id="submitReimburseText">Submit Claim</span>
                            <svg id="submitReimburseSpinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hidden data element for JS -->
        <div id="reimbursePageData" class="hidden"
            data-glasses-balance="{{ $glassesBalance }}"
            data-inpatient-balance="{{ $inpatientBalance }}"
            data-outpatient-balance="{{ $outpatientBalance }}"
            data-store-url="{{ route('reimburse.store') }}"
            data-cancel-url="{{ url('/reimburse/cancel') }}"></div>

        <script>
            // ── Balance data ────────────────────────────────────────────────
            const _d = document.getElementById('reimbursePageData').dataset;
            let reimburseBalances = {
                'glasses': parseInt(_d.glassesBalance) || 0,
                'Inpatient': parseInt(_d.inpatientBalance) || 0,
                'outpatient': parseInt(_d.outpatientBalance) || 0,
            };

            const storeUrl = _d.storeUrl;
            const cancelUrl = _d.cancelUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ── Modal open/close ────────────────────────────────────────────
            function openReimburseModal() {
                const modal = document.getElementById('reimburseModal');
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

            function closeReimburseModal() {
                const modal = document.getElementById('reimburseModal');
                const overlay = modal.querySelector('.modal-overlay');
                const content = modal.querySelector('.modal-content');
                overlay.classList.remove('opacity-100');
                content.classList.add('opacity-0', 'scale-95');
                content.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.getElementById('reimburseForm').reset();
                    document.getElementById('amountRaw').value = '';
                    resetFileDropZone();
                }, 300);
            }

            function resetFileDropZone() {
                document.getElementById('fileDropLabel').innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <span>Click to upload or drag & drop</span>`;
            }

            // ── Balance hint ────────────────────────────────────────────────
            function updateBalanceHint() {
                const cat = document.getElementById('reimburseCategory').value;
                const remaining = reimburseBalances[cat] ?? 0;
                const hint = document.getElementById('balanceHint');
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(remaining);

                if (remaining <= 0) {
                    hint.innerHTML = `<span class="inline-flex items-center gap-1 text-red-500 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Saldo habis — tidak bisa mengajukan kategori ini
                    </span>`;
                } else {
                    hint.innerHTML = `<span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Sisa saldo: <strong>${formatted}</strong>
                    </span>`;
                }
            }

            // ── Amount Formatting ───────────────────────────────────────────
            function formatAmountInput(input) {
                let val = input.value.replace(/[^0-9]/g, '');

                if (val) {
                    input.value = new Intl.NumberFormat('id-ID').format(val);
                    document.getElementById('amountRaw').value = val;
                } else {
                    input.value = '';
                    document.getElementById('amountRaw').value = '';
                }
            }

            // ── File preview ────────────────────────────────────────────────
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

            // ── Submit reimburse ────────────────────────────────────────────
            async function submitReimburse(e) {
                e.preventDefault();

                const cat = document.getElementById('reimburseCategory').value;
                const remain = reimburseBalances[cat] ?? 0;

                if (remain <= 0) {
                    window.showToast('Saldo Habis', `Sisa saldo untuk kategori ini sudah 0. Pilih kategori lain atau hubungi HR.`, true);
                    return;
                }

                const btn = document.getElementById('submitReimburseBtn');
                const spinner = document.getElementById('submitReimburseSpinner');
                const text = document.getElementById('submitReimburseText');

                btn.disabled = true;
                spinner.classList.remove('hidden');
                text.textContent = 'Submitting...';

                const formData = new FormData(document.getElementById('reimburseForm'));

                try {
                    const res = await fetch(storeUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData,
                    });
                    const data = await res.json();

                    if (data.success) {
                        window.showToast('Berhasil!', data.message, false);
                        closeReimburseModal();
                        appendReimburseRow(data.reimburse);
                        updateBalanceCards(data.balances);
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
                    text.textContent = 'Submit Claim';
                }
            }

            // ── Append new row ──────────────────────────────────────────────
            function appendReimburseRow(r) {
                const catConfig = {
                    'glasses': {
                        label: 'Glasses',
                        bg: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
                    },
                    'Inpatient': {
                        label: 'Inpatient',
                        bg: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                    },
                    'outpatient': {
                        label: 'Outpatient',
                        bg: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400'
                    },
                };
                const cat = catConfig[r.category] || {
                    label: r.category,
                    bg: 'bg-gray-100 text-gray-700'
                };
                const amount = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(r.amount);
                const dateObj = new Date(r.reimburse_date);
                const dateStr = dateObj.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                const tbody = document.getElementById('reimburseTableBody');
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors new-row';
                tr.dataset.reimburseId = r.id;
                tr.innerHTML = `
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">${dateStr}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold ${cat.bg}">${cat.label}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs">${r.description}</td>
                    <td class="px-6 py-4 text-gray-900 dark:text-white font-bold">${amount}</td>
                    <td class="px-6 py-4">
                        ${r.has_receipt
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
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs">—</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="cancelReimburse('${r.id}')" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">Cancel</button>
                    </td>`;
                tbody.insertBefore(tr, tbody.firstChild);
            }

            // ── Cancel reimburse ────────────────────────────────────────────
            async function cancelReimburse(id) {
                if (!confirm('Yakin ingin membatalkan klaim ini? Saldo akan dikembalikan.')) return;

                try {
                    const res = await fetch(`${cancelUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                    });
                    const data = await res.json();

                    if (data.success) {
                        window.showToast('Dibatalkan', data.message, false);
                        const row = document.querySelector(`tr[data-reimburse-id="${id}"]`);
                        if (row) {
                            row.style.opacity = '0';
                            row.style.transition = 'opacity 0.3s';
                            setTimeout(() => row.remove(), 300);
                        }
                        if (data.balances) updateBalanceCards(data.balances);
                    } else {
                        window.showToast('Gagal', data.message, true);
                    }
                } catch (err) {
                    window.showToast('Error', 'Terjadi kesalahan. Coba lagi.', true);
                }
            }

            // ── Update balance cards ────────────────────────────────────────
            function updateBalanceCards(balances) {
                const fmt = (v) => new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(v || 0);

                if (balances.glasses !== undefined) reimburseBalances['glasses'] = balances.glasses;
                if (balances.Inpatient !== undefined) reimburseBalances['Inpatient'] = balances.Inpatient;
                if (balances.outpatient !== undefined) reimburseBalances['outpatient'] = balances.outpatient;

                document.getElementById('balance-glasses').textContent = fmt(reimburseBalances['glasses']);
                document.getElementById('balance-inpatient').textContent = fmt(reimburseBalances['Inpatient']);
                document.getElementById('balance-outpatient').textContent = fmt(reimburseBalances['outpatient']);

                updateBalanceHint();
            }

            // ── Drag & drop support ─────────────────────────────────────────
            const dropZone = document.getElementById('fileDropZone');
            if (dropZone) {
                dropZone.addEventListener('dragover', e => {
                    e.preventDefault();
                    dropZone.classList.add('border-blue-400', 'bg-blue-50/30');
                });
                dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-blue-400', 'bg-blue-50/30'));
                dropZone.addEventListener('drop', e => {
                    e.preventDefault();
                    dropZone.classList.remove('border-blue-400', 'bg-blue-50/30');
                    const input = document.getElementById('receiptInput');
                    input.files = e.dataTransfer.files;
                    previewFile(input);
                });
            }

            document.addEventListener('DOMContentLoaded', () => updateBalanceHint());
        </script>
    </div>
</x-app-layout>