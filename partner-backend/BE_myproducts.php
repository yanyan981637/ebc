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

$strPType="SELECT ID, Type, ProductTypeID FROM partner_products_type WHERE 1";
$cmdPType=mysqli_query($link_db,$strPType);
while ($PType=mysqli_fetch_row($cmdPType)) {
  $Type[$PType[2]]=$PType[1];
}

// Find Company Name
$strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1";
$cdmCName=mysqli_query($link_db,$strCName);
while ($CName=mysqli_fetch_row($cdmCName)) {
	$CompanyName[$CName[0]]=$CName[1];
}
// Find Company Name END

// Find Model and SKU
$strModel="SELECT ID, Model, SKU, ProductType, CATEGORY_NAME, MiTAC_PN FROM partner_model WHERE 1";
$cdmModel=mysqli_query($link_db,$strModel);
while ($Model=mysqli_fetch_row($cdmModel)) {
	$arr_MID[$Model[0]]=$Model[0];
	if($Model[2]==""){
		//$arr_Model[$Model[0]]=$Model[5];
		//$arr_SKU[$Model[0]]=$Model[4];
  }else{
  	$arr_Model[$Model[0]]=$Model[1];
  	$arr_SKU[$Model[0]]=$Model[2];
  }
}
// Find Model and SKU END
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['company']!="" && $_GET['company']!="none"){
  $company=dowith_sql($_GET['company']);
  $company=filter_var($company);
  $switch.="A";
}
if($_GET['input']!=""){
  $input=dowith_sql($_GET['input']);
  $input=filter_var($input);
  $str_count="SELECT ID, Model, SKU FROM partner_model WHERE Model='".$input."'";
	$cmd_count=mysqli_query($link_db,$str_count);
	$num=mysqli_num_rows($cmd_count);

	if($num<="0"){
		$str_count="SELECT ID, Model, SKU FROM partner_model WHERE SKU='".$input."'";
		$cmd_count=mysqli_query($link_db,$str_count);
		$num=mysqli_num_rows($cmd_count);
  }
  $data=mysqli_fetch_row($cmd_count);
  $modelID=$data[0];
  $switch.="B";
}

$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];
if($Role=="SUAD" || $Role=="AD"){
  $noAdmin="1";
}else{
	$noAdmin="SalesID='".$ID."'";
}

