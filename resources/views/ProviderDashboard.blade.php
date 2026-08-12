<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="AppStyles.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" /> 
    <title>لوحة مقدم الخدمة - مهارتي</title>
    <link rel="icon" href="Logo.png" />
</head>
<body>
    <header class="navbar"><!-- نفس النافبار مع تغيير الاسم --></header>

    <main class="dashboard-container">
        <div class="page-header">
            <h1>لوحة تحكم <span>مقدم الخدمة</span></h1>
            <span class="badge-count"><i class="fas fa-bell"></i> 5 طلبات جديدة</span>
        </div>

        <div class="stats-grid">
            <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">طلبات جديدة</div></div>
            <div class="stat-card"><div class="stat-number">8</div><div class="stat-label">قيد التنفيذ</div></div>
            <div class="stat-card"><div class="stat-number">42</div><div class="stat-label">مكتملة</div></div>
        </div>

        <!-- الطلبات الواردة -->
        <div class="list-card">
            <h3><i class="fas fa-inbox"></i> الطلبات الواردة</h3>
            <div class="order-item"><div class="info"><h4>تركيب مطبخ</h4><p><i class="fas fa-user"></i> محمد السالم · الرياض</p></div><span class="status pending">جديد</span><div class="action-group"><button class="btn-sm accept">قبول</button><button class="btn-sm reject">رفض</button></div></div>
            <div class="order-item"><div class="info"><h4>تسريب مياه</h4><p><i class="fas fa-user"></i> سارة العتيبي · الدمام</p></div><span class="status active">قيد التنفيذ</span><div class="action-group"><button class="btn-sm complete" style="background:var(--gold);">تحديد كمكتمل</button><button class="btn-sm chat"><i class="fas fa-comment"></i></button></div></div>
            <div class="order-item"><div class="info"><h4>تمديد كهرباء</h4><p><i class="fas fa-user"></i> فهد القحطاني · جدة</p></div><span class="status active">قيد التنفيذ</span><div class="action-group"><button class="btn-sm start" style="background:var(--blue);">بدء التنفيذ</button></div></div>
        </div>
    </main>
</body>
</html>