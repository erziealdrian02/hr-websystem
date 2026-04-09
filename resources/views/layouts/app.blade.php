<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/styles.css', 'resources/js/script.js', 'resources/js/components.js', 'resources/js/modal.js', 'resources/js/bootstrap.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- TomSelect -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* === Animations === */
        .fade-in {
            opacity: 0;
            transform: translateY(14px);
            animation: fadeInUp 0.4s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        tr.new-row {
            animation: fadeInUp 0.3s ease;
        }

        /* === Toggle Switch === */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #d1d5db;
            border-radius: 24px;
            transition: 0.2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.2s;
        }

        input:checked+.toggle-slider {
            background: #3b82f6;
        }

        input:checked+.toggle-slider::before {
            transform: translateX(20px);
        }

        /* === Form Focus === */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .required::after {
            content: ' *';
            color: #ef4444;
        }

        /* === Cards === */
        .info-card {
            transition: box-shadow 0.2s;
        }

        .info-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .dark .info-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* === Step Indicator (Employee Form) === */
        .step-item {
            position: relative;
        }

        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: calc(50% + 20px);
            width: calc(100% - 40px);
            height: 2px;
            background: #e5e7eb;
        }

        .dark .step-item:not(:last-child)::after {
            background: #374151;
        }

        .step-item.completed:not(:last-child)::after {
            background: #3b82f6;
        }

        /* === Photo Upload === */
        .photo-upload {
            border: 2px dashed #d1d5db;
            transition: all 0.2s ease;
        }

        .photo-upload:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.04);
        }

        .dark .photo-upload {
            border-color: #4b5563;
        }

        .dark .photo-upload:hover {
            border-color: #3b82f6;
        }

        /* === Tabs === */
        .tab-btn.active,
        .tab-active {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
            font-weight: 600;
        }

        .dark .tab-btn.active,
        .dark .tab-active {
            background: rgba(37, 99, 235, 0.15);
            color: #60a5fa;
            border-color: rgba(96, 165, 250, 0.3);
        }

        /* === Progress / Form Sections === */
        #progress-bar {
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeInUp 0.35s ease forwards;
        }

        /* === Badge === */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        /* === Modal === */
        .modal-container {
            display: none;
        }

        .modal-container.flex {
            display: flex;
        }

        /* === Attendance Clock Ring === */
        .clock-ring {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px dashed rgba(59, 130, 246, 0.5);
            border-radius: 50%;
            animation: spin 30s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* === Placement Map === */
        #map {
            height: 360px;
            border-radius: 12px;
            z-index: 1;
        }

        .leaflet-container {
            border-radius: 12px;
        }

        .coord-box {
            background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
            border: 1px solid #bfdbfe;
        }

        .dark .coord-box {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.12) 0%, rgba(5, 150, 105, 0.08) 100%);
            border-color: rgba(96, 165, 250, 0.3);
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #3b82f6;
            animation: pulseDot 2s ease infinite;
        }

        @keyframes pulseDot {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.4);
                opacity: 0.6;
            }
        }

        .radius-ring {
            border: 2px dashed #3b82f6;
            border-radius: 50%;
            position: absolute;
            animation: ringPulse 3s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes ringPulse {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 0.2;
                transform: scale(1.05);
            }
        }

        /* === Range Slider === */
        input[type=range] {
            -webkit-appearance: none;
            height: 4px;
            border-radius: 2px;
            background: #e5e7eb;
            outline: none;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(59, 130, 246, 0.4);
        }

        .dark input[type=range] {
            background: #374151;
        }

        /* === Number Input - No Arrows === */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        /* === TomSelect Custom Styles === */
        .ts-wrapper .ts-control {
            border-radius: 0.5rem !important;
            padding: 0.5rem 0.75rem !important;
            border-color: #e5e7eb !important;
            background-color: #f9fafb !important;
            font-size: 0.875rem !important;
            color: #111827 !important;
            box-shadow: none !important;
            position: relative;
        }

        .ts-wrapper.has-icon .ts-control {
            padding-left: 2.25rem !important;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            position: relative;
        }

        .dark .ts-wrapper .ts-control {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #f1f5f9 !important;
        }

        /* Target the search input specifically */
        .ts-wrapper .ts-control>input {
            color: inherit !important;
            font-size: inherit !important;
        }

        .dark .ts-wrapper .ts-control>input {
            color: #f1f5f9 !important;
        }

        .ts-dropdown {
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            margin-top: 4px !important;
            z-index: 9999 !important;
        }

        .dark .ts-dropdown {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        .ts-dropdown .option {
            color: inherit !important;
        }

        .ts-dropdown .active {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }

        .dark .ts-dropdown .active {
            background-color: #3b82f6 !important;
            color: white !important;
        }

        .ts-dropdown .optgroup-header {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
            padding: 0.5rem 0.75rem !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            @include('layouts.header')

            <!-- Page Content -->
            <main class="w-full grow p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @foreach (['success', 'error', 'warning', 'info'] as $type)
    @if(session($type))
    <div class="hidden js-toast-trigger" data-message="{{ session($type) }}" data-type="{{ $type }}"></div>
    @endif
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelectorAll('.js-toast-trigger').forEach(el => {
                    if (typeof window.showToast === 'function') {
                        const type = el.dataset.type;
                        const isError = type !== 'success' && type !== 'info';
                        const title = type.charAt(0).toUpperCase() + type.slice(1);
                        window.showToast(title, el.dataset.message, isError);
                    }
                });
            }, 600); // Wait for modal.js script to init
        });
    </script>
</body>

</html>