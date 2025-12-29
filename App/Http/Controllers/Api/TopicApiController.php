<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicApiController extends Controller
{
    /**
     * Display all topics
     * GET /api/topics
     */
    public function index(Request $request)
    {
        $query = Topic::query();

        // Optional search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $topics = $query->orderBy('title')->paginate(50);

        return response()->json([
            'success' => true,
            'message' => 'Topics retrieved successfully',
            'data' => $topics
        ]);
    }

    /**
     * Display specific topic
     * GET /api/topics/{id}
     */
    public function show($id)
    {
        $topic = Topic::find($id);

        if (!$topic) {
            return response()->json([
                'success' => false,
                'message' => 'Topic not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Topic retrieved successfully',
            'data' => $topic
        ]);
    }
}
