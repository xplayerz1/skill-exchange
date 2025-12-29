@extends('layouts.app')

@section('title', $targetUser->name . ' - Portfolio')

@section('content')
@php
    $isOwnProfile = auth()->id() === $targetUser->id;
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    @if($isOwnProfile)
                        My Portfolio
                    @else
                        {{ $targetUser->name}}'s Portfolio
                    @endif
                </h1>
                <p class="text-gray-600 mt-2">
                    <span class="font-medium">{{ $targetUser->name }}</span> • 
                    {{ $targetUser->department }} • 
                    {{ $targetUser->batch }}
                </p>
            </div>
        </div>
    </div>

    {{-- Skills Section --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Expertise & Skills</h2>
            @if($isOwnProfile)
                <button onclick="document.getElementById('addSkillForm').classList.toggle('hidden')" 
                        class="text-linkedin-blue hover:text-linkedin-hover font-semibold flex items-center gap-1 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Manage Skills
                </button>
            @endif
        </div>

        @if($isOwnProfile)
            <div id="addSkillForm" class="hidden mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <form action="{{ route('profile.skills.attach') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="text" name="skill_name" placeholder="Enter skill name (e.g. PHP, Figma, Public Speaking)" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent" required>
                    <button type="submit" class="bg-linkedin-blue text-white px-6 py-2 rounded-lg font-semibold hover:bg-linkedin-hover transition-colors">
                        Add Skill
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-2 italic">A new skill will be created if it doesn't exist in our database.</p>
            </div>
        @endif

        @if($targetUser->skills->count() > 0)
            <div class="flex flex-wrap gap-3">
                @foreach($targetUser->skills as $skill)
                    <div class="group relative bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-blue-100 transition-all">
                        <div>
                            <p class="text-sm font-semibold text-blue-900 leading-tight">{{ $skill->name }}</p>
                            <p class="text-[10px] text-blue-600 uppercase tracking-wider font-bold">{{ $skill->category }}</p>
                        </div>
                        @if($isOwnProfile)
                            <form action="{{ route('profile.skills.detach', $skill->id) }}" method="POST" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-300 hover:text-red-500 transition-colors" title="Remove Skill">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">No specific skills listed yet.</p>
        @endif
    </div>

    {{-- Portfolio Section --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Portfolio Items</h2>
            @if($isOwnProfile)
            <button onclick="openCreatePortfolioModal()" class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-semibold px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Portfolio
            </button>
            @endif
        </div>

        @if($portfolios->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($portfolios as $portfolio)
                    <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-linkedin-blue hover:shadow-lg transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-bold text-gray-900">{{ $portfolio->title }}</h3>
                            @if($isOwnProfile)
                            <div class="flex gap-2">
                                <button onclick="editPortfolio({{ $portfolio->id }})" class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="deletePortfolio({{ $portfolio->id }})" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>

                        <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ $portfolio->description }}</p>

                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($portfolio->skills as $skill)
                                <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>

                        @if($portfolio->link)
                            <a href="{{ $portfolio->link }}" target="_blank" class="inline-flex items-center gap-2 text-linkedin-blue hover:text-linkedin-hover font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View Project
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Portfolio Items Yet</h3>
                <p class="text-gray-600 mb-6">
                    @if($isOwnProfile)
                        Start showcasing your work by adding your first portfolio item
                    @else
                        This user hasn't added any portfolio items yet.
                    @endif
                </p>
                @if($isOwnProfile)
                <button onclick="openCreatePortfolioModal()" class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Your First Portfolio
                </button>
                @endif
            </div>
        @endif
    </div>
</div>

@if($isOwnProfile)
{{-- Create Portfolio Modal --}}
<div id="createPortfolioModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-8 border w-full max-w-2xl shadow-lg rounded-xl bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Add Portfolio</h3>
            <button onclick="closeCreatePortfolioModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('portfolio.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Link (Optional)</label>
                <input type="url" name="link"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent"
                       placeholder="https://example.com">
            </div>


            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Skills Used <span class="text-red-500">*</span> <span class="text-gray-500 font-normal">(Select at least one)</span>
                </label>
                <div id="createPortfolioSkillsContainer" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto p-4 border border-gray-300 rounded-xl bg-gray-50">
                    @foreach($skills as $skill)
                    <label class="flex items-start hover:bg-white p-2 rounded-lg cursor-pointer transition-all group">
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                               class="create-portfolio-skills-checkbox mt-0.5 mr-3 w-4 h-4 text-linkedin-blue border-gray-300 rounded focus:ring-linkedin-blue">
                        <div class="flex-1">
                            <span class="text-sm font-medium text-gray-900 group-hover:text-linkedin-blue">{{ $skill->name }}</span>
                            <br><span class="text-xs text-gray-500">({{ $skill->category }})</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                <p id="createPortfolioSkillsError" class="hidden mt-2 text-sm text-red-600">
                    ⚠️ Please select at least one skill
                </p>
                <p class="text-xs text-gray-600 mt-2">Select all skills you used in this portfolio project</p>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCreatePortfolioModal()"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-3 bg-linkedin-blue text-white rounded-lg hover:bg-linkedin-hover">
                    Add Portfolio
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Portfolio Modal --}}
<div id="editPortfolioModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-8 border w-full max-w-2xl shadow-lg rounded-xl bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Edit Portfolio</h3>
            <button onclick="closeEditPortfolioModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="editPortfolioForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" name="title" id="edit_title" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="edit_description" rows="4" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Project Link (Optional)</label>
                <input type="url" name="link" id="edit_link"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-linkedin-blue focus:border-transparent">
            </div>


            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Skills Used <span class="text-red-500">*</span> <span class="text-gray-500 font-normal">(Select at least one)</span>
                </label>
                <div id="editPortfolioSkillsContainer" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-64 overflow-y-auto p-4 border border-gray-300 rounded-xl bg-gray-50">
                    @foreach($skills as $skill)
                    <label class="flex items-start hover:bg-white p-2 rounded-lg cursor-pointer transition-all group">
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                               class="edit-portfolio-skills-checkbox mt-0.5 mr-3 w-4 h-4 text-linkedin-blue border-gray-300 rounded focus:ring-linkedin-blue">
                        <div class="flex-1">
                            <span class="text-sm font-medium text-gray-900 group-hover:text-linkedin-blue">{{ $skill->name }}</span>
                            <br><span class="text-xs text-gray-500">({{ $skill->category }})</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                <p id="editPortfolioSkillsError" class="hidden mt-2 text-sm text-red-600">
                    ⚠️ Please select at least one skill
                </p>
                <p class="text-xs text-gray-600 mt-2">Select all skills you used in this portfolio project</p>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditPortfolioModal()"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-3 bg-linkedin-blue text-white rounded-lg hover:bg-linkedin-hover">
                    Update Portfolio
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deletePortfolioModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <svg class="mx-auto mb-4 w-14 h-14 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Portfolio?</h3>
            <p class="text-sm text-gray-600 mb-6">This action cannot be undone.</p>
            
            <form id="deletePortfolioForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeletePortfolioModal()"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validatePortfolioSkills(isCreate = true) {
    const selector = isCreate ? '.create-portfolio-skills-checkbox' : '.edit-portfolio-skills-checkbox';
    const errorId = isCreate ? 'createPortfolioSkillsError' : 'editPortfolioSkillsError';
    const containerId = isCreate ? 'createPortfolioSkillsContainer' : 'editPortfolioSkillsContainer';
    
    const checkboxes = document.querySelectorAll(selector);
    const checked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    const errorMsg = document.getElementById(errorId);
    const container = document.getElementById(containerId);
    
    if (!checked) {
        errorMsg.classList.remove('hidden');
        container.classList.add('border-red-500');
        container.classList.remove('border-gray-300');
        container.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    
    errorMsg.classList.add('hidden');
    container.classList.remove('border-red-500');
    container.classList.add('border-gray-300');
    return true;
}

function openCreatePortfolioModal() {
    document.getElementById('createPortfolioModal').classList.remove('hidden');
}

function closeCreatePortfolioModal() {
    document.getElementById('createPortfolioModal').classList.add('hidden');
    // Reset form
    document.querySelectorAll('.create-portfolio-skills-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('createPortfolioSkillsError').classList.add('hidden');
    document.getElementById('createPortfolioSkillsContainer').classList.remove('border-red-500');
}

function editPortfolio(portfolioId) {
    // Fetch portfolio data
    const portfolios = @json($portfolios);
    const portfolio = portfolios.find(p => p.id === portfolioId);
    
    if (portfolio) {
        document.getElementById('edit_title').value = portfolio.title;
        document.getElementById('edit_description').value = portfolio.description;
        document.getElementById('edit_link').value = portfolio.link || '';
        
        // Reset all checkboxes first
        document.querySelectorAll('.edit-portfolio-skills-checkbox').forEach(cb => {
            cb.checked = false;
        });
        
        // Check the skills that belong to this portfolio
        const portfolioSkillIds = portfolio.skills.map(s => s.id);
        portfolioSkillIds.forEach(skillId => {
            const checkbox = document.querySelector(`.edit-portfolio-skills-checkbox[value="${skillId}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
        
        // Set form action
        document.getElementById('editPortfolioForm').action = `/portfolio/${portfolioId}`;
        document.getElementById('editPortfolioModal').classList.remove('hidden');
    }
}

function closeEditPortfolioModal() {
    document.getElementById('editPortfolioModal').classList.add('hidden');
    document.getElementById('editPortfolioSkillsError').classList.add('hidden');
    document.getElementById('editPortfolioSkillsContainer').classList.remove('border-red-500');
}

function deletePortfolio(portfolioId) {
    document.getElementById('deletePortfolioForm').action = `/portfolio/${portfolioId}`;
    document.getElementById('deletePortfolioModal').classList.remove('hidden');
}

function closeDeletePortfolioModal() {
    document.getElementById('deletePortfolioModal').classList.add('hidden');
}

// Add form submit validation
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.querySelector('#createPortfolioModal form');
    const editForm = document.querySelector('#editPortfolioModal form');
    
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            if (!validatePortfolioSkills(true)) {
                e.preventDefault();
            }
        });
    }
    
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            if (!validatePortfolioSkills(false)) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endif
@endsection