if($kind=="search"){
  $url="kind=search&company=".$company."&input=".$input;
  switch ($switch) {
    case 'A':
      $str_count="SELECT COUNT(*) FROM partner_myproducts WHERE ".$noAdmin." AND CompanyID='".$company."' AND SKU<>'' AND ID>'1'";
      break;
    case 'B':
			$str_count="SELECT COUNT(*) FROM partner_myproducts WHERE ".$noAdmin." AND ModelID='".$modelID."' AND SKU<>'' AND ID>'1'";
			break;
    default:
      $str_count="SELECT COUNT(*) FROM `partner_myproducts` WHERE ".$noAdmin." AND SKU<>'' AND ID>'1'";
      break;
  }
}else{
  $str_count="SELECT COUNT(*) FROM `partner_myproducts` WHERE ".$noAdmin." AND SKU<>'' AND ID>'1'";
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
<title>BACKEND - My Products Management - MiTAC Partner Zone</title>


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

						<li class="breadcrumb-item active">Products Management
						</li>
						<li class="breadcrumb-item active">My Products
						</li>
					</ol>
				</div>
			</div>
		</div>

	</div>
	<div class="content-body">





		<!--Clients' Products list table-->
		<div class="row ">
			<div class="col-12">



				<div class="card no-border box-shadow-1">
					<div class="card-content">
						<div class="card-body">

							<h1>Client's "My Products" Management:</h1>
							<hr>
							<!--search & sorting-->
							<div class="row">
								<div class="col-md-4">
									<select id="sel_company" class="select2 form-control">
										<option value="" selected>Select a company</option>
										<?php
                    $strCName="SELECT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1 GROUP BY CompanyID";
                    $cdmCName=mysqli_query($link_db,$strCName);
                    while ($CName=mysqli_fetch_row($cdmCName)) {
                      echo "<option  value='".$CName[0]."'>".$CName[1]."</option>";
                    }
                    ?>
									</select>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<input id="s_Model" type="text" class="form-control" placeholder="Enter a Model or SKU">
									</div>
								</div>
								<div class="col-md-4">
									<button type="button" class="btn btn-info mr-1 mb-1" onclick="search()">Search</button>
								</div>
							</div>
							<!--end search & sorting-->
							<!--total-->
							<hr>
							<div class="row">
								<div class="col-md-12">
									<h3>Total: <span class="info darken-4 t700"><?=$total?></span></h3>

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
														<li class="page-item"><a href="?page=1" class="page-link">1</a></li>
														<li class="page-item"><a href="" class="page-link">...</a></li>
														<?php
													}
													if($i>=$first && $i<=$last){
														if ($page==$i) {
															?>
															<li class="page-item active"><a href="?page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}else{
															?>
															<li class="page-item"><a href="?page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}
													}
													if($i==$pages_totle && $last<$pages_totle){
														?>
														<li class="page-item"><a href="" class="page-link">...</a></li>
														<li class="page-item"><a href="?page=<?=$i?>" class="page-link"><?=$i?></a></li>
														<?php
													}
												}
												?>
												<li class="page-item">
													<a class="page-link" href="?page=<?=$page+1?>" aria-label="Next">
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

							<div class="text-left"><a href="addProduct"  /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>


							<table class="table table-hover table-responsive">
								<thead class="bg-grey bg-lighten-4">
									<tr>
										<th>Company</th>
										<th>SKU / Model</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($kind=="search"){
									  switch ($switch) {
									    case 'A':
												$strList="SELECT ID, CompanyID, ModelID FROM partner_myproducts WHERE ".$noAdmin." AND CompanyID='".$company."' AND ID>'1' ORDER BY CompanyID DESC LIMIT $start, $per";
									      break;
									    case 'B':
												$strList="SELECT ID, CompanyID, ModelID FROM partner_myproducts WHERE ".$noAdmin." AND ModelID='".$modelID."' AND ID>'1' ORDER BY CompanyID DESC LIMIT $start, $per";
												break;
									    default:
												$strList="SELECT ID, CompanyID, ModelID FROM partner_myproducts WHERE ".$noAdmin." AND ModelID<>'0' AND ID>'1' ORDER BY CompanyID DESC LIMIT $start, $per";
									      break;
									  }
									}else{
										$strList="SELECT ID, CompanyID, ModelID FROM partner_myproducts WHERE ".$noAdmin." AND ModelID<>'0' AND ID>'1' ORDER BY CompanyID DESC LIMIT $start, $per";
									}
									$cmdList=mysqli_query($link_db,$strList);
									while ($List=mysqli_fetch_row($cmdList)) {
										if($arr_SKU[$List[2]]!=""){
										?>
										<tr>
											<td><?=$CompanyName[$List[1]];?></td>
											<td><?=$arr_SKU[$List[2]];?> / <?=$arr_Model[$List[2]];?></td>
											<td>
												<a href="editProduct@<?=$List[0];?>"/><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
												<a href="#" data-toggle="modal" data-target="#del-product" onclick="D_ID('<?=$List[0]?>','<?=$arr_SKU[$List[2]];?>','<?=$arr_Model[$List[2]];?>')"/><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Delete</button></a>
											</td>
										</tr>
										<?php
										}
									}
									?>
								</tbody>
							</table>
							<input id="del_ID" type="hidden" value="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end Clients' Products list table-->
	</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!--footer-->
<?php
include("footer.php");
?>
<!--end footer-->


<!--xx delete products Modal -->
<div class="modal fade text-left" id="del-product" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h1 class="red"><i class="ft-trash-2"></i><h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div id="del_title" class="modal-body">

				</div>

				<div class="modal-footer">
					<input id="delOK" type="button" class="btn btn-info " value="Yes, Delete it.">
					<input type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" value="No">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end delete products Modal -->




<!--end edit a single product Modal -->
<!-- BEGIN VENDOR JS-->


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
function search(){
  var company=$("#sel_company").val();
  var model=$("#s_Model").val();
  document.location.href="BEmyproducts?kind=search&company="+company+"&input="+model;
}
function D_ID(i,j,k){
	var DID=i;
  var SKU=j;
  var MODEL=k;
  var title="Are you sure you want to delete the "+SKU+" of "+MODEL+" ?"
  document.getElementById("del_title").innerHTML = title;
  document.getElementById("del_ID").value = DID;
}
$("#delOK").click(function(){
	var prid=document.getElementById("del_ID").value;
  var kind = "DelPR";
  var url = "MyProductProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	prid : prid,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Delete My Product Done.");
  			document.location.href="BEmyproducts";
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