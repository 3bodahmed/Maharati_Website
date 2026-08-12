<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;   
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Storage;  
use App\Models\User; 
use App\Models\profile;   
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
    public function showProfile()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', Auth::id())->latest()->get();
        $profile = profile::where('user_id', $user->id)->first();
        return view('profile', compact('profile', 'posts'));
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
            'fullName'   => ['required', 'string', 'max:255'],
            'jobTitle'   => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'bio'        => ['nullable', 'string', 'max:255'],
            'price'      => ['nullable', 'string', 'max:255'],
            'location'   => ['nullable', 'string', 'max:255'],
            'about'      => ['nullable', 'string', 'max:255'],
            'image'      => ['nullable', 'array', 'max:5'],
            'image.*'    => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
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

        // تجهيز بيانات التحديث
        $data = [
            'name'        => $request->fullName,
            'jobs'        => $request->jobTitle,
            'experience'  => (int) $request->experience,
            'bio'         => $request->bio,
            'price'       => $request->price,
            'location'    => $request->location,
            'Description' => $request->about,
            'image'       => $imagePaths, 
        ];

        // تحديث اسم المستخدم إذا تغير
        $user = Auth::user();
        if ($user && $user->name !== $request->fullName) {
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




}
