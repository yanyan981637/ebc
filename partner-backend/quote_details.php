<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
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
$str = str_replace("master","",$str);*/
$str = str_replace("truncate","",$str);
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

$strQT="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Version FROM partner_projects WHERE QT_ID='".$QTID."'";
$cmdQT=mysqli_query($link_db,$strQT);
$dataQT=mysqli_fetch_row($cmdQT);

$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE ID='".$dataQT[3]."'";
$cmd=mysqli_query($link_db,$str);
$result=mysqli_fetch_row($cmd);

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>Quotation <?=$QTID?> Details</title>


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

<style>
body, h1, h2, h3, h4, h5 , div {color:#000}

</style>


</head>
<body>
<div class="app-content content">
	<div class="content-wrapper">

		<div class="content-body">

			<section class="card">
				<div id="invoice-template" class="card-body">
					<!-- Company Details -->
					<div id="invoice-company-details" class="row">
						<div class="col-md-6 col-sm-12 text-center text-md-left">
							<div class="media">
								<img src="./images/tyan-logo.png">
								<div class="media-body">
					<!--<ul class="ml-2 px-0 list-unstyled">
						<li class="text-bold-800">TYAN Computer Corporation</li>
						<li>39660 Eureka Drive,</li>
						<li>Newark, CA 94560</li>
						<li>United States</li>
					</ul>-->
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12 text-center text-md-right">
			<h2>ID: <?=$dataQT[1]?> - v.<?=$dataQT[10]?></h2>
		</div>
	</div>
	<!--/ Company Details -->

	<!-- Customer Details -->
	<div id="invoice-customer-details" class="row pt-2">
		<div class="col-sm-12 text-center text-md-left">
			<p class="text-muted">To</p>
		</div>
		<div class="col-md-6 col-sm-12 text-center text-md-left">
			<ul class="px-0 list-unstyled">
				<li class="text-bold-800">
					<li><?=$result[0]?></li>
					<li><?=$result[4]?></li>
					<li><?=$result[5]?></li>
				</ul>
			</div>
			<div class="col-md-6 col-sm-12 text-center text-md-right">
				<p><span class="text-muted">Date :</span> <?=$dataQT[4]?></p>
				<p><span class="text-muted">Due Date :  </span><?=$dataQT[5]?></p>
				<p><span class="text-muted">Terms & Conditions : </span> <?=$dataQT[6]?></p>
			</div>
		</div>
		<!--/ Customer Details -->

		<!--  Items Details -->
		<div id="invoice-items-details" class="pt-2">
			<div class="row">
				<div class="table-responsive col-sm-12">
					<table class="table">
						<thead class="bg-grey bg-lighten-4">
							<tr>
								<th>#</th>
								<th>Item & Description</th>
								<th >Qty</th>
								<th >Unit Price (USD$)</th>
								<th >Total (USD$)</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							$strItems="SELECT ID, QT_ID, Products, Qty, UnitPrice, Description, Sort, MiTAC_PN FROM partner_projects_items WHERE QT_ID='".$QTID."' ORDER BY Sort ASC";
              $cmd=mysqli_query($link_db,$strItems);
              while($Items=mysqli_fetch_row($cmd)) {
              	$total=$Items[3]*$Items[4];
              	$total_tmp+=$total;
              	$total=number_format($total,2,'.',',');
              	if($Items[7]!=""){
              		$MiTAC_PN="(".$Items[7].")";
              	}else{
              		$MiTAC_PN="";
              	}
							?>
							<tr><th scope="row"><?=$Items[6]?></th>
								<td><h4><?=$Items[2].$MiTAC_PN?></h4>
									<div style="padding:5px 15px; font-style: italic;"><?=$Items[5]?></div>
								</td>
								<td><?=$Items[3]?></td>
								<td><?=$Items[4]?></td>
								<td><?=$total?></td>
							</tr>
							<?php
							$i++;
							}
							?>
						</tbody>
						<thead class="bg-grey bg-lighten-4">
							<tr><th>#</th>
								<th colspan="4">Extra Costs</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$j=1;
							$strExtra="SELECT ID, QT_ID, Item, Price, Sort FROM partner_projects_extra WHERE QT_ID='".$QTID."' ORDER BY Sort ASC";
							$cmd=mysqli_query($link_db,$strExtra);
							while($Extra=mysqli_fetch_row($cmd)) {
								$total_tmp+=$Extra[3];
								$up=number_format($Extra[3],2,'.',',');
								$to=number_format($Extra[3],2,'.',',');
							?>
							<tr><th scope="row"><?=$Extra[4]?></th>
								<td colspan="2"><?=$Extra[2]?>
								</td>
								<td><?=$up?></td>
								<td><?=$to?></td>
							</tr>
							<?php
							$j++;
							}
							$ALL_total=$total_tmp;
							$ALL_total=number_format($ALL_total,2,'.',',');
							?>
						</tbody>
						<thead class="bg-grey bg-lighten-4">
							<tr>
								<th colspan="5" class="text-right bg-grey bg-lighten-1"><h1>Total: <?=$ALL_total?> &nbsp;USD</h1></th>
							</tr>
						</thead>
						<tbody class="bg-grey bg-lighten-4">
							<tr>
								<td colspan="5" class="">
									<h4 style="font-style: italic;">REMARKS:</h4>
									<div style="padding:5px 15px; "><?=$dataQT[7]?></div>
								</td>
							</tr>
						</tbody>


					</table>

					<div class="text-center">
						Thank you for your interest in Tyan products!
					</div>

				</div>
			</div>
		</div>
	</div>
</section>


</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/ui/popper.min.js"></script>
<script src="app-assets/vendors/js/vendors.min.js"></script>
<script src="app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js"></script>
<script src="app-assets/vendors/js/ui/unison.min.js"></script>
<script src="app-assets/vendors/js/ui/blockUI.min.js"></script>
<script src="app-assets/vendors/js/ui/jquery-sliding-menu.js"></script>

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
</body>
</html>