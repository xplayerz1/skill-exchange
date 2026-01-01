<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LearningGoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\SkillController;

// API Controllers
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\PortfolioApiController;
use App\Http\Controllers\Api\LearningGoalApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\SkillApiController;
use App\Http\Controllers\Api\TopicApiController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==========================================
// REST API ROUTES (GET Only)
// ==========================================
Route::prefix('api')->group(function () {
    // Posts API
    Route::get('/posts', [PostApiController::class, 'index']);
    Route::get('/posts/{id}', [PostApiController::class, 'show']);
    
    // Portfolios API
    Route::get('/portfolios', [PortfolioApiController::class, 'index']);
    Route::get('/portfolios/{id}', [PortfolioApiController::class, 'show']);
    
    // Learning Goals API
    Route::get('/learning-goals', [LearningGoalApiController::class, 'index']);
    Route::get('/learning-goals/{id}', [LearningGoalApiController::class, 'show']);
    
    // Users API
    Route::get('/users', [UserApiController::class, 'index']);
    Route::get('/users/{id}', [UserApiController::class, 'show']);
    
    // Skills API
    Route::get('/skills', [SkillApiController::class, 'index']);
    Route::get('/skills/{id}', [SkillApiController::class, 'show']);
    
    // Topics API
    Route::get('/topics', [TopicApiController::class, 'index']);
    Route::get('/topics/{id}', [TopicApiController::class, 'show']);
});

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// User area 
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Learning Goals
    Route::get('/learning-goals', [LearningGoalController::class, 'index'])->name('learning-goals.index');
    Route::post('/learning-goals', [LearningGoalController::class, 'store'])->name('learning-goals.store');
    Route::put('/learning-goals/{learningGoal}', [LearningGoalController::class, 'update'])->name('learning-goals.update');
    Route::delete('/learning-goals/{learningGoal}', [LearningGoalController::class, 'destroy'])->name('learning-goals.destroy');

    // Portfolio
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::put('/portfolio/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
    
    // Edit Profile 
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Skill Management
    Route::post('/profile/skills', [ProfileController::class, 'attachSkill'])->name('profile.skills.attach');
    Route::delete('/profile/skills/{skill}', [ProfileController::class, 'detachSkill'])->name('profile.skills.detach');
    Route::delete('/profile/user-skills/{userSkill}', [ProfileController::class, 'detachUserSkill'])->name('profile.user-skills.detach');
    
    // Public User Profile (View other users' portfolios)
    Route::get('/user/{user}', [ProfileController::class, 'show'])->name('user.profile');
});

// Admin area
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUserForm'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Posts
    Route::get('/posts', [AdminController::class, 'posts'])->name('posts.index');
    Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');

    // Topics
    Route::get('/topics', [AdminController::class, 'topics'])->name('topics.index');
    Route::get('/topics/create', [AdminController::class, 'createTopicForm'])->name('topics.create');
    Route::post('/topics', [AdminController::class, 'storeTopic'])->name('topics.store');
    Route::get('/topics/{topic}/edit', [AdminController::class, 'editTopic'])->name('topics.edit');
    Route::put('/topics/{topic}', [AdminController::class, 'updateTopic'])->name('topics.update');
    Route::delete('/topics/{topic}', [AdminController::class, 'destroyTopic'])->name('topics.destroy');

    // Skills
    Route::resource('skills', SkillController::class);
});
