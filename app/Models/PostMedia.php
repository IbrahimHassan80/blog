<?php

namespace App\models;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    protected $table = "post_media";  
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
