<?php
	/* Logged in session handling*/
	require "includes/validateLogin.php";
	$webaccount = isset($_SESSION["webaccount"])? $_SESSION["webaccount"]:"unknown";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require "includes/header.php" ?>
</head>
<body style="background:aliceblue">
	<?php require "includes/navbar.php" ?>
	<div class="container" style="margin-top:60px;">
		<div id="invoice-wrapper">
			<div id="searchModal-wrapper" style="padding:5px 0 10px 0">
				<div style="text-align:right">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceSearchModal">
						<span class="glyphicon glyphicon-search"></span> Search Invoices
					</button>
				</div>
				<div id="invoiceSearchModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="text-primary">Invoice Search</h4>
							</div>
							<div class="modal-body">
								<div class="form-horizontal">
									<div class="form-group form-group-sm">
										<label for="invoicenum" class="cntrol-label col-sm-3">Invoice Number</label>
										<div class="col-sm-6">
											<input type="number" id="invoicenum" class="form-control" min="0" max="999999999" autofocus>
										</div>
										<div class="col-sm-offset-3"></div>
									</div>
									<div class="form-group form-group-sm">
										<label for="datefrom" class="cntrol-label text-left col-sm-3">Date From</label>
										<div class="col-sm-6">
											<input type="date" id="datefrom" class="form-control">
										</div>
										<div class="col-sm-offset-3"></div>
									</div>
									<div class="form-group form-group-sm">
										<label for="dateto" class="contdrol-label col-sm-3">Date To</label>
										<div class="col-sm-6">
											<input type="date" id="dateto" class="form-control">
										</div>
										<div class="col-sm-offset-3"></div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" id="searchInvoice" class="btn btn-info" data-dismiss="modal">Search</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script id="invoice-template" type="text/x-handlebars-template">
				<div class="table-responsive">
					<table class="table table-striped table-fixed table-fixed-col-5" style="border:1px solid gainsboro">
						<thead class="bg-info">
							<tr>
								<th>Invoice Number</th>
								<th>Invoice Date</th>
								<th>Reference</th>
								<th>Amount</th>
								<th>Pdf link</th>
							</tr>
						</thead>
						<tbody>
							{{#each invoices}}
							<tr>
								<td>{{invoice_number}}</td>
								<td>{{invoice_date}}</td>
								<td>{{reference}}</td>
								<td>{{invoice_amount}}</td>
								<td>{{pdf_link}}</td>
							</tr>
							{{/each}}
						</tbody>
					</table>
				</div>
			</script>
			<div class="table-responsive" id="invoice-content">
				<!-- invoice content comes inside this div -->
			</div>
		</div>
	</div>
</body>
</html>
