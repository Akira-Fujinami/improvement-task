<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;

class Calendars extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'reserve_date',
        'reserve_part',
    ];

    public function users(){
        return $this->belongsToMany('App\Models\Users\User', 'calendar_users', 'calendar_id', 'user_id');
    }
}