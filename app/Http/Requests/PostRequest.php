<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|max:2',
        ];
    }
    /**
     * バリデータインスタンスの設定
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        
        $validator->after(function ($validator) {
            // dd('ett');
            // if ($this->somethingElseIsInvalid()) {
            //     $validator->errors()->add('field', 'Something is wrong with this field!');
            // }
        });
    }

    // エラー時のリダイレクト先を変更
    protected $redirect = '/';
}
