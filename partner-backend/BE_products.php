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

$j=0;
$strType="SELECT ID, ProductTypeID, Type FROM partner_products_type WHERE 1  ORDER BY ID ASC";
$cmdType=mysqli_query($link_db,$strType);
while ($Type=mysqli_fetch_row($cmdType)) {
	$type[$Type[1]]=$Type[2];
	//$typeName[$j]=$data_team[1];
	$j++;
}

$switch="";
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['type']!="" && $_GET['type']!="none"){
  $type1=dowith_sql($_GET['type']);
  $type1=filter_var($type1);
  $switch.="A";
}
if($_GET['input']!=""){
  $input=dowith_sql($_GET['input']);
  $input=filter_var($input);
  $switch.="B";
}

$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];
/*if($Role=="SUA" || $Role=="AD"){
  $noAdmin="1";
}else{
	$noAdmin="SalesID='".$ID."'";
}*/

if($kind=="search"){
  $url="kind=search&type=".$type1."&input=".$input;
  switch ($switch) {
    case 'A':
      $str_count="SELECT COUNT(*) FROM partner_model WHERE ProductType='".$type1."'";
      break;
    case 'B':
			$str_count="SELECT COUNT(*) FROM partner_model WHERE SKU='".$input."'";
			$cmd_count=mysqli_query($link_db,$str_count);
			$num=mysqli_fetch_row($cmd_count);
			if($num[0]<="0"){
				$str_count="SELECT COUNT(*) FROM partner_model WHERE Model='".$input."'";
				$cmd_count=mysqli_query($link_db,$str_count);
				$num=mysqli_fetch_row($cmd_count);
				if($num[0]<="0"){
					$str_count="SELECT COUNT(*) FROM partner_model WHERE MiTAC_PN='".$input."'";
					//$cmd_count=mysqli_query($link_db,$str_count);
					//$num=mysqli_num_rows($cmd_count);
				}
			}
			break;
    default:
      $str_count="SELECT COUNT(*) FROM `partner_model` WHERE 1";
      break;
  }
}else{
  $str_count="SELECT COUNT(*) FROM `partner_model` WHERE 1";
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
<title>BACKEND - Products Management - MiTAC Partner Zone</title>


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
							<li class="breadcrumb-item">Products Management
							</li>
							<li class="breadcrumb-item active">Products
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">


			<!--Products list table-->
			<div class="row ">
				<div class="col-xl-8 col-lg-12">

					<div class="card  no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">
								<h1>Products:</h1>
								<hr>
								<!--search & sorting-->
								<div class="row">
									<div class="col-md-3">
										<select id="sel_type" class="form-control">
											<option value="" selected>All Types</option>
											<?php
											foreach ($type as $key => $value) {
												echo "<option value=".$key.">".$value."</option>";
											}
											?>
										</select>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<input id="s_input" type="text" class="form-control" placeholder="Enter a Model / SKU / MiTAC P/N">
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
										<h3>Total: <span class="info darken-4 t700"><?=$total;?></span></h3>

										<!--Pagination-->
										<nav aria-label="Page navigation">
											<ul class="pagination justify-content-end pagination-separate pagination-curved pagination-flat pagination-lg mb-1">
												<li class="page-item">
													<a class="page-link" href="?<?=$url?>&page=<?=$page-1?>" aria-label="Previous">
														<span aria-hidden="true">&laquo; Prev</span>
														<span class="sr-only">Previous</span>
													</a>
												</li>
												<?php
												for($i=1;$i<=$pages_totle;$i++) {
													$pagenum=6;
													$last=$page+2;
													$first=$page-2;
													if($i==1 && $first>1){
														?>
														<li class="page-item"><a href="?<?=$url?>&page=1" class="page-link">1</a></li>
														<li class="page-item"><a href="" class="page-link">...</a></li>
														<?php
													}
													if($i>=$first && $i<=$last){
														if ($page==$i) {
															?>
															<li class="page-item active"><a href="?<?=$url?>&page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}else{
															?>
															<li class="page-item"><a href="?<?=$url?>&page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}
													}
													if($i==$pages_totle && $last<$pages_totle){
														?>
														<li class="page-item"><a href="" class="page-link">...</a></li>
														<li class="page-item"><a href="?<?=$url?>&page=<?=$i?>" class="page-link"><?=$i?></a></li>
														<?php
													}
												}
												?>
												<li class="page-item">
													<a class="page-link" href="?<?=$url?>&page=<?=$page+1?>" aria-label="Next">
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
								<div class="text-left"><a href="#" data-toggle="modal" data-target="#add-single-product" /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>
								<table class="table table-hover table-responsive" style="width:100%">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Type</th>
											<th>SKU (Model)</th>
											<th>Category (MiTAC P/N)</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($kind=="search"){
										  switch ($switch) {
										    case 'A':
													$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE, Import_BE FROM partner_model WHERE ProductType='".$type1."' ORDER BY C_DATE DESC LIMIT $start, $per";
										      break;
										    case 'B':
													$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE, Import_BE FROM partner_model WHERE SKU='".$input."' ORDER BY C_DATE DESC LIMIT $start, $per";
													$cmd_table=mysqli_query($link_db,$str_table);
													$num=mysqli_num_rows($cmd_table);
													if($num<="0"){
														$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE, Import_BE FROM partner_model WHERE Model='".$input."' ORDER BY C_DATE DESC LIMIT $start, $per";
														$cmd_table=mysqli_query($link_db,$str_table);
														$num=mysqli_num_rows($cmd_table);
														if($num<="0"){
															$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE, Import_BE FROM partner_model WHERE MiTAC_PN='".$input."' ORDER BY C_DATE DESC LIMIT $start, $per";
															//$cmd_table=mysqli_query($link_db,$str_table);
															//$num=mysqli_fetch_row($cmd_count);
														}
													}
													break;
										    default:
													$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE, Import_BE FROM partner_model WHERE 1 ORDER BY C_DATE DESC LIMIT $start, $per";
										      break;
										  }
										}else{
											//$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, Category, C_DATE, U_DATE FROM partner_model WHERE ".$noAdmin." LIMIT $start, $per";
											$str_table="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE, Import_BE FROM partner_model WHERE 1 ORDER BY C_DATE DESC LIMIT $start, $per";
										}
										$cmd_table=mysqli_query($link_db,$str_table);
										while ($table=mysqli_fetch_row($cmd_table)) {
										?>
										<tr>
											<td><?=$type[$table[1]]?></td>
											<td><?=$table[3]?> (<?=$table[2]?>)</td>
											<td><?=$table[5]?> (<?=$table[4]?>)</td>
											<td>
												<?php
												if($table[8]!="1"){
												?>
												<!-- <a href="#" data-toggle="modal" data-target="#edit-single-product" onclick="editList('<?//=$table[0]?>')" /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
												<a href="#" data-toggle="modal" data-target="#del-single-product" /><button type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="editToID('<?//=$table[0];?>', 'del', '<?//=$table[3];?>')">Delete</button></a>
												 -->
												<?php
												}
												?>
												</td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<input id="pr_ID" type="hidden" value="">
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-4 col-lg-12">
					<div class="card  no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">
								<h1>Product Types</h1>
								<input id="EditTypeID" type="hidden" value="">
								<hr>
								<a href="" data-toggle="modal" data-target="#add-tag" /><div class="badge badge-pill badge-secondary mr-b-2"><h4><i class="ft-plus"></i> ADD</h4></div></a>
								<?php
								foreach ($type as $key => $value) {
									$str_count1="SELECT COUNT(*) FROM partner_model WHERE ProductType='".$key."'";
									$cmd_count1=mysqli_query($link_db,$str_count1);
									list($num1)=mysqli_fetch_row($cmd_count1);
								?>
								<div class="badge badge-pill badge-primary mr-b-2">
									<h5 class="m-5-p-5">
										<a href="" data-toggle="modal" data-target="#edit-tag" onclick="editToID(<?=$key?>, 'Type')" />
											<?=$value?> (<?=$num1;?>)
										</a> &nbsp;&nbsp;&nbsp;
										<?php
										if($num1=="0"){
											echo "<a href='' data-toggle='modal' data-target='#del-type' onclick=editToID('".$key."','typeN','".$value."') ><i class='ft-x'></i></a>";
										}
										?>
									</h5>
								</div>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--end Products list table-->
		</div>
	</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!--footer-->
<?php
include("footer.php");
?>
<!--end footer-->



<!--delete del-type Modal -->
<div class="modal fade text-left" id="del-type" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="red"><i class="ft-trash-2"></i><h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="#">
					<div id="dTypeN" class="modal-body">


					</div>

					<div class="modal-footer">
						<input id="delTypeOK" type="button" class="btn btn-info " value="Yes, Delete it.">
						<input type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" value="No">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- end del-type Modal -->




	<!--delete single product Modal -->
	<div class="modal fade text-left" id="del-single-product" tabindex="-1" role="dialog" aria-hidden="true">
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
							<input id="delOK" type="button" class="btn btn-info " value="Yes, Delete it." >
							<input type="button" class="btn btn-secondary " data-dismiss="modal" aria-label="Close" value="No">
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- end delete single product Modal -->



		<!--add a single product Modal -->
		<div class="modal fade text-left" id="add-single-product" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<label class="modal-title text-text-bold-600" ><h1>Add a product:</h1></label>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#">
						<div class="modal-body">
							<div class="form-group">
								<label>Product Type: </label>
								<select id="s_aType" class="form-control" onchange="changeType()">
									<option value="">Select...</option>
									<?php
									foreach ($type as $key => $value) {
										echo "<option value='".$key."'>".$value."</option>";
									}
									?>
								</select>
							</div>
							<div id="div_aModel" class="form-group">
								<label>Model Name: </label>
								<select id="s_aModel" class="form-control">

								</select>
								<input id="aModel" type="text" placeholder="" class="form-control" value="" style="display:none" >
								<!-- <div id="err_aModel" class="alert alert-danger mb-1" role="alert" style="display:none" >
									Repeated Model Name
								</div> -->
							</div>
							<div id="div_aSKU" class="form-group">
								<label>SKU: </label>
								<input id="aSKU" type="text" placeholder="" class="form-control" value="">
								<div id="err_aSKU" class="alert alert-danger mb-1" role="alert" style="display:none" >Repeated SKU.</div>
							</div>
							<div id="div_aMiTAC" class="form-group">
								<label>MiTAC P/N: </label>
								<input id="aMiTAC" type="text" placeholder="" class="form-control" value="">
								<div id="err_aMitac" class="alert alert-danger mb-1" role="alert" style="display:none" >Repeated MiTAC P/N.</div>
							</div>
							<div id="div_aCate" class="form-group">
								<label>Category: </label>
								<input id="aCate" type="text" placeholder="" class="form-control" value="">
							</div>
						</div>
						<div class="modal-footer">
							<input id="addOK" type="button" class="btn btn-info btn-lg" value="Save">
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- end add single product Modal -->


		<!--edit a single product Modal -->
		<div class="modal fade text-left" id="edit-single-product" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<label class="modal-title text-text-bold-600" ><h1>Edit the product:</h1></label>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#">
						<div id="edit_list" class="modal-body">

						</div>
						<div class="modal-footer">
							<input id="editOK" type="button" class="btn btn-info btn-lg" value="Save">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

	<!--end edit a single product Modal -->





	<!--add a type Modal -->
	<div class="modal fade text-left" id="add-tag" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title text-text-bold-600" ><h1>Add a type:</h1></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="#">
					<div class="modal-body">
						<div class="form-group">
							<label>Type: </label>
							<input id="a_type" type="text" placeholder="" class="form-control" required>
							<div id="err_type" class="alert alert-danger mb-1" role="alert" style="display:none">Repeated Type.</div>
						</div>

					</div>
					<div class="modal-footer">
						<input id="addType" type="button" class="btn btn-info btn-lg" value="Create">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- end add a type Modal -->


	<!--edit a type Modal -->
	<div class="modal fade text-left" id="edit-tag" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<label class="modal-title text-text-bold-600" ><h1>Edit the type:</h1></label>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="#">
					<div class="modal-body">
						<div class="form-group">
							<label>Type: </label>
							<input id="e_type" type="text" placeholder="" class="form-control" value="[type name]">
							<div id="e_err_type" class="alert alert-danger mb-1" role="alert" style="display:none">Repeated Type.</div>
						</div>

					</div>
					<div class="modal-footer">
						<input id="EditType" type="button" class="btn btn-info btn-lg" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!--end edit a type Modal -->









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
$("#s_aModel").change(function(){
	var add=$("#s_aModel").val();
	if(add=="ADD"){
		$("#aModel").show();
	}
})

function sel_eModel(){
	var add=$("#s_eModel").val();
	if(add=="ADD"){
		$("#eModel").show();
	}
}


$("#addType").click(function(){
  var Type = document.getElementById("a_type").value;
  var kind = "AddType";
  var url = "ProductProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      Type : Type,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Add Type Done.");
  			document.location.href="BEproducts";
    	}else if(message=="Type"){
    		$("#err_type").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#EditType").click(function(){
	var ID = document.getElementById("EditTypeID").value;
  var Type = document.getElementById("e_type").value;
  var kind = "EditType";
  var url = "ProductProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	ID : ID,
      Type : Type,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Edit Type Done.");
  			document.location.href="BEproducts";
    	}else if(message=="Type"){
    		$("#e_err_type").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

function editToID(i,j,k){
	var kind=j;
	if(kind=="Type"){
		var EditTypeID=i;
		var kind="editToType";
		var url = "ProductProcess";
		$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	EditTypeID : EditTypeID,
      kind : kind
    },
	    success: function(message){
	    	if(message == "success"){

	    	}else{

	    		document.getElementById("e_type").value=message;
	    		document.getElementById("EditTypeID").value=EditTypeID;
	    	}
			}
		});
	}else if(kind=="del"){
		var EditID=i;
		var SKU=k;
		var title="Are you sure you want to delete this product - "+SKU+" ?"
		document.getElementById("pr_ID").value=EditID;
		document.getElementById("del_title").innerHTML=title;
	}else if(kind=="typeN"){
		var EditID=i;
		var TypeN=k;
		var title="Are you sure you want to delete "+TypeN+" ?";
		document.getElementById("EditTypeID").value=EditID;
		document.getElementById("dTypeN").innerHTML=title;
	}
}

function editList(i){
	var EditID=i;
	var kind="editList";
	var url = "ProductProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	EditID : EditID,
    kind : kind
  },
    success: function(message){
    	if(message == "success"){

    	}else{
    		document.getElementById("pr_ID").value=EditID;
    		document.getElementById("edit_list").innerHTML = message;
    	}
		}
	});
}

