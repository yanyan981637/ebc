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
require "countryCodeReplace.php";


putenv("TZ=Asia/Taipei");
$now=date("Y/m/d");

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

$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];

$j=0;
$str_team="SELECT ID, Team FROM partner_teams WHERE 1";
$cmd_team=mysqli_query($link_db,$str_team);
while ($data_team=mysqli_fetch_row($cmd_team)) {
	$teamID[$j]=$data_team[0];
	$teamName[$j]=$data_team[1];
	$j++;
}


/*$str_Country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE 1";
$cmd_Country=mysqli_query($link_db,$str_Country);
while ($data_Country=mysqli_fetch_row($cmd_Country)) {
	$arrCountryName[$data_Country[2]]=$data_Country[3];
	$arrRegions[$data_Country[2]]=$data_Country[1];
	$j++;
}*/

$str_sales="SELECT ID, NAME, EMAIL, Role FROM partner_sales WHERE 1";
$cmd_sales=mysqli_query($link_db,$str_sales);
while ($data_sales=mysqli_fetch_row($cmd_sales)) {
	$salesMail=$data_sales[2];
	$sales1[$data_sales[0]]=$data_sales[1];
}


$str_mapping="SELECT Sales, CountryCode FROM partner_mapping WHERE Sales LIKE '%".$salesMail."%'";
$cmd_mapping=mysqli_query($link_db,$str_mapping);
$data_mapping=mysqli_fetch_row($cmd_mapping);
$country=str_replace (",","','", $data_mapping[1]);

$switch="";

if($_GET['kind']!=""){
 	$kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);

	if($_GET['mail']!=""){
	  $mail=dowith_sql($_GET['mail']);
	  $mail=filter_var($mail);
	  $switch.="D";
	}else{
		if($_GET['status']!="" && $_GET['status']!="none"){
		  $status=dowith_sql($_GET['status']);
		  $status=filter_var($status);
		  $switch.="A";
		}
		if($_GET['regions']!="" && $_GET['regions']!="none"){
		  $regionsAll=dowith_sql($_GET['regions']);
		  $regionsAll=filter_var($regionsAll);
		  $switch.="B";
		  /*$regionsAll="";
		  $str="SELECT CountryCode FROM partner_countrycode WHERE Regions='".$regions."'";
		  $cmd =mysqli_query($link_db,$str);
			while($data_reg = mysqli_fetch_row($cmd)){
				if($regionsAll!=""){
					$regionsAll.="','";
				}
				$regionsAll.=$data_reg[0];
			}*/
		}
		/*if($_GET['sales']!="" && $_GET['sales']!="none"){
		  $sales=dowith_sql($_GET['sales']);
		  $sales=filter_var($sales);
		  $switch.="C";
		}*/
		if($_GET['type']!="" && $_GET['type']!="none"){
		  $type=dowith_sql($_GET['type']);
		  $type=filter_var($type);
		  $switch.="E";
		}
	}
}

if($Role=="SUAD" || $Role=="AD"){
  $noAdmin="1";
}else{
	$noAdmin="b.SalesID='".$ID."' OR (a.CountryCode IN ('".$country."') AND b.SalesID='')";
}

