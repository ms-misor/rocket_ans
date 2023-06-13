<?php

namespace Modules\Subcription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{

    public function rules()
    {
        return [
           'title' => 'required',
           'price' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
           'title.required' => 'Title field is required',
           'price.required' => 'Price field is required',
        ];
    }
}
