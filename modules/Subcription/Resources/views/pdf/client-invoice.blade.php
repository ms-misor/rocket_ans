<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Database Invoice</title>

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


	<div style="max-width: 980px;margin: 50px auto;">

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="card" style="border: 1px solid #9f9f9f; overflow: hidden; padding: 50px; position: relative">
						<div style="position: absolute;padding-top: 25px; padding-bottom: 25px; text-transform: uppercase; text-align: center;background-color: #2fab2b!important; font-weight: 700; right: -150px; top: 30px; min-width: 500px; font-size: 28px; transform: rotate(32deg); border: 4px solid #2ee535; color: #fff">Paid</div>
						<div class="align-items-center d-flex justify-content-between mb-5">
							<div class="d-block">
								<img src="http://64.225.72.133/public/photo_2022-06-30_17-48-49.jpg" alt="">
							</div>
						</div>
						<div class="d-block mb-4" style="margin-bottom: 20px">
							<div class="d-block text-right" style="margin-top: 70px">
								<h4 style="margin-top: 5px; margin-bottom: 5px">Database Mart LLC</h4>
								<h5 style="margin-top: 5px; margin-bottom: 5px; font-size: 15px; font-weight: 400">257 Westwood DR.</h5>
								<h5 style="margin-top: 5px; margin-bottom: 5px; font-size: 15px; font-weight: 400">League City, TXX02563</h5>
							</div>
						</div>
						<div class="d-block p-4" style="background: #efefef; padding: 25px; margin-bottom: 30px">
							<h4 style="margin-top: 0; margin-bottom: 10px; font-size: 22px">Invoice #4053269</h4>
							<p style="margin-bottom: 0; margin-top: 5px">Invoice Date: 01/03/22</p>
							<p style="margin-bottom: 0; margin-top: 5px">Due Date: 01/10/22</p>
						</div>
						<div class="d-block my-5" style="margin-top: 25px; margin-bottom: 25px">
							<h5 style="font-size: 18px; margin-bottom: 8px">Invoiced To</h5>
							Md. Humayun Bulbul <br>
							461, South Monipur, <br>
							Mirpur <br>
							Dhaka, dhaka, 1216 <br>
							Bangladesh
						</div>

						<table class="table table-bordered">
							<thead>
								<tr class="bg_grey">
									<th scope="col">Description</th>
									<th scope="col" class="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										Express Hyper-V (SSD + SATA) - IpacSoft.IpacSoft.com (01/10/2022 - 07/09/2022)- Part 2 <br>
										Operating System: Windows Server 2019 Standard Edition x64 <br>
										Database: SQL Server 2019 Express Edition <br>
										Cisco Hardware Firewall: None <br>
										Dedicated IPs: 1 IP (If you need extra IPs, please contact us.) <br>
										Remote Datacenter Backup: None <br>
										Management Plan: None <br>
										Extra SSD Space: None <br>
										Extra SATA Space: None <br>
									</td>
									<td class="text-center">$39.94 USD</td>
								</tr>
								<tr>
									<td>Late Fee (Added 01/14/2022) $8.99 USD</td>
									<td class="text-center">$8.99 USD</td>
								</tr>
								<tr class="bg_grey">
									<td class="text-right"><strong>Sub-total</strong></td>
									<td class="text-center">$48.93 USD</td>
								</tr>
								<tr class="bg_grey">
									<td class="text-right"><strong>Credit</strong></td>
									<td class="text-center">$0.00 USD</td>
								</tr>
								<tr class="bg_grey">
									<td class="text-right"><strong>Total</strong></td>
									<td class="text-center">$48.93 USD</td>
								</tr>
							</tbody>
						</table>

						<h5 class="my-4" style="font-size: 20px">Transactions</h5>

						<table class="table table-bordered mb-5">
							<thead>
								<tr class="bg_grey">
									<th scope="col" class="text-center">Transaction Date</th>
									<th scope="col" class="text-center">Gateway</th>
									<th scope="col" class="text-center">Transaction ID</th>
									<th scope="col" class="text-center">Amount</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center">01/15/2022</td>
									<td class="text-center">Credit Cart</td>
									<td class="text-center">txn_3KIE9AEYd98Et9Z314R3DLAu</td>
									<td class="text-center">$48.93 USD</td>
								</tr>
							</tbody>
						</table>

						<div class="text-center">
							<p class="mb-0">PDF Generated on 01/15/2022</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

</body>
