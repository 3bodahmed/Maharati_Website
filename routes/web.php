<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClientController;    
use App\Http\Controllers\PostController; 
use App\Http\Controllers\OrderController; 


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
Route::post('/delete-work-image', [ClientController::class, 'deleteWorkImage'])->name('delete.work.image');
Route::get('/profile/{user}', [ClientController::class, 'showPublicProfile'])->name('profile.show');
//Order routes
Route::resource('orders', OrderController::class)->middleware('auth');
Route::get('/orders/create/{post_id?}', [OrderController::class, 'create'])->name('orders.create')->middleware('auth');Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->middleware('auth');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update')->middleware('auth');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('auth');
