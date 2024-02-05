<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupllierRequest extends FormRequest
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
            'supplier_name'=>'required|unique:mixins_suppliers',
            'supplier_mobile'=>'required'

        ];
    }
    public function messages()
    {
        return [
            'supplier_name.required'=>'يجب ادخال اسم المورد',
            'supplier_name.unique'=>'ي  وجد مورد بهذا الاسم',
            'supplier_mobile.required'=>'هاتف المورد مطلوب'
        ];
    }
}
