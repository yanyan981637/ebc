<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
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

$Role=$_SESSION['role'];
if($Role=="SA"){
	echo "<script language='javascript'>self.location='BEdashboard'</script>";
}

$j=0;
$str_team="SELECT ID, Team FROM `partner_teams` WHERE 1";
$cmd_team=mysqli_query($link_db,$str_team);
while ($data_team=mysqli_fetch_row($cmd_team)) {
	$teamID[$j]=$data_team[0];
	$teamName[$j]=$data_team[1];
	$j++;
}

$switch="";
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['teams']!=""){
  $sel_teams=dowith_sql($_GET['teams']);
  $sel_teams=filter_var($sel_teams);
  $switch.="A";
}
if($_GET['roles']!=""){
  $sel_roles=dowith_sql($_GET['roles']);
  $sel_roles=filter_var($sel_roles);
  $switch.="B";
}
if($_GET['mail']!=""){
  $s_mail=dowith_sql($_GET['mail']);
  $s_mail=filter_var($s_mail);
  $switch.="C";
}

if($kind=="search"){
  $url="kind=search&teams=".$sel_teams."&roles=".$sel_roles."&mail=".$s_mail."&";
  switch ($switch) {
    case 'A':
      $str_count="SELECT COUNT(*) FROM partner_sales WHERE Team='".$sel_teams."'";
      break;
    case 'AB':
			$str_count="SELECT COUNT(*) FROM partner_sales WHERE Team='".$sel_teams."' AND Role='".$sel_roles."'";      
			break;
    case 'ABC':
			$str_count="SELECT COUNT(*) FROM partner_sales WHERE EMAIL='".$s_mail."'";      
			break;
    case 'B':
      $str_count="SELECT COUNT(*) FROM partner_sales WHERE Role='".$sel_roles."'";
      break;
    case 'BC':
			$str_count="SELECT COUNT(*) FROM partner_sales WHERE EMAIL='".$s_mail."'";      
      break;
    default:
      $str_count="SELECT COUNT(*) FROM `partner_sales` WHERE 1";
      break;
  }
}else{
  $str_count="SELECT COUNT(*) FROM `partner_sales` WHERE 1";
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
	<title>BACKEND - User Accounts Management - MiTAC Partner Zone</title>


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
							<li class="breadcrumb-item"><a href="BE_dashboard">Dashboard</a>
							</li>

							<li class="breadcrumb-item active">User Accounts Management
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">

			<div class="row ">
				<div class="col-xl-9 col-lg-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">

								<h1>User Accounts Management</h1>
								<hr>
								<!--search & sorting-->					
								<div class="row">

									<div class="col-md-3">
										<div class="form-group">
											<select id="sel_teams" class="form-control">
												<option value="" selected>All Teams</option>
												<?php
												for ($k=0; $k < $j ; $k++) { 
												?>
												<option value="<?=$teamID[$k]?>" <?php if($sel_teams==$teamID[$k]){echo "selected";}?>><?=$teamName[$k]?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<select id="sel_roles" class="form-control">
												<option value="" selected>All Roles</option>
												<option value="SUAD"<?php if($sel_roles=="SUAD"){echo "selected";}?>>Super Admin</option>
												<option value="AD"<?php if($sel_roles=="AD"){echo "selected";}?>>Admin</option>
												<option value="SA"<?php if($sel_roles=="SA"){echo "selected";}?>>Sales</option>		
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input id="s_mail" type="text" class="form-control" placeholder="Email address">
										</div>
									</div>
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
														<li class=""><a href="?<?=$url?>page=1" class="page-link">1</a></li>
														<li class=""><a href="" class="page-link">...</a></li>
														<?php
													}
													if($i>=$first && $i<=$last){
														if ($page==$i) {
															?>
															<li class="active"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}else{
															?>
															<li class=""><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
															<?php
														}
													}
													if($i==$pages_totle && $last<$pages_totle){
														?>
														<li class=""><a href="" class="page-link">...</a></li>
														<li class=""><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
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

								<div class="text-left"><a href="" data-toggle="modal" data-target="#add-user-account" /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>


								<!-- list table-->

								<table class="table table-hover table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Name</th>		
											<th>Email</th>
											<th>Role</th>
											<th>Team</th>
											<th>Leads</th>
											<th>Clients</th>			
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($kind=="search"){
										  switch ($switch) {
										    case 'A':
										    	$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE a.Team='".$sel_teams."' ORDER BY a.C_DATE DESC LIMIT $start, $per";
										      break;
										    case 'AB':
										    	$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE a.Team='".$sel_teams."' AND a.Role='".$sel_roles."' ORDER BY a.C_DATE DESC LIMIT $start, $per";
													break;
										    case 'ABC':
										    	$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE a.EMAIL='".$s_mail."' ORDER BY a.C_DATE DESC LIMIT $start, $per";
													break;
										    case 'B':
										    	$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE a.Role='".$sel_roles."' ORDER BY a.C_DATE DESC LIMIT $start, $per";
										      break;
										    case 'BC':
										    	$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE a.EMAIL='".$s_mail."' ORDER BY a.C_DATE DESC LIMIT $start, $per";
										      break;
										    default:
										    	$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE 1 ORDER BY a.C_DATE DESC LIMIT $start, $per";
										      break;
										  }
										}else{
											$str_list="SELECT a.ID, a.NAME, a.EMAIL, a.Role, a.checkbox, a.Team, b.Team FROM partner_sales a inner join partner_teams b on a.Team=b.ID WHERE 1 ORDER BY a.C_DATE DESC LIMIT $start, $per";
										}
										$i=0;
										
										$cmd_list=mysqli_query($link_db,$str_list);
										while ($data_list=mysqli_fetch_row($cmd_list)) {
											$strLeads="SELECT COUNT(*) FROM partner_leads_quote WHERE SalesID='".$data_list[0]."'";
											$cmdLeads=mysqli_query($link_db,$strLeads);
											$LeadsNum=mysqli_fetch_row($cmdLeads);
											$strClient="SELECT COUNT(*) FROM partner_user WHERE ResponsibleSales='".$data_list[0]."'";
											$cmdClient=mysqli_query($link_db,$strClient);
											$ClientNum=mysqli_fetch_row($cmdClient);
										?>
										<tr>
											<td><?=$data_list[1];?></td>	
											<td><?=$data_list[2];?></td>
											<td><?=$data_list[3];?></td>		
											<td><?=$data_list[6];?></td>
											<td><?=$LeadsNum[0]?></td>
											<td><?=$ClientNum[0]?></td>
											<td>
												<a href="#" data-toggle="modal" data-target="#edit-user-account" /><button id="edit_<?=$i?>" type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="editToID(<?=$data_list[0]?>,'sales')">Edit</button></a>
												<a href="#" data-toggle="modal" data-target="#delete-user-account" /><button id="delete_<?=$i?>" type="button" class="btn btn-outline-info btn-sm mr-b-1" onclick="editToID(<?=$data_list[0]?>,'del')">Delete</button></a>
											</td>
										</tr>
										<?php
										}
										?>
										<input id="edit_sales" type="hidden" value="">
									</tbody>
								</table>

								<!--end  list table-->
								<br /><br />
								<div class="p-15 m-t-b-1 bg-primary bg-lighten-4">Access functions for different roles:
									<ul>
										<li><strong>Super Admin:</strong> All functions</li>
										<li><strong>Admin:</strong> Dashboard, Leads Mgt, Client Accounts Mgt, Projects Mgt, Products Mgt, User Accounts Mgt, Contents Mgt, Reports Mgt</li>
										<li><strong>Sales:</strong> Dashboard, Leads Mgt, Client Accounts Mgt, Projects Mgt, Products Mgt</li>		
									</ul>

								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-lg-12">
					<div class="card  no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">
								<h1>Teams:</h1>
								<hr>
								<a href="" data-toggle="modal" data-target="#add-team" />
									<div class="badge badge-pill badge-secondary mr-b-2">
										<h4><i class="ft-plus"></i> ADD</h4>
									</div>
								</a>
								<?php
								for ($k=0; $k < $j ; $k++) { 
									$str_TNums="SELECT COUNT(*) FROM partner_sales WHERE Team='".$teamID[$k]."'";
									$list1_TNums =mysqli_query($link_db,$str_TNums);
									list($TNums) = mysqli_fetch_row($list1_TNums);
									?>
									<div class="badge badge-pill badge-primary mr-b-2">
										<h5 class="m-5-p-5">
											<a href="" data-toggle="modal" data-target="#edit-team" onclick="editToID(<?=$teamID[$k]?>, 'team')"/>
												<?=$teamName[$k]?> (<?=$TNums;?>)
											</a> &nbsp;&nbsp;&nbsp;&nbsp;
											<?php
											if($TNums==0){
											?>
											<a href="" data-toggle="modal" data-target="#del-team" onclick="editToID(<?=$teamID[$k]?>, 'team')"/>
												<i class="ft-x"></i>
											</a>
											<?php
											}
											?>
											
										</h5>
									</div>
									<?php
								}
								?>
								<input id="Edit_TeamID" type="hidden" value="">
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

<!--add-a user account Modal -->
<div class="modal fade text-left" id="add-user-account" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1>Add a user account:</h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="BEuser_accounts" method="post" onsubmit="return false">
				<div class="modal-body">
					<div class="form-group">
						<label>Name: </label>
						<input id="Add_Name" type="text" placeholder="" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Email: </label>
						<input id="Add_email" type="email" placeholder="" class="form-control" required>
						<div id="err_sales_mail" class="alert alert-danger mb-1" role="alert" style="display:none">This email already exists.</div>
					</div>
					<div class="form-group">
						<label>Role: </label>
						<select id="Add_Role" class="form-control" id="">
							<option value="" selected>Select...</option>
							<option  value="SUAD">Super Admin</option>
							<option  value="AD">Admin</option>
							<option  value="SA">Sales</option>		
						</select>
					</div>
					<div class="form-group">
						<div class="form-check">
							<input id="Add_checkbox" type="checkbox" class="form-check-input" id="exampleCheck1">
							<label class="form-check-label" for="exampleCheck1">Enable Quotation Approval</label>
						</div>
					</div>

					<div class="form-group">
						<label>Team: </label>
						<select id="Add_Team" class="form-control" id="">
							<option value="" selected>Select...</option>
							<?php
							for ($k=0; $k < $j ; $k++) { 
								if($teamName[$k]=="TUSA"){
									$status="selected";
								}else{
									$status="";
								}
								?>
								<option value="<?=$teamID[$k]?>" <?=$status;?> ><?=$teamName[$k]?></option>
								<?php
							}
							?>
						</select>
					</div>



				</div>
				<div class="modal-footer">
					<input id="AddSales" type="submit" class="btn btn-info btn-lg" value="Create">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end add-a user account Modal -->




<!--edit a user account Modal -->
<div class="modal fade text-left" id="edit-user-account" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1>Edit the user account:</h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="BEuser_accounts" method="post" onsubmit="return false">
				<div id="div_editSales" class="modal-body">

				</div>
				<div class="modal-footer">
					<input id="EditSales" type="submit" class="btn btn-info btn-lg" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end edit a user account Modal -->








<!--delete a user account Modal -->
<div class="modal fade text-left" id="delete-user-account" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="red"><i class="ft-trash-2"></i><h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form>
					<div id="del_user" class="modal-body">

					</div>

					<div class="modal-footer">
						<input id="del_sales" type="button" class="btn btn-info " value="Yes, Delete it.">
						<input type="button" class="btn btn-secondary " value="No" data-dismiss="modal" aria-label="Close">	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end delete a user account Modal -->












<!--add a team Modal -->
<div class="modal fade text-left" id="add-team" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1>Add a team:</h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div class="modal-body">
					<div class="form-group">
						<label>Team Name: </label>
						<input id="A_T_Name" type="text" placeholder="" class="form-control">
						<div id="err_Ateam" class="alert alert-danger mb-1" role="alert" style="display:none">Repeated Name.</div>
					</div>

				</div>
				<div class="modal-footer">
					<input id="ATeamsOK" type="button" class="btn btn-info btn-lg" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end add a team Modal -->

<!--edit a team Modal -->
<div class="modal fade text-left" id="edit-team" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1>Edit a team:</h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div class="modal-body">
					<div class="form-group">
						<label>Team Name: </label>
						<input id="E_T_Name" type="text" placeholder="" class="form-control">
						<div id="err_Eteam" class="alert alert-danger mb-1" role="alert" style="display:none">Repeated Name.</div>
					</div>
				</div>
				<div class="modal-footer">
					<input id="ETeamsOK" type="button" class="btn btn-info btn-lg" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end edit a team Modal -->




<!--delete a team Modal -->
<div class="modal fade text-left" id="del-team" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="red"><i class="ft-trash-2"></i><h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form >
					<div id="del_team" class="modal-body">
						Are you sure you want to delete [team name]?
					</div>

					<div class="modal-footer">
						<input id="DelTeam" type="button" class="btn btn-info " value="Yes, Delete it." >
						<input type="button" class="btn btn-secondary " value="No" data-dismiss="modal" aria-label="Close">	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end delete a team Modal -->	

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

<!-- END BEGIN VENDOR JS-->

<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->

<script>
$("#ATeamsOK").click(function(){
  var TeamName = document.getElementById("A_T_Name").value;
  var kind = "AddTeam";
  var url = "userAccount";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      TeamName : TeamName, 
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Add Done.");
  			document.location.href="BEuser_accounts";
    	}else if(message=="repeated"){
    		$("#err_Ateam").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#ETeamsOK").click(function(){
	var E_teamID = document.getElementById("Edit_TeamID").value;
	var TeamName = document.getElementById("E_T_Name").value;
	var kind = "EditTeam";
	var url = "userAccount";
	$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	E_teamID : E_teamID, 
      TeamName : TeamName, 
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Edit Done.");
  			document.location.href="BEuser_accounts";
    	}else if(message=="repeated"){
    		$("#err_Eteam").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#DelTeam").click(function(){
  var delTeamID = document.getElementById("Edit_TeamID").value;
  var kind = "DelTeam";
  var url = "userAccount";
  $.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
      delTeamID : delTeamID, 
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Delete Done.");
  			document.location.href="BEuser_accounts";
    	}else{
    		alert(message);
    	}
	}
	});
})

