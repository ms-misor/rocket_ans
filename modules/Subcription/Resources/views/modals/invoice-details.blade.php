<!-- Modal -->
<div class="modal fade" id="invoice-{{ $invoice->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Subscription Invoice Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body row">


                <div class="col-12">
                   
                    <div class="card card-body p-5" id="print-table">

                        <div class="row">
                            <div class="col text-center">
                                <img src="{{ (@$settings->app_logo) ? asset('public/'.@$settings->app_logo) : url('avatar.png')  }}" alt="..." class="img-fluid mb-4">
                                <h4 class="mb-5 fw-bold">{{$invoice->package->title}}</h4>
                            </div>
                        </div>

                        <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                    <td>
                                        <h6 class="text-uppercase text-muted fs-12 fw-semi-bold">Invoiced from</h6>
                                        <p class="text-muted mb-4">
                                            <strong class="text-body fs-16">{{ $settings->title }}</strong> 
                                            <br/>{{ $settings->email }} <br/>
                                            {!! $settings->address !!}
                                        </p>
                                        <h6 class="text-uppercase text-muted fs-12 fw-semi-bold">Invoiced ID</h6>
                                        <p class="mb-4">{{ $invoice->invoice_id }}</p>
                                    </td>
                                    <td class="text-end">
                                        <h6 class="text-uppercase text-muted fs-12 fw-semi-bold">Invoiced to</h6>
                                        <p class="text-muted mb-4">
                                            <strong class="text-body fs-16">{{ dataPrint($invoice->client,'client_name') }}</strong> 
                                            <br>Email : {{ dataPrint($invoice->client,'client_email') }} <br/>
                                            Phone : {{ dataPrint($invoice->client,'client_phone') }} <br/>
                                            {!! dataPrint($invoice->client,'client_address') !!}
                                        </p>
                                        {{-- <h6 class="text-uppercase text-muted fs-12 fw-semi-bold"> Due date</h6>
                                        <p class="mb-4"><time datetime="2018-04-23">Apr 23, 2018</time></p> --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="table-responsive-sm">
                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Module name</th>
                                    </tr>
                                </thead>

                                
                                <tbody>
                                    @foreach($invoice->modules as $key => $module)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><div >{{ ucwords($module->name) }}</div></td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>


                        <table class="table table-clear" style="width: 100%; display:flex; justify-content: end; ">
                            <tbody>

                                {{-- <tr>
                                    <td>{{  $invoice->packageInvoicePayment->packagePaymentMethod->title }}</td>
                                    <td>{{  $invoice->packageInvoicePayment->total_amount }}</td>
                                    <td>{{  $invoice->bill_start_date }}</td>
                                    <td>{{  $invoice->packageInvoicePayment->received_date }}</td>
                                    <td>
                                        @if($invoice->payment_status == 0)
                                                            <span class="badge bg-warning pending">Pending</span>
                                        @elseif($invoice->payment_status == 1)
                                            <span class="badge bg-success complete">Complete</span>
                                        @elseif($invoice->payment_status == 2)
                                            <span class="badge bg-danger">Incomplete</span>
                                        @endif
                                    </td>
                                </tr> --}}

                                <tr>
                                    <td>
                                        <strong>Package Price</strong>
                                    </td>
                                    <td>{{ $invoice->price }} / month</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Buy Package Duration</strong>
                                    </td>
                                    <td>{{ @$invoice->packageDuration->title }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Sub Total</strong>
                                    </td>
                                    <td>{{ $invoice->price*@$invoice->packageDuration->unit }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>Offer Price</strong>
                                    </td>
                                    <td>{{ $invoice->offer_price }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Offer Discount</strong>
                                    </td>
                                    <td>{{ $invoice->offer_discount }}</td>
                                </tr>

                                <tr>

                                    <td>
                                        <strong>Grand Total</strong>
                                    </td>

                                    <td>
                                        <strong>{{  $invoice->total_amount }}</strong>
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <strong>Payment Status</strong>
                                    </td>
                                    <td>
                                        @if($invoice->payment_status == 0)
                                                            <span class="badge bg-warning pending">Pending</span>
                                        @elseif($invoice->payment_status == 1)
                                            <span class="badge bg-success complete">Complete</span>
                                        @elseif($invoice->payment_status == 2)
                                            <span class="badge bg-danger">Incomplete</span>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
        </div>


        <div class="modal-footer">
            <button type="button" id="btn" class="btn btn-success me-2" value="Print Invoice" onclick="printContent('print-table')">
                <i class="typcn typcn-printer me-1"></i>Print Invoice
            </button>

          <button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

