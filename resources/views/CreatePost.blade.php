<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CreatePost.css" /> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />     
    <title>إنشاء منشور - مهارتي</title>
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
            <h1 class="error-title">تم إنشاء المنشور بنجاح</h1>
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
                <a href="{{ route('home') }}" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <span style="opacity:0.8; margin:0 5px;"><i class="fas fa-user"></i> {{ Auth::User()->name }}  </span>
                <a href="{{ route('profile') }}"><img src="{{ $imageUrl }}" alt="صورة" class="user-avatar" /></a>
                <a href="/register" class="btn-outline" onclick="return confirm('تسجيل الخروج؟');"><i class="fas fa-sign-out-alt"></i> خروج</a>
            </div>
        </div>
    </header>

    <main class="create-container">

        <div class="create-header">
            <h1><i class="fas fa-pen-fancy"></i> إنشاء <span>منشور جديد</span></h1>
            <a href="/home" class="btn-cancel"><i class="fas fa-arrow-right"></i> إلغاء</a>
        </div>

        <form id="createPostForm" method="POST" action="{{ route('posts.store') }}" class="create-form" enctype="multipart/form-data">
            @csrf

            <div class="user-info-bar">
                <img src="{{ $imageUrl }}" alt="صورة" class="user-avatar-lg" />
                <div>
                    <h4>{{ Auth::user()->name }}</h4>
        
                </div>
            </div>
           
            <div class="form-group">
                <label><i class="fas fa-tag"></i> نوع المنشور</label>
                <div class="post-type-selector">
                    <label class="type-option">
                        <input type="radio" name="postType" value="client" checked />
                        <span><i class="fas fa-user-plus"></i> طلب خدمة</span>
                    </label>
                    <label class="type-option">
                        <input type="radio" name="postType" value="provider" />
                        <span><i class="fas fa-briefcase"></i> عرض خدمة</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="postTitle"><i class="fas fa-heading"></i> عنوان المنشور</label>
                <input type="text" id="postTitle" name="title" placeholder="مثال: مطلوب نجار لتركيب مطابخ" required />
            </div>

            <div class="form-group">
                <label for="postContent"><i class="fas fa-align-left"></i> محتوى المنشور</label>
                <textarea id="postContent" rows="6" placeholder="اكتب تفاصيل طلبك أو خدمتك هنا..." name="content" required></textarea>
                <span class="char-counter">0 / 500</span>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="postLocation"><i class="fas fa-map-marker-alt"></i> الموقع</label>
                    <input type="text" id="postLocation" name="location" placeholder="المدينة، الحي"     required />
                </div>
                <div class="form-group half">
                    <label for="postPrice"><i class="fas fa-money-bill-wave"></i> السعر (ر.س)</label>
                    <input type="number" id="postPrice" name="price" placeholder="مثال: 500" required />
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-images"></i> إضافة صور (اختياري)</label>
                <div class="upload-area" id="uploadArea">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>اسحب الصور هنا أو اضغط للاختيار</p>
                    <span>يمكنك رفع حتى 5 صور</span>
                    <input type="file" name="image[]" id="imageInput" accept="image/*" multiple />
                </div>
                <div class="image-preview-grid" id="imagePreviewGrid">
                    <!-- سيتم عرض معاينة الصور هنا -->
                </div>
            </div>

            <div class="form-actions">
                <button type="reset" class="btn-reset"><i class="fas fa-undo"></i> مسح الكل</button>
                <button type="submit" class="btn-publish" id="publishBtn">
                    <span class="btn-text"><i class="fas fa-paper-plane"></i> نشر المنشور</span>
                    <span class="spinner" style="display: none;"></span>
                </button>
            </div>

            <div id="formMessage" class="form-message" style="display: none;"></div>

        </form>

    </main>


    <script>
       
        const contentInput = document.getElementById('postContent');
        const charCounter = document.querySelector('.char-counter');

        contentInput.addEventListener('input', function() {
            const count = this.value.length;
            charCounter.textContent = count + ' / 500';
            if (count > 500) {
                charCounter.style.color = '#ff4757';
                this.value = this.value.substring(0, 500);
                charCounter.textContent = '500 / 500';
            } else {
                charCounter.style.color = 'rgba(255,255,255,0.6)';
            }
        });

        const imageInput = document.getElementById('imageInput');
        const previewGrid = document.getElementById('imagePreviewGrid');
        const uploadArea = document.getElementById('uploadArea');
        const MAX_IMAGES = 5;

        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            // منع تجاوز الحد الأقصى
            const remaining = MAX_IMAGES - previewGrid.children.length;
            if (files.length > remaining) {
                alert('يمكنك رفع ' + remaining + ' صور إضافية فقط.');
                return;
            }

            files.forEach(file => {
                if (file.size > 5 * 1024 * 1024) {
                    alert('حجم الصورة ' + file.name + ' يتجاوز 5 ميجابايت');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-item';
                    wrapper.innerHTML = `
                        <img src="${e.target.result}" alt="معاينة" />
                        <button type="button" class="remove-image"><i class="fas fa-times"></i></button>
                    `;
                    wrapper.querySelector('.remove-image').addEventListener('click', function() {
                        wrapper.remove();
                        // إعادة تعيين الـ input إذا أصبح فارغاً
                        if (previewGrid.children.length === 0) {
                            imageInput.value = '';
                        }
                    });
                    previewGrid.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
            // إعادة تعيين الـ input للسماح برفع المزيد
            this.value = '';
        });

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
            const files = Array.from(e.dataTransfer.files);
            const remaining = MAX_IMAGES - previewGrid.children.length;
            const validFiles = files.filter(f => f.type.startsWith('image/'));
            if (validFiles.length > remaining) {
                alert('يمكنك رفع ' + remaining + ' صور إضافية فقط.');
                return;
            }
            validFiles.forEach(file => {
                if (file.size > 5 * 1024 * 1024) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-item';
                    wrapper.innerHTML = `
                        <img src="${e.target.result}" alt="معاينة" />
                        <button type="button" class="remove-image"><i class="fas fa-times"></i></button>
                    `;
                    wrapper.querySelector('.remove-image').addEventListener('click', function() {
                        wrapper.remove();
                    });
                    previewGrid.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

    
        document.querySelector('.btn-reset').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من مسح كل المحتوى؟')) {
                document.getElementById('postTitle').value = '';
                document.getElementById('postContent').value = '';
                document.getElementById('postLocation').value = 'الرياض';
                document.getElementById('postPrice').value = '';
                previewGrid.innerHTML = '';
                imageInput.value = '';
                charCounter.textContent = '0 / 500';
                document.getElementById('formMessage').style.display = 'none';
                // إعادة تعيين نوع المنشور إلى "طلب خدمة"
                document.querySelector('input[name="postType"][value="client"]').checked = true;
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