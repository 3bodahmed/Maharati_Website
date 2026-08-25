<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'حدث خطأ أثناء تسجيل الدخول عبر فيسبوك.');
        }

        $user = User::where('facebook_id', $facebookUser->id)->first();

        if (!$user) {
            // البحث بالإيميل إذا كان حساب فيسبوك يوفر إيميل معتمد
            $email = $facebookUser->getEmail() ?? $facebookUser->getId() . '@facebook.com';
            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name'        => $facebookUser->getName() ?? 'Facebook User',
                    'email'       => $email,
                    'username'    => Str::slug($facebookUser->getName() ?? 'fb_user') . '_' . Str::random(4),
                    'password'    => bcrypt(Str::random(16)),
                    'facebook_id' => $facebookUser->id,
                    'role'        => 'client',
                    'country'     => 'N/A',
                    'region'      => 'N/A',
                ]);
            } else {
                $user->facebook_id = $facebookUser->id;
                $user->save();
            }
        }

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'مرحباً أيها المدير!');
        }

        return redirect()->route('home')->with('success', 'مرحباً بك! تم تسجيل الدخول بنجاح.');
    }
}