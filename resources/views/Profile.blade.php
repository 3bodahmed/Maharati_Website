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
    <title>الملف الشخصي - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
    <style>
        .head-post {
            display: flex;
            justify-content: space-between;
        }
        .btn-new-request:hover{
            color: white;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: #ffffff;
            border: none;
            padding: 10px 28px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(231, 76, 60, 0.25);
            transition: all 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(231, 76, 60, 0.4);
        }
        .btn-edit-profile:hover{
            color: white;
        }
        .btn-delete:active {
            transform: translateY(0px);
            box-shadow: 0 2px 4px rgba(231, 76, 60, 0.3);
        }
        .btn-delete:focus-visible {
            outline: 3px solid #000000;
            outline-offset: 3px;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        .status.pending { background: #f39c12; color: #000; }
        .status.in_progress { background: #3498db; color: #fff; }
        .status.completed { background: #2ecc71; color: #000; }
        .status.cancelled { background: #e74c3c; color: #fff; }

        .orders-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 25px;
        }
        .stat-badge {
            padding: 6px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            background: var(--color-bg, #f8fafc);
            border: 1px solid var(--color-border, #e2e8f0);
            color: var(--color-text-secondary, #475569);
        }
        .stat-badge.pending { border-color: #f39c12; color: #f39c12; background: rgba(243, 156, 18, 0.08); }
        .stat-badge.in_progress { border-color: #3498db; color: #3498db; background: rgba(52, 152, 219, 0.08); }
        .stat-badge.completed { border-color: #2ecc71; color: #2ecc71; background: rgba(46, 204, 113, 0.08); }
        .stat-badge.cancelled { border-color: #e74c3c; color: #e74c3c; background: rgba(231, 76, 60, 0.08); }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .order-item {
            background: var(--color-surface, #ffffff);
            border: 1px solid var(--color-border, #e2e8f0);
            border-radius: 20px;
            padding: 18px 22px;
            transition: all 0.2s ease;
        }
        .order-item:hover {
            border-color: var(--color-primary, #1a73e8);
            box-shadow: var(--shadow-soft, 0 10px 30px -5px rgba(15,23,42,0.06));
        }
        .order-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px dashed var(--color-border, #e2e8f0);
            padding-bottom: 8px;
        }
        .order-id {
            font-weight: 700;
            color: var(--color-text-light, #94a3b8);
            font-size: 0.9rem;
        }
        .order-body h4 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--color-text, #0f172a);
            margin-bottom: 6px;
        }
        .order-body p {
            margin: 4px 0;
            color: var(--color-text-secondary, #475569);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .order-body p i {
            width: 18px;
            color: var(--color-primary, #1a73e8);
        }
        .order-date {
            font-size: 0.8rem;
            color: var(--color-text-light, #94a3b8) !important;
        }
        .order-actions {
            margin-top: 14px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .order-actions .btn-edit-profile,
        .order-actions .btn-delete,
        .order-actions .btn-accept,
        .order-actions .btn-reject {
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
            text-decoration: none;
        }
        .btn-accept {
            background: #2ecc71;
            color: #000;
        }
        .btn-accept:hover {
            background: #27ae60;
            transform: translateY(-2px);
        }
        .btn-reject {
            background: #e74c3c;
            color: #fff;
        }
        .btn-reject:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        /* زر العودة إلى لوحة التحكم (مخصص للمدير) */
        .btn-dashboard {
            background: rgba(241, 196, 15, 0.15);
            border: 1px solid #f1c40f;
            color: #f1c40f;
            padding: 8px 18px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-dashboard:hover {
            background: rgba(241, 196, 15, 0.25);
            transform: translateY(-2px);
        }
        @media (max-width: 600px) {
            .order-item { padding: 14px 16px; }
            .order-head { flex-direction: column; align-items: flex-start; gap: 6px; }
            .order-actions { flex-direction: column; width: 100%; }
            .order-actions form,
            .order-actions a {
                width: 100%;
            }
            .order-actions .btn-edit-profile,
            .order-actions .btn-delete,
            .order-actions .btn-accept,
            .order-actions .btn-reject {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    @php
        $firstImage = null;
        $avatarUrl = $imageUrl ?? 'https://i.pravatar.cc/150?img=3';
        if ($profile && $profile->image) {
            $images = json_decode($profile->image, true);
            $firstImage = is_array($images) ? $images[0] ?? null : null;
            if ($firstImage) {
                $avatarUrl = Storage::url($firstImage) . '?v=' . ($profile->updated_at->timestamp ?? time());
            }
        }
        // تحديد إذا كان المستخدم الحالي مديراً أم لا
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
    @endphp

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
                    <img src="{{ $avatarUrl }}" alt="صورة البروفايل" class="user-avatar" fetchpriority="high" width="36" height="36" />
                    @if (isset($isOwner) && $isOwner)
                        <a href="{{ route('login') }}" class="btn-outline" >
                            <i class="fas fa-sign-out-alt"></i> خروج
                        </a>
                    @else
                        <a href="{{ route('profile') }}" class="btn-outline"><i class="fas fa-user-circle"></i> ملفي</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-outline"><i class="fas fa-sign-in-alt"></i> دخول</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="profile-container">
        <!-- ===== Header ===== -->
        <div class="profile-header">
            <div class="profile-avatar-wrapper">
                <img src="{{ $avatarUrl }}" alt="صورة البروفايل" class="profile-avatar" fetchpriority="high" width="120" height="120" />
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ $user->name }}</h1>
                <h3>@ {{ $user->username ?? '' }}</h3>
                <p class="profile-bio">{{ $profile->bio ?? 'لا يوجد' }}</p>
                <div class="profile-meta">
                    <span><i class="fas fa-align-left"></i>{{ $profile->Description ?? 'لا يوجد' }}</span>
                    <hr>
                    <span><i class="fas fa-briefcase"></i> {{ $profile->jobs ?? 'لا يوجد' }}</span>
                    <hr>
                    <span><i class="fas fa-calendar-alt"></i> {{ $profile->experience ?? 'لا يوجد' }} سنوات خبرة</span>
                    <hr>
                    <span><i class="fas fa-calendar-alt"></i> انضم {{ $user->created_at->format('Y-m-d') }}</span>
                    <hr>
                    <span><i class="fas fa-map-marker-alt"></i> {{ $profile->location ?? 'لا يوجد' }}</span>
                    <hr>
                    <span><i class="fas fa-money-bill-wave"></i> {{ $profile->price ?? 'لا يوجد' }} ريال يمني</span>
                </div>
            </div>
            <div class="profile-actions">
                @if (isset($isOwner) && $isOwner)
                    <a href="{{ route('EditProfile') }}" class="btn-edit-profile" ><i class="fas fa-pen"></i> تعديل الملف</a>
                @endif
                {{-- إذا كان المستخدم مديراً ويزور ملفه الشخصي، أضف زر لوحة التحكم أيضاً هنا --}}
                @if($isAdmin && isset($isOwner) && $isOwner)
                    <a href="{{ route('admin.dashboard') }}" class="btn-dashboard" style="margin-top:10px; display:inline-block;">
                        <i class="fas fa-chart-pie"></i> لوحة التحكم
                    </a>
                @endif
            </div>
        </div>

        <!-- ===== Stats ===== -->
        <div class="profile-stats">
            <div class="stat-item"><span class="stat-number">{{ $posts->count() }}</span><span class="stat-label">منشورات</span></div>
            <div class="stat-item"><span class="stat-number">{{ $orders->count() }}</span><span class="stat-label">الطلبات المرسله</span></div>
            <div class="stat-item"><span class="stat-number">{{ $receivedOrders->count() }}</span><span class="stat-label">الطلبات الواردة</span></div>
        </div>

        <!-- ===== Tabs ===== -->
        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="posts"><i class="fas fa-newspaper"></i> @if (isset($isOwner) && $isOwner) منشوراتي @else منشوراته @endif</button>
            <button class="tab-btn" data-tab="portfolio"><i class="fas fa-images"></i> محفظة الأعمال</button>
            @if (isset($isOwner) && $isOwner)
                <button class="tab-btn" data-tab="orders"><i class="fas fa-paper-plane"></i> طلباتي المرسلة</button>
                <button class="tab-btn" data-tab="received"><i class="fas fa-inbox"></i> الطلبات الواردة</button>
            @endif
        </div>

        <!-- ===== تبويب المنشورات ===== -->
        <section id="tab-posts" class="tab-content active">
            <div class="posts-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                <h3><i class="fas fa-newspaper"></i> @if (isset($isOwner) && $isOwner) منشوراتي @else منشوراته @endif</h3>
                @if (isset($isOwner) && $isOwner)
                    <a href="{{ route('CreatePost') }}"><button class="btn-new-post" style="padding:8px 20px; background:rgba(255,255,255,0.08); border:1px solid var(--glass-border); border-radius:50px; color:#fff; font-weight:700; font-family:var(--font-family); cursor:pointer; transition:0.15s; display:flex; align-items:center; gap:8px;"><i class="fas fa-plus"></i> إنشاء منشور</button></a>
                @endif
            </div>

            <div class="posts-grid">
                @foreach ($posts as $post)
                    @php
                        $postOwner = $post->user;
                        $postAvatar = 'https://i.pravatar.cc/150?img=3';
                        if ($postOwner->profile && $postOwner->profile->image) {
                            $images = json_decode($postOwner->profile->image, true);
                            $first = is_array($images) ? $images[0] ?? null : null;
                            if ($first) {
                                $postAvatar = Storage::url($first) . '?v=' . ($postOwner->profile->updated_at->timestamp ?? time());
                            }
                        }
                    @endphp
                    <div class="post-card post-client">
                        <div class="head-post">
                            <div class="post-type {{ $post->typeRequest === 'provider' ? 'provider-type' : '' }}">
                                @if ($post->typeRequest === 'client')
                                    <i class="fas fa-user-plus"></i> طلب خدمة
                                @else
                                    <i class="fas fa-briefcase"></i> خدمة مقدمة
                                @endif
                            </div>
                            @if (isset($isOwner) && $isOwner)
                                <div style="display: flex;">
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-delete"
                                            onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                    </form>
                                    <button class="btn-delete" style="background: rgb(227, 227, 55);margin:0 10px">
                                        <a href="{{ route('post.edit', $post->id) }}" style="text-decoration: none;color:white;" >تعديل</a>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="post-header">
                            <a href="{{ route('profile.show', $postOwner->id) }}">
                                <img src="{{ $postAvatar }}" alt="صورة" class="post-avatar" />
                            </a>
                            <div class="post-user-info">
                                <h4><a href="{{ route('profile.show', $postOwner->id) }}" style="color:inherit; text-decoration:none;">{{ $postOwner->name }}</a></h4>
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
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ===== تبويب محفظة الأعمال ===== -->
        <section id="tab-portfolio" class="tab-content">
            <div class="portfolio-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap;">
                <h3><i class="fas fa-images"></i> محفظة الأعمال</h3>
                <span style="opacity:0.6;">
                    {{ $profile && $profile->works ? count(json_decode($profile->works, true)) : 0 }} صور
                </span>
            </div>

            @if (isset($isOwner) && $isOwner)
                <form enctype="multipart/form-data" method="POST" action="{{ route('CreateProfile') }}">
                    @csrf
                    <div class="portfolio-grid">
                        @if ($profile && $profile->works)
                            @php $worksImages = json_decode($profile->works, true); @endphp
                            @if (is_array($worksImages) && count($worksImages) > 0)
                                @foreach ($worksImages as $workImage)
                                    <div class="portfolio-item" data-image="{{ $workImage }}">
                                        <img src="{{ Storage::url($workImage) }}" alt="عمل" loading="lazy" decoding="async" width="200" height="200" />
                                        <div class="overlay">
                                            <button type="button" onclick="deleteWorkImage('{{ $workImage }}')"><i class="fas fa-trash"></i> حذف</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p style="text-align:center; opacity:0.7; grid-column: 1 / -1;">لا توجد صور في محفظة الأعمال</p>
                            @endif
                        @else
                            <p style="text-align:center; opacity:0.7; grid-column: 1 / -1;">لا توجد صور في محفظة الأعمال</p>
                        @endif
                        <div class="portfolio-item add-item">
                            <div style="text-align:center; color:var(--text-light);">
                                <i class="fas fa-plus" style="font-size:3rem; color:var(--gold);"></i>
                                <p>رفع صورة</p>
                            </div>
                            <input type="file" name="works[]" style="position:absolute; opacity:0; width:100%; height:100%; cursor:pointer;" accept="image/*" multiple />
                        </div>
                    </div>
                    <button type="submit" class="btn-save" id="saveBtn">حفظ</button>
                </form>
            @else
                <div class="portfolio-grid">
                    @if ($profile && $profile->works)
                        @php $worksImages = json_decode($profile->works, true); @endphp
                        @if (is_array($worksImages) && count($worksImages) > 0)
                            @foreach ($worksImages as $workImage)
                                <div class="portfolio-item">
                                    <img src="{{ Storage::url($workImage) }}" alt="عمل" loading="lazy" decoding="async" width="200" height="200" />
                                </div>
                            @endforeach
                        @else
                            <p style="text-align:center; opacity:0.7; grid-column: 1 / -1;">لا توجد صور في محفظة الأعمال</p>
                        @endif
                    @else
                        <p style="text-align:center; opacity:0.7; grid-column: 1 / -1;">لا توجد صور في محفظة الأعمال</p>
                    @endif
                </div>
            @endif
        </section>

        <!-- ===== تبويب الطلبات المرسلة ===== -->
        @if (isset($isOwner) && $isOwner)
        <section id="tab-orders" class="tab-content">
            <div class="orders-header" style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <h3><i class="fas fa-paper-plane"></i> طلباتي المرسلة</h3>
                <a href="{{ route('orders.create') }}" class="btn-new-request" >
                    <i class="fas fa-plus"></i> طلب جديد
                </a>
            </div>

            <div class="orders-stats">
                <span class="stat-badge pending">قيد الانتظار: {{ $orders->where('status', 'pending')->count() }}</span>
                <span class="stat-badge in_progress">قيد التنفيذ: {{ $orders->where('status', 'in_progress')->count() }}</span>
                <span class="stat-badge completed">مكتمل: {{ $orders->where('status', 'completed')->count() }}</span>
                <span class="stat-badge cancelled">ملغي: {{ $orders->where('status', 'cancelled')->count() }}</span>
            </div>

            <div class="orders-list">
                @forelse($orders as $order)
                    <div class="order-item">
                        <div class="order-head">
                            <span class="order-id">#{{ $order->id }}</span>
                            <span class="status {{ $order->status }}">
                                @switch($order->status)
                                    @case('pending')   <i class="fas fa-clock"></i> قيد الانتظار @break
                                    @case('in_progress') <i class="fas fa-spinner"></i> قيد التنفيذ @break
                                    @case('completed') <i class="fas fa-check-circle"></i> مكتمل @break
                                    @case('cancelled') <i class="fas fa-times-circle"></i> ملغي @break
                                @endswitch
                            </span>
                        </div>
                        <div class="order-body">
                            <h4>{{ $order->title }}</h4>
                            <p><i class="fas fa-user"></i> المقدم: {{ $order->provider ? $order->provider->name : 'لم يتم تعيين' }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $order->location ?? 'بدون موقع' }}</p>
                            <p><i class="fas fa-money-bill-wave"></i> {{ $order->price ?? 'غير محدد' }} ريال</p>
                            <p class="order-date"><i class="far fa-calendar-alt"></i> {{ $order->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="order-actions">
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn-edit-profile" style="padding:6px 16px; font-size:0.8rem;">
                                <i class="fas fa-pen"></i> تعديل
                            </a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete" style="padding:6px 16px; font-size:0.8rem;" onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center; opacity:0.7; padding:20px 0;">لا توجد طلبات مرسلة</p>
                @endforelse
            </div>
        </section>
        @endif

        <!-- ===== تبويب الطلبات الواردة ===== -->
        @if (isset($isOwner) && $isOwner)
        <section id="tab-received" class="tab-content">
            <div class="orders-header" style="margin-bottom:20px;">
                <h3><i class="fas fa-inbox"></i> الطلبات الواردة</h3>
            </div>

            <div class="orders-stats">
                <span class="stat-badge pending">قيد الانتظار: {{ $receivedOrders->where('status', 'pending')->count() }}</span>
                <span class="stat-badge in_progress">قيد التنفيذ: {{ $receivedOrders->where('status', 'in_progress')->count() }}</span>
                <span class="stat-badge completed">مكتمل: {{ $receivedOrders->where('status', 'completed')->count() }}</span>
                <span class="stat-badge cancelled">ملغي: {{ $receivedOrders->where('status', 'cancelled')->count() }}</span>
            </div>

            <div class="orders-list">
                @if($receivedOrders->count() > 0)
                    @foreach($receivedOrders as $order)
                        <div class="order-item">
                            <div class="order-head">
                                <span class="order-id">#{{ $order->id }}</span>
                                <span class="status {{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending')   <i class="fas fa-clock"></i> قيد الانتظار @break
                                        @case('in_progress') <i class="fas fa-spinner"></i> قيد التنفيذ @break
                                        @case('completed') <i class="fas fa-check-circle"></i> مكتمل @break
                                        @case('cancelled') <i class="fas fa-times-circle"></i> ملغي @break
                                    @endswitch
                                </span>
                            </div>
                            <div class="order-body">
                                <h4>{{ $order->title }}</h4>
                                <p><i class="fas fa-user"></i> من: {{ $order->user->name ?? 'مستخدم غير معروف' }}</p>
                                <p><i class="fas fa-map-marker-alt"></i> {{ $order->location ?? 'بدون موقع' }}</p>
                                <p><i class="fas fa-money-bill-wave"></i> {{ $order->price ?? 'غير محدد' }} ريال</p>
                                <p class="order-date"><i class="far fa-calendar-alt"></i> {{ $order->created_at->format('Y-m-d') }}</p>
                            </div>
                            <div class="order-actions">
                                @if($order->status == 'pending')
                                    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="in_progress">
                                        <button type="submit" class="btn-accept"><i class="fas fa-check"></i> قبول</button>
                                    </form>
                                    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn-reject"><i class="fas fa-times"></i> رفض</button>
                                    </form>
                                @else
                                    <span style="opacity:0.6; font-size:0.9rem;">تم الرد</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="text-align:center; opacity:0.7; padding:20px 0;">لا توجد طلبات واردة</p>
                @endif
            </div>
        </section>
        @endif

    </main>
    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== التبويبات =====
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active');
                    });

                    const tabName = this.dataset.tab;
                    const target = document.getElementById('tab-' + tabName);
                    if (target) {
                        target.classList.add('active');
                    }
                });
            });

            // ===== معاينة الصور المختارة =====
            const fileInput = document.querySelector('input[name="works[]"]');
            const portfolioGrid = document.querySelector('.portfolio-grid');
            if (fileInput && portfolioGrid) {
                fileInput.addEventListener('change', function(e) {
                    const files = Array.from(e.target.files);
                    files.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const item = document.createElement('div');
                            item.className = 'portfolio-item';
                            item.innerHTML = `
                                <img src="${ev.target.result}" alt="معاينة" style="width:100%; height:100%; object-fit:cover; border-radius:8px;" />
                                <div class="overlay">
                                    <span style="color:#fff; background:rgba(0,0,0,0.6); padding:4px 12px; border-radius:20px; font-size:0.8rem;">جديد</span>
                                </div>
                            `;
                            const addItem = portfolioGrid.querySelector('.add-item');
                            portfolioGrid.insertBefore(item, addItem);
                        };
                        reader.readAsDataURL(file);
                    });
                });
            }
        });

        // ===== حذف صورة عمل =====
        function deleteWorkImage(imagePath) {
            if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) return;
            fetch('{{ route('delete.work.image') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image: imagePath
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = document.querySelector(`[data-image="${imagePath}"]`);
                        if (item) item.remove();
                        const counter = document.querySelector('.portfolio-header span');
                        if (counter) {
                            let count = parseInt(counter.textContent.trim()) || 0;
                            counter.textContent = (count - 1) + ' صور';
                        }
                    } else {
                        alert('فشل الحذف: ' + data.message);
                    }
                })
                .catch(error => console.error('خطأ:', error));
        }
    </script>
</body>
</html>