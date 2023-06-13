@extends('layouts.backend')
@push('css')
<style>
   .complete{
        padding-left:10px;
        padding-right:10px;
   }
   .pending{
        padding-left:14px;
        padding-right:14px;
   }
   .active{
    padding-left:11px;
        padding-right:11px;
   }
</style>
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
                            <form action="{{route('packages-invoices.index')}}" method="GET" enctype="multipart/form-data" accept-charset="UTF-8">
                                <div class="row">                                    
                                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                                            <label class="col-form-label text-end fw-semi-bold">Client</label>
                                            <div class="col-12">
                                                <select name="client_id" class="form-control placeholder-single">
                                                    <optgroup label="Select Client">
                                                        <option value="">---</option>
                                                        @foreach($clients as $key => $item)
                                                        <option value="{{ $item->id }}" {{ @$request->client_id == $item->id ? 'selected' : '' }}>{{ @$item->client_name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                                            <label class="col-form-label text-end fw-semi-bold">Package</label>
                                            <div class="col-12">
                                                <select name="package_id" class="form-control placeholder-single">
                                                    <optgroup label="Select Package">
                                                        <option value="">---</option>
                                                        @foreach($packages as $key => $item)
                                                        <option value="{{ $item->id }}" {{ @$request->package_id == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-3 mb-3">
                                            <label class="col-form-label text-end fw-semi-bold">Date Range</label>
                                            <div class="col-12">
                                                <input class="form-control mydaterenge" type="text" name="mydaterenge" placeholder="Select Date Range">
                                            </div>
                                        </div>
                                        
                                        <div class="col-3 mb-3">
                                            <label class="col-form-label text-end fw-semi-bold"></label>
                                            <div class="col-12 " style="margin-top:15px;">
                                                <button class="btn btn-primary me-2 go" type="submit">Go</button>
                                                <button class="btn btn-danger reset">Reset</button>
                                            </div>
                                        </div>

                                        
                                </div>
                            </form>
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
                                <h6 class="fs-17 fw-semi-bold mb-0">Subscription</h6>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('packages-invoices.create') }}"  class="btn btn-success btn-sm mr-1"><i class="fas fa-plus mr-1"></i>Add Invoice</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive1">
                            <table id="example" class="text-center table display table-bordered table-striped table-hover bg-white m-0 card-table">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Invoice ID</th>
                                        <th>Client Name</th>
                                        <th>Package Name</th>
                                        <th>Package Type</th>
                                        <th>Package Price</th>
                                        <th>Package Buy Duration</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Invoice Date</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($invoices as $key => $invoice)

                                        <tr>
                                            <td>#{{ $key + 1 }}</td>
                                            <td>{{ $invoice->invoice_id }}</td>
                                            <td>{{ dataPrint($invoice->client,'client_name')}}</td>
                                            <td>{{ dataPrint($invoice->package,'title') }}</td>
                                            <td>
                                                @if($invoice->package->package_type == 1)
                                                    <span class="badge bg-warning pending">Merchandise</span>
                                                @elseif($invoice->package->package_type == 2)
                                                    <span class="badge bg-success">Sales</span>
                                                @endif
                                             </td>

                                            <td>{{ @$invoice->price??'---'}}</td>
                                            <td>{{ dataPrint($invoice->packageDuration,'title')}}</td>
                                            <td>{{ @$invoice->total_amount }}</td>
                                            
                                            <td>
                                               @if($invoice->payment_status == 0)
                                                   <span class="badge bg-warning pending">Pending</span>
                                               @elseif($invoice->payment_status == 1)
                                                   <span class="badge bg-success complete">Complete</span>
                                               @elseif($invoice->payment_status == 2)
                                                   <span class="badge bg-danger">Incomplete</span>
                                               @endif
                                            </td>
                                            <td>{{$invoice->invoice_date}}</td>
                                            <td>
                                                {{-- <a href="{{ route('recarring-invoices.show',$invoice->invoice_id) }}" class="text-white btn btn-success btn-sm"><i class="fa fa-list"></i></a> --}}
                                                <a href="{{ route('packages-invoices.edit',$invoice->id) }}" class="text-white btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a onclick="showInvoiceDetail({{ $invoice->id }})" href="javascript:void(0)" class="text-white btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#invoice-{{ $invoice->id }}" title="View"><i class="fa fa-eye"></i></a>
                                                @include('subcription::modals.invoice-details',['invoice' => $invoice])
                                                <a href="javascript:void(0)" class="text-white btn btn-sm btn-danger delete-confirm" data-route="{{ route('packages-invoices.destroy',$invoice->id) }}" data-csrf="{{csrf_token()}}" title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.body content-->

@endsection
@push('js')
    <script>
        function showInvoiceDetail(val){
            $('#invoice-'+val).modal('show');
        }
        $( document ).ready(function() {
            $('.reset').click(function (e) {
                e.preventDefault();
                $('.accordion-item').find('select').val('').trigger('change');
                $('.mydaterenge').val('');
            });

        });
    </script>
    <script src="{{ asset('public/sweetalert-script.js') }}"></script>
@endpush
