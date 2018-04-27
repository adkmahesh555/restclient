var preurl =  "https://wsa.pfconcept.com/test/v01/rest/PFRestService/";
var baseurl = "localhost/restclient/";

$(document).ready(function(){
	$('[data-toggle="popover"]').popover();
	$('[data-toggle="tooltip"]').tooltip();
	// ajax error handling
	$.ajaxSetup({
		error: function(jqxhr,exception){
			$("#dvLoading").hide(); // hide loading image if it was displayed on ajax call
			showAlert("AJAX Error!!!","Response code: " + jqxhr.status + "<br>Message: " + JSON.parse(jqxhr.responseText).response.message +
									 "<br><br>Responsedata: " + jqxhr.responseText);
			//$("#alertModal").modal("show");
		},
		headers: {"Authorization": "Basic " + f_getCookie("auth")}
	});
	//DASHBOARD
	if($("#priceAndStockData").length){
		$("#itemSearchbtn").on("click",f_searchitem); //Search button handler
		$("#itemtosearch").on("keypress", function(e){ //Trigger search on enter
			if(e.which === 13) $("#itemSearchbtn").trigger("click");
		});
		$("#btncreateorder").on("click", function(){ //submit form on create order button click
			$("#imageurl").val($("#productimage").attr("src"));
			if($("#future_stock").val() == "{}") {
				$("#future_stock").val("");
			}
			$("#form-createorder").submit();
		})
	}
	//CREATE ORDER PAGE

	//Select deco position on click inside decooptions block
	$("#decoOptions-content").on("click",".dvdecoOption",function(){
		//$(this).hasClass("selectedDeco")?$(this).removeClass("selectedDeco"):$(this).addClass("selectedDeco");
		if(!$(this).hasClass("selectedDeco")) $(this).addClass("selectedDeco")
	}).on("click",".unselectBtn",function(e){
		e.stopPropagation();
		$(this).closest("div.dvdecoOption").removeClass("selectedDeco");

	});

	//Trigger search on enter
	$("#additemcode,#setOrderRef").on("keypress", function(e){
		if(e.which === 13)
			$($(this).attr("data-entertrigger")).trigger("click");
	});

	//if addons available, display addons on Addons accordion
	if($("#addonsjson").length && $("#addonsjson").val() != ""){
		var addonsjson = JSON.parse($("#addonsjson").val());
		f_dispAddons(addonsjson);
	}
	$("#addons-content").on("click",".dvAddonsOption",function(){
		$(".dvAddonsOption.selected").each(function(){
			$(this).removeClass("selected");
		});
		$(this).addClass("selected")
		f_selectAddon();
	}).on("click",".unselectBtn",function(e){
		e.stopPropagation();
		$(this).closest("div.dvAddonsOption").removeClass("selected");
		f_selectAddon();
	});

	//IF ON INVOICE PAGE
	if($("#invoice-wrapper").length) {
		$("#searchInvoice").on("click",f_getinvoice);
		f_getinvoice();
	}

	//Contact(load customerAddress on dropdown)
	if($("div.contact-wrapper").length){
		f_customerAddress();
	}

});

/* Returns cookie data */
function f_getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

