<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}
error_reporting(0);

session_start();
if($_SESSION['user']=="" || $_SESSION['ID']==""){
  echo "<script language='javascript'>self.location='login'</script>";
  exit;
}

require "../config.php";


$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  /*$str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);*/
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
  $str = str_replace("'","&#39;",$str);
  $str = str_replace('"',"&quot;",$str);
  //$str = str_replace(".","",$str);
  //$str = str_replace("or","",$str);
  $str = str_replace("=","",$str);
  $str = str_replace("?","",$str);
  $str = str_replace("%","",$str);
  $str = str_replace("0x02BC","",$str);
  //$str = str_replace("%20","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  $str = str_replace("<style>","",$str);
  $str = str_replace("</style>","",$str);
  $str = str_replace("<img>","",$str);
  $str = str_replace("</img>","",$str);
  $str = str_replace("<a>","",$str);
  $str = str_replace("</a>","",$str);
  return $str;
}

if($_GET['QTID']!=""){
  $QTID=dowith_sql($_GET['QTID']);
  $QTID=filter_var($QTID);
}

$strType="SELECT ID, Type, ProductTypeID FROM partner_products_type WHERE 1";
$cmdType=mysqli_query($link_db,$strType);
while ($Type=mysqli_fetch_row($cmdType)) {
  $type[$Type[2]]=$Type[1];
  //$typeName[$j]=$data_team[1];
  $j++;
}

$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS FROM partner_projects WHERE QT_ID='".$QTID."'";
$cmd=mysqli_query($link_db,$str);
$data=mysqli_fetch_row($cmd);
$editID=$data[0];
$Company=$data[2];
$ToUser=$data[2];
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>BACKEND - Edit Quotation - MiTAC Partner Zone</title>


<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/plugins/ui/jqueryui.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!-- END Custom CSS-->
</head>
<body  class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
<!-- fixed-top-->
<?php
include("top.php");
?>
<!-- fixed-top end-->

<!--left menu-->
<?php
include("left_menu.php");
?>
<!--end left menu-->

