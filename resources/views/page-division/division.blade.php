<x-app-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 fade-in">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Organization Divisions</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Company structure and department heads.</p>
        </div>
        <a href="{{ route('division.form') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Division
        </a>
    </div>

    <div class="mb-6 fade-in">
        <input type="text" class="js-search-input w-full md:w-1/3 py-2 px-4 shadow-sm text-sm border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-800 dark:text-white outline-none focus:ring focus:ring-blue-300" placeholder="Search division name or head...">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in js-grid-body" style="animation-delay: 0.1s;">

        <!-- Division Card 1 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Engineering & Tech</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">45 Employees</p>
                </div>
                <div class="bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Alex+Tech&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Alex Tech Lead</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Chief Technology Officer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 2 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Human Resources</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">8 Employees</p>
                </div>
                <div class="bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=80&q=80" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Admin HR</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">HR Director</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Finance & Accounting</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">22 Employees</p>
                </div>
                <div class="bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Lisa+Finance&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Lisa Keuangan</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Chief Financial Officer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 4 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Marketing & Communications</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">30 Employees</p>
                </div>
                <div class="bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Michael Chen</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">VP Marketing</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 5 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Sales & Business Dev</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">55 Employees</p>
                </div>
                <div class="bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Budi Santoso</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">VP Sales</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 6 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Operations & Logistics</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">38 Employees</p>
                </div>
                <div class="bg-teal-100 text-teal-600 dark:bg-teal-900/30 dark:text-teal-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Andi+Ops&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Andi Operasional</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">COO</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 7 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Legal & Compliance</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">12 Employees</p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Dewi+Legal&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dewi Legalitas</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Head of Legal</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 8 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Product Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">15 Employees</p>
                </div>
                <div class="bg-pink-100 text-pink-600 dark:bg-pink-900/30 dark:text-pink-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Rina+PM&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Rina Produk</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">VP Product</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 9 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Customer Support</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">25 Employees</p>
                </div>
                <div class="bg-cyan-100 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Siti+Support&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Siti Layanan</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Head of Customer Success</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 10 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Quality Assurance</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">10 Employees</p>
                </div>
                <div class="bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Rizky+QA&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Rizky QA Lead</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Head of QA</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 11 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">Research & Development</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">18 Employees</p>
                </div>
                <div class="bg-violet-100 text-violet-600 dark:bg-violet-900/30 dark:text-violet-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Dr+Fajar&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dr. Fajar Riset</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Head of R&D</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Division Card 12 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover-scale">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white">General Affairs</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">14 Employees</p>
                </div>
                <div class="bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Department Head</p>
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name=Wawan+GA&background=random" class="w-8 h-8 rounded-full" alt="">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Wawan GA</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Head of General Affairs</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="js-pagination-controls mt-6"></div>

    <!-- Toast -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 text-sm font-medium">
            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="toast-msg">Berhasil!</span>
        </div>
    </div>

    <script>
        function showToast(msg) {
            document.getElementById('toast-msg').textContent = msg;
            const t = document.getElementById('toast');
            t.classList.remove('hidden');
            setTimeout(() => t.classList.add('hidden'), 3000);
        }

        // Just in case we need simulated table update logic
        window.onAddDivision = function(data) {
            // Unused since we moved to form approach
        }
    </script>

</x-app-layout>