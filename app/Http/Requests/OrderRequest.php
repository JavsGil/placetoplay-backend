<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customer_mame' => 'required|max:80',
            'customer_email' => 'required|max:120',
            'customer_mobile' => 'required|numeric|max:40',
            'status' => 'required|max:20',
            
        ];
    }

    public function messages()
    {
        return [
            'customer_mame.required' => 'A customer mame is required',
            'customer_mame.max' => 'A customer mame cannot exceed 80 characters',

            'customer email.required' => 'A customer email is required',
            'customer_email.max' => 'A customer email cannot exceed 120 characters',

            'customer_mobile.required' => 'A customer mobile is required',
            'customer_mobile.max' => 'A customer mobile cannot exceed 40 characters',

            'status.required' => 'A status is required',
            'status.max' => 'A status cannot exceed 2. characters',
            
        ];
    }
}
