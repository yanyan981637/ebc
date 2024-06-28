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

$str_sales="SELECT ID, NAME, EMAIL, Role FROM partner_sales WHERE 1";
$cmd_sales=mysqli_query($link_db,$str_sales);
while ($data_sales=mysqli_fetch_row($cmd_sales)) {
	$salesMail=$data_sales[2];
	$sales[$data_sales[0]]=$data_sales[1];
}

/*$str_Country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE 1";
$cmd_Country=mysqli_query($link_db,$str_Country);
while ($data_Country=mysqli_fetch_row($cmd_Country)) {
	$country[$data_Country[2]]=$data_Country[3];
	$Regions[$data_Country[2]]=$data_Country[1];
	$j++;
}*/


$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];
if($Role=="SUAD" || $Role=="AD"){
  $noAdmin="1";
}else{
	$noAdmin="ResponsibleSales='".$ID."'";
}

$switch="";
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['regions']!=""){
  $regions=dowith_sql($_GET['regions']);
  $regions=filter_var($regions);
  $regionsAll="";
  $str_Country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE Regions='".$regions."'";
	$cmd_Country=mysqli_query($link_db,$str_Country);
	while ($data_Country=mysqli_fetch_row($cmd_Country)) {
		if($regionsAll==""){
			$regionsAll=$data_Country[2];
		}else{
			$regionsAll.="','";
			$regionsAll.=$data_Country[2];
		}
	}
  $switch.="A";
}
if($_GET['sales']!="" && $_GET['sales']!="none"){
  $sales=dowith_sql($_GET['sales']);
  $sales=filter_var($sales);
  $switch.="B";
}
if($_GET['company']!=""){
  $company=dowith_sql($_GET['company']);
  $company=filter_var($company);
  $switch.="C";
}
if($_GET['mail']!=""){
  $mail=dowith_sql($_GET['mail']);
  $mail=filter_var($mail);
  $switch.="D";
}

if($kind=="search"){
  $url="kind=search&regions=".$regions."&sales=".$sales."&mail=".$mail."&company=".$company."&";
  switch ($switch) {
    case 'A':
			$str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ".$noAdmin." AND CountryCode IN ('".$regionsAll."')";
      break;
    case 'AB':
			$str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ".$noAdmin." AND CountryCode IN ('".$regionsAll."') AND ResponsibleSales='".$sales."'";
			break;
    case 'B':
			$str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ResponsibleSales='".$sales."'";
			break;
		case 'C':
			$str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ".$noAdmin." AND CompanyName='".$company."' OR CompanyID='".$company."'";
			break;
		case 'D':
			$str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ".$noAdmin." AND Email='".$mail."'";
			break;
    default:
			$str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ".$noAdmin;
			break;
  }
}else{
  $str_count="SELECT COUNT(DISTINCT CompanyID) FROM partner_user WHERE ".$noAdmin;
}
//echo $switch."++".$str_count;exit();

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
	<title>BACKEND - Client Accounts Management - MiTAC Partner Zone</title>


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

							<li class="breadcrumb-item active">Client Accounts Management
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

								<h1>Client Accounts Management</h1>
								<hr>
								<!--search & sorting-->
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<select id="sel_regions" class="form-control">
												<option selected value="">Select Regions</option>
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
												<option value="" selected>All Sales</option>
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
														echo "<option  value='".$data_sales[0]."' ".$selected.">".$data_sales[1]."</option>";
													}
												}*/
												?>
											</select>
										</div>
									</div>	 -->
									<div class="col-md-3">
										<div class="form-group">
											<input id="s_mail" type="text" class="form-control" placeholder="Email address">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input id="s_company" type="text" class="form-control" placeholder="Company Name or ID">
										</div>
									</div>
									<div class="col-md-2">
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

								<div class="text-left"><a href="addClient" /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add a client account</button></a></div>


								<!--clients list table-->

								<table class="table table-hover table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Company ID</th>
											<th>Company Name</th>
											<th>Members</th>
											<!-- <th>Responsible Sales</th> -->
											<th>Region</th>
											<th>Update Date / Time</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($kind=="search"){
										  switch ($switch) {
										    case 'A':
													$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user";
													$str.=" WHERE ".$noAdmin." AND CountryCode IN ('".$regionsAll."') GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
										      break;
										    case 'AB':
													$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user";
													$str.=" WHERE ".$noAdmin." AND CountryCode IN ('".$regionsAll."') AND ResponsibleSales='".$sales."' GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
													break;
										    case 'B':
													$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user";
													$str.=" WHERE ResponsibleSales='".$sales."' GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
													break;
												case 'C':
													$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user";
													$str.=" WHERE ".$noAdmin." AND CompanyName='".$company."' OR CompanyID='".$company."' GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
													break;
												case 'D':
													$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user";
													$str.=" WHERE ".$noAdmin." AND Email='".$mail."' GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
													break;
										    default:
													$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE ".$noAdmin." GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
													break;
										  }
										}else{
										  $str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE ".$noAdmin." GROUP BY CompanyID ORDER BY U_DATE DESC LIMIT $start, $per";
										}
									  $cmd=mysqli_query($link_db,$str);
									  while ($result=mysqli_fetch_row($cmd)) {
									  	if($result[11]=="0000-00-00 00:00:00"){
									  		$date=$result[10];
									  	}else{
									  		$date=$result[11];
									  	}

									  	if($result[9]!=""){
									  		$ResSales=$sales[$result[9]];
									  	}else{
									  		$ResSales="Edit";
									  	}
									  	$strNum="SELECT CompanyName FROM partner_user WHERE CompanyID='".$result[2]."'";
									  	$cmdNum=mysqli_query($link_db,$strNum);
									  	$num=mysqli_num_rows($cmdNum);

									  	if($ResSales==""){
									  		$ResSales="Edit";
									  	}
									  	$str_confirm="SELECT confirm_member FROM partner_user WHERE CompanyID='".$result[2]."' ORDER BY confirm_member DESC";
									  	$cmd_confirm=mysqli_query($link_db,$str_confirm);
									  	$result_confirm=mysqli_fetch_row($cmd_confirm);
									  	if($result_confirm[0]==1){
									  		$CID="<span class='info'><i class='fa fa-bookmark-o'></i></span>&nbsp;".$result[2];
									  	}else{
									  		$CID=$result[2];
									  	}
									  ?>
									  <tr>
											<td><?=$CID;?></td>
											<td><?=$result[0];?></td>
											<td><a href="clientsAccountDetails@<?=$result[2]?>"  /><?=$num;?>&nbsp;<i class="ft-edit-2"></i></a></td>
											<!-- <td>
												<a href="" data-toggle="modal" data-target="#edit-sales" / onclick="ResSales('<?//=$result[0];?>','<?//=$ResSales?>','<?//=$result[2];?>')"><?//=$ResSales?></a>
											</td> -->
											<td><?=$result[7]?></td>
											<td><?=$date;?></td>
											<td>
												<a href="clientsAccountDetails@<?=$result[2]?>"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Details</button></a>
											</td>
										</tr>
									  <?php
									  }
										?>
									</tbody>
								</table><input id="tmpCompanyID" type="hidden" value="">
								<input id="tmpCompany" type="hidden" value="">
								<!--end clients list table-->
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


