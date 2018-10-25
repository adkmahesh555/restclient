<?php

require "includes/validateLogin.php";

$preurl = "https://wsa.pfconcept.com/test/v01/rest/PFRestService/";
$webaccount = isset($_SESSION["webaccount"])? $_SESSION["webaccount"]:"Unknown";
$auth = $_COOKIE["auth"];
$url  =  $preurl.'OrderOverview?get_order_overview_req={%22order_overview_req%22:%20[{%22request_id%22:%22aae86dc3-d0b7-48d9-b0ec-8b02fa7b7916%22,%22version%22:%221%22,%22website%22:%22pfc%22,%22customer_id%22:%22'.$webaccount.'%22,%22date_from%22:%22%22,%22date_to%22:%22%22,%22status%22:%22%22,%22sales_order%22:%22%22,%22reference%22:%22%22,%22material_nr%22:%22%22,%22materialvendor%22:%22%22,%22range_from%22:%221%22,%22range_max%22:%2210%22}]}';

function httpGet($urll,$auth)
{
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_CAINFO, dirname(__FILE__).'/extras/ssl/cacert.pem');
	curl_setopt($ch,CURLOPT_URL,$urll);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_HTTPHEADER, array("Authorization: Basic ".$auth));

	$output=curl_exec($ch);

	if($output === false)
	{
		echo "Error Number:".curl_errno($ch)."<br>";
		echo "Error String:".curl_error($ch);
	}

	curl_close($ch);
	return $output;
}

//$testdata = '{"response":{"get_order_overview_rsp":{"order_overview_rsp":[{"total_rows":1,"customer_id":28521,"Orders":[{"customer_id":28521,"order_id":4803828,"order_reference_number":0,"order_date":"2017-06-16","creator_id":"","total":0.0,"status":""},{"customer_id":2222,"order_id":4803828,"order_reference_number":0,"order_date":"2017-06-16","creator_id":"","total":0.0,"status":""},{"customer_id":33333,"order_id":4803828,"order_reference_number":0,"order_date":"2017-06-16","creator_id":"","total":0.0,"status":""},{"customer_id":44444,"order_id":4803828,"order_reference_number":0,"order_date":"2017-06-16","creator_id":"","total":0.0,"status":""}]}]},"message":""}}';
//$data = json_decode($testdata,true);

