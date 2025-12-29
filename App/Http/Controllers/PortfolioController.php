<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class PortfolioController extends Controller
{

    public function index()
    {
        $targetUser = Auth::user();
        $targetUser->load('userSkills'); // Load personal skills for dropdown
        
        $portfolios = Portfolio::where('user_id', $targetUser->id)
                               ->with(['skills', 'userSkills'])
                               ->latest()
                               ->get();
        $skills = Skill::orderBy('name')->get();
        
        return view('profile', compact('targetUser', 'portfolios', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'user_skills' => 'nullable|array',
            'user_skills.*' => 'exists:user_skills,id',
        ]);
        
        if (empty($request->skills) && empty($request->user_skills)) {
            return back()->withErrors(['skills' => 'Please select at least one skill (Global or Personal).']);
        }

        $portfolio = Portfolio::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        if ($request->has('skills')) {
            $portfolio->skills()->attach($request->skills);
        }

        if ($request->has('user_skills')) {
            $portfolio->userSkills()->attach($request->user_skills);
        }

        return redirect()->route('portfolio.index')->with('success', 'Portfolio added successfully!');
    }


    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); 
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'user_skills' => 'nullable|array',
            'user_skills.*' => 'exists:user_skills,id',
        ]);

        if (empty($request->skills) && empty($request->user_skills)) {
            return back()->withErrors(['skills' => 'Please select at least one skill (Global or Personal).']);
        }

        $portfolio->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]); 

        // Sync Global Skills
        if ($request->has('skills')) {
            $portfolio->skills()->sync($request->skills);
        } else {
            $portfolio->skills()->detach();
        }

        // Sync Personal User Skills
        if ($request->has('user_skills')) {
            $portfolio->userSkills()->sync($request->user_skills);
        } else {
            $portfolio->userSkills()->detach();
        } 

        return redirect()->route('portfolio.index')->with('success', 'Portfolio updated successfully!');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($portfolio->file_path && Storage::disk('public')->exists($portfolio->file_path)) {
            Storage::disk('public')->delete($portfolio->file_path);
        }

        $portfolio->delete();

        return redirect()->route('portfolio.index')->with('success', 'Portfolio deleted successfully!');
    }
}