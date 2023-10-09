<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
          
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب',
            'name.string' => 'يرجى ادخال نص',
            'name.max' => 'الاسم يجب ان يكون اقل من 255 حرف'
        ];
    }
}
