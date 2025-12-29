<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;
use App\Models\Portfolio;
use App\Models\Topic;
use App\Models\Skill;
use App\Models\LearningGoal;
use App\Http\Controllers\PostController;
use Exception;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        // === USER STATISTICS ===
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $activeUsersThisWeek = User::where('updated_at', '>=', now()->subWeek())->count();
        
        // === POST STATISTICS ===
        $totalPosts = Post::count();
        $openForHelp = Post::where('type', 'open')->count();
        $needHelp = Post::where('type', 'need')->count();
        $postsThisWeek = Post::where('created_at', '>=', now()->subWeek())->count();
        
        // === SKILL & TOPIC STATISTICS ===
        $totalSkills = Skill::count();
        $totalTopics = Topic::count();
        
        // === OTHER CONTENT ===
        $totalPortfolios = Portfolio::count();
        $totalLearningGoals = LearningGoal::count();
        
        // === RECENT & POPULAR DATA ===
        $recentPosts = Post::with(['user', 'skills', 'topic'])
            ->latest()
            ->take(5)
            ->get();
        
        $popularSkills = Skill::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'newUsersThisMonth', 'activeUsersThisWeek',
            'totalPosts', 'openForHelp', 'needHelp', 'postsThisWeek',
            'totalSkills', 'totalTopics',
            'totalPortfolios', 'totalLearningGoals',
            'recentPosts', 'popularSkills'
        ));
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if (Auth::check() && Auth::user()->id === $user->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        try {
            $user->delete(); 
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage(), ['user_id' => $user->id]);
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function createUserForm()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'department' => 'required|string|max:255',
                'batch' => 'required|string|max:255',
                'description' => 'nullable|string',
                'role' => 'required|in:user,admin',
            ], [
                'name.required' => 'Name is required.',
                'name.max' => 'Name cannot exceed 255 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Invalid email format.',
                'email.unique' => 'Email is already registered.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'department.required' => 'Department is required.',
                'batch.required' => 'Batch is required.',
                'role.required' => 'Role must be selected.',
                'role.in' => 'Invalid role.',
            ]);

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->department = $request->input('department');
            $user->batch = $request->input('batch');
            $user->description = $request->input('description');
            $user->role = $request->input('role');
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'User added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in storeUser: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating user: ' . $e->getMessage());
        }
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
                'department' => 'required|string|max:255',
                'batch' => 'required|string|max:255',
                'description' => 'nullable|string',
                'role' => 'required|in:user,admin',
            ], [
                'name.required' => 'Name is required.',
                'name.max' => 'Name cannot exceed 255 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Invalid email format.',
                'email.unique' => 'Email is already registered.',
                'password.min' => 'Password must be at least 8 characters.',
                'department.required' => 'Department is required.',
                'batch.required' => 'Batch is required.',
                'role.required' => 'Role must be selected.',
                'role.in' => 'Invalid role.',
            ]);

            // Protection: admin cannot change their own role
            if (Auth::check() && Auth::user()->id === $user->id && $request->input('role') !== $user->role) {
                return back()->with('error', 'You cannot change your own role!');
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            
            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            
            $user->department = $request->input('department');
            $user->batch = $request->input('batch');
            $user->description = $request->input('description');
            $user->role = $request->input('role');
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in updateUser: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage(), ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'An error occurred while updating user: ' . $e->getMessage());
        }
    }

    public function posts()
    {
        try {
            $posts = Post::with(['user', 'topic', 'skills'])->latest()->paginate(20);
            return view('admin.posts.index', compact('posts'));
        } catch (\Exception $e) {
            \Log::error('Error fetching posts: ' . $e->getMessage());
            return back()->with('error', 'Failed to load posts list: ' . $e->getMessage());
        }
    }

    public function destroyPost(Post $post)
    {
        return (new PostController())->destroy($post);
        try {
            $post->delete();
            return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            $post->delete(); 
            return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting post: ' . $e->getMessage(), ['post_id' => $post->id]);
            return back()->with('error', 'Failed to delete post: ' . $e->getMessage());
        }
    }

    public function portfolios()
    {
        try {
            $portfolios = Portfolio::with('user')->latest()->paginate(20);
            return view('admin.portfolios.index', compact('portfolios'));
        } catch (\Exception $e) {
            \Log::error('Error fetching portfolios: ' . $e->getMessage());
            return back()->with('error', 'Failed to load portfolio list: ' . $e->getMessage());
        }
    }

    public function destroyPortfolio(Portfolio $portfolio)
    {
        try {
            $portfolio->delete();
            return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio deleted successfully.');
        } catch (\Exception $e) {
            $portfolio->delete(); 
            return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting portfolio: ' . $e->getMessage(), ['portfolio_id' => $portfolio->id]);
            return back()->with('error', 'Failed to delete portfolio: ' . $e->getMessage());
        }
    }

    public function topics()
    {
        $topics = Topic::orderBy('updated_at', 'desc')->paginate(20);
        return view('admin.topics.index', compact('topics'));
    }

    public function createTopicForm()
    {
        return view('admin.topics.create');
    }

    public function storeTopic(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ], [
                'title.required' => 'Topic title is required.',
                'title.max' => 'Title cannot exceed 255 characters.',
            ]);

            Topic::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.topics.index')->with('success', 'Topic added successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating topic: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating topic: ' . $e->getMessage());
        }
    }

    public function editTopic(Topic $topic)
    {
        return view('admin.topics.edit', compact('topic'));
    }

    public function updateTopic(Request $request, Topic $topic)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ], [
                'title.required' => 'Topic title is required.',
                'title.max' => 'Title cannot exceed 255 characters.',
            ]);

            $topic->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.topics.index')->with('success', 'Topic updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating topic: ' . $e->getMessage(), ['topic_id' => $topic->id]);
            return redirect()->back()->with('error', 'An error occurred while updating topic: ' . $e->getMessage());
        }
    }

    public function destroyTopic(Topic $topic)
    {
        try {
            $topic->delete();
            return redirect()->route('admin.topics.index')->with('success', 'Topic deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting topic: ' . $e->getMessage(), ['topic_id' => $topic->id]);
            return back()->with('error', 'Failed to delete topic: ' . $e->getMessage());
        }
    }
}