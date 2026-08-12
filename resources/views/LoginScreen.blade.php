<!doctype html>
<html lang="ar">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="LoginScreen.css" />
        <title>تسجيل الدخول - مهارتي</title>
        <link rel="icon" href="Logo.png" />
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
        <div class="login-container">
            <div class="login-image-container">
                <img src="Logo.png" alt="شعار مهارتي" />
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

                <form action="/register" method="POST" enctype="multipart/form-data">
                    @csrf
    

                    <label for="username">  اسم المستخدم او البريد الالكتروني  :</label>
                    <input
                        type="text"
                        id="username"
                        name="password_and_username"
                        required
                        placeholder="أدخل اسم المستخدم أو البريد الإلكتروني"
                        autocomplete=none
                        value="{{ old('password_and_username') }}"
                    />

                    <label for="password">كلمة المرور:</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="•••••••••••••••"
                        autocomplete=none
                       
                    />

                    <button type="submit">تسجيل الدخول</button>
                </form>

                <div class="divider">
                    <h1>أو تسجيل الدخول عبر</h1>
                </div>

                <div class="social-login">
                    <button class="facebook-login">
                         فيسبوك
                    </button>
                    <button class="google-login">
                        جوجل
                    </button>
                </div>

                <div class="register-link">
                    <p>ليس لديك حساب؟ <a href="/signup">انشاء حساب</a></p>
                </div>
                <div class="forgot-password">
                    <p><a href="ForgetPasswordScreen.html">نسيت كلمة المرور؟</a></p>
                </div>
            </div>
        </div>
    </body>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorDiv = document.querySelector('.error-messages');
        if (errorDiv) {
            setTimeout(function() {
                errorDiv.style.transition = 'opacity 0.8s ease';
                errorDiv.style.opacity = '0';
                setTimeout(function() {
                    errorDiv.style.display = 'none';
                }, 800);
            }, 3000);
        }
    });
    </script>
</html>

  