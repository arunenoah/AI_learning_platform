<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LearnHub') }}</title>
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
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="text-slate-900 antialiased">
    <div class="min-h-screen flex">
        {{-- Left panel — branding --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="absolute top-0 left-0 w-96 h-96 -translate-x-1/3 -translate-y-1/3" viewBox="0 0 200 200" fill="none">
                    <circle cx="100" cy="100" r="100" fill="white"/>
                </svg>
                <svg class="absolute bottom-0 right-0 w-80 h-80 translate-x-1/4 translate-y-1/4" viewBox="0 0 200 200" fill="none">
                    <circle cx="100" cy="100" r="100" fill="white"/>
                </svg>
            </div>
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">LearnHub</span>
                    </a>
                </div>
                <div class="space-y-8">
                    <h1 class="text-4xl font-extrabold text-white leading-tight">
                        Level up your skills<br>with curated learning paths
                    </h1>
                    <p class="text-lg text-primary-100 leading-relaxed max-w-md">
                        Access hundreds of resources, track your progress, earn badges, and join a community of learners.
                    </p>
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">500+</p>
                            <p class="text-sm text-primary-200">Resources</p>
                        </div>
                        <div class="w-px h-12 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">50+</p>
                            <p class="text-sm text-primary-200">Learning Paths</p>
                        </div>
                        <div class="w-px h-12 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-white">100+</p>
                            <p class="text-sm text-primary-200">Quizzes</p>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-primary-200">&copy; {{ date('Y') }} LearnHub. Built with Laravel.</p>
            </div>
        </div>

        {{-- Right panel — form --}}
        <div class="w-full lg:w-1/2 flex flex-col">
            {{-- Mobile header --}}
            <div class="lg:hidden p-6 border-b border-slate-200">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-lg bg-primary-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-900">LearnHub</span>
                </a>
            </div>

            <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
