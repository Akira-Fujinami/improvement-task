<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;

class ReserveSettingUsers extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'reserve_setting_id',
    ];
    

}