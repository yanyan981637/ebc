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

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>BACKEND - Add a Email Notification Mapping - MiTAC Partner Zone</title>


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
              <li class="breadcrumb-item active">Add an Email Mapping
              </li>
            </ol>
          </div>
        </div>
      </div>

    </div>
    <div class="content-body">

      <h1>Add an Email Notification Mapping:</h1>

      <hr>

      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="card no-border box-shadow-1">
            <div class="card-content">
              <div class="card-body">

                <div class="form-group">
                  <p><strong>Notification Received Email Accounts:</strong> </p>

                  <select id="a_m_sales" class="select2 form-control" multiple="multiple"  style="width: 100%">
                    <?php
                    $str="SELECT EMAIL FROM partner_sales WHERE 1";
                    $cmd=mysqli_query($link_db,$str);
                    while ($result=mysqli_fetch_row($cmd)) {
                      echo "<option value='".$result[0]."'>".$result[0]."</option>";
                    }
                    ?>
                  </select>

                </div>
                <p><strong>Select the countries:</strong></p>
                <div class="form-group">
                  <select id="a_m_country" multiple="multiple" size="20"  class="duallistbox-multi-selection" >
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
                <button id="addMpaaing" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> SAVE </button>
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
$("#addMpaaing").click(function(){
  var sales="";
  var a_m_sales = document.getElementById("a_m_sales");
  for(var i=0;i<a_m_sales.options.length;i++){
    if (a_m_sales.options[i].selected) {
      sales += a_m_sales.options[i].value;
    }
  } 
  //var country=$("#a_m_country :selected").attr("data-countryCode");
  var country=$("#a_m_country").val();
  var kind = "AddMapping";
  var url = "mapping_process.html";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      country : country, 
      sales : sales, 
      kind : kind
    },
    success: function(message){
      if(message == "success"){
        alert("Add Done.");
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