<x-app-layout>
<div class="js-datatable-container" data-per-page="10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 fade-in gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">System Users</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Manage who has access to the HRis platform and their roles.</p>
        </div>
        <button data-modal-target="addUserModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center hover-scale">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New User
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6 flex flex-col sm:flex-row gap-4 fade-in" style="animation-delay: 0.1s;">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" class="js-search-input w-full py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-slate-700 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" placeholder="Search by name, email, or username...">
        </div>

        <select class="py-2 px-4 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-slate-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring">
            <option>All Roles</option>
            <option>Admin</option>
            <option>HR Staff</option>
            <option>Employee</option>
        </select>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden fade-in" style="animation-delay: 0.2s;">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left">
                <thead class="bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-gray-400 text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Last Login</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">

                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=80&q=80" class="w-10 h-10 rounded-full object-cover" alt="Avatar">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Admin HRistopher</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs">admin@hris.internal</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium">adminhr</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded border border-purple-200 bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:border-purple-800 dark:text-purple-400 text-xs font-semibold uppercase tracking-wider">
                                Super Admin
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">Just now</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors tooltip" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" class="w-10 h-10 rounded-full object-cover" alt="Avatar">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">John Doe</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs">john.d@hris.internal</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium">johndoe</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded border border-blue-200 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400 text-xs font-semibold uppercase tracking-wider">
                                Employee
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">2 hours ago</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors tooltip" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Pagination Controls Container -->
        <div class="js-pagination-controls"></div>
    </div>

    <!-- Modals -->
    <div id="addUserModal" class="hidden fixed inset-0 z-50 items-center justify-center modal-container">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 modal-overlay" data-modal-close></div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md mx-4 relative z-10 opacity-0 scale-95 transform transition-all duration-300 modal-content border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Add New User</h3>
                <button data-modal-close class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form class="js-simulated-form p-5 space-y-4" data-callback="onCreateUser">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-200 rounded-lg dark:bg-slate-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-200 rounded-lg dark:bg-slate-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                        <input type="text" name="username" required class="w-full px-3 py-2 border border-gray-200 rounded-lg dark:bg-slate-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <select name="role" class="w-full px-3 py-2 border border-gray-200 rounded-lg dark:bg-slate-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="Employee">Employee</option>
                            <option value="HR Staff">HR Staff</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 mt-6">
                    <button type="button" data-modal-close class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium dark:bg-slate-700 dark:text-gray-300 dark:hover:bg-slate-600 transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Save User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Callback when Add User form is simulated
        window.onCreateUser = function(formData) {
            const name = formData.get('name');
            const email = formData.get('email');
            const username = formData.get('username');
            const role = formData.get('role');

            let roleClass = 'border-blue-200 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-400';
            if (role === 'Admin') roleClass = 'border-purple-200 bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:border-purple-800 dark:text-purple-400';

            const newRowHtml = `
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">${name}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">${email}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium">${username}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded border ${roleClass} text-xs font-semibold uppercase tracking-wider">
                            ${role}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center text-green-600 dark:text-green-400 text-sm font-medium">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Active
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">Just now</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="text-gray-400 hover:text-blue-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                        </div>
                    </td>
                </tr>
            `;

            document.querySelector('.js-datatable-container').addNewRow(newRowHtml);
        };
    </script>

</div>
</x-app-layout>