if($kind=="search"){
  $url="kind=search&status=".$status."&regions=".$regions."&sales=".$sales."&mail=".$mail."&";
  switch ($switch) {
    case 'A':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."'";
      break;
    case 'AB':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND a.CountryCode IN ('".$regionsAll."')";				
			break;
		case 'AC':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND b.SalesID='".$sales."'";				
			break;
    case 'ABC':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND a.CountryCode IN ('".$regionsAll."') AND b.SalesID='".$sales."'";	
			break;
		case 'AE':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND b.ProductTypeID LIKE '%".$type."%'";	
		break;
		case 'ABE':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND a.CountryCode IN ('".$regionsAll."') AND b.ProductTypeID LIKE '%".$type."%'";	
			break;
    case 'B':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND a.CountryCode IN ('".$regionsAll."')";				
      break;
    case 'BC':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND a.CountryCode IN ('".$regionsAll."') AND b.SalesID='".$sales."'";	
      break;
    case 'BE':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.ProductTypeID LIKE '%".$type."%' AND a.CountryCode IN ('".$regionsAll."')";	
			break;
    case 'C':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.SalesID='".$sales."'";	
     break;
    case 'D':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND a.Email='".$mail."'";	
    	break;
    case 'E':
			$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
			$str_count.=" WHERE ".$noAdmin." AND b.ProductTypeID LIKE '%".$type."%'";	
			break;
    default:
  		$str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE ".$noAdmin;
      break;
  }
}else{
  $str_count="SELECT COUNT(*) FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE ".$noAdmin;
}

$list1 =mysqli_query($link_db,$str_count);
list($public_count) = mysqli_fetch_row($list1);
$total=$public_count;
$per = 10; //每頁顯示項目數量 
$pages_totle = ceil($public_count/$per); //總頁數

if(!isset($_GET["page"])){ 
    $page=1; //設定起始頁 
} else { 
    $page = intval($_GET["page"]); //確認頁數只能夠是數值資料 
    $page = ($page > 0) ? $page : 1; //確認頁數大於零 
    $pages=0;
    $page = ($pages_totle > $page) ? $page : $pages_totle; //確認使用者沒有輸入太神奇的數字 
}

