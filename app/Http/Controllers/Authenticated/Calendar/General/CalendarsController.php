<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
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
        
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // dd($getDate);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            dd($reserveDays);
            foreach($reserveDays as $key => $value){
                // dd($key);
                $reserve=Calendars::create([
                    'reserve_date'=>$key,
                    'reserve_part'=>$value
                ]);
                // $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // $reserve_settings->decrement('limit_users');
                $reserve_user=$reserve->users()->attach(Auth::id());
            }
        
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}