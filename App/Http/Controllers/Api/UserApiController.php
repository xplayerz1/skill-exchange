<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    /**
     * Display all users
     * GET /api/users
     */
    public function index(Request $request)
    {
        $query = User::with('skills');

        // Optional filter by department
        if ($request->has('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }

        // Optional filter by batch
        if ($request->has('batch')) {
            $query->where('batch', $request->batch);
        }

        // Optional filter by skill
        if ($request->has('skill_id')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('skills.id', $request->skill_id);
            });
        }

        $users = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully',
            'data' => $users
        ]);
    }

    /**
     * Display specific user
     * GET /api/users/{id}
     */
    public function show($id)
    {
        $user = User::with(['skills', 'portfolios', 'learningGoals'])->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully',
            'data' => $user
        ]);
    }
}
