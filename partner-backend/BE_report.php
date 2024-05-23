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

require "../config.php";

putenv("TZ=Asia/Taipei");
$now=date("m/d/Y");
$sd_default= date("m/d/Y", strtotime("-1 month"));


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

$Role=$_SESSION['role'];
if($Role=="SA"){
  echo "<script language='javascript'>self.location='BEdashboard'</script>";
}

$j=0;
$str_team="SELECT ID, Team FROM partner_teams WHERE 1";
$cmd_team=mysqli_query($link_db,$str_team);
while ($data_team=mysqli_fetch_row($cmd_team)) {
  $teamID[$j]=$data_team[0];
  $teamName[$j]=$data_team[1];
  $j++;
}


?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

<title>BACKEND - Reports - MiTAC Partner Zone</title>
<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/pickadate/pickadate.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >	
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/plugins/pickers/daterange/daterange.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
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
            <li class="breadcrumb-item active">Reports Management
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content-body">
    <!-- Pick-A-Date Picker start => require this section to show  Date Range Picker, don't know why-->
    <section id="pick-a-date" style="display:none">
     <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <form action="#">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-12">
              </div>
              <div class="col-md-6 col-sm-6 col-12">
                <div class="form-group">
                  <label></label>
                  <div class="row" >
                    <div class="col-lg-12 mb-1">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <span class="fa fa-calendar-o"></span>
                          </span>
                        </div>
                        <input id="picker_from" class="form-control datepicker" type="date">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <span class="fa fa-calendar-o"></span>
                          </span>
                        </div>
                        <input id="picker_to" class="form-control datepicker" type="date">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Pick-A-Date Picker end -->

  <!--select Date Range, default is one month-->
  <form id="top_report" name="top_report" method="post" enctype="multipart/form-data" action="excel.php">
  <div class="row">	
    <!-- <div class="col-xl-2 col-lg-12">
      <br/>
      <div class="form-group">
        <select class="form-control" id="teams" name="teams">
          <option value="" selected>All Teams</option> -->
          <?php
          //for ($k=0; $k < $j ; $k++) {
          ?>
          <!-- <option value="<?//=$teamID[$k]?>" <?php //if($s_teams==$teamID[$k]){echo "selected";}?>><?//=$teamName[$k]?></option> -->
          <?php
          //}
          ?>
        <!-- </select>
      </div>
    </div> -->
    <!-- <div class="col-xl-2 col-lg-12">
      <br/>
      <div class="form-group">
        <select class="form-control" id="sales" name="sales">
          <option value="" selected>All Sales</option>
          <?php
          /*$str_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE 1";
          $cmd_sales=mysqli_query($link_db,$str_sales);
          while($data_sales=mysqli_fetch_row($cmd_sales)){
            if($s_sales==$data_sales[0]){
              $select="selected";
            }else{
              $select="";
            }
            echo "<option  value='".$data_sales[0]."' ".$select.">".$data_sales[1]."</option>";
          }*/
          ?> 
        </select>
      </div>
    </div> -->

    <div class="col-xl-3 col-lg-12">
      <div class="">		
        <div class="form-group">
          <label></label>
          <div class='input-group'>
            <input id="date" name="date" type='text' class="form-control linkedCalendars" value="<?=$sd_default?> - <?=$now?>" />
            <div class="input-group-append">
              <span class="input-group-text">
                <span class="fa fa-calendar"></span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-lg-12">
      <br/>

      <div class="form-group">
        <select class="form-control" id="type" name="type">
          <option value="Leads" selected>Leads Report</option>
          <option value="Clients">Clients Report</option>
          <!-- <option value="Sales">Sales Report</option> -->
        </select>
      </div>
    </div>
    <div class="col-xl-3 col-lg-12">
      <br/>
      <input id="report" type="submit" class="btn btn-info mr-1 mb-1" value="Export Report" />
    </div>
  </div>
  </form>
  <!--end Date Range-->
  <br>
  <br>
  <br>
  <br>
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
<script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
<script src="app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>

<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>

<!-- END PAGE LEVEL JS-->
<script type="text/javascript">
function report()
{
  top_report.submit();
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>