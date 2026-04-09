<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LearnHub') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                            50:  '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --orange-50:  #fff7ed;
            --orange-100: #ffedd5;
            --orange-400: #fb923c;
            --orange-500: #f97316;
            --orange-600: #ea580c;
            --orange-700: #c2410c;
            --canvas: #fafaf8;
            --surface: #ffffff;
            --header-bg: #18181b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--canvas);
            color: #1c1917;
            min-height: 100vh;
        }
        .input-field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1c1917;
            background: #fff;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            outline: none;
        }
        .input-field:focus {
            border-color: var(--orange-500);
            box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
        }
        .input-field::placeholder { color: #94a3b8; }
        .input-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .btn-submit {
            width: 100%;
            padding: 11px 16px;
            background: var(--orange-600);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .btn-submit:hover { background: var(--orange-700); }
        .form-error {
            font-size: 12.5px;
            color: #dc2626;
            margin-top: 5px;
        }
        .left-panel {
            background: var(--header-bg);
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--orange-500);
        }
        .stat-chip {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 14px 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="min-height: 100vh; display: flex;">

        {{-- Left panel — branding --}}
        <div class="left-panel hidden lg:flex lg:w-[45%] flex-col justify-between p-12">
            {{-- Logo --}}
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
                <div style="width: 36px; height: 36px; background: var(--orange-600); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span style="font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: #fafafa;">LearnHub</span>
            </a>

            {{-- Main copy --}}
            <div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; color: var(--orange-400); margin-bottom: 16px;">Your Learning Platform</p>
                <h1 style="font-family: 'Playfair Display', serif; font-size: 38px; font-weight: 700; color: #fafafa; line-height: 1.2; margin-bottom: 20px;">
                    Level up your skills<br>with curated paths
                </h1>
                <p style="font-size: 15px; color: #a8a29e; line-height: 1.7; max-width: 380px; margin-bottom: 36px;">
                    Access hundreds of resources, track your progress, earn badges, and join a community of learners.
                </p>

                {{-- Stats --}}
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    <div class="stat-chip">
                        <p style="font-family: 'DM Mono', monospace; font-size: 26px; font-weight: 700; color: #fafafa; line-height: 1;">{{ \App\Models\Resource::active()->count() }}</p>
                        <p style="font-size: 11px; color: #78716c; margin-top: 4px; font-weight: 500;">Resources</p>
                    </div>
                    <div class="stat-chip">
                        <p style="font-family: 'DM Mono', monospace; font-size: 26px; font-weight: 700; color: #fafafa; line-height: 1;">{{ \App\Models\LearningPath::count() }}</p>
                        <p style="font-size: 11px; color: #78716c; margin-top: 4px; font-weight: 500;">Paths</p>
                    </div>
                    <div class="stat-chip">
                        <p style="font-family: 'DM Mono', monospace; font-size: 26px; font-weight: 700; color: #fafafa; line-height: 1;">{{ \App\Models\Quiz::count() }}</p>
                        <p style="font-size: 11px; color: #78716c; margin-top: 4px; font-weight: 500;">Quizzes</p>
                    </div>
                </div>
            </div>

            <p style="font-size: 12px; color: #44403c;">&copy; {{ date('Y') }} LearnHub. Built with Laravel.</p>
        </div>

        {{-- Right panel — form --}}
        <div style="flex: 1; display: flex; flex-direction: column; background: var(--canvas);">
            {{-- Mobile logo --}}
            <div class="lg:hidden" style="padding: 20px 24px; border-bottom: 1px solid #e8e5e0; background: var(--header-bg);">
                <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                    <div style="width: 32px; height: 32px; background: var(--orange-600); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 18px; height: 18px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span style="font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: #fafafa;">LearnHub</span>
                </a>
            </div>

            <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 24px;">
                <div style="width: 100%; max-width: 420px; background: #fff; border: 1px solid #e8e5e0; border-radius: 12px; padding: 36px; box-shadow: 0 4px 24px rgba(0,0,0,0.05);">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
