<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
	echo "<script language='javascript'>self.location='../index.html'</script>";
	exit;
}
error_reporting(0);

require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    
function dowith_sql($str)
{
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);
  $str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  $str = str_replace("select","",$str);
  $str = str_replace("create","",$str);
  $str = str_replace("delete","",$str);
  $str = str_replace("insert","",$str);
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

if($_GET['qtid']!=""){
  $QTID=dowith_sql($_GET['qtid']);
  $QTID=filter_var($QTID);
}


$strQT="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Version, Approval_Y, Approval_N FROM partner_projects_tmp WHERE QT_ID='".$QTID."' ORDER BY Version DESC";
$cmdQT=mysqli_query($link_db,$strQT);
$dataQT=mysqli_fetch_row($cmdQT);
$QID=$dataQT[0];
$QT_ID=$dataQT[1];
$Version=$dataQT[10];
$Approval_Y=$dataQT[11];
$Approval_N=$dataQT[12];

$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE ID='".$dataQT[3]."'";
$cmd=mysqli_query($link_db,$str);
$result=mysqli_fetch_row($cmd);
$CompanyName=$result[0];
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>Quotation <?=$QT_ID?> Details</title>


<link rel="apple-touch-icon" sizes="180x180" href="../images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon/favicon-16x16.png">
<link rel="manifest" href="../images/favicon/site.webmanifest">
<link rel="mask-icon" href="../images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="../app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/forms/selects/select2.min.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="../app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="../app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="../app-assets/fonts/feather/style.min.css" >	
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
<!-- END Custom CSS-->
<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<style>
body, h1, h2, h3, h4, h5 , div {color:#000}

</style>


</head>
<body>

<?php
if($Approval_Y!=1 && $Approval_N!=1){
?>
<div id="top" class="bg-purple " style="padding:10px">
	<div class="text-center">
		<h2 class="text-white">Are you agree to send this quotation to <?=$CompanyName?>? &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-light btn-lg my-2" onclick="approval('<?=$QID?>','Y')">YES </button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-light btn-lg my-2" onclick="approval('<?=$QID?>','N')">NO </button></h2>
	</div>
</div>
<?php
}
?>



<div class="app-content content">
	<div class="content-wrapper">
		
		<div class="content-body">

			<section class="card">
				<div id="invoice-template" class="card-body">
					<!-- Company Details -->
					<div id="invoice-company-details" class="row">
						<div class="col-md-6 col-sm-12 text-center text-md-left">
							<div class="media">
								<img src="../images/tyan-logo.png">
								<div class="media-body">
									
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 text-center text-md-right">
							<h2>ID: <?=$QT_ID?> - v.<?=$Version?></h2>
							<input id="tmpQT_ID" type="hidden" value="<?=$QT_ID?>">
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
											$strItems="SELECT ID, QT_ID, Products, Qty, UnitPrice, Description, Sort, MiTAC_PN FROM partner_projects_items_tmp WHERE QT_ID='".$QTID."' AND Version='".$Version."' ORDER BY Sort ASC";
				              $cmd=mysqli_query($link_db,$strItems);
				              while($Items=mysqli_fetch_row($cmd)) {
				              	$QTID=$Items[1];
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
											$strExtra="SELECT ID, QT_ID, Item, Price, Sort FROM partner_projects_extra_tmp WHERE QT_ID='".$QTID."' AND Version='".$Version."' ORDER BY Sort ASC";
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

<!--
  <footer class="footer footer-static footer-dark navbar-border">
    <p class="clearfix  lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright&copy; 2004-2021 MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. All Rights Reserved. Please use the latest version of Firefox or Chrome to view this site.</span></p>
  </footer>

<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>

<!-- BEGIN VENDOR JS-->
<script src="../app-assets/vendors/js/ui/popper.min.js"></script>
<script src="../app-assets/vendors/js/vendors.min.js"></script>
<script src="../app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js"></script>
<script src="../app-assets/vendors/js/ui/unison.min.js"></script>
<script src="../app-assets/vendors/js/ui/blockUI.min.js"></script>
<script src="../app-assets/vendors/js/ui/jquery-sliding-menu.js"></script>

<!-- BEGIN PAGE VENDOR JS-->
<script src="../app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="../app-assets/js/core/app-menu.js"></script>
<script src="../app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="../app-assets/js/scripts/forms/form-repeater.js"></script>
<script src="../app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script type="text/javascript">
function approval(i,j){
	var QT=i;
	var kind=j;
	var QT_ID=document.getElementById("tmpQT_ID").value;
	var url = "approvalProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    QT : QT,
    QT_ID : QT_ID,
    kind : kind
  },
	  success: function(message){
		    if(message == "success"){
		      alert("Approval Done.");
		      document.getElementById("top").style.visibility="hidden";
		      exit;
		    }else{
		      alert(message);
		      exit;
		    }
	  }
  }); 
}
</script>
</body>
</html>