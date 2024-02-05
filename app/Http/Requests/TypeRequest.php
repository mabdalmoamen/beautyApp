<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
            'type_name_ar' => 'required|unique:types' . $this->type_id,
            'type_sill_price' => 'required',
            // 'type_barcode' => 'unique:types' . $this->type_id,

        ];
    }
    public function messages()
    {
        return [
            'type_name_ar.required' => 'يجب ادخال اسم الصنف العربي',
            'type_name_ar.unique' => 'هناك صنف أخر له نفس الاسم',
            'type_sill_price.required' => 'يجب إدخال سعر بيع الصنف',
            // 'type_barcode.unique' => 'هناك صنف أخر له نفس الباركود',

        ];
    }
}
