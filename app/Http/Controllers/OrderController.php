<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * عرض نموذج إنشاء طلب جديد
     */
  public function create(Request $request)
{
    // جلب المنشور إن وجد، أو إرجاع null تلقائياً دون استثناء أخطاء
    $post = $request->filled('post_id') 
        ? Post::with('user')->find($request->post_id) 
        : null;

    // استخراج معرف مقدم الخدمة من المنشور أو من الطلب المباشر
    $providerId = $request->input('provider_id') ?? $post?->user_id;

    return view('OrderCreate', compact('post', 'providerId'));
}
    /**
     * حفظ الطلب الجديد
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'location'    => 'nullable|string|max:255',
        'price'       => 'nullable|numeric|min:0',
        'post_id'     => 'nullable|exists:post,id',
        'provider_id' => 'nullable|exists:users,id',
    ]);

    $post = null;
    $provider_id = $validated['provider_id'] ?? null;

    if ($request->filled('post_id')) {
        $post = Post::find($request->post_id);
        if ($post) {
          
            if ($post->typeRequest === 'provider') {
                $provider_id = $post->user_id;
            }

        }
    }

    Order::create([
        'user_id'     => Auth::id(),
        'post_id'     => $validated['post_id'] ?? null,
        'provider_id' => $provider_id,
        'title'       => $validated['title'],
        'description' => $validated['description'],
        'location'    => $validated['location'],
        'price'       => $validated['price'],
        'status'      => 'pending',
    ]);

    return redirect()->route('profile')->with('success', 'تم إنشاء الطلب بنجاح');
}

   
    public function edit(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب');
        }
        return view('OrderEdit', compact('order'));
    }

    /**
     * تحديث الطلب
     */
public function update(Request $request, Order $order)
{
    // تأكد من أن المستخدم إما صاحب الطلب أو مقدم الخدمة
    if ($order->user_id !== Auth::id() && $order->provider_id !== Auth::id()) {
        abort(403, 'غير مصرح لك بتعديل هذا الطلب');
    }

    $validated = $request->validate([
        'title'       => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'location'    => 'nullable|string|max:255',
        'price'       => 'nullable|numeric|min:0',
        'status'      => 'nullable|in:pending,in_progress,completed,cancelled',
    ]);

    $order->update($validated);

    return redirect()->route('profile')->with('success', 'تم تحديث الطلب بنجاح');
}
    /**
     * حذف الطلب
     */
    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذا الطلب');
        }

        $order->delete();
        return redirect()->route('profile')->with('success', 'تم حذف الطلب بنجاح');
    }

    /**
     * عرض قائمة الطلبات (اختياري)
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * عرض تفاصيل طلب معين (اختياري)
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && $order->provider_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بمشاهدة هذا الطلب');
        }
        return view('orders.show', compact('order'));
    }
}