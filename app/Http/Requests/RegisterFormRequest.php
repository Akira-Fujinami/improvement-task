<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'mail_address' => ['required','email','max:100',Rule::unique('users','mail_address')],
            'birth_day'=>'before_or_equal:today',
            'password' => 'required|string|min:8|max:30|confirmed',//confirmedは最初に書く
            'password_confirmation' => ''//名前_confirmation
            //
        ];
    }
    public function messages(){
        return [
            'over_name.required' => '苗字は必ず入力してください。',
            'over_name.max' => '苗字は10文字以内で入力してください。',
            'over_name.string' => '苗字は文字列で入力してください。',
            'under_name.required'=>'名前は必ず入力してください。',
            'under_name.max' => '名前は10文字以内で入力してください。',
            'under_name.string' => '名前は文字列で入力してください。',
            'over_name_kana.required' =>'苗字は必ず入力してください。',
            'over_name_kana.string'=>'苗字は文字列で入力してください。',
            'over_name_kana.max'=>'苗字は30文字以内で入力してください。',
            'over_name_kana.regex'=>'苗字はカタカナで入力してください。',
            'under_name_kana.required' =>'名前は必ず入力してください。',
            'under_name_kana.string' =>'名前は文字列で入力してください。',
            'under_name_kana.max' =>'名前は30文字以内で入力してください。',
            'under_name_kana.regex'=>'名前はカタカナで入力してください。',
            'mail_address.email'=>'メールアドレスの形式で入力してください。',
            'mail_address.required'=>'メールアドレスは必ず入力してください。',
            'mail_address.max'=>'メールアドレスは100文字以内で入力してください。',
            'mail_address.unique'=>'メールアドレスは既に登録してあります。',
            'password.required'=>'パスワードは必ず入力してください。',
            'password.string'=>'パスワードは文字列で入力してください。',
            'password.min'=>'パスワードは8文字以上で入力してください。',
            'password.max'=>'パスワードは30文字以内で入力してください。',
            'password.confirmed'=>'確認用パスワードと同じものを入力してください。',
            'birth_day.before_or_equal'=>'今日より前の日程で指定してください。'

        ];
    }
}
