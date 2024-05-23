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
$now=date('Y-m-d H:i:s',time());

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

$str_count="SELECT COUNT(*) FROM partner_announcement WHERE 1";
$list1 =mysqli_query($link_db,$str_count);
list($public_count) = mysqli_fetch_row($list1);

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


$str_annTime="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE Status='0' AND Schedule>'0000-00-00 00:00:00'";
$cmd_annTime=mysqli_query($link_db,$str_annTime);
while($data_annTime=mysqli_fetch_row($cmd_annTime)){
	if(strtotime($now)>strtotime($data_annTime[3])){
		$update="UPDATE partner_announcement SET Status='1', U_DATE='".$now."' WHERE ID='".$data_annTime[0]."'";
		$cmd_update=mysqli_query($link_db,$update);
	}
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>BACKEND - Contents Management - MiTAC Partner Zone</title>


	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
	<link rel="shortcut icon" href="/images/ico/favicon.ico">
	<link rel="manifest" href="images/favicon/site.webmanifest">
	<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

	<!-- BEGIN VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
	<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
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
							<li class="breadcrumb-item active"> Announcements
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">



			<div class="row">
				<div class="col-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">

								<h1>Contents Management - Announcements</h1>
								<!--total-->	
								<hr>				
								<div class="row">
									<div class="col-md-12">
										<h3>Total: <span class="info darken-4 t700"><?=$public_count?></span></h3>

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




								<div class="text-left"><a href="AddAnnouncement"  /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add</button></a></div>


								<!--announcement list table-->

								<table class="table table-hover table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Date Created</th>		
											<th>Title</th>
											<th>Release To</th>	
											<th>Release Schedule (CST)</th>
											<th>Status</th>		
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$time="";
										$str="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE 1 ORDER BY C_DATE DESC LIMIT $start, $per";
										$cmd=mysqli_query($link_db,$str);
										while($data=mysqli_fetch_row($cmd)){
											if($data[5]==0){
												$status="Offline";
											}else{
												$status="Online";
											}
											if($data[3]=="0000-00-00 00:00:00"){
												$time=$data[6];
											}else{
												$time=$data[3];
											}
										?>
										<tr>
											<td><?=$data[6];?></td>
											<td><?=$data[1];?></td>
											<td><?=$data[2];?></td>		
											<td><?=$time;?></td>
											<td><?=$status;?></td>		
											<td>
												<a href="EditAnnouncement@<?=$data[0];?>"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
												<a href="" data-toggle="modal" data-target="#del-announcement"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="Assigned('<?=$data[0];?>')">Delete</button></a>
											</td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
								<input id="assID" type="hidden" value="">
								<!--end announcement list table-->


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






<!--delete announcement Modal -->
<div class="modal fade text-left" id="del-announcement" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="red"><i class="ft-trash-2"></i><h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div class="modal-body">
					Are you sure you want to delete this announcement - <br />[title]?
				</div>

				<div class="modal-footer">
					<input id="DeleteOK" type="button" class="btn btn-info " value="Yes, Delete it.">
					<input type="button" class="btn btn-secondary" data-dismiss="modal" value="No">	
				</div>
		</div>
	</div>
</div>
<!-- end delete announcement Modal -->





<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="app-assets/vendors/js/editors/ckeditor/ckeditor.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
<script src="app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<script src="app-assets/js/scripts/editors/editor-ckeditor.js"></script>
<script src="app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
<!-- END PAGE LEVEL JS-->
<script>
function Assigned(i,j){
	var deleteID=i;
	document.getElementById("assID").value=deleteID;
}

$("#DeleteOK").click(function(){
	var ID = document.getElementById("assID").value;
	var kind="Delete";
	var url = "AnnProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	ID : ID,  
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Delete Done.");
  		//document.location.href="BEcontents";
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