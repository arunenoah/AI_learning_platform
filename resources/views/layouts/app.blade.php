<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LearnHub - Corporate Learning Platform' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        'display': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
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
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }
        
        .card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .card-hover {
            transition: all 0.2s ease;
        }
        
        .card-hover:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .btn-primary {
            background: #2563eb;
            transition: all 0.2s ease;
        }
        
        .btn-primary:hover {
            background: #1d4ed8;
        }
        
        .progress-bar {
            background: #2563eb;
        }
        
        .nav-link {
            position: relative;
            transition: color 0.2s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #2563eb;
            transition: all 0.2s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        .nav-link.active {
            color: #2563eb;
        }
    </style>
</head>
<body class="text-slate-900 antialiased">
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-lg bg-primary-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-slate-900 hidden sm:block">LearnHub</span>
                    </a>
                    <div class="hidden md:flex items-center gap-1">
                        <a href="@auth{{ route('dashboard') }}@else{{ route('login') }}@endauth"
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Dashboard
                            </span>
                        </a>
                        <a href="{{ route('resources.index') }}"
                           class="nav-link {{ request()->routeIs('resources.*') ? 'active' : '' }} px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Resources
                            </span>
                        </a>
                        <a href="@auth{{ route('paths.index') }}@else{{ route('login') }}@endauth"
                           class="nav-link {{ request()->routeIs('paths.*') ? 'active' : '' }} px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                Learning Paths
                            </span>
                        </a>
                        <a href="@auth{{ route('quizzes.index') }}@else{{ route('login') }}@endauth"
                           class="nav-link {{ request()->routeIs('quizzes.*') ? 'active' : '' }} px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Quizzes
                            </span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary px-5 py-2.5 rounded-lg text-sm font-semibold text-white">
                            Get Started
                        </a>
                    @else
                        <div class="hidden sm:flex items-center gap-4">
                            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 border border-slate-200">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                                </svg>
                                <span class="text-sm font-bold text-slate-700">{{ number_format(Auth::user()->points) }}</span>
                                <span class="text-xs text-slate-500">pts</span>
                            </div>
                            
                            @if(isset($stats['streak']) && ($stats['streak']['current_streak'] ?? 0) > 0)
                                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-orange-50 border border-orange-200">
                                    <span class="text-sm">🔥</span>
                                    <span class="text-sm font-bold text-orange-600">{{ $stats['streak']['current_streak'] }}</span>
                                    <span class="text-xs text-orange-500">day streak</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100 transition-colors group">
                                <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-64 rounded-xl bg-white shadow-lg border border-slate-200 overflow-hidden">
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
                                    <a href="{{ route('badges') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                        Badges
                                    </a>
                                    <a href="{{ route('leaderboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        Leaderboard
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-900">LearnHub</span>
                </div>
                <p class="text-sm text-slate-500">
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
