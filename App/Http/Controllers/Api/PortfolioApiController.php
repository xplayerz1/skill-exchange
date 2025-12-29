<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioApiController extends Controller
{
    /**
     * Display all portfolios
     * GET /api/portfolios
     */
    public function index(Request $request)
    {
        $query = Portfolio::with(['user', 'skills']);

        // Optional filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Optional filter by skill
        if ($request->has('skill_id')) {
            $query->whereHas('skills', function($q) use ($request) {
                $q->where('skills.id', $request->skill_id);
            });
        }

        $portfolios = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Portfolios retrieved successfully',
            'data' => $portfolios
        ]);
    }

    /**
     * Display specific portfolio
     * GET /api/portfolios/{id}
     */
    public function show($id)
    {
        $portfolio = Portfolio::with(['user', 'skills'])->find($id);

        if (!$portfolio) {
            return response()->json([
                'success' => false,
                'message' => 'Portfolio not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Portfolio retrieved successfully',
            'data' => $portfolio
        ]);
    }
}
