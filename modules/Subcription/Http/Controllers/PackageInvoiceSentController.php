<?php

namespace Modules\Subcription\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Role\Entities\Module;
use Modules\Subcription\Entities\Package;
use Modules\Client\Entities\Client;
use Modules\Subcription\Http\Requests\InvoiceRequest;
use Modules\Subcription\Entities\PackageInvoice;
use Modules\Subcription\Entities\PackagePaymentMethod;
use Modules\Subcription\Entities\PackageInvoicePayment;
use Modules\Subcription\Entities\PackageRecarringInvoice;
use Modules\Subcription\Entities\PackageRecarringInvoiceDetails;
use Modules\Subcription\Entities\PackageRecarringInvoicePayment;
use Modules\Subcription\Entities\PackageDuration;
use Illuminate\Support\Facades\Mail;
use Auth;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class PackageInvoiceSentController extends Controller
{

    public function sentInvoice()
    {

        $now = Carbon::now()->format('Y-m');
        $invoices = PackageInvoice::with('packageDuration')->cursor();

        foreach($invoices as $invoice){
           
            $this->commonRecarringInvoiceLogic($invoice);
          
            if($invoice->packageDuration->unit == 1){
                if(Carbon::parse($invoice->bill_start_date)->format('Y-m') < $now){
                    $this->commonRecarringInvoiceLogic($invoice);
                }
            }elseif($invoice->packageDuration->unit == 3){
                if(Carbon::parse($invoice->bill_start_date)->addMonth(3)->format('Y-m') < $now){
                    $this->commonRecarringInvoiceLogic($invoice);
                }
            }elseif($invoice->packageDuration->unit == 6){
                if(Carbon::parse($invoice->bill_start_date)->addMonth(6)->format('Y-m') < $now){
                    $this->commonRecarringInvoiceLogic($invoice);
                }
            }elseif($invoice->packageDuration->unit == 12){
                if(Carbon::parse($invoice->bill_start_date)->addMonth(12)->format('Y-m') < $now){
                    $this->commonRecarringInvoiceLogic($invoice);
                }
            }
        }

    }

    public function commonRecarringInvoiceLogic($invoice){

        
        $reInvoice = PackageRecarringInvoice::where('invoice_id' , $invoice->invoice_id)->latest('invoice_no')->firstOrFail();
        $recarringInvoice = new PackageRecarringInvoice();
        $recarringInvoice->bill_start_date = Carbon::now()->format('Y-m-d');
        $recarringInvoice->invoice_date = Carbon::now()->format('Y-m-d');
        $recarringInvoice->invoice_id = $invoice->invoice_id;
        $this->storeRecarringRestField($recarringInvoice , $reInvoice);
        $recarringInvoice->status = $reInvoice->status;

        if($recarringInvoice->save()){

            foreach($reInvoice->modules as $module){
                $recarringInvoiceDetails = new PackageRecarringInvoiceDetails();
                $recarringInvoiceDetails->package_recarring_invoice_id = $recarringInvoice->id;
                $recarringInvoiceDetails->module_id = $module->id;
                $recarringInvoiceDetails->save();
            }
            $recarringInvoicePayment = new PackageRecarringInvoicePayment();
            $recarringInvoicePayment->total_amount =  $reInvoice->packageRecarringInvoicePayment->total_amount ?? 0;
            $recarringInvoicePayment->package_payment_method_id =  $reInvoice->packageRecarringInvoicePayment->package_payment_method_id;
            $recarringInvoicePayment->received_date =  $reInvoice->packageRecarringInvoicePayment->received_date;
            $recarringInvoicePayment->package_recarring_invoice_id = $recarringInvoice->id;
            $recarringInvoicePayment->save();
            $this->sentInvoiceByMail($recarringInvoice);
        }
    }


    public function storeRecarringRestField($recarringInvoice ,$reInvoice){

        $recarringInvoice->package_id           =   $reInvoice->package_id;
        $recarringInvoice->client_id            =   $reInvoice->client_id;
        $recarringInvoice->package_duration_id  =   $reInvoice->package_duration_id;
        $recarringInvoice->payment_status       =   $reInvoice->payment_status;
        $recarringInvoice->title                =   $reInvoice->title;
        $recarringInvoice->price                =   $reInvoice->price;
        $recarringInvoice->duration             =   $reInvoice->duration;
        $recarringInvoice->offer                =   $reInvoice->offer;
        $recarringInvoice->offer_price          =   $reInvoice->offer_price;
        $recarringInvoice->offer_discount       =   $reInvoice->offer_discount;
        $recarringInvoice->offer_duration       =   $reInvoice->offer_duration;
        $recarringInvoice->offer_status         =   $reInvoice->offer_status;
        $recarringInvoice->offer_start_date     =   $reInvoice->offer_start_date;
    }

    public function sentInvoiceByMail($reInvoice){

        $recarringInvoice = PackageRecarringInvoice::findOrFail($reInvoice->id);

        $data = [
            'recurringInvoice' => $recarringInvoice
        ];
        $pdf = PDF::loadView('subcription::pdf.client-invoice', $data);
        Storage::put('pdf/invoice.pdf', $pdf->output());
        $data = array(
            'email' => 'tuhinsorker92@gmail.com',
            'form_address' => 'tuhinsorker92@gmail.com',
            'file' => Storage::path('pdf/invoice.pdf')
        );

        // dd($data);

        //  $path = Storage::path('pdf/invoice.pdf');
        // dd($path);
        Mail::send('subcription::pdf.email', $data, function($message) use ($data){
            $message->to($data['email']);
            $message->from($data['form_address']);
            $message->subject('Your Next Payment Invoice');
            $message->attach($data['file']);
        });

        // if(Storage::exists('pdf/invoice.pdf')){
        //      Storage::delete('pdf/invoice.pdf');
        // }

        dd('success');
    }
}
