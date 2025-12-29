<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillExchange - Campus Skill Exchange Platform</title>
    
    {{-- Favicon --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%230A66C2' width='100' height='100' rx='20'/><path stroke='white' stroke-width='8' stroke-linecap='round' stroke-linejoin='round' fill='none' d='M30 35h40m0 0l-8-8m8 8l-8 8m-2 12H30m0 0l8 8m-8-8l8-8'/></svg>">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'linkedin-blue': '#0A66C2',
                        'linkedin-hover': '#004182',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -10px rgba(10, 102, 194, 0.3);
        }
    </style>
</head>
<body class="bg-white font-sans antialiased">
    
    {{-- Floating Action Nav --}}
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md border-b border-gray-100 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-linkedin-blue rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <span class="font-bold text-xl text-gray-900">SkillExchange</span>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" 
                   class="text-gray-600 hover:text-linkedin-blue font-medium px-4 py-2 rounded-lg transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="bg-linkedin-blue text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-linkedin-hover transition-all shadow-md hover:shadow-lg">
                    Register
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center space-y-6 animate-slide-up">
                {{-- Main Headline --}}
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight max-w-4xl mx-auto">
                    Ever Been Stuck on an Assignment But Don't Know Who to Ask?
                </h1>
                
                {{-- Subheadline --}}
                <p class="text-xl md:text-2xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    Platform where you can <span class="text-linkedin-blue font-semibold">exchange skills</span> with your campusmates.
                    <br class="hidden md:block"/>
                    You help them, they help you. Win-win.
                </p>
                
                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4 animate-slide-up delay-1">
                    <a href="{{ route('register') }}" 
                       class="bg-linkedin-blue text-white font-semibold px-8 py-4 rounded-xl hover:bg-linkedin-hover transition-all shadow-lg hover:shadow-xl text-center group">
                        Register Now
                        <svg class="w-5 h-5 inline-block ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#bagaimana" 
                       class="border-2 border-gray-200 text-gray-700 font-semibold px-8 py-4 rounded-xl hover:border-linkedin-blue hover:text-linkedin-blue transition-all text-center">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Problem Cards --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Familiar with This Problem?</h2>
                <p class="text-xl text-gray-600">You're not alone</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                {{-- Problem 1 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover-lift">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">   Tight Deadline, Completely Stuck</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tight deadline, YouTube already watched, Google already searched, still stuck. 
                        Need someone who can explain directly.
                    </p>
                </div>

                {{-- Problem 2 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover-lift">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Course Prices are High, Wallets are Thin</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Course prices are high, wallets are thin. 
                        Yet there might be friends who are skilled and willing to teach.
                    </p>
                </div>

                {{-- Problem 3 --}}
                <div class="bg-white rounded-2xl p-8 border border-gray-100 hover-lift">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Hard to Find Help</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Need help with X but can't find skilled helpers. 
                        Or you're skilled in Y but don't know who needs it.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="bagaimana" class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-xl text-gray-600">Simple. Just a few minutes.</p>
            </div>
            
            {{-- Horizontal Flow --}}
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 max-w-5xl mx-auto">
                {{-- Step 1 --}}
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-linkedin-blue rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-2xl">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Register & Fill Profile</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Create a free account, fill your profile with skills you have. 
                        Add your portfolio if you have one.
                    </p>
                </div>

                {{-- Arrow 1 --}}
                <div class="flex-shrink-0 rotate-90 md:rotate-0">
                    <svg class="w-12 h-12 text-linkedin-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>

                {{-- Step 2 --}}
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-linkedin-blue rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-2xl">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Post or Search</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Can help? Post your skills. Need help? Make a request. 
                        Filter by skill or topic.
                    </p>
                </div>

                {{-- Arrow 2 --}}
                <div class="flex-shrink-0 rotate-90 md:rotate-0">
                    <svg class="w-12 h-12 text-linkedin-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>

                {{-- Step 3 --}}
                <div class="flex-1 text-center">
                    <div class="w-16 h-16 bg-linkedin-blue rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-2xl">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Connect & Learn</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Meet matches? Contact via email, set schedules, 
                        start learning together. It's that simple.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Real Examples --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Real Examples from Campus</h2>
                <p class="text-xl text-gray-600">Here's how students exchange skills on SkillExchange</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Example 1 --}}
                <div class="bg-white rounded-2xl p-8 border-2 border-green-100 hover-lift">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-14 h-14 bg-linkedin-blue rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            R
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 text-lg">Reza</div>
                            <div class="text-sm text-gray-500">Computer Science</div>
                            <span class="inline-block mt-1 bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">Can Help</span>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        "I can help those struggling with Python or Machine Learning. 
                        But I need help with designing a good thesis presentation PPT."
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-blue-50 text-blue-700 text-sm font-medium px-3 py-1 rounded-lg">Python</span>
                        <span class="bg-blue-50 text-blue-700 text-sm font-medium px-3 py-1 rounded-lg">Machine Learning</span>
                    </div>
                </div>

                {{-- Example 2 --}}
                <div class="bg-white rounded-2xl p-8 border-2 border-red-100 hover-lift">
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-14 h-14 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            D
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 text-lg">Dina</div>
                            <div class="text-sm text-gray-500">Visual Communication Design</div>
                            <span class="inline-block mt-1 bg-red-100 text-red-700 text-xs font-medium px-3 py-1 rounded-full">Need Help</span>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        "Help! I have to create a portfolio website but I don't understand HTML & CSS at all. 
                        Anyone who can teach me step by step?"
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-red-50 text-red-700 text-sm font-medium px-3 py-1 rounded-lg">HTML</span>
                        <span class="bg-red-50 text-red-700 text-sm font-medium px-3 py-1 rounded-lg">CSS</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Different --}}
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-linkedin-blue rounded-3xl p-12 text-white">
                <h2 class="text-3xl md:text-4xl font-bold mb-8">Why Not in WhatsApp/Telegram Group?</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-2">Post Won't Be Lost</h4>
                            <p class="text-blue-100">Your post will still be found, won't be lost in scroll of hundreds of chats</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-2">Filter & Search</h4>
                            <p class="text-blue-100">Search for a specific skill/topic? Just filter, find it right away</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-2">Portfolio Showcase</h4>
                            <p class="text-blue-100">Showcase your projects, so people can trust your skills</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-2">Organized</h4>
                            <p class="text-blue-100">With deadlines, track records, not random chats</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Ready to Exchange Skills?
            </h2>
            <p class="text-xl text-gray-600 mb-10">
                Join other students who are already helping each other on SkillExchange. 
                Free 100%, no cost at all.
            </p>
            <a href="{{ route('register') }}" 
               class="inline-block bg-linkedin-blue text-white font-bold text-lg px-10 py-5 rounded-xl hover:bg-linkedin-hover transition-all shadow-2xl hover:shadow-3xl">
                Register Now - Free!
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-linkedin-blue rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span class="font-bold text-white text-lg">SkillExchange</span>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-sm">Collaborative platform for Indonesian students</p>
                    <p class="text-xs mt-2">© {{ date('Y') }} SkillExchange. Created with the spirit of sharing.</p>
                </div>
            </div>
        </div>
    </footer>

    {{-- Smooth Scroll --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href'))?.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>