<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <title>استعادة كلمة المرور - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
    <style>
        .otp-input-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 15px 0;
        }
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
            color: #fff;
            transition: 0.3s;
        }
        .otp-input:focus {
            border-color: var(--gold, #f1c40f);
            outline: none;
        }
        .step-content {
            display: none;
        }
        .step-content.active {
            display: block;
        }
        .message-box {
            width: 100%;
            text-align: center;
            padding: 12px;
            border-radius: 16px;
            margin-top: 15px;
            display: none;
        }
        .message-box.success {
            display: block;
            background: rgba(0, 184, 148, 0.2);
            border: 1px solid #00b894;
            color: #00b894;
        }
        .message-box.error {
            display: block;
            background: rgba(255, 71, 87, 0.2);
            border: 1px solid #ff4757;
            color: #ff4757;
        }
    </style>
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

    @if (session('status'))
        <div class="success-message">
            <ul class="error-list">
                <li>{{ session('status') }}</li>
            </ul>
        </div>
    @endif

    <div class="login-container">
        <div class="login-image-container">
            <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" />
            <h1 class="login-title">في <span>مهارتي</span></h1>
            <h4 class="login-subtitle">
                نقدم لك فرص عمل حقيقية تناسب تخصصك<br />
                طور مسيرتك المهنية وانطلق بعملك.
            </h4>
        </div>

        <div class="login-form">
            <h1>استعادة كلمة المرور</h1>
            <p id="stepDescription">أدخل بريدك الإلكتروني لإرسال رمز التحقق.</p>

            <!-- ===== الخطوة 1: البريد الإلكتروني ===== -->
            <div id="step1" class="step-content active">
                <form id="emailForm" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <label for="reset-email">البريد الإلكتروني:</label>
                    <input
                        type="email"
                        id="reset-email"
                        name="email"
                        required
                        placeholder="example@mail.com"
                        dir="ltr"
                        autocomplete="off"
                        value="{{ old('email') }}"
                    />
                    <button type="submit">إرسال رابط إعادة التعيين</button>
                </form>
                <div class="divider"><h1>أو</h1></div>
                <div class="register-link">
                    <p><a href="{{ route('login') }}">العودة لتسجيل الدخول</a></p>
                </div>
            </div>

            <!-- ===== الخطوة 2: رمز OTP (تذكير: يستخدم Laravel التوكن في الرابط، وليس OTP رقمي) ===== -->
            {{-- نستخدم الخطوة 2 لعرض رابط إعادة التعيين الذي يتم إرساله عبر البريد --}}
            <div id="step2" class="step-content">
                <p style="color: var(--text-light);">
                    تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.
                </p>
                <p style="color: var(--text-light); font-size: 14px;">
                    يرجى التحقق من صندوق الوارد (أو البريد المزعج) واتباع الرابط لإعادة تعيين كلمة المرور.
                </p>
                <div class="register-link" style="margin-top: 15px;">
                    <p><a href="{{ route('password.request') }}">إعادة إرسال الرابط</a></p>
                </div>
                <div class="register-link">
                    <p><a href="{{ route('login') }}">العودة لتسجيل الدخول</a></p>
                </div>
            </div>

            <!-- رسالة النجاح أو الخطأ -->
            <div id="messageBox" class="message-box"></div>
        </div>
    </div>

    <footer class="guest-footer">
        <p>© {{ date('Y') }} <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorDiv = document.querySelector('.error-messages');
            const successDiv = document.querySelector('.success-message');
            if (errorDiv) {
                setTimeout(() => {
                    errorDiv.style.transition = 'opacity 0.8s ease';
                    errorDiv.style.opacity = '0';
                    setTimeout(() => errorDiv.style.display = 'none', 800);
                }, 3000);
            }
            if (successDiv) {
                setTimeout(() => {
                    successDiv.style.transition = 'opacity 0.8s ease';
                    successDiv.style.opacity = '0';
                    setTimeout(() => successDiv.style.display = 'none', 3000);
                }, 3000);
            }
        });
    </script>

</body>
</html>