$data = json_decode(httpGet($url,$auth),true); //echo json_encode($data); return;
$data = $data['response']['get_order_overview_rsp'];
if(empty($data)){
	echo "No data";
	return;
}
$overviewrsp = $data["order_overview_rsp"][0];
$totalrows = $overviewrsp["total_rows"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php require "includes/header.php" ?>
</head>
<body style="background:aliceblue">
	<?php require "includes/navbar.php" ?>
	<div class="container" style="margin-top:60px;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<b>Order Overview</b>
				<button type="button" class="btn btn-xs btn-warning font-bold pull-right" data-toggle="modal" data-target="#orderOvSearchModal">
					<span class="glyphicon glyphicon-search"></span> Search
				</button>
			</div>
			<div class="panel-body bg-alice">
				<div id="orderoverview-content" class="table-responsive" style="border: 1px solid lightseagreen;border-radius:4px;">
					<table class="table table-striped table-condensed" id="orderoverview-table">
						<thead class="bg-slategray">
							<tr>
								<th>Customer no.</th>
								<th>Order no.</th>
								<th>Web order id.</th>
								<th>Order date</th>
								<!-- <th>Creator id</th>  -->
								<th>Order references</th>
								<th>Status</th>
								<th>Details</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($overviewrsp["Orders"])){
								for($i=0;$i<count($overviewrsp["Orders"]);$i++){
									$orders = $overviewrsp["Orders"][$i];
									$customerid = $orders["customer_id"];
									$orderid = $orders["order_id"];
									$orderrefno = $orders["web_order_id"];
									$orderref = $orders["order_reference"];
									$orderdate = $orders["order_date"];
									$creatorid = $orders["creator_id"];
									$status = $orders["status"];
									echo '<tr>
									<td>'.$customerid.'</td>
									<td>'.$orderid.'</td>
									<td>'.$orderrefno.'</td>
									<td>'.$orderdate.'</td>
									<td style="word-wrap: break-word;">'.$orderref.'</td>
									<td>'.$status.'</td>
									<td><button type="button" class="btn btn-sm btn-info" value="'.$orderid.'" onclick="f_getOrder(this.value)">Details</button></td>
									</tr>';
								}
							}else{
								echo '<tr class="text-center text-danger lead"><td colspan="7">No orders found!!</td></tr>';
							}
							?>
						</tbody>
					</table>
					<div class="pager orderovpager">
						<button type="button" class="btn btn-default round15 prev disabled" data-from="" data-find="prev" onclick="f_prevnextorder(this)" style="outline:none;">Previous</button>
						<button type="button" class="btn btn-default round15 next" data-from="11" data-find="next" data-totalrows="<?php echo $totalrows ?>" onclick="f_prevnextorder(this)" style="outline:none;">&nbsp;Next&nbsp; </button>
					</div>
				</div>
				<script id="orderoverview-template" type="text/x-handlebars-template">
					{{#if Orders}}
					{{#each Orders}}
					<tr>
						<td>{{customer_id}}</td>
						<td>{{order_id}}</td>
						<td>{{web_order_id}}</td>
						<td>{{order_date}}</td>
						<td style="word-wrap: break-word;">{{order_reference}}</td>
						<td>{{$status}}</td>
						<td><button type="button" class="btn btn-sm btn-info" value="{{order_id}}" onclick="f_getOrder(this.value)">Details</button></td>
					</tr>
					{{/each}}
					{{else}}
					<tr><td colspan="7" class="lead text-danger">No Order found!!</td></tr>
					{{/if}}
				</script>
			</div>
		</div>
		<div id="orderdetails">
			<div class="getorderwrapper">
				<script id="getorder-template" type="text/x-handlebars-template">
					<div class="panel panel-primary" >
						<div class="panel-heading"><b>Order Details</b></div>
						<div class="panel-body bg-alice">
							<div class="orderinfo well well-sm">
								<div class="table-responsive">
									<table class="table table-bordered table-collapsed bg-beige">
										<caption class="font-bold text-info">Order</caption>
										<thead class="bg-slategray">
											<tr>
												<th>Order id</th>
												<th>Extranet order id </th>
												<th>Creation date </th>
												<th>currency</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{order_id}}</td>
												<td>{{web_order_id}}</td>
												<td>{{creation_date}}</td>
												<td>{{currency}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="prodinfo well well-sm" >
								<div class="table-responsive">
									<table class="table table-bordered table-collapsed bg-beige">
										<caption class="font-bold text-info">Products</caption>
										<thead class="bg-slategray">
											<tr id='tr_productinfo'>
												<th>Product no.</th>
												<th>Desc.</th>
												<th>Delivery date </th>
												<th>Shipped date </th>
												<th>Qty</th>
												<th>Status</th>
												<th>Weight</th>
												<th>Volume</th>
											</tr>
										</thead>
										<tbody>
											{{#each product}}
											<tr>
												<td>{{material_number}}</td>
												<td>{{material_desc}}</td>
												<td>{{delivery_date}}</td>
												<td>{{ship_date}}</td>
												<td>{{qty}}</td>
												<td>{{status}}</td>
												<td>{{weight}}</td>
												<td>{{volume}}</td>
											</tr>
											{{/each}}
										</tbody>

									</table>
								</div>
							</div>
							<div class="decoinfo well well-sm">
								<div class="table-responsive">
									<table class="table table-bordered table-collapsed bg-beige">
										<caption class="font-bold text-info">Decoration</caption>
										<thead class="bg-slategray">
											<tr>
												<th>PF Order</th>
												<th>Decoration</th>
												<th>Color</th>
												<th>PMS</th>
												<th>Original</th>
												<th>E-proof</th>
											</tr>
										</thead>
										<tbody>
											{{#each product}}
											{{#each Decorations}}
											<tr>
												<td>{{order_id}}</td>
												<td>{{method}},{{description}}</td>
												<td>{{colors}}</td>
												<td>{{pms}}</td>
												<td><a target="_blank" href="{{origlogo}}">View logo</a></td>
												<td><a target="_blank" href="{{eproof}}">View eproof</a></td>
											</tr>
											{{/each}}
											{{/each}}
										</tbody>
									</table>
								</div>
							</div>
							<div class="shipinfo well well-sm">
								<div class="table-responsive">
									<table class="table table-bordered table-collapsed bg-beige">
										<caption class="font-bold text-info">Shipping info</caption>
										<tbody>

											{{#each shipping_info}}
											<tr>
												<td>Number of results per page</td>
												<td>{{number}}</td>
											</tr>
											<tr>
												<td>Pallets</td>
												<td>{{pallets}}</td>
											</tr>
											<tr>
												<td>Weight</td>
												<td>{{weight}}</td>
											</tr>
											<tr>
												<td>Shipping date</td>
												<td>{{shipped_date}}</td>
											</tr>
											<tr>
												<td>PT number</td>
												<td>{{pickingticket_nr}}</td>
											</tr>
											<tr>
												<td>Forwarder</td>
												<td>{{forwarder}}</td>
											</tr>
											<tr>
												<td>Tracking nr</td>
												<td>{{tracking_nr}}</td>
											</tr>
											<tr>
												<td>Name</td>
												<td>{{address_name}}</td>
											</tr>
											<tr>
												<td>Attention</td>
												<td>{{attention}}</td>
											</tr>
											<tr>
												<td>Address</td>
												<td>{{delivery_address}}</td>
											</tr>
											<tr>
												<td>House no</td>
												<td>{{house_number}}</td>
											</tr>
											<tr>
												<td>City</td>
												<td>{{city}}</td>
											</tr>
											<tr>
												<td>Zipcode</td>
												<td>{{zipcode}}</td>
											</tr>
											<tr>
												<td>Country code</td>
												<td>{{country}}</td>
											</tr>
											<tr>
												<td>links</td>
												<td>{{Transporter_links}}</td>
											</tr>
											{{/each}}

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</script>
				<div id="getorder-content">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- order overview search modal -->
<div id="orderOvSearchModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-primary">Search Order(s)</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group form-group-sm">
						<label for="invoicenum" class="col-sm-3">SalesOrder</label>
						<div class="col-sm-6">
							<input type="number" id="salesorder" class="form-control" min="0" max="999999999">
						</div>
						<div class="col-sm-offset-3"></div>
					</div>
					<div class="form-group form-group-sm">
						<label for="status" class="col-sm-3">Status</label>
						<div class="col-sm-6">
							<input type="text" id="status" class="form-control">
						</div>
						<div class="col-sm-offset-3"></div>
					</div>
					<div class="form-group form-group-sm">
						<label for="reference" class="col-sm-3">Reference</label>
						<div class="col-sm-6">
							<input type="text" id="reference" class="form-control">
						</div>
						<div class="col-sm-offset-3"></div>
					</div>
					<div class="form-group form-group-sm">
						<label for="material_nr" class="col-sm-3">Material num.</label>
						<div class="col-sm-6">
							<input type="text" id="material_nr" class="form-control">
						</div>
						<div class="col-sm-offset-3"></div>
					</div>
					<div class="form-group form-group-sm">
						<label for="material_vendor" class="col-sm-3">Material vendor</label>
						<div class="col-sm-6">
							<input type="text" id="material_vendor" class="form-control">
						</div>
						<div class="col-sm-offset-3"></div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-12">
							<div class="form-group row">
								<label for="datefrom" class="col-sm-3">Date from</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" id="datefrom" style="padding:5px 0px;">
								</div>
								<label for="dateto" class="col-sm-3">Date To</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" id="dateto" style="padding:5px 0px;">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<div class="col-sm-12">
							<div class="form-group row">
								<label for="rangefrom" class="col-sm-3">Range from</label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="rangefrom">
								</div>
								<label for="rangemax" class="col-sm-3 ">Range max.</label>
								<div class="col-sm-3">
									<input type="number" class="form-control" id="rangemax">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" onclick="f_searchOrderOverview()" data-dismiss="modal">Search</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- order overview search modal -->
</body>
</html>
