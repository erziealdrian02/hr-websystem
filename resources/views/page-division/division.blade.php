<x-app-layout :title="$title">
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
        <!-- Division Card -->
        @foreach ($divisions as $division)
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5 hover:shadow-md transition duration-300">
            <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($division->division_code) }}&background=random&color=fff"
                    class="w-14 h-14 rounded-full object-cover border-2 border-white dark:border-slate-700"
                    alt="Division Avatar">
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                        {{ $division->name }}
                    </h3>
                    <h5 class="font-semibold text-gray-900 dark:text-white truncate">
                        {{ $division->division_client_location->client_name }}
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $division->employee_count }} Employees
                    </p>
                </div>
                <div class="text-right flex flex-col justify-between items-end">
                    <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/40 px-2 py-1 rounded">
                        {{ $division->division_code }}
                    </p>
                    <div class="flex items-center gap-3 mt-2 text-gray-400">
                        <a href="{{ route('division.edit', $division->id) }}" class="hover:text-amber-500 transition-colors" title="Edit Division">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('division.destroy', $division->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Menghapus divisi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-red-500 transition-colors" title="Delete Division">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-2 tracking-wide">
                    Department Head
                </p>
                <div class="flex items-center gap-3">
                    @if($division->manager_division->profile_photo)
                    <img src="{{ asset('storage/' . $division->manager_division->profile_photo) }}" class="w-9 h-9 rounded-full" alt="Employee">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($division->manager_division->full_name ?? 'N/A') }}&background=random&color=fff&size=200" class="w-9 h-9 rounded-full" alt="Employee">
                    @endif

                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $division->manager_division->full_name ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ $division->manager_division->job_title ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

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