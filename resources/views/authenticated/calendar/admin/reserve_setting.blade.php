@extends('layouts.sidebar')
@section('content')
<div class="w-75 m-auto">
  <div class="border w-100 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-100 calendar-setting">
      {!! $calendar->render() !!}
    </div>
    <div class="adjust-table-btn m-auto text-right">
      <input type="submit" class="btn btn-primary btn-setting" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection