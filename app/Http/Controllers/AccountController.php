<?php

namespace App\Http\Controllers;  
use Illuminate\View\View;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Auth;    
use App\Models\User;  
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
            'password' => ['required', 'string', 'min:8','confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. إنشاء المستخدم
        $user = User::create([
            'name'     => $request->fullname,      
            'username' => $request->username,
            'email'    => $request->email,
            'country'  => $request->country,
            'region'   => $request->region,
            'password' => Hash::make($request->password),
        ]);

     return redirect()->back()->with('success', 'تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول من هنا.');
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
        return redirect()->intended('/home')->with('success', 'مرحباً بعودتك! تم تسجيل الدخول بنجاح.');
    }

    return back()->withErrors([
        'login' => 'بيانات الدخول غير صحيحة. يرجى التحقق من اسم المستخدم أو البريد الإلكتروني وكلمة المرور.',
    ])->onlyInput('login');
}
}