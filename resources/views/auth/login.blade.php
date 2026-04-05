<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — {{ config('app.name', 'HRis') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
        }

        /* ===================== BASE ===================== */
        body {
            background: #ffffff;
            transition: background 0.3s ease, color 0.3s ease;
        }

        html.dark body {
            background: #0f172a;
        }

        /* ===================== PAGE WRAPPER ===================== */
        .login-page {
            min-height: 100vh;
            width: 100%;
            display: flex;
            position: relative;
        }

        /* ===================== ABSTRACT IMAGE ===================== */
        /* Light: colorful waves, fades to white on left */
        /* Dark:  dark navy waves, fades to #0f172a on left */
        .login-abstract {
            position: fixed;
            top: 0;
            right: 0;
            width: 65%;
            height: 100%;
            background-image: url('/assets/login-bg.png');
            background-size: cover;
            background-position: left center;
            -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.25) 12%, rgba(0,0,0,0.8) 32%, #000 55%);
            mask-image:         linear-gradient(to right, transparent 0%, rgba(0,0,0,0.25) 12%, rgba(0,0,0,0.8) 32%, #000 55%);
            z-index: 0;
            transition: background-image 0.4s ease, opacity 0.4s ease;
        }

        /* Dark mode: swap image + adjust mask to fade to dark bg */
        html.dark .login-abstract {
            background-image: url('/assets/login-bg-dark.png');
            -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.2) 10%, rgba(0,0,0,0.75) 30%, #000 52%);
            mask-image:         linear-gradient(to right, transparent 0%, rgba(0,0,0,0.2) 10%, rgba(0,0,0,0.75) 30%, #000 52%);
        }

        @media (max-width: 900px) {
            .login-abstract { display: none; }
        }

        /* ===================== FORM SIDE ===================== */
        .login-form-side {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 52px;
            background: transparent;
        }

        @media (max-width: 900px) {
            .login-form-side {
                max-width: 100%;
                padding: 48px 32px;
                align-items: center;
            }
            .login-form-inner { width: 100%; max-width: 400px; }
        }

        /* ===================== THEME TOGGLE ===================== */
        .theme-toggle-btn {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 100;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
            color: #475569;
        }

        .theme-toggle-btn:hover {
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            transform: scale(1.05);
            color: #1e293b;
        }

        html.dark .theme-toggle-btn {
            background: rgba(30, 41, 59, 0.85);
            color: #94a3b8;
            box-shadow: 0 2px 12px rgba(0,0,0,0.5);
        }

        html.dark .theme-toggle-btn:hover {
            background: #1e293b;
            color: #e2e8f0;
        }

        /* Sun shown in dark mode, Moon shown in light mode */
        .icon-sun  { display: none; }
        .icon-moon { display: block; }

        html.dark .icon-sun  { display: block; }
        html.dark .icon-moon { display: none; }

        /* ===================== LOGO ===================== */
        .login-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 52px;
        }

        .login-logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            color: white;
            box-shadow: 0 4px 12px rgba(59,130,246,0.4);
            flex-shrink: 0;
        }

        .login-logo-text {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            transition: color 0.3s;
        }

        html.dark .login-logo-text { color: #f1f5f9; }

        /* ===================== HEADINGS ===================== */
        .login-heading {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.15;
            margin-bottom: 8px;
            transition: color 0.3s;
        }

        html.dark .login-heading { color: #f1f5f9; }

        .login-subheading {
            font-size: 0.9rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 36px;
            transition: color 0.3s;
        }

        html.dark .login-subheading { color: #94a3b8; }

        /* ===================== SESSION STATUS ===================== */
        .session-status {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.875rem;
            margin-bottom: 18px;
        }

        html.dark .session-status {
            background: rgba(37,99,235,0.15);
            border-color: rgba(96,165,250,0.3);
            color: #93c5fd;
        }

        /* ===================== FORM ELEMENTS ===================== */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: #475569;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            margin-bottom: 7px;
            transition: color 0.3s;
        }

        html.dark .form-label { color: #94a3b8; }

        .input-wrapper { position: relative; }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            display: flex;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            outline: none;
            transition: all 0.2s ease;
            -webkit-appearance: none;
        }

        html.dark .form-input {
            color: #e2e8f0;
            background: #1e293b;
            border-color: #334155;
        }

        .form-input:focus {
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        html.dark .form-input:focus {
            background: #1e293b;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
        }

        .form-input::placeholder { color: #94a3b8; }
        html.dark .form-input::placeholder { color: #475569; }

        .input-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            display: flex;
            padding: 0;
            transition: color 0.2s;
        }

        .input-toggle:hover { color: #3b82f6; }

        .form-error {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 5px;
        }

        /* ===================== BOTTOM ROW ===================== */
        .form-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 24px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #3b82f6;
            cursor: pointer;
        }

        .remember-label span {
            font-size: 0.85rem;
            color: #475569;
            font-weight: 500;
            transition: color 0.3s;
        }

        html.dark .remember-label span { color: #94a3b8; }

        .forgot-link {
            font-size: 0.85rem;
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: #1d4ed8; }
        html.dark .forgot-link:hover { color: #60a5fa; }

        /* ===================== BUTTON ===================== */
        .btn-login {
            width: 100%;
            padding: 13px 20px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(37,99,235,0.35);
            transition: all 0.25s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 6px 22px rgba(37,99,235,0.45);
            transform: translateY(-1px);
        }

        .btn-login:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
        .btn-login:disabled { opacity: 0.75; cursor: not-allowed; transform: none; }

        /* ===================== FOOTER ===================== */
        .login-footer {
            margin-top: 36px;
            font-size: 0.75rem;
            color: #94a3b8;
            line-height: 1.6;
            transition: color 0.3s;
        }

        html.dark .login-footer { color: #475569; }

        /* ===================== DIVIDER ===================== */
        .theme-divider {
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
            margin-bottom: 28px;
        }

        /* ===================== ANIMATIONS ===================== */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-form-inner {
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .spin { animation: spin 0.8s linear infinite; }
    </style>
</head>

<body>
    <div class="login-page">

        <!-- Abstract image — right side, merges into bg -->
        <div class="login-abstract" aria-hidden="true"></div>

        <!-- Theme toggle button — top right -->
        <button id="theme-toggle" class="theme-toggle-btn" aria-label="Toggle theme">
            <!-- Sun (visible in dark mode) -->
            <svg class="icon-sun" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <!-- Moon (visible in light mode) -->
            <svg class="icon-moon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        <!-- Form side — left -->
        <div class="login-form-side">
            <div class="login-form-inner">

                <!-- Logo (same as sidebar) -->
                <div class="login-logo">
                    <div class="login-logo-icon">H</div>
                    <span class="login-logo-text">HRis.</span>
                </div>

                <!-- Accent divider -->
                <div class="theme-divider"></div>

                <!-- Heading -->
                <h1 class="login-heading">Selamat Datang!</h1>
                <p class="login-subheading">Masuk ke akun HRis Anda untuk melanjutkan ke dashboard.</p>

                <!-- Session Status -->
                @if(session('status'))
                    <div class="session-status">{{ session('status') }}</div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input
                                id="email"
                                class="form-input"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="contoh@perusahaan.com"
                                required
                                autofocus
                                autocomplete="username"
                            >
                        </div>
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                id="password"
                                class="form-input"
                                type="password"
                                name="password"
                                placeholder="Masukkan password Anda"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="input-toggle" id="toggle-password" aria-label="Toggle password">
                                <svg id="eye-show" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-hide" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="form-bottom-row">
                        <label class="remember-label" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-login" id="login-btn">
                        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk ke Dashboard
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    &copy; {{ date('Y') }} HRis &mdash; Human Resource Information System. Hak cipta dilindungi.
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============================================================
        // THEME — Re-use the same localStorage key & logic as script.js
        // Apply theme ASAP before paint to prevent flash
        // ============================================================
        (function() {
            const html = document.documentElement;
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }
        })();

        // Theme toggle button — same logic as script.js toggleTheme()
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // ============================================================
        // PASSWORD TOGGLE
        // ============================================================
        const toggleBtn = document.getElementById('toggle-password');
        const passInput = document.getElementById('password');
        const eyeShow   = document.getElementById('eye-show');
        const eyeHide   = document.getElementById('eye-hide');

        toggleBtn.addEventListener('click', () => {
            const visible = passInput.type === 'text';
            passInput.type     = visible ? 'password' : 'text';
            eyeShow.style.display = visible ? 'block' : 'none';
            eyeHide.style.display = visible ? 'none'  : 'block';
        });

        // ============================================================
        // SUBMIT LOADING STATE
        // ============================================================
        const form     = document.getElementById('login-form');
        const loginBtn = document.getElementById('login-btn');

        form.addEventListener('submit', () => {
            loginBtn.disabled = true;
            loginBtn.innerHTML = `
                <svg class="spin" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Memproses...
            `;
        });
    </script>
</body>

</html>
