<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class SubjectUsers extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'user_id',
        'subject_id'
    ];
    public function subjects(){
        return $this->hasMany(Subject::class, 'subject');// リレーションの定義
    }
}