<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Comment;
use App\Models\Categorie;
use App\Models\User;
use App\Models\PostMedia;

class page extends Model
{
    use Sluggable;
 
 protected $table = 'posts';
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
        return $this->belongsTo(Categorie::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

           public function media()
    {
        return $this->hasMany(PostMedia::class, 'post_id', 'id');
    }
}
