<!doctype html>
<html lang="ar">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="ForgetPasswordScreen.css" />
        <title>استعادة كلمة المرور - مهارتي</title>
        <link rel="icon" href="Logo.png" />
    </head>
    <body>
        <div class="login-container">
            <!-- القسم الأيسر (ثابت) -->
            <div class="login-image-container">
                <img src="Logo.png" alt="شعار مهارتي" />
                <h1 class="login-title">في <span>مهارتي</span></h1>
                <h4 class="login-subtitle">
                    نقدم لك فرص عمل حقيقية تناسب تخصصك<br />
                    طور مسيرتك المهنية وانطلق بعملك.
                </h4>
            </div>

            <!-- القسم الأيمن (نموذج استعادة كلمة المرور) -->
            <div class="login-form">
                <h1>استعادة كلمة المرور</h1>
                <p id="stepDescription">أدخل بريدك الإلكتروني لإرسال رمز التحقق.</p>

                <!-- ====== الخطوة 1: البريد الإلكتروني ====== -->
                <div id="step1" class="step-content">
                    <form id="emailForm" onsubmit="sendOTP(event)">
                        <label for="reset-email">البريد الإلكتروني:</label>
                        <input
                            type="email"
                            id="reset-email"
                            name="email"
                            required
                            placeholder="example@mail.com"
                            dir="ltr"
                            autocomplete="off"
                        />
                        <button type="submit">إرسال رمز التحقق</button>
                    </form>
                    <div class="divider"><h1>أو</h1></div>
                    <div class="register-link">
                        <p><a href="LoginScreen.html">العودة لتسجيل الدخول</a></p>
                    </div>
                </div>

                <!-- ====== الخطوة 2: رمز OTP ====== -->
                <div id="step2" class="step-content" style="display: none;">
                    <p style="color: var(--text-light); font-size: 14px; margin-bottom: 15px;">
                        تم إرسال رمز التحقق إلى <strong id="displayEmail">example@mail.com</strong>
                    </p>
                    <form id="otpForm" onsubmit="verifyOTP(event)">
                        <label>أدخل رمز التحقق (4 أرقام):</label>
                        <div class="otp-input-container">
                            <input type="text" maxlength="1" class="otp-input" id="otp1" oninput="moveToNext(this, 'otp2')" required autocomplete="off"/>
                            <input type="text" maxlength="1" class="otp-input" id="otp2" oninput="moveToNext(this, 'otp3')" required autocomplete="off"/>
                            <input type="text" maxlength="1" class="otp-input" id="otp3" oninput="moveToNext(this, 'otp4')" required autocomplete="off"/>
                            <input type="text" maxlength="1" class="otp-input" id="otp4" oninput="moveToNext(this, 'otp4')" required autocomplete="off"/>
                        </div>
                        <button type="submit">تحقق من الرمز</button>
                    </form>
                    <div class="register-link" style="margin-top: 15px;">
                        <p><a href="#" onclick="resendOTP(); return false;">إعادة إرسال الرمز</a></p>
                    </div>
                    <div class="register-link">
                        <p><a href="LoginScreen.html">العودة لتسجيل الدخول</a></p>
                    </div>
                </div>

                <!-- ====== الخطوة 3: كلمة مرور جديدة ====== -->
                <div id="step3" class="step-content" style="display: none;">
                    <form id="resetForm" onsubmit="resetPassword(event)">
                        <label for="new-password">كلمة المرور الجديدة:</label>
                        <input
                            type="password"
                            id="new-password"
                            name="new-password"
                            required
                            placeholder="•••••••••••••••"
                        />

                        <label for="confirm-new-password">تأكيد كلمة المرور:</label>
                        <input
                            type="password"
                            id="confirm-new-password"
                            name="confirm-new-password"
                            required
                            placeholder="أعد كتابة كلمة المرور"
                        />

                        <button type="submit">إعادة تعيين كلمة المرور</button>
                    </form>
                    <div class="register-link" style="margin-top: 15px;">
                        <p><a href="LoginScreen.html">العودة لتسجيل الدخول</a></p>
                    </div>
                </div>

                <!-- رسالة نجاح أو خطأ -->
                <div id="messageBox" style="display: none; width: 100%; text-align: center; padding: 12px; border-radius: 16px; margin-top: 15px;"></div>
            </div>
        </div>

        <script>
            // ------ دالة الانتقال بين الخطوات ------
            function showStep(step) {
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'none';
                document.getElementById('step3').style.display = 'none';
                if (step === 1) document.getElementById('step1').style.display = 'block';
                else if (step === 2) document.getElementById('step2').style.display = 'block';
                else if (step === 3) document.getElementById('step3').style.display = 'block';
                document.getElementById('messageBox').style.display = 'none';
            }

            // ------ الخطوة 1: إرسال البريد ------
            function sendOTP(e) {
                e.preventDefault();
                const email = document.getElementById('reset-email').value;
                if (!email) return;
                // محاكاة إرسال البريد (في الواقع ترسل طلب للخادم)
                document.getElementById('displayEmail').innerText = email;
                showMessage('تم إرسال رمز التحقق إلى بريدك الإلكتروني.', 'success');
                // الانتقال للخطوة 2 بعد ثانية
                setTimeout(() => {
                    showStep(2);
                }, 1000);
            }

            // ------ التنقل التلقائي بين حقول OTP ------
            function moveToNext(current, nextId) {
                if (current.value.length === 1) {
                    if (nextId) {
                        document.getElementById(nextId).focus();
                    }
                }
                // السماح بالرجوع بالضغط على Backspace
                current.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value.length === 0) {
                        const prev = this.previousElementSibling;
                        if (prev) prev.focus();
                    }
                });
            }

            // ------ الخطوة 2: التحقق من OTP ------
            function verifyOTP(e) {
                e.preventDefault();
                let otp = '';
                for (let i = 1; i <= 4; i++) {
                    otp += document.getElementById('otp' + i).value;
                }
                if (otp.length !== 4) {
                    showMessage('يرجى إدخال رمز التحقق المكون من 4 أرقام.', 'error');
                    return;
                }
                // محاكاة التحقق (في الواقع ترسل للخادم)
                if (otp === '1234') { // كود تجريبي فقط
                    showMessage('تم التحقق من الرمز بنجاح!', 'success');
                    setTimeout(() => showStep(3), 800);
                } else {
                    showMessage('رمز التحقق غير صحيح، يرجى المحاولة مرة أخرى.', 'error');
                }
            }

            // ------ إعادة إرسال OTP ------
            function resendOTP() {
                showMessage('تم إعادة إرسال رمز التحقق إلى بريدك الإلكتروني.', 'success');
                // في الواقع ترسل طلب جديد للخادم
                // مسح الحقول
                for (let i = 1; i <= 4; i++) {
                    document.getElementById('otp' + i).value = '';
                }
                document.getElementById('otp1').focus();
            }

            // ------ الخطوة 3: إعادة تعيين كلمة المرور ------
            function resetPassword(e) {
                e.preventDefault();
                const pass = document.getElementById('new-password').value;
                const confirm = document.getElementById('confirm-new-password').value;
                if (pass.length < 6) {
                    showMessage('كلمة المرور يجب أن تكون 6 أحرف على الأقل.', 'error');
                    return;
                }
                if (pass !== confirm) {
                    showMessage('كلمة المرور وتأكيدها غير متطابقين.', 'error');
                    return;
                }
                // محاكاة إعادة التعيين
                showMessage('تم إعادة تعيين كلمة المرور بنجاح! سيتم توجيهك لتسجيل الدخول.', 'success');
                setTimeout(() => {
                    window.location.href = 'LoginScreen.html';
                }, 2000);
            }

            // ------ عرض الرسائل (نجاح/خطأ) ------
            function showMessage(text, type) {
                const box = document.getElementById('messageBox');
                box.style.display = 'block';
                box.innerText = text;
                box.style.background = type === 'success' ? 'rgba(0, 184, 148, 0.2)' : 'rgba(255, 71, 87, 0.2)';
                box.style.border = type === 'success' ? '1px solid #00b894' : '1px solid #ff4757';
                box.style.color = type === 'success' ? '#00b894' : '#ff4757';
                // اختفاء تلقائي بعد 5 ثواني
                clearTimeout(window.messageTimeout);
                window.messageTimeout = setTimeout(() => {
                    box.style.display = 'none';
                }, 5000);
            }
        </script>
    </body>
</html>