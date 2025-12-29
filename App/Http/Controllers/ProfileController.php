<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(?User $user = null)
    {
        $targetUser = $user ?? Auth::user(); 

        if (!$targetUser) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat profil.');
        }

        $targetUser->load('skills');

        $portfolios = Portfolio::where('user_id', $targetUser->id)
                                ->with('skills') 
                                ->latest()
                                ->get();

        $skills = Skill::orderBy('name')->get(); 

        return view('profile', compact('targetUser', 'portfolios', 'skills')); 

    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'department' => 'required|string',
            'batch' => 'required|string',
            'description' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'batch' => $request->batch,
            'description' => $request->description,
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    public function attachSkill(Request $request)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        
        $skillName = trim($request->skill_name);
        
        $skill = Skill::firstOrCreate(
            ['name' => $skillName],
            ['category' => 'user-generated'] 
        );
        
        if ($user->skills()->where('skill_id', $skill->id)->exists()) {
            return back()->with('error', 'Skill "' . $skillName . '" has already been added.');
        }

        $user->skills()->attach($skill->id);

        return back()->with('success', 'Skill "' . $skillName . '" added successfully!');
    }

    public function detachSkill(Skill $skill)
    {
        $user = Auth::user();
        $user->skills()->detach($skill->id);

        return back()->with('success', 'Skill removed successfully!');
    }
    
    /**
     * Show the edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Delete user account (only for non-admin users)
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        // Prevent admin from deleting their own account
        if ($user->is_admin || $user->role === 'admin') {
            return back()->with('error', 'Admin cannot delete their own account.');
        }
        
        // Verify password before deletion
        $request->validate([
            'password' => 'required|string',
        ]);
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }
        
        // Logout and delete user
        Auth::logout();
        $user->delete();
        
        return redirect()->route('home')->with('success', 'Account deleted successfully.');
    }
}