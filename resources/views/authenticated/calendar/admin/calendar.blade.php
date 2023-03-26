@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto">
  <div class="border w-100 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-70 calendar-admin">
      <p>{{ $calendar->getTitle() }}</p>
      <p>{!! $calendar->render() !!}</p>
    </div>
  </div>
</div>
@endsection