<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
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

if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['QID']!=""){
  $QID=dowith_sql($_GET['QID']);
  $QID=filter_var($QID);
  $switch.="A";
}

if($kind=="search"){
  $url="kind=search&QID=".$QID;
  switch ($switch) {
    case 'A':
      $str_count="SELECT * FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client WHERE ToUser='".$ID."') AS b ON a.Version=b.Version WHERE ToUser='".$ID."' AND QT_ID='".$QID."' GROUP BY a.QT_ID";
      break;
    default:
      $str_count="SELECT * FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client WHERE ToUser='".$ID."') AS b ON a.Version=b.Version WHERE ToUser='".$ID."' GROUP BY a.QT_ID";
      break;
  }
}else{
  $str_count="SELECT * FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client WHERE ToUser='".$ID."') AS b ON a.Version=b.Version WHERE ToUser='".$ID."' GROUP BY a.QT_ID";
}
$list1 =mysqli_query($link_db,$str_count);
$public_count=mysqli_num_rows($list1);
//list($public_count) = mysqli_fetch_row($list1);
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


<title>MiTAC Partner Zone - My Quotation</title>


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
<!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
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
				<h3 class="content-header-title mb-0 d-inline-block">My Quotation</h3>
				<div class="row breadcrumbs-top d-inline-block">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="FEdashboard">Dashboard</a>
							</li>
							<li class="breadcrumb-item active">My Quotation
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

								<h1>My Quotations</h1>


								<hr>	

								<!--search & sorting-->					
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<input id="s_QID" type="text" class="form-control" placeholder="Enter an ID">
											<div id="err_search" class="alert alert-danger mb-1" role="alert" style="display:none">
												There are no matches for your search.
											</div>	
										</div>
									</div>	
									<div class="col-md-9">
										<button type="button" class="btn btn-info mr-1 mb-1" onclick="search()">Search</button></a>	
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
											<th>ID</th>		
											<th>Quotation Date</th>
											<th>Products (Qty)</th>
											<th>Amount (USD)</th>
											<th>Due Date</th>		
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($total!="0"){
											$tmp=""; //Filter duplicate QT_ID 
											if($kind=="search"){
											  switch ($switch) {
											    case 'A':
											      //$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, Version FROM partner_projects_client WHERE ToUser='".$ID."' AND QT_ID='".$QID."' ORDER BY U_DATE DESC LIMIT $start, $per";
											      $str="SELECT a.ID, a.QT_ID, a.Company, a.ToUser, a.QT_DATE, a.Due_DATE, a.Terms, a.Remarks, a.Sales, a.STATUS, a.Approval_Y, a.Approval_N, a.Version FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client WHERE ToUser='".$ID."') AS b ON a.Version=b.Version WHERE a.ToUser='".$ID."' AND a.QT_ID='".$QID."' ORDER BY a.QT_ID DESC LIMIT $start, $per";
											      break;
											    default:
											      //$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, Version FROM partner_projects_client WHERE ToUser='".$ID."' ORDER BY U_DATE DESC LIMIT $start, $per";
											      $str="SELECT a.ID, a.QT_ID, a.Company, a.ToUser, a.QT_DATE, a.Due_DATE, a.Terms, a.Remarks, a.Sales, a.STATUS, a.Approval_Y, a.Approval_N, a.Version FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client WHERE ToUser='".$ID."') AS b ON a.Version=b.Version WHERE a.ToUser='".$ID."' ORDER BY a.QT_ID DESC LIMIT $start, $per";
											      break;
											  }
											}else{
											  //$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, Version FROM partner_projects_client WHERE ToUser='".$ID."' ORDER BY U_DATE DESC LIMIT $start, $per";
											  $str="SELECT a.ID, a.QT_ID, a.Company, a.ToUser, a.QT_DATE, a.Due_DATE, a.Terms, a.Remarks, a.Sales, a.STATUS, a.Approval_Y, a.Approval_N, a.Version FROM partner_projects_client a LEFT JOIN (SELECT QT_ID, max(version) as version FROM partner_projects_client WHERE ToUser='".$ID."') AS b ON a.Version=b.Version WHERE a.ToUser='".$ID."' ORDER BY a.QT_ID DESC LIMIT $start, $per";
											}
											$cmd=mysqli_query($link_db,$str);
											while ($data=mysqli_fetch_row($cmd)) {
												if($tmp=="" || $tmp!=$data[1]){
													$tmp=$data[1];

													$PR="";
				 									$Amount="";
			 										
				 									$str_items="SELECT ID, QT_ID, Products, Qty, UnitPrice FROM partner_projects_items_client WHERE QT_ID='".$data[1]."' AND Version='".$data[12]."' ORDER BY Sort ASC";
				 									$cmd_items=mysqli_query($link_db,$str_items);
				 									while ($data_items=mysqli_fetch_row($cmd_items)){
				 										if($PR==""){
				 											$PR.=$data_items[2]." (".$data_items[3].")";
				 										}else{
				 											$PR.="<br>".$data_items[2]." (".$data_items[3].")";
				 										}
				 										if($data[10]=="1"){
				 										$Amount=$Amount+($data_items[3]*$data_items[4]);
				 										}
				 									}

				 									$str_extra="SELECT QT_ID, Item, Price, Version FROM partner_projects_extra_client WHERE QT_ID='".$data[1]."' AND Version='".$data[12]."'";
				 									$cmd_extra=mysqli_query($link_db,$str_extra);
				 									while ($data_extra=mysqli_fetch_row($cmd_extra)){
				 										if($data[10]=="1"){
				 										$Amount=$Amount+$data_extra[2];
				 										}
				 									}	
			 									
				 									if($Amount!=""){
				 										$Amount=number_format($Amount,2,'.',',');
				 									}
				 								?>
				 								<tr>
													<td><?=$data[1]?></td>	
													<td><?=$data[4]?></td>
													<td><?=$PR?></td>
													<?php
													if($data[10]>"0"){
														echo "<td>".$Amount."</td>";
													}else{
														echo "<td></td>";
													}
													?>	
													<td><?=$data[5]?></td>		
													<td>
													<?php
													if($data[10]=="1"){
													?>
													<a href="FEquoteDetails@<?=$data[0]?>" target="_blank"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">View</button></a>
													<?php	
													}
													?>
													</td>
												</tr>
												<?php	
												}elseif($tmp!=$data[1]){

												}
			 								}
		 								}else{
		 									echo "<tr><td colspan='5' class='text-center'>There is no quotation for you. Please go to <a href='https://www.tyan.com/' target='_blank' />Tyan web site</a> to start requesting for quotes.</td></tr>";
		 								}
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
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->

<script src="app-assets/js/self.js"></script>
<script type="text/javascript">
function search(){
  var s_QID=$("#s_QID").val();
  document.location.href="FEmyquotation?kind=search&QID="+s_QID;
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>