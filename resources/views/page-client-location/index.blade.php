<x-app-layout :title="$title">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 350px;
            width: 100%;
            border-radius: 0.5rem;
            z-index: 0;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white" id="page-title">Client
                Locations</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1" id="page-subtitle">Kelola daftar lokasi klien dan titik radius absensi
                karyawan.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="toggleForm()" id="btn-toggle"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="toggle-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span id="toggle-text">Tambah Klien Baru</span>
            </button>
        </div>
    </div>


    <!-- Alert messages -->
    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-400">
        {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- TABLE SECTION -->
    <div id="table-section" class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-xs uppercase text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Nama Klien</th>
                        <th class="px-5 py-4 font-semibold">PIC / Kontak</th>
                        <th class="px-5 py-4 font-semibold">Lokasi / Alamat</th>
                        <th class="px-5 py-4 font-semibold">Radius Area</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($clientLocations as $loc)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $loc->client_name }}</p>
                            <p class="text-xs text-gray-500 font-mono">{{ $loc->client_code ?? '-' }} | {{ $loc->industry ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-gray-900 dark:text-white">{{ $loc->pic_name ?? '-' }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ $loc->pic_phone ?? '' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-800 dark:text-gray-200">{{ $loc->building_name }}</p>
                            <p class="text-xs text-gray-500">{{ $loc->city }}, {{ $loc->province }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1 text-xs font-medium bg-blue-50 text-blue-700 px-2 py-1 rounded dark:bg-blue-900/30 dark:text-blue-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                {{ $loc->attendance_radius_meter }}m
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($loc->is_active)
                            <span class="badge bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                            @else
                            <span class="badge bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick='editClient(@json($loc))' class="text-gray-400 hover:text-blue-600 transition-colors p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <form action="{{ route('client-locations.destroy', $loc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klien ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <p>Belum ada data Client Location. Silakan tambahkan baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- FORM SECTION -->
    <div id="form-section" class="form-section transition-all">
        <form id="client-form" action="{{ route('client-locations.store') }}" method="POST">
            @csrf
            <!-- Method will be dynamically updated for edit -->
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- LEFT: Form -->
                <div class="space-y-6">

                    <!-- Identitas Klien -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Identitas Klien / Perusahaan
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Nama
                                    Perusahaan / Klien</label>
                                <input type="text" name="client_name" id="client_name" required placeholder="e.g. CNBC Indonesia, Bank Mandiri"
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Kode Klien</label>
                                    <input type="text" name="client_code" id="client_code" placeholder="e.g. CNBC-01" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition uppercase">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Industri</label>
                                    <select name="industry" id="industry" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                                        <option value="">Pilih...</option>
                                        <option>Media & Broadcasting</option>
                                        <option>Perbankan & Keuangan</option>
                                        <option>Teknologi & IT</option>
                                        <option>Telekomunikasi</option>
                                        <option>Manufaktur</option>
                                        <option>Retail & FMCG</option>
                                        <option>Kesehatan</option>
                                        <option>Pendidikan</option>
                                        <option>Pemerintahan</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Nama PIC Klien</label>
                                    <input type="text" name="pic_name" id="pic_name" placeholder="Nama penanggung jawab" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">No. Telp PIC</label>
                                    <input type="tel" name="pic_phone" id="pic_phone" placeholder="+62 8xx" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Email PIC</label>
                                <input type="email" name="pic_email" id="pic_email" placeholder="pic@perusahaan.com" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Status Aktif</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Lokasi tersedia untuk penempatan</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Alamat Lokasi
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Nama Gedung / Lokasi</label>
                                <input type="text" name="building_name" id="building_name" required placeholder="e.g. Gedung Trans Media, Menara Mandiri"
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Alamat Lengkap</label>
                                <textarea name="address" id="full-address" required rows="2" placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan"
                                    class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Kota</label>
                                    <input type="text" name="city" id="city" required placeholder="e.g. Jakarta Pusat" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Provinsi</label>
                                    <select name="province" id="province" required class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                                        <option value="">Pilih provinsi...</option>
                                        <option>DKI Jakarta</option>
                                        <option>Jawa Barat</option>
                                        <option>Jawa Tengah</option>
                                        <option>Jawa Timur</option>
                                        <option>Banten</option>
                                        <option>DI Yogyakarta</option>
                                        <option>Bali</option>
                                        <option>Sumatera Utara</option>
                                        <option>Sumatera Selatan</option>
                                        <option>Kalimantan Timur</option>
                                        <option>Sulawesi Selatan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Kode Pos</label>
                                    <input type="text" name="postal_code" id="postal_code" maxlength="10" placeholder="10110" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Lantai / Unit</label>
                                    <input type="text" name="floor_unit" id="floor_unit" placeholder="e.g. Lt. 5, Unit B" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT: Map + Koordinat -->
                <div class="space-y-6">

                    <!-- Map -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Koordinat GPS
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Klik pada peta untuk menentukan titik lokasi absensi</p>

                        <!-- Search on map -->
                        <div class="relative mb-3">
                            <input type="text" id="map-search" placeholder="Cari lokasi di peta (ketik lalu Enter)..."
                                class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition"
                                onkeydown="if(event.key==='Enter') {event.preventDefault(); searchLocation();}">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <button type="button" onclick="searchLocation()" class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700 transition">Cari</button>
                        </div>

                        <!-- Map container -->
                        <div id="map" class="border border-gray-200 dark:border-gray-600"></div>

                        <!-- Tip -->
                        <div class="flex items-center gap-2 mt-3">
                            <div class="pulse-dot flex-shrink-0"></div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Klik di mana saja pada peta untuk
                                mengubah titik koordinat. Atau gunakan tombol "Lokasi Saya" untuk mengisi otomatis.</p>
                        </div>
                    </div>

                    <!-- Koordinat hasil -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z" />
                            </svg>
                            Koordinat & Radius Absensi
                        </h3>

                        <!-- Coordinate display -->
                        <div class="coord-box rounded-xl p-4 mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Latitude</label>
                                    <input type="number" name="latitude" id="lat-input" step="0.000001" placeholder="-6.200000" required oninput="updateMapFromInput()"
                                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-blue-200 dark:border-blue-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Longitude</label>
                                    <input type="number" name="longitude" id="lng-input" step="0.000001" placeholder="106.816666" required oninput="updateMapFromInput()"
                                        class="w-full px-3 py-2.5 text-sm rounded-lg border border-blue-200 dark:border-blue-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                                </div>
                            </div>

                            <!-- Accuracy indicator -->
                            <div class="flex items-center gap-2 mt-3" id="coord-status">
                                <div class="w-2 h-2 rounded-full bg-gray-300" id="coord-dot"></div>
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="coord-label">Belum ada titik dipilih</span>
                            </div>
                        </div>

                        <!-- Radius for attendance -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Radius Absensi</label>
                                <span class="text-sm font-bold text-blue-600 dark:text-blue-400" id="radius-val">100 meter</span>
                            </div>
                            <input type="range" name="attendance_radius_meter" id="radius-slider" min="50" max="500" step="10" value="100" oninput="updateRadius(this.value)" class="w-full">
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>50m</span>
                                <span>200m</span>
                                <span>500m</span>
                            </div>
                        </div>

                        <!-- Tombol aksi -->
                        <div class="flex gap-2 flex-wrap pb-4 border-b border-gray-100 dark:border-gray-700">
                            <button type="button" onclick="useMyLocation()" class="flex items-center gap-2 px-3 py-2 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/40 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Lokasi Saya
                            </button>
                            <button type="button" onclick="resetCoords()" class="flex items-center gap-2 px-3 py-2 text-xs font-medium bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/30 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/20 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </button>
                        </div>

                        <div class="mt-4">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Pengaturan Jam Kerja (Opsional)</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Jam Masuk</label>
                                    <input type="time" name="work_start_time" id="work_start_time" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Jam Pulang</label>
                                    <input type="time" name="work_end_time" id="work_end_time" class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Submit Row -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="toggleForm()" class="px-5 py-2.5 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 rounded-lg font-medium transition-colors shadow-sm">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Lokasi Klien
                </button>
            </div>
        </form>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <svg id="toast-icon" class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-msg">Berhasil!</span>
        </div>
    </div>

    <!-- Script Leaflet & Interactive Logic -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, marker, radiusCircle;
        let currentLat = null,
            currentLng = null;
        let currentRadius = 100;
        let isMapInitialized = false;

        const DEFAULT_LAT = -6.2088;
        const DEFAULT_LNG = 106.8456;

        function toggleForm(forceOpen = false) {
            const formSection = document.getElementById('form-section');
            const tableSection = document.getElementById('table-section');
            const toggleIcon = document.getElementById('toggle-icon');
            const toggleText = document.getElementById('toggle-text');
            const pageTitle = document.getElementById('page-title');

            if (formSection.classList.contains('active') && !forceOpen) {
                // Return to table
                formSection.classList.remove('active');
                tableSection.style.display = 'block';
                toggleText.textContent = "Tambah Klien Baru";
                toggleIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />`;
                pageTitle.textContent = "Client Locations";

                // Reset form values on hide just in case
                document.getElementById('client-form').reset();
                document.getElementById('form-method').value = "POST";
                document.getElementById('client-form').action = "{{ route('client-locations.store') }}";
                resetCoords();

            } else {
                // Show form
                formSection.classList.add('active');
                tableSection.style.display = 'none';
                toggleText.textContent = "Kembali ke Daftar";
                toggleIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />`;
                pageTitle.textContent = document.getElementById('form-method').value === "PUT" ? "Edit Klien" : "Tambah Klien Baru";

                // Map Initialization delay logic to prevent gray areas
                if (!isMapInitialized) {
                    setTimeout(() => {
                        initMap();
                        isMapInitialized = true;
                    }, 100);
                } else {
                    setTimeout(() => map.invalidateSize(), 150);
                }
            }
        }

        function initMap() {
            if (map) {
                map.remove();
            }
            map = L.map('map', {
                center: [DEFAULT_LAT, DEFAULT_LNG],
                zoom: 14,
                zoomControl: true
            });
            L.tileLayer('https://{s}.title.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
                maxZoom: 19
            }).addTo(map);

            map.on('click', function(e) {
                setCoordinate(e.latlng.lat, e.latlng.lng);
            });

            // If already editing, restore marker right away
            currentLat = parseFloat(document.getElementById('lat-input').value);
            currentLng = parseFloat(document.getElementById('lng-input').value);
            if (currentLat && currentLng && !isNaN(currentLat)) {
                currentRadius = parseInt(document.getElementById('radius-slider').value) || 100;
                setCoordinate(currentLat, currentLng);
            }
        }

        function setCoordinate(lat, lng) {
            currentLat = parseFloat(lat.toFixed(6));
            currentLng = parseFloat(lng.toFixed(6));

            document.getElementById('lat-input').value = currentLat;
            document.getElementById('lng-input').value = currentLng;

            if (marker) map.removeLayer(marker);

            const icon = L.divIcon({
                html: `<div style="background:#2563eb;width:20px;height:20px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(37,99,235,0.5);"></div>`,
                iconSize: [20, 20],
                iconAnchor: [10, 20],
                className: ''
            });
            marker = L.marker([currentLat, currentLng], {
                icon
            }).addTo(map);

            drawRadius();
            document.getElementById('coord-dot').className = 'w-2 h-2 rounded-full bg-green-500';
            document.getElementById('coord-label').textContent = `Koordinat: ${currentLat}, ${currentLng}`;

            // Just pan to don't enforce extreme zoom
            map.panTo([currentLat, currentLng]);
        }

        function drawRadius() {
            if (!currentLat || !currentLng) return;
            if (radiusCircle) map.removeLayer(radiusCircle);
            radiusCircle = L.circle([currentLat, currentLng], {
                radius: currentRadius,
                color: '#3b82f6',
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                weight: 2,
                dashArray: '6 4'
            }).addTo(map);
        }

        function updateRadius(val) {
            currentRadius = parseInt(val);
            document.getElementById('radius-val').textContent = currentRadius + ' meter';
            drawRadius();
        }

        function updateMapFromInput() {
            const lat = parseFloat(document.getElementById('lat-input').value);
            const lng = parseFloat(document.getElementById('lng-input').value);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                setCoordinate(lat, lng);
            }
        }

        function resetCoords() {
            currentLat = null;
            currentLng = null;
            document.getElementById('lat-input').value = '';
            document.getElementById('lng-input').value = '';
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            if (radiusCircle) {
                map.removeLayer(radiusCircle);
                radiusCircle = null;
            }
            document.getElementById('coord-dot').className = 'w-2 h-2 rounded-full bg-gray-300';
            document.getElementById('coord-label').textContent = 'Belum ada titik dipilih';
            if (map) map.setView([DEFAULT_LAT, DEFAULT_LNG], 14);
        }

        function useMyLocation() {
            if (!navigator.geolocation) {
                showToast('Browser tidak mendukung geolokasi', 'error');
                return;
            }
            showToast('Mendeteksi lokasi...', 'info');
            navigator.geolocation.getCurrentPosition(
                pos => {
                    setCoordinate(pos.coords.latitude, pos.coords.longitude);
                    showToast('Lokasi berhasil dideteksi!', 'success');
                },
                err => {
                    showToast('Gagal mendapatkan lokasi', 'error');
                }, {
                    enableHighAccuracy: true
                }
            );
        }

        async function searchLocation() {
            const query = document.getElementById('map-search').value.trim();
            if (!query) return;
            showToast('Mencari lokasi...', 'info');
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&countrycodes=id`);
                const data = await res.json();
                if (data && data.length > 0) {
                    setCoordinate(parseFloat(data[0].lat), parseFloat(data[0].lon));
                    if (!document.getElementById('full-address').value) {
                        document.getElementById('full-address').value = data[0].display_name;
                    }
                    showToast('Lokasi ditemukan!', 'success');
                } else {
                    showToast('Lokasi tidak ditemukan.', 'error');
                }
            } catch (e) {
                showToast('Gagal mencari lokasi.', 'error');
            }
        }

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

        function editClient(clientData) {
            // Restore form fields
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('client-form').action = `/client-locations/${clientData.id}`;

            document.getElementById('client_name').value = clientData.client_name || '';
            document.getElementById('client_code').value = clientData.client_code || '';
            document.getElementById('industry').value = clientData.industry || '';
            document.getElementById('pic_name').value = clientData.pic_name || '';
            document.getElementById('pic_phone').value = clientData.pic_phone || '';
            document.getElementById('pic_email').value = clientData.pic_email || '';
            document.getElementById('is_active').checked = clientData.is_active == 1;

            document.getElementById('building_name').value = clientData.building_name || '';
            document.getElementById('full-address').value = clientData.address || '';
            document.getElementById('city').value = clientData.city || '';
            document.getElementById('province').value = clientData.province || '';
            document.getElementById('postal_code').value = clientData.postal_code || '';
            document.getElementById('floor_unit').value = clientData.floor_unit || '';

            document.getElementById('lat-input').value = clientData.latitude || '';
            document.getElementById('lng-input').value = clientData.longitude || '';
            document.getElementById('radius-slider').value = clientData.attendance_radius_meter || 100;
            document.getElementById('radius-val').textContent = (clientData.attendance_radius_meter || 100) + ' meter';

            document.getElementById('work_start_time').value = clientData.work_start_time || '';
            document.getElementById('work_end_time').value = clientData.work_end_time || '';

            toggleForm(true); // Open the form view
        }
    </script>
</x-app-layout>