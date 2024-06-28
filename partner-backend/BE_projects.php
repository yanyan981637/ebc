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

$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];

// Find Sales Name
$strSales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE 1";
$cdmSales=mysqli_query($link_db,$strSales);
while ($Sales=mysqli_fetch_row($cdmSales)) {
	$SalesN[$Sales[0]]=$Sales[1];
}
// Title Sales Name End

// Title Company Name
$str="SELECT distinct CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE 1";
$cmd=mysqli_query($link_db,$str);
while ($result=mysqli_fetch_row($cmd)) {
	$CName[$result[2]]=$result[0];
}
// Title Company Name End


$switch="";
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['sataus']!="" && $_GET['sataus']!="none"){
  $sataus=dowith_sql($_GET['sataus']);
  $sataus=filter_var($sataus);
  $switch.="A";
}
if($_GET['company']!="" && $_GET['company']!="none"){
  $company=dowith_sql($_GET['company']);
  $company=filter_var($company);
  $switch.="B";
}
if($_GET['sales']!="" && $_GET['sales']!="none"){
  $sales=dowith_sql($_GET['sales']);
  $sales=filter_var($sales);
  $switch.="C";
}

$ID=$_SESSION['ID'];
$Role=$_SESSION['role'];
if($Role=="SUAD" || $Role=="AD"){
  $noAdmin="1";
}else{
	$noAdmin="Sales='".$ID."'";
}

