<?php

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


Route::get('/', 'Blog@index')->name('home');
Route::get('/tag/{tagId}', 'Blog@indexByTag')->name('byTag');
Route::get('/post/{id}', 'Blog@post')->name('post');
Route::get('/rss/main.rss', 'Blog@rss')->name('rss');
Route::get('/search', 'Blog@search')->name('search');
Route::get('/unsubscribe/{hash}', 'User@unsubscribe')->name('unsubscribe');

Route::middleware('auth')->group(function () {
    Route::get('/profile', 'User@showProfile')->name('profile');
    Route::post('/profile', 'User@saveProfile')->name('save-profile');

    Route::post('/comment', 'Blog@comment')->name('comment')->middleware('throttle:2,1');
    Route::get('/delete-comment/{commentId}', 'Blog@deleteComment')->name('delete-comment');
});

Route::middleware(['auth', 'admin'])->prefix('/admin')->group(function () {
    Route::get('/users', 'Admin\Users@index')->name('a.users');
});

Auth::routes(['verify' => true]);
