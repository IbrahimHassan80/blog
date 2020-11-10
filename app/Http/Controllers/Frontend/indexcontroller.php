<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\post;
use App\Http\Requests\validate_comment;
use Illuminate\Support\Facades\Validator;

class indexcontroller extends Controller
{
    public function index(){
        $posts = post::with(['category', 'user', 'media'])->whereHas('category', function($query){
            $query->whereStatus(1);
        })->whereHas('user', function($query){
            $query->whereStatus(1);
        })->wherePostType('post')->whereStatus(1)->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));
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
        $data['comment' ]         = $request->commen;
        $data['post_id' ]         = $post->id;
        $data['user_id' ]         = $user_id;
        $data['comment' ]         = $request->comment;
        $data['status' ]          = 1;
        $post->comments()->create($data);
        return redirect()->back()->with([
            'message'    => 'comment added succesfully',
            'alert-type' => 'success'
        ]);    
    }
    }
}
