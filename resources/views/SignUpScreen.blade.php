<!doctype html>
<html lang="ar">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="SignUpScreen.css" />
        <title>إنشاء حساب - مهارتي</title>
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
     @if (session('success'))
        <div class="success-message">
            <h1 class="error-title">تم إنشاء الحساب بنجاح</h1>
            <ul class="error-list">
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
             
        <div class="login-container"> 
            <div class="login-image-container">
                <img src="Logo.png" alt="شعار مهارتي" loading="lazy" />
                <h1 class="login-title">في <span>مهارتي</span></h1>
                <h4 class="login-subtitle">
                    نقدم لك فرص عمل حقيقية تناسب تخصصك<br />
                    طور مسيرتك المهنية وانطلق بعملك.
                </h4>
            </div>

          

            <div class="login-form">
                <h1>إنشاء حساب جديد</h1>
                <p>املأ البيانات التالية لبدء رحلتك.</p>

                <form action="/createAcounte" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="fullname">الاسم الكامل:</label>
                    <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}" required placeholder="أدخل اسمك الثلاثي" />
                   
                
                    <label for="reg-username">اسم المستخدم:</label>
                    <input type="text" id="reg-username" name="username" value="{{ old('username') }}" required placeholder="اختر اسم مستخدم" />

                    <label for="email">البريد الإلكتروني:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="example@mail.com" />

                    <label for="country">الدولة:</label>
                    <input type="text" id="country" name="country" value="{{ old('country') }}" required placeholder="أدخل اسم دولة" />

                    <label for="region">المنطقة:</label>
                    <input type="text" id="region" name="region" value="{{ old('region') }}" required placeholder="أدخل اسم منطقة" />

                    <label for="reg-password">كلمة المرور:</label>
                    <input type="password" id="reg-password" name="password" required placeholder="•••••••••••••••" />

                    <label for="confirm-password">تأكيد كلمة المرور:</label>
                    <input type="password" id="confirm-password" name="password_confirmation" required placeholder="أعد كتابة كلمة المرور" />
                    
                    <button type="submit">إنشاء الحساب</button>
                </form>

                <div class="divider"><h1>أو</h1></div>

                <div class="social-login">
                    <button class="facebook-login">فيسبوك</button>
                    <button class="google-login">جوجل</button>
                </div>

                <div class="register-link">
                    <p>لديك حساب بالفعل؟ <a href="/login">سجل دخول الآن</a></p>
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
     document.addEventListener('DOMContentLoaded', function() {
        var successDiv = document.querySelector('.success-message');
        if (successDiv) {
            setTimeout(function() {
                successDiv.style.transition = 'opacity 0.8s ease';
                successDiv.style.opacity = '0';
                setTimeout(function() {
                    successDiv.style.display = 'none';
                }, 800);
            }, 3000);
        }
    });
</script>
</html>
