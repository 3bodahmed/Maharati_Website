<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClientController;    
use App\Http\Controllers\PostController; 


Route::get('/', [ClientController::class, 'ShowVisitorHome'])->name('ShowVisitorHome');
Route::get('/home', [ClientController::class, 'getPost'])->name('home')->middleware('auth');

// account routes
Route::get('/signup', [AccountController::class, 'signUpView']);
Route::get('/login', [AccountController::class, 'loginView'])->name('login');

Route::post('/createAcounte', [AccountController::class, 'signUp']);
Route::post('/register', [AccountController::class, 'Login']);

//client routes
Route::get('/CreatePost', [PostController::class, 'ShowCreatePost'])->name('CreatePost')->middleware('auth');
Route::post('/posts', [PostController::class, 'createPost'])->name('posts.store')->middleware('auth');
Route::get('/profile', [ClientController::class, 'showProfile'])->name('profile')->middleware('auth');
Route::get('/ShowEditProfile', [ClientController::class, 'EditProfile'])->name('EditProfile')->middleware('auth');
Route::post('/CreateProfile', [ClientController::class, 'CreateProfile'])->name('CreateProfile')->middleware('auth');