//creating uuid
function f_generateUUID() {
    var d = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
}
//check valid email
function isValidEmail(email)
{
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
//If image not found try length-1
function f_imageloaderr(self){
	console.log(self.src);
	// if image not available on original length then try length - 1
	if(self.src != undefined && self.src != ""){
		self.src = self.src.substring(0,self.src.indexOf(".jpg") - 1) + ".jpg";
		self.onerror = "";
	}
}
//Alert Modal
function showAlert(headerhtml,bodyhtml){
	$("#alertModal .modal-header h4").html(headerhtml)
	$("#alertModal .modal-body p").html(bodyhtml);
	$("#alertModal").modal("show");
}
//PRICE AND STOCK
/*Item search, price n stock info*/
function f_searchitem(){
	var item = $('#itemtosearch').val();
	var	imageurl = "https://www.pfconcept.com/portal/prodimage/small/";
	var	itemimageurl = imageurl + item.split(",")[0] + ".jpg";
	var pricenStock = {};
	if(item == "" || item.length < 8) {
		showAlert("Error!!","Please enter valid item code!!");
		return;
	}
	//$('.dvLoading').removeClass("hidden");
	$('#dvLoading').show();
	$("#productimage").attr("src",itemimageurl);
	var	uuid		= f_generateUUID();
		webaccount = $("#webaccount").val(),
		requestURL = preurl + "PriceAndStock?get_price_and_stock_req=",
		requestjson = {"price_and_stock_req":[]},
		requestparam = {
			"request_id": uuid,
			"version": "1",
			"website": "pfc",
			"material_nr": item,
			"qty": "1",
			"unit": "",
			"customer_number": webaccount,
			"sales_organization": "",
			"distribution_channel": "",
			"division": "",
			"call_stock": true,
			"call_price": true,
			"call_deco_price": true,
			"get_addons": true
		};
	requestjson["price_and_stock_req"].push(requestparam);
	//console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));
	console.log(url);
	$.get(url,function(data,status){
		$('#dvLoading').hide();
		console.log("status:", status,JSON.stringify(data,0,3));
		if (status == "success") {
			//$('.dvLoading').addClass("hidden");
			//$('.dvLoading').hide();
			if($.isEmptyObject(data.response.get_price_and_stock_rsp)){
				showAlert("Error!!","Material info not available");
				return;
			}

			pricenStock = data.response.get_price_and_stock_rsp.price_and_stock_rsp[0];

			//display result div
			$("#priceAndStockData").removeClass("hidden");

			//product(s) and currency information
			$("#products").text(pricenStock.material_nr);
			//$("#item").val(pricenStock.material_nr);
			$("#model").text(pricenStock.model);
			$("#item_model").val(pricenStock.model)
			$("#currency").text(pricenStock.currency);

			//Set values in hidden widgets
			var futurestockObj = {};
			var futurestocks = '';
			var itemlist = '';
			var prices = {};
			var pricelist = '';
			for (var j=0;j<pricenStock.products.length; j++){
				if(pricenStock.products[j].hasOwnProperty("stocks") || pricenStock.products[j].hasOwnProperty("prices")){
					itemlist = itemlist + '|' + pricenStock.products[j].material_nr;
					futurestockObj.future_stocks = pricenStock.products[j].stocks;
					futurestocks = futurestocks + '|' + JSON.stringify(futurestockObj);
				}
				if(pricenStock.products[j].hasOwnProperty("prices")){
					prices.column_prices = pricenStock.products[j].prices;
					if(pricenStock.products[j].material_nr.startsWith('1Z') || pricenStock.products[j].material_nr.startsWith('1P'))
						pricelist = pricelist + '|' + JSON.stringify(prices);
					else
						pricelist = JSON.stringify(prices);
				}
			}
			$("#future_stock").val(futurestocks);
			$("#itemlist").val(itemlist);
			$("#column_prices").val(pricelist);


			/* Addons check */
			var hasaddons = false;
			var addonsobj = JSON.parse(JSON.stringify(pricenStock));
			$.each(addonsobj.products,function(i,o){ //pass addons information only to createorder page
				if(o.hasOwnProperty("addons")) hasaddons = true;
				delete o.prices;
				delete o.decoprices;
			});
			if(hasaddons){
				$("#addons").val(JSON.stringify(addonsobj));
				f_dispAddons(pricenStock);
			}else{
				$("#addons-panel").addClass("hidden");
				$("#addons").val("");
			}

			//Show column pricing, stock information and decoration pricing panel
			$("#colpriceinfo,#stockinfo,#decoinfo,#addonsinfo").collapse("show");
			f_fetchStock(pricenStock);
			f_fetchColumnPrice(pricenStock);
			f_fetchDecoPrice(pricenStock);
		}
		else console.log("error:", status);
	});
}

function f_fetchColumnPrice(pricenStock){
 //console.log("pricenstock",pricenStock);
	var template = $("#columnPrice-template").html();
	var context = pricenStock;
	var templateScript = Handlebars.compile(template);
	var html   = templateScript(context);

	$("div#columnPrice-content").empty().append(html);

}

function f_fetchStock(pricenStock){

	var template = $("#itemStock-template").html();
	var context = pricenStock;
	var templateScript = Handlebars.compile(template);
	var html   = templateScript(context);

	$("div#itemStock-content").empty().append(html);

}

function f_dispAddons(pricenStock){

	var template = $("#addons-template").html();
	var context = pricenStock;
	var templateScript = Handlebars.compile(template);
	var html   = templateScript(context);

	$("#addons-content").empty().append(html);

}

function f_fetchDecoPrice(pricenStock){
	//var template = $("#decoPrice-template").html();
	//var context = pricenStock;
	//var templateScript = Handlebars.compile(template);
	//var html   = templateScript(context);

	//$("div#decoPriceInfo").append(html); return;
$("#decoPrice-content").empty();
$.each(pricenStock.products, function(pi,pv){
	var decoprices = pv.decoprices;
	//console.log(JSON.stringify(decoprices,0,3));
	$.each(decoprices, function(i,methodobj){ //each decoration method object
		var decoPricetable = '', decotableBody	= '<tbody>', tdDC = [], tdDL = [],tdDS = [],tdPP = [],tr=[],j=0,rowindexarr=[],rowindex="",
			decotableHeader = '<table class="table table-bordered"><caption>' + methodobj.method_description + '</caption><thead class="bg-slategray">' +
							   '<tr>';

			if(methodobj.decoitems[0].area > 1){ 			//Area column for textile item
				decotableHeader += '<th>Area</th>';
			}
			decotableHeader += '<th>Colors</th>';

			//Add Column quantity in header
			$.each(methodobj.decoitems[0].prices, function(){
				decotableHeader = decotableHeader + '<th>' + this.column_quantity + '+</th>';
			});
			decotableHeader +=  '<th>Setup charge per color</th>'
							  +	'<th>Prodproof per color</th>'
							  +	'<th>Min print charge</th></tr></thead>';
			//Body
			tdDC[0] ="", tdDL[0] ="", tdDS[0] ="", tdPP[0] ="", tr[0] = "";

			$.each(methodobj.decoitems, function(ideco,decoobj){ 	//each decoitems ; four objects(DC, DL, PP, DS) constitute a single row
				/*if(decoobj.colors.indexOf("-") > 0 ){*/

				rowindex = (decoobj.area > 1)? "A" + decoobj.area: "C" + decoobj.colors;
				if($.inArray(rowindex,rowindexarr) < 0){ //new row for new rowid
						j++;
						tdDC[j] = rowindex.startsWith("A")? '<td>max ' + (decoobj.area/100) + 'cm2</td>':"";
						rowindexarr.push(rowindex);
				}

				//console.log(ideco,"\n",tdDC,"\n",tdDL,"\n",tdDS,"\n",tdPP);
				tr[j] = "";
				switch(decoobj.itemc.substr(0,2)){
					case "DC":
						tdDC[j] += '<td>' + decoobj.colors + '</td>';
						$.each(decoobj.prices,function(indprice,objprice){
							tdDC[j] += '<td>' + objprice.price + '</td>';
						});
						break;
					case "DL":
						tdDL[j] = '<td>' + decoobj.prices[0].price + '</td>';
						break;
					case "DP":
						tdPP[j] = '<td>' + decoobj.prices[0].price + '</td>';
						break;
					case "DS":
						tdDS[j] = '<td>' + decoobj.prices[0].price + '</td>';

				}

			});

			$.each(tr,function(i,val){		//prepare row for a decoration method table
				if(i == 0) return;
				if(typeof tdDS[i] == 'undefined'){tdDS[i] = "<td>-</td>"};
				if(typeof tdPP[i] == 'undefined'){tdPP[i] = "<td>-</td>"};
				if(typeof tdDL[i] == 'undefined'){tdDL[i] = "<td>-</td>"};
				tr[i] = '<tr>' + tdDC[i] + tdDS[i] + tdPP[i] + tdDL[i] +'</tr>';
				decotableBody += tr[i];		//append each row to table body
			});
			decotableBody += '</tbody></table>';

			decoPricetable = decotableHeader + decotableBody;
			$("#decoPrice-content").append(decoPricetable);
		});
	});
}

function f_toCreateOrder(){
	/*var item = $("#product_code").text(),
		itemlist = $("#itemlist").val(),
		imageurl = $("div.image-block img").attr("src"),
		futurestock = encodeURI($("#future_stock").val()),
		columnprices = encodeURI($("#column_prices").val());
	if(futurestock == "{}")
		$.redirectPost(baseurl + "createorder.php",{"item": item ,"itemlist":itemlist, "imageurl":imageurl,"model":$("#item_model").val(), "columnprices":columnprices});
	else
		$.redirectPost(baseurl + "createorder.php",{"item": item ,"itemlist":itemlist, "imageurl":imageurl,"model":$("#item_model").val(), "futurestock":futurestock,"columnprices":columnprices});
	*/
}

//INVOICES
function f_getinvoice(){
	var invoicenum 	= $('#invoicenum').val() || 0;
	var	todate 		= $('#dateto').val();
	var	fromdate 	= $('#datefrom').val();
	var	uuid		= f_generateUUID();
	var	webaccount 	= $("#webaccount").val(),
		requestURL 	= preurl + "InvoiceOverview?get_invoiceoverview_req=",
		requestjson = {"get_invoiceoverview_req":[]},
		requestparam= {
			"request_id": uuid,
			"version": "999",
			"website": "pfconcept.com",
			"customer_number": webaccount,
			"invoice_number":invoicenum,
			"date_to":todate,
			"date_from":fromdate

		};
	requestjson["get_invoiceoverview_req"].push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));
	console.log(url);
	$('#dvLoading').show();
	//url = "invoicetest.php";
	$.get(url,function(data,status){
		$('#dvLoading').hide();

		if (status == "success") {
			$('.dvLoading').hide();
			if($.isEmptyObject(data.response.get_invoiceoverview_rsp)){
				showAlert("Message","Invoice is not available");
				return;
			}
			if(data.response.get_invoiceoverview_rsp.get_invoiceOverview_rsp[0].total_rows == 0){
				var html = '<div class="alert alert-danger text-center">No Invoices found!!</div>';
				$("div#invoice-content").empty().append(html);
				return;
			}
			//data = JSON.parse(data);
			console.log(JSON.stringify(data,0,3));

			var template	 	= $("#invoice-template").html();
			var context 		= data.response.get_invoiceoverview_rsp.get_invoiceOverview_rsp[0];
			var templateScript 	= Handlebars.compile(template);
			var html 			= templateScript(context);
			$("div#invoice-content").empty().append(html);

		}
		else console.log("error:", status);
	});

} //f_getinvoice

