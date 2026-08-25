<!doctype html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />
    <title>إدارة الطلبات - مهارتي</title>
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
            font-size: 0.9rem;
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

        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .status-badge.pending { background: #fef3c7; color: #d97706; }
        .status-badge.in_progress { background: #dbeafe; color: #1a73e8; }
        .status-badge.completed { background: #d1fae5; color: #059669; }
        .status-badge.cancelled { background: #fecaca; color: #dc2626; }

        .status-select {
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.3);
            color: #fff;
            font-size: 0.8rem;
        }

        .action-btn {
            padding: 6px 12px;
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
        .action-btn.delete { background: #e74c3c; color: #fff; }
        .action-btn.delete:hover { background: #c0392b; transform: translateY(-2px); }

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
            .admin-table { font-size: 0.75rem; }
            .admin-table th, .admin-table td { padding: 8px 4px; }
            .status-select { font-size: 0.7rem; padding: 2px 4px; }
            .action-btn { padding: 4px 8px; font-size: 0.65rem; }
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
    @endphp

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <img src="{{ asset('Logo.png') }}" alt="شعار مهارتي" class="nav-logo" />
                <h2><span>مهارتي</span></h2>
            </div>
            <div class="nav-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-chart-pie" style="color:#1a73e8;"></i> لوحة التحكم
                </a>
                <a href="{{ route('admin.users') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-users" style="color:#1a73e8;"></i> المستخدمين
                </a>
                <a href="{{ route('admin.posts') }}" class="btn-new-request" style="background:rgba(255,255,255,0.05); padding:8px 16px; border-radius:50px; text-decoration:none; color:#1a73e8; display:inline-flex; align-items:center; gap:8px; border:1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-file-alt" style="color:#1a73e8;"></i> المنشورات
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
                <h1 style="font-size: 2rem;">🛒 إدارة <span>الطلبات</span></h1>
                <p style="opacity:0.7;">متابعة وتحديث حالة الطلبات بين العملاء ومقدمي الخدمة</p>
            </div>
        </section>

        <div class="admin-section-header">
            <h2 style="color: var(--gold);"><i class="fas fa-shopping-cart"></i> قائمة الطلبات</h2>
            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                <span style="opacity:0.6;">إجمالي: {{ $orders->total() }} طلب</span>
                {{-- ===== صندوق البحث ===== --}}
                <form method="GET" action="{{ route('admin.orders') }}" class="search-box-admin">
                    <input type="text" name="search" placeholder="بحث بالعنوان، العميل، أو مقدم الخدمة..." value="{{ request('search') }}" style="color: #000" autocomplete="off" />
                    <button type="submit"><i class="fas fa-search"></i></button>
                    @if(request('search'))
                        <a href="{{ route('admin.orders') }}" class="clear-btn visible" style="color:#666; text-decoration:none; padding:8px 12px;">
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
                        <th>العنوان</th>
                        <th>العميل</th>
                        <th>مقدم الخدمة</th>
                        <th>السعر</th>
                        <th>الموقع</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td><strong>{{ $order->title }}</strong></td>
                            <td>{{ $order->user->name ?? 'غير معروف' }}</td>
                            <td>{{ $order->provider->name ?? 'غير معين' }}</td>
                            <td>{{ $order->price }} ريال</td>
                            <td>{{ $order->location }}</td>
                            <td>
                                <span class="status-badge {{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending') قيد الانتظار @break
                                        @case('in_progress') قيد التنفيذ @break
                                        @case('completed') مكتمل @break
                                        @case('cancelled') ملغي @break
                                    @endswitch
                                </span>
                            </td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                            <td>
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('PUT')
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                    </select>
                                </form>
                                <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" style="display:inline-block; margin-top:5px;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn delete" onclick="return confirm('حذف الطلب؟')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; padding:40px 0; opacity:0.6;">
                                <i class="fas fa-search" style="font-size:2rem; display:block; margin-bottom:10px;"></i>
                                لا توجد نتائج تطابق بحثك
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $orders->appends(request()->query())->links() }}
        </div>

    </main>

    <footer class="guest-footer">
        <p>© {{ date('Y') }} <span>مهارتي</span> - جميع الحقوق محفوظة</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.success-message, .error-messages').forEach(el => {
                if (el) setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.style.display = 'none', 500); }, 3000);
            });

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