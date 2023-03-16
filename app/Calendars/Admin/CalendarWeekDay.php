<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\ReserveSettingUsers;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts_one($day){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '3')->first();

  
    if($one_part){
      $html[] = '<p class="day_part m-0 pt-1">1部</p>';
      $one_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '1')->first()->id;
    // dd($one_part);
    $one_part=ReservesettingUsers::where('reserve_setting_id',$one_part_reserve)->count();
    }
    else{
      $one_part = "0";
    }
    return $one_part;
  }

    function dayPartCounts_two($day){
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '2')->first();

    if($two_part){
      $two_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '2')->first()->id;
      $two_part=ReservesettingUsers::where('reserve_setting_id',$two_part_reserve)->count();
      $html[] = '<p class="day_part m-0 pt-1">2部</p>';
    }
    else{
      $two_part="0";
    }
    return $two_part;
  }
  function dayPartCounts_three($day){  
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part){
      $three_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '3')->first()->id;
      $three_part=ReservesettingUsers::where('reserve_setting_id',$three_part_reserve)->count();
      $html[] = '<p class="day_part m-0 pt-1">3部</p>';
    }
    else{
      $three_part="0";
    }
    return $three_part;
  }

  


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
  function reserveDetail($day){
    // dd($day);
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($three_part){
      $three_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $day)->where('setting_part', '1')->first()->id;
      $three_part=ReservesettingUsers::select('user_id')->where('reserve_setting_id',$three_part_reserve)->get();
    // dd($three_part);
    }
    else{
      $three_part="0";
    }
    return $three_part;
  }
}
