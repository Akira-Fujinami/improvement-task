<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SubFormRequest extends FormRequest
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
            'sub_category_name'=>['required','max:100','string',Rule::unique('sub_categories','sub_category')],
        ];
    }

    public function messages(){
        return [
            'sub_category_name.required'=>'サブカテゴリーは必ず入力してください。',
            'sub_category_name.max'=>'サブカテゴリーは100文字以内で入力してください。',
            'sub_category_name.unique'=>'サブカテゴリーは既に登録してあります。',
            'sub_category_name.string'=>'サブカテゴリーは文字列で入力してください。',
        ];
    }
}