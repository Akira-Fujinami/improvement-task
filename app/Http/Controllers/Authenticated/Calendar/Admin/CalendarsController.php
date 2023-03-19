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
        // dd($reserveDetail);
        $reservePersons=ReserveSettings::with('users')->where('id',$reserveDetail)->get();
        // dd($reservePersons);
        $Date=ReserveSettings::where('id',$reserveDetail)->first();
        if($reservePersons==null){
            return view('authenticated.calendar.admin.reserve_detail_null',compact('Date'));
        }
        else{
        $reservePlace=array('リモート');
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersons','Date','reservePlace'));
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