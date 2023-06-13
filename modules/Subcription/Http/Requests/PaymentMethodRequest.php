<?php

namespace Modules\Subcription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'required'
         ];
    }


    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
           'title.required' => 'Title field is required'
        ];
    }
}
