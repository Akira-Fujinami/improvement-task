<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class MainFormRequest extends FormRequest
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
            'main_category_name'=>['required','max:100','string',Rule::unique('main_categories','main_category')],
        ];
    }

    public function messages(){
        return [
            'main_category_name.required'=>'メインカテゴリーは必ず入力してください。',
            'main_category_name.max'=>'メインカテゴリーは100文字以内で入力してください。',
            'main_category_name.unique'=>'メインカテゴリーは既に登録してあります。',
            'main_category_name.string'=>'メインカテゴリーは文字列で入力してください。',
        ];
    }
}