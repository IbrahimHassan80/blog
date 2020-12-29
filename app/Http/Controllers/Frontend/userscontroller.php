<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\categorie;
use App\models\Comment;
use App\models\Post;
use App\models\PostMedia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
use App\Http\Requests\edit_info_user_request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class userscontroller extends Controller
{
    public function __construct()
    {
            $this->middleware(['auth','verified']);
    } 
    public function index(){
        $posts = auth()->user()->posts()->with(['media', 'user', 'category'])
        ->withCount('comments')->orderBy('id', 'desc')->paginate(10);
        
        return view('frontend.users.dashboard', compact('posts'));
    }

  public function create_post(){
    $categories = categorie::whereStatus(1)->pluck('name', 'id');  
    return view('frontend.users.create-post', compact('categories'));
  }  


  public function store_post(Request $request){
    $validator = Validator::make($request->all(),[
      'title'        => 'required',
      'description'  => 'required|min:50',
      'category_id'  => 'required',
      'status'       => 'required',
      'comment_able' => 'required',
    ]);
      if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      $data['title']          = Purify::clean($request->title);
      $data['description']    = Purify::clean($request->description);
      $data['category_id']    = $request->category_id;
      $data['status']         = $request->status;
      $data['comment_able']   = $request->comment_able;
      $post = auth()->user()->posts()->create($data);
      
      if($request->images && count($request->images) > 0){
        $i = 1;
        foreach($request->images as $file){
          $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
          $file_size = $file->getSize();
          $file_type = $file->getMimeType();
          $path = public_path('assets/posts/'.$filename);
          Image::make($file->getRealPath())->resize(800, null, function($constraint) {
            $constraint->aspectRatio();
          })->save($path, 100);
          $post->media()->create([
            'file_name' => $filename,
            'file_type' => $file_type,
            'file_size' => $file_size,
          ]);
            $i++;
        }
      
      }
      if($request->status ==1){
        Cache::forget('recent_posts');
      }
      return redirect()->back()->with([
        'message'    =>  'post created Successfully',
        'alert-type' => 'success',
      ]);
    }

    public function edit_post($post_id){
      $post = Post::whereId($post_id)->orWhere('slug', $post_id)->whereUserId(auth()->id())->first();
      if($post){
        $categories = categorie::whereStatus(1)->pluck('name', 'id');  
        return view('frontend.users.edit-post', compact('categories','post'));
      }
      return redirect()->route('frontend.index');
    }

    public function update_post(Request $request, $post_id){
      $validator = Validator::make($request->all(),[
        'title'        => 'required',
        'description'  => 'required|min:50',
        'category_id'  => 'required',
        'status'       => 'required',
        'comment_able' => 'required',
      ]);
        if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = post::whereId($post_id)->orWhere('slug', $post_id)->whereUserId(auth()->id())->first();   
        if($post){
        $data['title']          = Purify::clean($request->title);
        $data['description']    = Purify::clean($request->description);
        $data['category_id']    = $request->category_id;
        $data['status']         = $request->status;
        $data['comment_able']   = $request->comment_able;
        $post->update($data);
        
        if($request->images && count($request->images) > 0){
          $i = 1;
          foreach($request->images as $file){
            $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
            $file_size = $file->getSize();
            $file_type = $file->getMimeType();
            $path = public_path('assets/posts/'.$filename);
            Image::make($file->getRealPath())->resize(800, null, function($constraint) {
              $constraint->aspectRatio();
            })->save($path, 100);
            $post->media()->create([
              'file_name' => $filename,
              'file_type' => $file_type,
              'file_size' => $file_size,
            ]);
              $i++;
          }
        }
        return redirect()->back()->with([
          'message'    =>  'post Updated Successfully',
          'alert-type' => 'success',
        ]);
      }
      return redirect()->back()->with([
          'message'    =>  'something Was wrong',
          'alert-type' => 'danger',
      ]);  
    }
    
  public function post_destroy($post_id){
    $post = post::whereId($post_id)->orWhere('slug', $post_id)->whereUserId(auth()->id())->first();
    if($post){
       if($post->media->count() > 0){
         foreach($post->media as $media){
           if(File::exists("assets/posts/". $media->file_name)){
             unlink("assets/posts/". $media->file_name);
           }
         }
       }
    $post->delete();
    return redirect()->back()->with([
      'message'    =>  'post Deleted Successfully',
      'alert-type' => 'danger',
    ]);
      }
      return redirect()->back()->with([
        'message'    =>  'something Was wrong',
        'alert-type' => 'success',
      ]);
    }

    public function destroy_post_media($media_id){
      $media = PostMedia::whereId($media_id)->first();

      if($media){
        if(File::exists('assets/posts/'.$media->file_name)){
          unlink('assets/posts/'.$media->file_name);
        }
        $media->delete();
        return true;
      }
      return false;
    }
    
    // comments //
    public function show_comments(){
      $posts_id = auth()->user()->posts()->pluck('id')->toArray();
      $comments = Comment::whereIn('post_id', $posts_id)->paginate(10);
      return view('frontend.users.comments', compact('comments'));
    }
  
  public function edit_comments($comment_id){
    $comment = Comment::whereId($comment_id)->whereHas('post', function($query){
      $query->where('posts.user_id', auth()->id());
    })->first();
    if($comment){
      return view('frontend.users.edit_comments', compact('comment'));
    } else {
      return redirect()->back()->with([
        'message'    =>  'something Was wrong',
        'alert-type' => 'danger',
      ]);
    }
  }
  
  public function update_comments(Request $request, $comment_id){
    $validator = Validator::make($request->all(),[
      'name' => 'required',
      'email' => 'required|email',
      'url' => 'url|nullable',
      'comment' => 'required|min:10',
      'status'  => 'required' 
    ]);
      if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }
      $comment = comment::whereId($comment_id)->whereHas('post', function($query){
        $query->where('posts.user_id', auth()->id());
      })->first();
      if($comment){
        $data['name']    =   $request->name;
        $data['email']   =   $request->email;
        $data['url']     =   $request->url != ''? $request->url : null;
        $data['comment'] =   Purify::clean($request->comment);
        $data['status']  =   $request->status;
        $comment->update($data);
        if($request->status == 1){
          Cache::forget('recent_comments');
        }
        return redirect()->route('users.comments')->with([
          'message'    =>  'comment Updated Successfully',
          'alert-type' => 'success',
        ]);
      
      } else {
        return redirect()->back()->with([
          'message'    =>  'something Was wrong',
          'alert-type' => 'danger',
        ]);
      }
    }

    public function delete_comments($comment_id){
      $comment = comment::whereId($comment_id)->whereHas('post', function($query){
        $query->where('posts.user_id', auth()->id());
      })->first();
      if($comment){
        $comment->delete();
        Cache::forget('recent_comments');
        return redirect()->back()->with([
          'message'    =>  'comment deleted Successfully',
          'alert-type' => 'danger',
        ]);
      } else{
        return redirect()->back()->with([
          'message'    =>  'Some Thing Was Wrong',
          'alert-type' => 'danger',
        ]);
      }
    }
  
    public function edit_info(){
      return view('frontend.users.edit_info');
    }
  
    public function update_info(edit_info_user_request $request){
        // validate in request file //
        $data['name']          = $request->name;
        $data['email']         = $request->email;
        $data['mobile']        = $request->mobile;
        $data['bio']           = $request->bio;
        $data['receive_email'] = $request->receive_email;
        
        if($image = $request->file('user_image')){
          if(auth()->user()->user_image != ''){
            if(File::exists('/assets/users/'. auth()->user()->user_image)){
              unlink('/assets/users/'. auth()->user()->user_image);
            }
          }
          $file_name = str::slug(auth()->user()->username) . '.' . $image->getClientOriginalExtension();
          $path = public_path('assets/users/' . $file_name);
          Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
          })->save($path, 100);
          
          $data['user_image'] = $file_name;       
        }
        $update = auth()->user()->update($data);
        if($update){
          return redirect()->route('frontend.dashboard')->with([
            'message'    =>  'info Updated Successfully',
            'alert-type' => 'success',
          ]);  
        }else {
          return redirect()->back()->with([
            'message'    =>  'Some Thing Was Wrong',
            'alert-type' => 'danger',
          ]);
        } 
      }

      public function update_password(Request $request){
        $validate = Validator::make($request->all(),[
          'current_password' => 'required', 
          'password' => 'required|confirmed', 
        ]);
          if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
          }
          $user = auth()->user();
          if(Hash::check($request->current_password, $user->password)){
            $update = $user->update([
              'password' => bcrypt($request->password)]);
              if($update){
                return redirect()->route('frontend.dashboard')->with([
                  'message'    =>  'password Updated Successfully',
                  'alert-type' => 'success',
                ]);  
              } else {
                return redirect()->back()->with([
                  'message'    =>  'Some Thing Was Wrong',
                  'alert-type' => 'danger',
                ]);
              }
            } else {
              return redirect()->back()->with([
                'message'    =>  'Some Thing Was Wrong',
                'alert-type' => 'danger',
              ]);
            }
          
        }
}