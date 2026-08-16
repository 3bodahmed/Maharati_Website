<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css"></noscript>
    <link rel="stylesheet" href="{{ asset('Profile.css') }}" />
    <title>الملف الشخصي - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
    <style>
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
    </style>
</head>
<body>
    @if ($errors->any())
        <div class="error-messages">
            <h1 class="error-title">يوجد خطأ في البيانات المدخلة</h1>
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="success-message">
            <ul class="error-list">
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif

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
    @endphp

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('home') }}" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                @auth
                    <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                    <img src="{{ $avatarUrl }}" alt="صورة البروفايل" class="user-avatar" fetchpriority="high" width="36" height="36" />
                    @if(isset($isOwner) && $isOwner)
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
                @if(isset($isOwner) && $isOwner)
                    <a href="{{ route('EditProfile') }}" class="btn-edit-profile"><i class="fas fa-pen"></i> تعديل الملف</a>
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
            <button class="tab-btn active" data-tab="posts"><i class="fas fa-newspaper"></i> @if(isset($isOwner) && $isOwner) منشوراتي @else منشوراته @endif</button>
            <button class="tab-btn" data-tab="portfolio"><i class="fas fa-images"></i> محفظة الأعمال</button>
            @if(isset($isOwner) && $isOwner)
                <button class="tab-btn" data-tab="orders"><i class="fas fa-paper-plane"></i> طلباتي المرسلة</button>
                <button class="tab-btn" data-tab="received"><i class="fas fa-inbox"></i> الطلبات الواردة</button>
            @endif
        </div>

        <!-- ===== تبويب المنشورات ===== -->
        <section id="tab-posts" class="tab-content active">
            <div class="posts-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                <h3><i class="fas fa-newspaper"></i> @if(isset($isOwner) && $isOwner) منشوراتي @else منشوراته @endif</h3>
                @if(isset($isOwner) && $isOwner)
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
                        <div class="post-type {{ $post->typeRequest === 'provider' ? 'provider-type' : '' }}">
                            @if ($post->typeRequest === 'client')
                                <i class="fas fa-user-plus"></i> طلب خدمة
                            @else
                                <i class="fas fa-briefcase"></i> خدمة مقدمة
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

            @if(isset($isOwner) && $isOwner)
                <form enctype="multipart/form-data" method="POST" action="{{ route('CreateProfile') }}">
                    @csrf
                    <div class="portfolio-grid">
                        @if($profile && $profile->works)
                            @php $worksImages = json_decode($profile->works, true); @endphp
                            @if(is_array($worksImages) && count($worksImages) > 0)
                                @foreach($worksImages as $workImage)
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
                    @if($profile && $profile->works)
                        @php $worksImages = json_decode($profile->works, true); @endphp
                        @if(is_array($worksImages) && count($worksImages) > 0)
                            @foreach($worksImages as $workImage)
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
        @if(isset($isOwner) && $isOwner)
            <section id="tab-orders" class="tab-content">
                <div class="orders-header" style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
                    <h3><i class="fas fa-clipboard-list"></i> طلباتي المرسلة</h3>
                    <a href="{{ route('orders.create') }}" class="btn-new-request" style="padding:8px 20px; background:rgba(255,255,255,0.08); border:1px solid var(--glass-border); border-radius:50px; color:#fff; font-weight:700; font-family:var(--font-family); cursor:pointer; transition:0.15s; display:flex; align-items:center; gap:8px; text-decoration:none;">
                        <i class="fas fa-plus"></i> طلب جديد
                    </a>
                </div>
                <div class="orders-list">
                    @forelse($orders as $order)
                        <div class="order-item">
                            <div class="info">
                                <h4>{{ $order->title }}</h4>
                                <p><i class="fas fa-user"></i> {{ $order->provider ? $order->provider->name : 'لم يتم تعيين' }} · {{ $order->location ?? 'بدون موقع' }}</p>
                                <p><i class="fas fa-dollar-sign"></i> {{ $order->price ?? 'غير محدد' }} ريال</p>
                            </div>
                            <span class="status {{ $order->status }}">
                                @switch($order->status)
                                    @case('pending') قيد الانتظار @break
                                    @case('in_progress') قيد التنفيذ @break
                                    @case('completed') مكتمل @break
                                    @case('cancelled') ملغي @break
                                @endswitch
                            </span>
                            <div style="margin-top:10px;">
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn-edit-profile" style="padding:4px 12px; font-size:0.8rem;margin:5px;width:70px;">تعديل</a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-edit-profile" style="background:#c0392b; padding:4px 12px; font-size:0.8rem;margin:5px;width:70px" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="text-align:center; opacity:0.7;">لا توجد طلبات مرسلة</p>
                    @endforelse
                </div>
            </section>
        @endif

        <!-- ===== تبويب الطلبات الواردة ===== -->
        @if(isset($isOwner) && $isOwner)
            <section id="tab-received" class="tab-content">
                <div class="orders-header" style="margin-bottom:20px;">
                    <h3><i class="fas fa-inbox"></i> الطلبات الواردة</h3>
                </div>
                <div class="orders-list">
                    @if(isset($receivedOrders) && $receivedOrders->count() > 0)
                        @foreach($receivedOrders as $order)
                            <div class="order-item">
                                <div class="info">
                                    <h4>{{ $order->title }}</h4>
                                    <p><i class="fas fa-user"></i> من: {{ $order->user->name ?? 'مستخدم غير معروف' }} · {{ $order->location ?? 'بدون موقع' }}</p>
                                    <p><i class="fas fa-dollar-sign"></i> {{ $order->price ?? 'غير محدد' }} ريال</p>
                                </div>
                                <span class="status {{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending') قيد الانتظار @break
                                        @case('in_progress') قيد التنفيذ @break
                                        @case('completed') مكتمل @break
                                        @case('cancelled') ملغي @break
                                    @endswitch
                                </span>
                                <div style="margin-top:10px;">
                                    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="in_progress">
                                        <button type="submit" class="btn-edit-profile" style="background:#2ecc71; padding:4px 12px; font-size:0.8rem;">قبول</button>
                                    </form>
                                    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn-edit-profile" style="background:#e74c3c; padding:4px 12px; font-size:0.8rem;">رفض</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p style="text-align:center; opacity:0.7;">لا توجد طلبات واردة</p>
                    @endif
                </div>
            </section>
        @endif

    </main>

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
                fileInput.addEventListener('change', function (e) {
                    const files = Array.from(e.target.files);
                    files.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function (ev) {
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
                body: JSON.stringify({ image: imagePath })
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