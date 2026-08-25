<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />
    <title>إدارة المستخدمين - مهارتي</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" />
    <style>
        .admin-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin: 30px 0 20px;
        }

        .search-box-admin {
            display: flex;
            gap: 10px;
            align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 50px;
            padding: 5px 5px 5px 18px;
            transition: 0.3s;
        }
        .search-box-admin:focus-within {
            border-color: var(--gold, #f1c40f);
            box-shadow: 0 0 20px rgba(241,196,15,0.08);
        }
        .search-box-admin input {
            background: transparent;
            border: none;
            color: #fff;
            padding: 8px 0;
            font-size: 0.9rem;
            outline: none;
            min-width: 200px;
            font-family: inherit;
        }
        .search-box-admin input::placeholder {
            color: #666;
        }
        .search-box-admin button {
            background: var(--gold, #f1c40f);
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            transition: 0.3s;
            font-family: inherit;
        }
        .search-box-admin button:hover {
            transform: scale(1.03);
            background: #e6b800;
        }
        .search-box-admin .clear-btn {
            background: transparent;
            color: #666;
            padding: 8px 12px;
            display: none;
        }
        .search-box-admin .clear-btn.visible {
            display: inline-block;
        }
        .search-box-admin .clear-btn:hover {
            color: #fff;
        }

        .admin-table-wrapper {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(8px);
            border: 1px solid var(--glass-border, rgba(255,255,255,0.08));
            border-radius: 20px;
            padding: 20px;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .admin-table th {
            text-align: right;
            padding: 14px 12px;
            color: var(--gold, #f1c40f);
            font-weight: 700;
            border-bottom: 2px solid rgba(255,255,255,0.06);
        }

        .admin-table td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }

        .admin-table tr:hover td {
            background: rgba(255,255,255,0.02);
        }

        .badge-role {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-admin { background: #e74c3c; color: #fff; }
        .badge-provider { background: #3498db; color: #fff; }
        .badge-client { background: #2ecc71; color: #fff; }

        .action-btn {
            padding: 6px 14px;
            border-radius: 8px;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-btn:hover { transform: translateY(-2px); }
        .action-btn.role-toggle { background: #f1c40f; color: #000; }
        .action-btn.role-toggle:hover { background: #e6b800; }
        .action-btn.delete { background: #e74c3c; color: #fff; }
        .action-btn.delete:hover { background: #c0392b; }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .pagination-container nav { display: inline-block; }
        .pagination-container .page-item { display: inline-block; margin: 0 3px; }
        .pagination-container .page-link {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            color: #fff;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.06);
            transition: 0.2s;
        }
        .pagination-container .page-link:hover { background: rgba(241,196,15,0.15); border-color: var(--gold); }
        .pagination-container .active .page-link { background: var(--gold); color: #000; border-color: var(--gold); }

        @media (max-width: 768px) {
            .admin-table { font-size: 0.8rem; }
            .admin-table th, .admin-table td { padding: 10px 6px; }
            .action-btn { padding: 4px 10px; font-size: 0.7rem; }
            .admin-section-header { flex-direction: column; align-items: stretch; text-align: center; }
            .search-box-admin { justify-content: center; }
            .search-box-admin input { min-width: 120px; width: 100%; }
        }
    </style>
</head>

<body>

    @if (session('success'))
        <div class="success-message"><ul class="error-list"><li>{{ session('success') }}</li></ul></div>
    @endif
    @if (session('error'))
        <div class="error-messages"><ul class="error-list"><li>{{ session('error') }}</li></ul></div>
    @endif

    @php
        $avatarUrl = asset('Logo.png');
        if (Auth::check() && Auth::user()->profile && Auth::user()->profile->image) {
            $images = json_decode(Auth::user()->profile->image, true);
            $first = is_array($images) ? $images[0] ?? null : null;
            if ($first) $avatarUrl = Storage::url($first) . '?v=' . (Auth::user()->profile->updated_at->timestamp ?? time());
        }
        $adminCount = \App\Models\User::where('role', 'admin')->count();
    @endphp

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2><span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-chart-pie" style="color: #1a73e8;"></i> لوحة التحكم
                </a>
                <a href="{{ route('admin.posts') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-file-alt" style="color: #1a73e8;"></i> المنشورات
                </a>
                <a href="{{ route('admin.orders') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-shopping-cart" style="color: #1a73e8;"></i> الطلبات
                </a>
                <span style="opacity:0.8;"><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                <a href="{{ route('profile') }}"><img src="{{ $avatarUrl }}" alt="صورة" class="user-avatar" /></a>
                <a href="{{ route('login') }}" class="btn-outline logout-btn">
                    <i class="fas fa-sign-out-alt"></i> خروج
                </a>
            </div>
        </div>
    </header>

    <main class="main-content">

        <section class="hero-section" style="padding: 30px 20px;">
            <div class="hero-glass-card" style="padding: 25px 30px;">
                <h1 style="font-size: 2rem;">👥 إدارة <span>المستخدمين</span></h1>
                <p style="opacity:0.7;">عرض، تعديل الأدوار، وحذف المستخدمين في المنصة</p>
            </div>
        </section>

        <div class="admin-section-header">
            <h2 style="color: var(--gold);"><i class="fas fa-users"></i> قائمة المستخدمين</h2>
            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                <span style="opacity:0.6;">إجمالي: {{ $users->total() }} مستخدم</span>
                {{-- ===== صندوق البحث ===== --}}
                <form method="GET" action="{{ route('admin.users') }}" class="search-box-admin">
                    <input type="text" name="search" placeholder="بحث بالاسم، البريد، أو اسم المستخدم..." value="{{ request('search') }}" style="color: #000" autocomplete="off" />
                    <button type="submit"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.users') }}" class="clear-btn visible" style="color:#666; text-decoration:none; padding:8px 12px;">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>اسم المستخدم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الدور</th>
                        <th>تاريخ الانضمام</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge-role badge-{{ $user->role }}">
                                    {{ $user->role == 'admin' ? 'مدير' : ($user->role == 'provider' ? 'مقدم خدمة' : 'عميل') }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if(!$user->isAdmin() || ($user->isAdmin() && $adminCount > 1))
                                    <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="action-btn role-toggle" title="تبديل الدور">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                @endif
                                @if(!$user->isAdmin() || ($user->isAdmin() && $adminCount > 1))
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('حذف المستخدم نهائياً؟')" title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:40px 0; opacity:0.6;">
                                <i class="fas fa-search" style="font-size:2rem; display:block; margin-bottom:10px;"></i>
                                لا توجد نتائج تطابق بحثك
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $users->appends(request()->query())->links() }}
        </div>

    </main>

    <footer class="guest-footer">
        <p>© {{ date('Y') }} <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.success-message, .error-messages').forEach(el => {
                if (el) {
                    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.style.display = 'none', 500); }, 3000);
                }
            });

            // إظهار/إخفاء زر المسح
            const searchInput = document.querySelector('.search-box-admin input');
            const clearBtn = document.querySelector('.clear-btn');
            if (searchInput && clearBtn) {
                searchInput.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        clearBtn.classList.add('visible');
                    } else {
                        clearBtn.classList.remove('visible');
                    }
                });
            }
        });
    </script>

</body>
</html>