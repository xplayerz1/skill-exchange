<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('updated_at', 'desc')->get();
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name',
            'category' => 'required|string|max:255',
            'custom_category' => 'nullable|string|max:255',
        ]);

        $category = $request->custom_category ?: $request->category;

        Skill::create([
            'name' => $request->name,
            'category' => $category,
        ]);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill created successfully!');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $skill->id,
            'category' => 'required|string|max:255',
            'custom_category' => 'nullable|string|max:255',
        ]);

        $category = $request->custom_category ?: $request->category;

        $skill->update([
            'name' => $request->name,
            'category' => $category,
        ]);

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        // Check if skill is being used
        if ($skill->users()->count() > 0 || $skill->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete skill that is currently in use.');
        }

        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully!');
    }
}
