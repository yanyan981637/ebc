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

$strQT="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS FROM partner_projects WHERE QT_ID='".$QTID."'";
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
<title>BACKEND - Quotation Details - MiTAC Partner Zone</title>
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
							<li class="breadcrumb-item"><a href="BEprojects">Projects Management</a>
							</li>
							<li class="breadcrumb-item active">Quotation Details
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">
			<section class="card">
				<div id="invoice-template" class="card-body">
					<!-- Company Details -->
					<div id="invoice-company-details" class="row">
						<div class="col-md-6 col-sm-12 text-center text-md-left">
							<div class="media">
								<img src="images/tyan-logo.png">
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
			<h2>ID: <?=$QTID?></h2>
			
			
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
				</div>
			</div>
		</div>
	</div>

</section>

<div class="my-1">&nbsp;</div>		

</div>

</div>


<!--form-->	
<form>	
<div class="row bg-purple " style="padding:20px 60px">
	<div class="col-4">

		<div class="form-group">
			<h2 class="text-white">Send this Quotation for approval:</h2>
			<select class="form-control" id="s_AD" onchange="sel_ad('<?=$QTID?>')">
				<option value="" selected>Please select...</option>
				<?php
				$strSales="SELECT ID, NAME, EMAIL, Role FROM partner_sales WHERE Role='AD' AND checkbox='1'";
				$cmd=mysqli_query($link_db,$strSales);
        while($Sales=mysqli_fetch_row($cmd)) {
        	echo "<option value='".$Sales[0]."'>".$Sales[1]."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="col-8">
		<a href="#" data-toggle="modal" data-target="#send-confirm" /><button id="Send" type="button" class="btn btn-info btn-lg my-2" disabled><i class="fa fa-paper-plane-o"></i> Send For Approval</button></a>
		<input id="QTID" type="hidden" value="<?=$QTID?>">
	</div>
</div>
</form>
<!--end form-->	



</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!--footer-->
<?php
include("footer.php");
?>
<!--end footer--> 

<!--confirm Modal -->
<div class="modal fade text-left" id="send-confirm" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h1 class="red"><i class="ft-alert-circle"></i><h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div id="title" class="modal-body">
				</div>

				<div class="modal-footer">
					<input id="sendQT" type="button" class="btn btn-info " value="Yes, Send it."><br>
					<input type="button" class="btn btn-secondary " value="No" data-dismiss="modal" aria-label="Close">	
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end confirm Modal -->


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
$("#sendQT").click(function(){
	var QTID=document.getElementById("QTID").value;
	var AD=document.getElementById("s_AD").value;
  var kind = "Send";
  var url = "quoteProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	QTID : QTID,
    	AD : AD,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Send Quotation Done.");
  			document.location.href="BEprojects";
  			//location.reload();
    	}else{
    		alert(message);
    	}
	}
	});
})

function sel_ad(i){
	document.getElementById("Send").disabled = true; 
	var QT=i;
	var e = document.getElementById("s_AD");
	var selAD = e.options[e.selectedIndex].text;
	if(selAD=="Please select..."){
		 exit;
	}
	var title ="Are you sure you want to send "+QT+" to "+selAD+" for approval?"
	document.getElementById("title").innerHTML = title;
	document.getElementById("Send").disabled = false; 
}
</script>
</body>
</html>