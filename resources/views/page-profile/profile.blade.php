<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - HRis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { primary: '#3b82f6' } } }
        }
    </script>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200">
    <div class="flex h-screen overflow-hidden">
        <div id="sidebar-container" class="z-20"></div>
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <div id="navbar-container" class="sticky top-0 z-10 w-full transition-colors duration-300"></div>
            
            <main class="w-full grow p-4 md:p-6 lg:p-8">
                <!-- Cover & Avatar Profile Header -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8 fade-in">
                    <div class="h-40 md:h-56 bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-800 relative">
                        <!-- Cover Edit Button -->
                        <button class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Edit Cover
                        </button>
                    </div>
                    
                    <div class="px-6 pb-6 relative flex flex-col md:flex-row md:items-end gap-6 md:-mt-12">
                        <!-- Avatar -->
                        <div class="relative mx-auto md:mx-0 -mt-16 md:mt-0 z-10">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80" class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white dark:border-slate-800 object-cover shadow-md" alt="Profile">
                            <button class="absolute bottom-2 right-2 bg-blue-600 text-white rounded-full p-2.5 shadow-lg hover:bg-blue-700 transition hover-scale">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                        
                        <!-- Name & Title -->
                        <div class="text-center md:text-left flex-1 mt-2 md:mt-0 pt-2">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin HR</h1>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">HR Manager • HR Department</p>
                            
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-3 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Employee ID: HR-001
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Jakarta Branch
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Joined Jan 2020
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs & Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-in" style="animation-delay: 0.1s;">
                    <!-- Sidebar Tabs -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-2 flex flex-col gap-1">
                            <button class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 transition-colors">
                                Personal Information
                            </button>
                            <button class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                Contact Details
                            </button>
                            <button class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                Account Settings
                            </button>
                            <button class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors mt-4">
                                Logout
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Card 1 -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Basic Information</h2>
                                <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Edit Info</button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">Admin HRistopher</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email Address</label>
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">admin@hris.internal</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Phone Number</label>
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">+62 812-3456-7890</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Date of Birth</label>
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">15 August 1985</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Gender</label>
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">Male</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Work Details</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Department</label>
                                    <p class="text-gray-800 dark:text-gray-200 font-medium">Human Resources</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Direct Manager</label>
                                    <div class="flex items-center mt-1">
                                        <img src="https://ui-avatars.com/api/?name=Director+CEO&background=random" class="w-6 h-6 rounded-full mr-2" alt="avatar">
                                        <p class="text-gray-800 dark:text-gray-200 font-medium">Budi Santoso</p>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Employment Type</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Full-Time Permanent
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </main>
        </div>
    </div>
    <script src="../assets/components.js"></script>
    <script src="../assets/script.js"></script>
</body>
</html>
