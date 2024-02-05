<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'cust_name'=>'required|unique:customers',
          'cust_mobile'=>'unique:customers'

        ];
    }
    public function messages()
    {
        return [
            'cust_name.required'=>'يجب إدخال اسم العمسل',
            'cust_name.unique'=>'اسم العميل موجود بالفعل',
            'cust_mobile.unique'=>'تم تخصيص الهاتف لعميل ',

        ];
    }
}
