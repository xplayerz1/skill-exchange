{{-- Sidebar Component --}}
<div x-data="{ sidebarOpen: true }" class="relative">
    {{-- Sidebar --}}
    <aside 
        :class="sidebarOpen ? 'w-64' : 'w-16'" 
        class="fixed left-0 top-0 h-screen bg-white border-r border-gray-200 transition-all duration-300 ease-in-out z-40 flex flex-col"
    >
        {{-- Logo & Toggle --}}
        <div class="relative flex items-center p-4 border-b border-gray-200" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
            <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" 
               class="flex items-center gap-3"
               :class="!sidebarOpen && 'justify-center'">
                <div class="w-10 h-10 bg-linkedin-blue rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <span x-show="sidebarOpen" x-transition class="text-xl font-semibold text-gray-900">
                    SkillExchange
                </span>
            </a>
            
            {{-- Toggle Button --}}
            <button 
                @click="sidebarOpen = !sidebarOpen"
                class="p-2 rounded-lg hover:bg-gray-100 transition-all flex-shrink-0"
                :class="!sidebarOpen && 'absolute -right-3 top-16 bg-white border border-gray-200 shadow-md'"
                title="Toggle Sidebar"
            >
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="sidebarOpen ? 'M11 19l-7-7 7-7m8 14l-7-7 7-7' : 'M13 5l7 7-7 7M5 5l7 7-7 7'"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-6 px-3">
            @if(auth()->user()->is_admin)
                {{-- Admin Navigation --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Manage Users</span>
                </a>

                <a href="{{ route('admin.posts.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('admin.posts.*') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Manage Posts</span>
                </a>

                <a href="{{ route('admin.skills.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('admin.skills.*') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Manage Skills</span>
                </a>

                <a href="{{ route('admin.topics.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('admin.topics.*') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Manage Topics</span>
                </a>

            @else
                {{-- User Navigation --}}
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('portfolio.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ (request()->routeIs('portfolio.*') || request()->routeIs('user.profile')) ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Portfolio</span>
                </a>

                <a href="{{ route('learning-goals.index') }}" 
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all mb-2 {{ request()->routeIs('learning-goals.*') ? 'bg-blue-50 text-linkedin-blue border-l-4 border-linkedin-blue' : 'text-gray-700 hover:bg-gray-50' }}"
                   :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Learning Goals</span>
                </a>
            @endif
        </nav>

        {{-- User Profile --}}
        <div class="border-t border-gray-200 p-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:bg-gray-50 rounded-lg p-2 -m-2 transition-colors" :class="!sidebarOpen && 'justify-center'">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-600 font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </span>
                </div>
                <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" 
                        class="flex items-center gap-4 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all w-full"
                        :class="!sidebarOpen && 'justify-center px-3'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- Main Content Area --}}
    <div 
        :class="sidebarOpen ? 'ml-64' : 'ml-16'" 
        class="transition-all duration-300 ease-in-out min-h-screen bg-gray-50">
        {{ $slot }}
    </div>
</div>

<style>
    .nav-item {
        @apply flex items-center px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors mb-1 cursor-pointer;
    }
    
    .nav-item.active {
        @apply bg-blue-50 text-blue-600 font-medium;
    }
    
    .nav-item.active svg {
        @apply text-blue-600;
    }
</style>
