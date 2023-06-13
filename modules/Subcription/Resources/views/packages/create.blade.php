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
                                <h6 class="fs-17 fw-semi-bold mb-0">{{  @$package ? 'Edit' : 'Add' }} Package</h6>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('packages.index') }}"  class="btn btn-success btn-sm mr-1"><i class="fas fa-list mr-1"></i>Package List</a>
                            </div>
                        </div>
                    </div>
                        <form action="{{ @$package ? route('packages.update',$package->id) : route('packages.store') }}" method="POST">
                            @csrf
                            @if(@$package)
                                @method('PATCH')
                            @endif
                            <div class="card-body row">
                                <div class="card col-md-6 row">
                                        <div class="card-header">
                                            <h5 style="font-weight:bold">Package</h5>
                                        </div>
                                        <div class="card-body">

                                                <div class="mt-3 row">
                                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Title<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="title" id="title" value="{{ @$package->title }}" placeholder="Enter Title">
                                                        @if($errors->has('title'))
                                                        <div class="error text-danger">{{$errors->first('title')}}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3 row">
                                                    <label for="price" class="col-sm-3 col-form-label">Price<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="number" min="0" id="price"  name="price" value="{{ @$package->price }}" placeholder="Enter Price">
                                                        @if($errors->has('price'))
                                                        <div class="error text-danger">{{ $errors->first('price') }}</div>
                                                        @endif
                                                    </div>
                                                </div>


                                                

                                                <div class="mt-3 row">
                                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Module<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">

                                                        @foreach($modules as $module)
                                                            <div class="form-check form-check-inline">

                                                                @if(in_array($module->id,$modules_id))
                                                                    <input class="form-check-input cc" name="module_id[]" checked  type="checkbox" id="mid_{{ $module->id }}" value="{{ $module->id }}">
                                                                @else
                                                                    <input class="form-check-input cc" name="module_id[]"  type="checkbox" id="mid_{{ $module->id }}" value="{{ $module->id }}">
                                                                @endif
                                                                <label class="form-check-label" for="mid_{{ $module->id }}">{{ $module->name }}</label>
                                                            </div>
                                                        @endforeach 

                                                        {{-- <select name="module_id[]"  class="form-control placeholder-single"   multiple>
                                                            <option value="">Select Module</option>
                                                             @foreach($modules as $module)
                                                                @if(in_array($module->id,$modules_id))
                                                                    <option value="{{ $module->id }}" selected>{{ $module->name }}</option>
                                                                @else
                                                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                                                @endif
                                                             @endforeach
                                                        </select> --}}
            
                                                        @if($errors->has('module_id'))
                                                        <div class="error text-danger">{{$errors->first('module_id')}}</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- <div class="mt-3 row">
                                                    <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Duration<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select name="duration" class="form-select mySelect2First">
                                                            <option value="1" {{@$package->duration==1?'selected':''}}>Monthly</option>
                                                        </select>

                                                        @if($errors->has('duration'))
                                                            <div class="error text-danger">{{$errors->first('duration')}}</div>
                                                        @endif
                                                    </div>
                                                </div> --}}
                                                

                                                {{-- <div class="mt-3 row">
                                                    <label for="duration" class="col-sm-3 col-form-label">Duration<span class="text-danger">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="number" name="duration" value="{{ @$package->duration }}" placeholder="Enter Duration">
                                                        @if($errors->has('duration'))
                                                        <div class="error text-danger">{{ $errors->first('duration') }}</div>
                                                        @endif
                                                    </div>
                                                </div> --}}


                                                <div class="mt-3 row">
                                                    <label for="gio_long" class="col-sm-3 col-form-label fw-semi-bold "> Status </label>
                                                    <div class="col-sm-8 mt-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="status" id="status" value="1" class="form-check-input" {{ @$package->status == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="status">Is Package Active</label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                </div>


                                <div class="card col-md-6 row">
                                        <div class="card-header">
                                            <h5 style="font-weight:bold">Package Offer</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mt-3 row">
                                                <label for="title" class="col-sm-3 col-form-label fw-semi-bold">Offer Title</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="text" name="offer" id="offer_title" value="{{ @$package->offer }}" placeholder="Enter Offer Title">
                                                </div>
                                            </div>
                                            <div class="mt-3 row">
                                                <label for="price" class="col-sm-3 col-form-label">Offer Price</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="number" name="offer_price" id="offer_price" value="{{ @$package->offer_price }}" placeholder="Enter Offer Price">
                                                </div>
                                            </div>
                                            <div class="mt-3 row">
                                                <label for="duration" class="col-sm-3 col-form-label">Offer Discount</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="number" name="offer_discount" value="{{ @$package->offer_discount }}" placeholder="Enter Offer Discount">
                                                </div>
                                            </div>
                                            <div class="mt-3 row">
                                                <label for="duration" class="col-sm-3 col-form-label">Offer Start Date <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="date"  id="example-date-input" name="offer_start_date" value="{{ @$package->offer_start_date }}" placeholder="Enter Offer Duration">
                                                    @if($errors->has('offer_start_date'))
                                                        <div class="error text-danger">{{ $errors->first('offer_start_date') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-3 row">
                                                <label for="duration" class="col-sm-3 col-form-label">Offer Duration</label>
                                                <div class="col-sm-8">
                                                    <input min="1"  class="form-control" type="number" name="offer_duration" value="{{ @$package->offer_duration }}" placeholder="Enter Offer Duration">
                                                    <span class="text-danger">How many days continue this offer?</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 row">
                                                <label for="gio_long" class="col-sm-3 col-form-label fw-semi-bold"> </label>
                                                <div class="col-sm-8">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="offer_status" id="offer_status" value="1" class="form-check-input" {{ @$package->offer_status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="offer_status">Is Offer Active</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
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

@endsection
@push('js')

<script>
    
    $('body').on('change', '#offer_price', function(e) {

        var offer_price = parseInt($(this).val());
        var price = parseInt($('#price').val());
        if(price<=offer_price){
            $(this).val('');
            toastr.warning('You can not enter offer prce then package price','Error!');
        }
           
    });
</script>

{{-- <script src="{{ asset('vendor/Outlet/assets/js/outlet.js') }}"></script> --}}
@endpush