function f_getOrder(orderid){
	$('#dvLoading').show();
	var	uuid	   = f_generateUUID();
		webaccount = $('#webaccount').val(),
		requestURL = preurl + "Order?get_order_req=";
		requestjson = {"order_req":[]},
		requestparam = {
		  "request_id": uuid,
		  "version": "999",
		  "website": "999",
		  "customer_id": webaccount,
		  "order_id": orderid //3606787 test
		}
		requestjson["order_req"].push(requestparam);
		console.log(JSON.stringify(requestjson,0,3));
		url = encodeURI(requestURL + JSON.stringify(requestjson));
		$.get(url,function(data,status){
            $('#dvLoading').hide();
		    console.log("status:" + status);
		    if (status == "success") {
			    if($.isEmptyObject(data.response.get_order_rsp)){
				    showAlert("Message","Order info not available!");
				    return;
			    }
			    f_fetchOrderInfo(data.response.get_order_rsp.order_rsp[0]);

		    }
		    else console.log("error:", status);
		  });
}

function f_fetchOrderInfo(orderInfoData){
	console.log(JSON.stringify(orderInfoData,0,3));
	var template = $("#getorder-template").html();
	var context = orderInfoData;
	var templateScript = Handlebars.compile(template);
	var html = templateScript(context);

	$("#getorder-content").empty().append(html);
	//scroll to order details div
	$(window).scrollTop($('#orderdetails').offset().top-60); //60:offset due to fixed navbar
}

//CREATE ORDER PAGE
/*************Add item panel****************/
function f_addItemSearch(){
	var item = $('#additemcode').val();
	var	imageurl = "https://www.pfconcept.com/portal/prodimage/small/";
	var	itemimageurl = imageurl + item + ".jpg";
	if(item == "" || item.length < 8) {
		showAlert("Error!!","Please enter valid item code!!");
		return;
	}

	$("#additem-image").attr("src",itemimageurl).attr("onerror","f_imageloaderr(this)").parent().removeClass("hidden");
	var	uuid		= f_generateUUID();
		webaccount 	= $('#webaccount').val(),
		requestURL 	= preurl + "PriceAndStock?get_price_and_stock_req=",
		requestjson = {"price_and_stock_req":[]},
		requestparam = {
			"request_id": uuid,
			"version": "1",
			"website": "pfc",
			"material_nr": item,
			"customer_number": webaccount,
			"sales_organization": "",
			"distribution_channel": "",
			"division": "",
			"call_stock": "true",
			"call_future_stock": "true",
			"call_price": "true",
			"call_deco_price": "false"
		};
	requestjson["price_and_stock_req"].push(requestparam);
	//console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));
	$("#addedItemJson").val("");
	$('#dvLoading').show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();

		if (status == "success") {
			if($.isEmptyObject(data.response.get_price_and_stock_rsp)){
				showAlert("Message!!","Material info not available");
				return;
			}
			console.log(JSON.stringify(data,0,3));
			//save item json in hidden widget, will be used if item is selected after search
			$("#addedItemJson").val(JSON.stringify(data.response.get_price_and_stock_rsp.price_and_stock_rsp[0]));
		}
		else console.log("error:", status);
	});
}

function f_addItem(){
	var context = $("#addedItemJson").val();
	if(context == undefined || context == ""){
		showAlert("Error!!","Error occured while retrieving item info!!");
		return;
	}
	context = JSON.parse(context); // parse json
	//if same item exists already
	if($(".row.itemblock").find("td.itemcode:contains('"+context.material_nr+"')").length > 0){
		showAlert("Info!!","Added already.");
		return;
	}
	//if($("tr.itemBlock").find("input.model").val() !== context.model){
		//alert("Please select items of same model.");
		//return;
	//}
	if(context.material_nr.startsWith("1Z") || context.material_nr.startsWith("1p")){
	  showAlert("Info!!","World Source item must be configured alone!!");
	  return;
	}

	var template = $("#additem-template").html();
	var templateScript = Handlebars.compile(template);
	var html   = templateScript(context);
	//console.log(context.material_nr,typeof context);
	$("#itemblock-container").append(html);
	$("#addItem-wrapper").collapse("hide");
}
/*************  Add item panel end  ****************/
/************* Specify Quanity panel ***************/
function f_removeItemBlock(self){
	if($(".row.itemblock").length > 1){
		$(self).parent().remove();
	}
}

