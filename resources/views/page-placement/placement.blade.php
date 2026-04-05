<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Placement & Assignment</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola penempatan karyawan outsource ke
                klien & lokasi kerja.</p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('placement.form') }}"
                class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-3 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm hover-scale">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Tambah Lokasi Klien
            </a>
            <button onclick="openModal('assignModal')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm hover-scale">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                New Assignment
            </button>
        </div>
    </div>

    <!-- Stats row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 fade-in" style="animation-delay:0.05s">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Total Ditempatkan
            </p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">48</p>
            <p class="text-xs text-green-500 mt-1">↑ 3 bulan ini</p>
        </div>
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Jumlah Klien</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">12</p>
            <p class="text-xs text-blue-500 mt-1">Aktif</p>
        </div>
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Pending SK</p>
            <p class="text-2xl font-bold text-yellow-500 mt-1">5</p>
            <p class="text-xs text-gray-400 mt-1">Menunggu tanda tangan</p>
        </div>
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Masa Kontrak Habis
            </p>
            <p class="text-2xl font-bold text-red-500 mt-1">3</p>
            <p class="text-xs text-gray-400 mt-1">Dalam 30 hari</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-col md:flex-row gap-3 mb-4 fade-in" style="animation-delay:0.1s">
        <input type="text" id="search-input" oninput="filterTable()"
            placeholder="Cari karyawan, SK, atau klien..."
            class="w-full md:w-80 py-2 px-4 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
        <select id="filter-client" onchange="filterTable()"
            class="py-2 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
            <option value="">Semua Klien</option>
            <option>CNBC Indonesia</option>
            <option>Bank Mandiri</option>
            <option>BRI</option>
            <option>Kompas Gramedia</option>
            <option>Telkom Indonesia</option>
        </select>
        <select id="filter-status" onchange="filterTable()"
            class="py-2 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
            <option value="">Semua Status</option>
            <option>Aktif</option>
            <option>Selesai</option>
            <option>Pending</option>
        </select>
        <select id="filter-type" onchange="filterTable()"
            class="py-2 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
            <option value="">Semua Tipe</option>
            <option>Penempatan Baru</option>
            <option>Mutasi</option>
            <option>Perpanjangan</option>
            <option>Penarikan</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in"
        style="animation-delay: 0.15s;">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="placement-table">
                <thead
                    class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Karyawan</th>
                        <th class="px-5 py-4 font-semibold">No. SK</th>
                        <th class="px-5 py-4 font-semibold">Klien / Lokasi</th>
                        <th class="px-5 py-4 font-semibold">Posisi Ditempatkan</th>
                        <th class="px-5 py-4 font-semibold">Periode</th>
                        <th class="px-5 py-4 font-semibold">Tipe</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold"></th>
                    </tr>
                </thead>
                <tbody id="placement-tbody" class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Williams&background=3b82f6&color=fff&size=32"
                                    class="w-8 h-8 rounded-full flex-shrink-0" alt="">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Sarah
                                        Williams</p>
                                    <p class="text-xs text-gray-500">EMP-1025</p>
                                </div>
                            </div>
                        </td>
                        <td
                            class="px-5 py-4 text-blue-600 dark:text-blue-400 font-mono text-xs font-semibold">
                            SK/HR/04-2026/012</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-red-600 dark:text-red-400">C</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">CNBC
                                        Indonesia</p>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Kebon Sirih, Jakarta
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-700 dark:text-gray-300 text-sm">Video Editor</td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400 text-xs">
                            <p>01 Apr 2026</p>
                            <p class="text-gray-400">s/d 31 Mar 2027</p>
                        </td>
                        <td class="px-5 py-4"><span
                                class="badge bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">Penempatan
                                Baru</span></td>
                        <td class="px-5 py-4"><span
                                class="badge bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                        </td>
                        <td class="px-5 py-4">
                            <button
                                class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=10b981&color=fff&size=32"
                                    class="w-8 h-8 rounded-full flex-shrink-0" alt="">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Budi
                                        Santoso</p>
                                    <p class="text-xs text-gray-500">EMP-1018</p>
                                </div>
                            </div>
                        </td>
                        <td
                            class="px-5 py-4 text-blue-600 dark:text-blue-400 font-mono text-xs font-semibold">
                            SK/HR/03-2026/008</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-xs font-bold text-yellow-600 dark:text-yellow-400">M</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Bank
                                        Mandiri</p>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Plaza Mandiri, SCBD
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-700 dark:text-gray-300 text-sm">IT Support Analyst
                        </td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400 text-xs">
                            <p>15 Mar 2026</p>
                            <p class="text-gray-400">s/d 14 Mar 2027</p>
                        </td>
                        <td class="px-5 py-4"><span
                                class="badge bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">Mutasi</span>
                        </td>
                        <td class="px-5 py-4"><span
                                class="badge bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                        </td>
                        <td class="px-5 py-4">
                            <button
                                class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Dina+Rahayu&background=f59e0b&color=fff&size=32"
                                    class="w-8 h-8 rounded-full flex-shrink-0" alt="">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Dina
                                        Rahayu</p>
                                    <p class="text-xs text-gray-500">EMP-1031</p>
                                </div>
                            </div>
                        </td>
                        <td
                            class="px-5 py-4 text-blue-600 dark:text-blue-400 font-mono text-xs font-semibold">
                            SK/HR/04-2026/015</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-xs font-bold text-blue-600 dark:text-blue-400">T</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">Telkom
                                        Indonesia</p>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Gatot Subroto, Jakarta
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-700 dark:text-gray-300 text-sm">Customer Relations
                        </td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400 text-xs">
                            <p>01 Apr 2026</p>
                            <p class="text-red-400 font-medium">s/d 30 Apr 2026 ⚠️</p>
                        </td>
                        <td class="px-5 py-4"><span
                                class="badge bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400">Perpanjangan</span>
                        </td>
                        <td class="px-5 py-4"><span
                                class="badge bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">Pending</span>
                        </td>
                        <td class="px-5 py-4">
                            <button
                                class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination placeholder -->
        <div
            class="px-5 py-3 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
            <span>Menampilkan 3 dari 48 penempatan</span>
            <div class="flex gap-1">
                <button
                    class="px-3 py-1 rounded border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700">‹</button>
                <button
                    class="px-3 py-1 rounded border border-blue-200 bg-blue-50 text-blue-600 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-400 font-semibold">1</button>
                <button
                    class="px-3 py-1 rounded border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700">2</button>
                <button
                    class="px-3 py-1 rounded border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700">›</button>
            </div>
        </div>
    </div>

    <!-- New Assignment Modal -->
    <div id="assignModal" class="modal-container fixed inset-0 z-50 items-center justify-center">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('assignModal')"></div>
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-lg mx-4 relative z-10 border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
            <div
                class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-slate-800 z-10">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">New Assignment / Penempatan</h3>
                <button onclick="closeModal('assignModal')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form onsubmit="submitAssignment(event)" class="p-5 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Karyawan
                            <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Cari nama karyawan..." required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Klien
                            / Tempat Penempatan <span class="text-red-500">*</span></label>
                        <select required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                            <option value="">Pilih klien...</option>
                            <option>CNBC Indonesia — Kebon Sirih, Jakarta</option>
                            <option>Bank Mandiri — Plaza Mandiri, SCBD</option>
                            <option>BRI — Jl. Jenderal Sudirman</option>
                            <option>Kompas Gramedia — Palmerah</option>
                            <option>Telkom Indonesia — Gatot Subroto</option>
                        </select>
                        <a href="{{ route('placement.form') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-1 inline-block">+ Tambah
                            lokasi klien baru</a>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Posisi
                            / Jabatan di Klien <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="e.g. Video Editor, IT Support" required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tanggal
                            Mulai <span class="text-red-500">*</span></label>
                        <input type="date" required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tanggal
                            Selesai</label>
                        <input type="date"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">No.
                            SK</label>
                        <input type="text" placeholder="Auto-generate jika kosong"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none font-mono text-xs">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tipe
                            Penempatan <span class="text-red-500">*</span></label>
                        <select required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                            <option>Penempatan Baru</option>
                            <option>Mutasi</option>
                            <option>Perpanjangan</option>
                            <option>Penarikan</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Catatan</label>
                        <textarea rows="2" placeholder="Catatan tambahan..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" onclick="closeModal('assignModal')"
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-lg font-medium transition-colors">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan
                        Penempatan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div
            class="bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-msg">Berhasil disimpan!</span>
        </div>
    </div>

    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            el.classList.add('flex');
            el.classList.remove('hidden');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            el.classList.remove('flex');
            el.classList.add('hidden');
        }

        function showToast(msg) {
            document.getElementById('toast-msg').textContent = msg;
            const t = document.getElementById('toast');
            t.classList.remove('hidden');
            setTimeout(() => t.classList.add('hidden'), 3000);
        }

        function submitAssignment(e) {
            e.preventDefault();
            closeModal('assignModal');
            showToast('Penempatan berhasil disimpan!');
        }

        function filterTable() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('#placement-tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>