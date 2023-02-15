<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
        'created_at'
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'like_user_id','like_post_id');
    }
    public function subCategories(){
        // リレーションの定義
        return $this->belongsToMany('App\SubCategory');
    }
    public function mainCategory(){
        // リレーションの定義
        return $this->hasMany('App\mainCategory');
    }
    public function postSubCategories()
    {
        return $this->belongsTo(postSubCategories::class, 'post_id','sub_category_id');
    }
    public function likeCounts($post_id){
        return $this->likes()->where('like_post_id', $post_id)->get()->count();
    }
    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}