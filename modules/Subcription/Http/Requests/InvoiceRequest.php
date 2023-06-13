<?php

namespace Modules\Subcription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{

    public function rules()
    {
        return [
            'client_id'                 => 'required',
            'package_id'                => 'required',
            'invoice_date'              => 'required',
            'bill_start_date'           => 'required',
            'package_type'              => 'required',
            'package_payment_method_id' => 'required'

        ];
    }


    public function authorize()
    {
        return true;
    }


    public function messages()
    {
        return [
           'client_id.required'                 => 'Client field is required',
           'package_id.required'                => 'Package field is required',
           'invoice_date.required'              => 'Invoice Date field is required',
           'bill_start_date.required'           => 'Bill Start Date field is required',
           'package_payment_method_id.required' => 'Payment method field is required',
           'package_type.required'              => 'Package Type field is required',
        ];
    }
}
