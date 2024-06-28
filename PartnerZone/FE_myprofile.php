<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
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

include("countryCodeReplace.php");

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

$str="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE 1";
$cmd=mysqli_query($link_db,$str);
while($data=mysqli_fetch_row($cmd)){
	$CountryNumber[$data[2]]=$data[4];
	$CountryRegions[$data[2]]=$data[1];
	$CountryName[$data[2]]=$data[3];
}

$str="SELECT ID, CompanyID, Name, CompanyName, CompanyAddress, Title, Email, CountryCode FROM partner_user WHERE ID='".$ID."'";
$cmd=mysqli_query($link_db,$str);
$data=mysqli_fetch_row($cmd);
$companyID=$data[1];
$companyName=$data[3];
$companyAddress=$data[4];
$companyCountryCode=$data[7];
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">


<title>MiTAC Partner Zone - My Profile</title>


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
				<h3 class="content-header-title mb-0 d-inline-block">My Profile</h3>
				<div class="row breadcrumbs-top d-inline-block">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="FEdashboard">Dashboard</a>
							</li>
							<li class="breadcrumb-item active">My Profile
							</li>
						</ol>
					</div>
				</div>
			</div>
			<!--end breadcrumb-->


		</div>
		<div class="content-body">
			<input id="UID" type="hidden" value="<?=$ID?>"> <!-- for self.js -->
			<div class="row">
				<!--Members list-->
				<div class="col-xl-8 col-lg-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">
								<h1 class="card-header "><?=$companyName?> - Members</h1>

								<div class="text-left"><a href="addMembers"  /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add</button></a></div>
								<table class="table table-hover table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Name</th>
											<th>Title</th>
											<th>Email Address</th>
											<th>Tel</th>
											<th>Region</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$str="SELECT ID, CompanyID, Name, CompanyName, CompanyAddress, Title, Email, CountryCode, Tel FROM partner_user WHERE CompanyID='".$companyID."'";
										$cmd=mysqli_query($link_db,$str);
										while($data=mysqli_fetch_row($cmd)){
										?>
										<tr>
											<td><?=$data[2]?></td>
											<td><?=$data[5]?></td>
											<td><?=$data[6]?></td>
											<td><?=$data[8]?></td>
											<td><?=country($data[7])?></td>
											<td>
												<a href="editMembers@<?=$data[0]?>"  /><button type="button" class="btn btn-outline-info btn-sm"><i class="ft-edit-2"></i> Edit</button></a>
												<a href="" data-toggle="modal" data-target="#del-contact" onclick="ass('<?=$data[2]?>','<?=$data[0]?>','delete')"/><button type="button" class="btn btn-outline-info btn-sm" ><i class="ft-trash-2"></i> Delete</button></a>
											</td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<input id="assID" type="hidden" value="">
							</div>
						</div>
					</div>
				</div>
				<!--end Members list-->


				<!--delete member Modal -->
				<div class="modal fade text-left" id="del-contact" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">

								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="#">
								<div id="d_user" class="modal-body">

								</div>

								<div class="modal-footer">
									<input type="submit" class="btn btn-info " value="Yes, Delete it." onclick="DeleteOK()">
									<input type="submit" class="btn btn-light" data-dismiss="modal" aria-label="Close" value="No">
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- end delete member Modal -->












				<!--company info-->
				<div class="col-xl-4 col-lg-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-header">
								<h1 class="card-header ">Company Information</h1>
								<hr>

								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li style="font-size:2rem" title="edit"><a href="" data-toggle="modal" data-target="#edit-company-info" /><i class="ft-edit"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="card-body">
								<table class="table table-borderless" >
									<tr><th>Company Name:</th><td><?=$companyName?></td></tr>
									<tr><th>Company ID:</th><td><?=$companyID?></td></tr>
									<tr><th>Company Address:</th><td><?=$companyAddress?></td></tr>
									<tr><th>Region:</th><td><?=country($companyCountryCode)?></td></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--end company info-->





				<!--edit compoany info Modal -->
				<div class="modal fade text-left" id="edit-company-info" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">

								<label class="modal-title text-text-bold-600" ><h1>Edit Company Information</h1></label>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="#">
								<div class="modal-body">
									<label><span class="info">* </span>Company Name: </label>
									<div class="form-group">
										<input id="edit_Name" type="text" placeholder="" class="form-control" value="<?=$companyName?>" required>
										<div id="err_CNAME" class="alert alert-danger mb-1" role="alert" style="display:none">
											This company is already existed. Please contact with your Tyan sales representative.
										</div>
									</div>

									<label><span class="info">* </span>Company Address: </label>
									<div class="form-group">
										<textarea id="edit_Address" name="maxlength-textarea" class="form-control textarea-maxlength" placeholder="Enter upto 250 characters.." maxlength="250" rows="3" required><?=$companyAddress?></textarea>
									</div>

								</div>

								<div class="modal-footer">
									<input id="editOK" type="button" class="btn btn-info btn-lg" value="Save">
									<input id="edit_ID" type="hidden" value="<?=$companyID?>">
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- end edit compoany info Modal -->
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
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<script src="app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js"></script>
<script src="app-assets/js/scripts/forms/extended/form-maxlength.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script src="app-assets/js/self.js"></script>
<script>
function ass(i, j, k){
  var kind=k;
  if(kind=="delete"){
  	var Uname=i;
  	var DeleteID = j;
  	var content="<i class='ft-trash-2'></i>&nbsp;&nbsp;Are you sure you want to delete "+Uname+"?"
  	document.getElementById("assID").value=DeleteID;
  	document.getElementById("d_user").innerHTML = content;
  }
  if(kind=="sendP"){
  	var mail=i;
  	var UID = j;
  	var content="Are you sure you want to send account info to "+mail+"?"
  	document.getElementById("assmail").value=mail;
  	document.getElementById("assID").value=UID;
  	document.getElementById("sendMail").innerHTML = content;
  }
}
function DeleteOK(i){
  var Delete = document.getElementById("assID").value;
  var kind="delMembers";
  var url = "memberProcess";

  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    Delete : Delete,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      alert("Delete Members Done.");
      location.reload();
    }else{
      alert(message);
    }
  }
  });
}
$("#editOK").click(function(){
	var CompanyID=$("#edit_ID").val();
  var name=$("#edit_Name").val();
  var Address=$("#edit_Address").val();
  var kind="eCompany";
  var url = "memberProcess";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    CompanyID : CompanyID,
    name : name,
    Address : Address,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
      alert("Update Company Done.");
      document.location.href="FEmyprofile";
    }else if(message == "repeat"){
      $("#err_CNAME").show();
      exit;
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