<div class="app-content content">
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
      <h3 class="content-header-title mb-0 d-inline-block">MiTAC Partner Zone</h3>
      <div class="row breadcrumbs-top d-inline-block">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="BEdashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="BEprojects">Projects Management</a>
            </li>
            <li class="breadcrumb-item active">Edit Quotation
            </li>
          </ol>
        </div>
      </div>
    </div>

  </div>

  <div class="content-body">
    <div class="row ">
      <div class="col-xl-12 col-lg-12">
        <div class="card no-border box-shadow-1">
          <div class="card-content">
            <div class="card-body">

             <h1>Edit a Quotation</h1>
             <br />
             <table class="table ">


              <tr>
                <td>
                  <label>
                    <strong>Company:</strong>
                  </label>
                  <select id="company"  class="select2 form-control" style="width:60%" onchange="sel_member()" disabled="disabled">
                    <option value="" selected>Select a company</option>
                    <?php
                    $strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1";
                    $cdmCName=mysqli_query($link_db,$strCName);
                    while ($CName=mysqli_fetch_row($cdmCName)) {
                      if($Company==$CName[0]){
                        $selected="selected";
                        $CompanyID=$CName[0];
                      }else{
                        $selected="";
                      }
                      echo "<option  value='".$CName[0]."' ".$selected.">".$CName[1]."</option>";
                    }
                    ?>
                  </select>
                <td>
              </tr>
              <tr>
                <td><strong>To:</strong>
                  <select id="member" class="form-control">
                    <option >Select a member of this company </option>
                    <?php
                    $strName="SELECT ID, Name, Email FROM partner_user WHERE CompanyID='".$CompanyID."'";
                    $cdmName=mysqli_query($link_db,$strName);
                    while ($Name=mysqli_fetch_row($cdmName)) {
                      if($data[3]==$Name[0]){
                        $selected="selected";
                        $a=$Name[0];
                      }else{
                        $selected="";
                      }
                      echo "<option value='".$Name[0]."' ".$selected.">".$Name[1]." (".$Name[2].")</option>";
                    }
                    ?>
                  </select>
                <td>
              </tr>
              <tr>
                <td><strong>ID:</strong> <?=$QTID?><td>

                </tr>
                <tr>
                  <td><strong>Quotation Date:</strong>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ft-calendar"></i></span>
                      </div>
                      <input id="QT_Date"  type="text" class="form-control datepicker-default" value="<?=$data[4]?>" />
                    </div><td>
                  </tr>
                  <tr>
                    <td><strong>Due Date:</strong>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ft-calendar"></i></span>
                        </div>
                        <input id="Due_Date" type="text" class="form-control datepicker-default" value="<?=$data[5]?>" />
                      </div>
                      <td>
                      </tr>
                      <tr>
                        <td><strong>Terms & Conditions:</strong> <div class="form-group">
                         <input id="Terms" type="text" class="form-control" placeholder="" value="<?=$data[6]?>">
                       </div>
                       <td>
                       </tr>
                       <tr>
                        <td><strong>Remarks:</strong>
                          <textarea id="Remarks" class="form-control" rows="2"><?=$data[7]?></textarea>
                          <td>
                          </tr>
                        </table>

                        <h2>Items:</h2>
                        <div class="alert alert-warning" role="alert">
                          If you can't find the products you can select. Please <a href="BEproducts" />go here to add them first</a>!
                        </div>
                        <!--add one product-->
                        <div class="repeater-default bg-grey bg-lighten-4 p-15">
                          <div data-repeater-list="">
                            <?php
                            $strItems="SELECT ID, QT_ID, Products, Qty, UnitPrice, Description, Sort, ModelID FROM partner_projects_items WHERE QT_ID='".$QTID."' ORDER BY Sort ASC";
                            $cmd=mysqli_query($link_db,$strItems);
                            $num=mysqli_num_rows($cmd);
                            if($num!=0){
                              while($Items=mysqli_fetch_row($cmd)) {
                              ?>
                              <div id="d_Items" data-repeater-item>
                                <form class="form row">
                                  <div class="form-group mb-1 col-sm-12 col-md-1">
                                    <label for="order" class="cursor-pointer">#</label>
                                    <br>
                                    <input id="Order" name="Order" class="form-control" type="" value="<?=$Items[6]?>" >
                                  </div>
                                  <div class="form-group mb-1 col-sm-12 col-md-3">
                                    <label for="email-addr">Products</label>
                                    <br>
                                    <!-- <select id="pr" name="pr" class="select2 form-control" > -->
                                    <select id="pr" name="pr" class="select1 form-control" >
                                      <option value="">Please select:</option>
                                      <?php
                                      foreach ($type as $key => $value){
                                        echo "<optgroup label='".$value."'>";
                                        if($key=="1" || $key=="2"){
                                          $strModel="SELECT ID, MiTAC_PN, CATEGORY_NAME, ProductType FROM partner_model WHERE ProductType=".$key." ORDER BY CATEGORY_NAME ASC";
                                        }else{
                                          $strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType=".$key;
                                        }
                                        $cmdModel=mysqli_query($link_db,$strModel);
                                        while ($Model=mysqli_fetch_row($cmdModel)) {
                                          if($key=="1" || $key=="2"){
                                            if($Items[7]==$Model[0]){
                                              $selected="selected";
                                            }else{
                                              $selected="";
                                            }
                                          }else{
                                            if($Items[2]==$Model[2]){
                                              $selected="selected";
                                            }else{
                                              $selected="";
                                            }
                                          }

                                          echo "<option value='".$Model[0]."' ".$selected.">".$Model[2]." (".$Model[1].")</option>";
                                        }
                                        echo "</optgroup>";
                                      }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label for="Qty" class="cursor-pointer">Qty</label>
                                    <br>
                                    <input id="Qty" name="Qty" class="form-control" type="" value="<?=$Items[3]?>">
                                  </div>
                                  <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                    <label for="tel-input">Unit Price (USD$)</label>
                                    <br>
                                    <input id="UnitPrice" name="UnitPrice" class="form-control" type="" value="<?=$Items[4]?>">
                                  </div>
                                  <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label for="Desp" class="cursor-pointer">Description</label>
                                    <br>
                                    <input id="des" name="des"  class="form-control" type="" value="<?=$Items[5]?>">
                                  </div>
                                  <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                    <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Delete</button>
                                  </div>
                                </form>
                                <hr>
                              </div>
                              <?php
                              }
                            }else{
                            ?>
                            <div data-repeater-list="">
                                  <div id="d_Items" data-repeater-item>
                                    <form class="form row">
                                      <div class="form-group mb-1 col-sm-12 col-md-1">
                                        <label for="order" class="cursor-pointer">#</label>
                                        <br>
                                        <input id="Order" name="Order" class="form-control" type="" value="" >
                                      </div>
                                      <div class="form-group mb-1 col-sm-12 col-md-3">
                                        <label for="email-addr">Products</label>
                                        <br>
                                        <!-- <select id="pr" name="pr" class="select2 form-control" > -->
                                        <select id="pr" name="pr" class="select1 form-control" >
                                          <option>Please select:</option>
                                          <?php
                                          foreach ($type as $key => $value) {
                                            echo "<optgroup label='".$value."'>";
                                            if($key=="1" || $key=="2"){
                                              $strModel="SELECT ID, MiTAC_PN, CATEGORY_NAME, ProductType FROM partner_model WHERE ProductType=".$key." ORDER BY CATEGORY_NAME ASC";
                                            }else{
                                              $strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType=".$key;
                                            }
                                            $cmdModel=mysqli_query($link_db,$strModel);
                                            while ($Model=mysqli_fetch_row($cmdModel)) {
                                              echo "<option value='".$Model[0]."'>".$Model[2]." (".$Model[1].")</option>";
                                            }
                                            echo "</optgroup>";
                                           }
                                           ?>
                                         </select>
                                       </div>
                                       <div class="form-group mb-1 col-sm-12 col-md-2">
                                        <label for="Qty" class="cursor-pointer">Qty</label>
                                        <br>
                                        <input id="Qty" name="Qty" class="form-control" type="" value="" >
                                      </div>
                                      <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                        <label for="tel-input">Unit Price (USD$)</label>
                                        <br>
                                        <input id="UnitPrice" name="UnitPrice" class="form-control" type="" value="" >
                                      </div>
                                      <div class="form-group mb-1 col-sm-12 col-md-2">
                                        <label for="Desp" class="cursor-pointer">Description</label>
                                        <br>
                                        <input id="des" name="des" class="form-control" type="" value="" >
                                      </div>
                                      <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                        <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Delete</button>
                                      </div>
                                    </form>
                                    <hr>
                                  </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-group overflow-hidden">
                          <div class="col-12">
                            <button data-repeater-create class="btn btn-outline-secondary">
                              <i class="ft-plus"></i> Add
                            </button>
                          </div>
                        </div>
                      </div>
                      <!--end add one product-->
                      <br />
                      <h2>Extra Costs:</h2>
                      <!--add one extra cost-->
                      <div class="repeater-default bg-grey bg-lighten-4 p-15">
                        <div data-repeater-list="">
                          <?php
                          $strExtra="SELECT ID, QT_ID, Item, Price, Sort FROM partner_projects_extra WHERE QT_ID='".$QTID."' ORDER BY Sort ASC";
                          $cmd=mysqli_query($link_db,$strExtra);
                          $num=mysqli_num_rows($cmd);
                          if($num!=0){
                            while($Extra=mysqli_fetch_row($cmd)) {
                            ?>
                            <div id="d_Extra" data-repeater-item>
                              <form class="form row">
                                <div class="form-group mb-1 col-sm-12 col-md-1">
                                  <label for="order" class="cursor-pointer">#</label>
                                  <br>
                                  <input id="ex_Order" name="ex_Order" class="form-control" type="" value="<?=$Extra[4]?>">
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-7">
                                  <label for="Item" class="cursor-pointer">Item</label>
                                  <br>
                                  <input id="Item" name="Item" class="form-control" type="" value="<?=$Extra[2]?>">
                                </div>
                                <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                  <label for="tel-input">Price (USD$)</label>
                                  <br>
                                  <input id="Price" name="Price" class="form-control" type="" value="<?=$Extra[3]?>">
                                </div>
                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                  <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Delete</button>
                                </div>
                              </form>
                              <hr>
                            </div>
                            <?php
                            }
                          }else{
                            ?>
                            <div id="d_Extra" data-repeater-item>
                              <form class="form row">
                                <div class="form-group mb-1 col-sm-12 col-md-1">
                                  <label for="order" class="cursor-pointer">#</label>
                                  <br>
                                  <input id="ex_Order" name="ex_Order" class="form-control" type="" value="<?=$Extra[4]?>">
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-7">
                                  <label for="Item" class="cursor-pointer">Item</label>
                                  <br>
                                  <input id="Item" name="Item" class="form-control" type="" value="<?=$Extra[2]?>">
                                </div>
                                <div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">
                                  <label for="tel-input">Price (USD$)</label>
                                  <br>
                                  <input id="Price" name="Price" class="form-control" type="" value="<?=$Extra[3]?>">
                                </div>
                                <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                  <button type="button" class="btn btn-danger" data-repeater-delete> <i class="ft-x"></i> Delete</button>
                                </div>
                              </form>
                              <hr>
                            </div>
                            <?php
                          }
                          ?>
                        </div>
                        <div class="form-group overflow-hidden">
                          <div class="col-12">
                            <button data-repeater-create class="btn btn-outline-secondary">
                              <i class="ft-plus"></i> Add
                            </button>
                          </div>
                        </div>
                      </div>
                      <!--end add one extra cost-->
                      <br />
                      <div class="text-left">
                        <button id="EditOK" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> Save</button>
                        <!-- <a href=""  /><button type="button" class="btn btn-outline-info mr-1 mb-1">Clear All</button></a> -->
                        <input id="editID" type="hidden" value="<?=$editID?>">
                        <input id="QT_ID" type="hidden" value="<?=$QTID?>">
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
          </div>
       </div>
     </div>
      <!-- ////////////////////////////////////////////////////////////////////////////-->

<!--footer-->
<?php
include("footer.php");
?>
<!--end footer-->

<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>
<script src="app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/form-repeater.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="app-assets/js/scripts/ui/jquery-ui/date-pickers.js"></script>
<!-- END PAGE LEVEL JS-->
<script>
Date.prototype.format = function(fmt) {
var o = {
  "M+" : this.getMonth()+1,                 //月份
  "d+" : this.getDate(),                    //日
  "h+" : this.getHours(),                   //小時
  "m+" : this.getMinutes(),                 //分
  "s+" : this.getSeconds(),                 //秒
  "q+" : Math.floor((this.getMonth()+3)/3), //季
  "S"  : this.getMilliseconds()             //毫秒
};
  if(/(y+)/.test(fmt)) {
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
  }
  for(var k in o) {
    if(new RegExp("("+ k +")").test(fmt)){
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
    }
  }
  return fmt;
}

function sel_member(i){
  var ID=document.getElementById("company").value;
  var kind="selMember";
  var url = "QuotationProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    ID : ID,
    kind : kind
  },
    success: function(message){
      if(message == "success"){

      }else{
        document.getElementById("member").innerHTML = message;
      }
    }
  });
}