if($kind=="search"){
  $url="kind=search&sataus=".$sataus."&company=".$company."&sales=".$sales;
  switch ($switch) {
    case 'A':
      $str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin." AND STATUS='".$sataus."'";
      break;
    case 'AB':
      $str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin." AND STATUS='".$sataus."' AND Company='".$company."'";
			break;
		case 'ABC':
      $str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin." AND STATUS='".$sataus."' AND Company='".$company."'";
			break;
    case 'B':
			$str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin." AND Company='".$company."'";
			break;
		case 'BC':
			$str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin." AND Company='".$company."'";
			break;
    case 'C':
			$str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin;
			break;
    default:
      $str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin;
      break;
  }
}else{
  $str_count="SELECT COUNT(*) FROM partner_projects WHERE ".$noAdmin;
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
<title>BACKEND - Projects Management - MiTAC Partner Zone</title>
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

							<li class="breadcrumb-item active">Projects Management
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">
<!--
<div class=" btn-group-lg" role="group" aria-label="Basic example">
   <a href="#project" /><button type="button" class="btn btn-primary">Projects Management</button></a>
   <a href="#TC" /><button type="button" class="btn btn-primary">Terms & Conditions</button></a>
 </div>-->

 <div  id="project">
 	<div class="m-2">&nbsp;</div>

 	<div class="row">
 		<div class="col-12">
 			<div class="card no-border box-shadow-1">
 				<div class="card-content">
 					<div class="card-body">

 						<h1>Projects Management</h1>
 						<hr>
 						<!--search & sorting-->
 						<div class="row">
 							<div class="col-md-3">
 								<div class="form-group">
 									<select class="form-control" id="sel_sataus">
 										<option value="" selected>All Status</option>
 										<option value="Contact" <?php if($sataus=="Contact"){echo "selected";}?>>Contact</option>
										<option value="RFP" <?php if($sataus=="RFP"){echo "selected";}?>>RFP / RFQ</option>
										<!-- <option value="Assessment" <?php //if($sataus=="Assessment"){echo "selected";}?>>Assessment</option> -->
										<!-- <option value="RFQ" <?php //if($sataus=="RFQ"){echo "selected";}?>>RFQ</option>  -->
										<!-- <option value="Audit" <?php //if($sataus=="Audit"){echo "selected";}?>>Audit</option>-->
										<option value="POC" <?php if($sataus=="POC"){echo "selected";}?>>POC</option>
										<!-- <option value="Award" <?php //if($sataus=="Award"){echo "selected";}?>>Award</option>-->
										<option  value="Confirmed" <?php if($sataus=="Confirmed"){echo "selected";}?>>Confirmed</option>
										<option value="Dropped" <?php if($sataus=="Dropped"){echo "selected";}?>>Dropped</option>
 									</select>
 								</div>
 							</div>
 							<div class="col-md-3"><div class="form-group">
 								<select id="sel_company" class="select2 form-control">
 									<option value="" selected>Select a company</option>
 									<?php
 									if($Role=="SUAD" || $Role=="AD"){
 										$strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1";
	                  $cdmCName=mysqli_query($link_db,$strCName);
	                  while ($SEL_CName=mysqli_fetch_row($cdmCName)) {
	                  	if($SEL_CName[0]==$company){
	                  		$selected="selected";
	                  	}else{
	                  		$selected="";
	                  	}
	                    echo "<option  value='".$SEL_CName[0]."' ".$selected.">".$SEL_CName[1]."</option>";
	                  }
 									}else{
 										$strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE ResponsibleSales='".$ID."'";
	                  $cdmCName=mysqli_query($link_db,$strCName);
	                  while ($SEL_CName=mysqli_fetch_row($cdmCName)) {
	                  	if($SEL_CName[0]==$company){
	                  		$selected="selected";
	                  	}else{
	                  		$selected="";
	                  	}
	                    echo "<option  value='".$SEL_CName[0]."' ".$selected.">".$SEL_CName[1]."</option>";
	                  }
 									}

                  ?>
 								</select></div>
 							</div>
 							<!-- <div class="col-md-3">
 								<div class="form-group">
	 								<select id="sel_sales" class="select2 form-control">
	 									<option value="" selected>Select a sales</option>
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
												echo "<option value='".$data_sales[0]."' ".$selected.">".$data_sales[1]."</option>";
											}
	 									}
	 									*/
										?>
	 								</select>
	 							</div>
	 						</div> -->

 							<div class="col-md-3">
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
 						<div class="text-left"><a href="addQuotation" /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>


 						<!--Quotation list table-->

 						<table class="table table-hover table-responsive">
 							<thead class="bg-grey bg-lighten-4">
 								<tr>
 									<th>ID</th>
 									<th>Lead ID</th>
 									<th>Quotation Date</th>
 									<th>Company</th>
 									<th>Products</th>
 									<th>Amount (USD)</th>
 									<!-- <th>Sales</th>	 -->
 									<th>Status</th>
 									<th>Approval</th>
 									<th></th>
 								</tr>
 							</thead>
 							<tbody>
 								<?php
								if($kind=="search"){
								  $url="kind=search&sataus=".$sataus."&company=".$company."&sales=".$sales;
								  switch ($switch) {
								    case 'A':
								    	$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." AND STATUS='".$sataus."' ORDER BY QT_ID DESC LIMIT $start, $per";
								      break;
								    case 'AB':
								    	$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." AND STATUS='".$sataus."' AND Company='".$company."' ORDER BY QT_ID DESC LIMIT $start, $per";
											break;
										case 'ABC':
								    	$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." AND STATUS='".$sataus."' AND Company='".$company."' ORDER BY QT_ID DESC LIMIT $start, $per";
											break;
								    case 'B':
								    	$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." AND Company='".$company."' ORDER BY QT_ID DESC LIMIT $start, $per";
											break;
										case 'BC':
								    	$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." AND Company='".$company."' ORDER BY QT_ID DESC LIMIT $start, $per";
											break;
								    case 'C':
								    	$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." ORDER BY QT_ID DESC LIMIT $start, $per";
											break;
								    default:
 											$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." ORDER BY QT_ID DESC LIMIT $start, $per";
								      break;
								  }
								}else{
 								$str="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, LeadsID FROM partner_projects WHERE ".$noAdmin." ORDER BY QT_ID DESC LIMIT $start, $per";
								}
 								$cmd=mysqli_query($link_db,$str);
 								while ($data=mysqli_fetch_row($cmd)) {
 									if($data[9]=="" || $data[9]=="0"){
 										$STATUS="Edit";
 									}else{
 										$STATUS=$data[9];
 									}
 									$PR="";
 									$Amount="";
 									//$str_items="SELECT a.ID, a.QT_ID, a.Products, a.Qty, a.UnitPrice, b.Model, b.SKU, b.CATEGORY_NAME, b.MiTAC_PN FROM partner_projects_items a INNER JOIN partner_model b ON a.Products=b.SKU WHERE a.QT_ID='".$data[1]."'";
 									$str_items="SELECT a.ID, a.QT_ID, a.Products, a.Qty, a.UnitPrice FROM partner_projects_items a WHERE a.QT_ID='".$data[1]."'";
 									$cmd_items=mysqli_query($link_db,$str_items);
 									while ($data_items=mysqli_fetch_row($cmd_items)){
 										if($PR==""){
 											$PR.=$data_items[2];
 										}else{
 											$PR.="<br>".$data_items[2];
 										}
 										$Amount=$Amount+($data_items[3]*$data_items[4]);
 									}

 									$Approval_Y=$data[10];
 									$Approval_N=$data[11];

 									$strExtra="SELECT ID, QT_ID, Item, Price, Sort FROM partner_projects_extra WHERE QT_ID='".$data[1]."' ORDER BY Sort ASC";
									$cmdExtra=mysqli_query($link_db,$strExtra);
									while($Extra=mysqli_fetch_row($cmdExtra)) {
										$Amount=$Amount+$Extra[3];
									}
									$Amount=number_format($Amount,2,'.',',');
 								?>
 								<tr>
 									<td><a href="quoteDetails@<?=$data[1]?>" target="qt" /><?=$data[1]?></a></td>
 									<td><?=$data[12]?></td>
 									<td><?=$data[4]?></td>
 									<td><?=$CName[$data[2]]?></td>
 									<td><?=$PR?></td>
 									<td><?=$Amount?></td>
 									<?php
 									if($data[8]=="0"){
 									?>
 									<!-- <td>
 										<a href="#" data-toggle="modal" data-target="#edit-sales" onclick="AssID('<?//=$data[0]?>', 'AssSales', '<?//=$data[1]?>')"/>
 											<i class="ft-edit-2"></i>assign sales
 										</a>
 									</td>
 									<td>-->
 									<?php
 									}else{
 									?>
 									<!-- <td>
 										<a href="#" data-toggle="modal" data-target="#edit-sales" onclick="AssID('<?//=$data[0]?>', 'AssSales', '<?//=$data[1]?>')"/>
 											<i class="ft-edit-2"></i><?//=$SalesN[$data[8]]?>
 										</a>
 									</td>
 									<td>-->
 									<?php
 									}
 									if($STATUS=="Confirmed"){
									?>
 									<td>
 										<?=$STATUS?>
	 								</td>
	 								<?php
 									}else{
 									?>
 									<td>
 										<a href="#" data-toggle="modal" data-target="#quote-status" onclick="AssID('<?=$data[0]?>', 'Status', '<?=$data[1]?>')"/>
 										<?=$STATUS?>
	 									</a>
	 								</td>
	 								<?php
 									}


	 								if($Amount!="" && $Amount<1){
	 									echo "<td></td>";
	 								}else{
	 									echo "<td><a href='approvalQuote@".$data[1]."' /><button type='button' class='btn btn-outline-info btn-sm mr-b-1'>Send</button></a></br>Y(".$Approval_Y.") / N(".$Approval_N.")</td>";
	 								}
	 								?>
 									<td>
 										<a href="editQuotation@<?=$data[1]?>" /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
 										<a href="#" data-toggle="modal" data-target="#del-quote" onclick="AssID('<?=$data[0]?>', 'DEL', '<?=$data[1]?>')" />
 											<button type="button" class="btn btn-outline-info btn-sm mr-b-1">Delete</button>
 										</a>
 										<a href="#" data-toggle="modal" data-target="#quote-status-log" onclick="AssID('<?=$data[0]?>', 'Log', '<?=$data[1]?>')" />
 											<button type="button" class="btn btn-outline-info btn-sm" >Log</button>
 										</a>
 									</td>
 								</tr>
 								<?php
 								}
 								?>

 							</tbody>
 						</table>
 						<input id="prj_ID" type="hidden" value="">
 						<!--end Quotation list table-->
 					</div>
 				</div>
 			</div>
 		</div>

 	</div>
 </div>
 <div id="TC"><div class="m-2">&nbsp;</div>

 <div class="row">
 	<div class="col-12">

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

