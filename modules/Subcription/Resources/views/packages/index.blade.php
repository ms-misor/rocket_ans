@extends('layouts.backend')
@push('css')
@endpush


@section('content')
    <!--/.Content Header (Page header)-->
     <div class="body-content">

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">Merchandiser Pricing Plan</h6>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('packages.create') }}"  class="btn btn-success btn-sm mr-1"><i class="fas fa-plus mr-1"></i> Add New Package</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row mb-4">
                        
                        @foreach($mpackages as $key => $package)

                            <div class="col-lg-4 mb-4">
                                
                                <div class="pricing-card basic-{{$key}}">
                                    <div class="pricing-header">
                                        <span class="plan-title">{{$package->title}}</span>
                                        <div class="edit-icon">
                                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-sm btn-warning text-end">
                                                <i class='far fa-edit'></i>
                                            </a>
                                        </div>
                                        <div class="price-circle">
                                            <span class="price-title">
                                                <small>$</small><span>{{$package->price-$package->offer_price}} </span>
                                            </span>
                                            <span class="info">{{$package->price}}</span>
                                            <small>{{$package->duration==1?'Monthly':'Yearly'}}</small>
                                        </div>
                                    </div>

                                    <ul>
                                        @foreach($modules as $module)
                                            @php
                                                $modules_id = $package->modules()->pluck('module_id')->toArray();
                                            @endphp

                                            @if(in_array($module->id,$modules_id))
                                            <li class="d-flex align-items-center justify-content-center"><i class="ti ti-check me-2 text-success"></i><span>{{ ucwords($module->name) }}</span></li>
                                            
                                            @else
                                            <li class="d-flex align-items-center justify-content-center"><i class="ti-close me-2 text-danger"></i><span>{{ ucwords($module->name) }}</span></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                
                                    <div class="buy-button-box">
                                        <a href="{{ route('packages-invoices.create') }}" class="buy-now">Purchase Now</a>
                                    </div>
                                </div>
{{-- 
                                <a href="{{ route('packages.edit', $package->id) }}" class="text-white btn btn-sm btn-success text-end">
                                    <i class='far fa-edit'></i>
                                </a> --}}

                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        
@endsection
@push('js')
<script src="{{ asset('public/sweetalert-script.js') }}"></script>
@endpush
