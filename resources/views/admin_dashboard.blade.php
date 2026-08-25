<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />
    <title>لوحة تحكم المدير - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
    <style>
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .admin-stat-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border, rgba(255,255,255,0.1));
            border-radius: 20px;
            padding: 25px 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold, #f1c40f);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .admin-stat-card .stat-icon {
            font-size: 2.2rem;
            color: var(--gold, #f1c40f);
            margin-bottom: 10px;
        }

        .admin-stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: #fff;
            display: block;
            line-height: 1.2;
        }

        .admin-stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--text-light, #aaa);
            font-weight: 600;
        }

        .admin-recent-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-top: 30px;
        }

        .admin-recent-box {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(8px);
            border: 1px solid var(--glass-border, rgba(255,255,255,0.08));
            border-radius: 20px;
            padding: 25px;
        }

        .admin-recent-box h3 {
            color: var(--gold, #f1c40f);
            font-size: 1.2rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-recent-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-recent-box li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.95rem;
        }

        .admin-recent-box li:last-child {
            border-bottom: none;
        }

        .admin-recent-box .user-role-badge {
            font-size: 0.7rem;
            padding: 3px 12px;
            border-radius: 50px;
            font-weight: 700;
        }

        .role-admin { background: #e74c3c; color: #fff; }
        .role-provider { background: #3498db; color: #fff; }
        .role-client { background: #2ecc71; color: #fff; }

        .admin-quick-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin: 25px 0 10px;
        }

        .admin-quick-actions a {
            padding: 12px 28px;
            border-radius: 50px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .admin-quick-actions a:hover {
            background: rgba(241, 196, 15, 0.15);
            border-color: var(--gold, #f1c40f);
            color: var(--gold, #f1c40f);
            transform: translateY(-2px);
        }

        .admin-quick-actions a i {
            color: var(--gold, #f1c40f);
        }

        @media (max-width: 768px) {
            .admin-recent-grid {
                grid-template-columns: 1fr;
            }
            .admin-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .admin-stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    {{-- رسائل النجاح --}}
    @if (session('success'))
        <div class="success-message">
            <ul class="error-list">
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="error-messages">
            <ul class="error-list">
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    @endif

    {{-- صورة البروفايل للشريط --}}
    @php
        $avatarUrl = asset('Logo.png');
        if (Auth::check() && Auth::user()->profile && Auth::user()->profile->image) {
            $images = json_decode(Auth::user()->profile->image, true);
            $first = is_array($images) ? $images[0] ?? null : null;
            if ($first) {
                $avatarUrl = Storage::url($first) . '?v=' . (Auth::user()->profile->updated_at->timestamp ?? time());
            }
        }
    @endphp

    {{-- الشريط العلوي (مطابق لـ HomeClient) --}}
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2><span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('admin.users') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-users" style="color:var(--gold);"></i> المستخدمين
                </a>
                <a href="{{ route('admin.posts') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-file-alt" style="color:var(--gold);"></i> المنشورات
                </a>
                <a href="{{ route('admin.orders') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-shopping-cart" style="color:var(--gold);"></i> الطلبات
                </a>
                
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                <a href="{{ route('profile') }}">
                    <img src="{{ $avatarUrl }}" alt="صورة" class="user-avatar" />
                </a>
                <a href="{{ route('login') }}" class="btn-outline logout-btn">
                    <i class="fas fa-sign-out-alt"></i> خروج
                </a>
              
            </div>
        </div>
    </header>

    <main class="main-content">

        {{-- قسم الهيرو مع الترحيب (مخصص للمدير) --}}
        <section class="hero-section">
            <div class="hero-glass-card">
                <h1>مرحباً <span>مدير</span> المنصة</h1>
                <p>إحصائيات عامة وأحدث النشاطات على منصة <strong>مهارتي</strong></p>
                <div style="display:flex; gap:15px; flex-wrap:wrap; justify-content:center; margin-top:15px;">
                    <span style="background:rgba(255,215,0,0.15); padding:8px 20px; border-radius:50px; border:1px solid rgba(255,215,0,0.3);">
                        <i class="fas fa-shield-alt" style="color:var(--gold);"></i> صلاحية المدير
                    </span>
                </div>
            </div>
        </section>

        {{-- إحصائيات المدير (بنفس تنسيق البطاقات الزجاجية) --}}
        <div class="admin-stats-grid">
            <div class="admin-stat-card">
                <div class="stat-icon" style="color: #1a73e8;"><i class="fas fa-users"></i></div>
                <span class="stat-number" style="color: #1a73e8;">{{ $totalUsers ?? 0 }}</span>
                <span class="stat-label" style="color: #1a73e8;">إجمالي المستخدمين</span>
            </div>
            <div class="admin-stat-card">
                <div class="stat-icon" style="color: #1a73e8;"><i class="fas fa-file-alt"></i></div>
                <span class="stat-number" style="color: #1a73e8;">{{ $totalPosts ?? 0 }}</span>
                <span class="stat-label" style="color: #1a73e8;">إجمالي المنشورات</span>
            </div>
            <div class="admin-stat-card" >
                <div class="stat-icon" style="color: #1a73e8;"><i class="fas fa-shopping-cart"></i></div>
                <span class="stat-number" style="color: #1a73e8;">{{ $totalOrders ?? 0 }}</span>
                <span class="stat-label" style="color: #1a73e8;">إجمالي الطلبات</span>
            </div>
            <div class="admin-stat-card">
                <div class="stat-icon" style="color: #1a73e8;"><i class="fas fa-clock"></i></div>
                <span class="stat-number" style="color: #1a73e8;">{{ $pendingOrders ?? 0 }}</span>
                <span class="stat-label" style="color: #1a73e8;">طلبات معلقة</span>
            </div>
        </div>


        {{-- أحدث النشاطات (آخر المستخدمين والمنشورات) --}}
        <section class="feed-section" style="margin-top: 20px;">
            <div class="feed-header">
                <h2 class="section-title">أحدث <span>النشاطات</span> على المنصة</h2>
                <span class="feed-badge" style="background:rgba(241,196,15,0.15); border-color:var(--gold); color:var(--gold);">
                    <i class="fas fa-bolt"></i> تحديث مباشر
                </span>
            </div>

            <div class="admin-recent-grid">
                {{-- أحدث المستخدمين --}}
                <div class="admin-recent-box">
                    <h3><i class="fas fa-user-plus"></i> أحدث المستخدمين</h3>
                    <ul>
                        @forelse($recentUsers ?? [] as $user)
                            <li>
                                <span><i class="fas fa-user" style="color:var(--gold); margin-left:8px;"></i> {{ $user->name }}</span>
                                <span>
                                    <span class="user-role-badge role-{{ $user->role }}">{{ $user->role }}</span>
                                    <small style="color:#666; margin-right:8px;">{{ $user->created_at->diffForHumans() }}</small>
                                </span>
                            </li>
                        @empty
                            <li style="opacity:0.6; justify-content:center;">لا يوجد مستخدمون جدد</li>
                        @endforelse
                    </ul>
                </div>

                {{-- أحدث المنشورات --}}
                <div class="admin-recent-box">
                    <h3><i class="fas fa-newspaper"></i> أحدث المنشورات</h3>
                    <ul>
                        @forelse($recentPosts ?? [] as $post)
                            <li>
                                <span>
                                    <i class="fas fa-tag" style="color:var(--gold); margin-left:8px;"></i>
                                    {{ Str::limit($post->title, 25) }}
                                </span>
                                <span>
                                    <span style="font-size:0.7rem; background:rgba(255,255,255,0.05); padding:2px 10px; border-radius:50px;">
                                        {{ $post->user->name ?? 'غير معروف' }}
                                    </span>
                                    <small style="color:#666; margin-right:8px;">{{ $post->created_at->diffForHumans() }}</small>
                                </span>
                            </li>
                        @empty
                            <li style="opacity:0.6; justify-content:center;">لا توجد منشورات جديدة</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </section>

        {{-- ===== قسم المنشورات (بنفس تنسيق HomeClient) ===== --}}
        <section class="feed-section" style="margin-top: 40px;">
            <div class="feed-header">
                <h2 class="section-title">جميع <span>المنشورات</span> على المنصة</h2>
                <span class="feed-badge" style="background:rgba(241,196,15,0.15); border-color:var(--gold); color:var(--gold);">
                    <i class="fas fa-list"></i> عرض الكل
                </span>
            </div>

            <div class="posts-grid">
                @foreach ($posts as $post)
                    @php
                        // صورة المستخدم
                        $firstImage = null;
                        $imageUrlPost = 'https://i.pravatar.cc/150?img=3';
                        if ($post->user->profile && $post->user->profile->image) {
                            $images = json_decode($post->user->profile->image, true);
                            $firstImage = is_array($images) ? $images[0] ?? null : null;
                            if ($firstImage) {
                                $imageUrlPost = Storage::url($firstImage) . '?v=' . ($post->user->profile->updated_at->timestamp ?? time());
                            }
                        }

                        // صور المنشور
                        $postImages = [];
                        if ($post->image) {
                            $decoded = is_string($post->image) ? json_decode($post->image, true) : $post->image;
                            $postImages = is_array($decoded) ? $decoded : [];
                        }
                    @endphp

                    <div class="post-card post-client" data-title="{{ strtolower($post->title) }}"
                         data-content="{{ strtolower($post->content) }}"
                         data-location="{{ strtolower($post->location) }}"
                         data-username="{{ strtolower($post->user->name) }}">
                        <div class="post-type {{ $post->typeRequest === 'provider' ? 'provider-type' : '' }}">
                            @if ($post->typeRequest === 'client')
                                <i class="fas fa-user-plus"></i> طلب خدمة
                            @else
                                <i class="fas fa-briefcase"></i> خدمة مقدمة
                            @endif
                        </div>

                        <div class="post-header">
                            <a href="{{ route('profile.show', $post->user->id) }}">
                                <img src="{{ $imageUrlPost }}" alt="صورة" class="post-avatar" />
                            </a>
                            <div class="post-user-info">
                                <h4><a href="{{ route('profile.show', $post->user->id) }}" style="color:inherit; text-decoration:none;">{{ $post->user->name }}</a></h4>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <h3>{{ $post->title }}</h3>

                        {{-- معرض الصور --}}
                        @if (count($postImages) > 0)
                            <div class="post-gallery" data-current-slide="0">
                                <div class="gallery-slides">
                                    @foreach ($postImages as $img)
                                        <div class="slide">
                                            <img src="{{ asset('storage/' . $img) }}" alt="صورة المنشور" />
                                        </div>
                                    @endforeach
                                </div>
                                @if (count($postImages) > 1)
                                    <button class="gallery-btn prev-btn" onclick="moveSlide(this, -1)"><i class="fas fa-chevron-right"></i></button>
                                    <button class="gallery-btn next-btn" onclick="moveSlide(this, 1)"><i class="fas fa-chevron-left"></i></button>
                                    <div class="gallery-dots">
                                        @foreach ($postImages as $index => $img)
                                            <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="setSlide(this, {{ $index }})"></span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- Placeholder لعدم وجود صور --}}
                            <div class="post-gallery" style="display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.02); color:#666;">
                                <i class="fas fa-image" style="font-size:2rem;"></i>
                            </div>
                        @endif

                        <p class="post-description">{{ $post->content }}</p>

                        <div class="post-footer">
                            <span class="post-location"><i class="fas fa-location-dot"></i> {{ $post->location }}</span>
                            <span class="post-price"><i class="fas fa-money-bill-wave"></i> {{ $post->price }} ريال</span>
                        </div>

                        <div class="post-cta">
                            <a href="{{ route('orders.create', ['post_id' => $post->id]) }}">
                                <button class="cta-logged-in"><i class="fas fa-comment"></i> تواصل الآن</button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </main>

    {{-- تذييل الصفحة --}}
    <footer class="guest-footer">
        <p>© {{ date('Y') }} <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    {{-- جافا سكريبت --}}
    <script>
        // 1️⃣ إخفاء رسائل النجاح والخطأ
        document.addEventListener('DOMContentLoaded', function() {
            var successDiv = document.querySelector('.success-message');
            var errorDiv = document.querySelector('.error-messages');

            if (successDiv) {
                setTimeout(function() {
                    successDiv.style.transition = 'opacity 0.8s ease';
                    successDiv.style.opacity = '0';
                    setTimeout(function() {
                        successDiv.style.display = 'none';
                    }, 800);
                }, 3000);
            }

            if (errorDiv) {
                setTimeout(function() {
                    errorDiv.style.transition = 'opacity 0.8s ease';
                    errorDiv.style.opacity = '0';
                    setTimeout(function() {
                        errorDiv.style.display = 'none';
                    }, 3000);
                }, 3000);
            }
        });

        // 2️⃣ وظائف معرض الصور
        function updateGallery(gallery, slideIndex) {
            const slides = gallery.querySelector('.gallery-slides');
            const totalSlides = slides.children.length;
            const dots = gallery.querySelectorAll('.dot');
            if (slideIndex >= totalSlides) slideIndex = 0;
            if (slideIndex < 0) slideIndex = totalSlides - 1;
            slides.style.transform = `translateX(${slideIndex * 100}%)`;
            gallery.setAttribute('data-current-slide', slideIndex);
            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === slideIndex);
            });
        }

        function moveSlide(button, direction) {
            const gallery = button.closest('.post-gallery');
            let currentIndex = parseInt(gallery.getAttribute('data-current-slide')) || 0;
            updateGallery(gallery, currentIndex + direction);
        }

        function setSlide(dot, index) {
            const gallery = dot.closest('.post-gallery');
            updateGallery(gallery, index);
        }
    </script>

</body>
</html>