<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillApiController extends Controller
{
    /**
     * Display all skills
     * GET /api/skills
     */
    public function index(Request $request)
    {
        $query = Skill::query();

        // Optional filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Optional search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $skills = $query->orderBy('name')->paginate(50);

        return response()->json([
            'success' => true,
            'message' => 'Skills retrieved successfully',
            'data' => $skills
        ]);
    }

    /**
     * Display specific skill
     * GET /api/skills/{id}
     */
    public function show($id)
    {
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Skill retrieved successfully',
            'data' => $skill
        ]);
    }
}
