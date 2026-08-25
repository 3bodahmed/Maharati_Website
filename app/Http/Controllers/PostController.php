<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    // عرض صفحة إنشاء منشور جديد
    public function ShowCreatePost(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $imageUrl = $profile && $profile->image
            ? asset('storage/' . json_decode($profile->image, true)[0])
            : 'https://i.pravatar.cc/50?img=' . $user->id;

        return view('CreatePost', compact('imageUrl'));
    }

    

public function createPost(Request $request)
{
    $validator = Validator::make($request->all(), [
        'postType' => ['required', 'in:client,provider'],
        'title'    => ['required', 'string', 'max:255'],
        'content'  => ['required', 'string', 'max:5000'],
        'location' => ['required', 'string', 'max:255'],
        'price'    => ['nullable', 'numeric', 'min:0'],
        'image'    => ['nullable', 'array', 'max:5'],
        'image.*'  => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $imagePaths = [];
    if ($request->hasFile('image')) {
        foreach ($request->file('image') as $image) {
            // تخزين الصورة في مجلد posts (يمكنك تغيير 'posts' إلى ما تريد)
            $path = $image->store('posts', 'public');
            $imagePaths[] = $path;
        }
    }

    // إنشاء المنشور
    $post = Post::create([
        'typeRequest' => $request->postType,
        'title'       => $request->title,
        'content'     => $request->content,
        'location'    => $request->location,
        'price'       => $request->price,
        'image'       => !empty($imagePaths) ? json_encode($imagePaths) : null,
        'user_id'     => Auth::id(),
    ]);

    return redirect()->back()->with('success', 'تم إنشاء المنشور بنجاح');
}

    // حذف منشور
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذا المنشور');
        }

        $post->delete();
        return redirect()->route('profile')->with('success', 'تم حذف المنشور بنجاح');
    }

    // عرض صفحة تعديل منشور
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا المنشور');
        }

        $user = Auth::user();
        $profile = $user->profile;
        // تم حذف السطر الزائد (الذي يعطي قيمة boolean)
        $imageUrl = $profile && $profile->image
            ? asset('storage/' . json_decode($profile->image, true)[0])
            : 'https://i.pravatar.cc/50?img=' . $user->id;

        return view('CreatePost', compact('post', 'imageUrl'));
    }

    // تحديث منشور
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب');
        }

        $validator = Validator::make($request->all(), [
            'postType' => ['required', 'in:client,provider'],
            'title'    => ['required', 'string', 'max:255'],
            'content'  => ['required', 'string', 'max:5000'],
            'location' => ['required', 'string', 'max:255'],
            'price'    => ['nullable', 'numeric', 'min:0'],
            'image'    => ['nullable', 'array', 'max:5'],
            'image.*'  => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // معالجة الصور الجديدة (اختياري: حذف القديمة إذا رفع صور جديدة)
        $imagePaths = [];
        if ($request->hasFile('image')) {
            // حذف الصور القديمة من التخزين (اختياري)
            if ($post->image) {
                $oldImages = json_decode($post->image, true);
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImage) {
                        \Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            // رفع الصور الجديدة
            foreach ($request->file('image') as $image) {
                $path = $image->store('posts', 'public');
                $imagePaths[] = $path;
            }
        }

        // إعداد بيانات التحديث
        $data = $validator->validated(); // 🔥 الحل المطلوب

        // إضافة مسارات الصور إذا وجدت
        if (!empty($imagePaths)) {
            $data['image'] = json_encode($imagePaths);
        } else {
            // إذا لم يتم رفع صور جديدة، نحتفظ بالصور القديمة (أو نضع null إذا أردنا مسحها)
            // هنا نتركها كما هي (لا نغيرها)
            unset($data['image']); // لا نعدل حقل الصورة
        }

        // تحديث النموذج بالمصفوفة الصحيحة
        $post->update($data); // ✅ أصبح يستقبل مصفوفة وليس Validator

        return redirect()->route('profile')->with('success', 'تم تحديث المنشور بنجاح');
    }
}   