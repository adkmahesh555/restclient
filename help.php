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
		<script src="js/doc.js"></script>
    </head>
    <body style="background:aliceblue">
        <?php require "includes/navbar.php" ?>
<div class="upperpart" style="clear:both">
</div>	
<div class="helpContainer" style="position: relative;top: 30px;">
	<div class="containerWrapper" style="width:110%;">
        <div class="serviceList" style="float:left; width: 25%;">	
      <h3 class="serviceName" onclick="f_chooseService('login')">Login </h3>
      <h3 class="serviceName" onclick="f_chooseService('getPriceAndStock')">getPriceAndStock </h3>
      <h3 class="serviceName" onclick="f_chooseService('getDeconPrice')">getDeconPrice </h3>
      <h3 class="serviceName" onclick="f_chooseService('CustomerAddress')">CustomerAddress </h3>
		  <h3 class="serviceName" onclick="f_chooseService('getOrderSimulation')">getOrderSimulation </h3>
			<h3 class="serviceName" onclick="f_chooseService('Order')">Order </h3>
			<h3 class="serviceName" onclick="f_chooseService('getInvoiceOverview')">getInvoiceOverview </h3>
			<h3 class="serviceName" onclick="f_chooseService('setContact')">setContact </h3>
			
			
			
	
        </div>
   
        <div class="serviceDetails" style="float:left; width: 60%">	
		   <h2 class="getHeader" data-accordion="dvGetBlock" data-servicename="">GET</h2>
		      <div class="dvGetBlock hidden">
			    <h3 style="color:blue;">Description </h3>
				 <p class="desc"></p>
				 
				 <p class="requrl" style="color:blue;"><b>Request URL: </b>  </p>
				 <h3 style="color:blue;">Parameters </h3>
				 <div class="dvParameter clgetOrderSimulation hidden">
				     
					 <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="requestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="requestid" placeholder="" style="float:left; width: 40%" onblur="fo_requestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="version" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="version" placeholder="" style="float:left; width: 40%" onblur="fo_version()">
			            </div>
		             </div>
					 
					 <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="website"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="website" placeholder="" style="float:left; width: 40%" onblur="fo_website()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="orderrefno" style="float:left; width: 25%"> Order Ref. No.: </label>
		                   <input type="text" id="orderrefno" placeholder="" style="float:left; width: 40%" onblur="fo_orderref()">
			            </div>
		             </div>
					 
					 <div class="row" id="thirdrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="ordertype"  style="float:left; width: 25%"> Order type:  </label>
		                   <input type="text" id="ordertype" placeholder="" style="float:left; width: 40%" onblur="fo_ordertype()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="salesorg" style="float:left; width: 25%"> Sales Organization: </label>
		                   <input type="text" id="salesorg" placeholder="" style="float:left; width: 40%" onblur="fo_salesorg()">
			            </div>
		             </div>
					 
					  <div class="row" id="fourthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="distchannel"  style="float:left; width: 25%"> Distribution channel:  </label>
		                   <input type="text" id="distchannel" placeholder="" style="float:left; width: 40%" onblur="fo_distchannel()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="division" style="float:left; width: 25%"> Division: </label>
		                   <input type="text" id="division" placeholder="" style="float:left; width: 40%" onblur="fo_div()">
			            </div>
		             </div>
					 
					 <div class="row" id="fifthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="langcode"  style="float:left; width: 25%"> Language Code:  </label>
		                   <input type="text" id="langcode" placeholder="" style="float:left; width: 40%" onblur="fo_langcode()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="custid" style="float:left; width: 25%"> Customer id: </label>
		                   <input type="text" id="custid" placeholder="" style="float:left; width: 40%" onblur="fo_custid()">
			            </div>
		             </div>
					 
					 <div class="row" id="sixthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="contactid"  style="float:left; width: 25%"> Contact id:  </label>
		                   <input type="text" id="contactid" placeholder="" style="float:left; width: 40%" onblur="fo_contactid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="shipadd" style="float:left; width: 25%"> Shipping address: </label>
		                   <input type="text" id="shipadd" placeholder="" style="float:left; width: 40%" onblur="fo_shipadd()">
			            </div>
		             </div>
					 
					  <div class="row" id="seventhrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="paymentmethod"  style="float:left; width: 25%"> Payment method:  </label>
		                   <input type="text" id="paymentmethod" placeholder="" style="float:left; width: 40%" onblur="fo_paymentmet()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="shipmethod" style="float:left; width: 25%"> Shipping method: </label>
		                   <input type="text" id="shipmethod" placeholder="" style="float:left; width: 40%" onblur="fo_shipmet()">
			            </div>
		             </div>
					 
					 <div class="row" id="eighthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="reqdeldate"  style="float:left; width: 25%"> Req. Del Date:  </label>
		                   <input type="text" id="reqdeldate" placeholder="" style="float:left; width: 40%" onblur="fo_reqdeldate()">
			            </div>
						
						<div class="secondcol col-md-6" style="clear:both">
			         
			            </div>
				        
		             </div>
		             
		        <p><b>Products:</b></p>
					 
					  <div class="row" id="ninethrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 30%">
			               <label for="ordrfno"  style="float:left; width: 25%"> Order Ref. No.:  </label>
		                   <input type="text" id="ordrfno" placeholder="" style="float:left; width: 40%" onblur="">
			            </div>
						
						<div class="secondcol" style="float:left; width: 30%">
			               <label for="materialno" style="float:left; width: 25%"> Material No.: </label>
		                   <input type="text" id="materialno" placeholder="" style="float:left; width: 40%" onblur="">
			            </div>
						
						<div class="thirdcol" style="float:left; width: 30%">
			               <label for="qty" style="float:left; width: 25%"> Quantity: </label>
		                   <input type="text" id="qty" placeholder="" style="float:left; width: 40%" onblur="">
			            </div>
						
						 <button type="button" id="addProduct" class="btn-default greenbtn" onclick="f_addProduct()">Add</button>
				        
		             </div>
					 
					  
					 <textarea class="products" id="productjson" style="float:left; width: 80%; margin-top: 10px; height: 100px;"> </textarea>
			     
					 
				 </div>
				 
				 <!-- PriceAndStock -->
				
				<div class="dvParameter clgetPriceAndStock hidden">
				     
					 <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="PnSrequestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="PnSrequestid" placeholder="" style="float:left; width: 40%" onblur="fo_prequestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="PnSversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="PnSversion" placeholder="" style="float:left; width: 40%" onblur="fo_pversion()">
			            </div>
		             </div>
					 
					 <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="PnSwebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="PnSwebsite" placeholder="" style="float:left; width: 40%" onblur="fo_pwebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="PnSmaterialno" style="float:left; width: 25%"> Material No.: </label>
		                   <input type="text" id="PnSmaterialno" placeholder="" style="float:left; width: 40%" onblur="fo_pmaterial()">
			            </div>
		             </div>
	 
					  <div class="row" id="fourthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="PnScustomerno"  style="float:left; width: 25%"> Customer No.:  </label>
		                   <input type="text" id="PnScustomerno" placeholder="" style="float:left; width: 40%" onblur="fo_pcust()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="PnSsalesorg" style="float:left; width: 25%"> Sales Organization: </label>
		                   <input type="text" id="PnSsalesorg" placeholder="" style="float:left; width: 40%" onblur="fo_psalesorg()">
			            </div>
		             </div>
					 
					 <div class="row" id="fifthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="PnSdistchannel"  style="float:left; width: 25%"> Distribution channel:  </label>
		                   <input type="text" id="PnSdistchannel" placeholder="" style="float:left; width: 40%" onblur="fo_pdistchan()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="PnSdiv" style="float:left; width: 25%"> Division: </label>
		                   <input type="text" id="PnSdiv" placeholder="" style="float:left; width: 40%" onblur="fo_pdiv()">
			            </div>
		             </div>
					 
					<div class="row" id="sixthrow" style="width: 100%;">
			            <div class="firstcol" style="width: 50%;margin-top: 10px">
				          <input type="checkbox" id="PnSstock" value="s" onchange="fo_pstock()" checked> Stock &nbsp;
                  <input type="checkbox" id="PnSprice" value="p" onchange="fo_pprice()" checked> Net Price &nbsp;
					      <input type="checkbox" id="PnSdecoprice" value="dp" onchange="fo_pdecoprice()" checked> Deco Price &nbsp;
			            </div>
						
				        <div class="secondcol col-md-6" style="clear:both">
			         
			            </div>
		            </div>
		             
			     
					 
				 </div>
				
				<!--ends PriceAndStock -->
				
				<!-- CustomerAddress -->
				
				<div class="dvParameter clgetCustomerAddress hidden">
				     
					 <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="CArequestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="CArequestid" placeholder="" style="float:left; width: 40%" onblur="fo_carequestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="CAversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="CAversion" placeholder="" style="float:left; width: 40%" onblur="fo_caversion()">
			            </div>
		             </div>
					 
					 <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="CAwebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="CAwebsite" placeholder="" style="float:left; width: 40%" onblur="fo_cawebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="CAcustid" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="CAcustid" placeholder="" style="float:left; width: 40%" onblur="fo_cacustid()">
			            </div>
		             </div>
					 
					 <div class="row" id="thirdrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="CAtype"  style="float:left; width: 25%"> Type:  </label>
		                   <input type="text" id="CAtype" placeholder="" style="float:left; width: 40%" onblur="fo_catype()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="CAsearchtxt" style="float:left; width: 25%"> Search Text: </label>
		                   <input type="text" id="CAsearchtxt" placeholder="" style="float:left; width: 40%" onblur="fo_casearchtxt()">
			            </div>
		             </div>
					 
					 
				 </div>
				
				<!--ends CustomerAddress -->
				
				<!-- getDeconPrice -->
				
				<div class="dvParameter clgetDeconPrice hidden">
				     
					 <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="DPrequestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="DPrequestid" placeholder="" style="float:left; width: 40%" onblur="fo_dprequestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="DPversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="DPversion" placeholder="" style="float:left; width: 40%" onblur="fo_dpversion()">
			            </div>
		             </div>
					 
					 <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="DPwebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="DPwebsite" placeholder="" style="float:left; width: 40%" onblur="fo_dpwebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="DPcustid" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="DPcustid" placeholder="" style="float:left; width: 40%;margin-bottom:10px" onblur="fo_dpcustid()">
			            </div>
		             </div>
					 
					 <p><b>Deco Products:</b></p>
					 
					 <div class="row" id="thirdrow" style="width: 100%;margin-top:-20px">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="DPitemno"  style="float:left; width: 25%"> Item No.:  </label>
		                   <input type="text" id="DPitemno" placeholder="" style="float:left; width: 40%" onblur="fo_dpitemno()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="DPquantity" style="float:left; width: 25%"> Quantity: </label>
		                   <input type="text" id="DPquantity" placeholder="" style="float:left; width: 40%" onblur="fo_dpquantity()">
			            </div>
		             </div>
					 
					 
				 </div>
				
				<!--ends getDeconPrice -->
				
				<!-- getOrder -->
				
				<div class="dvParameter clgetOrder hidden">
				     
					 <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="Orequestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="Orequestid" placeholder="" style="float:left; width: 40%" onblur="fo_orequestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="Oversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="Oversion" placeholder="" style="float:left; width: 40%" onblur="fo_oversion()">
			            </div>
		             </div>
					 
					 <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="Owebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="Owebsite" placeholder="" style="float:left; width: 40%" onblur="fo_owebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="Ocustid" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="Ocustid" placeholder="" style="float:left; width: 40%;margin-bottom:10px" onblur="fo_ocustid()">
			            </div>
		             </div>
					 
					
					 
					 <div class="row" id="thirdrow" style="width: 100%;margin-top:-20px">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="Oorderid"  style="float:left; width: 25%"> Order Id:  </label>
		                   <input type="text" id="Oorderid" placeholder="" style="float:left; width: 40%" onblur="fo_oorderid()">
			            </div>
						
						 <div class="secondcol" style="clear:both">
						 </div>
				       
		             </div>
					 
					 
				 </div>
				
				<!--ends getOrder-->
				
				<!-- getInvoiceOverview -->
				
				<div class="dvParameter clgetInvoiceOverview hidden">
				     
					 <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="IOrequestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="IOrequestid" placeholder="" style="float:left; width: 40%" onblur="fo_iorequestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="IOversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="IOversion" placeholder="" style="float:left; width: 40%" onblur="fo_ioversion()">
			            </div>
		             </div>
					 
					 <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="IOwebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="IOwebsite" placeholder="" style="float:left; width: 40%" onblur="fo_iowebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="IOcustid" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="IOcustid" placeholder="" style="float:left; width: 40%;margin-bottom:10px" onblur="fo_iocustid()">
			            </div>
		             </div>
					 
					
					 
					 <div class="row" id="thirdrow" style="width: 100%">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="IOinvoiceno"  style="float:left; width: 25%"> Invoice No:  </label>
		                   <input type="text" id="IOinvoiceno" placeholder="" style="float:left; width: 40%" onblur="fo_ioinvoiceno()">
			            </div>
						
						 <div class="firstcol" style="float:left; width: 50%">
			               <label for="IOtodate"  style="float:left; width: 25%"> To Date:  </label>
		                   <input type="date" id="IOtodate" placeholder="" style="float:left; width: 40%" onchange="fo_iotodate()">
			            </div>
										       
		             </div>
					 
					  <div class="row" id="fourthrow" style="width: 100%">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="IOfromdate"  style="float:left; width: 25%"> From Date:  </label>
		                   <input type="date" id="IOfromdate" placeholder="" style="float:left; width: 40%" onchange="fo_iofromdate()">
			            </div>
						
						 <div class="secondcol" style="clear:both">
						 </div>
										       
		             </div>
					  
					 
					 
				 </div>
				
				<!--ends getInvoiceOverview-->
				
				 <p><b>request:</b></p>
			     <textarea class="request" id="getrequest" style="float:left; width: 80%; margin-top: -10px; height: 383px;"> </textarea>
				 
				 <button type="button" id="sendrequest" class="btn-default greenbtn" onclick="f_sendRequest()">Send</button>
				 
				  <p><b>response:</b></p>
			     <textarea class="request" id="getresponse" style="float:left; width: 80%; margin-top: -10px; height: 700px;"> </textarea>
				 .
				  
				
				
	          </div>
		   <h2 class="postHeader" data-accordion="dvPostBlock" data-servicename="">POST</h2>
		       <div class="dvPostBlock hidden">
		       
		        <h3 style="color:blue;">Description </h3>
				    <p class="desc1"></p>
				 
				    <p class="postrequrl" style="color:blue;"><b>Request URL: </b>  </p>
				    <h3 style="color:blue;">Parameters </h3>
				    <!-- set contact start -->
				 <div class="dvpostParameter clsetcontent hidden">   
					      <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="requestid"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="crequest_id" placeholder="" style="float:left; width: 40%" onblur="fo_crequestid()">
			            </div>
				          <div class="secondcol" style="float:left; width: 50%">
			               <label for="version" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="cversion" placeholder="" style="float:left; width: 40%" onblur="fo_cversion()">
			            </div>
	               </div>
	              <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="website"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="cwebsite" placeholder="" style="float:left; width: 40%" onblur="fo_cwebsite()">
			            </div>
				          <div class="secondcol" style="float:left; width: 50%">
			               <label for="customerid" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="customerid" placeholder="" style="float:left; width: 40%" onblur="fo_ccustomerid()">
			            </div>
	              </div>
	              <div class="row" id="thirdrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="first_name"  style="float:left; width: 25%"> First Name:  </label>
		                   <input type="text" id="first_name" placeholder="" style="float:left; width: 40%" onblur="fo_cfirstname()">
			            </div>
				          <div class="secondcol" style="float:left; width: 50%">
			               <label for="last_name" style="float:left; width: 25%"> Last Name: </label>
		                   <input type="text" id="last_name" placeholder="" style="float:left; width: 40%" onblur="fo_clastname()">
			            </div>
	              </div>
	               <div class="row" id="forthrow" style="width: 100%;">
			              <div class="firstcol" style="float:left; width: 50%">
			               <label for="function"  style="float:left; width: 25%"> Function:  </label>
		                   <input type="text" id="function" placeholder="" style="float:left; width: 40%" onblur="fo_cfunction()">
			              </div>
				            <div class="secondcol" style="float:left; width: 50%">
			               <label for="email" style="float:left; width: 25%"> Email Address: </label>
		                   <input type="text" id="email" placeholder="" style="float:left; width: 40%" onblur="fo_cemail()">
			              </div>
	               </div>
	                  
			        </div>	
                  
                  <!-- setcontact ends--> 
                  
                  <!-- setcustomerAddress-->  
             <div class="dvParameter clsetcustomerAddress hidden">   
					      <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="cusrequest_id"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="cusrequest_id" placeholder="" style="float:left; width: 40%" onblur="fo_cusrequestid()">
			            </div>
				          <div class="secondcol" style="float:left; width: 50%">
			               <label for="cusversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="cusversion" placeholder="" style="float:left; width: 40%" onblur="fo_cusversion()">
			            </div>
	               </div>
	              <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="cuswebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="cuswebsite" placeholder="" style="float:left; width: 40%" onblur="fo_cuswebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="cuscustomerid" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="cuscustomerid" placeholder="" style="float:left; width: 40%" onblur="fo_cuscustomerid()">
			            </div>
	                  </div>
	                  <div class="row" id="thirdrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="type"  style="float:left; width: 25%"> Type:  </label>
		                   <input type="text" id="type" placeholder="" style="float:left; width: 40%" onblur="fo_custype()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="name" style="float:left; width: 25%"> Name: </label>
		                   <input type="text" id="name" placeholder="" style="float:left; width: 40%" onblur="fo_cusname()">
			            </div>
	                  </div>
	                  <div class="row" id="forthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="street"  style="float:left; width: 25%"> Street:  </label>
		                   <input type="text" id="street" placeholder="" style="float:left; width: 40%" onblur="fo_cusstreet()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="house_number" style="float:left; width: 25%"> House Number: </label>
		                   <input type="text" id="houser_number" placeholder="" style="float:left; width: 40%" onblur="fo_cushousenumber()">
			            </div>
	                  </div>
	                  <div class="row" id="fifthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="extension"  style="float:left; width: 25%"> Extension:  </label>
		                   <input type="text" id="extension" placeholder="" style="float:left; width: 40%" onblur="fo_cusextension()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="city" style="float:left; width: 25%"> City: </label>
		                   <input type="text" id="city" placeholder="" style="float:left; width: 40%" onblur="fo_cuscity()">
			            </div>
	                  </div>
	                  <div class="row" id="sixthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="zipcode"  style="float:left; width: 25%"> Zipcode:  </label>
		                   <input type="text" id="zipcode" placeholder="" style="float:left; width: 40%" onblur="fo_cuszipcode()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="country" style="float:left; width: 25%"> Country: </label>
		                   <input type="text" id="country" placeholder="" style="float:left; width: 40%" onblur="fo_cuscountry()">
			            </div>
	                  </div>
	                  <div class="row" id="seventhrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="temporary"  style="float:left; width: 25%"> Temporary Address:  </label>
		                   <input type="text" id="temporary" placeholder="" style="float:left; width: 40%" onblur="fo_custemporary()">
			            </div>
	                </div>
                  </div>
                  <!--setCustomerAddress ends-->
                  
                  <!--setOrder start -->
                  <div class="dvParameter clsetorder hidden">   
					         <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="orequest_id"  style="float:left; width: 25%"> Request id:  </label>
		                   <input type="text" id="orequest_id" placeholder="" style="float:left; width: 40%" onblur="fo_setrequestid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="setversion" style="float:left; width: 25%"> Version: </label>
		                   <input type="text" id="setversion" placeholder="" style="float:left; width: 40%" onblur="fo_setversion()">
			            </div>
	                  </div>
	                  <div class="row" id="secondrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="setwebsite"  style="float:left; width: 25%"> Website:  </label>
		                   <input type="text" id="setwebsite" placeholder="" style="float:left; width: 40%" onblur="fo_setwebsite()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="ordercomment" style="float:left; width: 25%"> Order Comment: </label>
		                   <input type="text" id="ordercomment" placeholder="" style="float:left; width: 40%" onblur="fo_ordercomment()">
			            </div>
	                  </div>
	                  <div class="row" id="thirdrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="order_type"  style="float:left; width: 25%"> Order Type:  </label>
		                   <input type="text" id="order_type" placeholder="" style="float:left; width: 40%" onblur="fo_ordertype()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="customer_number" style="float:left; width: 25%"> Customer Id: </label>
		                   <input type="text" id="customer_number" placeholder="" style="float:left; width: 40%" onblur="fo_ocustomernumber()">
			            </div>
	                  </div>
	          		  
	          		  <div class="row" id="fourthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="contactid"  style="float:left; width: 25%"> contact Id:  </label>
		                   <input type="text" id="contactid" placeholder="" style="float:left; width: 40%" onblur="fo_ocontactid()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="shipping_address_id" style="float:left; width: 25%"> shipping address Id: </label>
		                   <input type="text" id="shipping_address_id" placeholder="" style="float:left; width: 40%" onblur="fo_shippingaddress()">
			            </div>
	                  </div>
	                  <div class="row" id="fifthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="reqdeliverydate"  style="float:left; width: 25%"> Delivery Date:  </label>
		                   <input type="text" id="reqdeliverydate" placeholder="" style="float:left; width: 40%" onblur="fo_reqdeliverydate()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="currency" style="float:left; width: 25%"> Currency: </label>
		                   <input type="text" id="currency" placeholder="" style="float:left; width: 40%" onblur="fo_ocurrency()">
			            </div>
	                  </div>
	                  <div class="row" id="sixthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="material_num"  style="float:left; width: 25%"> Material Number:  </label>
		                   <input type="text" id="material_num" placeholder="" style="float:left; width: 40%" onblur="fo_omaterialnum()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="oqty" style="float:left; width: 25%"> Quantity: </label>
		                   <input type="text" id="oqty" placeholder="" style="float:left; width: 40%" onblur="fo_oqty()">
			            </div>
	                  </div>
	                  <div class="row" id="seventhrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="oprice"  style="float:left; width: 25%"> Price:  </label>
		                   <input type="text" id="oprice" placeholder="" style="float:left; width: 40%" onblur="fo_oprice()">
			            </div>
				        <div class="secondcol" style="float:left; width: 50%">
			               <label for="req_delivery_date" style="float:left; width: 25%"> Delivery_date: </label>
		                   <input type="text" id="req_delivery_date" placeholder="" style="float:left; width: 40%" onblur="fo_oreqdeliverydate()">
			            </div>
	                  </div>
	                  <div class="row" id="eighthrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="inhand_date"  style="float:left; width: 25%"> Inhand Date:  </label>
		                   <input type="text" id="inhand_date" placeholder="" style="float:left; width: 40%" onblur="fo_oinhand()">
			            </div>
			            </div>
	                 </div> 
	                  <!-- set Order ends -->
	                   <!--login starts-->
	               <div class="dvParameter cllogin hidden" style="height:auto">
        	         <div class="row" id="firstrow" style="width: 100%;">
			            <div class="firstcol" style="float:left; width: 50%">
			               <label for="uname"  style="float:left; width: 25%"> Webaccount:  </label>
		                   <input type="text" id="uname" placeholder="" style="float:left; width: 40%">
			            </div>
		              <div class="secondcol" style="float:left; width: 50%">
			               <label for="pwd" style="float:left; width: 25%"> Password: </label>
		                   <input type="password" id="pwd" placeholder="" style="float:left; width: 40%">
			            </div>
			            <button type="button" id="tkn" class="btn-default greenbtn" onclick="f_generatetoken()" style="margin-top: 18px; margin-bottom: 18px;float: left;">Generate Token</button>
			          <textarea class="tokenrequest" id="gettoken" style="float:left; width: 80%; margin-top: 60px; height: 250px;margin-left: -113px;"> </textarea>
		           </div>
		             
			
					 
              </div>
              <!--login ends-->
				        <p id ="txtdata"><b>Data:</b></p>
			              <textarea class="setrequest" id="setrequest" style="float:left; width: 80%; margin-top: -10px; height: 383px;"> </textarea>
				 
				         <button type="button" id="setrequestbtm" class="btn-default greenbtn" onclick="f_setrequest()">Post</button>
				 
				        <p id="txtresponse"><b>response:</b></p>
			              <textarea class="setresponse" id="setresponse" style="float:left; width: 80%; margin-top: -10px; height: 50px;"> </textarea>
			              
			              <p id="defaultcust" style="margin-top:10px"><b>Example for Default Decoration:</b></p>
			              <textarea class="tokenrequest" id="defaultdec" style="float:left; width: 80%; margin-top: 20px; height: 500px;" readonly> 
  {
   "request": {
      "set_order_req": {
         "Order_req": [
            {
               "request_id": "9c965b99-00e8-4a5d-ace3-0e6de2402174",
               "version": "1",
               "website": "pfconcept.com",
               "order_comment": "102",
               "order_reference_number": "9c965b99-00e8-4a5d-ace3-0e6de2402174",
               "order_type": "STD",
               "customer_number": "1028521 ",
               "contact_id": "javrma",
               "shipping_address_id": 70292,
               "req_delivery_date": null,
               "currency": "EUR",
               "Products": [
                  {
                     "order_line": 1,
                     "material_number": "10000200",
                     "qty": 1002,
                     "price": 0.95,
                     "req_delivery_date": "2017-10-10",
                     "inhand_date": "2017-10-13",
                     "DecorationReferences": [
                        {
                           "DecoReferenceID": 1
                        }
                     ]
                  }
               ],
               "Decorations": [
                  {
                     "decoration_id": "0x0000000000e717c9",
                     "configuration_id": "1_1175_34",
                     "colors": 1,
                     "length": 70,
                     "width": 30,
                     "diameter": 0,
                     "DecoReferenceID": 1
                  }
               ]
            }
         ]
      },
      "token": "cmVzdHVzZXIxOnBhc3MxzWifLDXL2bwuFDP6GIDweg=="
   }
}</textarea>
			              .
			              
                  
                  </div>
	          </div>
        </div>
</body>
</html>

