<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
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
$ID=$_SESSION['ID'];
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
<title>BACKEND - Change Password - MiTAC Partner Zone</title>


<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
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
            
            <li class="breadcrumb-item active">Password Change
            </li>
          </ol>
        </div>
      </div>
    </div>
    
  </div>
  <div class="content-body">
    
    
    
    
    <div class="row">
      <div class="col-xl-4 col-lg-6 col-md-12">
        <div class="card no-border box-shadow-1"><div class="card">
          <div class="card-content">
            <div class="card-body">
              <h1 class="card-header ">Change Password</h1>
              <hr>
              
              
              <form class="form-horizontal form-simple" action="#" novalidate>
                <fieldset class="form-group position-relative has-icon-left">
                  <input id="password1" type="password" class="form-control form-control-lg input-lg" placeholder="Enter New Password" required minlength="8">
                  <div class="form-control-position">
                    <i class="fa fa-key"></i>
                  </div>
                  <div id="err_PW1" class="alert alert-danger mb-1" role="alert" style="display:none">
                   The new password must be different from the current password.
                 </div>
               </fieldset>
               <fieldset class="form-group position-relative has-icon-left">
                <input id="password2" type="password" class="form-control form-control-lg input-lg" placeholder="Confirm New Password" required minlength="8">
                <div class="form-control-position">
                  <i class="fa fa-key"></i>
                </div>
                <div id="err_PW2" class="alert alert-danger mb-1" role="alert" style="display:none">
                 Passwords don't match. Please enter your password again to confirm it.
               </div>
             </fieldset>
             
             <button id="changeOK" type="button" class="btn btn-info btn-lg btn-block"><i class="fa fa-floppy-o"></i> Save</button>
             <input id="UID" type="hidden" value="<?=$ID?>">
           </form>
           
         </div>
       </div>
     </div></div>
   </div>
   <div class="col-xl-4 col-lg-6 col-md-12">
     
   </div>
   <div class="col-xl-4 col-lg-12 col-md-12">
     
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
<script src="app-assets/vendors/js/vendors.min.js"></script>

<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
<script>
$("#changeOK").click(function(){
  $("#err_PW1").hide();
  $("#err_PW2").hide();
  var PW1 = document.getElementById("password1").value;
  var PW2 = document.getElementById("password2").value;
  var UID = document.getElementById("UID").value;
  if(PW1!=PW2){
    $("#err_PW2").show();exit;
  }
  var url = "pwProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    PW1 : PW1,
    PW2 : PW2,
    UID : UID
  },
  success: function(message){
    if(message == "success"){
      document.location.href="BEdashboard";
    }else if(message == "N"){
      $("#err_PW1").show();
      exit;
    }else{
      alert(message);
      exit;
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