function f_getOrderSimulation(){ /* Onclick of Next button #qtyinputNext */

	var item,qty,productObj={},errorflag=false,emptyitems=false,itemcnt=1;
	var ordertype 	= "STD"; //test $("#dvOrdertype").find("input[type='radio']:checked").val();
	var ddadn 		= ($('#delivery_address').val() > '')?$('#delivery_address').val():'' ;
	var	uuid		= f_generateUUID();
	var	webaccount 	= $('#webaccount').val();
	var	requestURL 	= preurl + "OrderSimulation?get_order_simulation_req=";
	var	requestjson = {"order_simulation_req":[]};
	var	requestparam = {
		/*	"request_id": uuid,
			"version": "1",
			"website": "pfc",
			"order_reference_number": "999",
			"order_type": ordertype,
			"sales_organization": "",
			"distribution_channel": "",
			"division": "",
			"language_code": "",*/
			"customer_id": webaccount,
			"contact_id": "javrprs",
			"shipping_address_id": ddadn,
		/*	"payment_method": "",
			"shipping_method": "",*/
			"req_del_date": "",
			"Products": []
		};

	var modelist = '';
	var modindex = '';
	$(".row.itemblock").each(function(){

	var thismodel = $(this).find("input.model").val() ;
	modindex = modelist.indexOf(thismodel);
	if( modindex <= 0)
	modelist = modelist + ',' + thismodel;
  });
  modelist.trim(',');

  if (modelist.split(',').length > 2 ){
  	if (ordertype == 'STD'){
  		showAlert("Info!!","Only blank and default deco orders allowed with multiple models");
  		return;
  		}
  }

	$(".row.itemblock").each(function(){
  	emptyitems = true ;
  	$(this).find(".itemcode").each(function(){
    	item = $(this).text();
    	qty = 0;
      $('input[data-itemc="' + item + '"]').each(function() { //$('itemqty_item').each..
    		if($(this).val() != ""){
    		  //qty = qty + parseInt(($(this).val()));
				qty = parseInt(($(this).val())); }
			else {
				qty = 0
			};
    	if (qty != undefined && qty != "" && qty > 0){
      		console.log("quantity check" + qty);
      	    emptyitems = false;
      		productObj.material_nr	= item.trim();
      		productObj.line_id  = itemcnt;
      		productObj.qty			= qty;
      		productObj.req_delivery_date	= $(this).siblings("input.del_date").val();
      	    productObj.inhand_date				= $(this).siblings("input.del_decodate").val();
      	    requestparam.Products.push(productObj);
      	    itemcnt = itemcnt + 1;
    	  }
    		productObj = {};
    		});

  	});

  	if (emptyitems){
  		errorflag = true;
  		return;
  	}
  });

	requestjson["order_simulation_req"].push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));

	if(errorflag) {	//if errorflag is true then return
		showAlert("Warning","Please enter quantity for all items!!");
		return;
	}

	//Save requstjson in hidden widget inside addons block(to be used for simulation request with addons)
	$("#orderSimulationReqJson").val(JSON.stringify(requestjson));

	// Display confirm order button & hide error msg span on right side
	$("#dvorderResponseMsg").addClass("hidden");
	$("#btn-setOrder").removeClass("hidden");

	$('#dvLoading').show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();
		$('.col-right').removeClass("hidden");
		if (status == "success") {
			console.log(JSON.stringify(data,0,3));

			if(!$.isEmptyObject(data.response.get_order_simulation_rsp)){
				var orderSimulation = data.response.get_order_simulation_rsp.order_simulation_rsp[0];

				f_dispOrderSimulation(orderSimulation); // display order simulation
				if($("#delivery_address option").length == 0)
					f_deliveryAddress();	// display delivery address (will be used for setorder)

				// if order type is deco with logo,open upload logo accordion
				/*if(ordertype === "DDL" && orderSimulation.Products[0].hasOwnProperty("Decorations")){
					f_openUploadLogoSection(ordertype,orderSimulation);
				}else{
					$("#dvlogoUpload-placeholder").empty().closest("div.accordion-content").hide();
				}*/
			}

		}
		else console.log("error:", status);
	});

	if(ordertype == "STD")
	{
	  var decoProducts = [];
  	$("#requestParamBlank").val(JSON.stringify(requestparam));

  	$(".row.itemblock").each(function(){
			$(this).find(".itemcode").each(function(){
			item = $(this).text();
			qty = 0;
		  $('input[data-itemc="' + item + '"]').each(function() {
				if($(this).val() != "")
				qty = qty + parseInt(($(this).val()));
			});
			if (qty != undefined && qty != "" && qty > 0){
		  decoProducts.push({"itemc":item, "quantity":qty});
		  }
			});
	  });

  	f_getDecooptions(decoProducts);

	}

}

/************* Specify Quanity panel end ***************/

function f_dispOrderSimulation(orderSimulation){

	var template = $("#ordersimulation-template").html();
	var context = orderSimulation;
	var templateScript = Handlebars.compile(template);
	var html	= templateScript(context);

	$("#ordersimulation-content").empty().append(html);
}

//DeconPrice
 function f_getDecooptions(decoProducsts){

	var	uuid	= f_generateUUID();
	var webaccount = $('#webaccount').val();
	var requestURL = preurl + "GetDeconPrice?get_deco_price_req=";
	var requestjson = {"get_deco_price_req":[]};
	var requestparam = {
  	"request_id": uuid,
  	"version": "1",
  	"website": "pfc",
  	"customer_id": webaccount,
  	"deco_products":decoProducsts
	};
	requestjson["get_deco_price_req"].push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));
	$('#dvLoading').show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();
		if (status == "success") {
			console.log(JSON.stringify(data,0,3));
			//$("#itemDecoJson").val(JSON.stringify(data.response.deco_price_rsp.get_deco_price_rsp[0]));
			f_dispDecooptions(data.response.deco_price_rsp.get_deco_price_rsp[0]);
		}
	});

}
function f_dispDecooptions(context){
	//var context = $("#itemDecoJson").val();
	/*if(context == undefined || context == ""){
		alert("Error occured while retrieving decoration info!!");
		return;
	}
	context = JSON.parse(context); // parse json
	*/
	var template = $("#decoOptions-template").html();
	var templateScript = Handlebars.compile(template);
	var html   = templateScript(context);
	$("#decoOptions-content").empty().append(html); //add to the division

	//hide specify quantity accordion(collapse) and dispaly deco options block
	$("#specifyqty-wrapper").collapse("hide");
	$("#decoOptions-wrapper").collapse("show");
}

