<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Too Many Requests - LearnHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-white text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-6 text-center">
        <div class="w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-slate-900 mb-3">Too many requests</h1>
        <p class="text-lg text-slate-500 max-w-md mb-8">
            You've made too many attempts. Please wait a moment before trying again.
        </p>
        @if(isset($exception) && $exception->getHeaders()['Retry-After'] ?? null)
            <p class="text-sm text-slate-400 mb-6">
                Try again in <span class="font-semibold text-slate-600">{{ ceil($exception->getHeaders()['Retry-After'] / 60) }}</span> minute(s).
            </p>
        @endif
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}"
               class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg transition">
                Go back
            </a>
            <a href="{{ url('/') }}"
               class="px-5 py-2.5 text-sm font-semibold text-white bg-primary-600 hover:bg-primary-700 rounded-lg transition">
                Home
            </a>
        </div>
        <div class="mt-12 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <span class="font-bold text-slate-900">LearnHub</span>
        </div>
    </div>
</body>
</html>
