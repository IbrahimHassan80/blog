<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Comment;
use App\Models\Categorie;
use App\Models\User;
use App\Models\PostMedia;
use Nicolaslopezj\Searchable\SearchableTrait;
class Post extends Model
{
  use Sluggable, SearchableTrait;
 
 protected $guarded = [];
 
 public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'posts.title'       =>  10,
            'posts.description' => 10
        ],
    ];

    // Relation Ship //
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
    
    public function approved_comments()
    {
        return $this->hasMany(Comment::class)->whereStatus(1);
    }

         public function media()
    {
        return $this->hasMany(PostMedia::class);
    }


}
