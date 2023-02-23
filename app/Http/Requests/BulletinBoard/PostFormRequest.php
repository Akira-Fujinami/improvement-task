<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ];
    }

    public function messages(){
        return [
            'post_title.required' => 'タイトルは必ず入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_title.string' => 'タイトルは文字列で入力してください。',
            'post_body.required' => '投稿内容は必ず入力してください。',
            'post_body.max' => '投稿内容の最大文字数は500文字です。',
            'post_body.string' => '投稿内容は文字列で入力してください。',
        ];
    }
}