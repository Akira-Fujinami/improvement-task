<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Illuminate\Validation\Rule;
use App\Http\Requests\RegisterFormRequest;

use App\Models\Users\Subjects;
use App\Models\Users\SubjectUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }
    public function store(Request $request){
            $validated=$request->validate([//バリデーションを行う
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30',
            'under_name_kana' => 'required|string|max:30',
            'mail_address' => ['required','email','string','max:100',Rule::unique('users','mail_address')],
            'sex' => 'required',
            'year' => 'nullable|present|numeric|required_with:month,day',
            'month' => 'nullable|present|numeric|required_with:year,day',
            'day' => 'nullable|present|numeric|required_with:year,month',
            'full_date' => 'nullable|date|before_or_equal:' . today()->format('Y-m-d'),
            'role' => 'required',
            'password' => 'required|string|min:8|max:30|confirmed',//confirmedは最初に書く
            'password_confirmation' => 'required|string|min:8|max:30']);//名前_confirmation
            return redirect('/login');
    }
    public function registerPost(RegisterFormRequest $request)
    {
        // DB::beginTransaction();
        // try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;
            // dd($subjects);
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            $user = $user_get->id;
            // dd($user);
            // DB::commit();
            // SubjectUsers::create([
            //     'user_id' => $user,
            //     'subject_id' => $subjects,
            // ]);
            // return redirect('/login');
        // }catch(\Exception $e){
        //     DB::rollback();
        //     // return redirect()->route('loginView');
        // }
            $subject=SubjectUsers::create([
                'user_id' => $user,
                'subject_id' => $subjects,
            ]);
            // dd($subject);
            return redirect('/login');
    }
}