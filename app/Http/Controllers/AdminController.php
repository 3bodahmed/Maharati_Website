<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Order;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // عرض لوحة التحكم الرئيسية
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentUsers = User::latest()->take(5)->get();
        $recentPosts = Post::with('user')->latest()->take(5)->get();

        $posts = Post::with('user.profile')->latest()->get(); 
        return view('admin_dashboard', compact('totalUsers', 'totalPosts', 'totalOrders', 'pendingOrders', 'recentUsers', 'recentPosts', 'posts'));
    }

  
   

    public function toggleUserRole($userId)
    {
        $user = User::findOrFail($userId);

        $roles = ['client', 'admin'];
        $currentIndex = array_search($user->role, $roles);
        $nextIndex = ($currentIndex + 1) % count($roles);
        $user->role = $roles[$nextIndex];
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير دور المستخدم بنجاح');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->back()->with('error', 'لا يمكن حذف آخر مدير في النظام');
        }
        $user->delete();
        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح');
    }

    // إدارة المستخدمين مع البحث
public function users(Request $request)
{
    $query = User::with('profile');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $users = $query->latest()->paginate(20);
    return view('admin_users', compact('users'));
}

// إدارة المنشورات مع البحث
public function posts(Request $request)
{
    $query = Post::with('user');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    $posts = $query->latest()->paginate(20);
    return view('admin_posts', compact('posts'));
}

// إدارة الطلبات مع البحث
public function orders(Request $request)
{
    $query = Order::with(['user', 'provider']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhereHas('user', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('provider', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

    $orders = $query->latest()->paginate(20);
    return view('admin_orders', compact('orders'));
}

    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->delete();
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح');
    }
}