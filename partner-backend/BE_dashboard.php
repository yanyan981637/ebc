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

$j=0;
$str_team="SELECT ID, Team FROM partner_teams WHERE 1";
$cmd_team=mysqli_query($link_db,$str_team);
while ($data_team=mysqli_fetch_row($cmd_team)) {
  $teamID[$j]=$data_team[0];
  $teamName[$j]=$data_team[1];
  $j++;
}


if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);

  if($_GET['teams']!="" || $_GET['teams']!="none"){
    $s_teams=dowith_sql($_GET['teams']);
    $s_teams=filter_var($s_teams);
    $switch.="A";
  }
  if($_GET['sales']!="" || $_GET['sales']!="none"){
    $s_sales=dowith_sql($_GET['sales']);
    $s_sales=filter_var($s_sales);
    $switch.="B";
  }
  $s_date=dowith_sql($_GET['sdate']);
  $s_date=filter_var($s_date);
  $s_date1=$s_date." 00:00:00";
  $e_date=dowith_sql($_GET['edate']);
  $e_date=filter_var($e_date);
  $e_date1=$e_date." 23:59:59";
  $switch.="C";


  $now=str_replace("-","/",$e_date);

  $now=date("m/d/Y",strtotime($now));
  $sd_default=str_replace("-","/",$s_date);
  $sd_default=date("m/d/Y",strtotime($sd_default));
}

$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];
if($Role=="SUAD" || $Role=="AD"){
  $L_noadmin=""; //str_Leads
  $noadmin=""; //str_Project
  $user_noadmin="1"; //str_user
}else{
  $L_noadmin="AND b.ID='".$ID."'"; //str_Leads
  $noadmin=" (a.Sales='".$ID."' OR a.Sales='".$ID."') AND"; //str_Project
  $user_noadmin="ResponsibleSales='".$ID."'"; //str_user
}

/*if($kind=="search"){
  switch ($switch) {
    case 'AC':
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid' AND b.Team='".$s_teams."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' ".$L_noadmin." GROUP BY a.STATUS";
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' AND b.Team='".$s_teams."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
      break;
    case 'BC':
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid' AND a.SalesID='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' ".$L_noadmin." GROUP BY a.STATUS";
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' AND a.Sales='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
      break;
    case 'ABC':
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid' AND b.Team='".$s_teams."' AND a.SalesID='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' ".$L_noadmin." GROUP BY a.STATUS";
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' AND b.Team='".$s_teams."' AND a.Sales='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
      break;
    default:
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid' ".$L_noadmin." GROUP BY a.STATUS";
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' GROUP BY a.STATUS";
      break;
  }
}else{
  $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid' ".$L_noadmin." GROUP BY a.STATUS";
  $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
  $str_Project.=" WHERE".$noadmin." a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' GROUP BY a.STATUS";
}*/
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <title>BACKEND - Dashboard - MiTAC Partner Zone</title>
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
            <li class="breadcrumb-item active">Dashboard
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
<div class="row">
  <div class="col-xl-2 col-lg-12">
    <br/>
    <div class="form-group">
     <select class="form-control" id="s_teams">
      <option value="" selected>All Teams</option>
      <?php
      for ($k=0; $k < $j ; $k++) {
      ?>
      <option value="<?=$teamID[$k]?>" <?php if($s_teams==$teamID[$k]){echo "selected";}?>><?=$teamName[$k]?></option>
      <?php
      }
      ?>
     </select>
   </div>
 </div>
 <!-- <div class="col-xl-2 col-lg-12">
  <br/>
  <div class="form-group">
    <select class="form-control" id="s_sales">
      <option value="" >All Sales</option>
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
  <section id="daterange">
    <div class="form">
      <div class="form-group">
        <label></label>
        <div class='input-group'>
         <input id="s_date" type='text' class="form-control linkedCalendars" value="<?=$sd_default?> - <?=$now?>"/>
         <div class="input-group-append">
          <span class="input-group-text">
           <span class="fa fa-calendar"></span>
         </span>
       </div>
     </div>

   </div>
 </div>
</section>
</div>
<div class="col-xl-5 col-lg-12">
  <br/>
  <button type="button" class="btn btn-info mr-1 mb-1" onclick="search()">Search</button>
</div>
</div>
<!--end Date Range-->

