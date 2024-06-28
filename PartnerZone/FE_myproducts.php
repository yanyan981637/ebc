<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/index.html'</script>";
  exit;
}
error_reporting(0);

session_start();
$now=time();
if($_SESSION['FEuser']=="" || $_SESSION['FEID']==""){
	echo "<script language='javascript'>self.location='index.html'</script>";
	exit;
}elseif($now > $_SESSION['expire']){
	session_destroy();
	setcookie("IN", "", time()-3600, '/', "tyan.com");
  echo "<script language='javascript'>self.location='index.html'</script>";
  exit();
}

require "config.php";

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
$ID=dowith_sql($_SESSION['FEID']);
$ID=filter_var($ID);

$str_user="SELECT CompanyID FROM partner_user WHERE ID='".$ID."'";
$cmd_user=mysqli_query($link_db,$str_user);
$company = mysqli_fetch_row($cmd_user);
$companyID=$company[0];

$str_Ftype="SELECT ID, FileType FROM partner_files_type WHERE 1";
$cmd_Ftype=mysqli_query($link_db,$str_Ftype);
while ($Ftype = mysqli_fetch_row($cmd_Ftype)) {
	$FileType[$Ftype[0]]=$Ftype[1];
}

if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['product']!=""){
  $MyPRID=dowith_sql($_GET['product']);
  $MyPRID=filter_var($MyPRID);
  $switch.="A";
}
if($_GET['type']!=""){
  $type=dowith_sql($_GET['type']);
  $type=filter_var($type);
  $switch.="B";
}
if($kind=="search"){
	$url="kind=search&product=".$MyPRID."&type=".$type;
	switch ($switch) {
		case 'A':
		$str="SELECT COUNT(*) FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
		$str.=" WHERE b.CompanyID='".$companyID."' AND a.ToWho LIKE '%".$MyPRID."%'";
		break;
		case 'AB':
		$str="SELECT COUNT(*) FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
		$str.=" WHERE b.CompanyID='".$companyID."' AND a.ToWho LIKE '%".$MyPRID."%' AND a.FileType='".$type."'";
		break;
		case 'B':
		$str="SELECT COUNT(*) FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
		$str.=" WHERE b.CompanyID='".$companyID."' AND a.FileType='".$type."' AND a.ToWho<>'1' ";
		break;
		default:
		$str="SELECT COUNT(*) FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
		$str.=" WHERE b.CompanyID='".$companyID."' AND a.ToWho<>'1' ";
		break;
	}
}else{
	$str="SELECT COUNT(*) FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
	$str.=" WHERE b.CompanyID='".$companyID."' AND a.ToWho<>'1' ";
}
$i=0;
$list1 =mysqli_query($link_db,$str);
list($public_count) = mysqli_fetch_row($list1);
$total=$public_count;

$per = 10; //每頁顯示項目數量
$pages_totle = ceil($total/$per); //總頁數

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

<title>MiTAC Partner Zone - My Products</title>

<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<link rel="manifest" href="images/favicon/site.webmanifest">
<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/js/gallery/photo-swipe/photoswipe.css">
<link rel="stylesheet" type="text/css" href="app-assets/vendors/js/gallery/photo-swipe/default-skin/default-skin.css">
<!-- END VENDOR CSS-->
<!-- BEGIN ROBUST CSS-->
<link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
<link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
<link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/style.min.css" >
<!-- END ROBUST CSS-->
<!-- BEGIN Page Level CSS-->
<!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
<link rel="stylesheet" type="text/css" href="app-assets/css/pages/gallery.css">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<!-- END Custom CSS-->
</head>

<body class="vertical-layout vertical-overlay-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-overlay-menu" data-col="2-columns">
<!-- fixed-top-->
<?php
include("top.php");
?>
<!-- fixed-top end--

