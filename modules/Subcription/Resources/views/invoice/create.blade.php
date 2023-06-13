@extends('layouts.backend')
@push('css')
@endpush

@section('content')
    <!--/.Content Header (Page header)-->
     <div class="body-content">

        

        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">Create Order</h6>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('packages-invoices.index') }}"  class="btn btn-success btn-sm mr-1"><i class="fas fa-list mr-1"></i>Invoice List</a>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('packages-invoices.store') }}" method="POST">
                        @csrf

                        <div class="card-body row">
                            <div class="card-body col-md-6" style="border-right:2px solid #b2bdb5">

                                <div class="mt-3 row">
                                    <label for="Client" class="col-sm-3 col-form-label fw-semi-bold">Client<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="client_id" class="form-select mySelect2First">
                                            <option value="">Select Client</option>
                                                @foreach($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                                @endforeach
                                            </select>
                                        @if($errors->has('client_id'))
                                            <div class="error text-danger">{{$errors->first('client_id')}}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label for="Package Type" class="col-sm-3 col-form-label fw-semi-bold">Package Type<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="package_type" class="form-select mySelect2First loadPackages">
                                            <option value="">Select a Option</option>
                                            <option value="1">Merchandise</option>
                                            <option value="2">Sales</option>
                                        </select>
                                        @if($errors->has('package_type'))
                                            <div class="error text-danger">{{$errors->first('package_type')}}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Package<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="package_id" class="form-select mySelect2First loadPackageModule">
                                            <option value="">Select package</option>
                                               
                                        </select>
                                            @if($errors->has('package_id'))
                                                <div class="error text-danger">{{$errors->first('package_id')}}</div>
                                            @endif
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Module<span class="text-danger">*</span></label>
                                    <div class="col-sm-8" id="getModules">
                                        
                                    </div>
                                </div>



                                <div class="mt-3 row">
                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Duration<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="package_duration_id" class="form-select mySelect2First" id="package_duration_id" onchange="calculation()">
                                            @foreach($packageDurations as $duration)
                                                <option value="{{ $duration->id }}">{{ $duration->title }}</option>
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
                                                    @if ($method->id!=3)
                                                        <option value="{{ $method->id }}" >{{ $method->title }}</option> 
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if($errors->has('package_payment_method_id'))
                                                <div class="error text-danger">{{$errors->first('package_payment_method_id')}}</div>
                                            @endif
                                    </div>
                                </div>

                                <input type="hidden" name="payment_status" value="1">
                                
                                
                                {{-- <div class="mt-3 row">
                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Payment Status<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="payment_status" class="form-select">
                                                <option value="">Select a Option</option>
                                                <option value="0" >Pending</option>
                                                <option value="1" >complete</option>
                                                <option value="2" >Incomplete</option>
                                            </select>
                                        @if($errors->has('payment_status'))
                                            <div class="error text-danger">{{$errors->first('payment_status')}}</div>
                                        @endif
                                    </div>
                                </div> --}}

                            </div>

                            <div class="card-body col-md-6">
                                <div class="mt-3 row">
                                    <label class="col-sm-3 col-form-label fw-semi-bold">Invoice Date<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="invoice_date" type="date" value="{{old('invoice_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" id="example-date-input">
                                        @if($errors->has('invoice_date'))
                                            <div class="error text-danger">{{$errors->first('invoice_date')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 row">
                                    <label class="col-sm-3 col-form-label fw-semi-bold">Bill Start Date<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="bill_start_date" type="date" value="{{old('bill_start_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" id="example-date-input">
                                        @if($errors->has('bill_start_date'))
                                            <div class="error text-danger">{{$errors->first('bill_start_date')}}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label for="price" class="col-sm-3 col-form-label">Total Amount</label>
                                    <div class="col-sm-8">
                                        <input class="form-control total_amount" type="number" name="total_amount" disabled placeholder="Enter Total Amount" readonly>
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label class="col-sm-3 col-form-label fw-semi-bold">Received Date</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="received_date" type="date"  id="example-date-input">
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <label for="gio_long" class="col-sm-3 col-form-label fw-semi-bold"> </label>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input type="checkbox" name="status" id="status" value="1" class="form-check-input">
                                            <label class="form-check-label" for="status">Auto Renewal Active</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="p-2 border bg-light text-center">Calculation</div>

                                    <table class="table table-bordered table-sm text-center">

                                        <tbody>


                                            <tr>
                                                <td class="px-0">
                                                    Package Price
                                                </td>
                                                <td class="px-0 text-end" id="pprice">0</td>
                                            </tr>

                                            <tr>
                                                <td class="px-0">
                                                    Offer Amount
                                                </td>
                                                <td class="px-0 text-end" id="oprice">0</td>
                                            </tr>


                                            <tr id="oda">
                                                <td class="px-0">
                                                    Offer Discount Amount
                                                </td>
                                                <td class="px-0 text-end" id="odis">0</td>
                                            </tr>

                                            <tr>
                                                <td class="px-0 border-top border-top-2">
                                                    <strong>Total amount </strong>
                                                </td>
                                                <td colspan="2" class="px-0 text-end border-top border-top-2">
                                                    <span class="fs-16 fw-semi-bold" id="tamount">0 </span>
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
        </div><br>


        <div class="row" id="flush-collapseOne" >
            <div class="col-12 pe-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">Details</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="container overflow-hidden" id="packageInfo">
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div><!--/.body content-->

    <script>

        $("#flush-collapseOne").hide();
        $("#oda").hide();



        
        $('body').on('change', '.loadPackages', function(e) {

            var package_type = $(this).val();

            $.ajax({
                type: 'GET',
                url: "{{route('get-packages')}}",
                data: {"_token": "{{ csrf_token() }}","package_type":package_type},
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);
                    $('.loadPackageModule').html(res.packages);
                },
                error: function() {
                }
            });
        });


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
@endpush
