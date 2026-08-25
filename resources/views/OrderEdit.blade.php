<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تعديل الطلب - مهارتي</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />
    <style>
        body { font-family: 'Tajawal', sans-serif; background: #0a0a1a; color: #fff; }
        .form-container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
        .form-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(12px); border-radius: 20px; padding: 30px; border: 1px solid rgba(255,255,255,0.1); }
        .form-card h2 { margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #444; background: #1a1a2e; color: #fff; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .btn-submit { width: 100%; padding: 14px; background: linear-gradient(135deg, #f1c40f, #f39c12); border: none; border-radius: 50px; font-weight: 700; font-size: 1.1rem; cursor: pointer; color: #000; transition: 0.3s; }
        .btn-submit:hover { transform: scale(1.02); }
        .btn-cancel { display: inline-block; margin-top: 10px; color: #aaa; text-decoration: none; }
        .btn-cancel:hover { color: #fff; }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2> <span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('home') }}" class="btn-outline"><i class="fas fa-home"></i> الرئيسية</a>
                <span style="opacity:0.8;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                <a href="{{ route('profile') }}" class="btn-outline"><i class="fas fa-user-circle"></i> ملفي</a>
            </div>
        </div>
    </header>

    <main class="form-container">
        <div class="form-card">
            <h2><i class="fas fa-edit"></i> تعديل الطلب</h2>

            <form method="POST" action="{{ route('orders.update', $order->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>عنوان الطلب <span style="color:#e74c3c;">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $order->title) }}" required />
                    @error('title') <span style="color:#e74c3c; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>الوصف</label>
                    <textarea name="description" rows="4">{{ old('description', $order->description) }}</textarea>
                    @error('description') <span style="color:#e74c3c; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>الموقع</label>
                    <input type="text" name="location" value="{{ old('location', $order->location) }}" />
                    @error('location') <span style="color:#e74c3c; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>السعر (ريال)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $order->price) }}" />
                    @error('price') <span style="color:#e74c3c; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>الحالة</label>
                    <select name="status">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                    @error('status') <span style="color:#e74c3c; font-size:0.8rem;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> حفظ التعديلات</button>
                <br />
                <a href="{{ route('profile') }}" class="btn-cancel"><i class="fas fa-arrow-right"></i> العودة إلى الملف الشخصي</a>
            </form>
        </div>
    </main>
    <footer class="guest-footer">
        <p>© 2026 <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>
</body>
</html>