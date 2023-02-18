<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostSubCategory extends Model
{
    public $timestamps = false;
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
