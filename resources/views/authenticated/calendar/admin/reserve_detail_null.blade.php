@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{$Date->setting_reserve}}日</span><span class="ml-3">{{$Date->setting_part}}部</span></p>
    <div class="h-75 border">
      <table class="text-center">
        <div class="text-center-id">
          <tr class="text-center">
            <th class="w-25 detail-id-title">ID</th>
            <th class="w-25 detail-name-title">名前</th>
            <th class="w-25 detail-place-title">場所</th>
          </tr>
        </div>
        <tr class="text-center">
          <td class="w-25">
          </td>
          <td class="w-25">
          </td>
          <td class="w-25">
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection