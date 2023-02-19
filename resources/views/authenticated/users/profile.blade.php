@extends('layouts.sidebar')

@section('content')
<div class="vh-100 border">
  <div class="top_area w-75 m-auto pt-5">
  @foreach($users as $user)
  {{isset($user->sex)}}
    <span>{{ $user->over_name }}</span><span>{{ isset($user->under_name) }}さんのプロフィール</span>
    <div class="user_status p-3">
      <p>名前 : <span>{{ isset($user->over_name) }}</span><span class="ml-1">{{ isset($user->under_name) }}</span></p>
      <p>カナ : <span>{{ isset($user->over_name_kana) }}</span><span class="ml-1">{{ isset($user->under_name_kana) }}</span></p>
      <p>性別 : @if(isset($user->sex) == 1)<span>男</span>@else<span>女</span>@endif</p>
      <p>生年月日 : <span>{{ isset($user->birth_day) }}</span></p>
      @endforeach
  @if(isset($user->role) == 4)
      @foreach($subject_lists as $subject_lists)
      <div>選択科目 :
        <span>{{ isset($subject_lists->subject) }}</span>
      </div>
      <div class="">
        @can('admin')
        <span class="subject_edit_btn">選択科目の編集</span>
        <div class="subject_inner">
          <form action="{{ route('user.edit') }}" method="post">
            <div>
              <label>{{ isset($subject_lists->id) }}</label>
              <input type="checkbox" name="subjects[]" value="{{ isset($subject_lists->id) }}">
            </div>
            
            <input type="submit" value="編集" class="btn btn-primary">
            <input type="hidden" name="user_id" value="{{ isset($user->id) }}">
            {{ csrf_field() }}
          </form>
        </div>
        @endcan
      </div>
      @endforeach
      @else
      @endif
    </div>
  </div>
</div>

@endsection