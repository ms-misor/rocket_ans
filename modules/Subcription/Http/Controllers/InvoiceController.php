<?php

namespace Modules\Subcription\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Role\Entities\Module;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Subcription\Entities\Package;
use Modules\Subcription\Entities\PackageInvoice;
use Modules\Subcription\Entities\PackageDuration;
use Modules\Subcription\Http\Requests\InvoiceRequest;
use Modules\Subcription\Entities\PackagePaymentMethod;
use Modules\Subcription\Entities\PackageInvoicePayment;
use Modules\Subcription\Entities\PackageRecarringInvoice;
use Modules\Subcription\Entities\PackageRecarringInvoicePayment;

use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Entities\Setting;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        // return $month  = Carbon::now()->diffInMonths($entry_date);
        // return $day    = Carbon::now()->diffInDays($entry_date);
        $invoices = $this->filterInvoice($request)->with(['client','package','packageInvoicePayment','packageDuration'])->groupBy('id')->get();

        return view('subcription::invoice.index',[
            'invoices' => $invoices,
            'packages'  => Package::get()
        ]);

    }


    public function filterInvoice($request = null)
    {
        
        $query = PackageInvoice::whereNotNull('id');
        if(!empty($request->client_id)){
            $query =$query->where('client_id', $request->client_id);
        }

        if(!empty($request->package_id)){
            $query =$query->where('package_id', $request->package_id);
        }

        if(!empty($request->mydaterenge)){

            $dateRange = explode("/",$request->mydaterenge);
            $startdate = $dateRange[0];
            $enddate   = $dateRange[1];
            $query = $query->whereBetween('invoice_date', [$startdate, $enddate]);

        }
        return $query;

    }

    


    public function create()
    {
        return view('subcription::invoice.create',[
            'packages'          => Package::orderBy('id','desc')->get(),
            'clients'           => Client::orderBy('id','desc')->get(),
            'paymentMethods'    => PackagePaymentMethod::orderBy('id','desc')->get(),
            'packageDurations'  => PackageDuration::get()
        ]);
    }

    
    // public function invoiceCreate(Package $package){
    //     return view('subcription::invoice.create',[
    //         'packages'          => Package::orderBy('id','desc')->get(),
    //         'clients'           => Client::orderBy('id','desc')->get(),
    //         'selected_package'  => $package,
    //         'paymentMethods'    => PackagePaymentMethod::orderBy('id','desc')->get(),
    //         'packageDurations'  => PackageDuration::get()
    //     ]);
    // }
    


    public function store(InvoiceRequest $request)
    {

        $packageDuration = PackageDuration::findOrFail($request->package_duration_id);

        $invoice = new PackageInvoice();
        $package = Package::with('modules')->where('id',$request->package_id)->firstOrFail();
        $invoice->fill($request->all());
        $this->storeOffer($invoice,$package);
        $invoice->status = @$request->status ?? 0;
        if($packageDuration->unit>=12){
            $discount = (@$package->offer_price + @$package->offer_discount);
            $invoice->offer_discount = @$package->offer_discount;
        }else{
            $discount = (@$package->offer_price);
            $invoice->offer_discount = 0;
        }
        $invoice->duration = @$package->duration;
        $invoice->total_amount = ($package->price*$packageDuration->unit)- @$discount;

        if($invoice->save()){

            $modules_id = $package->modules()->pluck('module_id')->toArray();
            $invoice->modules()->sync( $modules_id);
            $invoicePayment = new PackageInvoicePayment();
            $invoicePayment->fill($request->only('total_amount','package_payment_method_id','received_date'));
            
            $invoicePayment->total_amount =  $invoice->total_amount;
            $invoicePayment->invoice_id =  $invoice->invoice_id;

            $invoicePayment->save();

            $this->recarringInvoiceStore($request , $invoice, $package, $modules_id );

            $this->sentInvoiceByMail($invoice->id);

        }

        Toastr::success('Invoice created successfully :)','Success');

        return redirect()->route('packages-invoices.index');
    }


    public function show($id)
    {
        return view('subcription::show');
    }



    public function edit($id)
    {

        $invoice = PackageInvoice::findOrFail($id);
        return view('subcription::invoice.edit',[
            'packages'      => Package::orderBy('id','desc')->get(),
            'clients'       => Client::orderBy('id','desc')->get(),
            'modules'       => Module::orderBy('id','desc')->get(),
            'paymentMethods' => PackagePaymentMethod::orderBy('id','desc')->get(),
            'invoice' => $invoice,
            'modules_id' => $invoice->modules()->pluck('module_id')->toArray(),
            'packageDurations' => PackageDuration::get()
        ]);

    }

    
    public function update(Request $request, $id)
    {

        //return $request->all();
        $invoice = PackageInvoice::findOrFail($id);
        $package = Package::with('modules')->where('id',$request->package_id)->firstOrFail();
        $packageDuration = PackageDuration::findOrFail($request->package_duration_id);
        
        $invoice->fill($request->all());
        $this->storeOffer($invoice,$package);
        $invoice->status = @$request->status ?? 0;
        $invoice->duration = @$package->duration;
        if($packageDuration->unit>=12){
            $discount = (@$package->offer_price + @$package->offer_discount);
            $invoice->offer_discount = @$package->offer_discount;
        }else{
            $discount = (@$package->offer_price);
            $invoice->offer_discount = 0;
        }
        $invoice->total_amount = ($package->price*$packageDuration->unit)- @$discount;

        if($invoice->save()){

            $modules_id = $package->modules()->pluck('module_id')->toArray();
            $invoice->modules()->sync( $modules_id);
            $invoicePayment = $invoice->packageInvoicePayment()->firstOrFail();
            $invoicePayment->fill($request->only('total_amount','package_payment_method_id','received_date'));
            $invoicePayment->total_amount =  $invoice->total_amount;
            $invoicePayment->invoice_id =  $invoice->invoice_id;
            $invoicePayment->save();
            $this->recarringInvoiceUpdate($request , $invoice, $package, $modules_id );
        }

        Toastr::success('Invoice updated successfully :)','Success');
        return redirect()->route('packages-invoices.index');

    }


    public function destroy($id)
    {
        $invoice = PackageInvoice::findOrFail($id);
        $invoice->packageInvoicePayment()->delete();
        $invoice->delete();
        Toastr::success('Invoice deleted successfully :)','Success');
        return response()->json(['success' => 'Data Deleted Successfully']);
    }


    private function recarringInvoiceStore($request , $invoice, $package, $modules_id){

        $recarringInvoice = new PackageRecarringInvoice();
        $recarringInvoice->fill($request->all());
        $recarringInvoice->invoice_id = $invoice->invoice_id;
        $this->storeRecarringOffer( $recarringInvoice ,$package);
        $recarringInvoice->status = @$request->status ?? 0;
        if($recarringInvoice->save()){
            $recarringInvoice->modules()->sync( $modules_id);
            $recarringInvoicePayment = new PackageRecarringInvoicePayment();
            $recarringInvoicePayment->fill($request->only('total_amount','package_payment_method_id','received_date'));
            $recarringInvoicePayment->package_recarring_invoice_id = $recarringInvoice->id;
            $recarringInvoicePayment->save();
        }
    }


    private function recarringInvoiceUpdate($request , $invoice, $package, $modules_id){
        
        $recarringInvoice = PackageRecarringInvoice::where('invoice_id',$invoice->invoice_id)->firstOrFail();
        $recarringInvoice->fill($request->all());
        $recarringInvoice->invoice_id = $recarringInvoice->invoice_id;
        $this->storeRecarringOffer( $recarringInvoice ,$package);
        $recarringInvoice->status = @$request->status ?? 0;
        
        if($recarringInvoice->save()){

            $recarringInvoice->modules()->sync( $modules_id);

            $recarringInvoicePayment = PackageRecarringInvoicePayment::where('package_recarring_invoice_id',$recarringInvoice->id)->firstOrFail();
            $recarringInvoicePayment->fill($request->only('total_amount','package_payment_method_id','received_date'));
            $recarringInvoicePayment->package_recarring_invoice_id = $recarringInvoice->id;
            $recarringInvoicePayment->save();
        }
    }


    private function storeOffer($invoice,$package){

        $invoice->title = $package->title;
        $invoice->price = $package->price;
        $invoice->package_duration_id = $package->duration;
        $invoice->offer = $package->offer;
        $invoice->offer_price = $package->offer_price;
        $invoice->offer_discount = $package->offer_discount;
        $invoice->offer_duration = $package->offer_duration;
        $invoice->offer_status = $package->offer_status;
        $invoice->offer_start_date = $package->offer_start_date;
    }


    private function storeRecarringOffer($recarringInvoice ,$package){
        $recarringInvoice->title    = $package->title;
        $recarringInvoice->price    = $package->price;
        $recarringInvoice->duration = $package->duration;
        $recarringInvoice->offer    = $package->offer;
        $recarringInvoice->offer_price = $package->offer_price;
        $recarringInvoice->offer_discount = $package->offer_discount;
        $recarringInvoice->offer_duration = $package->offer_duration;
        $recarringInvoice->offer_status = $package->offer_status;
        $recarringInvoice->offer_start_date = $package->offer_start_date;
    }


    public function sentInvoiceByMail($invoice_id){

        $invoice = PackageInvoice::with(['client','package','packageInvoicePayment','packageDuration'])->findOrFail($invoice_id);
        $data = [
            'invoice' => $invoice,
            'settings' => Setting::first()
        ];
        $pdf = PDF::loadView('subcription::pdf.invoice', $data);

        Storage::put('pdf/invoice.pdf', $pdf->output());
        $data = array(
            'email'         => $invoice->client?->client_email,
            'form_address'  => 'tuhinsorker92@gmail.com',
            'file'          => Storage::path('pdf/invoice.pdf')
        );

        Mail::send('subcription::pdf.email', $data, function($message) use ($data){
            $message->to($data['email']);
            $message->from($data['form_address']);
            $message->subject('Your Next Payment Invoice');
            $message->attach($data['file']);
        });

        if(Storage::exists('pdf/invoice.pdf')){
             Storage::delete('pdf/invoice.pdf');
        }

        
    }


}
