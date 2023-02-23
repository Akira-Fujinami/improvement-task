<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Models\Users\SubjectUsers;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    public function showUsers(Request $request){
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = $request->subject;// ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        // $usersubject=subjects::
        $usersubject=SubjectUsers::
        join('users','users.id','=','subject_users.user_id')
        ->get();
        // $subject_id=$user_subject->subject_id;
        // // dd($subject_id);
        // $subjectuser=Subjects::
        // where('id',$subject_id)
        // ->get();
        // // dd($subject_user);
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects','usersubject'));
    }

    public function userProfile($id){
        $users = User::find($id);
        // dd($users);
        if($users->role == 4 ){
        //  dd($user);
        $user_id=$users->id;
        // dd($user_id);
        // $subjects=SubjectUsers::select('subject_id')->join('users',function($join) use($user_id)
        // {
        //     $join->where('subject_users.user_id','=',$user_id);
        // })
        // ->first();
        // $subject_lists=Subjects::with(['subjectUsers'=>function($query){
        //     $query->where('user_id',$user->id);
        // }])->select('subject')
        // ->get();
        // dd($subject_lists);
        $subjects=SubjectUsers::where('user_id',$user_id)->first();
        // dd($subjects);
        $subject_lists = Subjects::select('subject')
        ->where('id',$subjects->subject_id)
        ->get();
        // dd($subject_lists);
        return view('authenticated.users.profile', compact('users', 'subject_lists'));
        }
        else{
            return view('authenticated.users.profile', compact('users'));
        }
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}