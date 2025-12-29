<?php

namespace App\Http\Controllers;

use App\Models\LearningGoal;
use App\Models\Skill;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningGoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->learningGoals()->with(['skill', 'topic'])->latest()->get();
        $skills = Skill::orderBy('name')->get();
        $topics = Topic::orderBy('title')->get();
        
        return view('learning-goals.index', compact('goals', 'skills', 'topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skill_id' => 'nullable|exists:skills,id',
            'topic_id' => 'nullable|exists:topics,id',
            'target_date' => 'nullable|date|after:today',
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        Auth::user()->learningGoals()->create($request->all());

        return back()->with('success', 'Learning goal created successfully!');
    }

    public function update(Request $request, LearningGoal $learningGoal)
    {
        if ($learningGoal->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skill_id' => 'nullable|exists:skills,id',
            'topic_id' => 'nullable|exists:topics,id',
            'target_date' => 'nullable|date',
            'status' => 'required|in:not_started,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        $learningGoal->update($request->all());

        return back()->with('success', 'Learning goal updated successfully!');
    }

    public function destroy(LearningGoal $learningGoal)
    {
        if ($learningGoal->user_id !== Auth::id()) {
            abort(403);
        }

        $learningGoal->delete();

        return back()->with('success', 'Learning goal deleted successfully!');
    }
}
