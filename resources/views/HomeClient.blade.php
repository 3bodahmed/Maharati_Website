<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />
    <title>مهارتي - الصفحة الرئيسية</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
<style>
   .btn-new-request{
    color: black;
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

    {{-- الشريط العلوي --}}
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2> <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('CreatePost') }}" class="btn-new-request" >
                    <i class="fas fa-plus" style="color:black;"></i> طلب جديد
                </a>
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

    <main class="main-content">

        {{-- قسم الهيرو مع البحث --}}
        <section class="hero-section">
            <div class="hero-glass-card">
                <h1>ابحث عن <span>الحرفيين</span> أو اعرض <span>خدمتك</span></h1>
                <p>منصة تجمع بين طالبي الخدمات ومقدميها في مكان واحد</p>
                <div class="search-wrapper">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" placeholder="ابحث عن حرفة، خدمة، أو موقع..." class="search-input" />
                        <button class="search-btn" id="searchBtn">بحث</button>
                    </div>
                    
                </div>
            </div>
        </section>

        {{-- الإعلانات
        <section class="ads-section">
            <div class="ads-container">
                <div class="ad-card ad-primary">
                    <div class="ad-content">
                        <span class="ad-badge">مميز</span>
                        <h3>خصم 20% على أول طلب</h3>
                        <p>استخدم كود <strong>MAHARTI20</strong> عند إنشاء طلبك الأول واحصل على خصم فوري</p>
                        <a href="{{ route('CreatePost') }}" class="ad-btn">اطلب الآن</a>
                    </div>
                    <div class="ad-icon"><i class="fas fa-gift"></i></div>
                </div>
                <div class="ad-card ad-secondary">
                    <div class="ad-content">
                        <span class="ad-badge">جديد</span>
                        <h3>انضم كحرفي محترف</h3>
                        <p>واصل مسيرتك المهنية وانضم إلى أكبر منصة للحرفيين في السعودية</p>
                        <a href="{{ route('profile') }}" class="ad-btn ad-btn-outline">انضم الآن</a>
                    </div>
                    <div class="ad-icon"><i class="fas fa-tools"></i></div>
                </div>
            </div>
        </section> --}}

        {{-- التصنيفات --}}
        <section class="categories-section">
            <h2 class="section-title">أشهر <span>المهن</span></h2>
            <div class="categories-grid">
                <div class="category-item"><div class="category-icon"><i class="fas fa-wrench"></i></div><span>سباك</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-hammer"></i></div><span>نجار</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-bolt"></i></div><span>كهربائي</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-paint-roller"></i></div><span>دهان</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-cut"></i></div><span>خياط</span></div>
            </div>
        </section>

        {{-- قائمة المنشورات --}}
        <section class="feed-section">
            <div class="feed-header">
                <h2 class="section-title">آخر <span>الفرص</span> والخدمات</h2>
                <span class="feed-badge"><i class="fas fa-user-check"></i> مرحباً بك</span>
            </div>

            {{-- حاوية المنشورات (سيتم البحث فيها) --}}
            <div class="posts-grid" id="postsContainer">
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

            {{-- رسالة "لا توجد نتائج" (مخفية افتراضياً) --}}
            <div id="noResults" style="display:none; text-align:center; padding:40px 0; color:var(--text-light);">
                <i class="fas fa-search" style="font-size:2rem; opacity:0.5;"></i>
                <p style="margin-top:10px;">لا توجد منشورات تطابق بحثك</p>
            </div>
        </section>
    </main>

    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    {{-- ===== جافا سكريبت ===== --}}
    <script>
        // 1️⃣ إخفاء رسالة النجاح بعد 3 ثوان
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

       
        // 4️⃣ وظيفة البحث
        function performSearch() {
            const query = searchInput.value.trim().toLowerCase();
            const posts = document.querySelectorAll('.post-card');
            const postsContainer = document.getElementById('postsContainer');
            const noResults = document.getElementById('noResults');

            let found = false;

            posts.forEach(post => {
                // الحصول على البيانات من attributes
                const title = post.getAttribute('data-title') || '';
                const content = post.getAttribute('data-content') || '';
                const location = post.getAttribute('data-location') || '';
                const username = post.getAttribute('data-username') || '';

                // تطابق إذا كان النص موجوداً في أي من الحقول
                const match = title.includes(query) || content.includes(query) ||
                              location.includes(query) || username.includes(query);

              // ✅ الكود المعدل
if (query === '' || match) {
    post.style.display = ''; // إزالة style الضمني ليعود التنسيق الأصلي من CSS
    found = true;
} else {
    post.style.display = 'none';
}
            });

            // إظهار/إخفاء رسالة "لا توجد نتائج"
            if (query !== '' && !found) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        }

        // ربط زر البحث
        document.getElementById('searchBtn').addEventListener('click', performSearch);

        // ربط الضغط على Enter في حقل البحث
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // (اختياري) تحديث البحث عند تغيير النص مع تأخير بسيط
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 400);
        });

        // تنفيذ بحث عند تحميل الصفحة (للتأكد من عدم وجود أخطاء)
        document.addEventListener('DOMContentLoaded', function() {
            // نضع المؤشر في حقل البحث (اختياري)
            // searchInput.focus();
        });
    </script>
</body>
</html>