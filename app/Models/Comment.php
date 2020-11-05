<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class Comment extends Model
{
    protected $guarded = [];

    public function post(){
    	return $this->belongsTo(Post::class);
    }
}
