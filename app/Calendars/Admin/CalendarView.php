<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Users\User;
use App\Models\Calendars\ReserveSettings;

class CalendarView{
  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();
    $days=date('Y-m-d',strtotime('yesterday'));
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");

        
        $toDay = $this->carbon->yesterday()->copy()->format("Y-m-d");
        // dd($day);
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="past-day border '.$day->pastClassName().'">';
        }else{
          $html[] = '<td class="border '.$day->getClassName().'">';
        }
        $html[] = $day->render();
        if($day->everyDay()){
          if(ReserveSettings::select()->exists()){            
          $html[]='<div class="reserve-detail-wrap">';
          $html[]='<div class="reserve-detail-div">';
          $html[] ='<div><button type="submit" class="reserve-detail" name="reserveDetail" value='.$day->reserveDetail_one($day->everyDay())->first()->id.' form="reserveDetail">'.$day->dayPartCounts_one($day->everyDay()).'</button></div>';
          $html[] = '<div><button type="submit" class="reserve-detail" name="reserveDetail" value='.$day->reserveDetail_two($day->everyDay())->first()->id.' form="reserveDetail">'.$day->dayPartCounts_two($day->everyDay()).'</button></div>';
          $html[] = '<div><button type="submit" class="reserve-detail" name="reserveDetail" value='.$day->reserveDetail_three($day->everyDay())->first()->id.' form="reserveDetail">'.$day->dayPartCounts_three($day->everyDay()).'</button></div>';
          $html[]='</div>';
          $html[]='<div class="reserve-part-frame-div">';
          $html[]='<div><button type="submit" class="reserve-part-frame" name="reserveDetail" value='.$day->reserveDetail_one($day->everyDay())->first()->id.' form="reserveDetail">1部</button></div>';
          $html[]='<input type="hidden" value='.$day->reserveDetail_one($day->everyDay())->first()->id.' form="reserveDetail">';
          $html[] = '<div><button type="submit" class="reserve-part-frame" name="reserveDetail" value='.$day->reserveDetail_two($day->everyDay())->first()->id.' form="reserveDetail">2部</button></div>';
          $html[]='<input type="hidden" value='.$day->reserveDetail_two($day->everyDay())->first()->id.' form="reserveDetail">';
          $html[] = '<div><button type="submit" class="reserve-part-frame" name="reserveDetail" value='.$day->reserveDetail_three($day->everyDay())->first()->id.' form="reserveDetail">3部</button></div>';
          $html[]='<input type="hidden" value='.$day->reserveDetail_three($day->everyDay())->first()->id.' form="reserveDetail">';
          $html[]='</div>';
          $html[]='</div>';
      }
      }
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/calendar" method="get" id="reserveDetail">'.csrf_field().'</form>';
    return implode("", $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();//開始日～終了日
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){//月曜日から日曜日までループ
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}