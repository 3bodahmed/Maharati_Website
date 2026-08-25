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

    <title>طلب جديد - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />

    <style>
        /* ===== تحسينات مخصصة لصفحة الطلب الجديد ===== */

        .create-order-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .create-order-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 35px;
            padding: 35px 40px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
        }

        .create-order-card:hover {
            box-shadow: var(--shadow-heavy);
        }

        .create-order-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            padding-bottom: 18px;
            border-bottom: 2px solid var(--color-border);
        }

        .create-order-header h2 {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--color-text);
        }

        .create-order-header h2 i {
            color: var(--color-primary);
            margin-left: 12px;
        }

        /* ===== بطاقة معلومات المنشور المرتبط ===== */
        .post-info-card {
            background: var(--color-primary-light);
            border: 1px solid var(--color-primary);
            border-radius: 18px;
            padding: 18px 22px;
            margin-bottom: 28px;
            transition: all 0.2s ease;
        }

        .post-info-card .post-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--color-primary);
            margin-bottom: 6px;
        }

        .post-info-card .post-title i {
            margin-left: 8px;
        }

        .post-info-card .post-content {
            color: var(--color-text-secondary);
            font-size: 0.95rem;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .post-info-card .post-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            font-size: 0.9rem;
            color: var(--color-text-secondary);
        }

        .post-info-card .post-meta i {
            color: var(--color-primary);
            margin-left: 5px;
            width: 18px;
        }

        .post-info-card .post-meta span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* ===== حقول النموذج ===== */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .form-group label .required {
            color: #e74c3c;
            margin-right: 4px;
        }

        .form-group label i {
            color: var(--color-primary);
            margin-left: 8px;
            width: 20px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
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
        .form-group textarea:focus,
        .form-group select:focus {
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

        .form-group .error-text {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: #e74c3c;
            font-weight: 600;
        }

        .form-group .hint {
            display: block;
            margin-top: 4px;
            font-size: 0.8rem;
            color: var(--color-text-light);
        }

        /* ===== أزرار النموذج ===== */
        .form-actions {
            display: flex;
            gap: 16px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .btn-submit {
            flex: 1;
            padding: 16px 32px;
            min-width: 160px;
            background: var(--color-primary);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: var(--color-primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 115, 232, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0px);
        }

        .btn-cancel {
            padding: 16px 32px;
            min-width: 140px;
            background: transparent;
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
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-cancel:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        /* ===== رسائل الخطأ العامة ===== */
        .alert-error {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            color: #991b1b;
            padding: 16px 24px;
            border-radius: 16px;
            margin-bottom: 22px;
            font-weight: 600;
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-error ul li {
            margin: 4px 0;
        }

        /* ===== التجاوب ===== */
        @media (max-width: 768px) {
            .create-order-card {
                padding: 22px 18px;
                border-radius: 24px;
            }

            .create-order-header h2 {
                font-size: 1.4rem;
            }

            .post-info-card {
                padding: 14px 16px;
            }

            .post-info-card .post-meta {
                gap: 10px;
                font-size: 0.8rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .create-order-container {
                padding: 0 10px;
                margin: 15px auto;
            }

            .create-order-card {
                padding: 18px 14px;
                border-radius: 20px;
            }

            .form-group input,
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
        <div class="alert-error" style="max-width:800px; margin:20px auto 0; padding:0 20px;">
            <div style="background:#fef2f2; border:1.5px solid #fecaca; color:#991b1b; padding:16px 24px; border-radius:16px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ===== الشريط العلوي ===== --}}
     <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2> <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
             
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                <a href="{{ route('profile') }}">
                    <img src="{{ $imageUrl }}" alt="صورة" class="user-avatar" />
                </a>
                <a href="{{ route('login') }}" class="btn-outline logout-btn">
                    <i class="fas fa-sign-out-alt"></i> خروج
                </a>
            </div>
        </div>
    </header>

    {{-- ===== المحتوى الرئيسي ===== --}}
    <main class="create-order-container">
        <div class="create-order-card">

            {{-- الرأس --}}
            <div class="create-order-header">
                <h2><i class="fas fa-file-signature"></i> طلب جديد</h2>
            </div>

            {{-- معلومات المنشور المرتبط (إن وجد) --}}
            @if(isset($post) && $post)
                <div class="post-info-card">
                    <div class="post-title">
                        <i class="fas fa-newspaper"></i> {{ $post->title }}
                    </div>
                    <div class="post-content">{{ $post->content }}</div>
                    <div class="post-meta">
                        <span><i class="fas fa-map-marker-alt"></i> {{ $post->location ?? 'بدون موقع' }}</span>
                        <span><i class="fas fa-money-bill-wave"></i> {{ $post->price ?? 'غير محدد' }} ريال</span>
                        <span><i class="fas fa-user"></i> بواسطة: {{ $post->user->name ?? 'مستخدم' }}</span>
                    </div>
                </div>
            @endif

            {{-- نموذج الطلب --}}
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                {{-- حقول مخفية --}}
                <input type="hidden" name="provider_id" value="{{ $providerId ?? '' }}">
                @if(isset($post) && $post)
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                @endif

                {{-- العنوان --}}
                <div class="form-group">
                    <label for="title">
                        <i class="fas fa-heading"></i> عنوان الطلب
                        <span class="required">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $post->title ?? '') }}"
                        placeholder="أدخل عنواناً واضحاً للطلب"
                        required />
                    @error('title')
                        <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- الوصف --}}
                <div class="form-group">
                    <label for="description">
                        <i class="fas fa-align-left"></i> الوصف
                    </label>
                    <textarea id="description" name="description" rows="4"
                        placeholder="صف تفاصيل الطلب بشكل دقيق...">{{ old('description', $post->content ?? '') }}</textarea>
                    @error('description')
                        <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                    <span class="hint"><i class="fas fa-info-circle"></i> اذكر التفاصيل المهمة التي تساعد مقدم الخدمة على فهم متطلباتك</span>
                </div>

                {{-- الموقع --}}
                <div class="form-group">
                    <label for="location">
                        <i class="fas fa-map-marker-alt"></i> الموقع
                    </label>
                    <input type="text" id="location" name="location"
                        value="{{ old('location', $post->location ?? '') }}"
                        placeholder="المدينة أو المنطقة" />
                    @error('location')
                        <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- السعر --}}
                <div class="form-group">
                    <label for="price">
                        <i class="fas fa-money-bill-wave"></i> السعر (ريال)
                    </label>
                    <input type="number" step="0.01" id="price" name="price"
                        value="{{ old('price', $post->price ?? '') }}"
                        placeholder="المبلغ المقترح" />
                    @error('price')
                        <span class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- الأزرار --}}
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check"></i> إرسال الطلب
                    </button>
                    <a href="{{ route('home') }}" class="btn-cancel">
                        <i class="fas fa-arrow-right"></i> العودة
                    </a>
                </div>
            </form>

        </div>
    </main>
    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    {{-- ===== جافا سكريبت ===== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تعيين التركيز تلقائياً على الحقل الأول
            const firstInput = document.querySelector('input[name="title"]');
            if (firstInput) {
                firstInput.focus();
            }

            // إخفاء رسائل الخطأ بعد 5 ثوانٍ (اختياري)
            const errorMessages = document.querySelectorAll('.error-text');
            errorMessages.forEach(function(el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.6s ease';
                    el.style.opacity = '0';
                    setTimeout(function() {
                        el.style.display = 'none';
                    }, 600);
                }, 5000);
            });
        });
    </script>

</body>
</html>