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
        $portfolios = Portfolio::where('user_id', $targetUser->id)
                               ->with('skills')
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
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ]);

        $portfolio = Portfolio::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        $portfolio->skills()->attach($request->skills);

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
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ]);

        $portfolio->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]); 

        $portfolio->skills()->sync($request->skills); 

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