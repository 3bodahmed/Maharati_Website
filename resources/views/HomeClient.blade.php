<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="HomeClient.css" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />     

    <title>مهارتي - الصفحة الرئيسية</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>
    
    <!-- رسائل النجاح والأخطاء (اختياري) -->
    @if (session('success'))
        <div class="success-message">
            <ul class="error-list">
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('CreatePost') }}" class="btn-new-request">
                    <i class="fas fa-plus"></i> طلب جديد
                </a>
                
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                <a href="{{ route('profile') }}">
                    <img src="{{ $imageUrl }}" alt="صورة" class="user-avatar" />
                </a>
                <a href="{{ route('login') }}" class="btn-outline logout-btn" >
                    <i class="fas fa-sign-out-alt"></i> خروج
                </a>
               
            </div>
        </div>
    </header>

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

        <section class="ads-section">
            <div class="ads-container">
                <div class="ad-card ad-primary">
                    <div class="ad-content">
                        <span class="ad-badge">مميز</span>
                        <h3>خصم 20% على أول طلب</h3>
                        <p>استخدم كود <strong>MAHARTI20</strong> عند إنشاء طلبك الأول واحصل على خصم فوري</p>
                        <a href="{{ route('CreatePost') }}" class="ad-btn">اطلب الآن</a>
                    </div>
                    <div class="ad-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                </div>
                <div class="ad-card ad-secondary">
                    <div class="ad-content">
                        <span class="ad-badge">جديد</span>
                        <h3>انضم كحرفي محترف</h3>
                        <p>واصل مسيرتك المهنية وانضم إلى أكبر منصة للحرفيين في السعودية</p>
                        <a href="{{ route('profile') }}" class="ad-btn ad-btn-outline">انضم الآن</a>
                    </div>
                    <div class="ad-icon">
                        <i class="fas fa-tools"></i>
                    </div>
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
                <span class="feed-badge"><i class="fas fa-user-check"></i> مرحباً بك</span>
            </div>
            <div class="posts-grid">
                @foreach ($posts as $post)
                    @php
                        $firstImage = null;
                        $imageUrlPost = 'https://i.pravatar.cc/150?img=3'; 

                        if ($post->user->profile && $post->user->profile->image) {
                            $images = json_decode($post->user->profile->image, true);
                            $firstImage = is_array($images) ? $images[0] ?? null : null;
                            if ($firstImage) {
                                $imageUrlPost = Storage::url($firstImage) . '?v=' . ($post->user->profile->updated_at->timestamp ?? time());
                            }
                        }
                    @endphp

                    <div class="post-card post-client">
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
                        <p class="post-description">{{ $post->content }}</p>
                        <div class="post-footer">
                            <span class="post-location"><i class="fas fa-location-dot"></i>{{ $post->location }}</span>
                            <span class="post-price"><i class="fas fa-money-bill-wave"></i> {{ $post->price }} ريال</span>
                        </div>
                        <div class="post-cta">
<a href="{{ route('orders.create', ['post_id' => $post->id]) }}">
    <button class="cta-logged-in"><i class="fas fa-comment"></i> تواصل الآن</button>
</a>                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
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
</body>
</html>