$("#addOK").click(function(){
  var Type = document.getElementById("s_aType").value;
  var Model = document.getElementById("s_aModel").value;
  if(Model=="ADD"){
  	Model = document.getElementById("aModel").value;
  }
  var SKU = document.getElementById("aSKU").value;
  var MiTAC = document.getElementById("aMiTAC").value;
  var Cate = document.getElementById("aCate").value;
  var kind = "AddPR";
  var url = "ProductProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      Type : Type,
      Model : Model,
      SKU : SKU,
      MiTAC : MiTAC,
      Cate : Cate,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Add Product Done.");
  			document.location.href="BEproducts";
    	}else if(message=="SKU"){
    		$("#err_aSKU").show();
    	}else if(message=="MiTAC"){
    		$("#err_aMitac").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#editOK").click(function(){
	var prid=document.getElementById("pr_ID").value;
  var Type = document.getElementById("s_eType").value;
  var Model = document.getElementById("s_eModel").value;
  if(Model=="ADD"){
  	Model = document.getElementById("eModel").value;
  }
  var SKU = document.getElementById("eSKU").value;
  var MiTAC = document.getElementById("eMiTAC").value;
  var Cate = document.getElementById("eCate").value;
  var kind = "EditPR";
  var url = "ProductProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	prid : prid,
      Type : Type,
      Model : Model,
      SKU : SKU,
      MiTAC : MiTAC,
      Cate : Cate,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Edit Product Done.");
  			document.location.href="BEproducts";
    	}else if(message=="Model"){
    		$("#err_eModel").show();
    	}else if(message=="SKU"){
    		$("#err_eSKU").show();
    	}else if(message=="MiTAC"){
    		$("#err_eMitac").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#delOK").click(function(){
	var prid=document.getElementById("pr_ID").value;
  var kind = "DelPR";
  var url = "ProductProcess";
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
    		alert("Delete Product Done.");
  			document.location.href="BEproducts";
    	}else{
    		alert(message);
    	}
	}
	});
})

