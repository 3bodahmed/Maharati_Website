<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'حدث خطأ أثناء تسجيل الدخول عبر جوجل.');
        }

        $user = User::where('google_id', $googleUser->id)->first();

      if (!$user) {
    $user = User::create([
        'name'      => $googleUser->name,
        'email'     => $googleUser->email,
        'username'  => Str::slug($googleUser->name) . '_' . Str::random(4),
        'password'  => bcrypt(Str::random(16)),
        'google_id' => $googleUser->id,
        'role'      => 'client',
        'country'   => 'N/A', 
        'region'    => 'N/A', 
    ]);
} else {
    $user->google_id = $googleUser->id;
    $user->save();
}

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'مرحباً أيها المدير!');
        }

        return redirect()->route('home')->with('success', 'مرحباً بك! تم تسجيل الدخول بنجاح.');
    }
}