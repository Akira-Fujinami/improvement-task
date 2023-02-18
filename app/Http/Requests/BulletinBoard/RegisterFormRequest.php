<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'password_confirmation' => 'required|string|min:8|max:30'//名前_confirmation
        ];
    }

    public function messages(){
        return [
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
        ];
    }
}