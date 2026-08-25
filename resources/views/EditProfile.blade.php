<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css"></noscript>
    <link rel="stylesheet" href="{{ asset('style.css') }}" />

    <title>تعديل الملف الشخصي - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />

    <style>
        /* ===== تحسينات مخصصة لصفحة تعديل الملف ===== */

        .edit-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .edit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        .edit-header h1 {
            font-size: 2rem;
            font-weight: 900;
            color: var(--color-text);
        }

        .edit-header h1 i {
            color: var(--color-primary);
            margin-left: 12px;
        }

        .edit-header h1 span {
            color: var(--color-primary);
        }

        .btn-back {
            padding: 10px 28px;
            background: var(--color-surface);
            border: 1.5px solid var(--color-border);
            border-radius: 50px;
            color: var(--color-text-secondary);
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            border-color: var(--color-primary);
            background: var(--color-primary-light);
            color: var(--color-primary);
        }

        /* ===== بطاقة النموذج ===== */
        .edit-form-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 35px;
            padding: 40px 45px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
        }

        .edit-form-card:hover {
            box-shadow: var(--shadow-heavy);
        }

        /* ===== قسم الصورة ===== */
        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--color-border);
        }

        .avatar-preview-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--color-primary);
            box-shadow: 0 8px 25px rgba(26, 115, 232, 0.25);
            background: var(--color-bg);
            transition: all 0.3s ease;
        }

        .avatar-preview-wrapper:hover {
            transform: scale(1.03);
            border-color: var(--color-primary-dark);
            box-shadow: 0 12px 35px rgba(26, 115, 232, 0.35);
        }

        .avatar-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .avatar-upload-label {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: var(--color-primary);
            color: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
            border: 2px solid var(--color-surface);
            font-size: 1.1rem;
        }

        .avatar-upload-label:hover {
            background: var(--color-primary-dark);
            transform: scale(1.1);
        }

        #avatarInput {
            display: none;
        }

        .avatar-hint {
            margin-top: 12px;
            font-size: 0.9rem;
            color: var(--color-text-light);
            font-weight: 600;
        }

        .avatar-hint i {
            color: var(--color-primary);
            margin-left: 6px;
        }

        /* ===== شبكة الحقول ===== */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 25px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--color-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group label i {
            color: var(--color-primary);
            width: 20px;
            text-align: center;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            background: var(--color-bg);
            border: 2px solid var(--color-border);
            border-radius: 16px;
            color: var(--color-text);
            font-size: 16px;
            font-family: inherit;
            outline: none;
            transition: all 0.25s ease;
            direction: rtl;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.12);
            background: var(--color-surface);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--color-text-light);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 16px center;
            padding-left: 40px;
        }

        /* ===== الأزرار ===== */
        .form-actions {
            display: flex;
            gap: 16px;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid var(--color-border);
            flex-wrap: wrap;
        }

        .btn-reset {
            padding: 14px 32px;
            background: var(--color-bg);
            border: 2px solid var(--color-border);
            border-radius: 50px;
            color: var(--color-text-secondary);
            font-weight: 700;
            font-size: 1rem;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reset:hover {
            border-color: #e74c3c;
            background: #fef2f2;
            color: #e74c3c;
        }

        .btn-save {
            flex: 1;
            min-width: 160px;
            padding: 14px 36px;
            background: var(--color-primary);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.05rem;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-save:hover {
            background: var(--color-primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 115, 232, 0.35);
        }

        .btn-save:active {
            transform: translateY(0px);
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 0.8s ease infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== رسائل النظام ===== */
        .form-message {
            margin-top: 20px;
            padding: 14px 20px;
            border-radius: 16px;
            font-weight: 700;
            display: none;
        }

        .form-message.success {
            background: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            color: #166534;
            display: block;
        }

        .form-message.error {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            color: #991b1b;
            display: block;
        }

        /* ===== التجاوب ===== */
        @media (max-width: 768px) {
            .edit-container {
                padding: 0 12px;
                margin: 20px auto;
            }

            .edit-header h1 {
                font-size: 1.5rem;
            }

            .edit-form-card {
                padding: 24px 18px;
                border-radius: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .avatar-preview-wrapper {
                width: 110px;
                height: 110px;
            }

            .avatar-upload-label {
                width: 34px;
                height: 34px;
                font-size: 0.9rem;
                bottom: 4px;
                right: 4px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-reset,
            .btn-save {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .edit-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .edit-form-card {
                padding: 18px 12px;
                border-radius: 18px;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 12px 14px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    {{-- ===== رسائل الخطأ ===== --}}
    @if ($errors->any())
        <div class="error-messages" style="max-width:900px; margin:20px auto 0; padding:0 20px;">
            <div style="background:#fef2f2; border:1.5px solid #fecaca; color:#991b1b; padding:16px 24px; border-radius:16px;">
                <strong><i class="fas fa-exclamation-triangle"></i> يوجد خطأ في البيانات المدخلة</strong>
                <ul style="margin-top:8px; list-style:none; padding:0;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-circle" style="font-size:0.4rem; margin-left:8px;"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ===== رسالة النجاح ===== --}}
    @if (session('success'))
        <div class="success-message" style="max-width:900px; margin:20px auto 0; padding:0 20px;">
            <div style="background:#f0fdf4; border:1.5px solid #bbf7d0; color:#166534; padding:16px 24px; border-radius:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- ===== صورة البروفايل (للاستخدام في الشريط) ===== --}}
    @php
        $firstImage = null;
        $imageUrl = asset('Logo.png');
        if ($profile && $profile->image) {
            $images = json_decode($profile->image, true);
            $firstImage = is_array($images) ? $images[0] ?? null : null;
            if ($firstImage) {
                $imageUrl = Storage::url($firstImage) . '?v=' . ($profile->updated_at->timestamp ?? time());
            }
        }
         $isAdmin = Auth::check() && Auth::user()->isAdmin();
    @endphp

    {{-- ===== الشريط العلوي ===== --}}
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2> <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                 @if(!$isAdmin)
                <a href="{{ route('home') }}" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                @endif
                @auth
                    {{-- إذا كان المستخدم مديراً، أضف زر لوحة التحكم --}}
                    @if($isAdmin)
                        <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">
                            <i class="fas fa-chart-pie"></i> لوحة التحكم
                        </a>
                    @endif
                    <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                    <img src="{{ $imageUrl }}" alt="صورة" class="user-avatar" />
                    <a href="{{ route('login') }}" class="btn-outline" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
                @else
                    <a href="{{ route('login') }}" class="btn-outline"><i class="fas fa-sign-in-alt"></i> دخول</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ===== المحتوى الرئيسي ===== --}}
    <main class="edit-container">

        {{-- الرأس --}}
        <div class="edit-header">
            <h1><i class="fas fa-user-edit"></i> تعديل <span>الملف الشخصي</span></h1>
            <a href="{{ route('profile') }}" class="btn-back"><i class="fas fa-arrow-right"></i> العودة للملف</a>
        </div>

        {{-- بطاقة النموذج --}}
        <div class="edit-form-card">
            <form id="editProfileForm" enctype="multipart/form-data" method="POST" action="{{ route('CreateProfile') }}">
                @csrf

                {{-- قسم الصورة --}}
                <div class="avatar-section">
                    <div class="avatar-preview-wrapper">
                        <img
                            src="{{ $imageUrl }}"
                            alt="صورة البروفايل"
                            id="avatarPreview"
                            class="avatar-preview"
                        />
                        <label for="avatarInput" class="avatar-upload-label">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="image[]" id="avatarInput" accept="image/*" multiple />
                    </div>
                    <p class="avatar-hint"><i class="fas fa-info-circle"></i> اضغط على أيقونة الكاميرا لتغيير الصورة (يدعم صور متعددة)</p>
                </div>

                {{-- شبكة الحقول --}}
                <div class="form-grid">

                    {{-- الاسم الكامل --}}
                    <div class="form-group full-width">
                        <label for="fullName"><i class="fas fa-user"></i> الاسم الكامل</label>
                        <input type="text" name="fullName" id="fullName" value="{{ Auth::user()->name }}" placeholder="أدخل اسمك الكامل" />
                    </div>

                    {{-- المهنة (قائمة منسدلة) --}}
                    @php
                        $jobs = [
                            'لا يوجد' => 'لا يوجد مهنه',
                            'مهندس برمجيات' => 'مهندس برمجيات',
                            'نجار' => 'نجار',
                            'سباك' => 'سباك',
                            'كهربائي' => 'كهربائي',
                            'دهان' => 'دهان',
                            'خياط' => 'خياط',
                            'مطور ويب' => 'مطور ويب',
                        ];
                        $selectedJob = old('jobTitle', $profile->jobs ?? 'لا يوجد');
                    @endphp
                    <div class="form-group">
                        <label for="jobTitle"><i class="fas fa-briefcase"></i> المهنة (اختياري)</label>
                        <select id="jobTitle" name="jobTitle">
                            @foreach ($jobs as $value => $label)
                                <option value="{{ $value }}" {{ $selectedJob == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- سنوات الخبرة --}}
                    <div class="form-group">
                        <label for="experience"><i class="fas fa-calendar-alt"></i> سنوات الخبرة (اختياري)</label>
                        <input type="number" name="experience" id="experience" value="{{ $profile ? $profile->experience : '' }}" placeholder="0" min="0" />
                    </div>

                    {{-- السيرة الذاتية (Bio) --}}
                    <div class="form-group full-width">
                        <label for="bio"><i class="fas fa-quote-right"></i> السيرة الذاتية (Bio) (اختياري)</label>
                        <input type="text" name="bio" id="bio" value="{{ $profile ? $profile->bio : '' }}" placeholder="وصف مختصر عنك" />
                    </div>

                    {{-- السعر --}}
                    <div class="form-group">
                        <label for="price"><i class="fas fa-money-bill-wave"></i> السعر (ريال) (اختياري)</label>
                        <input type="number" name="price" id="price" value="{{ $profile ? $profile->price : '0' }}" placeholder="مثال: 100" />
                    </div>

                    {{-- الموقع --}}
                    <div class="form-group">
                        <label for="location"><i class="fas fa-map-marker-alt"></i> الموقع (اختياري)</label>
                        <input type="text" name="location" id="location" value="{{ $profile ? $profile->location : '' }}" placeholder="المدينة، الحي" />
                    </div>

                    {{-- الوصف التفصيلي --}}
                    <div class="form-group full-width">
                        <label for="about"><i class="fas fa-align-left"></i> الوصف التفصيلي (اختياري)</label>
                        <textarea name="about" id="about" rows="5" placeholder="اكتب وصفاً مفصلاً عن خدماتك وخبراتك...">{{ $profile ? $profile->Description : '' }}</textarea>
                    </div>

                </div>

                {{-- أزرار الإجراء --}}
                <div class="form-actions">
                    <button type="reset" class="btn-reset"><i class="fas fa-undo"></i> إعادة تعيين</button>
                    <button type="submit" class="btn-save" id="saveBtn">
                        <span class="btn-text"><i class="fas fa-save"></i> حفظ التغييرات</span>
                        <span class="spinner" style="display: none;"></span>
                    </button>
                </div>

                {{-- رسالة الحالة --}}
                <div id="formMessage" class="form-message" style="display: none;"></div>

            </form>
        </div>
        

    </main>
    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    {{-- ===== جافا سكريبت ===== --}}
    <script>
        // 1. معاينة الصورة عند التحميل
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('avatarPreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // 2. إعادة تعيين الحقول (إعادة تحميل الصفحة مع تأكيد)
        document.querySelector('.btn-reset').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من إعادة تعيين جميع التغييرات؟')) {
                window.location.reload();
            }
        });

        // 3. إخفاء رسائل الخطأ والنجاح تلقائياً بعد 3 ثوانٍ
        document.addEventListener('DOMContentLoaded', function() {
            // رسائل الخطأ
            const errorDiv = document.querySelector('.error-messages');
            if (errorDiv) {
                setTimeout(function() {
                    errorDiv.style.transition = 'opacity 0.8s ease';
                    errorDiv.style.opacity = '0';
                    setTimeout(function() {
                        errorDiv.style.display = 'none';
                    }, 800);
                }, 4000);
            }

            // رسائل النجاح
            const successDiv = document.querySelector('.success-message');
            if (successDiv) {
                setTimeout(function() {
                    successDiv.style.transition = 'opacity 0.8s ease';
                    successDiv.style.opacity = '0';
                    setTimeout(function() {
                        successDiv.style.display = 'none';
                    }, 800);
                }, 4000);
            }
        });

        // 4. (اختياري) عرض مؤشر تحميل عند إرسال النموذج
        document.getElementById('editProfileForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('saveBtn');
            const textSpan = btn.querySelector('.btn-text');
            const spinner = btn.querySelector('.spinner');
            textSpan.style.display = 'none';
            spinner.style.display = 'inline-block';
            btn.disabled = true;
        });
    </script>

</body>
</html>