<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LearningGoal;
use Illuminate\Http\Request;

class LearningGoalApiController extends Controller
{
    /**
     * Display all learning goals
     * GET /api/learning-goals
     */
    public function index(Request $request)
    {
        $query = LearningGoal::with(['user', 'topic', 'skill']);

        // Optional filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Optional filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $learningGoals = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Learning goals retrieved successfully',
            'data' => $learningGoals
        ]);
    }

    /**
     * Display specific learning goal
     * GET /api/learning-goals/{id}
     */
    public function show($id)
    {
        $learningGoal = LearningGoal::with(['user', 'topic', 'skill'])->find($id);

        if (!$learningGoal) {
            return response()->json([
                'success' => false,
                'message' => 'Learning goal not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Learning goal retrieved successfully',
            'data' => $learningGoal
        ]);
    }
}
