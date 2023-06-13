<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Client Invoice</title>

	<!-- Bootstrap -->
	<link href="assets/themify-icons/themify-icons.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');


		body {
			margin: 0;
			font-family: 'Roboto', sans-serif;
			background-color: #fff;
		}

		.mt-0 {
			margin-top: 0;
		}

		.d-block {
			display: block;
		}

		.text-right {
			text-align: right
		}

		.text-center {
			text-align: center
		}

		.text-completed {
			color: #32ba7c;
			font-weight: 600;
		}

		.bg_grey {
			background-color: #efefef !important;
		}

		.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
		}

		.table-bordered {
			border: 1px solid #eeeeee;
			border-spacing: 0;
		}

		.table td,
		.table th {
			padding: 5px 18px;
		}

		.table-bordered td,
		.table-bordered th {
			border: 1px solid #8d8d8d;
		}

		.table thead th {
			border-bottom: 1px solid #bababa;
		}

	</style>

</head>

<body>


	{{-- @dd($invoice); --}}

	<div style="max-width: 980px;margin: 50px auto;">

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="card" style="border: 1px solid #9f9f9f; overflow: hidden; padding: 50px; position: relative">
						{{-- <div style="position: absolute;padding-top: 25px; padding-bottom: 25px; text-transform: uppercase; text-align: center;background-color: #2fab2b!important; font-weight: 700; right: -150px; top: 30px; min-width: 500px; font-size: 28px; transform: rotate(32deg); border: 4px solid #2ee535; color: #fff">Paid</div> --}}
						<div class="align-items-center d-flex justify-content-between mb-5">
							<div class="d-block">
								<img src="http://64.225.72.133/gdm/public//uploads/app-setting/202206070456alpha-logo.png" alt="">
							</div>
						</div>
						
						<div class="d-block mb-4" style="margin-bottom: 20px">
							<div class="d-block text-right" style="margin-top: 70px">
								<h4 style="margin-top: 5px; margin-bottom: 5px">{{ $settings->title }}</h4>
								<h5 style="margin-top: 5px; margin-bottom: 5px; font-size: 15px; font-weight: 400">{{ $settings->email }} </h5>
								<h5 style="margin-top: 5px; margin-bottom: 5px; font-size: 15px; font-weight: 400"> {!! $settings->address !!}</h5>
							</div>
						</div>

						<div class="d-block p-4" style="background: #efefef; padding: 25px; margin-bottom: 30px">
							<h4 style="margin-top: 0; margin-bottom: 10px; font-size: 22px">Invoice #{{$invoice->invoice_id}}</h4>
							<p style="margin-bottom: 0; margin-top: 5px">Invoice Date: {{$invoice->invoice_date}}</p>
						</div>
                        
						<div class="d-block my-5" style="margin-top: 25px; margin-bottom: 25px">
							<h5 style="font-size: 18px; margin-bottom: 8px">Invoiced To</h5>
							{{$invoice->client?->client_name}} <br>
							{{ $invoice->client?->client_email }}<br/>
							{{ $invoice->client?->client_phone }}<br/>
							{!! $invoice->client?->client_address !!}
						</div>


                            <table class="table table-border">

                                <thead>
                                    <tr>
                                        <th class="text-left">#SL</th>
                                        <th class="text-right">Module name</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($invoice->package?->modules as $key => $module)
										<tr>
											<td class="text-left">{{$key+1}}</td>
											<td class="text-right">{{ ucwords($module->name) }}</td>
										</tr>
                                   @endforeach
                                </tbody>
                            </table>
							<hr>
                      


                        <table class="table table-border" style="width: 100%; justify-content: end; ">
                            <tbody>

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

						<div class="text-center">
							<p class="mb-0">PDF Generated on {{date('Y-m-d')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

</body>
