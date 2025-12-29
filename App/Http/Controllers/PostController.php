<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:open,need',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'preference' => 'required|in:online,offline,both',
            'topic_id' => 'nullable|exists:topics,id',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'topic_id' => $request->topic_id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'preference' => $request->preference,
        ]);

        $post->skills()->attach($request->skills);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Post created successfully!');
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:open,need',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:today',
            'preference' => 'required|in:online,offline,both',
            'topic_id' => 'nullable|exists:topics,id',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id',
        ]);

        $post->update([
            'type' => $request->type,
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'preference' => $request->preference,
        ]);

        $post->skills()->sync($request->skills);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id && !(Auth::check() && Auth::user()->is_admin)) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }

        try {
            $post->delete();

            if (Auth::check() && Auth::user()->is_admin) {
                return redirect()
                    ->route('admin.posts.index')
                    ->with('success', 'Post deleted successfully by Admin.');
            }

            return redirect()
                ->route('dashboard')
                ->with('success', 'Your post has been deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting post', [
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to delete post.');
        }
    }
}
