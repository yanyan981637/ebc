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

$Role=$_SESSION['role'];
if($Role=="SA" ){
	echo "<script language='javascript'>self.location='BEdashboard'</script>";
}

$switch="";
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['client']!="" && $_GET['client']!="none"){
  $sel_company=dowith_sql($_GET['client']);
  $sel_company=filter_var($sel_company);
  $switch.="A";
}
if($_GET['searchSKU']!=""){
  $searchSKU=dowith_sql($_GET['searchSKU']);
  $searchSKU=filter_var($searchSKU);
  $switch.="B";
}

// Title Company Name
$str="SELECT distinct CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE 1";
$cmd=mysqli_query($link_db,$str);
while ($result=mysqli_fetch_row($cmd)) {
	$CName[$result[2]]=$result[0];
}
// Title Company Name End

if($kind=="search"){
	$url="kind=search&client=".$sel_company."&SKU=".$searchSKU;
  switch ($switch) {
    case 'A':
      $str_count="SELECT COUNT(*) FROM partner_files_group WHERE CompanyID LIKE '%".$sel_company."%'";
      break;
    case 'B':
      $str_count="SELECT COUNT(*) FROM partner_files_group WHERE SKU LIKE '%".$searchSKU."%'";
			break;
    default:
      $str_count="SELECT COUNT(*) FROM partner_files_group WHERE 1";
      break;
  }
}else{
	$str_count="SELECT COUNT(*) FROM partner_files_group WHERE 1";
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
	<title>BACKEND - Group Files Management - MiTAC Partner Zone</title>


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
							<li class="breadcrumb-item">Contents Management
							</li>
							<li class="breadcrumb-item active"> Files Group Management
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">

			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">

								<h1>Files Group Management</h1>
								<hr>
								<!--search & sorting-->					
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<select id="sel_company" class="form-control" >
												<option value="" selected>All Clients</option>
												<?php
			 									$strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1";
				                $cdmCName=mysqli_query($link_db,$strCName);
				                while ($SEL_CName=mysqli_fetch_row($cdmCName)) {
				                  if($SEL_CName[0]==$sel_company){
				                  	$selected="selected";
				                  }else{
				                  	$selected="";
				                  }
				                  echo "<option  value='".$SEL_CName[0]."' ".$selected.">".$SEL_CName[1]."</option>";
				                }
			                  ?>	
											</select>
										</div>
									</div>		
									<div class="col-md-3">
										<div class="form-group">
											<input id="searchSKU" type="text" class="form-control" placeholder="SKU">
										</div>
									</div>
									<div class="col-md-7">
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
											<a class="page-link" href="?<?=$url?>&page=<?=$page-1?>" aria-label="Previous">
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

								<div class="text-left">
									<a href="BEaddGroup"  />
										<button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add a Group</button>
									</a>
								</div>


								<!--file list table-->

								<table class="table table-hover table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Date Created</th>		
											<th>Group / SKU</th>
											<th>Clients / Companies</th>
											<th>Files</th>		
											<th>Update Date</th>		
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$date="";
										$tmpCompanyID="";
										$tmp="";
										$tmpFile="";
										$fileNums="";

										if($kind=="search"){
										  switch ($switch) {
										    case 'A':
										      $str_FGroup="SELECT ID, SKU, FileID, CompanyID, C_DATE, U_DATE FROM partner_files_group WHERE CompanyID LIKE '%".$sel_company."%' ORDER BY U_DATE DESC";
										      break;
										    case 'B':
										      $str_FGroup="SELECT ID, SKU, FileID, CompanyID, C_DATE, U_DATE FROM partner_files_group WHERE SKU LIKE '%".$searchSKU."%' ORDER BY U_DATE DESC";
													break;
										    default:
										      $str_FGroup="SELECT ID, SKU, FileID, CompanyID, C_DATE, U_DATE FROM partner_files_group WHERE 1 ORDER BY U_DATE DESC";
										      break;
										  }
										}else{
											$str_FGroup="SELECT ID, SKU, FileID, CompanyID, C_DATE, U_DATE FROM partner_files_group WHERE 1 ORDER BY U_DATE DESC";
										}

										$cmd_FGroup=mysqli_query($link_db, $str_FGroup);
										while ($data_FGroup=mysqli_fetch_row($cmd_FGroup)) {
											$Company="";
											if($data_FGroup[5]=="0000-00-00 00:00:00"){
												$tmp=explode(" ", $data_FGroup[4]);
												$date=$tmp[0];
											}else{
												$tmp=explode(" ", $data_FGroup[5]);
												$date=$tmp[0];
											}
											$tmpCompanyID=explode(",", $data_FGroup[3]);
											foreach ($tmpCompanyID as $key => $value) {
												if($value!=""){
													if($Company==""){
														$Company=$CName[$value];
													}else{
														$Company.=", ".$CName[$value];
													}
												}
											}
											$tmpFile=explode(",", $data_FGroup[2]);
											$fileNums=count($tmpFile)-1; //扣除空值
											$trigger="";
											$strfile="SELECT a.ID, a.Name, b.FileType FROM partner_files a INNER JOIN partner_files_type b ON a.FileType=b.ID";
											$strfile.="  WHERE FIND_IN_SET(a.ID ,'".$data_FGroup[2]."')";
											$cmdfile=mysqli_query($link_db, $strfile);
											while ($datafile=mysqli_fetch_row($cmdfile)) {
												$trigger.=$datafile[1]."(".$datafile[2].") / ";
											}

										?>
										<tr>
											<td><?=$data_FGroup[4];?></td>	
											<td><?=$data_FGroup[1];?></td>
											<td><?=$Company?></td>
											<td>
												<div style="width:100px" data-toggle="popover" data-trigger="hover" data-placement="top" data-container="body"  data-content="<?=$trigger?>">
													<?=$fileNums?>
												</div>
											</td>
											<td><?=$date;?></td>	
											<td>
												<a href="BEeditGroup@<?=$data_FGroup[0]?>"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
												<a href="#" data-toggle="modal" data-target="#del-file"  /><button id="del" type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="Del('<?=$data_FGroup[0]?>', '<?=$data_FGroup[1];?>')">Delete</button></a>
											</td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>

								<!--end file list table-->
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

	<!--delete member Modal -->
	<div class="modal fade text-left" id="del-file" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="red"><i class="ft-trash-2"></i><h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#">
						<div id="del_tile" class="modal-body">
							

						</div>
						<input id="del_fileID" type="hidden" value="">	
						<div class="modal-footer">
							<input id="DelOK" type="button" class="btn btn-info " value="Yes, Delete it.">
							<input type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close"  value="No">	
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- end delete member Modal -->












<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="app-assets/js/scripts/popover/popover.js"></script>
<!-- END PAGE LEVEL JS-->
<script type="text/javascript">
function Del(i, j){
	var FileID = i;
	var title="Are you sure you want to delete this group - "+j+"?";
	$("#del_tile").append(title);
	document.getElementById("del_fileID").value=FileID;
}

function search(){
  var client=$("#sel_company").val();
  var SKU=$("#searchSKU").val();
  document.location.href="BEgroupsMgt?kind=search&client="+client+"&SKU="+SKU;
}

$("#DelOK").click(function(){
  var FileID = document.getElementById("del_fileID").value;
  var kind="delGroup";
  var url = "groupProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    FileID : FileID,  
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      //document.location.href="BEgroupsMgt";
      location.reload(); 
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