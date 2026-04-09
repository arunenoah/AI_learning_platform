<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LearnHub - Corporate Learning Platform' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            /* Orange Palette */
            --orange-50:  #fff7ed;
            --orange-100: #ffedd5;
            --orange-200: #fed7aa;
            --orange-300: #fdba74;
            --orange-400: #fb923c;
            --orange-500: #f97316;
            --orange-600: #ea580c;
            --orange-700: #c2410c;
            --orange-800: #9a360d;
            --orange-900: #7c2d12;

            /* Warm Dark Sidebar */
            --sidebar-bg:    #1c1917;
            --sidebar-hover: #292524;
            --sidebar-active:#292524;
            --sidebar-text:  #d6d3d1;
            --sidebar-muted: #78716c;
            --sidebar-accent:#f97316;
            --sidebar-border:#2c2826;

            /* Canvas */
            --canvas:      #fafaf8;
            --surface:     #ffffff;
            --surface-2:   #f5f5f2;

            /* Header */
            --header-bg:   #18181b;
            --header-text: #fafafa;

            /* Slate */
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--canvas) !important;
            color: #1c1917;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 15px;
            line-height: 1.6;
        }

        /* ─── LAYOUT ─── */
        .app-layout {
            min-height: calc(100vh - 56px);
        }

        /* ─── MAIN CONTENT ─── */
        .app-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 36px 32px;
        }

        /* ─── TYPOGRAPHY ─── */
        .app-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 26px;
            font-weight: 700;
            color: #1c1917;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
        }

        .app-subtitle {
            font-size: 13.5px;
            color: var(--slate-500);
            font-weight: 400;
            margin-bottom: 0;
        }

        .app-header {
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e8e5e0;
        }

        /* ─── BUTTONS ─── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--orange-600);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease;
        }
        .btn-primary:hover { background: var(--orange-700); color: #fff; }

        /* ─── CARD GRID ─── */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        /* ─── CARD — Editorial style ─── */
        .card {
            background: var(--surface);
            border: 1px solid #e8e5e0;
            border-left: 3px solid transparent;
            border-radius: 6px;
            padding: 18px 20px;
            transition: border-left-color 0.15s ease, box-shadow 0.15s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .card:hover {
            border-left-color: var(--orange-500);
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .card-icon {
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: var(--orange-50);
            border-radius: 6px;
            flex-shrink: 0;
        }

        .card-title {
            font-size: 14.5px;
            font-weight: 600;
            color: #1c1917;
            word-break: break-word;
            line-height: 1.35;
        }

        .card-category {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--orange-600);
            background: var(--orange-50);
            padding: 3px 7px;
            border-radius: 3px;
            letter-spacing: 0.6px;
        }

        .card-description {
            font-size: 13px;
            color: var(--slate-500);
            line-height: 1.5;
            flex: 1;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid #f0ece8;
            font-size: 11.5px;
            color: var(--slate-400);
        }

        /* ─── STAT CARD — Editorial style ─── */
        .stat-card {
            background: var(--surface);
            border: 1px solid #e8e5e0;
            border-radius: 6px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--orange-400);
        }
        .stat-card:hover {
            border-color: #d5cfc8;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-label {
            font-size: 11px;
            color: var(--slate-400);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .stat-value {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 36px;
            font-weight: 700;
            color: #1c1917;
            line-height: 1;
            margin-top: 6px;
            letter-spacing: -0.5px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 6px;
            background: var(--orange-50);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .app-main {
                padding: 20px 16px;
            }
            .app-title {
                font-size: 22px;
            }
            .card-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .card-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['DM Sans', 'sans-serif'],
                        'display': ['Playfair Display', 'Georgia', 'serif'],
                        'mono': ['DM Mono', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                        slate: {
                            850: '#1a2234',
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'card': '0 0 0 1px rgba(0, 0, 0, 0.03), 0 2px 4px rgba(0, 0, 0, 0.05), 0 12px 24px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 0 0 1px rgba(37, 99, 235, 0.1), 0 4px 8px rgba(0, 0, 0, 0.05), 0 20px 40px rgba(0, 0, 0, 0.08)',
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                }
            }
        }
    </script>
</head>
<body class="text-slate-900 antialiased">
    <nav style="background: var(--header-bg); border-bottom: 1px solid #2d2d2d; position: sticky; top: 0; z-index: 50;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded bg-orange-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span style="font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #fafafa;" class="hidden sm:block">LearnHub</span>
                    </a>
                    <div class="hidden md:flex items-center gap-0.5">
                        <a href="{{ route('blogs.index') }}"
                           style="{{ request()->routeIs('blogs.*') ? 'color:#f97316;' : 'color:#a8a29e;' }}"
                           class="px-3 py-2 text-sm font-medium hover:text-white transition-colors">Blogs</a>
                        <a href="@auth{{ route('paths.index') }}@else{{ route('login') }}@endauth"
                           style="{{ request()->routeIs('paths.*') ? 'color:#f97316;' : 'color:#a8a29e;' }}"
                           class="px-3 py-2 text-sm font-medium hover:text-white transition-colors">Paths</a>
                        <a href="@auth{{ route('quizzes.index') }}@else{{ route('login') }}@endauth"
                           style="{{ request()->routeIs('quizzes.*') ? 'color:#f97316;' : 'color:#a8a29e;' }}"
                           class="px-3 py-2 text-sm font-medium hover:text-white transition-colors">Quizzes</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="px-3 py-1.5 text-sm font-medium text-stone-400 hover:text-white transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Get Started
                        </a>
                    @else
                        <div class="hidden sm:flex items-center gap-3">
                            @if(isset($stats['streak']) && ($stats['streak']['current_streak'] ?? 0) > 0)
                                <div class="flex items-center gap-1 px-2.5 py-1 rounded" style="background: rgba(234,88,12,0.15); border: 1px solid rgba(234,88,12,0.3);">
                                    <span style="font-size: 12px;">🔥</span>
                                    <span style="font-size: 13px; font-weight: 700; color: #fb923c;">{{ $stats['streak']['current_streak'] }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center gap-2 p-1 rounded transition-colors" style="background: rgba(255,255,255,0.06);">
                                <div class="w-8 h-8 rounded bg-orange-600 flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <svg class="w-3.5 h-3.5 text-stone-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-56 rounded-lg bg-white shadow-lg border border-slate-200 overflow-hidden">
                                <div class="p-4 border-b border-slate-100">
                                    <p class="font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-slate-500">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile
                                    </a>
                                </div>
                                <div class="p-2 border-t border-slate-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Log out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="app-layout">
        <main class="app-main animate-fade-in">
            @yield('content')
        </main>
    </div>

    <footer style="border-top: 1px solid #2d2d2d; background: var(--header-bg); margin-top: 48px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded bg-orange-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span style="font-family: 'Playfair Display', serif; font-weight: 700; color: #fafafa; font-size: 15px;">LearnHub</span>
                </div>
                <p style="font-size: 12px; color: #78716c;">
                    &copy; {{ date('Y') }} LearnHub. Built with Laravel.
                </p>
            </div>
        </div>
    </footer>

    <script>
        const menuButton = document.getElementById('user-menu-button');
        const menu = document.getElementById('user-menu');
        if (menuButton && menu) {
            menuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!menuButton.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