<!--edit sales Modal -->
<div class="modal fade text-left" id="edit-sales" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1 id="salesModal"></h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="Sales_content" class="form-group">

				</div>
			</div>
			<div class="modal-footer">
				<input id="resSalesOK" type="submit" class="btn btn-info btn-lg" value="Save">
			</div>
			<hr>
			<div style="padding:20px">

				<h2>Update Log:</h2>

				<table class="table table-hover">
					<thead class="bg-grey bg-lighten-4">
						<tr>
							<th>Sales:</th>
							<th>Update Time / Date </th>
						</tr>
					</thead>
					<tbody id="logs">

					</tbody>
				</table>
			</div>



		</div>
	</div>
</div>

<!-- end edit sales Modal -->

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
function ResSales(i, j, k){
	var companyID=k;
	var companyName=i;
	var sales=j;
	if(sales=="Edit"){
		sales=="";
	}
	document.getElementById("tmpCompanyID").value=companyID;
	document.getElementById("tmpCompany").value=companyName;
	var kind="ResSales";
	var title=companyName+" - Edit the responsible sales";

	var url = "clientAccounts";
	$.ajax({
		type: "post",
		url: url,
		dataType: "html",
		data: {
			companyID : companyID,
			companyName : companyName,
			sales : sales,
			kind : kind
		},
		success: function(message){
			if(message == "success"){

			}else{
				document.getElementById("salesModal").innerHTML=title;
				document.getElementById("Sales_content").innerHTML=message;
			}

		}
	});

	var kind="Logs";
	var url = "clientAccounts";
	$.ajax({
		type: "post",
		url: url,
		dataType: "html",
		data: {
			companyID : companyID,
			companyName : companyName,
			kind : kind
		},
		success: function(message){
			if(message == "success"){

			}else{
				document.getElementById("logs").innerHTML=message;
			}
		}
	});
}

$("#resSalesOK").click(function(){
	var CompanyID = document.getElementById("tmpCompanyID").value;
	var Company = document.getElementById("tmpCompany").value;
	var res_sales = document.getElementById("res_sales").value;
	var kind="assSales";
	var url = "clientAccounts";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	CompanyID : CompanyID,
  	Company : Company,
  	res_sales : res_sales,
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Update Sales Done.");
  		document.location.href="BEclient_accounts";
  	}else{
  		alert(message);
  	}
  }
	});
})

function search(){
  var sel_regions=$("#sel_regions").val();
  var sel_sales=$("#sel_sales").val();
  var s_mail=$("#s_mail").val();
  var s_company=$("#s_company").val();
  document.location.href="BEclient_accounts?kind=search&regions="+sel_regions+"&sales="+sel_sales+"&mail="+s_mail+"&company="+s_company;
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>