//On click of next button inside decoration option section
function f_selectDeco(){
	// perform order simulation for the selected item & decorations and open upload logo section

	var ddadn 	    = ($('#delivery_address').val() > '')?$('#delivery_address').val():'' ;
	var	uuid	    = f_generateUUID();
	var	webaccount 	= $('#webaccount').val();
	var	requestURL 	= preurl + "OrderSimulation?get_order_simulation_req=";
	var	requestjson = {"order_simulation_req":[]};
	var requestparam = JSON.parse($("#requestParamBlank").val());
	var url			 = "";
	var ordertype   = "STD";

	var decoInfoJson,decoSelectedArr=[],decoSelectedObj = {};
	var colors=0,areap="",errorFlag=false,errorMsg="";

	if($("#issureship").prop("checked")) // sureship order?
	  ordertype = $("#issureship").val();

	requestparam.order_type = ordertype;

	$.each(requestparam.Products, function(i,obj){
		decoSelectedArr=[];
		//iterate through selected Decoration(s) & prepare decoration object
		$(".dvdecoOption.selectedDeco").each(function(){

			colors = parseInt($(this).find(".color-select").val()) || 0;
			areap = $(this).find(".area-select").val() || "";

			//if color or area is not selected throw error
			if(colors == 0 &&(areap == "" || areap.indexOf("Area") > 0)){
				errorMsg = "Select color/area first";
				errorFlag = true;
				return false;
			}
			if(colors == 0){colors = 1;}
			decoInfoJson = $(this).find("input.decoInfoJson:hidden").val();
			decoInfoJson = JSON.parse(decoInfoJson);

		/*	decoSelectedObj.material_nr = decoInfoJson.itemc;*/
			decoSelectedObj.qty       = obj.qty;
			decoSelectedObj.line_id   = obj.line_id;
		/*	decologoObj.decorid	  = decoInfoJson.decorid;*/
			decoSelectedObj.configuration_id = decoInfoJson.configuration_id;
			decoSelectedObj.length    = decoInfoJson.Max_length;
			decoSelectedObj.width  	  = decoInfoJson.Max_width;
			decoSelectedObj.colors 	  = colors;
			decoSelectedObj.diameter  = decoInfoJson.Diameter;
			decoSelectedObj.pproof    = false;

			decoSelectedArr.push(decoSelectedObj);
			decoSelectedObj = {};

		});
		if(errorFlag) return false;
		/*if(typeof requestparam !== "object"){
			errorMsg = "Error occured while preparing request";
			errorFlag = true;
		}*/

		console.log(JSON.stringify(decoSelectedArr,0,3));

		// push selected decorations inside products, single product for now
		//requestparam.Products[0].Decorations = decoSelected;

		obj.Decorations = decoSelectedArr;
	});

	if(errorFlag){
		showAlert("Error!!",errorMsg);
		return;
	}

	requestjson["order_simulation_req"].push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));

	//Save requstjson in hidden widget inside addons block(to be used for simulation request with addons)
	$("#orderSimulationReqJson").val(JSON.stringify(requestjson));

	url = encodeURI(requestURL + JSON.stringify(requestjson));

	$('#dvLoading').show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();
		if (status == "success") {
			console.log(JSON.stringify(data,0,3));

			if(!$.isEmptyObject(data.response.get_order_simulation_rsp)){
				var orderSimulation = data.response.get_order_simulation_rsp.order_simulation_rsp[0];

				f_dispOrderSimulation(orderSimulation); // display order simulation
				$("#btn-setOrder").removeClass("hidden"); 		//show set order button
				f_openUploadLogoSection(ordertype,orderSimulation);

			}

		}
		else console.log("error:", status);
	});

}

// creates div for logo upload for each item and open upload logo accordion
function f_openUploadLogoSection(ordertype,orderSimulation){

	var deconlogoContext={"deconlogo":[]};
	var decologoObj = {};
	var imprintIDs = "";

	$.each(orderSimulation.Products,function(prodIndex,prodObj){
		console.log("prodIndex" + prodIndex);
		if (prodIndex == 0){
		  /*store selected decorations sku in variable*/
		  $.each(prodObj.Decorations,function(decoIndex,decoObj){
		    imprintIDs += ((imprintIDs === "")? decoObj.image_sku : "," + decoObj.image_sku);
		  });
  		$.each(prodObj.Decorations,function(decoIndex,decoObj){
  			decologoObj.itemc 	  = prodObj.material_nr;
  			//decologoObj.line_id   = prodObj.line_id;
  			//decologoObj.qty       = prodObj.qty;
  			decologoObj.method 	  = decoObj.method;
  			decologoObj.description = decoObj.description;
  			decologoObj.configuration_id  = decoObj.configuration_id;
  			decologoObj.colors 	  = decoObj.colors;
  			decologoObj.length    = decoObj.length;
  			decologoObj.width  	  = decoObj.width;
  			decologoObj.image_sku = decoObj.image_sku;
  			decologoObj.imprintids = imprintIDs;

  			deconlogoContext.deconlogo.push(decologoObj);
  			decologoObj = {};
  		});
	  }
	});
	console.log(JSON.stringify(deconlogoContext,0,3));

	var template = $("#logoUpload-template").html();
	var context = deconlogoContext; //logoContext;
	var templateScript = Handlebars.compile(template);
	var html   = templateScript(context);

	$("#dvlogoUpload-content").empty().append(html);//.closest("div.accordion-content").show();
	//$(".dvLogoSection.dvAccordion").slideDown().siblings("h2.accordionHeader").addClass("active");
	//Close decooptions panel and open upload logo panel
	$("#decoOptions-wrapper").collapse("hide");
	$("#logoUpload-wrapper").collapse("show");
}
function f_setOrder(){

	var	uuid		= f_generateUUID();
	var	webaccount 	= $('#webaccount').val();
	var	requestURL 	= preurl + "Order";
	var	requestjson = {"request":{
						 "set_order_req":{
							"order_req":[]
							}
						}
					  };
    var ordercomment = "";
	var orderref = $("#setOrderRef").val();
	$("#setOrderRef").val(""); //clear the value
    //var orderref = prompt("Order Reference:");
	//orderref = (orderref == null)? "" : orderref;
    var	requestparam = {
				"request_id": uuid,
				"version": "1",
				"website": "pfconcept.com",
				"order_comment": ordercomment,
				"order_reference": orderref,
				"order_type":"",
				"customer_number": webaccount,
				"contact_id": "javrprs",
				"shipping_address_id": Number($("#delivery_address").val()) || 0,
				"req_delivery_date": null,
				"currency": "EUR",
				"products": []
			};
	var	prodobj = {}, itemcode ="",price=0,qty=0,decoObj={}, decoJsonData="",configid="",decoOptionData="";
	var productArr=[],decorationArr = [], artArr  = [],decoRefArr=[],configidArr=[],productCounter = 0,decoCounter = 0, artCounter = 0;
	var errorFlag = false, errorMsg = "";
	var decoOptionsObj	 = {};
	var decorationRefObj = {};
	var artRefObj		 = {};
  var addonsRefObj = {}, addonsObj = {};
	var addonsRefArr = [], addonsArr = [];
  var addonscounter = 0;

	// get products in prodobj object and push it to 'Product' array
	//$("tr.itemBlock").each(function(){
		//itemcode = $(this).find("td.itemcode").text().trim();
	$("td.itemcode").each(function(){
		itemcode = $(this).text().trim();
		price	 = Number($("#price_"+itemcode).text());

		//$(this).find(".qtyinput").each(function(){
		$("input.itemqty_" + itemcode).each(function(){
			qty = parseInt($(this).val());
			if(isNaN(qty)) return;

			//prodobj.order_reference_number 	= orderref;
			prodobj.order_line				= ++productCounter;
			prodobj.material_number 		= itemcode;
			prodobj.qty 					= qty;
			prodobj.price 					= price;
			prodobj.req_delivery_date		= $(this).siblings("input.del_date").val();
			prodobj.inhand_date				= $(this).siblings("input.del_decodate").val();

			productArr.push(prodobj); //requestparam.Product.push(prodobj);
			prodobj = {};
		});
	}); /* each product */

	 //if Addons exists
	 if($("table.addonstbl").length && $("tr.addonsrow").length){

		 $(".addonsrow.simulated").each(function(){
			 addonsRefObj.addonref_id  = ++addonscounter;
			 addonsObj.addonref_id	 	 = addonscounter;
			 addonsObj.material_number = $(this).find(".addonitem").text().trim();
			 addonsObj.qty 						 = Number($(this).find(".qty").text());
			 addonsObj.price 					 = Number($(this).find(".price").text());

			 addonsRefArr.push(addonsRefObj);
			 addonsArr.push(addonsObj);
			 addonsObj 		= {};
			 addonsRefObj = {};
		 });

	 }

		//if decoration exists
		if($("table.decoPriceOverviewtbl").length && $(".decoration.simulated").length){

			decoRefArr=[]; //prodobj.DecorationReferences = [];

			$(".decoration.simulated").each(function(){

				configid 		= $(this).attr("data-configid");
				if($.inArray(configid,configidArr) > -1) return; //continue to next
				configidArr.push(configid);	// push configid to configid array

				decoJsonData 	= $("#deco_" + configid).val();

				if(decoJsonData !== undefined && decoJsonData !== ""){
					//get deco info(standard info)
					decoObj 	= JSON.parse(decoJsonData);

					decorationRefObj.decoreference_id = ++decoCounter; //Decoration Reference

					decoObj.decoreference_id = decoCounter;
					//decoObj.material_number = itemcode;

					//get decoinstruction,pms,length,width etc(additional info)
					decoOptionData = $("#decoOptionsObj_" + configid).val();
					if(decoOptionData !== undefined && decoOptionData!== ""){
						decoOptionsObj = JSON.parse(decoOptionData);

						decoObj.colors 			 = decoOptionsObj.colors
						decoObj.length 			 = decoOptionsObj.length;
						decoObj.width  			 = decoOptionsObj.width;
						decoObj.pms    			 = decoOptionsObj.pms;
						decoObj.deco_instruction = decoOptionsObj.deco_instruction;
						decoObj.configuration_id = decoOptionsObj.configuration_id;

					}
					//check for art(logo)
					if($(".dvDeconLogo .dvLogoUpload").length > 0){

						var artObjData = $("#artInfoObj_" + configid).val();

						if(artObjData != undefined && artObjData != ""){
							decoObj.art_references = [];		//Art reference
							artObjData = JSON.parse(artObjData);

							$.each(artObjData.art,function(artObjIndex,artObj){
								artRefObj.artreference_id = ++artCounter;		//Art reference
								artObj.artreference_id    = artCounter;

								decoObj.art_references.push(artRefObj);		//push Art Reference inside decoration object
								artArr.push(artObj);						//push Art object inside art array
								artRefObj = {};
							});

							//decoObj.art = artObj.art;	//array of object
						}else{
							//errorFlag = true;
							errorMsg += errorMsg.trim().length ? " | " + configid : "No logo found for decoration(s): " + configid;

						}
					}

					//prodobj.DecorationReferences.push(decorationRefObj); 	//push decorationReference object inside product
					decoRefArr.push(decorationRefObj);
					decorationArr.push(decoObj);
					decoObj = {};
					decorationRefObj = {};

				} /*if decojson data available*/
			}); /* each decoration*/
		} // if decorated order

		if(addonsRefArr.length){
				$.each(productArr, function(i,obj){			//push addonsReferences to corresponding products
						obj.addon_references = addonsRefArr;
				});
				requestparam.addons = addonsArr;
		}

	if(decoRefArr.length){
			$.each(productArr, function(i,obj){			//push decorationReferences to corresponding items
				//if(obj.material_number == itemcode){
					obj.decoration_references = decoRefArr;
				//}
			});
	}

	requestparam.products = productArr;
	if(decorationArr.length) {
		requestparam.decorations = decorationArr;
		requestparam.order_type = "STD";
	}
	if(artArr.length)
		requestparam.artworks = artArr;

	requestjson.request.set_order_req.order_req.push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));

	// if error occurs
	if(errorFlag && errorMsg !== ""){
		showAlert("Error!!",errorMsg);
		return;
	}
	if(errorMsg !== "") showAlert("Error!!",errorMsg);
	url = encodeURI(requestURL);
