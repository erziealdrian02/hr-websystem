<x-app-layout>
<div class="js-datatable-container" data-per-page="10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 fade-in gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Active Employees</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage and view all employee records across the organization.</p>
        </div>
        <div class="flex gap-2">
            <button class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export
            </button>
            <a href="{{ route('employees.form') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Employee
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6 flex flex-col md:flex-row gap-4 fade-in" style="animation-delay: 0.1s;">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" class="js-search-input w-full py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-slate-700 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" placeholder="Search by name, ID, or department...">
        </div>
    </div>

    <!-- Employee Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 fade-in js-grid-body" style="animation-delay: 0.2s;">
        <!-- Employee Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Sarah Williams</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Senior Frontend Dev</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-1025</div>
                    <div class="flex items-center justify-center gap-1">Engineering</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-green-500 to-teal-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Michael Chen</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Marketing Director</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0842</div>
                    <div class="flex items-center justify-center gap-1">Marketing</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-purple-500 to-pink-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Budi Santoso</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Sales Manager</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0512</div>
                    <div class="flex items-center justify-center gap-1">Sales</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 4 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-orange-500 to-red-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Lisa+Keuangan&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Lisa Keuangan</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Finance Lead</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0398</div>
                    <div class="flex items-center justify-center gap-1">Finance</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 5 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-cyan-500 to-blue-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Ahmad Fauzi</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Backend Developer</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0756</div>
                    <div class="flex items-center justify-center gap-1">Engineering</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 6 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-indigo-500 to-violet-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Rina+Wati&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Rina Wati</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">UI/UX Designer</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0890</div>
                    <div class="flex items-center justify-center gap-1">Engineering</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 7 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-emerald-500 to-green-600 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Dewi+Legal&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Dewi Legalitas</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Legal Counsel</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0245</div>
                    <div class="flex items-center justify-center gap-1">Legal</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 8 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-rose-500 to-pink-600 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Siti+Layanan&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Siti Layanan</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Customer Success Lead</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0901</div>
                    <div class="flex items-center justify-center gap-1">Support</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 9 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-amber-500 to-orange-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Hendra+G&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Hendra Gunawan</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Project Manager</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0634</div>
                    <div class="flex items-center justify-center gap-1">Engineering</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 10 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-teal-400 to-cyan-500 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Putri+Ayu&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Putri Ayu</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Data Analyst</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0950</div>
                    <div class="flex items-center justify-center gap-1">Engineering</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 11 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-slate-500 to-gray-600 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Wawan+GA&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Wawan GA</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">General Affairs Manager</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0123</div>
                    <div class="flex items-center justify-center gap-1">General Affairs</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>

        <!-- Employee Card 12 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
            <div class="h-24 bg-gradient-to-r from-fuchsia-500 to-purple-600 relative"></div>
            <div class="px-6 pb-6 relative -mt-12 text-center">
                <img src="https://ui-avatars.com/api/?name=Dr+Fajar&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover" alt="Employee">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">Dr. Fajar Riset</h3>
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">R&D Lead</p>
                <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center justify-center gap-1">EMP-0077</div>
                    <div class="flex items-center justify-center gap-1">R&D</div>
                </div>
                <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 py-2 rounded-lg font-medium text-sm transition-colors dark:bg-blue-900/30 dark:hover:bg-blue-900/50">View Full Profile</a>
            </div>
        </div>
    </div>

    <!-- Pagination Placeholder -->
    <div class="js-pagination-controls mt-6"></div>

    <!-- Modals -->
    <div id="addEmployeeModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-2xl mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Register New Employee</h3>
                <button data-modal-close class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="max-h-[70vh] overflow-y-auto">
                <form class="js-simulated-form p-5 space-y-5" data-callback="onCreateEmployee">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring focus:ring-blue-300 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee ID (NIK)</label>
                            <input type="text" name="empId" value="EMP-1026" class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white bg-gray-50 focus:ring outline-none" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Title</label>
                            <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                            <select name="dept" required class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-slate-700 dark:text-white focus:ring outline-none">
                                <option>Engineering</option>
                                <option>Marketing</option>
                                <option>HR</option>
                                <option>Finance</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6 mt-4">
                        <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 dark:bg-slate-700 dark:text-gray-300 hover:bg-gray-200 rounded-lg font-medium transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Register Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form callback implementation
        window.onCreateEmployee = function(formData) {
            const name = formData.get('name');
            const title = formData.get('title');
            const dept = formData.get('dept');
            const empId = formData.get('empId');

            const html = `
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden hover:shadow-md transition-shadow hover-scale group">
                    <div class="h-24 bg-gradient-to-r from-purple-500 to-pink-500 relative"></div>
                    <div class="px-6 pb-6 relative -mt-12 text-center">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&size=200" class="w-24 h-24 mx-auto rounded-full border-4 border-white dark:border-slate-800 object-cover">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-3">${name}</h3>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">${title}</p>
                        <div class="mt-4 flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
                            <div>${empId}</div>
                            <div>${dept}</div>
                        </div>
                        <a href="{{ route('employees.detail') }}" class="mt-5 block w-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 py-2 rounded-lg font-medium text-sm transition-colors">View Full Profile</a>
                    </div>
                </div>
            `;

            document.querySelector('.js-datatable-container').addNewRow(html);
        };
    </script>
</div>
</x-app-layout>