<!--update  quote status Modal -->
<div class="modal fade text-left" id="quote-status" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<label class="modal-title text-text-bold-600" ><h1 id="status_title"></h1></label>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form action="#">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Select a Status:</label>
							<select id="sel_status" class="form-control" >
								<option value="Contact">Contact</option>
								<option value="RFP">RFP / RFQ</option>
								<!-- <option value="Assessment">Assessment</option> -->
								<!-- <option value="RFQ">RFQ</option>  -->
								<!-- <option value="Audit">Audit</option> -->
								<option value="POC">POC</option>
								<!-- <option value="Award">Award</option> -->
								<option value="Confirmed">Confirmed</option>
								<option value="Dropped">Dropped</option>
							</select>
						</div>
						<div class="form-group">
							<label for="">Note:</label>
							<fieldset>
								<textarea id="status_note" class="form-control" rows="3"></textarea>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input id="StatusOK" type="button" class="btn btn-info btn-lg" value="Save">
			</div>
		</form>
	</div>
</div>
</div>
<!--end update quote status Modal -->

<!-- Quote status update log Modal -->

<div class="modal fade text-left" id="quote-status-log" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<label class="modal-title text-text-bold-600" ><h1 id="log_title"></h1></label>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover ">
						<thead class="bg-grey bg-lighten-4">
							<tr>
								<th>Update Time</th>
								<th>Action</th>
								<th>Note</th>
							</tr>
						</thead>
						<tbody id="logs_content">
							<tr>
								<td>2021-04-4 18:35:55 </td>
								<td>[ID]-v.2 Approval by Robby.Lin: <br />Y</td>
								<td></td>
							</tr>

						</tbody>
					</table>


				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
		</div>

	</div>
