<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="HomeVisetor.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" /> 
    <title>مهارتي - الصفحة الرئيسية</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>
    
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" loading="lazy" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="/login" class="btn-outline"><i class="fas fa-sign-in-alt"></i> تسجيل الدخول</a>
                <a href="/signup" class="btn-primary"><i class="fas fa-user-plus"></i> إنشاء حساب</a>
            </div>
        </div>
    </header>

    <!-- ===== المحتوى ===== -->
    <main class="main-content">
        <section class="hero-section">
            <div class="hero-glass-card">
                <h1>ابحث عن <span>الحرفيين</span> أو اعرض <span>خدمتك</span></h1>
                <p>منصة تجمع بين طالبي الخدمات ومقدميها في مكان واحد</p>
                <div class="search-wrapper">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="ابحث عن حرفة، خدمة، أو موقع..." class="search-input" />
                        <button class="search-btn">بحث</button>
                    </div>
                    <button class="location-btn"><i class="fas fa-location-dot"></i> تحديد موقعي تلقائياً</button>
                </div>
            </div>
        </section>

        <section class="categories-section">
            <h2 class="section-title">أشهر <span>المهن</span></h2>
            <div class="categories-grid">
                <div class="category-item"><div class="category-icon"><i class="fas fa-wrench"></i></div><span>سباك</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-hammer"></i></div><span>نجار</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-bolt"></i></div><span>كهربائي</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-paint-roller"></i></div><span>دهان</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-cut"></i></div><span>خياط</span></div>
                <div class="category-item"><div class="category-icon"><i class="fas fa-plus"></i></div><span>المزيد</span></div>
            </div>
        </section>

        <section class="feed-section">
            <div class="feed-header">
                <h2 class="section-title">آخر <span>الفرص</span> والخدمات</h2>
                <span class="feed-badge"><i class="fas fa-globe"></i> للزوار</span>
            </div>
            <div class="posts-grid">
                <!-- منشورات ثابتة (طلبات + عروض) -->
                @foreach ($posts as $post)
                 @php
                        $firstImage = null;
                        $imageUrlPost = 'https://i.pravatar.cc/150?img=3'; 

                        if ( $post->user->profile->image) {
                            $images = json_decode($post->user->profile->image, true);
                            $firstImage = is_array($images) ? $images[0] ?? null : null;
                            
                            if ($firstImage) {
                                $imageUrlPost = Storage::url($firstImage) . '?v=' . ($post->user->profile->updated_at->timestamp ?? time());
                            }
                        }
                @endphp

                <div class="post-card post-client">
                <div class="post-type " style="background-color: white;color:black;">
                    <i class="fas fa-user-plus"></i> متابعه
                </div>
                <div class="post-type {{ $post->typeRequest === 'provider' ? 'provider-type' : '' }}">
                @if ($post->typeRequest === 'client')
                
                <i class="fas fa-user-plus"></i> طلب خدمة
                @else
                    <i class="fas fa-briefcase"></i> خدمة مقدمة
                @endif
            </div>


                    <div class="post-header">
                        
                        <img src="{{ $imageUrlPost}}" alt="صورة" class="post-avatar" />
                        <div class="post-user-info"><h4>{{ $post->user->name }}</h4><span>{{ $post->created_at->diffForHumans() }}</span></div>
                    </div>
                    <h3>{{ $post->title }}</h3>
                    <p class="post-description">{{ $post->content }}</p>
                    <div class="post-footer">
                        <span class="post-location"><i class="fas fa-location-dot"></i>{{ $post->location  }}</span>
                        <span class="post-price"><i class="fas fa-money-bill-wave"></i> {{$post->price }} ريال</span>
                    </div>
                    <div class="post-cta">
                        <a href="{{ route('login') }}"><button class="cta-logged-in"><i class="fas fa-comment"></i> تواصل الآن</button></a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>