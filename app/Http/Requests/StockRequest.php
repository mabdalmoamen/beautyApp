<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'title'=>
            'required|unique:gusto_stocks'.$this->id,
            'stock'=>'required'

        ];
    }
    public function messages()
    {
        return [
            'title.required'=>'يجب ادخال اسم المخزون',
            'title.unique'=>'يوجد مخزون بهذا الاسم',
            'stock.required'=>'كمية المخزون'
        ];
    }
}
