<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
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
  $ID=dowith_sql($_GET['ID']);
  $ID=filter_var($ID);
}else{
  $ID="";
}

$str="SELECT ID, Sales, CountryCode FROM `partner_mapping` WHERE ID='".$ID."'";
$cmd=mysqli_query($link_db,$str);
$data=mysqli_fetch_row($cmd);
$mappingID=$data[0];
$CountryCode=$data[2];
$Sales=$data[1];
$Sales=explode(",", $Sales);
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>BACKEND - Edit a Email Notification Mapping - MiTAC Partner Zone</title>


  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
  <link rel="shortcut icon" href="/images/ico/favicon.ico">
  <link rel="manifest" href="images/favicon/site.webmanifest">
  <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/listbox/bootstrap-duallistbox.min.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN ROBUST CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >	
  <!-- END ROBUST CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/dual-listbox.css">
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
              <li class="breadcrumb-item">Settings
              </li>
              <li class="breadcrumb-item"><a href="BEemail_mapping">Email Mapping</a>
              </li>
              <li class="breadcrumb-item active">Edit an Email Mapping
              </li>
            </ol>
          </div>
        </div>
      </div>

    </div>
    <div class="content-body">

      <h1>Edit an Email Notification Mapping:</h1>

      <hr>

      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card no-border box-shadow-1">
            <div class="card-content">
              <div class="card-body">

                <div class="form-group">
                  <p><strong>Notification Received Email Accounts:</strong> </p>
                  <select id="e_m_sales" class="select2 form-control" multiple="multiple"  style="width: 100%">
                    <?php
                    $str="SELECT EMAIL FROM partner_sales WHERE 1";
                    $cmd=mysqli_query($link_db,$str);
                    while ($result=mysqli_fetch_row($cmd)) {
                      $status="";
                      foreach ($Sales as $key => $value) {
                        if($result[0]==$value){
                          $status="selected";
                        }
                      }
                      echo "<option value='".$result[0]."' ".$status.">".$result[0]."</option>";
                    }
                    ?>
                  </select> 

                </div>
                <p><strong>Select the countries:</strong></p>
                <input id="db_country" type="hidden" value="<?=$CountryCode;?>">
                <input id="editID" type="hidden" value="<?=$mappingID;?>">
                <div class="form-group">
                  <select id="e_m_country" multiple="multiple" size="20"  class="duallistbox-multi-selection" >
                  <?php
                  //include("countryCode.php");
                  
                  $str1="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE 1";
                  $cmd1=mysqli_query($link_db,$str1);
                  while ($result1=mysqli_fetch_row($cmd1)) {
                    echo "<option value='".$result1[2]."'>".$result1[3]."(+".$result1[4].")</option>";
                  }
                  ?>
                  </select>
                </div>
                <button id="editMpaaing" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> SAVE </button>
                <a href="BEemail_mapping"  /><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> BACK </button></a>		

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

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/listbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/listbox/form-duallistbox.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script>
$(document).ready(function (){
  var x = document.getElementById("e_m_country");
  var country=document.getElementById("db_country").value;
  var selectorx = $('select[id="e_m_country"]').bootstrapDualListbox({});
  var tmp="";
  for (var i = 0; i < x.length; i++) {
    var y=x[i].value;
    if(country.indexOf(y)!= -1){
      tmp=tmp+y;
      selectorx.get(0).options[i].selected = true;
      selectorx.bootstrapDualListbox('refresh');
    }
  }
});


$("#editMpaaing").click(function(){
  var editID = document.getElementById("editID").value;
  var sales="";
  var e_m_sales = document.getElementById("e_m_sales");
  for(var i=0;i<e_m_sales.options.length;i++){
    if (e_m_sales.options[i].selected) {
      sales += e_m_sales.options[i].value;
    }
  }
  var country=$("#e_m_country").val();
  var kind = "EditMapping";
  var url = "mappingProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      editID : editID, 
      country : country, 
      sales : sales, 
      kind : kind
    },
    success: function(message){
      if(message == "success"){
        alert("Edit Done.");
        document.location.href="BEemail_mapping";
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