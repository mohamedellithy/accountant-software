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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'purchasing_price' => 'required',
            'sale_price'       => 'required',
            'product_id'       => 'required|unique:products,id,'.$this->stock,
            'quantity'         => 'required|numeric',
            'supplier_id'      => 'required',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'product_id.required'  => 'المنتج مطلوب',
    //         'quantity.required'    => 'حقل الكمية مطلوب',
    //         'purchasing_price.required'  => 'حقل سعر البيع مطلوب',
    //         'sale_price.required'  => 'حقل سعر الشراء مطلوب',
    //         'supplier_id.required' => 'حقل اسم المزود مطلوب'
    //     ];
    // }
}
