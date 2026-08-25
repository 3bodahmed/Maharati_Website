<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />     
    <title>@isset($post) تعديل منشور @else إنشاء منشور @endisset - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
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
            <h1 class="error-title">@isset($post) تم التعديل بنجاح @else تم إنشاء المنشور بنجاح @endisset</h1>
            <ul class="error-list">
                <li>{{ session('success') }}</li>
            </ul>
        </div>
    @endif

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2> <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('home') }}" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::User()->name }}  </span>
                <a href="{{ route('profile') }}"><img src="{{ $imageUrl }}" alt="صورة" class="user-avatar" /></a>
                <a href="/register" class="btn-outline" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <main class="create-container">

        <div class="create-header">
            <h1>
                <i class="fas fa-pen-fancy"></i> 
                @isset($post)
                    تعديل <span>المنشور</span>
                @else
                    إنشاء <span>منشور جديد</span>
                @endisset
            </h1>
            <a href="/home" class="btn-cancel"><i class="fas fa-arrow-right"></i> إلغاء</a>
        </div>

        {{-- بداية النموذج --}}
        <form id="createPostForm" method="POST" 
              action="@isset($post) {{ route('post.update', $post->id) }} @else {{ route('posts.store') }} @endisset" 
              class="create-form" enctype="multipart/form-data">
            
            @csrf
            @isset($post)
                @method('PUT')
            @endisset

            <div class="user-info-bar">
                <img src="{{ $imageUrl }}" alt="صورة" class="user-avatar-lg" />
                <div>
                    <h4>{{ Auth::user()->name }}</h4>
                </div>
            </div>
           
            {{-- نوع المنشور (راديو) --}}
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نوع المنشور</label>
                <div class="post-type-selector">
                    <label class="type-option">
                        <input type="radio" name="postType" value="client" 
                            {{ (old('postType', $post->typeRequest ?? 'client') == 'client') ? 'checked' : '' }} />
                        <span><i class="fas fa-user-plus"></i> طلب خدمة</span>
                    </label>
                    <label class="type-option">
                        <input type="radio" name="postType" value="provider" 
                            {{ (old('postType', $post->typeRequest ?? 'client') == 'provider') ? 'checked' : '' }} />
                        <span><i class="fas fa-briefcase"></i> عرض خدمة</span>
                    </label>
                </div>
            </div>

            {{-- العنوان --}}
            <div class="form-group">
                <label for="postTitle"><i class="fas fa-heading"></i> عنوان المنشور</label>
                <input type="text" id="postTitle" name="title" 
                       value="{{ old('title', $post->title ?? '') }}" 
                       placeholder="مثال: مطلوب نجار لتركيب مطابخ" required />
            </div>

            {{-- المحتوى --}}
            <div class="form-group">
                <label for="postContent"><i class="fas fa-align-left"></i> محتوى المنشور</label>
                <textarea id="postContent" name="content" rows="6" 
                          placeholder="اكتب تفاصيل طلبك أو خدمتك هنا..." required>{{ old('content', $post->content ?? '') }}</textarea>
                <span class="char-counter">0 / 500</span>
            </div>

            {{-- الموقع والسعر --}}
            <div class="form-row">
                <div class="form-group half">
                    <label for="postLocation"><i class="fas fa-map-marker-alt"></i> الموقع</label>
                    <input type="text" id="postLocation" name="location" 
                           value="{{ old('location', $post->location ?? '') }}" 
                           placeholder="المدينة، الحي" required />
                </div>
                <div class="form-group half">
                    <label for="postPrice"><i class="fas fa-money-bill-wave"></i> السعر (ر.س)</label>
                    <input type="number" id="postPrice" name="price" 
                           value="{{ old('price', $post->price ?? '') }}" 
                           placeholder="مثال: 500" required />
                </div>
            </div>

            {{-- رفع الصور --}}
            <div class="form-group">
                <label><i class="fas fa-images"></i> إضافة صور (اختياري)</label>
                <div class="upload-area" id="uploadArea">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>اسحب الصور هنا أو اضغط للاختيار</p>
                    <span>يمكنك رفع حتى 5 صور</span>
                    <input type="file" name="image[]" id="imageInput" accept="image/*" multiple />
                </div>
                <div class="image-preview-grid" id="imagePreviewGrid">
                    {{-- 
                    إذا كنت في صفحة التعديل وتريد عرض الصور القديمة هنا، 
                    يمكنك تمريرها من المتحكم وعرضها باستخدام JS أو حلقة @foreach 
                    --}}
                </div>
            </div>

            {{-- الأزرار --}}
            <div class="form-actions">
                <button type="submit" class="btn-publish" id="publishBtn">
                    <span class="btn-text">
                        <i class="fas fa-paper-plane"></i> 
                        @isset($post)
                            تحديث المنشور
                        @else
                            نشر المنشور
                        @endisset
                    </span>
                    <span class="spinner" style="display: none;"></span>
                </button>
            </div>

            <div id="formMessage" class="form-message" style="display: none;"></div>

        </form>
        

    </main>
    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
       const imageInput = document.getElementById('imageInput');
const previewGrid = document.getElementById('imagePreviewGrid');
const uploadArea = document.getElementById('uploadArea');
const MAX_IMAGES = 5;

// كائن DataTransfer لإدارة قائمة الملفات داخل الـ Input
let dt = new DataTransfer();

function updatePreviews() {
    previewGrid.innerHTML = '';
    
    Array.from(dt.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-item';
            wrapper.innerHTML = `
                <img src="${e.target.result}" alt="معاينة" />
                <button type="button" class="remove-image"><i class="fas fa-times"></i></button>
            `;
            
            // عند الضغط على زر الحذف
            wrapper.querySelector('.remove-image').addEventListener('click', function() {
                dt.items.remove(index); // حذف الملف من DataTransfer
                imageInput.files = dt.files; // تحديث input.files
                updatePreviews(); // إعادة رسم المعاينة
            });
            
            previewGrid.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

function handleFiles(newFiles) {
    const availableSlots = MAX_IMAGES - dt.files.length;
    
    if (newFiles.length > availableSlots) {
        alert('يمكنك رفع ' + availableSlots + ' صور إضافية فقط.');
    }

    const filesToAdd = Array.from(newFiles).slice(0, availableSlots);

    filesToAdd.forEach(file => {
        if (!file.type.startsWith('image/')) return;
        if (file.size > 5 * 1024 * 1024) {
            alert('حجم الصورة ' + file.name + ' يتجاوز 5 ميجابايت');
            return;
        }
        dt.items.add(file); // إضافة الملف للكائن
    });

    imageInput.files = dt.files; // ربط الملفات بـ input الحقيقي
    updatePreviews();
}

// عند اختيار ملفات عن طريق الضغط
imageInput.addEventListener('change', function(e) {
    handleFiles(e.target.files);
});

// Drag & Drop
uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = 'var(--gold)';
    this.style.background = 'rgba(253, 203, 110, 0.05)';
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.style.borderColor = 'rgba(255,255,255,0.2)';
    this.style.background = 'transparent';
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = 'rgba(255,255,255,0.2)';
    this.style.background = 'transparent';
    handleFiles(e.dataTransfer.files);
});
    </script>

</body>
</html>