function changeType(i){
	var tmp=i;
	if(tmp=="e"){
		var ID=document.getElementById("s_eType").value;
	}else{
		var ID=document.getElementById("s_aType").value;
	}
	var prid=document.getElementById("pr_ID").value;

	var kind="changeType";
	var url = "ProductProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	ID : ID,
  	tmp : tmp,
  	prid : prid,
    kind : kind
  },
    success: function(message){
    	if(message == "success"){

    	}else{
    		document.getElementById("s_aModel").innerHTML = message;
    		document.getElementById("s_eModel").innerHTML = message;
    	}
		}

	});
	if(tmp=="e"){
		if(ID==1 || ID==2){
			document.getElementById("div_eModel").style.display="none";
			document.getElementById("div_eSKU").style.display="none";
			document.getElementById("div_eMiTAC").style.display="";
			document.getElementById("div_eCate").style.display="";
		}else{
			document.getElementById("div_eModel").style.display="";
			document.getElementById("div_eSKU").style.display="";
			document.getElementById("div_eMiTAC").style.display="none";
			document.getElementById("div_eCate").style.display="none";
		}
	}else{
		if(ID==1 || ID==2){
			document.getElementById("div_aModel").style.display="none";
			document.getElementById("div_aSKU").style.display="none";
			document.getElementById("div_aMiTAC").style.display="";
			document.getElementById("div_aCate").style.display="";
		}else{
			document.getElementById("div_aModel").style.display="";
			document.getElementById("div_aSKU").style.display="";
			document.getElementById("div_aMiTAC").style.display="none";
			document.getElementById("div_aCate").style.display="none";
		}
	}

}

function search(){
  var sel_type=$("#sel_type").val();
  var s_input=$("#s_input").val();
  document.location.href="BEproducts?kind=search&type="+sel_type+"&input="+s_input;
}

$("#delTypeOK").click(function(){
	var EditTypeID=document.getElementById("EditTypeID").value;
  var kind = "DelType";
  var url = "ProductProcess";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	EditTypeID : EditTypeID,
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Delete Type Done.");
  			document.location.href="BEproducts";
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