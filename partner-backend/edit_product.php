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

if($_GET['ID']!=""){
  $prID=dowith_sql($_GET['ID']);
  $prID=filter_var($prID);
}else{
  $prID="";
}

$strPType="SELECT ID, Type, ProductTypeID FROM partner_products_type WHERE ProductTypeID<>'1' AND ProductTypeID<>'2'";
$cmdPType=mysqli_query($link_db,$strPType);
while ($PType=mysqli_fetch_row($cmdPType)) {
  $Type[$PType[2]]=$PType[1];
}

$strMyPR="SELECT ID, CompanyID, ModelID FROM partner_myproducts WHERE ID='".$prID."'";
$cmdMyPR=mysqli_query($link_db,$strMyPR);
$MyPR=mysqli_fetch_row($cmdMyPR);
$ModelID=$MyPR[2];
$uID=$_SESSION['ID'];
$Role=$_SESSION['role'];
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>BACKEND - Edit Product - My Products Management - MiTAC Partner Zone</title>


<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
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
            <li class="breadcrumb-item">Products Management
            </li>
            <li class="breadcrumb-item"><a href="BEmyproducts">My Products Management</a>
            </li>
            <li class="breadcrumb-item active">Edit Product(s)
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

             <h1>Edit Product(s)</h1>
             <input id="eID" type="hidden" value="<?=$prID?>">
             <br />
             <table class="table">
              <tr>
                <td>
                  <label>
                    <strong>Company:</strong>
                  </label>
                  <select id="sel_company" class="select2 form-control" style="width:50%">
                    <?php
                    $strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1";
                    $cdmCName=mysqli_query($link_db,$strCName);
                    while ($CName=mysqli_fetch_row($cdmCName)) {
                      if($CName[0]==$MyPR[1]){
                        $status="selected";
                      }else{
                        $status="";
                      }
                      echo "<option  value='".$CName[0]."' ".$status.">".$CName[1]."</option>";
                    }
                    ?>
                  </select>
                <td>
              </tr>
              <tr>
                <td>
                  <label>
                    <strong>Product:</strong>
                  </label>

                  <select id="sel_product" class="select2 form-control" style="width:50%" >
                    <option>Select:</option>
                    <?php
                    foreach ($Type as $key => $value) {
                      echo "<optgroup label='".$value."'>";
                      if($key=="1" || $key=="2"){
                        $strModel="SELECT ID, MiTAC_PN, CATEGORY_NAME, ProductType FROM partner_model WHERE ProductType='".$key."'";
                      }else{
                        $strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType='".$key."'";
                      }
                      //$strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType=".$key;
                      $cmdModel=mysqli_query($link_db,$strModel);
                      while ($Model=mysqli_fetch_row($cmdModel)) {
                        if($Model[0]==$ModelID){
                          $status="selected";
                        }else{
                          $status="";
                        }
                        echo "<option value='".$Model[0]."' ".$status.">".$Model[2]." (".$Model[1].")</option>";
                      }
                      echo "</optgroup>";
                    }
                    ?>
                  </select>

                <td>
            </tr>
          </table>
          <br />

          <div class="alert alert-warning" role="alert">
            If you can't find the products you can select. Please <a href="BEproducts" />go here to add them first</a>!
          </div>

          <br />
          <div class="text-left">
            <button id="EditOK" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> Save</button>
            <a href="BEmyproducts"  /><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> BACK </button></a>
          </div>
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
<!-- END PAGE LEVEL JS-->

<script>
$("#EditOK").click(function(){
  var ID = document.getElementById("eID").value;
  var company = document.getElementById("sel_company").value;
  var product = document.getElementById("sel_product").value;
  var kind = "EditPR";
  var url = "MyProductProcess";

  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      ID : ID,
      company : company,
      product : product,
      kind : kind
    },
    success: function(message){
      if(message == "success"){
        alert("Edit MyProduct Done.");
        document.location.href="BEmyproducts";
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