$("#EditOK").click(function(){
  var editID = document.getElementById("editID").value;
  var QT_ID = document.getElementById("QT_ID").value;
  var company = document.getElementById("company").value;
  var member = document.getElementById("member").value;

  var QT_Date = "";
  var date=document.getElementById("QT_Date").value;
  QT_Date = new Date(date).format("yyyy-MM-dd");

  var Due_Date = "";
  var date=document.getElementById("Due_Date").value;
  Due_Date = new Date(date).format("yyyy-MM-dd");

  var Terms = document.getElementById("Terms").value;
  var Remarks = document.getElementById("Remarks").value;
  var Items = $('[id=d_Items]').length;
  var Order="";
  var pr="";
  var Qty="";
  var UnitPrice="";
  var des="";
  for (var i = 0; i < Items; i++) {
    if($("select[name='["+i+"][pr]']").val()==""){
      alert("Products not null");exit;
    }
    Order += $("input[name='["+i+"][Order]']").val();
    Order +="+";
    pr += $("select[name='["+i+"][pr]']").val();
    pr +="+";
    Qty += $("input[name='["+i+"][Qty]']").val();
    Qty +="+";
    UnitPrice += $("input[name='["+i+"][UnitPrice]']").val();
    UnitPrice +="+";
    des += $("input[name='["+i+"][des]']").val();
    des +=",";
  };
  var ex_Order="";
  var Item="";
  var Price="";
  var Extra = $('[id=d_Extra]').length;
  for (var i = 0; i < Extra; i++) {
    ex_Order += $("input[name='["+i+"][ex_Order]']").val();
    ex_Order +="+";
    Item += $("input[name='["+i+"][Item]']").val();
    Item +="+";
    Price += $("input[name='["+i+"][Price]']").val();
    Price +="+";
  };
  //var b =document.getElementsByName('[0][email]')[0].value;
  var kind="editQT";
  var url = "QuotationProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    editID : editID,
    QT_ID : QT_ID,
    company : company,
    member : member,
    QT_Date : QT_Date,
    Due_Date : Due_Date,
    Terms : Terms,
    Remarks : Remarks,
    Order : Order,
    pr : pr,
    Qty : Qty,
    UnitPrice : UnitPrice,
    des : des,
    ex_Order : ex_Order,
    Item : Item,
    Price : Price,
    Items : Items,
    Extra : Extra,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      alert("Edit Quotation Done.");
      document.location.href="BEprojects";
    }else{
      alert(message);
    }
  }
  });
})


</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>