function editToID(i,j){
	var kind=j;
	if(kind=="team"){
		var EditTeameID=i;
		var kind="editToValue";
		var url = "userAccount";
		$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	EditTeameID : EditTeameID,  
      kind : kind
    },
	    success: function(message){
	    	if(message == "success"){

	    	}else{
	    		document.getElementById("del_team").innerHTML="Are you sure you want to delete "+message+"?";
	    		document.getElementById("E_T_Name").value=message;
	    		document.getElementById("Edit_TeamID").value=EditTeameID;
	    	}
			}
		});  	
	}else if(kind=="sales"){
		var EditSalesID=i;
		var kind="editToSales";
		var url = "userAccount";
		$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	EditSalesID : EditSalesID,  
      kind : kind
    },
	    success: function(message){
	    	if(message == "success"){

	    	}else{
	    		$("#div_editSales").empty(); 
	    		$("#div_editSales").append(message);
	    		document.getElementById("edit_sales").value=EditSalesID;

	    	}
			}
		});  
	}else if(kind=="del"){
		var delID=i;
		var kind="editToDel";
		var url = "userAccount";
		$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	delID : delID,  
      kind : kind
    },
	    success: function(message){
	    	if(message == "success"){

	    	}else{
	    		document.getElementById("edit_sales").value=delID;
	    		document.getElementById("del_user").innerHTML="Are you sure you want to delete "+message+" account??";

	    	}
			}
		});  	
	}
}

