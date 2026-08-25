<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <title>إعادة تعيين كلمة المرور - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
</head>
<body>

    @if ($errors->any())
        <div class="error-messages">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-container">
        <div class="login-image-container">
            <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" />
            <h1 class="login-title">في <span>مهارتي</span></h1>
            <h4 class="login-subtitle">أدخل كلمة المرور الجديدة</h4>
        </div>

        <div class="login-form">
            <h1>إعادة تعيين كلمة المرور</h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}" />

                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" required placeholder="example@mail.com" value="{{ old('email') }}" />

                <label for="password">كلمة المرور الجديدة:</label>
                <input type="password" id="password" name="password" required placeholder="•••••••••••••••" />

                <label for="password_confirmation">تأكيد كلمة المرور:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="أعد كتابة كلمة المرور" />

                <button type="submit">إعادة تعيين كلمة المرور</button>
            </form>

            <div class="register-link">
                <p><a href="{{ route('login') }}">العودة لتسجيل الدخول</a></p>
            </div>
        </div>
    </div>

    <footer class="guest-footer">
        <p>© {{ date('Y') }} <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorDiv = document.querySelector('.error-messages');
            if (errorDiv) {
                setTimeout(() => {
                    errorDiv.style.transition = 'opacity 0.8s ease';
                    errorDiv.style.opacity = '0';
                    setTimeout(() => errorDiv.style.display = 'none', 800);
                }, 3000);
            }
        });
    </script>
</body>
</html>