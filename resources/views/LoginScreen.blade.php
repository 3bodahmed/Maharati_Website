<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <title>تسجيل الدخول - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
    <style>
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            color: #fff;
        }
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        .facebook-btn {
            background: #1877f2;
        }
        .facebook-btn:hover {
            background: #0d65d9;
            color: white;
        }
        .google-btn {
            background: #db4437;
        }
        .google-btn:hover {
            background: #c23321;
            color: white;
        }
        .guest-btn {
            background: #1a1a2e;
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
        }
        .guest-btn:hover {
            background: #2a2a4e;
            color: white;
        }
        .social-login {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    @if ($errors->any())
        <div class="error-messages">
            <h1 class="error-title">يوجد خطأ في البيانات المدخلة</h1>
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="success-message">
            <ul class="error-list">
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif

    <div class="login-container">
        <div class="login-image-container">
            <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" />
            <h1 class="login-title">في <span>مهارتي</span></h1>
            <h4 class="login-subtitle">
                نقدم لك فرص عمل حقيقية تناسب تخصصك<br />
                سواء كنت نجاراً، كهربائياً، سباكاً، خياطاً، أو أي حرفة أخرى.
                طور مسيرتك المهنية وانطلق بعملك.
            </h4>
        </div>

        <div class="login-form">
            <h1>تسجيل الدخول</h1>
            <p>يرجى إدخال بيانات الدخول الخاصة بك.</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <label for="username">اسم المستخدم أو البريد الإلكتروني:</label>
                <input
                    type="text"
                    id="username"
                    name="password_and_username"
                    required
                    placeholder="أدخل اسم المستخدم أو البريد الإلكتروني"
                    autocomplete="off"
                    value="{{ old('password_and_username') }}"
                />

                <label for="password">كلمة المرور:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="•••••••••••••••"
                    autocomplete="off"
                />

                <button type="submit">تسجيل الدخول</button>
            </form>

            <div class="divider">
                <h1>أو تسجيل الدخول عبر</h1>
            </div>

            <div class="social-login">
                {{-- فيسبوك --}}
                <a href="{{ route('facebook.redirect') }}" class="social-btn facebook-btn">
                    <i class="fab fa-facebook-f"></i> فيسبوك
                </a>

                {{-- جوجل (اختياري، يمكنك إزالته إذا أردت) --}}
                <a href="{{ route('google.redirect') }}" class="social-btn google-btn">
                    <i class="fab fa-google"></i> جوجل
                </a>

                {{-- بدون تسجيل دخول --}}
                <a href="{{ route('ShowVisitorHome') }}" class="social-btn guest-btn">
                    <i class="fas fa-user"></i> بدون تسجيل دخول
                </a>
            </div>

            <div class="register-link">
                <p>ليس لديك حساب؟ <a href="{{ route('signUpView') }}">انشاء حساب</a></p>
            </div>
            <div class="forgot-password">
                <p><a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a></p>
            </div>
        </div>
    </div>

    <footer class="guest-footer">
        <p>© {{ date('Y') }} <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorDiv = document.querySelector('.error-messages');
            var successDiv = document.querySelector('.success-message');
            if (errorDiv) {
                setTimeout(function() {
                    errorDiv.style.transition = 'opacity 0.8s ease';
                    errorDiv.style.opacity = '0';
                    setTimeout(function() { errorDiv.style.display = 'none'; }, 800);
                }, 3000);
            }
            if (successDiv) {
                setTimeout(function() {
                    successDiv.style.transition = 'opacity 0.8s ease';
                    successDiv.style.opacity = '0';
                    setTimeout(function() { successDiv.style.display = 'none'; }, 3000);
                }, 3000);
            }
        });
    </script>

</body>
</html>