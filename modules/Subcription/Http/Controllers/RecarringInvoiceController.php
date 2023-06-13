<?php

namespace Modules\Subcription\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subcription\Entities\PackageInvoice;
use Modules\Subcription\Entities\PackagePaymentMethod;
use Modules\Subcription\Entities\PackageInvoicePayment;
use Modules\Subcription\Entities\PackageRecarringInvoice;
use Modules\Subcription\Entities\PackageRecarringInvoiceDetails;
use Modules\Subcription\Entities\PackageRecarringInvoicePayment;

class RecarringInvoiceController extends Controller
{

    public function index()
    {

    }

    public function create()
    {
        return view('subcription::create');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($invoice_id)
    {
        $recarringInvoices = PackageRecarringInvoice::where('invoice_id',$invoice_id)
                                                     ->with('client','package','packageRecarringInvoicePayment')
                                                     ->get();
        return view('subcription::invoice.recarring-invoice.index',[
            'recarringInvoices' => $recarringInvoices
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('subcription::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
