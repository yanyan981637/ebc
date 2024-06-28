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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d");

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

include("countryCodeReplace.php");
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
$ID=$_SESSION['ID'];
$salesID=$_SESSION['ID'];
$Role=$_SESSION['role'];
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>BACKEND - Add a client - Client Accounts Management - MiTAC Partner Zone</title>


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
              <li class="breadcrumb-item"><a href="BEclient_accounts">Client Accounts Management</a>
              </li>

              <li class="breadcrumb-item active">Add a client account
              </li>
            </ol>
          </div>
        </div>
      </div>

    </div>
    <div class="content-body">



      <div class="row ">
        <div class="col-12">
          <div class="card no-border box-shadow-1">
            <div class="card-content">
              <div class="card-body">
               <h1>Add a Client Account</h1>
               <hr>

               <label>Company Name: </label>
               <div class="form-group">
                 <input id="companyName" type="text" placeholder="" class="form-control">
                 <div id="err_companyName" class="alert alert-danger mb-1" role="alert" style="display:none">
                  Please Enter Company Name.
                 </div>
               </div>
               <label>Company Address: </label>
               <div class="form-group">
                 <textarea id="companyAddress" name="maxlength-textarea" class="form-control textarea-maxlength" placeholder="Enter upto 250 characters.." maxlength="250" rows="3"></textarea>
                 <div id="err_companyAddress" class="alert alert-danger mb-1" role="alert" style="display:none">
                  Please Enter Company Address.
                 </div>
               </div>
               <div class="form-group">
                <label for="username">Member Name:</label>
                <input id="username" type="" class="form-control"  placeholder="" required>
                <div id="err_username" class="alert alert-danger mb-1" role="alert" style="display:none" >
                  Please Enter Member Name.
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email Address:</label>
                <input id="email" type="" class="form-control" placeholder="" required>
                <div id="err_mail" class="alert alert-danger mb-1" role="alert" style="display:none">
                  Please enter a valid email.
                </div>
                <div id="err_mail2" class="alert alert-danger mb-1" role="alert" style="display:none">
                  This email has already been registered.
                </div>
              </div>
              <div class="form-group">
               <label>Title: </label>
               <input id="Title" type="text" placeholder="" class="form-control">
               <!-- <div id="err_Title" class="alert alert-danger mb-1" role="alert" style="display:none">
                  Please Enter Title.
               </div> -->
             </div>
             <div class="form-group">
               <label>Residing Region: </label>
               <select id="Region" name="Region" class="form-control" >
                <option selected value="">Select...</option>
                <option value="NA">North America</option>
                <option value="SA">Central / South America</option>
                <option value="EUR">Europe</option>
                <option value="ME">Middle East / Africa</option>
                <option value="ASIA">Asia</option>
                <option value="Oceania">Oceania</option>
              </select>
               <!-- <div id="err_Title" class="alert alert-danger mb-1" role="alert" style="display:none">
                  Please Enter Title.
               </div> -->
             </div>
             <div class="row">
              <!--<div class="col-md-4">
                  <div class="form-group">
                  <label for="countryCode">Tel:</label>

                 <select id="countryCode" class="select2 form-control">
                    <option value="" selected>Select...</option>
                    <?php
                    //include("countryCode.php");
                    ?>
                  </select>
                  <div id="err_countryCode" class="alert alert-danger mb-1" role="alert" style="display:none">
                    Please Select.
                  </div>
                </div>
              </div>-->
              <div class="col-md-8"><div class="form-group">
                <label for="countryCode">Tel:</label>
                <label for="tel">&nbsp;</label>
                <input id="tel" type="" class="form-control" placeholder="" required>
                <div id="err_tel" class="alert alert-danger mb-1" role="alert" style="display:none">
                  Please Enter tel.
                </div>
              </div>
            </div>
          </div>
          <?php
          if($Role=="SUAD" || $Role=="AD"){
          ?>
          <div class="form-group">
            <label>Responsible Sales: </label>
            <select id="resSales" class="form-control" >
              <option value="" selected>Please select...</option>
              <?php
              $str_teams="SELECT ID, Team FROM partner_teams WHERE 1";
              $cmd_teams=mysqli_query($link_db, $str_teams);
              while ($data_teams=mysqli_fetch_row($cmd_teams)) {
                echo "<optgroup label='".$data_teams[1]."'>";
                $str_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE Team LIKE '%".$data_teams[0]."%'";
                $cmd_sales=mysqli_query($link_db, $str_sales);
                while ($data_sales=mysqli_fetch_row($cmd_sales)) {
                  echo "<option value='".$data_sales[0]."'>".$data_sales[1]." / ".$data_sales[2]."</option>";
                }
              }
              ?>
            </select>
            <div id="err_resSales" class="alert alert-danger mb-1" role="alert" style="display:none">
              Please Select.
            </div>
          </div>
          <?php
          }else{
            echo "<input id='resSales' type='hidden' value='".$salesID."'>";
          }
          ?>
          <br />
          <div class="text-left">
            <button id="AddOK" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> Save</button>
            <a href="BEclient_accounts"/><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> BACK </button></a>
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
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script>
$(function(){
  $("#AddOK").click(function(){

    $("#err_companyName").hide();
    $("#err_companyAddress").hide();
    $("#err_username").hide();
    $("#err_mail").hide();
    //$("#err_Title").hide();
    $("#err_countryCode").hide();
    $("#err_tel").hide();
    $("#err_resSales").hide();

    if($("#companyName").val()==""){
      document.getElementById("companyName").focus();
      $("#err_companyName").show();
      exit;
    }
    if($("#companyAddress").val()==""){
      document.getElementById("companyAddress").focus();
      $("#err_companyAddress").show();
      exit;
    }username
    if($("#username").val()==""){
      document.getElementById("username").focus();
      $("#err_username").show();
      exit;
    }
    if($("#email").val()!=""){
      var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;  //前面的註解*+/是search_str字串;
      var mail_val = $("#email").val();
      if(search_str.test(mail_val)){

      }else{
        alert("格式錯誤1");
        $("#err_mail").show();
        document.getElementById("email").focus();
        exit;
      }
    }else if($("#email").val()==""){
      document.getElementById("email").focus();
      $("#err_mail").show();
      exit;
    }
    /*if($("#Title").val()==""){
      document.getElementById("Title").focus();
      $("#err_Title").show();
      exit;
    }*/

    /*if($("#countryCode").val()=="none"){
      document.getElementById("countryCode").focus();
      $("#err_countryCode").show();
      exit;
    }*/

    if($("#tel").val()==""){
      document.getElementById("tel").focus();
      $("#err_tel").show();
      exit;
    }
    if($("#resSales").val()=="none"){
      document.getElementById("resSales").focus();
      $("#err_resSales").show();
      exit;
    }

    var companyName = $("#companyName").val();
    var companyAddress = $("#companyAddress").val();
    var username = $("#username").val();
    var email = $("#email").val();
    var Title = $("#Title").val();
    //var countryCode = $("#countryCode :selected").attr("data-countryCode");
    var countryCode = "";
    var tel = $("#tel").val();
    var resSales = $("#resSales").val();
    var Region = $("#Region").val();
    var kind = "Add";
    var url = "clientAccounts";
    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: {
        companyName : companyName,
        companyAddress : companyAddress,
        username : username,
        email : email,
        Title : Title,
        countryCode : countryCode,
        tel : tel,
        resSales : resSales,
        Region : Region,
        kind : kind
      },
      success: function(message){
        if(message == "email"){
          $('#err_mail2').show();
          exit;
        }else if(message == "success"){
          alert("Add Client Account Done.");
          document.location.href="BEclient_accounts";
          exit;
        }else{
          alert(message);
          exit;
        }
      }
    });

  })
})

</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>