<br>
<!--4 small info cards-->
<?php
if($kind=="search"){
  switch ($switch) {
    case 'AC':
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') AND b.Team='".$s_teams."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' ".$L_noadmin;
      $str_user="SELECT COUNT(*) FROM partner_user WHERE ".$user_noadmin;
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped') AND b.Team='".$s_teams."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."'";
      break;
    case 'BC':
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') AND a.SalesID='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' ".$L_noadmin;
      $str_user="SELECT COUNT(*) FROM partner_user WHERE ".$user_noadmin;
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped') AND a.Sales='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."'";
      break;
    case 'ABC':
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') AND (b.Team='".$s_teams."' OR a.SalesID='".$s_sales."') AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' ".$L_noadmin;
      $str_user="SELECT COUNT(*) FROM partner_user WHERE ".$user_noadmin;
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped') AND (b.Team='".$s_teams."' OR a.Sales='".$s_sales."') AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."'";
      break;
    default:
      $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') ".$L_noadmin;
      $str_user="SELECT COUNT(*) FROM partner_user WHERE ".$user_noadmin;
      $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
      $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped')";
      break;
  }
}else{
  $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') ".$L_noadmin;
  $str_user="SELECT COUNT(*) FROM partner_user WHERE ".$user_noadmin;
  $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
  $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped')";
}
$list1 =mysqli_query($link_db,$str_Leads);
list($Leads_count) = mysqli_fetch_row($list1);
?>
<div class="row match-height">
  <div class="col-xl-4 col-lg-12">
    <div class="card no-border box-shadow-1">
      <div class="card-content">
        <div class="card-body">
          <div class="media">
            <div class="media-body text-left">
              <h2 class="green darken-1"><?=$Leads_count?></h2>
              <span>Total Leads</span>
            </div>
            <div class="media-right media-middle">
              <i class="icon-graph green darken-1 font-large-3 float-right"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  $list1 =mysqli_query($link_db,$str_user);
  list($user_count) = mysqli_fetch_row($list1);
  ?>
  <div class="col-xl-4 col-lg-12">
    <div class="card  no-border box-shadow-1">
      <div class="card-content">
        <div class="card-body">
          <div class="media">
            <div class="media-body text-left">
              <h2 class="pink lighten-1"><?=$user_count?></h2>
              <span>Total Clients</span>
            </div>
            <div class="media-right media-middle">
              <i class="ft-user-plus pink lighten-1 font-large-3 float-right"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  $list1 =mysqli_query($link_db,$str_Project);
  list($projects_count) = mysqli_fetch_row($list1);
  ?>
  <div class="col-xl-4 col-lg-12">
    <div class="card no-border box-shadow-1">
      <div class="card-content">
        <div class="card-body">
          <div class="media">
            <div class="media-body text-left">
              <h2 class="info darken-1 "><?=$projects_count?></h2>
              <span>Total Projects</span>
            </div>
            <div class="media-right media-middle">
              <i class="fa fa-file-text-o info darken-1  font-large-3 float-right"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- <div class="col-xl-3 col-lg-12">
    <div class="card  no-border box-shadow-1">
        <div class="card-content">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left">
                        <h2 class="primary darken-1">14,000 USD</h2>
                        <span>Total Sales</span>
                    </div>
                    <div class="media-right media-middle">
                        <i class="fa fa-usd primary darken-1 font-large-3 float-right"></i>
                    </div>
                </div>
            </div>
        </div>
      </div>-->
    </div>
  </div>
  <!--end 4 small info cards-->
  <br>
  <!--pine charts for the status of Leads and Quotes-->
  <?php
  if($kind=="search"){
    switch ($switch) {
      case 'AC':
        $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') AND b.Team='".$s_teams."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
        $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
        $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped') AND b.Team='".$s_teams."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
        break;
      case 'BC':
        $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') AND a.SalesID='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
        $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
        $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped') AND a.Sales='".$s_sales."' AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
        break;
      case 'ABC':
        $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') AND (b.Team='".$s_teams."' OR a.SalesID='".$s_sales."') AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
        $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
        $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped') AND (b.Team='".$s_teams."' OR a.Sales='".$s_sales."') AND a.C_DATE BETWEEN '".$s_date1."' AND '".$e_date1."' GROUP BY a.STATUS";
        break;
      default:
        $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') GROUP BY a.STATUS";
        $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
        $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' GROUP BY a.STATUS";
        break;
    }
  }else{
    $str_Leads="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_leads_quote a INNER JOIN partner_sales b ON a.SalesID=b.ID WHERE (a.STATUS='Processing' OR a.STATUS='Pending' OR a.STATUS='Verified' OR a.STATUS='Invalid') GROUP BY a.STATUS";
    $str_Project="SELECT COUNT(a.STATUS) as STOTAL, a.STATUS FROM partner_projects a INNER JOIN partner_sales b ON a.Sales=b.ID ";
    $str_Project.=" WHERE".$noadmin." (a.STATUS='Contact' OR a.STATUS='RFP' OR a.STATUS='Assessment' OR a.STATUS='RFQ' OR a.STATUS='Audit' OR a.STATUS='POC' OR a.STATUS='Award' OR a.STATUS='Confirmed' OR a.STATUS='Dropped' GROUP BY a.STATUS";
  }
  $cmd=mysqli_query($link_db,$str_Leads);
  while ($Status_L=mysqli_fetch_row($cmd)) {
    if($Status_L[1]=="Processing"){
      $Processing=$Status_L[0];
    }elseif($Status_L[1]=="Pending"){
      $Pending=$Status_L[0];
    }elseif($Status_L[1]=="Verified"){
      $Verified=$Status_L[0];
    }elseif($Status_L[1]=="Invalid"){
      $Invalid=$Status_L[0];
    }
  }

  $Conversion_Leads=$Verified * 100 / ($Processing + $Pending + $Verified + $Invalid);
  $Conversion_Leads=number_format($Conversion_Leads, 2);
  if($Conversion_Leads=="nan"){
    $Conversion_Leads=0;
  }
  ?>
  <div class="row match-height">
    <div class="col-xl-6 col-lg-12">
      <div class="card no-border box-shadow-1">
        <div class="card-content">
          <div class="card-body text-center">
            <div class="card-header mb-2">
              <h3 class="font-large-1 grey darken-1 text-bold-200">Status for Leads</h3>
              <span class="green darken-1">Conversion: <?=$Conversion_Leads?> %</span>
              <input id="Processing" type="hidden" value="<?=$Processing?>">
              <input id="Pending" type="hidden" value="<?=$Pending?>">
              <input id="Verified" type="hidden" value="<?=$Verified?>">
              <input id="Invalid" type="hidden" value="<?=$Invalid?>">
            </div>
            <div class="height-400">
              <canvas id="simple-pie-chart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    $cmd=mysqli_query($link_db,$str_Project);
    while ($Status_L=mysqli_fetch_row($cmd)) {
      if($Status_L[1]=="Contact"){
        $Contact=$Status_L[0];
      }elseif($Status_L[1]=="RFP"){
        $RFP=$Status_L[0];
      }elseif($Status_L[1]=="Assessment"){
        $Assessment=$Status_L[0];
      }elseif($Status_L[1]=="RFQ"){
        $RFQ=$Status_L[0];
      }elseif($Status_L[1]=="Audit"){
        $Audit=$Status_L[0];
      }elseif($Status_L[1]=="POC"){
        $POC=$Status_L[0];
      }elseif($Status_L[1]=="Award"){
        $Award=$Status_L[0];
      }elseif($Status_L[1]=="Confirmed"){
        $Confirmed=$Status_L[0];
      }elseif($Status_L[1]=="Dropped"){
        $Dropped=$Status_L[0];
      }
    }
    //$Conversion_Projects=$Confirmed * 100 / ($Contact + $RFP + $Assessment + $RFQ + $Audit + $POC + $Award + $Confirmed + $Dropped);
    $Conversion_Projects=$Confirmed * 100 / ($Contact + $RFP + $POC + $Confirmed + $Dropped);
    $Conversion_Projects=number_format($Conversion_Projects, 2);
    if($Conversion_Projects=="nan"){
      $Conversion_Projects=0;
    }
    ?>
    <div class="col-xl-6 col-lg-12">
      <div class="card no-border box-shadow-1">
        <div class="card-content">
          <div class="card-body text-center">
            <div class="card-header mb-2">
              <h3 class="font-large-1 grey darken-1 text-bold-200">Status for Projects</h3>
              <span class="info darken-1">Conversion: <?=$Conversion_Projects?> %</span>
              <input id="Contact" type="hidden" value="<?=$Contact?>">
              <input id="RFP" type="hidden" value="<?=$RFP?>">
              <!-- <input id="Assessment" type="hidden" value="<?//=$Assessment?>"> -->
              <!-- <input id="RFQ" type="hidden" value="<?//=$RFQ?>"> -->
              <!-- <input id="Audit" type="hidden" value="<?//=$Audit?>"> -->
              <input id="POC" type="hidden" value="<?=$POC?>">
              <!-- <input id="Award" type="hidden" value="<?//=$Award?>"> -->
              <input id="Confirmed" type="hidden" value="<?=$Confirmed?>">
              <input id="Dropped" type="hidden" value="<?=$Dropped?>">
            </div>
            <div class="height-400">
              <canvas id="simple-pie-chart-2"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end pine charts-->
  <br>


  <!--Line chart for leads and clients-->
