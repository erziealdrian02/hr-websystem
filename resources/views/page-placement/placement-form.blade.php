<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 350px;
            width: 100%;
            border-radius: 0.5rem;
            z-index: 0;
        }
    </style>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <a href="placement.html"
                class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Placement
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Lokasi Klien</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftarkan lokasi tempat penempatan
                karyawan outsource</p>
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
                Simpan Lokasi
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- LEFT: Form -->
        <div class="space-y-6">

            <!-- Identitas Klien -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.05s">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Identitas Klien / Perusahaan
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Nama
                            Perusahaan / Klien</label>
                        <input type="text" id="client-name"
                            placeholder="e.g. CNBC Indonesia, Bank Mandiri"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Kode
                                Klien</label>
                            <input type="text" placeholder="e.g. CNBC-01"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition uppercase">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Industri</label>
                            <select
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
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
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Nama
                                PIC Klien</label>
                            <input type="text" placeholder="Nama penanggung jawab"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">No.
                                Telp PIC</label>
                            <input type="tel" placeholder="+62 8xx"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Email
                            PIC</label>
                        <input type="email" placeholder="pic@perusahaan.com"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Status Aktif</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Lokasi tersedia untuk
                                penempatan</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.1s">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Alamat Lokasi
                </h3>
                <div class="space-y-4">
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Nama
                            Gedung / Lokasi</label>
                        <input type="text" id="building-name"
                            placeholder="e.g. Gedung Trans Media, Menara Mandiri"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Alamat
                            Lengkap</label>
                        <textarea id="full-address" rows="2" placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan"
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Kota</label>
                            <input type="text" id="city" placeholder="e.g. Jakarta Pusat"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Provinsi</label>
                            <select id="province"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
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
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Kode
                                Pos</label>
                            <input type="text" maxlength="5" placeholder="10110"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Lantai
                                / Unit</label>
                            <input type="text" placeholder="e.g. Lt. 5, Unit B"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT: Map + Koordinat -->
        <div class="space-y-6">

            <!-- Map -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.1s">
                <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Koordinat GPS
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Klik pada peta untuk menentukan
                    titik lokasi absensi</p>

                <!-- Search on map -->
                <div class="relative mb-3">
                    <input type="text" id="map-search"
                        placeholder="Cari lokasi di peta (ketik lalu Enter)..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition"
                        onkeydown="if(event.key==='Enter') searchLocation()">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <button onclick="searchLocation()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700 transition">Cari</button>
                </div>

                <!-- Map container -->
                <div id="map" class="border border-gray-200 dark:border-gray-600"></div>

                <!-- Tip -->
                <div class="flex items-center gap-2 mt-3">
                    <div class="pulse-dot flex-shrink-0"></div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Klik di mana saja pada peta untuk
                        mengubah titik koordinat. Atau gunakan tombol "Lokasi Saya" untuk mengisi otomatis.
                    </p>
                </div>
            </div>

            <!-- Koordinat hasil -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.15s">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3l14 9-14 9V3z" />
                    </svg>
                    Koordinat & Radius Absensi
                </h3>

                <!-- Coordinate display -->
                <div class="coord-box rounded-xl p-4 mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Latitude</label>
                            <input type="number" id="lat-input" step="0.000001" placeholder="-6.200000"
                                oninput="updateMapFromInput()"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-blue-200 dark:border-blue-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5 required">Longitude</label>
                            <input type="number" id="lng-input" step="0.000001"
                                placeholder="106.816666" oninput="updateMapFromInput()"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-blue-200 dark:border-blue-700 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition font-mono">
                        </div>
                    </div>

                    <!-- Accuracy indicator -->
                    <div class="flex items-center gap-2 mt-3" id="coord-status">
                        <div class="w-2 h-2 rounded-full bg-gray-300" id="coord-dot"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400" id="coord-label">Belum ada
                            titik dipilih</span>
                    </div>
                </div>

                <!-- Radius for attendance -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label
                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Radius
                            Absensi</label>
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400"
                            id="radius-val">100 meter</span>
                    </div>
                    <input type="range" id="radius-slider" min="50" max="500"
                        step="10" value="100" oninput="updateRadius(this.value)" class="w-full">
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span>50m</span>
                        <span>200m</span>
                        <span>500m</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Karyawan hanya bisa absen
                        dalam radius ini dari titik koordinat</p>
                </div>

                <!-- Tombol aksi -->
                <div class="flex gap-2 flex-wrap">
                    <button onclick="useMyLocation()"
                        class="flex items-center gap-2 px-3 py-2 text-xs font-medium bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800/40 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lokasi Saya
                    </button>
                    <button onclick="copyCoords()"
                        class="flex items-center gap-2 px-3 py-2 text-xs font-medium bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin Koordinat
                    </button>
                    <button onclick="resetCoords()"
                        class="flex items-center gap-2 px-3 py-2 text-xs font-medium bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/30 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>

            <!-- Jadwal Kerja -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 info-card fade-in"
                style="animation-delay:0.2s">
                <h3
                    class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Jam Kerja Lokasi
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Jam
                                Masuk</label>
                            <input type="time" value="08:00"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Jam
                                Pulang</label>
                            <input type="time" value="17:00"
                                class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:border-blue-500 transition">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Hari
                            Kerja</label>
                        <div class="flex gap-2 flex-wrap">
                            <label class="day-check cursor-pointer" for="day-mon">
                                <input type="checkbox" id="day-mon" checked class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Sen</span>
                            </label>
                            <label class="day-check cursor-pointer" for="day-tue">
                                <input type="checkbox" id="day-tue" checked class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Sel</span>
                            </label>
                            <label class="day-check cursor-pointer" for="day-wed">
                                <input type="checkbox" id="day-wed" checked class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Rab</span>
                            </label>
                            <label class="day-check cursor-pointer" for="day-thu">
                                <input type="checkbox" id="day-thu" checked class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Kam</span>
                            </label>
                            <label class="day-check cursor-pointer" for="day-fri">
                                <input type="checkbox" id="day-fri" checked class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Jum</span>
                            </label>
                            <label class="day-check cursor-pointer" for="day-sat">
                                <input type="checkbox" id="day-sat" class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Sab</span>
                            </label>
                            <label class="day-check cursor-pointer" for="day-sun">
                                <input type="checkbox" id="day-sun" class="hidden peer">
                                <span
                                    class="block px-3 py-1.5 rounded-lg text-xs font-semibold border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-500 dark:text-gray-400 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition">Min</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1.5">Catatan
                            Tambahan</label>
                        <textarea rows="2" placeholder="Dress code, akses parkir, prosedur khusus, dll."
                            class="w-full px-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:border-blue-500 transition resize-none"></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Submit Row -->
    <div class="flex justify-end gap-3 mt-6 fade-in" style="animation-delay:0.25s">
        <a href="placement.html"
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
            Simpan Lokasi Klien
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
        let map, marker, radiusCircle;
        let currentLat = null,
            currentLng = null;
        let currentRadius = 100;

        // Default center: Jakarta
        const DEFAULT_LAT = -6.2088;
        const DEFAULT_LNG = 106.8456;

        function initMap() {
            map = L.map('map', {
                center: [DEFAULT_LAT, DEFAULT_LNG],
                zoom: 14,
                zoomControl: true
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Click on map to set marker
            map.on('click', function(e) {
                setCoordinate(e.latlng.lat, e.latlng.lng);
            });
        }

        function setCoordinate(lat, lng) {
            currentLat = parseFloat(lat.toFixed(6));
            currentLng = parseFloat(lng.toFixed(6));

            // Update inputs
            document.getElementById('lat-input').value = currentLat;
            document.getElementById('lng-input').value = currentLng;

            // Remove old marker
            if (marker) map.removeLayer(marker);

            // Custom icon
            const icon = L.divIcon({
                html: `<div style="background:#2563eb;width:20px;height:20px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(37,99,235,0.5);"></div>`,
                iconSize: [20, 20],
                iconAnchor: [10, 20],
                className: ''
            });
            marker = L.marker([currentLat, currentLng], {
                icon
            }).addTo(map);
            marker.bindPopup(`<b>Titik Absensi</b><br>${currentLat}, ${currentLng}`).openPopup();

            // Draw radius circle
            drawRadius();

            // Update status
            document.getElementById('coord-dot').className = 'w-2 h-2 rounded-full bg-green-500';
            document.getElementById('coord-label').textContent = `Koordinat dipilih: ${currentLat}, ${currentLng}`;

            map.setView([currentLat, currentLng], 16);
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
                    showToast('Gagal mendapatkan lokasi: ' + err.message, 'error');
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
                const res = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&countrycodes=id`
                );
                const data = await res.json();
                if (data && data.length > 0) {
                    const {
                        lat,
                        lon,
                        display_name
                    } = data[0];
                    setCoordinate(parseFloat(lat), parseFloat(lon));
                    // Auto-fill address if empty
                    if (!document.getElementById('full-address').value) {
                        document.getElementById('full-address').value = display_name;
                    }
                    showToast('Lokasi ditemukan!', 'success');
                } else {
                    showToast('Lokasi tidak ditemukan. Coba kata kunci lain.', 'error');
                }
            } catch (e) {
                showToast('Gagal mencari lokasi. Cek koneksi internet.', 'error');
            }
        }

        function copyCoords() {
            if (!currentLat || !currentLng) {
                showToast('Belum ada koordinat dipilih', 'error');
                return;
            }
            const text = `${currentLat}, ${currentLng}`;
            navigator.clipboard.writeText(text).then(() => showToast('Koordinat disalin: ' + text, 'success'));
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
            map.setView([DEFAULT_LAT, DEFAULT_LNG], 14);
            showToast('Koordinat direset', 'info');
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

        function saveDraft() {
            showToast('Draft disimpan!', 'success');
        }

        function submitForm() {
            if (!currentLat || !currentLng) {
                showToast('Pilih koordinat lokasi terlebih dahulu!', 'error');
                document.getElementById('map').scrollIntoView({
                    behavior: 'smooth'
                });
                return;
            }
            if (!document.getElementById('client-name').value) {
                showToast('Nama klien wajib diisi!', 'error');
                return;
            }
            showToast('Lokasi klien berhasil disimpan! ✓', 'success');
        }

        // Init on load
        window.addEventListener('load', function() {
            initMap();
        });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</x-app-layout>