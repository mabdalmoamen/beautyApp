<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UersRequest extends FormRequest
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
            'name' => 'required|unique:users',
            'password' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يجب ادخال الاسم',
            'name.unique' => 'هذا الاسم موجود',
            'password' => 'يجب ادخال كلمة المرور'

        ];
    }
}
