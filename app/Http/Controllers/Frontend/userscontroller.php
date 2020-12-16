<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\categorie;
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

  public function create(){
    $categoer = categorie::whereStatus(1)->pluck('name', 'id');  
    return view('frontend.users.create-post', compact('categoer'));
  }  

}