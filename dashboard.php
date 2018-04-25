<?php
   /* Logged in session handling*/
   require "includes/validateLogin.php";
   //include "includes/header.php"; //include top header part
   $webaccount = isset($_SESSION["webaccount"])? $_SESSION["webaccount"]:"Unknown";
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php require "includes/header.php" ?>
   </head>
   <body style="background:aliceblue">
      <?php require "includes/navbar.php" ?>
      <div class="container-fluid" style="margin-top:60px;">
         
		<div class="well well-sm">
			<div class="row">				
			   <div class="col-sm-4"></div>
			   <div class="col-sm-5">
				  <div class="input-group">
					 <input type="text" id="itemtosearch" class="form-control" placeholder="Search item(s)" title="Item search" value=""
						data-toggle="popover" data-placement="left" data-trigger="hover"
						data-content="Enter comma separated values for multiple items" autofocus>
					 <div class="input-group-btn">
						<button type="button" id="itemSearchbtn" class="btn btn-info" >
						<span class="glyphicon glyphicon-search"></span> Search</button>
					 </div>
				  </div>
			   </div>
			   <div class="col-sm-3"></div>
			</div>
		</div>
		<div id="priceAndStockData" class="hidden">
            <div class="row">
               <div class="col-sm-5">
					<div class="panel-group">
					  <div class="panel panel-primary">
						 <div class="panel-heading">
							<h4 class="panel-title">
							   <a class="btn-block" href="#colpriceinfo" data-toggle="collapse" >
								 Column Pricing</a>
							</h4>
						 </div>
						 <div id="colpriceinfo" class="collapse">
							<div class="panel-body bg-alice">
								<div class="scrollover340">
								   <div class="table-responsive" id="columnPrice-content">
									  <!-- COlumn price content -->
								   </div>
							   </div>
							</div>
							<!-- column price template -->
							<script id="columnPrice-template" type="text/x-handlebars-template">
							   {{#each products}}
							   <table class="table table-bordered">
								<caption><b>{{material_nr}}|Column Price</b></caption>
								<thead class="bg-slategray">
									<tr>
										<th>Price in EUR</th>
										{{#each prices}}
										<th>{{column_quantity}}+</th>
										{{/each}}
									</tr>
								<thead>
								<tbody>
									<tr>
										<td>Price - Blank</td>
										{{#each prices}}
										<td>{{price}}</td>
										{{/each}}
									</tr>
									<tr>
										<td>Price - Decorated</td>
										{{#each prices}}
										<td>{{incl_price}}</td>
										{{/each}}
									</tr>
								</tbody>
							   </table>
							   {{/each}}
							</script>
						 </div>
					  </div>
					  <div class="panel panel-primary">
						 <div class="panel-heading">
							<h4 class="panel-title">
							   <a href="#stockinfo" data-toggle="collapse" class="btn-block">
							   Stock Information</a>
							</h4>
						 </div>
						 <div id="stockinfo" class="collapse">
							<div class="panel-body bg-alice">
								<div class="scrollover340">
								   <div id="itemStock-content" class="table-responsive">
									  <!-- stock info comes here -->
								   </div>
							   </div>
							   <script id="itemStock-template" type="template/x-handlebars-template">
								  {{#each products}}
									<table class="table table-bordered">
										<caption><b>{{material_nr}}|Stock Info:</b></caption>
										<thead class="bg-slategray">
										  <tr>
											 <th>Available stock</th>
											 <th colspan="2">Future stock</th>
										  </tr>
										</thead>
										<tbody>
										  {{#each stocks}}
										  {{#if @first}}
										  <tr>
											 <td class="availstock" rowspan="{{../stocks.length}}">{{stock}}</td>
											 <td><b>Avail date</b></td>
											 <td><b>stock</b></td>
										  </tr>	
										  {{else}}									  
										  <tr>
											 <td>{{avail_date}}</td>
											 <td>{{stock}}</td>
										  </tr>
										  {{/if}}	
										  {{/each}}											 
										</tbody>
									</table>
								  {{/each}}
							   </script>
							</div>
						 </div>
					  </div>
				  </div>
               </div>  
			   <div class="col-sm-4">
				  <div class="well">
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Product(s):</td>
									<td><p id="products" style="word-wrap:break-word;"></p></td>
								</tr>
								<tr>
									<td>Model:</td>
									<td id="model"></td>
								</tr>
								<tr>
									<td>Prices in:</td>
									<td id="currency"></td>
								</tr>
							</tbody>
						</table>
					</div>					
                  </div>
				  <div class="text-right">
					<button type="button" id="btncreateorder" class="btn btn-lg btn-success">Create Order</button>
				  </div>
               </div>
               <div class="col-sm-3">
					<div id="image-wrapper" class="thumbnail">
						<img id="productimage" class="img-thumbnail img-responsive" alt="Product Image" onerror="f_imageloaderr(this)"></img>
						<div class="caption">
							<p class="text-center">Product Image</p>
						</div>						
					</div>
			   </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <h4 class="panel-title">
                           <a href="#decoinfo" data-toggle="collapse" class="btn-block">
                           Decoration Pricing</a>
                        </h4>
                     </div>
                     <div id="decoinfo" class="collapse">
                        <div class="panel-body bg-alice">
                           <div class="pre-scrollable">
                              <div id="decoPrice-content" class="table-responsive">
                                 <!-- decoration table -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>  
            <div class="row">
               <div class="col-sm-12">
                  <div class="panel panel-primary" id="addons-panel">
                     <div class="panel-heading">
                        <h4 class="panel-title">
                           <a href="#addonsinfo" data-toggle="collapse" class="btn-block">
                           Addons</a>
                        </h4>
                     </div>
                     <div id="addonsinfo" class="collapse">
                        <div class="panel-body bg-alice">
                           <div class="">
                              <div id="addons-content" class="">
                                 <!-- addons info -->
                              </div>
							  <!-- addons template -->
								<script id="addons-template" type="text/x-handlebars-template">
								   {{#each products}}
								   <div class="row">
								   {{#each addons}}
									 <div class="col-sm-4">
										<div class="table-responsive" style="border:1px solid lightseagreen;border-radius:5px;">
										   <table class="table">
											 <tbody>
												<tr>
													<th>Item</th>
													<td>{{addon_item}}</td>
												</tr>
													<th>Size</th>
													<td>{{size}}</td>
												</tr>
													<th>Model</th>
													<td>{{model_code}}</td>
												</tr>
													<th>Quantity</th>
													<td>{{addon_quantity}}</td>
												</tr>
													<th>Type</th>
													<td>{{addon_type}}</td>
												</tr>
													<th>Exclusive</th>
													<td>{{exclusive}}</td>
												</tr>
													<th>Prices</th>
													<td>
														{{#if prices}} 
														<select type="select" class="input-sm">
														{{#each prices}}
															<option value="{{column_quantity}}">{{column_quantity}} :: {{price}} </option>
														{{/each}}
														</select>
														{{/if}}
													</td>
												</tr>
											 </tbody>
										   </table>
									   </div>
									 </div>
									 {{/each}}
								   </div>
								   {{/each}}
								</script>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>          
         </div>
      </div>
  	<form id="form-createorder" action="createorder.php" method="POST" hidden>
  		<input type="hidden" id="imageurl" name="imageurl" value="">
  		<input type="hidden" id="item_model" name="model" value="">	
  		<input type="hidden" id="itemlist" name="itemlist" value="">																 
  		<input type="hidden" id="future_stock" name="futurestock" value="">
  		<input type="hidden" id="column_prices" name="columnprices" value="">
  		<input type="hidden" id="addons" name="addons" value="">
  	</form>
   </body>
</html>