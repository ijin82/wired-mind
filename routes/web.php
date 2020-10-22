<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog;
use App\Http\Controllers\User;
use App\Http\Controllers\Admin\Users as AdmUsers;
use App\Http\Controllers\Admin\Posts as AdmPosts;
use App\Http\Controllers\Admin\Comments as AdmComments;

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

Route::get('/', [Blog::class, 'index'])->name('home');
Route::get('/tag/{tagId}', [Blog::class, 'indexByTag'])->name('byTag');
Route::get('/post/{id}', [Blog::class, 'post'])->name('post');
Route::get('/rss/main.rss', [Blog::class, 'rss'])->name('rss');
Route::get('/search', [Blog::class, 'search'])->name('search');
Route::get('/unsubscribe/{hash}', [User::class, 'unsubscribe'])->name('unsubscribe');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [User::class, 'showProfile'])->name('profile');
    Route::post('/profile', [User::class, 'saveProfile'])->name('save-profile');

    Route::post('/comment', [Blog::class, 'comment'])->name('comment')->middleware('throttle:2,1');
    Route::get('/delete-comment/{commentId}', [Blog::class, 'deleteComment'])->name('delete-comment');
});

Route::middleware(['auth', 'admin'])->prefix('/admin')->group(function () {
    Route::get('/users', [AdmUsers::class, 'index'])->name('a.users');
    Route::get('/comments', [AdmComments::class, 'index'])->name('a.comments');
    Route::get('/posts', [AdmPosts::class, 'index'])->name('a.posts');
    Route::get('/posts/{id}', [AdmPosts::class, 'show'])->name('a.posts.show');
    Route::post('/posts/{id}', [AdmPosts::class, 'save'])->name('a.posts.save');
});

Auth::routes(['verify' => true]);
