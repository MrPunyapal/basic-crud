<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// alternative to the above
// Route::view('/','welcome');

// set locale cookie
Route::get('/set-locale/{locale}', fn ($locale) => back()->withCookie(cookie()->forever('locale', $locale)))->name('set-locale');

// redirect to posts
Route::redirect('/', '/posts');

// resource route for posts controller (all routes)
Route::resource('posts', App\Http\Controllers\PostController::class);

// feature post route (patch request) - only one route needed
Route::patch('/posts/{post}/feature', App\Http\Controllers\FeaturedPostController::class)->name('posts.featured');

// other option to do the same thing
// Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
// Route::get('/posts/create', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
// Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
// Route::get('/posts/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
// Route::get('/posts/{post}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
// Route::put('/posts/{post}', [App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
// Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
