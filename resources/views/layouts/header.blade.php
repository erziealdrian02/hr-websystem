<header class="bg-white border-b border-gray-200 dark:bg-slate-900 dark:border-gray-700 shadow-sm z-10 w-full transition-colors duration-300">
    <div class="px-4 py-3 mx-auto flex justify-between items-center w-full">
        <div class="flex items-center gap-4">
            <button id="sidebar-toggle-header" class="md:hidden text-gray-500 bg-gray-100 hover:bg-gray-200 dark:text-gray-400 dark:bg-slate-800 p-2 rounded-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="hidden sm:flex items-center">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <input type="text" class="w-full py-2 pl-10 pr-4 text-gray-700 bg-gray-50 border border-gray-100 rounded-lg dark:bg-slate-800 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" placeholder="Search employees, documents...">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="text-gray-500 bg-gray-100 hover:bg-gray-200 dark:text-gray-400 dark:bg-slate-800 dark:hover:bg-slate-700 p-2 rounded-full transition-colors">
                <!-- Sun Icon -->
                <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <!-- Moon Icon -->
                <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>

            <!-- Notifications -->
            <button class="relative text-gray-500 bg-gray-100 hover:bg-gray-200 dark:text-gray-400 dark:bg-slate-800 dark:hover:bg-slate-700 p-2 rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- Profile -->
            <div class="relative x-dropdown">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-slate-800 p-1 pr-2 rounded-full transition-colors cursor-pointer border-none focus:outline-none">
                            <img class="object-cover w-8 h-8 rounded-full border border-gray-200 dark:border-gray-700" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=80&q=80" alt="Avatar">
                            <div class="hidden sm:block text-left text-sm">
                                <p class="font-semibold text-gray-700 dark:text-gray-200 leading-tight">Harusnya nama</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Admin</p>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>