//return;
	$('#dvLoading').show();
	$.ajax({
		"url":url,
		"contentType": "application/json",
		"type":"post",
		"data": JSON.stringify(requestjson),
		"success":function(responsedata){
			$("#dvLoading").hide();
			//display setorder response message on screen& hide confirm order button
			console.log(JSON.stringify(responsedata,0,3));
			$("#orderRespAlertCloned").remove(); //if alert is already there remove it
			$("#dvorderResponseMsg").clone().attr("id","orderRespAlertCloned")
										                  .removeClass("hidden")
											                .insertAfter("#dvorderResponseMsg")
											                .find("span.message").text(responsedata.response.set_order_rsp.get_quote_rsp[0].message);
			$("#btn-setOrder").addClass("hidden");
		},
		"error":function(jqxhr){
			$("#dvLoading").hide();
			$("#orderRespAlertCloned").remove();  //if alert is already there remove it
			$("#dvorderResponseMsg").clone().attr("id","orderRespAlertCloned")
										                  .removeClass("hidden")
											                .insertAfter("#dvorderResponseMsg")
											                .find("span.message").html("<b>Error:</b> " + JSON.parse(jqxhr.responseText).response.message);
		}
	});
}

function f_deliveryAddress(){
	var searchtxt = $('#searchtxt').val();

	var	uuid	   = f_generateUUID();
		webaccount = $('#webaccount').val(),
		requestURL = preurl + "CustomerAddress?get_customer_address_req=";
		requestjson = {"customer_address_req":[]},
		requestparam = {
		  "request_id": uuid,
		  "version": "1",
		  "website": "pfc",
		  "customer_id": webaccount,
		  "type": "DLV",
		  "searchtxt" : searchtxt
		}
		requestjson["customer_address_req"].push(requestparam);
		url = encodeURI(requestURL + JSON.stringify(requestjson));

		$('#dvLoading').show();
		$.get(url,function(data,status){
        $('#delivery_address').empty();
        $('#dvLoading').hide();
		    if (status == "success") {
			    if(!$.isEmptyObject(data.response.get_customer_address_rsp.customer_address_rsp)){
					//console.log(JSON.stringify(data.response.get_customer_address_rsp.customer_address_rsp[0].addresses,0,3));
				    $(data.response.get_customer_address_rsp.customer_address_rsp[0].addresses).each(function(){
					     var option = $('<option />');
						 option.attr('value', this.address_id).text(this.street + ',' + this.zipcode + ',' + this.city + ',' + this.country).attr('data-addvalue', this.street + ',' + this.city + ',' + this.zipcode + ',' + this.country);
						 $('#delivery_address').append(option);
					 });
					$('.addresstext').val($('#delivery_address').find('option:selected').attr('data-addvalue'));
					$("#deliveryadd-wrapper").removeClass("hidden");
			    }
		    }
		    else console.log("error:", status);
		  });
}

