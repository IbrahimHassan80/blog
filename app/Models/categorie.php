<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Models\Post;
class categorie extends Model
{
    use Sluggable;

     public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


     public function posts()
    {
        return $this->hasMany(Post::class);
    }

}//
