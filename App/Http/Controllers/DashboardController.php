<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Skill;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'skills', 'topic']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('skills', function($skillQuery) use ($search) {
                      $skillQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('skill_id') && $request->skill_id) {
            $query->whereHas('skills', function($skillQuery) use ($request) {
                $skillQuery->where('skills.id', $request->skill_id);
            });
        }

        if ($request->has('topic_id') && $request->topic_id) {
            $query->where('topic_id', $request->topic_id);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Load ALL skills for post creation
        $allSkills = Skill::orderBy('category')->orderBy('name')->get();
        $topics = Topic::orderBy('title')->get();

        return view('dashboard', compact('posts', 'allSkills', 'topics'));
    }
}