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
    <link rel="stylesheet" href="Profile.css" />
    <title>الملف الشخصي - مهارتي</title>
    <link rel="icon" href="Logo.png" />

</head>
<body>

    <header class="navbar">
        <div class="nav-container">
           @php
    $firstImage = null;
    $imageUrl = 'https://i.pravatar.cc/150?img=3'; 

    if ($profile && $profile->image) {
        $images = json_decode($profile->image, true);
        $firstImage = is_array($images) ? $images[0] ?? null : null;
        
        if ($firstImage) {
            $imageUrl = Storage::url($firstImage) . '?v=' . ($profile->updated_at->timestamp ?? time());
        }
    }
@endphp
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{route('home') }}" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::User()->name }} </span>
               <img 
    src="{{ $imageUrl }}" 
    alt="صورة البروفايل" 
    class="user-avatar" 
    fetchpriority="high" 
    width="36" 
    height="36" 
/>

                <a href="HomeVisitor.html" class="btn-outline" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <main class="profile-container">

    

        <div class="profile-header">
            <div class="profile-avatar-wrapper">
                   <img 
            src="{{ $firstImage ? Storage::url($firstImage) : 'https://i.pravatar.cc/150?img=3' }}" 
            alt="صورة البروفايل" 
           class="profile-avatar" fetchpriority="high" width="120" height="120"
        />
            </div>
            <div class="profile-info">
                <h1 class="profile-name">{{ Auth::User()->name }}</h1>
                <p class="profile-bio">{{ $profile->bio ?? ' لا يوجد' }}</p>
                <div class="profile-meta">
                    <span><i class="fas fa-align-left"></i>{{ $profile->Description ?? ' لا يوجد' }}</span>
                    <hr>
                    <span><i class="fas fa-briefcase"></i> {{ $profile->jobs ?? ' لا يوجد' }}</span>
                    <hr>
                    <span><i class="fas fa-calendar-alt"></i> {{ $profile->experience ?? ' لا يوجد' }} سنوات خبرة</span>
                    <hr>
                    <span><i class="fas fa-calendar-alt"></i> انضم {{ Auth::User()->created_at->format('Y-m-d') }}  </span>
                    <hr>
                    <span><i class="fas fa-map-marker-alt"></i> {{ $profile->location ?? ' لا يوجد' }}</span>
                    <hr>
                    <span><i class="fas fa-money-bill-wave"></i> {{ $profile->price ?? ' لا يوجد' }} ريال يمني</span>

                </div>
            </div>
            <div class="profile-actions">
                <a href="{{ route('EditProfile') }}" class="btn-edit-profile"><i class="fas fa-pen"></i> تعديل الملف</a>
            </div>
        </div>

        <div class="profile-stats">
            <div class="stat-item"><span class="stat-number">{{ $posts->count() }}</span><span class="stat-label">منشورات</span></div>
            <div class="stat-item"><span class="stat-number">45</span><span class="stat-label">متابع</span></div>
            <div class="stat-item"><span class="stat-number">4.8</span><span class="stat-label">تقييم</span></div>
        </div>

        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="posts"><i class="fas fa-newspaper"></i> منشوراتي</button>
            <button class="tab-btn" data-tab="portfolio"><i class="fas fa-images"></i> محفظة الأعمال</button>
            <button class="tab-btn" data-tab="orders"><i class="fas fa-clipboard-list"></i> طلباتي</button>
        </div>

        <section id="tab-posts" class="tab-content active">
            <div class="posts-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                <h3><i class="fas fa-newspaper"></i> منشوراتي</h3>
                <a href="{{ route('CreatePost') }}"><button class="btn-new-post" style="padding:8px 20px; background:rgba(255,255,255,0.08); border:1px solid var(--glass-border); border-radius:50px; color:#fff; font-weight:700; font-family:var(--font-family); cursor:pointer; transition:0.15s; display:flex; align-items:center; gap:8px;"><i class="fas fa-plus"></i> إنشاء منشور</button></a>
            </div>

            

            
                <div class="posts-grid">
                @foreach ($posts as $post)
                <div class="post-card post-client">
                <div class="post-type {{ $post->typeRequest === 'provider' ? 'provider-type' : '' }}">
                @if ($post->typeRequest === 'client')
                    <i class="fas fa-user-plus"></i> طلب خدمة
                @else
                    <i class="fas fa-briefcase"></i> خدمة مقدمة
                @endif
            </div>


                    <div class="post-header">
                        <img src="{{$imageUrl}}" alt="صورة" class="post-avatar" />
                        <div class="post-user-info"><h4>{{ $post->user->name }}</h4><span>{{ $post->created_at->diffForHumans() }}</span></div>
                    </div>
                    <h3>{{ $post->title }}</h3>
                    <p class="post-description">{{ $post->content }}</p>
                    <div class="post-footer">
                        <span class="post-location"><i class="fas fa-location-dot"></i>{{ $post->location  }}</span>
                        <span class="post-price"><i class="fas fa-money-bill-wave"></i> {{$post->price }} ريال</span>
                    </div>
                    <div class="post-cta">
                        <a href="Chat.html"><button class="cta-logged-in"><i class="fas fa-comment"></i> تواصل الآن</button></a>
                    </div>
                </div>
                @endforeach
              

          
            </div>
        </section>

        <!-- ===== تبويب محفظة الأعمال ===== -->
        <section id="tab-portfolio" class="tab-content">
            <div class="portfolio-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap;">
                <h3><i class="fas fa-images"></i> محفظة الأعمال</h3>
                <span style="opacity:0.6;">5 صور</span>
            </div>

            <div class="portfolio-grid">
                <div class="portfolio-item"><img  alt="عمل 1" loading="lazy" decoding="async" width="200" height="200" /><div class="overlay"><button><i class="fas fa-trash"></i> حذف</button></div></div>
                <div class="portfolio-item"><img  alt="عمل 2" loading="lazy" decoding="async" width="200" height="200" /><div class="overlay"><button><i class="fas fa-trash"></i> حذف</button></div></div>
                <div class="portfolio-item"><img  alt="عمل 3" loading="lazy" decoding="async" width="200" height="200" /><div class="overlay"><button><i class="fas fa-trash"></i> حذف</button></div></div>
                <div class="portfolio-item"><img  alt="عمل 4" loading="lazy" decoding="async" width="200" height="200" /><div class="overlay"><button><i class="fas fa-trash"></i> حذف</button></div></div>
                <div class="portfolio-item add-item">
                    <div style="text-align:center; color:var(--text-light);">
                        <i class="fas fa-plus" style="font-size:3rem; color:var(--gold);"></i>
                        <p>رفع صورة</p>
                    </div>
                    <input type="file" style="position:absolute; opacity:0; width:100%; height:100%; cursor:pointer;" />
                </div>
            </div>

            <div class="upload-area">
                <i class="fas fa-cloud-upload-alt" style="font-size:3rem; color:var(--gold);"></i>
                <p style="margin-top:10px;">اسحب الصور هنا أو اضغط للاختيار</p>
                <input type="file" multiple />
            </div>
        </section>

        <!-- ===== تبويب الطلبات ===== -->
        <section id="tab-orders" class="tab-content">
            <div class="orders-header" style="margin-bottom:20px;"><h3><i class="fas fa-clipboard-list"></i> طلباتي</h3></div>
            <div class="orders-list">
                <div class="order-item"><div class="info"><h4>تركيب مطبخ جديد</h4><p><i class="fas fa-user"></i> أحمد النجار · الرياض</p></div><span class="status pending">قيد الانتظار</span></div>
                <div class="order-item"><div class="info"><h4>تسريب مياه الحمام</h4><p><i class="fas fa-user"></i> فهد السباك · الدمام</p></div><span class="status active">قيد التنفيذ</span></div>
                <div class="order-item"><div class="info"><h4>دهان غرفة النوم</h4><p><i class="fas fa-user"></i> محمد الدهان · مكة</p></div><span class="status completed">مكتمل</span></div>
            </div>
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = {
                posts: document.getElementById('tab-posts'),
                portfolio: document.getElementById('tab-portfolio'),
                orders: document.getElementById('tab-orders')
            };
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    Object.values(contents).forEach(c => c.classList.remove('active'));
                    const tabName = this.dataset.tab;
                    if (contents[tabName]) contents[tabName].classList.add('active');
                });
            });
        });
    </script>

</body>
</html>