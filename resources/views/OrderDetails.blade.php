<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- استيراد أنماط تفاصيل الطلب -->
    <link rel="stylesheet" href="OrderDetails.css" />
    
    <!-- مكتبة الأيقونات -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />     
    <title>تفاصيل الطلب - مهارتي</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>

    <!-- ===== شريط التنقل ===== -->
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="HomeClient.html" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <a href="ClientDashboard.html" class="btn-outline"><i class="fas fa-th-large"></i> لوحة التحكم</a>
                <span class="user-greeting"><i class="fas fa-user"></i> أحمد</span>
                <img src="https://i.pravatar.cc/40?img=3" alt="صورة" class="user-avatar" />
                <a href="HomeVisitor.html" class="btn-outline logout-btn" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <!-- ===== المحتوى الرئيسي ===== -->
    <main class="order-details-container">

        <!-- ===== رأس الصفحة ===== -->
        <div class="page-header">
            <h1>تفاصيل <span>الطلب</span></h1>
            <a href="ClientDashboard.html" class="btn-back"><i class="fas fa-arrow-right"></i> العودة</a>
        </div>

        <!-- ===== معلومات مقدم الخدمة ===== -->
        <div class="provider-card">
            <img src="https://i.pravatar.cc/80?img=1" alt="صورة مقدم الخدمة" class="provider-avatar" />
            <div class="provider-info">
                <h2>أحمد النجار</h2>
                <p class="provider-rating">
                    <i class="fas fa-star"></i> 4.8 (22 تقييم)
                </p>
                <p class="provider-bio">نجار محترف · خبرة 10 سنوات</p>
            </div>
        </div>


        <!-- ===== أزرار الإجراءات ===== -->
        <div class="action-buttons">
            <button class="btn-chat" onclick="window.location.href='Chat.html'">
                <i class="fas fa-comment"></i> فتح الدردشة
            </button>
            <button class="btn-cancel" onclick="if(confirm('هل أنت متأكد من إلغاء الطلب؟')) { alert('تم إلغاء الطلب بنجاح'); window.location.href='ClientDashboard.html'; }">
                <i class="fas fa-times"></i> إلغاء الطلب
            </button>
        </div>

        <!-- ===== تفاصيل الطلب ===== -->
        <div class="order-info">
            <h3><i class="fas fa-clipboard-list"></i> معلومات الطلب</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">الخدمة</span>
                    <span class="info-value">تركيب مطبخ جديد</span>
                </div>
                <div class="info-item">
                    <span class="info-label">السعر</span>
                    <span class="info-value">1,500 ر.س</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الموقع</span>
                    <span class="info-value">الرياض - السليمانية</span>
                </div>
                <div class="info-item">
                    <span class="info-label">تاريخ الطلب</span>
                    <span class="info-value">12 يوليو 2026</span>
                </div>
                <div class="info-item">
                    <span class="info-label">حالة الطلب</span>
                    <span class="status pending">قيد الانتظار</span>
                </div>
                <div class="info-item">
                    <span class="info-label">رقم الطلب</span>
                    <span class="info-value">#ORD-2026-0012</span>
                </div>
            </div>
        </div>

    </main>

    <footer class="order-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>