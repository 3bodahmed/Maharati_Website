<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- استيراد أنماط التعديل -->
    <link rel="stylesheet" href="EditProfile.css" />
    
    <!-- مكتبة الأيقونات -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />     
    
    <title>تعديل الملف الشخصي - مهارتي</title>
    <link rel="icon" href="Logo.png" />
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
    $imageUrl = 'https://i.pravatar.cc/150?img=3'; 

    if ($profile && $profile->image) {
        $images = json_decode($profile->image, true);
        $firstImage = is_array($images) ? $images[0] ?? null : null;
        
        if ($firstImage) {
            $imageUrl = Storage::url($firstImage) . '?v=' . ($profile->updated_at->timestamp ?? time());
        }
    }
@endphp
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="Logo.png" alt="شعار مهارتي" class="nav-logo" />
                <h2>في <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="/home" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::User()->name }}</span>
                <img src="{{ $imageUrl }}" alt="صورة" class="user-avatar" />
                <a href="/login" class="btn-outline" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <main class="edit-container">

        <div class="edit-header">
            <h1><i class="fas fa-user-edit"></i> تعديل <span>الملف الشخصي</span></h1>
            <a href="{{ route('profile') }}" class="btn-cancel"><i class="fas fa-arrow-right"></i> العودة للملف</a>
        </div>

        <form id="editProfileForm" class="edit-form" enctype="multipart/form-data" method="POST" action="{{route('CreateProfile')}}">
            @csrf
            <div class="avatar-section">
                <div class="avatar-preview-wrapper">
           
        
        
        
        <img 
            src="{{ $imageUrl }}" 
            alt="صورة البروفايل" 
            id="avatarPreview" 
            class="avatar-preview" 
        />

        <label for="avatarInput" class="avatar-upload-label">
            <i class="fas fa-camera"></i>
        </label>
        <input type="file" name="image[]" id="avatarInput" accept="image/*" multiple />
                </div>
                <p class="avatar-hint">اضغط على الكاميرا لتغيير الصورة</p>
            </div>

            <!-- ===== الحقول الأساسية ===== -->
            <div class="form-grid">

                <div class="form-group full-width">
                    <label for="fullName"><i class="fas fa-user"></i> الاسم الكامل</label>
                    <input type="text" name="fullName" id="fullName" value="{{ Auth::User()->name }}" placeholder="أدخل اسمك الكامل" />
                </div>
                @php
                    $jobs = [
                        'لا يوجد' => 'لا يوجد مهنه',
                        'مهندس برمجيات' => 'مهندس برمجيات',
                        'نجار' => 'نجار',
                        'سباك' => 'سباك',
                        'كهربائي' => 'كهربائي',
                        'دهان' => 'دهان',
                        'خياط' => 'خياط',
                        'مطور ويب' => 'مطور ويب',
                    ];
                    $selectedJob = old('jobTitle', $profile->jobs ?? 'لا يوجد');
                @endphp
              <div class="form-group">
                    <label for="jobTitle"><i class="fas fa-briefcase"></i> المهنة</label>
                    <select id="jobTitle" name="jobTitle">
                                        @foreach ($jobs as $value => $label)
                                            <option value="{{ $value }}" {{ $selectedJob == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="experience"><i class="fas fa-calendar-alt"></i> سنوات الخبرة</label>
                    <input type="number" name="experience" id="experience" value="{{ $profile ? $profile->experience : '' }}" placeholder="0" min="0" />
                </div>

                <div class="form-group full-width">
                    <label for="bio"><i class="fas fa-quote-right"></i> السيرة الذاتية (Bio)</label>
                    <input type="text" name="bio" id="bio" value="{{ $profile ? $profile->bio : '' }}" placeholder="وصف مختصر عنك" />
                </div>

                <div class="form-group">
                    <label for="price"><i class="fas fa-money-bill-wave"></i> السعر (اختياري)</label>
                    <input type="number" name="price" id="price" value="{{ $profile ? $profile->price : '0' }}" placeholder="ر.س" />
                </div>

                <div class="form-group">
                    <label for="location"><i class="fas fa-map-marker-alt"></i> الموقع</label>
                    <input type="text" name="location" id="location" value="{{ $profile ? $profile->location : '' }}" placeholder="المدينة، الحي" />
                </div>

                <div class="form-group full-width">
                    <label for="about"><i class="fas fa-align-left"></i> الوصف التفصيلي</label>
                    <textarea name="about" id="about" rows="5" placeholder="اكتب وصفاً مفصلاً عن خدماتك وخبراتك...">{{ $profile ? $profile->Description : '' }}</textarea>
                </div>

            </div>

            <!-- ===== أزرار الإجراء ===== -->
            <div class="form-actions">
                <button type="reset" class="btn-reset"><i class="fas fa-undo"></i> إعادة تعيين</button>
                <button type="submit" class="btn-save" id="saveBtn">
                    <span class="btn-text"><i class="fas fa-save"></i> حفظ التغييرات</span>
                    <span class="spinner" style="display: none;"></span>
                </button>
            </div>

            <!-- ===== رسالة الحالة ===== -->
            <div id="formMessage" class="form-message" style="display: none;"></div>

        </form>

    </main>

    <script>
        // 1. معاينة الصورة عند التحميل
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('avatarPreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });


        // 3. إعادة تعيين الحقول (حل بديل للزر)
        document.querySelector('.btn-reset').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من إعادة تعيين التغييرات؟')) {
                window.location.reload();
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
        var errorDiv = document.querySelector('.error-messages');
        if (errorDiv) {
            setTimeout(function() {
                errorDiv.style.transition = 'opacity 0.8s ease';
                errorDiv.style.opacity = '0';
                setTimeout(function() {
                    errorDiv.style.display = 'none';
                }, 800);
            }, 3000);
        }
    });
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