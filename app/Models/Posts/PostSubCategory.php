<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post_Sub_Category extends Model
{

    protected $fillable = [
        'post_id',
        'sub_category_id',
        'created_at'
    ];
    public function posts()
    {
        return $this->hasMany(post::class, 'user_id','post_title','post');
    }
}
