<x-app-layout :title="$title">
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
            <button data-modal-target="assignModal"
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
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 fade-in" style="animation-delay:0.05s">
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Total Ditempatkan
            </p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalEmployees }}</p>
            @if($totalThisMonthContract > 0)
            <p class="text-xs text-green-500 mt-1">↑ {{ $totalThisMonthContract }} bulan ini</p>
            @endif
        </div>
        <div
            class="group bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4 transition cursor-pointer">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">
                <span class="group-hover:hidden">Jumlah Klien</span>
                <a href="{{ route('client-locations.index') }}" class="hidden animation-delay-200 group-hover:inline text-blue-500">+ Lihat List Client</a>
            </p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalClient }}</p>
            <p class="text-xs text-blue-500 mt-1">Aktif</p>

        </div>
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold uppercase">Masa Kontrak Habis
            </p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $totalExpiredContract }}</p>
            <p class="text-xs text-gray-400 mt-1">Dalam 30 hari</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-col md:flex-row gap-3 mb-4 fade-in" style="animation-delay:0.1s">
        <input type="text" id="search-input" oninput="filterTable()"
            placeholder="Cari karyawan, SK, atau klien..."
            class="w-full md:w-80 py-2 px-4 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
        <select id="filter-client" onchange="filterTable()" class="tom-select w-full md:w-48">
            <option value="">Semua Klien</option>
            @foreach($locationClients as $locationClient)
            <option>
                {{ $locationClient->client_name }}
            </option>
            @endforeach
        </select>
        <select id="filter-status" onchange="filterTable()"
            class="py-2 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="completed">Selesai</option>
            <option value="canceled">Pending</option>
        </select>
        <select id="filter-type" onchange="filterTable()"
            class="py-2 px-3 text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300">
            <option value="">Semua Tipe</option>
            <option value="new_placement">Penempatan Baru</option>
            <option value="mutation">Mutasi</option>
            <option value="extension">Perpanjangan</option>
            <option value="withdrawal">Penarikan</option>
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
                    @foreach ($employees as $employee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($employee->profile_photo)
                                <img src="{{ asset('storage/' . $employee->profile_photo) }}" class="w-8 h-8 rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                                @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->full_name) }}&background=random&color=fff&size=200" class="w-8 h-8 rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $employee->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $employee->employee_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td
                            class="px-5 py-4 text-blue-600 dark:text-blue-400 font-mono text-xs font-semibold">
                            {{ $employee->placement?->sk_number ?? '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->placement?->clientLocation?->client_name) }}&background=random&color=fff&size=200" class="rounded-full w-6 h-6" alt="Employee">
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $employee->placement?->clientLocation?->client_name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $employee->placement?->clientLocation?->city ?? '-' }}, {{ $employee->placement?->clientLocation?->province ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-700 dark:text-gray-300 text-sm">{{ $employee->placement?->position_at_client ?? '-' }}</td>
                        <td class="px-5 py-4 text-gray-600 dark:text-gray-400 text-xs">
                            <p>
                                {{
                                    $employee->placement?->start_date
                                    ? \Carbon\Carbon::parse($employee->placement->start_date)->format('d M Y')
                                    : '-'
                                }}
                            </p>
                            s/d
                            <p>
                                {{
                                    $employee->placement?->end_date
                                    ? \Carbon\Carbon::parse($employee->placement->end_date)->format('d M Y')
                                    : '-'
                                }}
                            </p>
                        </td>
                        @php
                        $type = $employee->placement?->placement_type;

                        $typeClass = match($type) {
                        'new_placement' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        'mutation' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                        'extension' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                        'withdrawal' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
                        };

                        $status = $employee->placement?->status;

                        $statusClass = match($status) {
                        'active' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                        'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
                        };

                        $typeLabel = $type ? ucfirst(str_replace('_', ' ', $type)) : '-';
                        $statusLabel = $status ? ucfirst($status) : '-';
                        @endphp

                        <td class="px-5 py-4">
                            <span class="badge {{ $typeClass }}">
                                {{ $typeLabel }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <span class="badge {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
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
                                @if($employee->placement)
                                <button type="button" data-modal-target="editModal{{ $employee->placement->id }}"
                                    class="text-gray-400 hover:text-yellow-600 transition-colors p-1 rounded hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form action="{{ route('placement.destroy', $employee->placement->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus placement ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-gray-400 hover:text-red-600 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach

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
    <div id="assignModal" class="modal-container fixed inset-0 z-50 hidden items-center justify-center">
        <div class="modal-overlay opacity-0 transition-opacity absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>
        <div
            class="modal-content opacity-0 scale-95 transition-all duration-200 bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-lg mx-4 relative z-10 border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
            <div
                class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-slate-800 z-10">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">New Assignment / Penempatan</h3>
                <button type="button" data-modal-close
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('placement.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Karyawan
                            <span class="text-red-500">*</span></label>
                        <select name="employee_id" required class="tom-select w-full">
                            <option value="">— None —</option>
                            @foreach($allEmployees as $allEmployee)
                            <option value="{{ $allEmployee->id }}">
                                {{ $allEmployee->full_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Klien
                            / Tempat Penempatan <span class="text-red-500">*</span></label>
                        <select name="client_location_id" required class="tom-select w-full">
                            <option value="">Pilih klien...</option>
                            @foreach($locationClients as $locationClient)
                            <option value="{{ $locationClient->id }}">
                                {{ $locationClient->client_name }}
                            </option>
                            @endforeach
                        </select>
                        <a href="{{ route('placement.form') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-1 inline-block">+ Tambah
                            lokasi klien baru</a>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Posisi
                            / Jabatan di Klien <span class="text-red-500">*</span></label>
                        <input type="text" name="position_at_client" placeholder="e.g. Video Editor, IT Support" required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tanggal
                            Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tanggal
                            Selesai</label>
                        <input type="date" name="end_date"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">No.
                            SK</label>
                        <input type="text" name="sk_number" placeholder="Auto-generate jika kosong"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none font-mono text-xs">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tipe
                            Penempatan <span class="text-red-500">*</span></label>
                        <select name="placement_type" required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                            <option value="new_placement">Penempatan Baru</option>
                            <option value="mutation">Mutasi</option>
                            <option value="extension">Perpanjangan</option>
                            <option value="withdrawal">Penarikan</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Catatan</label>
                        <textarea name="notes" rows="2" placeholder="Catatan tambahan..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" data-modal-close
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-lg font-medium transition-colors">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan
                        Penempatan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form is handled normally via standard PHP submission
        // Toast is handled via session flash message in layout

        function filterTable() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('#placement-tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tom-select').forEach((el) => {
                new TomSelect(el, {
                    create: false,
                    dropdownParent: 'body',
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });
        });
    </script>

    <!-- Edit Assignment Modals -->
    @foreach ($employees as $employee)
    @if($employee->placement)
    <div id="editModal{{ $employee->placement->id }}" class="modal-container fixed inset-0 z-50 hidden items-center justify-center">
        <div class="modal-overlay opacity-0 transition-opacity absolute inset-0 bg-black/50 backdrop-blur-sm" data-modal-close></div>
        <div
            class="modal-content opacity-0 scale-95 transition-all duration-200 bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-lg mx-4 relative z-10 border border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
            <div
                class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-white dark:bg-slate-800 z-10">
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Assignment / Penempatan</h3>
                <button type="button" data-modal-close
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('placement.update', $employee->placement->id) }}" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Karyawan
                            <span class="text-red-500">*</span></label>
                        <select name="employee_id" required class="tom-select w-full">
                            <option value="">— None —</option>
                            @foreach($allEmployees as $allEmployee)
                            <option value="{{ $allEmployee->id }}" {{ $employee->placement->employee_id == $allEmployee->id ? 'selected' : '' }}>
                                {{ $allEmployee->full_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Klien
                            / Tempat Penempatan <span class="text-red-500">*</span></label>
                        <select name="client_location_id" required class="tom-select w-full">
                            <option value="">Pilih klien...</option>
                            @foreach($locationClients as $locationClient)
                            <option value="{{ $locationClient->id }}" {{ $employee->placement->client_location_id == $locationClient->id ? 'selected' : '' }}>
                                {{ $locationClient->client_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Posisi
                            / Jabatan di Klien <span class="text-red-500">*</span></label>
                        <input type="text" name="position_at_client" placeholder="e.g. Video Editor, IT Support" required value="{{ $employee->placement->position_at_client }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tanggal
                            Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" required value="{{ \Carbon\Carbon::parse($employee->placement->start_date)->format('Y-m-d') }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tanggal
                            Selesai</label>
                        <input type="date" name="end_date" value="{{ $employee->placement->end_date ? \Carbon\Carbon::parse($employee->placement->end_date)->format('Y-m-d') : '' }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">No.
                            SK</label>
                        <input type="text" name="sk_number" placeholder="Auto-generate jika kosong" value="{{ $employee->placement->sk_number }}"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none font-mono text-xs" readonly>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Tipe
                            Penempatan <span class="text-red-500">*</span></label>
                        <select name="placement_type" required
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none">
                            <option value="new_placement" {{ $employee->placement->placement_type == 'new_placement' ? 'selected' : '' }}>Penempatan Baru</option>
                            <option value="mutation" {{ $employee->placement->placement_type == 'mutation' ? 'selected' : '' }}>Mutasi</option>
                            <option value="extension" {{ $employee->placement->placement_type == 'extension' ? 'selected' : '' }}>Perpanjangan</option>
                            <option value="withdrawal" {{ $employee->placement->placement_type == 'withdrawal' ? 'selected' : '' }}>Penarikan</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Catatan</label>
                        <textarea name="notes" rows="2" placeholder="Catatan tambahan..."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 outline-none resize-none">{{ $employee->placement->notes }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" data-modal-close
                        class="px-4 py-2 text-sm text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600 rounded-lg font-medium transition-colors">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition-colors">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @endforeach
</x-app-layout>