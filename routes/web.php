<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClientController;    
use App\Http\Controllers\PostController; 
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GoogleController;

// vistor routes 
Route::get('/', [ClientController::class, 'ShowVisitorHome'])->name('ShowVisitorHome');

// account routes
Route::get('/signup', [AccountController::class, 'signUpView'])->name('signUpView');
Route::get('/login', [AccountController::class, 'loginView'])->name('login');
Route::post('/createAcounte', [AccountController::class, 'signUp'])->name('signup');
Route::post('/register', [AccountController::class, 'Login'])->name('register');

Route::get('/forgot-password', [AccountController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AccountController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AccountController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AccountController::class, 'reset'])->name('password.update');


// post routes 
Route::get('/CreatePost', [PostController::class, 'ShowCreatePost'])->name('CreatePost')->middleware('auth');
Route::post('/posts', [PostController::class, 'createPost'])->name('posts.store')->middleware('auth');
Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy')->middleware('auth');
Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit')->middleware('auth');
Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update')->middleware('auth');
//client routes
Route::get('/home', [ClientController::class, 'getPost'])->name('home')->middleware('auth');
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


// ===== Routes الخاصة بالمدير =====

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // إدارة المستخدمين
Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::post('admin/users/toggle-role/{user}', [AdminController::class, 'toggleUserRole'])->name('admin.users.toggle-role');
Route::delete('admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // إدارة المنشورات
Route::get('admin/posts', [AdminController::class, 'posts'])->name('admin.posts');
Route::delete('admin/posts/{post}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');

    // إدارة الطلبات
Route::get('admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::put('admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
Route::delete('admin/orders/{order}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');



// تسجيل الدخول عبر فيسبوك
Route::get('/auth/facebook/redirect', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// تسجيل الدخول عبر جوجل 
Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);