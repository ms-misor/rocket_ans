<?php

namespace Modules\Subcription\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Modules\Subcription\Entities\PackagePaymentMethod;

class PaymentMethodController extends Controller
{

    public function index()
    {
        $paymentMethods = PackagePaymentMethod::orderBy('id','desc')->get();
        return view('subcription::payment-methods.index',[
           'paymentMethods' => $paymentMethods
        ]);
    }


    public function store(Request $request)
    {
        $paymentMethod =  new PackagePaymentMethod();
        $paymentMethod->fill($request->all());
        $paymentMethod->status = @$request->status ?? 0;
        $paymentMethod->save();
        Toastr::success('PaymentMethod created successfully :)','Success');
        return redirect()->route('payment-methods.index');

    }

    public function update(Request $request, $id)
    {
        $paymentMethod =  PackagePaymentMethod::findOrFail($id);
        $paymentMethod->fill($request->all());
        $paymentMethod->status = @$request->status ?? 0;
        $paymentMethod->save();
        Toastr::success('PaymentMethod Update Successfully ','Success');
        return redirect()->route('payment-methods.index');
    }


}