function f_addComboValueChange(){
  $('.addresstext').val($('#delivery_address').find('option:selected').attr('data-addvalue'));
}

//Personal settings(add contact)
function f_addContact()
{
	var uuid        = f_generateUUID();
	var url         = preurl + "Contact";
	var	requestjson = {"request":{
						 "set_contact_req":{
							"contact_req":[]
							}
						}
					  };
	var firstname = $("#cfirstname").val();
	var surname   = $("#csurname").val();
	var phone     = $("#cphone").val();
	var func      = $("#cfunction").val();
	var email     = $("#cemail").val();
	var website   = $("#cwebsite").val();
	var fax       = $("#cfax").val();
	var faxno     = $("#cfaxoneproof").val();
	var userid    = $("#upuserid").val();
	var passwd    = $("#uppassword").val();
/*	var stp       = $("#tradingprices").prop("checked");
	var sp        = $("#showprices").prop("checked");
	var ao        = $("#alloworder").prop("checked");
	var si        = $("#showinvoices").prop("checked");*/
	var add       = parseInt($("#deliveryadd").val());
	var disclaimer = $("#snwdisclaimer").val();
	var webaccount = $('#webaccount').val().trim();

	requestjson.request.set_contact_req.contact_req.push({
		"request_id": uuid,
		"version": "1",
		"website": "pfconcept.com",
		"customer_id": webaccount,
		"dconc": userid,
		"dconm": firstname,
		"dcontsurname": surname,
		"dcontfunction": func,
		"dcontemail": email,
		"dconttel": phone,
		"dcontfax": fax,
		"dcontpassword": passwd,
		"dcontdisclaimer": disclaimer,
		/*"ddadn": add,
		"dconlprice": sp,
		"dconlorder": ao,
		"dconlinvoices": si,
		"dconltradprice": stp */
    });
	if (firstname == '' || email == '' || passwd == '' || userid == ''){
		showAlert("Error!!","Please enter required field");

	}else{
		if (!isValidEmail(email)){
			showAlert("Error!!","Please enter valid email address");
		}else{
			$("#dvLoading").show();
			console.log(JSON.stringify(requestjson,0,3));
			$.ajax({
				"url":url,
				"contentType": "application/json",
				"type":"post",
				"data": JSON.stringify(requestjson),
				"success":function(responsedata){
					$("#dvLoading").hide();
					console.log(JSON.stringify(responsedata,0,3));
					if($.isEmptyObject(responsedata.response.set_contact_rsp)){
					  showAlert("Error!!","Sorry, something went wrong. Contact couldn't be created :(");
					  return;
					}
					showAlert("Message",responsedata.response.set_contact_rsp.contact_rsp[0].message);

				}
			});
		}

	}
}

function f_confirmDeco(){

	var ddadn 	    = ($('#delivery_address').val() > '')?$('#delivery_address').val():'' ;
	var	uuid	    = f_generateUUID();
	var	webaccount 	= $('#webaccount').val();
	var	requestURL 	= preurl + "OrderSimulation?get_order_simulation_req=";
	var	requestjson = {"order_simulation_req":[]};
	var requestparam = JSON.parse($("#requestParamBlank").val());
	var url			 = "";
	var ordertype   = "STD";

	var decoInfoJson,decoSelected=[],decologoObj = {};
	var errorFlag=false,errorMsg="",configid=""; //,colors=0,xyz="";

	//iterate through selected Decoration(s) & prepare decoration object
	$.each(requestparam.Products, function(i,obj){
		$(".dvDeconLogo").each(function(){
			var decoOptionsObj = {};
			configid = $(this).attr("data-configid");
			decologoObj.material_nr = obj.material_nr;
			decologoObj.qty       = obj.qty;
			decologoObj.line_id   = obj.line_id;
			//decologoObj.decorid	  = $(this).attr("data-decorid"); //decoInfoJson.decorid;
			decologoObj.configuration_id = configid ;//decoInfoJson.configuration_id;
			decologoObj.length    = parseInt($("#length_" + configid).val()) || 0;
			decologoObj.width  	  = parseInt($("#width_" + configid).val()) || 0;
			decologoObj.colors 	  = parseInt($("#colors_" + configid).val()) || 1;
			decologoObj.diameter  = parseInt($("#diameter_" + configid).val()) || 0;
			decologoObj.pproof  =  $("#pproof_" + configid).prop("checked");

			decoSelected.push(decologoObj); //push to decoration array

			decoOptionsObj = $.extend({},decologoObj); //copy to decoOptionsObj to save it in hidden field(will be used for setorder request)
			decoOptionsObj.pms      		= $("#pms_" + configid).val();
			decoOptionsObj.deco_instruction = $("#decoInstruction_" + configid).val();
			$("#decoOptionsObj_" + configid).val(JSON.stringify(decoOptionsObj)); //save in hidden field

			decologoObj = {};

		});
			obj.Decorations = decoSelected;
			decoSelected = [];
	});

	if(typeof requestparam !== "object"){
		errorMsg = "Error occured while preparing request";
		errorFlag = true;
	}

	if(errorFlag){
		showAlert("Error!!",errorMsg);
		return;
	}

	requestjson["order_simulation_req"].push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));

	//Save requstjson in hidden widget inside addons block(to be used for simulation request with addons)
	$("#orderSimulationReqJson").val(JSON.stringify(requestjson));

	url = encodeURI(requestURL + JSON.stringify(requestjson));

	$('#dvLoading').show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();
		if (status == "success") {
			console.log(JSON.stringify(data,0,3));

			if(!$.isEmptyObject(data.response.get_order_simulation_rsp)){
				var orderSimulation = data.response.get_order_simulation_rsp.order_simulation_rsp[0];

				f_dispOrderSimulation(orderSimulation); // display order simulation
			}
		}
		else console.log("error:", status);
	});
}

function f_confirmLogo(){

	var falsyitems = "";

	$("#dvlogoUpload-content .dvDeconLogo").each(function(){
		var artInfoObj = {"art":[]};

		var configid = $(this).attr("data-configid");
		var origObj = {},layoutObj = {};
		var itemc 	= $(this).attr("data-itemc");
		var sku	  	= $(this).attr("data-sku");
		var origImage   = $("#origurl_" + sku).val();	//$(this).find(".origImage").attr("src");
		var layoutImage = $("#layoutImage_" + sku).attr("src");	//$(this).find(".layoutImage").attr("src") || "";
		var designid = $("#designid_" + sku).val();

		if(origImage == undefined || origImage == ""){
			falsyitems += configid /*itemc*/ + " ";
			return true;
		}
		// Save art info provided
		origObj.art_type = "ORIG";
		origObj.art_url  = origImage;
		origObj.design_id = designid;
		//imgname			= copyImage(origImage);
		//origObj.art_name = imgname;

		layoutObj.art_type = "LAYOUT";
		layoutObj.art_url  = layoutImage;
		layoutObj.design_id = designid;
		//imgname		     = copyImage(layoutImage);
		//layoutObj.art_name = imgname;

		//push orig object and layout object to artInfoObj
		artInfoObj.art.push(origObj);
		artInfoObj.art.push(layoutObj);

		$("#artInfoObj_" + configid).val(JSON.stringify(artInfoObj));
		console.log(JSON.stringify(artInfoObj,0,2));

	});
	if(falsyitems != ""){
		/*alert("Please upload logo for item(s): " + falsyitems);*/
		showAlert("Error!!","Logo not uploaded for all selected decorations.<br>Not uploaded for: " + falsyitems);
	}else{
		showAlert("Message","Logo confirmed");
	}

}

