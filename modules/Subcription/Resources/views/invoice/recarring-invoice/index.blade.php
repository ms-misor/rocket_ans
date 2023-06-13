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
                                <h6 class="fs-17 fw-semi-bold mb-0">Recarring Invoice</h6>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('packages-invoices.index') }}"  class="btn btn-primary btn-sm mr-1">Back</a>
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
                                        <th>Package Price</th>
                                        <th>Package Duration</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($recarringInvoices as $key => $invoice)
                                        <tr>
                                            <td>#{{ $key + 1 }}</td>
                                            <td>{{ $invoice->invoice_id }}</td>
                                            <td>{{ $invoice->client->client_name??'---' }}</td>
                                            <td>{{ $invoice->package->title }}</td>
                                            <td>{{ $invoice->price??'---'}}</td>
                                            <td>{{ $invoice->duration??'---'}}</td>
                                            <td>{{ $invoice->packageRecarringInvoicePayment->total_amount}}</td>
                                            <td>
                                               @if($invoice->payment_status == 0)
                                                   <span class="badge bg-warning pending">Pending</span>
                                               @elseif($invoice->payment_status == 1)
                                                   <span class="badge bg-success complete">Complete</span>
                                               @elseif($invoice->payment_status == 2)
                                                   <span class="badge bg-danger">Incomplete</span>
                                               @endif
                                            </td>
                                            <td>
                                                @if($invoice->status == 0)
                                                   <span class="badge bg-danger">Inactive</span>
                                                @elseif($invoice->status == 1)
                                                   <span class="badge bg-success active">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-white btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#recarring-invoice-{{ $invoice->id }}"><i class="fa fa-eye"></i></a>
                                                 @include('subcription::modals.recarring-invoice-details')
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
<script src="{{ asset('public/sweetalert-script.js') }}"></script>
@endpush
