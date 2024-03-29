@extends('layouts.sidebar')

@section('content')
<div class="vh-100 border">
  <div class="top_area w-75 m-auto pt-5">
    <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>
    <div class="user_status p-3">
      <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
      <p>カナ : <span>{{ $user->over_name_kana}}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
      <p>性別 : @if($user->sex == 1)<span>男</span>@else<span>女</span>@endif</p>
      <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
      @if($user->role == 4)
      <div>選択科目 :
        @foreach($user->subjects as $subject)
        <span>{{$subject->subject}}</span>
        @endforeach
      </div>
      <div class="accordion-edit-wrap">
        <div class="accordion-edit"></div>
      </div>
      <div class="subject_edit">
        <span class="subject_edit_btn">選択科目の編集</span>
        <div class="subject_inner">
          <form action="{{ route('user.edit') }}" method="post">
            <div>
              @foreach($subjects as $subject)
              <label>{{$subject->subject}}</label>
              <input type="checkbox" name="subjects[]" value="{{ $subject->id }}">
              @endforeach
            </div>
        </div>
            <input type="submit" value="編集" class="btn btn-primary edit-btn">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            {{ csrf_field() }}
          </form>
      </div>
      @else
      @endif
    </div>
  </div>
</div>

@endsection