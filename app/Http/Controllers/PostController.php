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
  
    public function ShowCreatePost(Request $request){
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('posts', 'public');
                $imagePaths[] = $path;
            }
        }

        $post = Post::create([
            'typeRequest' => $request->postType,
            'title'       => $request->title,
            'content'     => $request->content,
            'location'    => $request->location,
            'price'       => $request->price,
            'image'       => !empty($imagePaths) ? json_encode($imagePaths) : null, 
            'user_id'     => Auth::id(),
        ]);

        return redirect()->back()->with('success');
    }

}
