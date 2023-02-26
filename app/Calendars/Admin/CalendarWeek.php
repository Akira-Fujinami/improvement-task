<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;

class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName(){
    return "week-" . $this->index;
  }

  function getDays(){
    $days = [];
    $startDay = $this->carbon->copy()->startOfWeek();//開始日から終了日
    $lastDay = $this->carbon->copy()->endOfWeek();
    $tmpDay = $startDay->copy();

    while($tmpDay->lte($lastDay)){//月曜日から日曜日までループ
      if($tmpDay->month != $this->carbon->month){
        $day = new CalendarWeekBlankDay($tmpDay->copy());
        $days[] = $day;
        $tmpDay->addDay(1);
        continue;
       }
       $day = new CalendarWeekDay($tmpDay->copy());
       $days[] = $day;
       $tmpDay->addDay(1);
    }
    return $days;
  }
}