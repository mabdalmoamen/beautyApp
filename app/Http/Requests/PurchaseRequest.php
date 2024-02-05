<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'bill_serial'=>'required|unique:mixins_purchase_bills',
            'supplier'=>'required'

        ];
    }
    public function messages()
    {
        return [
            'bill_serial.required'=>'يجب إدخال سيريال الفاتورة',
            'bill_serial.unique'=>'سيريال الفاتورة موجود بالفعل',
            'supplier.required'=>'يجب إدخال   المورد ',

        ];
    }
}
