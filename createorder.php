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
  <div class="container-fluid"  style="margin-top:60px;">
    <div class="row">
      <div class="col-sm-6">
        <div class="panel-group" style="margin-top:22px;">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title"><a class="btn-block" href="#addItem-wrapper" data-toggle="collapse"> Add Item </a>
              </h4>
            </div>
            <div id="addItem-wrapper" class="collapse">
              <div class="panel-body bg-alice">
                <div class="dvAddItemBlock">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="input-group">
                        <input type="text" id="additemcode" data-entertrigger="#addItemSearchbtn" maxlength="8" class="form-control" value="">
                        <div class="input-group-btn">
                          <button type="button" id="addItemSearchbtn" class="btn btn-info" onclick="f_addItemSearch()">Search</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5"></div>
                  </div>
                  <div class="row" style="margin-top:8px;">
                    <div class="col-xs-4 col-sm-3">
                      <div id="additemImage-wrapper" class="hidden" onclick="f_addItem()">
                        <img id="additem-image" class="img-responsive img-thumbnail">
                        <p class="additemtext">Click to add</p>
                        <input type="hidden" id="addedItemJson" value="">
                      </div>
                    </div>
                    <div class="col-xs-8 col-sm-9"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h4 class="panel-title"><a class="btn-block" href="#specifyqty-wrapper" data-toggle="collapse"> Specify Quantity </a></h4>
            </div>
            <div id="specifyqty-wrapper" class="collapse in">
              <div class="panel-body bg-alice">
                <div id="itemblock-container">
                  <div class="promptqty itemblock row" style="border:1px solid lightseagreen;padding:4px;border-radius:6px;margin-bottom:1px;">
                    <button class="close" onclick="f_removeItemBlock(this)">&times</button>
                    <div class="col-sm-3 text-center">
                      <img class="itemimage img-responsive img-thumbnail" src="<?php if(isset($_POST["imageurl"])) echo $_POST["imageurl"] ?>" style="margin-top:25%;">
                        <input type="hidden" class="model" value="<?php if(isset($_POST["model"])) echo $_POST["model"] ?>">
                      </div>
                      <div class="col-sm-9">
                        <div class="table-responsive">
                          <table class="promptQtyInnertbl table table-bordered table-condensed" style="font-size:smaller;">
                            <thead class="bg-slategray">
                              <tr>
                                <th>Size</th>
                                <th>Product</th>
                                <th>Availability</th>
                                <th>Avail.Qty</th>
                                <th>Quantity</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $itemlist = urldecode($_POST["itemlist"]);
                              $itemlist = trim($itemlist,'|');
                              $itemarray = explode('|', $itemlist);
                              $arraycnt = count($itemarray);
                              if(substr($itemlist,0,2) == "1Z" || substr($itemlist,0,2) == "1P"){
                                for($j = 0;$j<$arraycnt; $j++){
                                  echo '<tr><td>NA</td><td class="itemcode">'.$itemarray[$j].'</td><td>On stock</td><td>-</td><td><input type="number" min="0" class="qtyinput itemqty_'.$itemarray[$j].'"  data-itemc="'.$itemarray[$j].'"  style="width:75px;" ></td></tr>';
                                }
                              }
                              else{
                                if (isset($_POST["futurestock"])){
                                  $futurestocks = urldecode($_POST["futurestock"]);
                                  $itemlist = urldecode($_POST["itemlist"]);
                                  $itemarray = explode('|', $itemlist);
                                  $array = explode('|', $futurestocks);
                                  $arraycnt = count($array);
                                  for($j = 1;$j<$arraycnt; $j++){
                                    $futurestock = $array[$j];
                                    $futurestock = json_decode($futurestock,true);
                                    $futurestock = $futurestock["future_stocks"];
                                    $arrlength	  = count($futurestock);
                                    for($i = 0;$i<$arrlength; $i++){
                                      $colqtyrow = "";
                                      if($i == 0)
                                      {$colqtyrow   = $colqtyrow.'<td>NA<td class="itemcode">' . $itemarray[$j]  . '</td><td>On stock</td><td>'. $futurestock[$i]["stock"] .' </td><td><input type="hidden" class="del_date" value="'. $futurestock[$i]["del_date"] .'"><input type="hidden" class="del_decodate" value="'. $futurestock[$i]["del_decodate"] .'" ><input type="number" min="0" class="qtyinput itemqty_'.$itemarray[$j].'" data-itemc="'.$itemarray[$j].'" style="width:75px;" autofocus></td>';}
                                      else
                                      {$colqtyrow   = $colqtyrow.'<td><td><td>'. $futurestock[$i]["avail_date"] .' </td><td>'. $futurestock[$i]["stock"] .' </td><td><input type="hidden" class="del_date" value="'. $futurestock[$i]["del_date"] .'"><input type="hidden" class="del_decodate" value="'. $futurestock[$i]["del_decodate"] .'" ><input type="number" min="0" class="qtyinput itemqty_'.$itemarray[$j].'" data-itemc="'.$itemarray[$j].'" style="width:75px;" ></td>';}
                                      $colqtyrow   = '<tr>'.$colqtyrow.'</tr>';
                                      echo $colqtyrow;
                                    }
                                  }
                                }
                              }
                              ?>
                              <tr>
                                <td colspan="5">
                                  <?php
                                  if (isset($_POST["columnprices"])){
                                    $columnprices = urldecode($_POST["columnprices"]);
                                    $pricesarray = explode('|', $columnprices);
                                    $itemlist = urldecode($_POST["itemlist"]);
                                    $itemsarray = explode('|', $itemlist);
                                    $arraycnt	  = count($pricesarray);
                                    for($j = 0;$j<$arraycnt; $j++){
                                      $colqtyrow = 	$colpricerow = "";
                                      $columnprice = $pricesarray[$j];
                                      $columnprice = json_decode($columnprice,true);
                                      $columnprice = $columnprice["column_prices"];
                                      $arrlength	  = count($columnprice);
                                      for($i = 0;$i<$arrlength; $i++){
                                        $colqtyrow   = $colqtyrow.'<td>'. $columnprice[$i]["column_quantity"] .'+ </td>';
                                        $colpricerow = $colpricerow.'<td>'. $columnprice[$i]["price"] .'</td>';
                                      }
                                      $colqtyrow   = '<tr>'.$colqtyrow.'</tr>';
                                      $colpricerow = '<tr>'.$colpricerow.'</tr>';
                                      echo '<table class="table table-bordered table-collapsed" style="width:100%;background:beige;margin-top:15px;">'.$colqtyrow .$colpricerow.'</table>';
                                    }
                                  }
                                  ?>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script id="additem-template" type="text/x-handlebars-template">
                    <div class="promptqty showborder itemblock row" style="border:1px solid lightseagreen;padding:4px;border-radius:6px;margin-bottom:1px;">
                      <button class="close" onclick="f_removeItemBlock(this)">&times</button>
                      <div class="col-sm-3 text-center">
                        <img class="img-responsive itemimage img-thumbnail" src="https://www.pfconcept.com/portal/prodimage/small/{{material_nr}}.jpg" onerror="f_imageloaderr(this)" style="margin-top:25%;">
                        <input type="hidden" class="model" value="{{model}}">
                      </div>
                      <div class="col-sm-9">
                        <div class="table-responsive">
                          <table class="promptQtyInnertbl table table-bordered table-condensed" style="font-size:smaller;">
                            <thead class="bg-slategray">
                              <tr>
                                <th>Size</th>
                                <th>Product</th>
                                <th>Availability</th>
                                <th>Avail.Qty</th>
                                <th>Quantity</th>
                              </tr>
                            </thead>
                            <tbody>
                              {{#each products}}
                              {{#each stocks}}
                              {{#if @first}}
                              <tr>
                                <td>NA</td>
                                <td class="itemcode">{{../material_nr}}</td>
                                <td>On stock</td>
                                <td>{{stock}}</td>
                                <td>
                                  <input type="hidden" class="del_date" name="del_date" value="{{del_date}}" /><input type="hidden" class="del_decodate" name="del_decodate" value="{{del_decodate}}" />
                                  <input type="number" min="0" class="qtyinput itemqty_{{../material_nr}}" data-itemc="{{../material_nr}}"  style="width:75px;" autofocus></td>
                                </tr>
                                {{else}}
                                <tr>
                                  <td></td>
                                  <td class="itemcode"></td>
                                  <td>{{avail_date}}</td>
                                  <td>{{stock}}</td>
                                  <td>
                                    <input type="hidden" class="del_date" name="del_date" value="{{del_date}}" /><input type="hidden" class="del_decodate" name="del_decodate" value="{{del_decodate}}" />
                                    <input type="number" min="0" class="qtyinput itemqty_{{../material_nr}}" data-itemc="{{../material_nr}}" style="width:75px;"></td>
                                  </tr>
                                  {{/if}}
                                  {{/each}}
                                  {{#if prices}}
                                  <tr>
                                    <td colspan="5">
                                      <table class="table" style="width:100%;background:beige;margin-top:15px;">
                                        <tbody>
                                          <tr>
                                            {{#each prices}}
                                            <td>{{column_quantity}}+</td>
                                            {{/each}}
                                          </tr>
                                          <tr>
                                            {{#each prices}}
                                            <td>{{price}}</td>
                                            {{/each}}
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                  {{/if}}
                                  {{/each}}
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </script>
                      <div class="text-right">
                        <hr style="margin-top:5px;margin-bottom:5px;">
                        <button type="button" id="qtyinputNext" class="btn btn-primary" onclick="f_getOrderSimulation()">Next</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title"><a class="btn-block" href="#decoOptions-wrapper" data-toggle="collapse"> Decoration Methods/Position </a>
                    </h4>
                  </div>
                  <div id="decoOptions-wrapper" class="collapse">
                    <div class="panel-body bg-alice">
                      <div>
                        <input type="hidden" id="requestParamBlank" value="">
                        <script id="decoOptions-template" type="text/x-handlebars-template">
                          <div  style="max-height:450px;overflow-y:auto;border:2px solid lightblue;">
                            {{#each deco_info}}
                            <div id="{{decorid}}_" class="dvdecoOption" data-itemc="{{itemc}}" data-configid="{{configuration_id}}">
                              <input type="hidden" class="decoInfoJson" id="decoinfo_{{decorid}}" value="{{tostring this}}">
                              <div>
                                {{#if Areabased}}
                                <select class="select area-select">
                                  <option> Select Area </option>
                                  {{else}}
                                  <select class="select color-select">
                                    <option>Select # of colors</option>
                                    {{/if}}
                                    {{#each decoprices.0.price_val}}
                                    <option value="{{Value}}">{{Value}} - EUR {{Price}}</option>
                                    {{/each}}
                                  </select>
                                  <button class="crossBtn unselectBtn"></button>
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div style="/*width:60%;float:left;*/">
                                      <p><b>Method : "{{Method}}"</b></p>
                                      <p>Position : "{{Position}}" </p>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div style="/*width:40%;float:left;*/">
                                      <p>Length: &#x2195; "{{Max_length}}"</p>
                                      <p>Width : &#x2194; "{{Max_width}}"</p>
                                      <p>Colors:"{{Max_colors}}"</p>
                                      <p>Diameter:"{{Diameter}}"</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              {{/each}}
                            </div>
                            <div>
                              <hr style="margin-top:5px;margin-bottom:5px;">
                              <label class="text-warning"><input type="checkbox" id="issureship" value="1DSH">Sureship Order </label>
                              <div class="text-right">
                                <button type="button" id="selectDeco" class="btn btn-primary" onclick="f_selectDeco()">Next</button>
                              </div>
                            </div>
                          </script>
                          <div id="decoOptions-content">
                            <!-- Decoration positions blocks comes here -->
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h4 class="panel-title"><a class="btn-block" href="#logoUpload-wrapper" data-toggle="collapse"> Decoration Options & Upload logo </a>
                      </h4>
                    </div>
                    <div id="logoUpload-wrapper" class="collapse">
                      <div class="panel-body bg-alice">
                        <div class="dvLogoSection">
                          <script id="logoUpload-template" type="text/x-handlebars-template">
                            <div  style="max-height:600px;overflow-y:auto;border:2px solid lightblue;">
                              {{#each deconlogo}}
                              <div class="dvDeconLogo" data-itemc="{{itemc}}" data-configid="{{configuration_id}}" data-sku="{{image_sku}}">
                                <div class="dvDecoOptions" style="padding:5px;margin:0 0 5px 0;">
                                  <input type="hidden" id="decoOptionsObj_{{configuration_id}}" class="decoOptionsObj_{{itemc}}" value="">
                                  <div style="float:left;width:55%;">
                                    <span><b>Description: {{description}}</b></span><br>
                                    <span><b>Method: {{method}}</b></span><br>
                                    <label>Colors: <input id="colors_{{configuration_id}}" type="number" min="1" max="{{colors}}" value="{{colors}}" ></label><br>
                                    <label>Length: <input id="length_{{configuration_id}}" type="number" min="0" max="{{length}}" value="{{length}}"></label>
                                    <label>Width:  <input id="width_{{configuration_id}}" type="number" min="0" max="{{width}}" value="{{width}}"></label><br>
                                    <label>Product proof: <input id="pproof_{{configuration_id}}" type="checkbox" ></label>


                                  </div>
                                  <div style="padding:5px 5px 0 5px;">
                                    <textarea id="decoInstruction_{{configuration_id}}" class="deco-instruction decoinstr_{{itemc}}" rows="2" title="Decoration Instructions" placeholder="Decoration Instructions" style="width:40%;"></textarea>
                                    <textarea id="pms_{{configuration_id}}" class="pms-indication pms_{{itemc}}" placeholder="PMS Color Indication" title="PMS Color Indication" rows="2" style="width:40%;"></textarea>
                                  </div>
                                </div><hr>
                                <div class="dvLogoUpload" data-sku="{{image_sku}}" data-itemc="{{itemc}}" data-configid="{{configuration_id}}" style="min-height:100px;">
                                  <input type="hidden" id="artInfoObj_{{configuration_id}}" class="artInfoObj_{{itemc}}" value="" >
                                  <label><b>Upload logo [{{image_sku}}]</b></label><br>
                                  <!--<input type="file" class="logoToUpload" style="margin:5px 0 5px 0;" onchange="f_uploadLogo(this)"><br>-->
                                  <button name="Upload logo" id="show-designer-button" class="btn btn-info" onclick="myLogoTool.showEditor('{{image_sku}}','{{imprintids}}');" >Upload logo </button>
                                  <input type="hidden" id="designid_{{image_sku}}" value="" />
                                  <input type="hidden" id="origurl_{{image_sku}}" value="" />
                                  <img class="origImage img-thumbnail hidden" id="origImage_{{image_sku}}" alt="Original Art" onclick="f_showLogo('{{image_sku}}')" style="height:150px;width:150px;">
                                  <img class="layoutImage img-thumbnail hidden" id="layoutImage_{{image_sku}}" alt="Layout Image" onclick="f_showLayout('{{image_sku}}')" style="height:150px;width:150px;">
                                </div>
                              </div>
                              {{/each}}
                            </div>
                            <div class="text-right">
                              <hr style="margin-top:5px;margin-bottom:5px;">
                              <button type="button" id="btnConfirmLogo" class="btn btn-primary" onclick="f_confirmLogo()">Confirm Logo</button>
                              <button type="button" id="confirmDeco" class="btn btn-primary" onclick="f_confirmDeco()">Save</button>
                            </div>
                          </script>
                          <div class="accordion-content">
                            <div id="dvlogoUpload-content">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-primary <?php if(empty($_POST["addons"])) echo 'hidden'; ?>">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a href="#addonsinfo" data-toggle="collapse" class="btn-block">
                          Addons/ Extra Items</a>
                        </h4>
                      </div>
                      <div id="addonsinfo" class="collapse">
                        <div class="panel-body bg-alice">
                          <div class="">
                            <input type="hidden" id="addonsjson" value='<?php if(isset($_POST["addons"])){ echo $_POST["addons"];} ?>' >
                            <input type="hidden" id="orderSimulationReqJson" value="">
                            <div id="addons-content" class="">
                              <!-- addons info -->
                            </div>
                            <!-- addons template -->
                            <script id="addons-template" type="text/x-handlebars-template">
                              {{#each products}}
                              <div class="row">
                                {{#each addons}}
                                <div class="col-sm-6">
                                  <div class="dvAddonsOption">
                                    <button class="crossBtn unselectBtn"></button>
                                    <div class="table-responsive">
                                      <table class="table">
                                        <tbody>
                                          <tr>
                                            <th>Item</th>
                                            <td class="addonitem">{{addon_item}}</td>
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
    <div class="col-sm-6">
      <div class="alert alert-info alert-dismissable hidden" id="dvorderResponseMsg">
        <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
        <span class="message">order request will be processed.</span>
      </div>
      <div class="text-right">
        <button type="button" id="btn-setOrder" class="btn btn-success hidden" data-toggle="modal" data-target="#setOrderModal" style="margin:7px;">Confirm Order </button><br>
      </div>
      <div id="setOrderModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="text-primary">Order Reference</h4>
            </div>
            <div class="modal-body">
              <input type="text" id="setOrderRef" data-entertrigger="#setOrderOk" class="form-control" placeholder="Enter Order Reference" autofocus>
            </div>
            <div class="modal-footer">
              <button type="button" id="setOrderOk" class="btn btn-success" onclick="f_setOrder()" data-dismiss="modal">OK</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div id="dvordsimulation">
        <!--order simulation tables, context: response.get_order_simulation_rsp.order_simulation_rsp[0] -->
        <script id="ordersimulation-template" type="text/x-handlebars-template">
          <table class="itemtbl table">
            <thead class="bg-slategray">
              <tr>
                <th>Item</th>
                <th>Delivery date</th>
                <th>In stock</th>
                <th>Quantity</th>
                <th>Unit price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              {{#each Products}}
              <tr class="itemtblrow">
                <td class="item col-xs-2" id="item_{{material_nr}}">{{material_nr}}</td>
                <td class="col-xs-2">{{delivery_date}}</td>
                <td class="col-xs-2">{{instock}}</td>
                <td class="col-xs-2" id="qty_{{material_nr}}">{{qty}}</td>
                <td class="col-xs-2" id="price_{{material_nr}}">{{unitprice}}</td>
                <td class="col-xs-2">{{price}} {{../currency}}</td>
              </tr>
              {{/each}}
            </tbody>
          </table>
          {{#if Products.[0].Addons}}
          <table class="table table-condensed">
            <thead class="text-warning">
              <tr>
                <th colspan="6">ADD ON ITEMS</th>
              </tr>
            </thead>
            <tbody>
              {{#each Products}}
              {{#each Addons}}
              <tr class="itemtblrow">
                <td class="item col-xs-2" id="item_{{material_nr}}">{{material_nr}}</td>
                <td class="col-xs-2">{{delivery_date}}</td>
                <td class="col-xs-2">{{instock}}</td>
                <td class="col-xs-2" id="qty_{{material_nr}}">{{qty}}</td>
                <td class="col-xs-2" id="price_{{material_nr}}">{{unitprice}}</td>
                <td class="col-xs-2">{{price}} {{../../currency}}</td>
              </tr>
              {{/each}}
              {{/each}}
            </tbody>
          </table>
          {{/if}}
          {{#if Products.[0].Decorations}}
          <table class="table decoPriceOverviewtbl">
            <thead class="text-warning">
              <tr>
                <th colspan="6">DECORATION</th>
              </tr>
            </thead>
            <tbody>
              {{#each Products}}
              {{#each Decorations}}
              <tr>
                <td colspan="6" style="font-weight:bold;text-align:center;background:lightgray;">
                  <span>{{method}} {{length}}*{{width}} {{colors}}Nr.of colors [{{../material_nr}}]</span>
                  <input type="hidden" id="deco_{{configuration_id}}" class="decoration simulated" data-configid="{{configuration_id}}" value="{{operate this 'methodobj'}}">
                </td>
              </tr>
              {{#each Decolines}}
              <tr>
                <td colspan="3" class="col-xs-6">{{material_desc}}</td>
                <td class="col-xs-2">{{qty}}</td>
                <td class="col-xs-2">{{math price "/" qty}}</td>
                <td class="col-xs-2">{{price}} {{../../../currency}}</td>
              </tr>
              {{/each}}
              {{/each}}
              {{/each}}
            </tbody>
          </table>
          {{/if}}
          <table class="priceoverviewtbl table">
            <tbody>
              <tr>
                <td colspan="5" class="col-xs-10">Price per item(rounded)</td>
                <td class="col-xs-2">{{operate this "unitpricesub"}} {{currency}}</td>
              </tr>
              {{#if Surcharge}}
              {{#each Surcharge}}
              <tr>
                <td colspan="5" class="col-xs-10">{{costcode}}</td>
                <td class="col-xs-2">{{price}} {{../currency}}</td>
              </tr>
              {{/each}}
              {{/if}}
              <tr class="font-bold">
                <td colspan="4" class="col-xs-8">TOTAL</td>
                <td class="col-xs-2">{{operate this "unitpricetotal"}}</td>
                <td class="col-xs-2">{{grandtotal}} {{currency}}</td>
              </tr>
            </tbody>
          </table>
        </script>
        <div id="ordersimulation-content">
        </div>
      </div>
      <!-- DELIVERY ADDRESS section -->
      <div id="deliveryadd-wrapper" class="well-sm hidden" style="border:1px solid gray;margin-bottom:3px;">
        <div class="">
          <p class="lead text-primary">DELIVERY ADDRESS</p>
          <div class="row padding-xs">
            <label class="col-md-3" for="searchtxt"> Search Address: </label>
            <div class="col-md-8 col-lg-6">
              <input type="text" id="searchtxt" class="input-sm" />
              <button type="button" class="btn btn-info btn-sm" onclick="f_deliveryAddress()"> Search</button>
            </div>
          </div>
          <div class="row padding-xs">
            <label class=" col-md-3" for="delivery_address">Select Address:&nbsp;&nbsp;</label>
            <div class="col-md-8">
              <select id="delivery_address" onchange="f_addComboValueChange()" class="input-sm maxwidth100" >
              </select>
            </div>
          </div>
          <div class="row padding-xs">
            <div class="col-md-8 col-md-offset-3">
              <textarea rows="4" cols="40" class="addresstext maxwidth100" style="min-width:60%;background:#eee;" readonly></textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- DELIVERY ADDRESS section end -->
    </div>
  </div>
</div>
<script src="https://logo.pfconcept.com/js/dist/plugin.logotool.js" id="pf-widget-embedder"></script>
<script >
var myLogoTool = new LogoTool({
  clientId: '52fb33b0-149f-438a-bd91-4688c86afe07' /*,
  onSave: function(err,data){
  if(err){
  alert("The logo could not be saved");
}
else{
var design_id = data.design_id;
var imprint_id = data.imprint_id;
var design = data.design;
var logo = data.logos[0].png;
console.log(design_id + imprint_id + design );
$("#designid_" + imprint_id).val(design_id);
$("#layoutImage_" + imprint_id).attr({"src": design,"height":"150px","width":"150px"}).show();
$("#origImage_" + imprint_id).attr({"src": logo,"height":"150px","width":"150px"}).show();
}
},
onClose:function()	{

}*/
}).init();


myLogoTool.on("save", function(data,err){
  console.log("data:\n",data);
  if(err){
    alert("The logo could not be saved");
  }
  else{
    for(var i=0;i<data.designs.length;i++)
    {
      var design_id = data.designs[i].design_id;
      var imprint_id = data.designs[i].imprint_id;
      var design = data.designs[i].design;
      var logo = data.designs[i].logos[0].png;
      var origlogo =  data.designs[i].logos[0].original;
      console.log(design_id + imprint_id + design );
      $("#designid_" + imprint_id).val(design_id);
      $("#origurl_" + imprint_id).val(origlogo);
      $("#layoutImage_" + imprint_id).attr("src",design).removeClass("hidden");
      $("#origImage_" + imprint_id).attr("src",logo).removeClass("hidden");

    }
  }
  f_confirmLogo(); //save orig/layout art info in array (will be used on setorder)
});

myLogoTool.on("close", function(err,data){
  console.log("designer modal closed");
});

function f_showLogo(imprintid){

  var designid = $('#designid_' + imprintid).val();

  myLogoTool.getDesign(designid,'logo', function(err,url){
    var redirectWindow = window.open(url, '_blank');
    redirectWindow.location;

  });
}

function f_showLayout(imprintid){
  var designid = $('#designid_' + imprintid).val();
  myLogoTool.getDesign(designid,'design',function(err,url){
    var redirectWindow = window.open(url, '_blank');
    redirectWindow.location;


  });

}

</script>
</body>
</html>
