@extends('layouts.app')

@section('title', 'Edit Topic - Admin')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('admin.topics.index') }}" class="inline-flex items-center gap-2 text-linkedin-blue hover:text-linkedin-hover font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Topics List
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
        {{-- Header --}}
        <div class="border-b border-gray-200 bg-gradient-to-r from-linkedin-blue to-blue-600 px-8 py-6">
            <h1 class="text-3xl font-bold text-white">Edit Topic</h1>
            <p class="text-blue-50 mt-1 text-sm">Update topic: <span class="font-semibold">{{ $topic->title }}</span></p>
        </div>

        {{-- Form Content --}}
        <div class="px-8 py-8">
            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-red-800 font-semibold text-sm">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside text-red-700 text-sm mt-2 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.topics.update', $topic) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                        Topic Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $topic->title) }}"
                           required
                           placeholder="e.g., Web Development, Mobile Apps, AI & Machine Learning"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all duration-200 placeholder-gray-400">
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Enter a clear and descriptive topic name
                    </p>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                        Description <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="5"
                              placeholder="Provide a brief description of this topic..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all duration-200 placeholder-gray-400">{{ old('description', $topic->description) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Help users understand what this topic is about
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.topics.index') }}" 
                       class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-linkedin-blue text-white rounded-xl font-semibold hover:bg-linkedin-hover transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Topic
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