$("#AddSales").click(function(){
	var Add_Name = document.getElementById("Add_Name").value;
	if(Add_Name==""){
		exit;
	}
	if($("#Add_email").val()!=""){
		var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		var mail_val = $("#Add_email").val();
		if(search_str.test(mail_val)){

			$("#err_Email").hide();
		}else{
			$("#err_Email").show();
			exit;
		}
	}else if($("#Add_email").val()==""){
		exit;
	}

	var Add_Role = document.getElementById("Add_Role").value;
	if (document.getElementById("Add_checkbox").checked==true) {
    var Add_checkbox = 1; //status:on
  }else{
    var Add_checkbox = 0; //status:off
  }

	var Add_Team = document.getElementById("Add_Team").value;
	var kind = "addSales";
	var url = "userAccount";

	$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	Add_Name : Add_Name, 
      mail_val : mail_val,
      Add_Role : Add_Role, 
      Add_checkbox : Add_checkbox, 
      Add_Team : Add_Team,  
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Add Done.");
  			document.location.href="BEuser_accounts";
    	}else if(message=="repeated"){
    		$("#err_sales_mail").show();
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#EditSales").click(function(){
	var editSalesID = document.getElementById("edit_sales").value;

	var edit_Name = document.getElementById("edit_Name").value;
	if(edit_Name==""){
		exit;
	}
	if($("#edit_Email").val()!=""){
		var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		var mail_val = $("#edit_Email").val();
		if(search_str.test(mail_val)){

			$("#err_Email").hide();
		}else{
			$("#err_Email").show();
			exit;
		}
	}else if($("#edit_Email").val()==""){
		exit;
	}

	var edit_Role = document.getElementById("edit_Role").value;

	if (document.getElementById("edit_checkbox").checked==true) {
    var edit_checkbox = 1; //status:on
  }else{
    var edit_checkbox = 0; //status:off
  }

	var edit_Team = document.getElementById("edit_Team").value;
	var kind = "editSales";
	var url = "userAccount";
	$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	editSalesID : editSalesID, 
    	edit_Name : edit_Name, 
      mail_val : mail_val,
      edit_Role : edit_Role, 
      edit_checkbox : edit_checkbox, 
      edit_Team : edit_Team,  
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Edit Done.");
  			document.location.href="BEuser_accounts";
    	}else{
    		alert(message);
    	}
	}
	});
})

$("#del_sales").click(function(){
	
	var delSalesID = document.getElementById("edit_sales").value;
	var kind = "delSales";
	var url = "userAccount";

	$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	delSalesID : delSalesID,  
      kind : kind
    },
    success: function(message){
    	if(message == "success"){
    		alert("Delete Done.");
  			document.location.href="BEuser_accounts";
    	}else{
    		alert(message);
    	}
	}
	});
})

function search(){
  var sel_teams=$("#sel_teams").val();
  var sel_roles=$("#sel_roles").val();
	var mail=$("#s_mail").val();	
  document.location.href="BEuser_accounts?kind=search&teams="+sel_teams+"&roles="+sel_roles+"&mail="+mail;
}

</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>