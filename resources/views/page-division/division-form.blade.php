<x-app-layout>

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <a href="{{ route('division.index') }}"
                class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Division
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Department Division</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Buat struktur organisasi baru dan tetapkan kepala departemen.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="saveDraft()"
                class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Simpan Draft
            </button>
            <button type="submit" form="divisionForm"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Divisi
            </button>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-md fade-in">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan formulir:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form id="divisionForm" method="POST" action="{{ isset($division) ? route('division.update', $division->id) : route('division.store') }}">
        @csrf
        @if(isset($division))
        @method('PUT')
        @endif
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                    style="animation-delay:0.05s">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Detail Organisasi Divisi
                    </h3>

                    <div class="space-y-4">
                        <!-- Nama Divisi -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                                Nama Divisi / Departemen <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="div-name" name="name" maxlength="60"
                                placeholder="e.g. Engineering & Tech, Marketing"
                                value="{{ old('name', $division->name ?? '') }}"
                                oninput="updateChar('div-name', 'name-count', 60); triggerGenerateCode()"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition outline-none @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            <div class="flex justify-end mt-1">
                                <span id="name-count" class="text-xs text-gray-400">0 / 60</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Kode Divisi -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                                    Kode Divisi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="div-code" name="division_code" maxlength="20"
                                        placeholder="e.g. AS-BM-1"
                                        value="{{ old('division_code', $division->division_code ?? '') }}"
                                        oninput="updateChar('div-code', 'code-count', 20); this.value = this.value.toUpperCase()"
                                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition outline-none uppercase @error('division_code') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                        readonly>
                                    <div id="code-loading" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                                        <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-1">
                                    <span id="code-count" class="text-xs text-gray-400">0 / 20</span>
                                </div>
                            </div>

                            <!-- Lokasi Client -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                                    Lokasi Client
                                </label>
                                <div class="relative">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 z-10 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <select id="client-location" name="client_location_id" class="tom-select w-full has-icon" onchange="triggerGenerateCode()">
                                        <option value="">Cari lokasi Client</option>
                                        @foreach ($clientLocations as $clientLocation)
                                        <option value="{{ $clientLocation->id }}" {{ old('client_location_id', $division->client_location_id ?? '') == $clientLocation->id ? 'selected' : '' }}>{{ $clientLocation->client_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Status Aktif</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Divisi tersedia untuk penempatan karyawan</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span id="status-badge"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded-md bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400 transition-all">
                                    <span id="status-dot" class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                    <span id="status-text">Aktif</span>
                                </span>
                                <label class="toggle-switch">
                                    <input type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', $division->is_active ?? true) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Kepemimpinan -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                    style="animation-delay:0.1s">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Kepemimpinan (Leadership)
                    </h3>

                    <div class="space-y-4">
                        <!-- Search Kepala Divisi -->
                        <div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                                    Kepala Divisi (Department Head)
                                </label>
                                <div class="relative">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 z-10 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <select id="head-search" name="head_employee_id" class="tom-select w-full has-icon" onchange="triggerGenerateCode()">
                                        <option value="">Cari karyawan untuk ditetapkan..."</option>
                                        @foreach ($managers as $manager)
                                        <option value="{{ $manager->id }}" {{ old('head_employee_id', $division->head_employee_id ?? '') == $manager->id ? 'selected' : '' }}>{{ $manager->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 flex items-center justify-between">
                                <span>Ketik nama untuk mencari dari database karyawan.</span>
                                <!-- Clear Selection (Only shows if there's a selected employee) -->
                                <button type="button" id="clear-employee-btn" class="hidden text-red-500 hover:underline" onclick="clearEmployeeSelection()">Hapus Pilihan</button>
                            </p>

                            <!-- Employee Result Preview -->
                            <div id="emp-result"
                                class="{{ old('head_employee_id', $division->head_employee_id ?? '') ? 'flex' : 'hidden' }} mt-2 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600 items-center gap-3">
                                <div id="emp-avatar"
                                    class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-xs font-semibold text-blue-700 dark:text-blue-300 flex-shrink-0">
                                    {{ substr($division->manager_division->full_name ?? '', 0, 2) ?: '--' }}
                                </div>
                                <div>
                                    <p id="emp-name" class="text-sm font-medium text-gray-900 dark:text-white">{{ $division->manager_division->full_name ?? '' }}</p>
                                    <span id="emp-div"
                                        class="inline-flex items-center text-xs font-medium px-2 py-0.5 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 mt-0.5">
                                        Pilihan Terpilih
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                            <!-- Jabatan -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">
                                    Jabatan (Title Kepemimpinan) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="head-title" name="head_title"
                                    placeholder="e.g. Chief Technology Officer, VP Marketing"
                                    value="{{ old('head_title', $division->head_title ?? '') }}"
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition outline-none @error('head_title') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                                <p class="text-xs text-gray-400 mt-1">Jabatan yang akan ditampilkan pada chart organisasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Form Actions -->
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 fade-in" style="animation-delay:0.25s">
            <a href="{{ route('division.index') }}"
                class="px-5 py-2.5 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 rounded-lg font-medium transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit"
                class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($division) ? 'Update Divisi' : 'Simpan Divisi' }}
            </button>
        </div>
    </form>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden transition-all">
        <div class="bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <span id="toast-dot" class="w-2 h-2 rounded-full bg-green-400 flex-shrink-0"></span>
            <span id="toast-msg">Berhasil!</span>
        </div>
    </div>

    <script>
        // ── Character counter ──────────────────────────────────────────
        function updateChar(inputId, countId, max) {
            const len = document.getElementById(inputId).value.length;
            document.getElementById(countId).textContent = len + ' / ' + max;
        }

        // ── Status toggle ──────────────────────────────────────────────
        function toggleStatus() {
            const on = document.getElementById('toggle-status').checked;
            const badge = document.getElementById('status-badge');
            const dot = document.getElementById('status-dot');
            const txt = document.getElementById('status-text');

            if (on) {
                badge.className = 'inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded-md bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400 transition-all';
                dot.className = 'w-1.5 h-1.5 rounded-full bg-green-500 inline-block';
                txt.textContent = 'Aktif';
            } else {
                badge.className = 'inline-flex items-center gap-1.5 text-xs font-medium px-2 py-0.5 rounded-md bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400 transition-all';
                dot.className = 'w-1.5 h-1.5 rounded-full bg-red-500 inline-block';
                txt.textContent = 'Nonaktif';
            }
        }

        // ── Toast helper ───────────────────────────────────────────────
        function showToast(msg, type = 'success') {
            const colors = {
                success: 'bg-green-400',
                error: 'bg-red-400',
                info: 'bg-blue-400'
            };
            document.getElementById('toast-dot').className = `w-2 h-2 rounded-full flex-shrink-0 ${colors[type] ?? colors.success}`;
            document.getElementById('toast-msg').textContent = msg;

            const t = document.getElementById('toast');
            t.classList.remove('hidden');
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => t.classList.add('hidden'), 3000);
        }

        // ── TomSelect init & Generate Code ─────────────────────────────
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
                ts.on('change', function() {
                    if (el.id === 'client-location') {
                        triggerGenerateCode();
                    }
                });
            });
        });

        let codeTimeout;

        function triggerGenerateCode() {
            clearTimeout(codeTimeout);
            codeTimeout = setTimeout(function() {
                const divName = document.getElementById('div-name').value;
                const clientSelect = document.getElementById('client-location');
                const clientId = clientSelect ? clientSelect.value : '';

                if (divName.trim() === '') {
                    return; // Don't generate if name is empty
                }

                const loadingIndicator = document.getElementById('code-loading');
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');

                fetch(`{{ route('division.generate-code') }}?division_name=${encodeURIComponent(divName)}&client_id=${encodeURIComponent(clientId)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.code) {
                            const codeInput = document.getElementById('div-code');
                            codeInput.value = data.code;
                            updateChar('div-code', 'code-count', 20);
                        }
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    })
                    .catch(error => {
                        console.error('Error generating code:', error);
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    });
            }, 600); // 600ms debounce
        }

        function searchEmployee(query) {
            // Note: Currently not fully implemented, should fetch from employee endpoint
            if (!query) {
                document.getElementById('emp-result').classList.add('hidden');
                document.getElementById('clear-employee-btn').classList.add('hidden');
            }
            // For now, allow manually clearing
        }

        function clearEmployeeSelection() {
            document.getElementById('head_employee_id').value = '';
            document.getElementById('emp-result').classList.add('hidden');
            document.getElementById('clear-employee-btn').classList.add('hidden');
            document.getElementById('head-search').value = '';
        }
    </script>
</x-app-layout>