$start = ($page-1)*$per; //每頁起始資料序號

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>BACKEND - Leads Management - MiTAC Partner Zone</title>


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
								<li class="breadcrumb-item active">Leads Management
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

									<h1>Leads Management</h1>
									<hr>
									<!--search & sorting-->					
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<select id="sel_type" class="form-control" >
													<option value="" selected>All Type</option>
													<?php
													$str_type="SELECT ProductTypeID, ProductTypeName FROM producttypes WHERE 1";
													$cmd_type=mysqli_query($link_db,$str_type);
													while($data_type=mysqli_fetch_row($cmd_type)){
														if($data_type[0]==$type){
																$selected="selected";
					                  	}else{
					                  		$selected="";
					                  	}
														echo "<option  value='".$data_type[0]."'".$selected.">".$data_type[1]."</option>";
													}
													?>	
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<select id="sel_status" class="form-control" >
													<option value="" selected>All Status</option>
													<option value="Processing" <?php if($status=="Processing"){echo "selected";}?>>Processing</option>
													<option value="Pending" <?php if($status=="Pending"){echo "selected";}?>>Pending</option>			
													<option value="Verified" <?php if($status=="Verified"){echo "selected";}?>>Verified</option>
													<option value="Invalid" <?php if($status=="Invalid"){echo "selected";}?>>Invalid</option>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<select id="sel_regions" class="form-control">
													<option value="" selected>All Regions</option>
													<option value="NA" <?php if($regions=="NA"){echo "selected";}?> >North America</option>
													<option value="SA" <?php if($regions=="SA"){echo "selected";}?> >Central / South America</option>
													<option value="EUR" <?php if($regions=="EUR"){echo "selected";}?> >Europe</option>
													<option value="ME" <?php if($regions=="ME"){echo "selected";}?> >Middle East / Africa</option>
													<option value="ASIA" <?php if($regions=="ASIA"){echo "selected";}?> >Asia</option>
													<option value="Oceania" <?php if($regions=="Oceania"){echo "selected";}?> >Oceania</option>	
											</select>
											</div>
										</div>	
										<!-- <div class="col-md-2">
											<div class="form-group">
												<select id="sel_sales" class="form-control">
													<option value="">All Sales</option>
													<?php
													/*if($Role=="SUAD" || $Role=="AD"){
														$str_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE 1";
														$cmd_sales=mysqli_query($link_db,$str_sales);
														while($data_sales=mysqli_fetch_row($cmd_sales)){
															if($data_sales[0]==$sales){
																	$selected="selected";
						                  	}else{
						                  		$selected="";
						                  	}
															echo "<option  value='".$data_sales[0]."'".$selected.">".$data_sales[1]."</option>";
														}
													}*/
													?>	
												</select>
											</div>
										</div>	 -->
										<div class="col-md-3">
											<div class="form-group">
												<?
												if($Role=="SUA" || $Role=="AD"){
													$s_mail_status="disabled='disabled'";
												}
												?>
												<input id="s_mail" type="text" class="form-control" placeholder="Registrar Email address" <?=$s_mail_status?>>
											</div>
										</div>
										<div class="col-md-3">
											<button type="button" class="btn btn-info mr-1 mb-1" onclick="search()">Search</button>							
										</div>
									</div>
									<!--end search & sorting-->						
									<!--total-->	
									<hr>				
									<div class="row">
										<div class="col-md-12">
											<h3>Total: <span class="info darken-4 t700"><?=$total;?></span></h3>

											<!--Pagination-->
											<nav aria-label="Page navigation">
												<ul class="pagination justify-content-end pagination-separate pagination-curved pagination-flat pagination-lg mb-1">
													<li class="page-item">
														<a class="page-link" href="?<?=$url?>page=<?=$page-1?>" aria-label="Previous">
															<span aria-hidden="true">&laquo; Prev</span>
															<span class="sr-only">Previous</span>
														</a>
													</li>
													<?php
													for($i=1;$i<=$pages_totle;$i++) { 
														$pagenum=6;
														$last=$page+10;
														$first=$page-10;
														if($i==1 && $first>1){
															?>
															<li class="page-item"><a href="?<?=$url?>page=1" class="page-link">1</a></li>
															<li class="page-item"><a href="" class="page-link">...</a></li>
															<?php
														}
														if($i>=$first && $i<=$last){
															if ($page==$i) {
																?>
																<li class="page-item active"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
																<?php
															}else{
																?>
																<li class="page-item"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
																<?php
															}
														}
														if($i==$pages_totle && $last<$pages_totle){
															?>
															<li class="page-item"><a href="" class="page-link">...</a></li>
															<li class="page-item"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}
													}
													?>
													<li class="page-item">
														<a class="page-link" href="?<?=$url?>page=<?=$page+1?>" aria-label="Next">
															<span aria-hidden="true">Next &raquo;</span>
															<span class="sr-only">Next</span>
														</a>
													</li>
												</ul>
											</nav>
											<!--End Pagination-->

										</div>
									</div>
									<!--end total-->

									<!--leads list table-->

									<table class="table table-hover table-responsive">
										<thead class="bg-grey bg-lighten-4">
											<tr>
												<th>Lead ID</th>		
												<th>Name</th>
												<th>Email</th>
												<th>Company</th>
												<th>Region</th>
												<!-- <th>Quote</th>	 -->
												<!-- <th>Assigned Sales</th> -->
												<th>Status</th>
												<th>Update Date / Time</th>			
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php
											if($kind=="search"){
											  $url="kind=search&status=".$sel_teams."&regions=".$sel_roles."&sales=".$s_mail."&mail&";
											  switch ($switch) {
											    case 'A':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' ORDER BY b.ID DESC LIMIT $start, $per";
											      break;
											    case 'AB':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND a.CountryCode IN ('".$regionsAll."') ORDER BY b.ID DESC LIMIT $start, $per";				
														break;
													case 'AC':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_count.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND b.SalesID='".$sales."' ORDER BY b.ID DESC LIMIT $start, $per";				
														break;
													case 'ABC':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND a.CountryCode IN ('".$regionsAll."') AND b.SalesID='".$sales."' ORDER BY b.ID DESC LIMIT $start, $per";	
														break;
													case 'AE':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND b.ProductTypeID LIKE '%".$type."%' ORDER BY b.ID DESC LIMIT $start, $per";	
														break;
													case 'ABE':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND b.STATUS='".$status."' AND a.CountryCode IN ('".$regionsAll."') AND b.ProductTypeID LIKE '%".$type."%' ORDER BY b.ID DESC LIMIT $start, $per";		
														break;
											    case 'B':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND a.CountryCode IN ('".$regionsAll."') ORDER BY b.ID DESC LIMIT $start, $per";				
											      break;
											    case 'BC':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE a.CountryCode IN ('".$regionsAll."') AND b.SalesID='".$sales."' ORDER BY b.ID DESC LIMIT $start, $per";	
											      break;
											    case 'BE':
												    $str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
												    $str_list.=" WHERE ".$noAdmin." AND b.ProductTypeID LIKE '%".$type."%' AND a.CountryCode IN ('".$regionsAll."') ORDER BY b.ID DESC LIMIT $start, $per";	
												    break;
											    case 'C':
														$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
														$str_list.=" WHERE ".$noAdmin." AND b.SalesID='".$sales."' ORDER BY b.ID DESC LIMIT $start, $per";	
											     	break;
											    case 'D':
												    $str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
												    $str_list.=" WHERE ".$noAdmin." AND a.Email='".$mail."' ORDER BY b.ID DESC LIMIT $start, $per";	
												    break;
											    case 'E':
												    $str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID";
												    $str_list.=" WHERE ".$noAdmin." AND b.ProductTypeID LIKE '%".$type."%' ORDER BY b.ID DESC LIMIT $start, $per";	
												    break;
											    default:
											  		$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE ".$noAdmin." ORDER BY b.ID DESC LIMIT $start, $per";
											      break;
											  }
											}else{
											  $str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE ".$noAdmin." ORDER BY b.ID DESC LIMIT $start, $per";
											}
											//$str_list="SELECT a.ID, a.Name, a.CompanyName, a.Email, a.CountryCode, b.ID, b.SalesID, b.UserID, b.QuoteQty, b.Verification, b.STATUS, b.C_DATE, b.U_DATE";
											//$str_list.=" FROM partner_user a INNER JOIN partner_leads_quote b ON a.ID=b.UserID WHERE b.SalesID='2' OR  (a.CountryCode IN ('".$country."') AND b.SalesID='')";
											$cme_list=mysqli_query($link_db,$str_list);
											while ($data_list=mysqli_fetch_row($cme_list)) {
												if($data_list[12]=="0000-00-00 00:00:00"){
													$date=$data_list[11];
												}else{
													$date=$data_list[12];
												}
												$LID=$data_list[5];
												$Verification=explode(" ", $data_list[9]);
												if($data_list[10]=="pending"){
													if(strtotime($now)>strtotime($Verification[0])){
														$UP_LID="UPDATE partner_leads_quote SET STATUS='Invalid' WHERE ID='".$LID."'";
														mysqli_query($link_db,$UP_LID);
													}
												}
												
												if($data_list[10]!=""){
													$status=$data_list[10];
												}else{
													$status="Edit";
												}

												if($data_list[8]!=""){
													$tmp=explode(",", $data_list[8]);
													$qtynum=count(array_filter($tmp));
												}else{
													$qtynum="0";
												}
											?>
											<tr>
												<td><?=$data_list[5]?></td>		
												<td><?=$data_list[1]?></td>
												<td><?=$data_list[3]?></td>		
												<td><?=$data_list[2]?></td>
												<td><?=country($data_list[4])?></td>
												<?php
												/*$strProjects="SELECT * FROM partner_projects_client a INNER JOIN partner_projects_extra b ON a.QT_ID=b.QT_ID WHERE a.LeadsID='".$data_list[5]."'";
												$cmeProjects=mysqli_query($link_db,$strProjects);
												$ProjectsNums=mysqli_num_rows($cmeProjects);*/
												/*if($qtynum>0){
													echo "<td>Y(".$qtynum.")</td>";
												}else{
													echo "<td>N</td>";
												}*/
												?>
												<!-- <td>
													<a href="" data-toggle="modal" data-target="#edit-sales" onclick="Assigned('<?//=$LID?>','sales')" />
													<?php
													//if($data_list[6]!="" && $data_list[6]!="0"){
													//echo $sales1[$data_list[6]];
													//}else{
													?>
													<button type="button" class="btn btn-outline-info btn-sm">Add</button>
													<?php
													//}
													?>
													</a>
												</td> -->
												<td>
												<?php
												if($data_list[10]=="Verified"){
													echo $status;
												}else{
												?>
													<a href="" data-toggle="modal" data-target="#lead-status" onclick="Assigned('<?=$LID?>','status')" />
														<?=$status?>
													</a>
												<?php
												}
												?>
												</td>
												<td><?=$date?></td>
												<td>
													<a href="" data-toggle="modal" data-target="#lead-detail" /><button type="button" class="btn btn-outline-info btn-sm mr-b-1"  onclick="detail('<?=$LID?>','<?=$data_list[0]?>')">Details</button></a>
													<a href="" data-toggle="modal" data-target="#lead-log" /><button type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="Logs('<?=$LID?>','<?=$data_list[2]?>')">Log</button></a>
												</td>
											</tr>
											<?php
											}
											?>
											
										</tbody>
									</table>
									<input id="assign" type="hidden" value="">
									<!--end leads list table-->



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
	
	
	
	
	
	
	
	<!-- edit-sales assigned sales Modal -->
	<div class="modal fade text-left" id="edit-sales" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label id="ass_title" class="modal-title text-text-bold-600" ></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="#">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Select a sale rep.</label>
									<select class="form-control" id="AssignSales">
										<option value="" selected>Please select...</option>
										<?php
										$str_AS_T="SELECT ID, Team FROM partner_teams WHERE 1";
										$cmd_AS_T=mysqli_query($link_db, $str_AS_T);										
										while ($data_AS_T=mysqli_fetch_row($cmd_AS_T)) {
											echo "<optgroup label='".$data_AS_T[1]."'>";
											$str_AS_S="SELECT ID, NAME, EMAIL FROM partner_sales WHERE Team='".$data_AS_T[0]."'";
											$cmd_AS_S=mysqli_query($link_db, $str_AS_S);										
											while ($data_AS_S=mysqli_fetch_row($cmd_AS_S)) {
												echo "<option value='".$data_AS_S[0]."'>".$data_AS_S[1]." / ".$data_AS_S[2]."</option>";
											}
											echo "</optgroup>";
										}
										?>

									</select>
								</div>
								<div class="form-group">
									<label for="">Note:</label>
									<fieldset>
										<textarea id="AssignNote" class="form-control"  rows="3"></textarea>
									</fieldset>
								</div>
							</div>
						</div>								 
					</div>
					<div class="modal-footer">
						<input id="assignOK" type="button" class="btn btn-info btn-lg" value="Save" >								
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- end edit-sales assigned sales Modal -->
	
	<!-- lead-status update lead status Modal -->
	<div class="modal fade text-left" id="lead-status" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label id="up_title" class="modal-title text-text-bold-600" ></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="#">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Select a Status:</label>
									<select class="form-control" id="up_sel_status">
										<option value="Processing" >Processing</option>
										<option value="Pending" >Pending</option>	
										<option value="Invalid" >Invalid</option>
										<option value="Verified" >Verified</option>
									</select>
								</div>
								<div class="form-group">
									<label for="">Note:</label>
									<fieldset>
										<textarea class="form-control" id="status_note" rows="3"></textarea>
									</fieldset>
								</div>
							</div>
						</div>								 
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-info btn-lg" value="Save" onclick="up_status()">								
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- end lead-status update lead status Modal -->
	
	
	<!-- lead-detail Modal -->
	<div class="modal fade text-left" id="lead-detail" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title text-text-bold-600" ><h1 id="detailTitle"></h1></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="detailContent" class="col-md-12">
							<table class="table table-borderless table-hover" >
								
							</table>
							<br />
							<h3>Quote:</h3>
							<table class="table table-sm table-hover bg-grey bg-lighten-4"  >
								
							</table>
						</div>
					</div>								 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>							
				</div>

			</div>
		</div>
	</div>
	<!-- end lead-detail Modal -->	
	
	
	
	<!-- lead-log Modal -->
	<div class="modal fade text-left" id="lead-log" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title text-text-bold-600" ><h1 id="titleLog">[ID] - [company name] Logs:</h1></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-hover ">
								<thead class="bg-grey bg-lighten-4">
									<tr>
										<th>Update Time</th>		 		
										<th>Action</th>
										<th>Note</th>	
									</tr>
								</thead>
								<tbody id="bodyLog">
											
								</tbody>
							</table>


						</div>
					</div>								 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>							
				</div>

			</div>
		</div>
	</div>
	<!-- end lead-log Modal -->	

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- END BEGIN VENDOR JS-->

