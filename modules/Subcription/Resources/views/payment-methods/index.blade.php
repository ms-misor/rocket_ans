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
                                <h6 class="fs-17 fw-semi-bold mb-0">Payment Methods</h6>
                            </div>

                            <div class="text-end">
                                {{-- <a href="javascript:void(0)"  class="btn btn-success btn-sm mr-1" data-bs-toggle="modal" data-bs-target="#payment"><i class="fas fa-plus mr-1"></i>Add New</a> --}}
                                @include('subcription::modals.create-payment-methods')
                            </div>
                            
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive1">
                            <table class="table display table-bordered table-striped table-hover bg-white m-0 card-table text-center">
                                <thead>

                                    <tr>
                                        <th width="10%">SL.</th>
                                        <th width="60%">Title</th>
                                        <th width="15%">Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paymentMethods as $key => $payment)
                                        <tr>
                                            <td>#{{ $key + 1 }}</td>
                                            <td>{{ $payment->title }}</td>
                                            <td>
                                                @if($payment->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @elseif ($payment->status == 0)
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#payment-{{ $payment->id }}">
                                                    <i class='far fa-edit'></i>
                                                    </button>

                                                @include('subcription::modals.payment-methods')
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
