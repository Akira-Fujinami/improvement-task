<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use App\Models\Calendars\Calendars;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
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
          $html[] = '<td class="past-day border">';
        }else{
          $html[] = '<td class="border '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          $reserveDate = $day->authReserveDate($day->everyDay())->first()->setting_reserve;
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          $id=$day->authReserveDate($day->everyDay())->first()->id;
          if($reservePart == 1){
            $reservePart_name = "リモ1部";
          }else if($reservePart == 2){
            $reservePart_name = "リモ2部";
          }else if($reservePart == 3){
            $reservePart_name = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'.$reservePart_name.'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            // $html[]='<input type="submit" class="btn btn-danger p-0 w-75" style="font-size:12px" value=""'.$reservePart_name.'</input>';
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" style="font-size:12px" >'. $reservePart_name .'</button>';
            $html[]='<button type="submit" name="delete_date" class="reserve-modal-open pt-modal-cancel" form="deleteParts" value="'. $id .'" reserve_date='.$reserveDate.' reserve_part='.$reservePart_name.' reserve_id='.$id.'>キャンセル</button>';
            $html[] = '<input type="hidden" name="getPart[]" value=""'.$id.' form="reserveParts">';
          };
          
        }elseif($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[]='<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
        }else{
          $html[] = $day->selectPart($day->everyDay());
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[]='<div class="modal js-modals">';
    $html[]='<div class="modal__bg js-modal-close"></div>';
    $html[]='<div class="modal__content">';
    $html[]='<div class="reserve-dating">';
    $html[]='<p class="reserve-date">予約日時：</p>';
    $html[]='<input disabled type="text" class="modal_reserve reserve-dates" name="reserve_date">';
    $html[]='</div>';
    $html[]='<div class="reserve-parting">';
    $html[]='<p class="reserve-part">時間：</p>';
    $html[]='<input disabled type="text" class="modal_part reserve-parts" name="reserve_part">';
    $html[]='</div>';
    $html[]='<input type="hidden" class="modal_id" name="reserve_id">';
    $html[]='<p>上記の予約をキャンセルしてもよろしいでしょうか</p>';
    $html[]='<button type="submit" class="btn btn-danger pt-cancel" name="delete_date" form="deleteParts" value="'. $id .'" >キャンセル</button>';
    $html[]='<a class="js-modal-close btn btn-primary pt-close" href="">閉じる</a>';
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[]='</div>';
    $html[] = '</div>';
    $html[]='</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';
    $html[]='<script src="{{ asset("js/calendar.js") }}" rel="stylesheet"></script>';
    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}