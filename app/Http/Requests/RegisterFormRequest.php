<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
    public function getValidatorInstance()
    {
        // プルダウンで選択された値(= 配列)を取得
        $datetime_year = $this->input('old_year'); //デフォルト値は空の配列
        $datetime_month = $this->input('old_month'); 
        $datetime_day = $this->input('old_day'); 
        $datetime_validation = $datetime_year . '-' . $datetime_month . '-' . $datetime_day;
        // 日付を作成(ex. 2020-1-20)

        // rules()に渡す値を追加でセット
        //     これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'datetime_validation' => $datetime_validation,
        ]);
        return parent::getValidatorInstance();
    }
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' => 'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'mail_address' => ['required','email','max:100',Rule::unique('users','mail_address')],
            'sex'=>'required|in:1,2,3',
            'role'=>'required|in:1,2,3,4',
            'datetime_validation'=>'before_or_equal:today|after:1999-12-31',
            'password' => 'required|string|min:8|max:30|confirmed',//confirmedは最初に書く
            'password_confirmation' => ''//名前_confirmation
            //
        ];
    }
    public function messages(){
        return [
            'over_name.required' => '苗字は必ず入力してください。',
            'over_name.max' => '苗字は10字以内で入力ください。',
            'over_name.string' => '苗字は文字列で入力ください。',
            'under_name.required'=>'名前は必ず入力してください。',
            'under_name.max' => '名前は10字以内で入力ください。',
            'under_name.string' => '名前は文字列で入力ください。',
            'over_name_kana.required' =>'苗字は必ず入力してください。',
            'over_name_kana.string'=>'苗字は文字列で入力ください。',
            'over_name_kana.regex'=>'苗字はカナで入力してください。',
            'over_name_kana.max'=>'苗字は30字以内で入力ください。',
            'under_name_kana.required' =>'名前は必ず入力してください。',
            'under_name_kana.string' =>'名前は文字列で入力ください。',
            'under_name_kana.regex'=>'名前はカナで入力してください。',
            'under_name_kana.max' =>'名前は30字以内で入力ください。',
            'mail_address.email'=>'メールアドレスの形式で入力してください。',
            'mail_address.required'=>'メールアドレスは必ず入力してください。',
            'mail_address.max'=>'メールアドレスは100文字以内で入力してください。',
            'mail_address.unique'=>'メールアドレスは既に登録してあります。',
            'password.required'=>'パスワードは必ず入力してください。',
            'password.string'=>'パスワードは文字列で入力してください。',
            'password.min'=>'パスワードは8文字以上で入力してください。',
            'password.max'=>'パスワードは30文字以内で入力してください。',
            'password.confirmed'=>'確認用パスワードと同じものを入力してください。',
            'datetime_validation.before_or_equal'=>'今日より前の日程で指定してください。',
            'datetime_validation.after'=>'2000年1月1日より後の日程を指定してください。',
            'sex.required'=>'性別は必ず入力してください。',
            'sex.in'=>'性別は男性、女性、その他以外無効です。',
            'role.required'=>'役職は必ず入力してください。',
            'role.in'=>'役職は講師(国語)、講師(数学)、教師(英語)、生徒以外無効です。'
        ];
    }
}
