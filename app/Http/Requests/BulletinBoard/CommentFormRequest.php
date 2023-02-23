<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CommentFormRequest extends FormRequest
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
            'comment' => 'required|string|max:2500',
        ];
    }

    public function messages(){
        return [
            'comment.required' => 'コメントは必ず入力してください。',
            'comment.max' => 'コメントは2500文字以内で入力してください。',
            'comment.string' => 'コメントは文字列で入力してください。',
        ];
    }
}