<!--left menu-->
<?php
include("left_menu.php");
?>
<!--end left menu-->

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">

			<!--breadcrumb-->
			<div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
				<h3 class="content-header-title mb-0 d-inline-block">My Products</h3>
				<div class="row breadcrumbs-top d-inline-block">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="FEdashboard">Dashboard</a>
							</li>
							<li class="breadcrumb-item active">My Products
							</li>
						</ol>
					</div>
				</div>
			</div>
			<!--end breadcrumb-->


		</div>
		<div class="content-body">
			<input id="UID" type="hidden" value="<?=$ID?>"> <!-- for self.js -->
			<div class="row ">

				<div class="col-xl-2 col-lg-12">

				</div>
				<div class="col-xl-8 col-lg-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">
								<h1>My Products</h1>
								<hr>
								<!--search & sorting-->
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<select class="form-control" id="sel_product">
												<option value="" selected>All Products</option>
												<?php
												//$str_files="SELECT b.ID, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID WHERE b.CompanyID='".$companyID."'";
												$str_files="SELECT ID, SKU FROM partner_myproducts WHERE CompanyID='".$companyID."'";
												$cmd_files=mysqli_query($link_db,$str_files);
												while ($file=mysqli_fetch_row($cmd_files)) {
													if($file[1]!=""){
														$status="";
														if($file[0]==$MyPRID){
															$status="selected";
														}
														echo "<option  value='".$file[0]."' ".$status.">".$file[1]."</option>";

													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<select class="form-control" id="sel_type">
												<option value="" selected>All Types</option>
												<?php
												$str_type="SELECT ID, FileType FROM partner_files_type WHERE 1";
												$cmd_type=mysqli_query($link_db,$str_type);
												while ($S_type=mysqli_fetch_row($cmd_type)) {
													$status1="";
													if($S_type[0]==$type){
														$status1="selected";
													}
													echo "<option  value='".$S_type[0]."' ".$status1.">".$S_type[1]."</option>";
												}

												?>
											</select>
										</div>
									</div>


									<div class="col-md-8">
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
														<li class=""><a href="?page=1" class="page-link">1</a></li>
														<li class=""><a href="" class="page-link">...</a></li>
														<?php
													}
													if($i>=$first && $i<=$last){
														if ($page==$i) {
															?>
															<li class="active"><a href="?page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}else{
															?>
															<li class=""><a href="?page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}
													}
													if($i==$pages_totle && $last<$pages_totle){
														?>
														<li class=""><a href="" class="page-link">...</a></li>
														<li class=""><a href="?page=<?=$i?>" class="page-link"><?=$i?></a></li>
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

								<!--Quotation list table-->
								<table class="table table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Date</th>
											<th>Product</th>
											<th>Type</th>
											<th>Name</th>
											<th>Description</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($kind=="search"){
											switch ($switch) {
												case 'A':
												//$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
												//$str_file.=" WHERE b.CompanyID='".$companyID."' AND a.ToWho LIKE '%".$MyPRID."%' AND a.Status='1' AND a.ToWho<>'1'  ORDER BY a.FileDate DESC";
												$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL FROM partner_files a";
												$str_file.=" WHERE (a.ToWho LIKE '%,".$MyPRID."%' OR a.ToWho LIKE '%".$MyPRID.",%') AND a.Status='1' AND a.ToWho<>'1'  ORDER BY a.FileDate DESC";
												break;
												case 'AB':
												//$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
												//$str_file.=" WHERE b.CompanyID='".$companyID."' AND a.ToWho LIKE '%".$MyPRID."%' AND a.FileType='".$type."' AND a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC";
												$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL FROM partner_files a";
												$str_file.=" WHERE (a.ToWho LIKE '%,".$MyPRID."%' OR a.ToWho LIKE '%".$MyPRID.",%') AND a.FileType='".$type."' AND a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC";
												break;
												case 'B':
												//$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
												//$str_file.=" WHERE b.CompanyID='".$companyID."' AND a.FileType='".$type."' AND a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC";
												$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL FROM partner_files a";
												$str_file.=" WHERE a.FileType='".$type."' AND a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC";
												break;
												default:
												//$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
												//$str_file.=" WHERE b.CompanyID='".$companyID."' AND a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC" ;
												$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL FROM partner_files a";
												$str_file.=" WHERE a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC" ;
												break;
											}
										}else{
											//$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL, b.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
											//$str_file.=" WHERE b.CompanyID='".$companyID."' AND a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC";
											$str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL FROM partner_files a";
											$str_file.=" WHERE a.Status='1' AND a.ToWho<>'1' ORDER BY a.FileDate DESC";
											$str_FGroup="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, a.DownloadURL, (SELECT SKU FROM partner_files_group WHERE FIND_IN_SET(a.ID, FileID)) as SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID";
											$str_FGroup.=" WHERE FIND_IN_SET(a.ID ,(SELECT FileID FROM partner_files_group WHERE CompanyID LIKE '%".$companyID."%')) AND a.Status='1' ORDER BY a.FileDate DESC";
										}
										$cmd=mysqli_query($link_db,$str_file);
										while($data=mysqli_fetch_row($cmd)){
											$strSKU="SELECT SKU FROM partner_myproducts WHERE FIND_IN_SET(ID, '".$data[5]."') AND CompanyID='".$companyID."'";
											$cmdSKU=mysqli_query($link_db,$strSKU);
											$dataSKU=mysqli_fetch_row($cmdSKU);
											if($dataSKU[0]!=""){
												$tmp_Type=explode("/", $data[4]);
												$TypeName="";
												foreach ($tmp_Type as $key => $value) {
													if($TypeName==""){
														$TypeName=$FileType[$value];
													}else{
														$TypeName.="/".$FileType[$value];
													}
												}
												?>
												<tr>
													<td><?=$data[2]?></td>
													<td><?=$dataSKU[0]?></td>
													<td><?=$TypeName?></td>
													<td><?=$data[1]?> (<?=$data[7]?>)</td>
													<td><?=$data[6]?></td>
													<td><div class="text-center" style="font-size:5rem"><a href="<?=$data[8]?>" /><i class="fa fa-download"></i></a></div></td>
												</tr>
												<?php
											}
										}

										/*$cmd_FGroup=mysqli_query($link_db,$str_FGroup);
										while($data_FGroup=mysqli_fetch_row($cmd_FGroup)){
											if($data_FGroup[9]!=""){
												$tmp_Type=explode("/", $data_FGroup[4]);
												$TypeName="";
												foreach ($tmp_Type as $key => $value) {
													if($TypeName==""){
														$TypeName=$FileType[$value];
													}else{
														$TypeName.="/".$FileType[$value];
													}
												}
												?>
												<tr>
													<td><?=$data_FGroup[2]?></td>
													<td><?=$data_FGroup[9]?></td>
													<td><?=$TypeName?></td>
													<td><?=$data_FGroup[1]?> (<?=$data_FGroup[7]?>)</td>
													<td><?=$data_FGroup[6]?></td>
													<td><div class="text-center" style="font-size:5rem"><a href="<?=$data_FGroup[8]?>" /><i class="fa fa-download"></i></a></div></td>
												</tr>
											<?php
											}
										}*/
										?>

									</tbody>
								</table>
								<!--end Quotation list table-->
							</div>
						</div>
					</div>
				</div>


				<div class="col-xl-2 col-lg-12">

				</div>


			</div>
		</div>
	</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->


<?php
include("footer.php");
?>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/gallery/masonry/masonry.pkgd.min.js"></script>
<script src="app-assets/vendors/js/gallery/photo-swipe/photoswipe.min.js"></script>
<script src="app-assets/vendors/js/gallery/photo-swipe/photoswipe-ui-default.min.js"></script>


<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/gallery/photo-swipe/photoswipe-script.js"></script>
<!-- END PAGE LEVEL JS-->

<script src="app-assets/js/self.js"></script>
<script type="text/javascript">
function search(){
  var s_product=$("#sel_product").val();
  var s_type=$("#sel_type").val();
  document.location.href="FEmyproducts?kind=search&product="+s_product+"&type="+s_type;
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>