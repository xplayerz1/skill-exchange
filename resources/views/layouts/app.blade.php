<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Skill Exchange')</title>
    
    {{-- Favicon --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%230A66C2' width='100' height='100' rx='20'/><path stroke='white' stroke-width='8' stroke-linecap='round' stroke-linejoin='round' fill='none' d='M30 35h40m0 0l-8-8m8 8l-8 8m-2 12H30m0 0l8 8m-8-8l8-8'/></svg>">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Alpine.js for sidebar collapse --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Google Fonts - Inter (Professional LinkedIn-style font) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    {{-- LinkedIn-inspired color scheme --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'linkedin-blue': '#0A66C2',
                        'linkedin-hover': '#004182',
                        'linkedin-light': '#EDF3F8',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Flash messages */
        .flash-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            min-width: 300px;
            max-width: 90%;
            text-align: center;
            opacity: 1;
            transition: opacity 0.5s ease-out;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .flash-alert.fade-out {
            opacity: 0;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    @auth
        {{-- Sidebar Layout --}}
        <x-sidebar>
            {{-- Flash Messages --}}
            @if(session('success'))
                <div id="flash-message" class="flash-alert bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div id="flash-message" class="flash-alert bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Main Content --}}
            <main class="p-6">
                @yield('content')
            </main>
        </x-sidebar>
    @else
        {{-- Guest Layout (Login/Register pages) --}}
        <main>
            @yield('content')
        </main>
    @endauth

    {{-- Flash message auto-hide script --}}
    <script>
        // Auto-hide flash messages after 5 seconds
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.classList.add('fade-out');
                setTimeout(() => flashMessage.remove(), 500);
            }, 5000);
        }
    </script>

    @stack('scripts')
</body>
</html>