</div>
</div>

<!--end  Quote status update log Modal -->

<!--delete quote Modal -->
<div class="modal fade text-left" id="del-quote" tabindex="-1" role="dialog" aria-hidden="true">
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
					<input id="DelOK" type="button" class="btn btn-info " value="Yes, Delete it.">
					<input type="button" class="btn btn-secondary " value="No" data-dismiss="modal" aria-label="Close">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end delete quote Modal -->





<!-- edit sales  Modal -->
<div class="modal fade text-left" id="edit-sales" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1 id="e_sales_title"></h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Select a sale:</label>
								<select id="editSales" class="form-control" >


								</select>
							</div>
							<div class="form-group">
								<label for="">Note:</label>
								<fieldset>
									<textarea id="sales_note" class="form-control" rows="3"></textarea>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input id="SalesOK" type="button" class="btn btn-info btn-lg" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit-sales  Modal -->

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
function AssID(i,j,k){
	var kind=j;
	var ID=i;
	var QT=k;
	if(kind=="DEL"){
		var title="Are you sure you want to delete "+QT+" ?";
		document.getElementById("prj_ID").value=ID;
		document.getElementById("del_title").innerHTML=title;
	}else if(kind=="AssSales"){
		var title="Assign a Sales for "+QT;
		var kind="Sales";
		var url = "QuotationProcess";
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

				}else{
					document.getElementById("prj_ID").value=ID;
					document.getElementById("e_sales_title").innerHTML=title;
					document.getElementById("editSales").innerHTML=message;

				}

			}
		});
	}else if(kind=="Status"){
		var title="Update Status for "+QT;
		document.getElementById("prj_ID").value=ID;
		document.getElementById("status_title").innerHTML=title;
	}
	else if(kind=="Log"){
		var title=QT+" - Logs:";
		document.getElementById("log_title").innerHTML=title;
		var kind="LogView";
		var url = "QuotationProcess";
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

				}else{
					document.getElementById("logs_content").innerHTML=message;
				}

			}
		});
	}
}

$("#DelOK").click(function(){
  var ID = document.getElementById("prj_ID").value;
  var kind="delQT";
  var url = "QuotationProcess";
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
      alert("Delete Quotation Done.");
      document.location.href="BEprojects";
    }else{
      alert(message);
    }
  }
  });
})

$("#SalesOK").click(function(){
  var ID = document.getElementById("prj_ID").value;
  var editSales = document.getElementById("editSales").value;
  var sales_note = document.getElementById("sales_note").value;
  var kind="assSales";
  var url = "QuotationProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    ID : ID,
    editSales : editSales,
    sales_note : sales_note,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      alert("Add / Edit Sales Done.");
      document.location.href="BEprojects";
    }else{
      alert(message);
    }
  }
  });
})

$("#StatusOK").click(function(){
  var ID = document.getElementById("prj_ID").value;
  var sel_status = document.getElementById("sel_status").value;
  var status_note = document.getElementById("status_note").value;
  var kind="Status";
  var url = "QuotationProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    ID : ID,
    sel_status : sel_status,
    status_note : status_note,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      alert("Update Status Done.");
      document.location.href="BEprojects";
    }else{
      alert(message);
    }
  }
  });
})

function search(){
  var sataus=$("#sel_sataus").val();
  var company=$("#sel_company").val();
  var sales=$("#sel_sales").val();
  document.location.href="BEprojects?kind=search&sataus="+sataus+"&company="+company+"&sales="+sales;
}
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>