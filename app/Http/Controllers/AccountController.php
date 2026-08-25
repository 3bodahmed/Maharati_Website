<?php

namespace App\Http\Controllers;  
use Illuminate\View\View;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Auth;    
use App\Models\User;  
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class AccountController  
{
    public function signUpView()  
    {
        return view('SignUpScreen');
    }
    
     public function loginView()  
    {
        return view('LoginScreen');
    }


    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country'  => ['required', 'string', 'max:255'],
            'region'   => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:client'], 
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name'     => $request->fullname,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'country'  => $request->country,
            'region'   => $request->region,
            'role'     => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'password_and_username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('password_and_username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'مرحباً أيها المدير!');
        }
            return redirect()->route('home')->with('success', 'مرحباً بعودتك!');
        }

        return back()->withErrors([
            'login' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function showLinkRequestForm()
        {
            return view('ForgetPasswordScreen'); // اسم الـ View الخاص بك
        }

    public function sendResetLinkEmail(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $response = Password::sendResetLink($request->only('email'));

            if ($response == Password::RESET_LINK_SENT) {
                return redirect()->route('password.request')->with('status', trans($response));
            }

            return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    public function showResetForm($token)
    {
        return view('reset-password', ['token' => $token]); // أنشئ هذه الـ View
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', trans($response));
        }

        return redirect()->back()->withErrors(['email' => trans($response)]);
    }


    }