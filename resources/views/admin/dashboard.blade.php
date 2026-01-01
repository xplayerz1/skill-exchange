@extends('layouts.app')

@section('title', 'Admin - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-0">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <svg class="w-8 h-8 text-linkedin-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
            </svg>
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        </div>
        <p class="text-gray-600 ml-11">Welcome! Here's the application statistics summary</p>
    </div>

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
                    <p class="text-xs text-blue-600 mt-1">
                        <i class="fas fa-user-plus mr-1"></i>{{ $newUsersThisMonth }} new this month
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Posts</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalPosts }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-fire mr-1"></i>{{ $openForHelp }} open, {{ $needHelp }} need help
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-newspaper text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Skills -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Skills</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSkills }}</p>
                    <p class="text-xs text-purple-600 mt-1">
                        <i class="fas fa-code mr-1"></i>Available skills
                    </p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-code text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Topics -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Topics</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTopics }}</p>
                    <p class="text-xs text-orange-600 mt-1">
                        <i class="fas fa-folder mr-1"></i>Topic categories
                    </p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-folder-open text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Active Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-indigo-100 rounded-full p-3 mr-4">
                    <i class="fas fa-chart-line text-2xl text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeUsersThisWeek }}</p>
                    <p class="text-xs text-gray-500">Last 7 days</p>
                </div>
            </div>
        </div>

        <!-- Posts This Week -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-teal-100 rounded-full p-3 mr-4">
                    <i class="fas fa-calendar-week text-2xl text-teal-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Posts This Week</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $postsThisWeek }}</p>
                    <p class="text-xs text-gray-500">Last 7 days</p>
                </div>
            </div>
        </div>

        <!-- Portfolio Items -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-pink-100 rounded-full p-3 mr-4">
                    <i class="fas fa-briefcase text-2xl text-pink-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Portfolio Items</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPortfolios }}</p>
                    <p class="text-xs text-gray-500">Total portfolios</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-clock text-blue-600 mr-2"></i>
                Recent Posts
            </h3>
            @if($recentPosts->count() > 0)
                <div class="space-y-3">
                    @foreach($recentPosts as $post)
                    <div class="border-l-4 border-blue-500 bg-gray-50 p-3 rounded">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ Str::limit($post->title, 40) }}</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="inline-block px-2 py-0.5 bg-{{ $post->type == 'open' ? 'green' : 'orange' }}-100 text-{{ $post->type == 'open' ? 'green' : 'orange' }}-800 rounded text-xs">
                                        {{ $post->type == 'open' ? 'Open for Help' : 'Need Help' }}
                                    </span>
                                    by <strong>{{ $post->user->name }}</strong>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="far fa-calendar mr-1"></i>{{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No posts yet</p>
            @endif
        </div>

        <!-- Popular Skills -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-fire text-orange-600 mr-2"></i>
                Popular Skills
            </h3>
            @if($popularSkills->count() > 0)
                <div class="space-y-3">
                    @foreach($popularSkills as $skill)
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                        <div class="flex items-center">
                            <div class="bg-purple-100 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                                <i class="fas fa-code text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $skill->name }}</p>
                                <p class="text-xs text-gray-500">{{ $skill->category }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-purple-600">{{ $skill->posts_count }}</p>
                            <p class="text-xs text-gray-500">posts</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No data yet</p>
            @endif
        </div>
</div>
@endsection