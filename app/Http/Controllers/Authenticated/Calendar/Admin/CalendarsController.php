<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView;
use App\Calendars\Admin\CalendarSettingView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\ReserveSettingUsers;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

    public function reserveDetail(Request $request){
        // dd($request);
        $reserveDetail=$request->reserveDetail;
        $Date=ReserveSettings::where('id',$reserveDetail)->first();
        // dd($reserveDetail);
        // $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
        // $reservePersons=User::join('Reserve_Setting_Users',function($join)use($reserveDetail){
        //     $join->where('reserve_setting_id','=',$reserveDetail);
        // })->get();
        // dd($reservePersons);
        $reservePersons=ReservesettingUsers::select('user_id')->where('reserve_setting_id',$reserveDetail)->first();
        if($reservePersons==null){
            return view('authenticated.calendar.admin.reserve_detail_null',compact('Date'));
        }
        else{
        $reserveDetails=$reservePersons->user_id;
        // dd($reserveDetails);
        $reservePersonUser=User::where('id',$reserveDetails)->get();
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersonUser','Date'));
    }}

    public function reserveSettings(){
        $calendar = new CalendarSettingView(time());
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    public function updateSettings(Request $request){
        $reserveDays = $request->input('reserve_day');
        // dd($reserveDays);
        foreach($reserveDays as $day => $parts){
            foreach($parts as $part => $frame){
                $reservesetting=ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ],[
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);
    }
}