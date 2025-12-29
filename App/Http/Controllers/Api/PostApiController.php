<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * Display all posts
     * GET /api/posts
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'skills', 'topic']);

        // Optional filters
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('skill_id')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('skills.id', $request->skill_id);
            });
        }

        if ($request->has('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        $posts = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully',
            'data' => $posts
        ]);
    }

    /**
     * Display specific post
     * GET /api/posts/{id}
     */
    public function show($id)
    {
        $post = Post::with(['user', 'skills', 'topic'])->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post retrieved successfully',
            'data' => $post
        ]);
    }
}
