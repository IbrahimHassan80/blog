<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use App\Models\Contact;
use App\Models\categorie;
use App\Http\Requests\validate_comment;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\valid_contactus;
use App\Models\User;

class indexcontroller extends Controller
{
    public function index(){
        $posts = post::with(['user', 'media'])->whereHas('category', function($query){
            $query->whereStatus(1);
        })->whereHas('user', function($query){
            $query->whereStatus(1);
        })->Posttype()->active()->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));
    }
    
    public function search(Request $request){
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;
        
        $posts = post::with(['user', 'media'])->whereHas('category', function($query){
            $query->whereStatus(1);
        })->whereHas('user', function($query){
            $query->whereStatus(1);
        });
        
        if($keyword != null){
            $posts = $posts->search($keyword, null, true);
        }
        $posts = $posts->Posttype()->active()->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));    
    }
        
    
    public function page_show($slug){
        
        $post = post::with(['user', 'media']);
        $post = $post->whereSlug($slug);
        $post = $post->wherePostType('post')->whereStatus(1)->first();
        
        if($post){
            return view('frontend.show_page', compact('post'));
        } else{
           return redirect()->route('frontend.index');
        }
    }
    
    public function post_show($slug){
        $post = post::with(['category', 'user', 'media',
        'approved_comments' => function($query){
            $query->orderBy('id','desc');}]);
        
        $post = $post->whereHas('category', function($query){
            $query->whereStatus(1);
        })->whereHas('user', function($query){
            $query->whereStatus(1);
        });

        $post = $post->whereSlug($slug);
        $post = $post->wherePostType('post')->whereStatus(1)->first();
        
        if($post){
            return view('frontend.show_post', compact('post'));
        } else{
            return redirect()->route('frontend.index');
        }
    }

    public function store_comment(validate_comment $request, $slug){
        // validate in request file //
        $post = post::whereSlug($slug)->wherePostType('post')->whereStatus(1)->first();
        
        if($post){
        $user_id = auth()->check() ? auth()->id() : null;
        
        $data['name']             = $request->name;
        $data['email']            = $request->email;
        $data['url']              = $request->url;
        $data['ip_address']       = $request->ip();
        $data['comment' ]         = $request->comment;
        $data['post_id' ]         = $post->id;
        $data['user_id' ]         = $user_id;
        $data['status' ]          = 1;
        
        $post->comments()->create($data);
        return redirect()->back()->with([
            'message'    => 'comment added succesfully',
            'alert-type' => 'success'
        ]);    
    }
    }

    public function contact_us(){
        return view('frontend.contact_us');
    }

    public function do_contactus(valid_contactus $request){
            ////
     
        $data['name']             = $request->name;
        $data['email']            = $request->email; 
        $data['mobile']           = $request->mobile; 
        $data['title']            = $request->title; 
        $data['message']          = $request->message; 
        
        Contact::create($data);
        return redirect()->back()->with([  
        'message'    => 'your message Send succesfully',
        'alert-type' => 'success']);
       
    }

    ////
    public function category($slug){
        $category = categorie::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;
        
        if($category){
            $posts = Post::with(['media','user'])
            ->Posttype()
            ->whereCategoryId($category)
            ->active()
            ->orderBy('id','desc')
            ->paginate(5);
            return view('frontend.index', compact('posts'));
        }    
            return redirect()->route('frontend.index');
            
    }

    public function archive($date){
        $explode_date = explode('-', $date);
        $month = $explode_date[0];
        $year = $explode_date[1];

        $posts = Post::with(['media', 'user'])
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->posttype()
        ->active(1)
        ->orderBy('id','desc')
        ->paginate(5);
        if($posts){
            return view('frontend.index', compact('posts'));
        }
            return redirect()->route('frontend.index');
    }

    public function author($user_name){
        $user = User::whereUsername($user_name)->whereStatus(1)->first()->id;

        if($user){
            $posts = Post::with(['media','user'])
            ->posttype()
            ->whereUserId($user)
            ->active()
            ->orderBy('id','desc')
            ->paginate(5);
            return view('frontend.index', compact('posts'));
        }
          return redirect()->route('frontend.index');
    }
}