<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->

<script>
function Assigned(i,j){
	var kind=j;
	if(kind=="sales"){
		var LeadsID=i;
		var title="<h1>Assign a Sales for "+LeadsID+"</h1>";
		document.getElementById("ass_title").innerHTML = title; 
		document.getElementById("assign").value=LeadsID;
	}
	if(kind=="status"){
		var LeadsID=i;
		var title="<h1>Update Status for "+LeadsID+"</h1>";
		document.getElementById("up_title").innerHTML = title; 
		document.getElementById("assign").value=LeadsID;
	}
}
function Logs(i,j){
	var LeadsID=i;
	var company=j;
	var titleLog=LeadsID+" - "+company+" Logs:";
	var kind="Log";
	var url = "leadsProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	LeadsID : LeadsID,  
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  	}else{
  		document.getElementById("titleLog").innerHTML = titleLog; 
  		document.getElementById("bodyLog").innerHTML = message; 
  	}
  }
	}); 
}
function detail(i,j){
	var LeadsID=i;
	var UserID=j;
	var detailTitle=LeadsID+" Details:";
	var kind="Detail";
	var url = "leadsProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	LeadsID : LeadsID,  
  	UserID : UserID,  
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){

  	}else{
  		document.getElementById("detailTitle").innerHTML = detailTitle; 
  		document.getElementById("detailContent").innerHTML = message; 
  	}
  }
	}); 
}