<!--<div class="row">
<div class="col-12">
    <div class="card no-border box-shadow-1">
	<div class="card-content collapse show">
                <div class="card-body chartjs">
                    <div class="height-500">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
        </div>

    </div>
</div>
</div>
<!--end Line chart-->
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
<script src="app-assets/vendors/js/charts/chart.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
<!--<script src="app-assets/js/scripts/charts/chartjs/pie-doughnut/pie.js"></script>-->
<script src="app-assets/js/scripts/charts/chartjs/pie-doughnut/pie-simple.js"></script>
<!--<script src="app-assets/js/scripts/charts/chartjs/line/line.js"></script>-->
<!-- END PAGE LEVEL JS-->
<script type="text/javascript">

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
function search(){
  var s_teams=$("#s_teams").val();
  var s_sales=$("#s_sales").val();
  var date=$("#s_date").val();
  var tmp=date.split("-");
  var s_date="";
  for (var i = 0; i < tmp.length; i++) {
    if(i==0){
      sDate = new Date(tmp[i]).format("yyyy-MM-dd");
    }else{
      eDate = new Date(tmp[i]).format("yyyy-MM-dd");
    }

  };
  document.location.href="BEdashboard?kind=search&teams="+s_teams+"&sales="+s_sales+"&sdate="+sDate+"&edate="+eDate;
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>