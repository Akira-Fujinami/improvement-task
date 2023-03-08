<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\ReserveSettingUsers;
use App\Models\Calendars\Calendars;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        // dd($request);
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // dd($getDate);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // dd($reserveDays);
            foreach($reserveDays as $key => $value){
                // dd($key);
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
                // $reservePart=$reserve->id;
                // dd($reservepart);
            }
        
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
        $delete_id=$request->delete_date;
        ReserveSettingUsers::where('reserve_setting_id',$delete_id)->delete();
        $delete_reserve=ReserveSettings::where('id',$delete_id)->first();
        $delete_reserve->increment('limit_users');
        
        return back();
    }
}