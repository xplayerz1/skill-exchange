@extends('layouts.app')

@section('title', 'Edit Skill - Admin')

@section('content')
@php
    // Determine if current category is custom (not in predefined list)
    $predefinedCategories = ['Frontend', 'Backend', 'Mobile', 'Design', 'DevOps', 'Data Science'];
    $isCustomCategory = !in_array($skill->category, $predefinedCategories);
    $selectedCategory = $isCustomCategory ? 'Other' : old('category', $skill->category);
    $customCategoryValue = $isCustomCategory ? old('custom_category', $skill->category) : old('custom_category', '');
@endphp

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center gap-2 text-linkedin-blue hover:text-linkedin-hover font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Skills List
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
        {{-- Header --}}
        <div class="border-b border-gray-200 bg-gradient-to-r from-linkedin-blue to-blue-600 px-8 py-6">
            <h1 class="text-3xl font-bold text-white">Edit Skill</h1>
            <p class="text-blue-50 mt-1 text-sm">Update skill: <span class="font-semibold">{{ $skill->name }}</span></p>
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

            {{-- Usage Warning --}}
            @if($skill->users()->count() > 0 || $skill->posts()->count() > 0)
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-yellow-800 font-semibold text-sm mb-1">This skill is currently in use:</h3>
                        <ul class="list-disc list-inside text-yellow-700 text-sm space-y-1">
                            @if($skill->users()->count() > 0)
                            <li>{{ $skill->users()->count() }} user(s) have this skill</li>
                            @endif
                            @if($skill->posts()->count() > 0)
                            <li>{{ $skill->posts()->count() }} post(s) use this skill</li>
                            @endif
                        </ul>
                        <p class="mt-2 text-yellow-700 text-sm">⚠️ Updating this skill will affect all users and posts using it.</p>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.skills.update', $skill) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                {{-- Skill Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                        Skill Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $skill->name) }}"
                           required
                           placeholder="e.g., Laravel, React, Python"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all duration-200 placeholder-gray-400">
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Enter a unique skill name that doesn't exist yet
                    </p>
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-900 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="category" 
                                id="category" 
                                required
                                class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all duration-200 appearance-none bg-white">
                            <option value="">Select Category</option>
                            <option value="Frontend" {{ $selectedCategory == 'Frontend' ? 'selected' : '' }}>Frontend Development</option>
                            <option value="Backend" {{ $selectedCategory == 'Backend' ? 'selected' : '' }}>Backend Development</option>
                            <option value="Mobile" {{ $selectedCategory == 'Mobile' ? 'selected' : '' }}>Mobile Development</option>
                            <option value="Design" {{ $selectedCategory == 'Design' ? 'selected' : '' }}>UI/UX Design</option>
                            <option value="DevOps" {{ $selectedCategory == 'DevOps' ? 'selected' : '' }}>DevOps & Cloud</option>
                            <option value="Data Science" {{ $selectedCategory == 'Data Science' ? 'selected' : '' }}>Data Science & AI</option>
                            <option value="Other" {{ $selectedCategory == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Select 'Other' if you want to specify a custom category below
                    </p>
                </div>

                {{-- Custom Category --}}
                <div>
                    <label for="custom_category" class="block text-sm font-semibold text-gray-900 mb-2">
                        Custom Category <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <input type="text" 
                           name="custom_category" 
                           id="custom_category"
                           value="{{ $customCategoryValue }}"
                           placeholder="If 'Other' is selected, specify custom category"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-linkedin-blue focus:border-transparent transition-all duration-200 placeholder-gray-400">
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        This will override the selected category above if filled
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.skills.index') }}" 
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
                        Update Skill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-select 'Other' when custom category is filled
document.getElementById('custom_category').addEventListener('input', function() {
    if (this.value.trim()) {
        document.getElementById('category').value = 'Other';
    }
});

// Clear custom category when non-Other category is selected
document.getElementById('category').addEventListener('change', function() {
    if (this.value !== 'Other' && this.value !== '') {
        document.getElementById('custom_category').value = '';
    }
});
</script>
@endsection
