@extends('layouts.app')

@section('title', 'Users - Learning Goals')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Learning Goals</h1>
        <p class="text-gray-600">Track your learning progress and achieve your skill development goals</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Main Content Box --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-200 p-8">
        {{-- Box Header with Add Button --}}
        <div class="flex justify-between items-center mb-8 pb-6 border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Learning Goals</h2>
                <p class="text-gray-600 text-sm mt-1">{{ $goals->count() }} {{ $goals->count() == 1 ? 'goal' : 'goals' }} in progress</p>
            </div>
            <button onclick="openCreateGoalModal()" class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-semibold px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Goal
            </button>
        </div>

        {{-- Goals List --}}
        @if($goals->count() > 0)
            <div class="space-y-4">
                @foreach($goals as $goal)
                <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-linkedin-blue hover:shadow-md transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $goal->title }}</h3>
                            
                            <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                @if($goal->topic)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        {{ $goal->topic->title }}
                                    </span>
                                @endif

                                @if($goal->skill)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                        </svg>
                                        {{ $goal->skill->name }}
                                    </span>
                                @endif

                                @if($goal->target_date)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Target: {{ $goal->target_date->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <span class="px-4 py-2 text-sm font-semibold rounded-full whitespace-nowrap
                            @if($goal->status == 'not_started') bg-gray-100 text-gray-800
                            @elseif($goal->status == 'in_progress') bg-blue-50 text-blue-700 border-2 border-blue-200
                            @else bg-green-50 text-green-700 border-2 border-green-200 @endif">
                            {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                        </span>
                    </div>

                    @if($goal->description)
                        <p class="text-gray-700 mb-4 leading-relaxed">{{ Str::limit($goal->description, 150) }}</p>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button onclick="editGoal({{ $goal->id }})" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Goal
                        </button>
                        <button onclick="deleteGoal({{ $goal->id }})" class="flex items-center gap-2 text-red-600 hover:text-red-800 font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Learning Goals Yet</h3>
                <p class="text-gray-600 mb-6">Set your first learning goal and start tracking your progress!</p>
                <button onclick="openCreateGoalModal()" class="bg-linkedin-blue hover:bg-linkedin-hover text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Your First Goal
                </button>
            </div>
        @endif
    </div>
</div>

{{-- Create/Edit Modal --}}
<div id="goalModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Create Learning Goal</h3>
                <button onclick="closeGoalModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="goalForm" method="POST" action="{{ route('learning-goals.store') }}">
                @csrf
                <input type="hidden" id="goalMethod" name="_method" value="POST">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Title *</label>
                    <input type="text" name="title" id="goalTitle" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Topic</label>
                    <select name="topic_id" id="goalTopic" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">Select Topic</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Skill</label>
                    <select name="skill_id" id="goalSkill" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">Select Skill</option>
                        @foreach($skills as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Target Date</label>
                    <input type="date" name="target_date" id="goalDate" min="{{ date('Y-m-d') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status *</label>
                    <select name="status" id="goalStatus" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="not_started">Not Started</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="goalDescription" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" id="goalNotes" rows="2" class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeGoalModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Save Goal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateGoalModal() {
    document.getElementById('goalModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Create Learning Goal';
    document.getElementById('goalForm').action = '{{ route('learning-goals.store') }}';
    document.getElementById('goalMethod').value = 'POST';
    document.getElementById('goalForm').reset();
}

function closeGoalModal() {
    document.getElementById('goalModal').classList.add('hidden');
}

function editGoal(id) {
    // Get goal data from embedded Blade data
    const goals = @json($goals);
    const goal = goals.find(g => g.id === id);
    
    if (!goal) {
        alert('Goal data not found');
        return;
    }
    
    // Populate form fields
    document.getElementById('goalTitle').value = goal.title || '';
    document.getElementById('goalTopic').value = goal.topic_id || '';
    document.getElementById('goalSkill').value = goal.skill_id || '';
    document.getElementById('goalStatus').value = goal.status || 'not_started';
    document.getElementById('goalDescription').value = goal.description || '';
    document.getElementById('goalNotes').value = goal.notes || '';
    
    // Format target_date for input
    if (goal.target_date) {
        let dateValue = goal.target_date;
        if (typeof dateValue === 'string') {
            const dateObj = new Date(dateValue);
            if (!isNaN(dateObj.getTime())) {
                const year = dateObj.getFullYear();
                const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                const day = String(dateObj.getDate()).padStart(2, '0');
                dateValue = `${year}-${month}-${day}`;
            }
        }
        document.getElementById('goalDate').value = dateValue;
    } else {
        document.getElementById('goalDate').value = '';
    }
    
    // Update modal and form for editing
    document.getElementById('modalTitle').textContent = 'Edit Learning Goal';
    document.getElementById('goalForm').action = '/learning-goals/' + id;
    document.getElementById('goalMethod').value = 'PUT';
    
    // Show modal
    document.getElementById('goalModal').classList.remove('hidden');
}

function deleteGoal(id) {
    if (confirm('Are you sure you want to delete this goal?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/learning-goals/' + id;
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
