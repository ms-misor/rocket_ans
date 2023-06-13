@extends('layouts.backend')
@push('css')
@endpush

@section('content')
    <!--/.Content Header (Page header)-->
     <div class="body-content">

        <div class="row">
            <div class="col-12 pe-3">
                <div class="accordion accordion-flush px-0 mb-2" id="accordionFlushExample">
                    <div class="accordion-item">

                        <h2 class="accordion-header d-flex justify-content-end mb-3" id="flush-headingOne">
                            <button type="button" class="fs-17 filter-bt" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"><img  class="me-2 h-24" src="assets/dist/img/icons8-filter-30.png" alt="">Filter</button>
                        </h2>

                        <div id="flush-collapseOne" class="accordion-collapse collapse bg-white px-3" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="row">

                                <div class="col-4 mb-3">
                                <div class="col-4 mb-3">
                                    <label class="col-form-label text-end fw-semi-bold">Location</label>
                                    <div class="col-12">
                                        <select class="form-control placeholder-single">
                                            <optgroup label="Central Time Zone">
                                                <option value="AL">Alabama</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4 mb-3">
                                    <label class="col-form-label text-end fw-semi-bold">From date</label>
                                    <div class="col-12">
                                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="col-form-label text-end fw-semi-bold">To date</label>
                                    <div class="col-12">
                                        <input class="form-control" type="date" value="2019-08-19" id="example-date-input">
                                    </div>
                                </div>

                                <div class="col-3 mb-3">
                                    <button class="btn btn-primary me-2 go">Go</button>
                                    <button class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">Edit Invoice</h6>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('packages-invoices.index') }}"  class="btn btn-success btn-sm mr-1"><i class="fas fa-list mr-1"></i>Invoice List</a>
                            </div>
                        </div>
                    </div>
                        <form action="{{ route('packages-invoices.update',$invoice->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body row">
                                <div class="card-body col-md-6" style="border-right:2px solid #b2bdb5">
                                    <div class="mt-3 row">
                                        <label for="Client" class="col-sm-3 col-form-label fw-semi-bold">Client<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="client_id" class="form-select mySelect2First">
                                                <option value="">Select Client</option>
                                                 @foreach($clients as $client)
                                                    <option value="{{ $client->id }}" {{ $invoice->client_id ==  $client->id ? 'selected' : ''}}>{{ $client->client_name }}</option>
                                                 @endforeach
                                               </select>
                                            @if($errors->has('client_id'))
                                            <div class="error text-danger">{{$errors->first('client_id')}}</div>
                                            @endif
                                        </div>
                                    </div>
                               
                                    
                                    <div class="mt-3 row">
                                        <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Package<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select  class="form-select mySelect2First " disabled>
                                                <option value="">Select package</option>
                                                 @foreach($packages as $package)
                                                    <option value="{{ $package->id }}" {{ $invoice->package_id ==  $package->id ? 'selected' : ''}}>{{ $package->title }}</option>
                                                 @endforeach
                                               </select>
                                            @if($errors->has('package_id'))
                                            <div class="error text-danger">{{$errors->first('package_id')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Module<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="module_id[]" class="form-select mySelect2First" multiple disabled>
                                                <option value="">Select Module</option>
                                                 @foreach($modules as $module)
                                                    @if(in_array($module->id,$modules_id))
                                                       <option value="{{ $module->id }}" selected>{{ $module->name }}</option>
                                                    @endif
                                                 @endforeach
                                               </select>
                                            @if($errors->has('module_id'))
                                            <div class="error text-danger">{{$errors->first('module_id')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Package Duration<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="package_duration_id" class="form-select mySelect2First " id="package_duration_id" onchange="calculation()">
                                                <option value="">Select Package Duration</option>
                                                 @foreach($packageDurations as $duration)
                                                    <option value="{{ $duration->id }}" {{ $invoice->duration == $duration->id ? 'selected' : '' }}>{{ $duration->title }}</option>
                                                 @endforeach
                                               </select>
                                            @if($errors->has('package_duration_id'))
                                            <div class="error text-danger">{{$errors->first('package_duration_id')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Payment Method<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="package_payment_method_id" class="form-select">
                                                <option value="">Select a Option</option>
                                                @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" {{ $invoice->packageInvoicePayment->packagePaymentMethod->id == $method->id ? 'selected' : ''}}>{{ $method->title }}</option>
                                                @endforeach
                                               </select>
                                            @if($errors->has('package_payment_method_id'))
                                               <div class="error text-danger">{{$errors->first('package_payment_method_id')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-3 row">
                                        <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Payment Status<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="payment_status" class="form-select" disabled>
                                                    <option value="">Select a Option</option>
                                                    <option value="0" {{ $invoice->payment_status == 0 ? 'selected' : ''}}>Pending</option>
                                                    <option value="1" {{ $invoice->payment_status == 1 ? 'selected' : ''}}>complete</option>
                                                    <option value="2" {{ $invoice->payment_status == 2 ? 'selected' : ''}}>Incomplete</option>
                                               </select>
                                            @if($errors->has('payment_status'))
                                               <div class="error text-danger">{{$errors->first('payment_status')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label for="gio_long" class="col-sm-3 col-form-label fw-semi-bold"> </label>
                                        <div class="col-sm-8">
                                            <div class="form-check">
                                                <input type="checkbox" name="status" id="status" value="1" {{ $invoice->status == 1 ? 'checked' : ''}} class="form-check-input">
                                                <label class="form-check-label" for="status">Is Invoice Active</label>
                                            </div>
                                        </div>
                                    </div>


                                </div>



                                <div class="card-body col-md-6">
                                    <div class="mt-3 row">
                                        <label class="col-sm-3 col-form-label fw-semi-bold">Invoice Date<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="invoice_date" type="date" value="{{$invoice->invoice_date}}" id="example-date-input">
                                            @if($errors->has('invoice_date'))
                                                <div class="error text-danger">{{$errors->first('invoice_date')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label class="col-sm-3 col-form-label fw-semi-bold">Bill Start Date<span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="bill_start_date" type="date" value="{{ $invoice->bill_start_date }}" id="example-date-input">
                                            @if($errors->has('bill_start_date'))
                                                <div class="error text-danger">{{$errors->first('bill_start_date')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label for="price" class="col-sm-3 col-form-label">Total Amount</label>
                                        <div class="col-sm-8">
                                            <input class="form-control total_amount" type="number" name="total_amount" readonly  value={{ $invoice->packageInvoicePayment->total_amount }}>
                                        </div>
                                    </div>

                                    <div class="mt-3 row">
                                        <label class="col-sm-3 col-form-label fw-semi-bold">Received Date</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="received_date" type="date" value={{ $invoice->packageInvoicePayment->received_date }}  id="example-date-input">

                                        </div>
                                    </div>

                                    <hr>

                                <div class="p-2 border bg-light text-center">Calculation</div>

                                <input type="hidden" name="package_id" value="{{$invoice->package_id}}">
                                

                                <input type="hidden" id="package_price" value="{{$invoice->price}}">
                                <input type="hidden" id="package_duration" value="{{$invoice->duration}}">
                                <input type="hidden" id="offer_price" value="{{$invoice->offer_price}}">
                                <input type="hidden" id="offer_discount" value="{{$invoice->offer_discount}}">
                                
                                    <table class="table table-bordered table-sm text-center">
                                        <tbody>
                                            <tr>
                                                <td class="px-0">
                                                    Package Price
                                                </td>
                                                <td class="px-0 text-end" id="pprice">{{ $invoice->price }}</td>
                                            </tr>

                                            <tr>
                                                <td class="px-0">
                                                    Offer Amount
                                                </td>
                                                <td class="px-0 text-end" id="oprice">{{ $invoice->offer_price }}</td>
                                            </tr>


                                            <tr id="oda">
                                                <td class="px-0">
                                                    Offer Discount Amount
                                                </td>
                                                <td class="px-0 text-end" id="odis">{{ $invoice->offer_descount }}</td>
                                            </tr>

                                            <tr>
                                                <td class="px-0 border-top border-top-2">
                                                    <strong>Total amount </strong>
                                                </td>
                                                <td colspan="2" class="px-0 text-end border-top border-top-2">
                                                    <span class="fs-16 fw-semi-bold" id="tamount">{{ $invoice->packageInvoicePayment->total_amount }} </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>

       


    </div><!--/.body content-->


    
    <script>

        $("#flush-collapseOne").hide();
        $("#oda").hide();


        $('body').on('change', '.loadPackageModule', function(e) {
            var package_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: "{{route('get-package-info')}}",

                data: {"_token": "{{ csrf_token() }}","package_id":package_id},
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);

                    $('#packageInfo').html(res.packageinfo);
                    $('#getModules').html(res.modules);
                    $("#flush-collapseOne").show('1000');

                    calculation()
                },
                error: function() {
                }
            });
        });


        function calculation(){

            var duration = $('#package_duration_id').val();

            if(duration == 1){
                var qty = 1;
            }else if(duration == 2){
                var qty = 3;
            }else if(duration == 3){
                var qty = 6;
            } else if(duration == 4){
                var qty = 12;
            }

            var pacPrice    = $('#package_price').val();

            var offer_price  = $('#offer_price').val();
            var offer_discount = $('#offer_discount').val();

            if(qty>=12){
                var offerDisAmount = offer_discount*qty;
                var offerAmount = offer_price*qty;
                var total = (((pacPrice*qty)-offerAmount)-offerDisAmount);
                $("#oda").show();
            }else{
                var offerAmount = offer_price*qty;
                var total = ((pacPrice*qty)-offerAmount);
                $("#oda").hide();
            }

            $("#pprice").text(pacPrice);
            $("#oprice").text(offerAmount);
            $("#odis").text(offerDisAmount);
            $("#tamount").text(total);
            $(".total_amount").val(total);

        }



    </script>

@endsection
@push('js')
{{-- <script src="{{ asset('vendor/Outlet/assets/js/outlet.js') }}"></script> --}}
@endpush
