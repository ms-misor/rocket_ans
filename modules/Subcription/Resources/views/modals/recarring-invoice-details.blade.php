<!-- Modal -->
<div class="modal fade" id="recarring-invoice-{{ $invoice->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Subscription Invoice Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
           <div class="container overflow-hidden pb-3">
                <div class="row gy-5 text-center">
                    <div class="col-12">
                        <div class="p-2 border bg-light">
                            <h4><span class="fw-bold">Client:&nbsp;{{ $invoice->client->client_name }}</span></h4>
                            <p><strong>Invoice ID:</strong> {{ $invoice->invoice_id }}</p>
                        </div>
                    </div>
                </div>
            </div>
           <div class="container overflow-hidden">
            <div class="row gy-2">
                <div class="col-6">
                    <div class="p-2 border bg-light">Package</div>
                    <div class="col-md-12">
                    <table class="table table-bordered table-sm ">
                        <tr>
                            <td width="50%" class="fw-bold">Invoice No</td>
                            <td >{{ $invoice->invoice_no }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Title</td>
                            <td >{{ $invoice->title }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Price</td>
                            <td >{{ $invoice->price }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Duration</td>
                            <td >{{ $invoice->price }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Invoice Date</td>
                            <td>{{ $invoice->invoice_date }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Package Duration</td>
                            <td>{{ $invoice->packageDuration->title }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status</td>
                            <td>
                                @if($invoice->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @elseif ($invoice->status == 0)
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Created By</td>
                            <td >{{ $invoice->createdBy->name??'---'}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Updated By</td>
                            <td >{{ $invoice->updatedBy->name??'---'}}</td>
                        </tr>
                    </table>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 border bg-light">Package Offer</div>
                    <table class="table table-bordered table-sm text-center">
                        <tr>
                            <td width="50%" class="fw-bold ">Title</td>
                            <td >{{ $invoice->offer }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Price</td>
                            <td>{{ $invoice->offer_price }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Discount</td>
                            <td>{{ $invoice->offer_discount  }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Duration</td>
                            <td>{{ $invoice->offer_duration }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Offer Start Date</td>
                            <td>{{ $invoice->offer_start_date??'---' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status</td>
                            <td>
                                @if($invoice->offer_status == 1)
                                    <span class="badge bg-success">Active</span>
                                @elseif ($invoice->offer_status == 0)
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold">---</td>
                            <td >---</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">---</td>
                            <td >---</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">---</td>
                            <td >---</td>
                        </tr>
                    </table>
                </div>
                <div class="col-12">
                    <div class="p-2 border bg-light">Access Modules</div>
                    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 pt-1">
                        @foreach($invoice->modules as $module)
                        <div class="col">
                           <div class="p-2 border bg-light">{{ $module->name }}</div>
                        </div>
                        @endforeach
                     </div>
                </div>
                <div class="col-12 ">
                    <div class="p-2 mt-3 border bg-light">Payment</div>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Payment Type</th>
                            <th>Total Amount</th>
                            <th>Bill Start Date</th>
                            <th>Received Date</th>
                            <th>Payment Status</th>
                        </tr>
                        <tr>
                            <td>{{ $invoice->packageRecarringInvoicePayment->packagePaymentMethod->title }}</td>
                           <td>{{  $invoice->packageRecarringInvoicePayment->total_amount }}</td>
                            <td>{{  $invoice->bill_start_date }}</td>
                            <td>{{  $invoice->packageRecarringInvoicePayment->received_date }}</td>
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
                    </table>
                </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
