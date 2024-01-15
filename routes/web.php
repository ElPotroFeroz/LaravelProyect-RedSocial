<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//USER
Route::get('/configuracion', [App\Http\Controllers\UserController::class, 'config'])->name('config');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/avatar/{filename}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.avatar');
Route::get('/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
Route::post('/search', [App\Http\Controllers\UserController::class, 'search'])->name('user.search');
//IMAGE
Route::get('/image/create', [App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [App\Http\Controllers\ImageController::class, 'getImage'])->name('image.file');
Route::get('/imagedetail/{id}', [App\Http\Controllers\ImageController::class, 'detail'])->name('image.detail');
Route::get('/image/delete/{id}', [App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/edit/{id}', [App\Http\Controllers\ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');
//COMENT
Route::post('/coment/save', [App\Http\Controllers\ComentController::class, 'save'])->name('coment.save');
Route::get('/coment/delete/{id}', [App\Http\Controllers\ComentController::class, 'delete'])->name('coment.delete');
//LIKE
Route::get('/like/{image_id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like');
Route::get('/dislike/{image_id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('dislike');
Route::get('/lista/likes', [App\Http\Controllers\LikeController::class, 'index'])->name('likes');
