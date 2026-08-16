<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Storage;  
use App\Models\User; 
use App\Models\profile; 
use App\Models\Order;    
use App\Models\Post; 

class ClientController extends Controller
{


    public function ShowVisitorHome()
    {
        
        $posts = Post::with('user.profile')->latest()->get();

        return view('HomeVisetor',compact('posts'));
    }

    public function getPost()
    {
        $user = Auth::user();
        $profile = $user->profile; // استخدم العلاقة مباشرة

        // تحميل user + profile معاً
        $posts = Post::with('user.profile')->latest()->get();

        $imageUrl = $profile && $profile->image 
            ? asset('storage/' . json_decode($profile->image, true)[0]) 
            : 'https://i.pravatar.cc/50?img=' . $user->id;

        return view('HomeClient', compact('posts', 'profile', 'imageUrl'));
    }

    public function EditProfile()
    {
        $user = Auth::user();
        $profile = profile::where('user_id', $user->id)->first();
        

        return view('EditProfile', compact('profile'));
    }
    public function CreateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName'   => ['nullable', 'string', 'max:255'],
            'jobTitle'   => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'bio'        => ['nullable', 'string', 'max:255'],
            'price'      => ['nullable', 'string', 'max:255'],
            'location'   => ['nullable', 'string', 'max:255'],
            'about'      => ['nullable', 'string', 'max:255'],
            'image'      => ['nullable', 'array', 'max:5'],
            'image.*'    => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'works'      => ['nullable', 'array', 'max:10'], // حد أقصى 10 صور للأعمال
            'works.*'    => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profile = profile::where('user_id', Auth::id())->first();

        if ($request->hasFile('image')) {
            if ($profile && $profile->image) {
                $oldImages = json_decode($profile->image, true);
                if (is_array($oldImages)) {
                    foreach ($oldImages as $oldImage) {
                        // حذف الملف القديم من مجلد public/profile
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                }
            }

            // 2. حفظ الصور الجديدة
            $newPaths = [];
            foreach ($request->file('image') as $image) {
                $path = $image->store('profile', 'public');
                $newPaths[] = $path;
            }
            $imagePaths = json_encode($newPaths);
        } else {
            $imagePaths = $profile ? $profile->image : null;
        }

         // ------------------- معالجة صور الأعمال (works) -------------------
        // معالجة صور الأعمال (works) - إضافة فوق القديم
        if ($request->hasFile('works')) {
            // جلب الصور القديمة إن وجدت
            $oldWorks = $profile && $profile->works ? json_decode($profile->works, true) : [];
            $oldWorks = is_array($oldWorks) ? $oldWorks : [];

            // حفظ الصور الجديدة
            $newWorks = [];
            foreach ($request->file('works') as $workImage) {
                $path = $workImage->store('works', 'public');
                $newWorks[] = $path;
            }

            // دمج القديم والجديد (مع تجنب التكرار إن أردت)
            $allWorks = array_merge($oldWorks, $newWorks);
            $worksPaths = json_encode($allWorks);
        } else {
            // إذا لم يتم رفع صور جديدة، احتفظ بالصور القديمة
            $worksPaths = $profile ? $profile->works : null;
        }

        // تجهيز بيانات التحديث
        $data = [
            'name' => $request->filled('fullName') ? $request->fullName : Auth::user()->name,
            'jobs'        => $request->jobTitle,
            'experience'  => (int) $request->experience,
            'bio'         => $request->bio,
            'price'       => $request->price,
            'location'    => $request->location,
            'Description' => $request->about,
            'image'       => $imagePaths, 
             'works'       => $worksPaths,
            
        ];

        // تحديث اسم المستخدم إذا تغير
        $user = Auth::user();
        if ($request->filled('fullName') && $user->name !== $request->fullName) {
            $user->name = $request->fullName;
            $user->save();
        }


        // إنشاء أو تحديث البروفايل
        $profile = profile::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        $message = $profile->wasRecentlyCreated ? 'تم إنشاء البروفايل بنجاح' : 'تم تحديث البروفايل بنجاح';
        return redirect()->back()->with('success', $message);
    }
    public function deleteWorkImage(Request $request)
{
    $request->validate([
        'image' => 'required|string',
    ]);

    $profile = Profile::where('user_id', Auth::id())->firstOrFail();
    $works = json_decode($profile->works, true) ?? [];

    // البحث عن الصورة وحذفها من المصفوفة
    $index = array_search($request->image, $works);
    if ($index !== false) {
        // حذف الملف الفعلي من التخزين
        if (Storage::disk('public')->exists($request->image)) {
            Storage::disk('public')->delete($request->image);
        }
        // إزالة من المصفوفة
        unset($works[$index]);
        $profile->works = json_encode(array_values($works));
        $profile->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'الصورة غير موجودة']);
}

public function showProfile()
{
    $user = Auth::user();
    $posts = Post::where('user_id', $user->id)->latest()->get();
    $profile = Profile::where('user_id', $user->id)->first();

    // الطلبات التي أرسلها المستخدم
    $orders = Order::with('provider')
        ->where('user_id', $user->id)
        ->latest()
        ->get();

    // الطلبات الواردة للمستخدم كمقدم خدمة
    $receivedOrders = Order::with('user')
        ->where('provider_id', $user->id)
        ->latest()
        ->get();

    $isOwner = true;

    return view('profile', compact('profile', 'posts', 'orders', 'receivedOrders', 'isOwner', 'user'));
}

public function showPublicProfile($userId)
{
    $user = User::with('profile')->findOrFail($userId);
    $posts = Post::where('user_id', $userId)->latest()->get();
    $profile = $user->profile;
    $isOwner = (Auth::check() && Auth::id() == $userId);

    // تمرير متغيرات فارغة لضمان عدم حدوث خطأ في Blade
    $orders = collect();
    $receivedOrders = collect();

    return view('profile', compact('user', 'profile', 'posts', 'orders', 'receivedOrders', 'isOwner'));
}



}
