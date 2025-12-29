@extends('layouts.app')

@section('title', 'Users - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8 text-linkedin-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        </div>
        @if(auth()->user()->role !== 'admin')
        <button onclick="openCreateModal()" class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-semibold px-6 py-3 rounded-lg flex items-center gap-2 transition-all transform hover:scale-105 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create Post
        </button>
        @endif
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-red-700 font-semibold mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


    {{-- Filters Section --}}
    <div class="mb-8">
        <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
            {{-- Search Bar --}}
            <div class="mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search by title, description, or skills..." 
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all">
                </div>
            </div>

            {{-- Filter Dropdowns --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Type Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Post Type
                    </label>
                    <select name="type" onchange="this.form.submit()" 
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all bg-white appearance-none"
                            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%236B7280\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.5em;">
                        <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>All Types</option>
                        <option value="open" {{ request('type') == 'open' ? 'selected' : '' }}>🟢 Open for Help</option>
                        <option value="need" {{ request('type') == 'need' ? 'selected' : '' }}>🔴 Need Help</option>
                    </select>
                </div>

                {{-- Skill Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        Skill
                    </label>
                    <select name="skill_id" onchange="this.form.submit()" 
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all bg-white appearance-none"
                            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%236B7280\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.5em;">
                        <option value="">All Skills</option>
                        @foreach($allSkills as $skill)
                            <option value="{{ $skill->id }}" {{ request('skill_id') == $skill->id ? 'selected' : '' }}>
                                {{ $skill->name }} ({{ $skill->category }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Topic Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                        Topic
                    </label>
                    <select name="topic_id" onchange="this.form.submit()" 
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all bg-white appearance-none"
                            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%236B7280\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.5em;">
                        <option value="">All Topics</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>
                                {{ $topic->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Active Filters Display & Clear Button --}}
            @php
                $hasActiveFilters = request('search') || 
                                   (request('type') && request('type') !== 'all') || 
                                   request('skill_id') || 
                                   request('topic_id');
            @endphp
            
            @if($hasActiveFilters)
            <div class="mt-4 flex items-center justify-between bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm font-medium text-blue-900">Active Filters:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Search: "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('type') && request('type') !== 'all')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Type: {{ request('type') == 'open' ? 'Open for Help' : 'Need Help' }}
                        </span>
                    @endif
                    @if(request('skill_id'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Skill: {{ $allSkills->find(request('skill_id'))->name ?? 'Unknown' }}
                        </span>
                    @endif
                    @if(request('topic_id'))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Topic: {{ $topics->find(request('topic_id'))->title ?? 'Unknown' }}
                        </span>
                    @endif
                </div>
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear All
                </a>
            </div>
            @endif
        </form>
    </div>

    @if($posts->count() > 0)
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($posts as $post)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-600">
                        Posted by 
                        @if($post->user_id == auth()->id())
                            <span class="font-medium text-gray-900">{{ $post->user->name }}</span>
                        @else
                            <a href="{{ route('user.profile', $post->user->id) }}" 
                               class="font-medium text-linkedin-blue hover:text-linkedin-hover hover:underline transition-colors">
                                {{ $post->user->name }}
                            </a>
                        @endif
                        • {{ $post->user->department }} • {{ $post->user->batch }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->type == 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $post->type == 'open' ? 'Open for Help' : 'Need Help' }}
                    </span>
                    @if($post->user_id == auth()->id())
                    <div class="relative">
                        <button onclick="togglePostMenu({{ $post->id }})" class="text-gray-400 hover:text-gray-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/>
                            </svg>
                        </button>
                        <div id="postMenu{{ $post->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10 border border-gray-200">
                            <button onclick="editPost({{ $post->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                </svg>
                                Edit
                            </button>
                            <button onclick="deletePost({{ $post->id }}); togglePostMenu({{ $post->id }});" class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-b-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <p class="text-gray-700 mb-4">{{ Str::limit($post->description, 100) }}</p>
            
            @if($post->topic)
            <div class="mb-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
                    </svg>
                    {{ $post->topic->title }}
                </span>
            </div>
            @endif
            
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($post->skills as $skill)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $skill->name }}
                </span>
                @endforeach
            </div>
            
            <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                <span class="text-sm text-gray-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                    Deadline: {{ $post->deadline->format('M d, Y') }}
                </span>

                @if($post->user_id != auth()->id())
                    <a href="mailto:{{ $post->user->email }}"
                    class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-medium px-4 py-2.5 rounded-lg text-sm inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        {{ $post->type == 'open' ? 'Contact' : 'Offer Help' }}
                    </a>
                @else
                    <span class="text-sm text-gray-500 font-medium">Your Post</span>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No posts found</h3>
        <p class="text-gray-600 mb-6">
            @if(request('search'))
                Try adjusting your search or filter to find what you're looking for.
            @else
                {{ auth()->user()->role === 'admin' ? 'No posts to display.' : 'Create your first post to get started!' }}
            @endif
        </p>
        @if(auth()->user()->role !== 'admin')
        <button onclick="openCreateModal()" class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center gap-2 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create Post
        </button>
        @endif
    </div>
    @endif
</div>

{{-- Create Post Modal - Modern Design --}}
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl transform transition-all">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Create New Post</h2>
                <p class="text-sm text-gray-600 mt-1">Share your knowledge or request help from the community</p>
            </div>
            <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <form id="createPostForm" action="{{ route('posts.store') }}" method="POST" class="px-8 py-6" onsubmit="return validateSkills()">
            @csrf
            <div class="space-y-6 max-h-[calc(100vh-280px)] overflow-y-auto pr-2">
                
                {{-- Post Type --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Post Type</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-linkedin-blue hover:bg-blue-50 transition-all peer-checked:border-linkedin-blue peer-checked:bg-blue-50">
                            <input type="radio" name="type" value="open" class="peer sr-only" checked>
                            <div class="text-center">
                                <svg class="w-6 h-6 mx-auto mb-2 text-linkedin-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="font-semibold text-gray-900">Offer Help</p>
                                <p class="text-xs text-gray-600 mt-1">I can teach/help others</p>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-linkedin-blue peer-checked:bg-linkedin-blue peer-checked:after:content-['✓'] peer-checked:after:text-white peer-checked:after:text-xs peer-checked:after:flex peer-checked:after:items-center peer-checked:after:justify-center"></div>
                        </label>
                        
                        <label class="relative flex items-center justify-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-red-500 hover:bg-red-50 transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                            <input type="radio" name="type" value="need" class="peer sr-only">
                            <div class="text-center">
                                <svg class="w-6 h-6 mx-auto mb-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="font-semibold text-gray-900">Need Help</p>
                                <p class="text-xs text-gray-600 mt-1">I need assistance</p>
                            </div>
                            <div class="absolute top-3 right-3 w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-red-500 peer-checked:bg-red-500 peer-checked:after:content-['✓'] peer-checked:after:text-white peer-checked:after:text-xs peer-checked:after:flex peer-checked:after:items-center peer-checked:after:justify-center"></div>
                        </label>
                    </div>
                </div>

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required 
                           placeholder="e.g., Learn React.js basics or Need help with Laravel authentication"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all">
                </div>

                {{-- Topic --}}
                <div>
                    <label for="topic_id" class="block text-sm font-semibold text-gray-900 mb-2">
                        Topic (Category)
                    </label>
                    <select name="topic_id" id="topic_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all appearance-none bg-white bg-no-repeat bg-right pr-10" 
                            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%236B7280\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'%3E%3C/path%3E%3C/svg%3E'); background-size: 1.5em;">
                        <option value="">Select Topic</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-600">💡 Categorize your post for better discoverability</p>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required 
                              placeholder="Provide details about what you can teach or what help you need..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all resize-none"></textarea>
                    <p class="mt-2 text-xs text-gray-600">Be specific and clear to get better responses</p>
                </div>

                {{-- Skills --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Skills <span class="text-red-500">*</span> <span class="text-gray-500 font-normal">(Select at least one)</span>
                    </label>
                    <div id="skillsContainer" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto p-4 border border-gray-300 rounded-xl bg-gray-50">
                        @foreach($allSkills as $skill)
                        <label class="flex items-start hover:bg-white p-2 rounded-lg cursor-pointer transition-all group">
                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                                   class="skills-checkbox mt-0.5 mr-3 w-4 h-4 text-linkedin-blue border-gray-300 rounded focus:ring-linkedin-blue">
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-900 group-hover:text-linkedin-blue">{{ $skill->name }}</span>
                                <br><span class="text-xs text-gray-500">({{ $skill->category }})</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p id="skillsError" class="hidden mt-2 text-sm text-red-600">
                        ⚠️ Please select at least one skill
                    </p>
                    <p class="mt-2 text-xs text-gray-600">
                        <span class="font-semibold">Tip:</span> For "<strong>Need Help</strong>", select skills you need. For "<strong>Offer Help</strong>", select what you can teach.
                    </p>
                </div>

                {{-- Deadline & Preference --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="deadline" class="block text-sm font-semibold text-gray-900 mb-2">
                            Deadline <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="deadline" id="deadline" required 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="preference" class="block text-sm font-semibold text-gray-900 mb-2">
                            Preference <span class="text-red-500">*</span>
                        </label>
                        <select name="preference" id="preference" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all appearance-none bg-white bg-no-repeat bg-right pr-10"
                                style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%236B7280\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'%3E%3C/path%3E%3C/svg%3E'); background-size: 1.5em;">
                            <option value="online">💻 Online</option>
                            <option value="offline">🤝 Offline</option>
                            <option value="both">🌐 Both</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <button type="button" onclick="closeCreateModal()" 
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-8 py-3 bg-linkedin-blue text-white font-semibold rounded-xl hover:bg-linkedin-hover shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Post
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Post</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="type" value="open" class="mr-2" id="editTypeOpen">
                                <span>Open for Help</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="type" value="need" class="mr-2" id="editTypeNeed">
                                <span>Need Help</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="editTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="editTitle" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="editTopicId" class="block text-sm font-medium text-gray-700">Topic (Category)</label>
                        <select name="topic_id" id="editTopicId" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Topic</option>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="editDescription" rows="4" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                        <div id="editSkills" class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
                            @foreach($allSkills as $skill)
                            <label class="flex items-center hover:bg-gray-50 p-1 rounded">
                                <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="mr-2 edit-skill-checkbox">
                                <span class="text-sm">{{ $skill->name }}</span>
                                <span class="text-xs text-gray-500 ml-1">({{ $skill->category }})</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="editDeadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="date" name="deadline" id="editDeadline" required 
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="editPreference" class="block text-sm font-medium text-gray-700">Preference</label>
                            <select name="preference" id="editPreference" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Post</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this post? This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }
    
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function validateSkills() {
        const checkboxes = document.querySelectorAll('.skills-checkbox');
        const checked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        const errorMsg = document.getElementById('skillsError');
        const container = document.getElementById('skillsContainer');
        
        if (!checked) {
            // Show error message
            errorMsg.classList.remove('hidden');
            // Add red border to container
            container.classList.add('border-red-500');
            container.classList.remove('border-gray-300');
            // Scroll to skills section
            container.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false; // Prevent form submission
        }
        
        // Hide error if validation passes
        errorMsg.classList.add('hidden');
        container.classList.remove('border-red-500');
        container.classList.add('border-gray-300');
        return true; // Allow form submission
    }
    
    function togglePostMenu(postId) {
        const menu = document.getElementById('postMenu' + postId);
        menu.classList.toggle('hidden');
    }
    
    function editPost(postId) {
        // Find post data from the page
        const posts = @json($posts->items());
        const post = posts.find(p => p.id === postId);
        
        if (!post) {
            alert('Post data not found');
            return;
        }
        
        // Set form action
        document.getElementById('editForm').action = '{{ url('/posts') }}/' + postId;
        
        // Populate form fields
        document.getElementById('editTitle').value = post.title || '';
        document.getElementById('editDescription').value = post.description || '';
        
        // Format deadline for date input (YYYY-MM-DD)
        if (post.deadline) {
            // Handle various date formats
            let deadlineValue = post.deadline;
            if (typeof deadlineValue === 'string') {
                // If it's already a string, try to parse and format
                const dateObj = new Date(deadlineValue);
                if (!isNaN(dateObj.getTime())) {
                    // Format as YYYY-MM-DD
                    const year = dateObj.getFullYear();
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    deadlineValue = `${year}-${month}-${day}`;
                }
            }
            document.getElementById('editDeadline').value = deadlineValue;
        } else {
            document.getElementById('editDeadline').value = '';
        }
        
        document.getElementById('editPreference').value = post.preference || 'online';
        
        // Set post type radio buttons
        if (post.type === 'open') {
            document.getElementById('editTypeOpen').checked = true;
        } else {
            document.getElementById('editTypeNeed').checked = true;
        }
        
        // Set topic dropdown
        const topicSelect = document.getElementById('editTopicId');
        if (topicSelect && post.topic_id) {
            topicSelect.value = post.topic_id;
        } else if (topicSelect) {
            topicSelect.value = '';
        }
        
        // Reset all skill checkboxes first
        document.querySelectorAll('#editSkills input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Check skills that belong to this post
        if (post.skills && Array.isArray(post.skills)) {
            post.skills.forEach(skill => {
                const checkbox = document.querySelector(`#editSkills input[value="${skill.id}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
        
        // Show modal
        document.getElementById('editModal').classList.remove('hidden');
    }
    
    function togglePostMenu(postId) {
        const menu = document.getElementById('postMenu' + postId);
        menu.classList.toggle('hidden');
    }
    
    function deletePost(postId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = '{{ url('/posts') }}/' + postId;
    }
    
    // Close all post menus when clicking outside
    window.onclick = function(event) {
        // Don't close if clicking on the menu button or inside the menu
        if (!event.target.closest('button[onclick^="togglePostMenu"]') && 
            !event.target.closest('[id^="postMenu"]')) {
            const menus = document.querySelectorAll('[id^="postMenu"]');
            menus.forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    }
</script>
@endsection