$("#assignOK").click(function(){
	var LeadsID = document.getElementById("assign").value;
	var AssignSales = document.getElementById("AssignSales").value;
	var AssignNote = document.getElementById("AssignNote").value;
	var kind="AssignSales";
	var url = "leadsProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	LeadsID : LeadsID,  
  	AssignSales : AssignSales,  
  	AssignNote : AssignNote,
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Assign a Sales Done.");
  		document.location.href="BEleads";
  	}else{
  		alert(message);
  	}
  }
	}); 
})

function search(){
	var sel_type=$("#sel_type").val();
  var sel_status=$("#sel_status").val();
  var sel_regions=$("#sel_regions").val();
  //var sel_sales=$("#sel_sales").val();
  var s_mail=$("#s_mail").val();
  document.location.href="BEleads?kind=search&status="+sel_status+"&regions="+sel_regions+"&type="+sel_type+"&mail="+s_mail;
}

function up_status(){
	var LeadsID = document.getElementById("assign").value
  var up_sel_status=$("#up_sel_status").val();
  var status_note=$("#status_note").val();
  var kind="UpdateStatus"
  var url = "leadsProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	LeadsID : LeadsID,  
  	up_sel_status : up_sel_status,  
  	status_note : status_note,  
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Update Status Done.");
  		document.location.href="BEleads";
  	}else{
  		alert(message);
  	}
  }
	}); 
}
</script>

</body>
</html>
<?php
mysqli_close($link_db);
?>