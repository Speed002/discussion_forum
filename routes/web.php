<?php

use App\Http\Controllers\DiscussionDestroyController;
use App\Http\Controllers\DiscussionShowController;
use App\Http\Controllers\DiscussionSolutionPatchController;
use App\Http\Controllers\DiscussionStoreController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForumIndexController;
use App\Http\Controllers\MarkdownController;
use App\Http\Controllers\PostDestroyController;
use App\Http\Controllers\PostPatchController;
use App\Http\Controllers\PostStoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// _____________________________________________________


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// we changed this route from dashboard to home page
Route::get('/', ForumIndexController::class)->name('home');

Route::get('/discussions/{discussion:slug}', DiscussionShowController::class)->name('discussion.show');
Route::post('/discussions', DiscussionStoreController::class)->name('discussion.store');

Route::post('/discussions/{discussion}/posts', PostStoreController::class)->name('posts.store');
Route::patch('/posts/{post}', PostPatchController::class)->name('posts.patch');
Route::delete('/posts/{post}', PostDestroyController::class)->name('posts.destroy');
Route::delete('/discussions/{discussion}', DiscussionDestroyController::class)->name('discussions.destroy');
Route::patch('/discussions/{discussion}/solution', DiscussionSolutionPatchController::class)->name('discussions.solution.patch');

Route::post('/markdown', MarkdownController::class)->name('markdown');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