//format date to yyyy-mm-dd format
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
} //formatDate(date)

//Previous/Next order overview
function f_prevnextorder(self){
	var recordsperpage = 10;
	var rangefrom = $(self).attr("data-from"); console.log("rangefrom:", rangefrom);
	if($(self).hasClass("disabled") || rangefrom === "" || rangefrom === undefined)
		return;

	/****** trigger search ******/
	$("#rangefrom").val(rangefrom);
	$("#rangemax").val(recordsperpage.toString());
	f_searchOrderOverview();

	/*** adjust parameters for prev/next after navigating to previous or next set of records ***/
	var totalrows;
	var startpos,prevstart,nextstart;
	var type = $(self).attr("data-find"); //prev or next

	if(type === "prev"){
		startpos = parseInt(rangefrom) - recordsperpage;
		nextstart = startpos + 2*recordsperpage;
		if(isNaN(startpos) || (startpos < 1)){
			startpos = 1;
			nextstart = 1 + recordsperpage;
			$(self).addClass("disabled");
		}
		$(".orderovpager .prev").attr("data-from", startpos.toString());
		$(".orderovpager .next").attr("data-from", nextstart.toString()).removeClass("disabled");

	}
	if(type === "next"){
		startpos  = parseInt(rangefrom) + recordsperpage;
		prevstart = startpos - 2*recordsperpage;
		totalrows = parseInt($(self).attr("data-totalrows"));
		if(isNaN(totalrows) || (totalrows < startpos)){
			startpos = startpos - recordsperpage;

			$(self).addClass("disabled");
		}
		$(".orderovpager .next").attr("data-from", startpos.toString());
		$(".orderovpager .prev").attr("data-from", prevstart.toString()).removeClass("disabled");
	}

}


//Search Order Overview
function f_searchOrderOverview(){
	var	uuid		= f_generateUUID();
	var	webaccount 	= $('#webaccount').val();
	var datefrom	= $("#datefrom").val();
	var dateto   	= $("#dateto").val();
	var	requestURL 	= preurl + "OrderOverview?get_order_overview_req=";
	var	requestjson = {"order_overview_req":[]};
	var	requestparam = {
			"request_id": uuid,
			"version": "1",
			"website": "pfc",
			"customer_id": webaccount,
			"date_from": datefrom !== "" ? formatDate(new Date(datefrom)):"",
			"date_to": dateto !== "" ? formatDate(new Date(dateto)):"",
			"status": $("#status").val(),
			"sales_order": $("#salesorder").val(),
			"reference": $("#reference").val(),
			"material_nr": $("#material_nr").val(),
			"materialvendor": $("#materialvendor").val(),
			"range_from": $("#rangefrom").val(),
			"range_max": $("#rangemax").val()
		};
	requestjson["order_overview_req"].push(requestparam);
	console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));
	$('#dvLoading').show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();

		if (status == "success") {
			if($.isEmptyObject(data.response.get_order_overview_rsp)){
				showAlert("Message!!","Order info not available");
				return;
			}
			console.log(JSON.stringify(data,0,3));
			//display the search result
			var context = data.response.get_order_overview_rsp.order_overview_rsp[0];
			var template = $("#orderoverview-template").html();
			var templateScript = Handlebars.compile(template);
			var html   		= templateScript(context);
			$("#orderoverview-table>tbody").empty().append(html);
		}
		else console.log("error:", status);
	});
} //f_searchOrderOverview

function f_customerAddress(){

	var	uuid	   = f_generateUUID();
		webaccount = $('#webaccount').val(),
		requestURL = preurl + "CustomerAddress?get_customer_address_req=";
		requestjson = {"customer_address_req":[]},
		requestparam = {
		  "request_id": uuid,
		  "version": "1",
		  "website": "pfc",
		  "customer_id": webaccount,
		  "type": "DLV",
		  "searchtxt" : ""
		}
		requestjson["customer_address_req"].push(requestparam);
		url = encodeURI(requestURL + JSON.stringify(requestjson));

		$('#dvLoading').show();
		$.get(url,function(data,status){
			$('#dvLoading').hide();
		    if (status == "success") {
			    if(!$.isEmptyObject(data.response.get_customer_address_rsp.customer_address_rsp)){
					//console.log(JSON.stringify(data.response.get_customer_address_rsp.customer_address_rsp[0].addresses,0,3));
				    $.each(data.response.get_customer_address_rsp.customer_address_rsp[0].addresses, function(ind,obj){
					     $('#deliveryadd').append($('<option>', {value:obj.address_id, text:(obj.street + ',' + obj.zipcode + ',' + obj.city + ',' + obj.country)}));

					 });

			    }
		    }
		    else console.log("error:", status);
		});
}

function f_selectAddon(){
	var addonsArr = [], addonsObj={};
	var	requestURL 	= preurl + "OrderSimulation?get_order_simulation_req=";
	var requestjson = $("#orderSimulationReqJson").val();

	if(requestjson == undefined || requestjson == "" ||requestjson === "{}" ){
		showAlert("Error!!", "Sorry, couldn't process the request");
		return;
	}

	$(".dvAddonsOption.selected").each(function(){
		addonsObj.addonitem = $(this).find(".addonitem").text().trim();
		addonsArr.push(addonsObj);
		addonsObj={};
	});

	requestjson = JSON.parse(requestjson);
	if(addonsArr.length){
		$.each(requestjson.order_simulation_req[0].Products, function(i,obj){
			obj.Addons = addonsArr;
		});
	}

	console.log(JSON.stringify(requestjson,0,3));
	url = encodeURI(requestURL + JSON.stringify(requestjson));

	$("#dvLoading").show();
	$.get(url,function(data,status){
		$('#dvLoading').hide();
		if (status == "success") {
			console.log(JSON.stringify(data,0,3));

			if(!$.isEmptyObject(data.response.get_order_simulation_rsp)){
				var orderSimulation = data.response.get_order_simulation_rsp.order_simulation_rsp[0];

				f_dispOrderSimulation(orderSimulation); // display order simulation

			}

		}
		else console.log("error:", status);
	});

}
