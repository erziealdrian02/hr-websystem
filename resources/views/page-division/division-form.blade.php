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
            <button onclick="submitForm()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                Simpan Divisi
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- LEFT: Detail Evaluasi Divisi -->
        <div class="space-y-6">

            <!-- Detail Organisasi Divisi -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.05s">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Detail Organisasi Divisi
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Nama Divisi / Departemen</label>
                        <input type="text" id="div-name"
                            placeholder="e.g. Engineering & Tech, Marketing"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Kode Divisi</label>
                            <input type="text" placeholder="e.g. ENG, MRK, FIN"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition uppercase">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Parent Division (Sub dari)</label>
                            <select
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                                <option value="">- Tidak ada (Root Level) -</option>
                                <option>Engineering & Tech</option>
                                <option>Human Resources</option>
                                <option>Finance & Accounting</option>
                                <option>Operations & Logistics</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Cost Center</label>
                        <input type="text" placeholder="Masukkan kode Cost Center (contoh: CC12345)"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition uppercase">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Deskripsi / Fungsi</label>
                        <textarea rows="3" placeholder="Tuliskan tugas dan fungsi dari divisi ini..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                    </div>
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Status Aktif</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Divisi tersedia untuk penempatan karyawan</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT: Kepala & Pengaturan -->
        <div class="space-y-6">

            <!-- Kepemimpinan -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.1s">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-700">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kepemimpinan (Leadership)
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Kepala Divisi (Department Head)</label>
                        <div class="relative">
                            <input type="text" id="head-search"
                                placeholder="Cari karyawan untuk ditetapkan..."
                                class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-purple-500 transition">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Ketik nama untuk mencari dari database karyawan.</p>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Jabatan (Title Kepemimpinan)</label>
                        <input type="text" id="head-title" placeholder="e.g. Chief Technology Officer, VP Marketing"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-purple-500 transition">
                    </div>
                </div>
            </div>

            <!-- Budgeting -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.15s">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Rencana & Anggaran
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Maks. Headcount</label>
                            <input type="number" step="1" placeholder="Batas karyawan"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-green-500 transition">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tipe Tagihan</label>
                            <select
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:border-green-500 transition">
                                <option>Internal (Overhead)</option>
                                <option>Billable (Client Project)</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/40">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Pengaturan Akses Default</p>
                            </div>
                            <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">Struktur penggajian, shift, dan kebijakan lembur (Overtime) akan menggunakan pengaturan default perusahaan kecuali di-override dari menu System Settings.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Submit Row -->
    <div class="flex justify-end gap-3 mt-6 fade-in" style="animation-delay:0.25s">
        <a href="{{ route('division.index') }}"
            class="px-5 py-2.5 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 rounded-lg font-medium transition-colors shadow-sm">Batal</a>
        <button onclick="saveDraft()"
            class="px-5 py-2.5 text-sm bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-lg font-medium transition-colors shadow-sm">Simpan
            Draft</button>
        <button onclick="submitForm()"
            class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            Simpan Divisi
        </button>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div
            class="bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <svg id="toast-icon" class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-msg">Berhasil!</span>
        </div>
    </div>


    <script>
        function showToast(msg, type = 'success') {
            const colors = {
                success: 'text-green-400',
                error: 'text-red-400',
                info: 'text-blue-400'
            };
            document.getElementById('toast-icon').className = `w-4 h-4 flex-shrink-0 ${colors[type] || colors.success}`;
            document.getElementById('toast-msg').textContent = msg;
            const t = document.getElementById('toast');
            t.classList.remove('hidden');
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => t.classList.add('hidden'), 3000);
        }

        function saveDraft() {
            showToast('Draft disimpan!', 'success');
        }

        function submitForm() {
            const divName = document.getElementById('div-name').value;
            const headSearch = document.getElementById('head-search').value;
            const headTitle = document.getElementById('head-title').value;

            if (!divName || !headSearch || !headTitle) {
                showToast('Harap lengkapi semua field yang wajib (*)!', 'error');
                return;
            }
            showToast('Divisi berhasil dibuat! ✓', 'success');
            setTimeout(() => {
                window.location.href = '{{ route('division.index') }}';
            }, 1000);
        }
    </script>
</x-app-layout>