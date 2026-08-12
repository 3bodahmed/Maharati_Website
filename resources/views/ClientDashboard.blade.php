<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="ClientDashboard.css" />
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" /> 
    <title>لوحة تحكم العميل - مهارتي</title>
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
                <a href="ClientDashboard.html" class="btn-outline active-link"><i class="fas fa-th-large"></i> لوحة التحكم</a>
                <span class="user-greeting"><i class="fas fa-user"></i> أحمد</span>
                <img src="https://i.pravatar.cc/40?img=3" alt="صورة" class="user-avatar" />
                <a href="HomeVisitor.html" class="btn-outline logout-btn" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <!-- ===== المحتوى الرئيسي ===== -->
    <main class="dashboard-container">

        <!-- ===== رأس الصفحة ===== -->
        <div class="page-header">
            <div>
                <h1>لوحة تحكم <span>العميل</span></h1>
                <p class="welcome-text">مرحباً بك في لوحة التحكم، يمكنك متابعة طلباتك وإدارة خدماتك</p>
            </div>
            <a href="CreatePost.html" class="btn-new-request">
                <i class="fas fa-plus"></i> طلب جديد
            </a>
        </div>

        <!-- ===== الإحصائيات ===== -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-spinner fa-fw"></i></div>
                <div class="stat-number">3</div>
                <div class="stat-label">طلبات نشطة</div>
                <span class="stat-sub">قيد الانتظار والتنفيذ</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle fa-fw"></i></div>
                <div class="stat-number">12</div>
                <div class="stat-label">طلبات مكتملة</div>
                <span class="stat-sub">تم تنفيذها بنجاح</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-star fa-fw"></i></div>
                <div class="stat-number">4.8</div>
                <div class="stat-label">متوسط التقييمات</div>
                <span class="stat-sub">من مقدمي الخدمة</span>
            </div>
        </div>

        <!-- ===== الطلبات النشطة ===== -->
        <div class="list-card">
            <div class="list-header">
                <h3><i class="fas fa-spinner"></i> الطلبات النشطة</h3>
                <span class="list-badge">3 طلبات</span>
            </div>

            <!-- طلب 1 -->
            <div class="order-item">
                <div class="order-info">
                    <h4>تركيب مطبخ جديد</h4>
                    <p class="order-meta">
                        <span><i class="fas fa-user"></i> أحمد النجار</span>
                        <span><i class="fas fa-calendar-alt"></i> 12/07/2026</span>
                    </p>
                </div>
                <span class="status pending">قيد الانتظار</span>
                <div class="order-actions">
                    <button class="btn-chat" onclick="window.location.href='Chat.html'">
                        <i class="fas fa-comment"></i> دردشة
                    </button>
                    <button class="btn-details" onclick="window.location.href='OrderDetails.html'">
                        <i class="fas fa-info-circle"></i> تفاصيل
                    </button>
                </div>
            </div>

            <!-- طلب 2 -->
            <div class="order-item">
                <div class="order-info">
                    <h4>تسريب مياه الحمام</h4>
                    <p class="order-meta">
                        <span><i class="fas fa-user"></i> فهد السباك</span>
                        <span><i class="fas fa-calendar-alt"></i> 10/07/2026</span>
                    </p>
                </div>
                <span class="status active">قيد التنفيذ</span>
                <div class="order-actions">
                    <button class="btn-chat" onclick="window.location.href='Chat.html'">
                        <i class="fas fa-comment"></i> دردشة
                    </button>
                    <button class="btn-details" onclick="window.location.href='OrderDetails.html'">
                        <i class="fas fa-info-circle"></i> تفاصيل
                    </button>
                    <button class="btn-cancel" onclick="if(confirm('هل أنت متأكد من إلغاء الطلب؟')) alert('تم إلغاء الطلب');">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                </div>
            </div>

            <!-- طلب 3 -->
            <div class="order-item">
                <div class="order-info">
                    <h4>تمديد كهرباء الفيلا</h4>
                    <p class="order-meta">
                        <span><i class="fas fa-user"></i> سعيد الكهربائي</span>
                        <span><i class="fas fa-calendar-alt"></i> 08/07/2026</span>
                    </p>
                </div>
                <span class="status pending">قيد الانتظار</span>
                <div class="order-actions">
                    <button class="btn-chat" onclick="window.location.href='Chat.html'">
                        <i class="fas fa-comment"></i> دردشة
                    </button>
                    <button class="btn-details" onclick="window.location.href='OrderDetails.html'">
                        <i class="fas fa-info-circle"></i> تفاصيل
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== تاريخ الطلبات ===== -->
        <div class="list-card">
            <div class="list-header">
                <h3><i class="fas fa-history"></i> تاريخ الطلبات</h3>
                <span class="list-badge">2 طلبات</span>
            </div>

            <!-- طلب مكتمل -->
            <div class="order-item">
                <div class="order-info">
                    <h4>دهان غرفة النوم</h4>
                    <p class="order-meta">
                        <span><i class="fas fa-user"></i> خالد الدهان</span>
                        <span><i class="fas fa-calendar-alt"></i> 01/07/2026</span>
                    </p>
                </div>
                <span class="status completed">مكتمل</span>
                <div class="order-actions">
                    <button class="btn-review" onclick="window.location.href='LeaveReview.html'">
                        <i class="fas fa-star"></i> تقييم
                    </button>
                    <button class="btn-details" onclick="window.location.href='OrderDetails.html'">
                        <i class="fas fa-info-circle"></i> تفاصيل
                    </button>
                </div>
            </div>

            <!-- طلب ملغي -->
            <div class="order-item">
                <div class="order-info">
                    <h4>خياطة فستان سهرة</h4>
                    <p class="order-meta">
                        <span><i class="fas fa-user"></i> نورة الخياطة</span>
                        <span><i class="fas fa-calendar-alt"></i> 25/06/2026</span>
                    </p>
                </div>
                <span class="status cancelled">ملغي</span>
                <div class="order-actions">
                    <button class="btn-details" onclick="window.location.href='OrderDetails.html'">
                        <i class="fas fa-info-circle"></i> تفاصيل
                    </button>
                </div>
            </div>
        </div>

    </main>

    <footer class="dashboard-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>