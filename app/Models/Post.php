<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Comment;
use App\Models\Categorie;
use App\Models\User;
use App\Models\PostMedia;

class Post extends Model
{
  use Sluggable;
 
 protected $guarded = [];
 
 public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

         public function media()
    {
        return $this->hasMany(PostMedia::class);
    }


}
