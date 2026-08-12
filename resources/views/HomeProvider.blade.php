<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="HomeProvider.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" /> 
    <title>مهارتي - الصفحة الرئيسية</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>
    
    <!-- ===== شريط التنقل - مقدم الخدمة ===== -->
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="HomeProvider.html" class="btn-outline active-link"><i class="fas fa-home"></i> الرئيسية</a>
                <a href="ProviderDashboard.html" class="btn-outline"><i class="fas fa-tools"></i> لوحة التحكم</a>
                <a href="Profile.html" class="btn-outline"><i class="fas fa-user"></i> ملفي</a>
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> سعيد</span>
                <img src="https://i.pravatar.cc/40?img=5" alt="صورة" class="user-avatar" />
                <a href="HomeVisitor.html" class="btn-outline" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <!-- ===== المحتوى (نفس المحتوى لكن مع أزرار مختلفة) ===== -->
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
                <span class="feed-badge"><i class="fas fa-briefcase"></i> مقدم خدمة</span>
            </div>
            <div class="posts-grid">
                <!-- طلبات عملاء يمكن لمقدم الخدمة قبولها -->
                <div class="post-card post-client">
                    <div class="post-type"><i class="fas fa-user-plus"></i> طلب خدمة</div>
                    <div class="post-header">
                        <img src="https://i.pravatar.cc/50?img=1" alt="صورة" class="post-avatar" />
                        <div class="post-user-info"><h4>أحمد السليمان</h4><span>عميل · قبل ساعتين</span></div>
                    </div>
                    <h3>مطلوب نجار لتركيب مطابخ</h3>
                    <p class="post-description">أحتاج نجاراً محترفاً لتركيب مطبخ جديد في منطقة السليمانية.</p>
                    <div class="post-footer">
                        <span class="post-location"><i class="fas fa-location-dot"></i> الرياض</span>
                        <span class="post-price"><i class="fas fa-money-bill-wave"></i> 1,500 ر.س</span>
                    </div>
                    <div class="post-cta">
                        <button class="cta-provider"><i class="fas fa-check-circle"></i> قبول الطلب</button>
                    </div>
                </div>

                <div class="post-card post-client">
                    <div class="post-type"><i class="fas fa-user-plus"></i> طلب خدمة</div>
                    <div class="post-header">
                        <img src="https://i.pravatar.cc/50?img=10" alt="صورة" class="post-avatar" />
                        <div class="post-user-info"><h4>فهد الزهراني</h4><span>عميل · قبل يوم</span></div>
                    </div>
                    <h3>تسريب مياه في الحمام</h3>
                    <p class="post-description">يوجد تسريب مياه في حمام الدور الأرضي. أبحث عن سباك ماهر لحل المشكلة بشكل نهائي.</p>
                    <div class="post-footer">
                        <span class="post-location"><i class="fas fa-location-dot"></i> الدمام</span>
                        <span class="post-price"><i class="fas fa-money-bill-wave"></i> 300 ر.س</span>
                    </div>
                    <div class="post-cta">
                        <button class="cta-provider"><i class="fas fa-check-circle"></i> قبول الطلب</button>
                    </div>
                </div>

                <div class="post-card post-client">
                    <div class="post-type"><i class="fas fa-user-plus"></i> طلب خدمة</div>
                    <div class="post-header">
                        <img src="https://i.pravatar.cc/50?img=12" alt="صورة" class="post-avatar" />
                        <div class="post-user-info"><h4>نورة القحطاني</h4><span>عميلة · قبل 4 أيام</span></div>
                    </div>
                    <h3>خياطة فساتين سهرة</h3>
                    <p class="post-description">أبحث عن خياطة محترفة لتفصيل فستانين سهرة بتصميم خاص.</p>
                    <div class="post-footer">
                        <span class="post-location"><i class="fas fa-location-dot"></i> الرياض</span>
                        <span class="post-price"><i class="fas fa-money-bill-wave"></i> 400 ر.س</span>
                    </div>
                    <div class="post-cta">
                        <button class="cta-provider"><i class="fas fa-check-circle"></i> قبول الطلب</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>