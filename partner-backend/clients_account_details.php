<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
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

if($_GET['CID']!=""){
	$CID=dowith_sql($_GET['CID']);
	$CID=filter_var($CID);
}

// Get Sales Naem
$strSales="SELECT ID, NAME FROM partner_sales WHERE 1";
$cmdSales=mysqli_query($link_db,$strSales);
while ($dataSales=mysqli_fetch_row($cmdSales)) {
	$arr_sales[$dataSales[0]]=$dataSales[1];
}
// Get Sales Naem End
// Get Country Naem
/*$str_countrycode="SELECT Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE 1";
$cmd_countrycode=mysqli_query($link_db,$str_countrycode);
while ($data_countrycode=mysqli_fetch_row($cmd_countrycode)) {
	$country[$data_countrycode[1]]=$data_countrycode[2];
	$Regions[$data_countrycode[1]]=$data_countrycode[0];
	$Number[$data_countrycode[1]]=$data_countrycode[3];
}*/
// Get Country Naem End

// Title Company Name
$str="SELECT distinct CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE CompanyID='".$CID."' ";
$cmd=mysqli_query($link_db,$str);
$result=mysqli_fetch_row($cmd);
// Title Company Name End

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
						<li class="breadcrumb-item"><a href="BEclient_accounts">Client Accounts Management</a>
						</li>
						<li class="breadcrumb-item active">Client Account Details
						</li>
					</ol>
				</div>
			</div>
		</div>

	</div>
	<div class="content-body">
		<div class="row" >
			<!--Members list-->
			<div class="col-12">
				<div class="card no-border box-shadow-1">
					<div class="card-content">
						<div class="card-body">

							<h1 class="card-header "><?=$result[0]?> - Members:</h1>

							<div class="text-left"><a href="AddclientMembers@<?=$result[2]?>"  /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>

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
									$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE CompanyID='".$CID."' ";
									$cmd=mysqli_query($link_db,$str);
									while($result_list=mysqli_fetch_row($cmd)){
									?>
									<tr>
										<td><?=$result_list[4]?></td>
										<td><?=$result_list[6]?></td>
										<td><?=$result_list[5]?></td>
										<td><?=$result_list[8]?></td>
										<td><?=country($result_list[7])?></td>
										<td>
											<a href="EditclientMembers@<?=$result_list[1]?>"  /><button type="button" class="btn btn-outline-info btn-sm"> Edit</button></a>
											<a href="#" data-toggle="modal" data-target="#del-contact" onclick="ass('<?=$result_list[4]?>','<?=$result_list[1]?>','delete')"/><button id="DeleteOK" type="button" class="btn btn-outline-info btn-sm" > Delete</button></a>
											<a href="#" data-toggle="modal" data-target="#send-pwd"  onclick="ass('<?=$result_list[5]?>','<?=$result_list[1]?>','sendP')"/><button type="button" class="btn btn-outline-info btn-sm"><i class="fa fa-envelope-o"></i> Send Password</button></a>
										</td>
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							<input id="assID" type="hidden" value="">
							<input id="assmail" type="hidden" value="">
						</div>
					</div>
				</div>
			</div>
			<!--end Members list-->
		</div>

		<div class="row">
			<!--company info-->
			<div class="col-12">
				<div class="card no-border box-shadow-1">
					<div class="card-content">
						<div class="card-header">
							<h1 class="card-header ">Company Information</h1>
							<input id="companyID" type="hidden" value="<?=$result[2]?>">
							<hr>

							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li style="font-size:2rem" title="edit"><a href="" id="edit_company" data-toggle="modal" data-target="#edit-company-info" /><i class="ft-edit"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="card-body">
							<table class="table table-borderless" >
								<tr><th>Company Name:</th><td><?=$result[0]?></td></tr>
								<tr><th>Company ID:</th><td><?=$result[2]?></td></tr>
								<tr><th>Company Address:</th><td><?=$result[3]?></td></tr>
								<tr><th>Region:</th><td><?=$Regions[$result[7]]?> - <?=$country[$result[7]]?></td></tr>
								<tr><th>Responsible Sales:</th><td><?=$arr_sales[$result[9]]?></td></tr>
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
							<div id="e_c_content" class="modal-body">

							</div>

							<div class="modal-footer">
								<input id="e_companyOK" type="button" class="btn btn-info btn-lg" value="Save">

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


<!--footer-->
<?php
include("footer.php");
?>
<!--end footer-->


<!--delete member Modal -->
<div class="modal fade text-left" id="del-contact" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h1 class="red"><i class="ft-trash-2"></i><h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div id="d_user" class="modal-body">

				</div>

				<div class="modal-footer">
					<input type="button" class="btn btn-info " value="Yes, Delete it." onclick="DeleteOK()">
					<input type="button" class="btn btn-secondary " data-dismiss="modal" aria-label="Close" value="No">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end delete member Modal -->


<!--send password Modal -->
<div class="modal fade text-left" id="send-pwd" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="info"><i class="ft-mail"></i><h1>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="#">
					<div id="sendMail" class="modal-body">


					</div>

					<div class="modal-footer">
						<input id="sendPW" type="button" class="btn btn-info " value="Yes, Send it.">
						<input type="button" class="btn btn-secondary " data-dismiss="modal" aria-label="Close" value="No">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- end send password Modal -->


<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>

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
function ass(i, j, k){
  var kind=k;
  if(kind=="delete"){
  	var Uname=i;
  	var DeleteID = j;
  	var content="Are you sure you want to delete "+Uname+"?"
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
  var url = "clientAccounts";
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

$("#edit_company").click(function(){
  var CompanyID = document.getElementById("companyID").value;
  var kind="editCompany";
  var url = "clientAccounts";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    CompanyID : CompanyID,
    kind : kind
  },
  success: function(message){
    if(message == "success"){

    }else{
      document.getElementById("e_c_content").innerHTML = message;
    }
  }
  });
})

$("#e_companyOK").click(function(){

  var CompanyID = document.getElementById("companyID").value;
  var CName = document.getElementById("edit_CName").value;
  var CAddress = document.getElementById("edit_CAddress").value;
  var CCode = document.getElementById("edit_CCode").value;
  var kind="editCompanyinfo";
  var url = "clientAccounts";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    CompanyID : CompanyID,
    CName : CName,
    CAddress : CAddress,
    CCode : CCode,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
    	alert("Update Company Done.");
    	document.location.href="clientsAccountDetails@"+CompanyID;
    }else{
    	alert(message);
    }
  }
  });
})

$("#sendPW").click(function(){
  var UID = document.getElementById("assID").value;
  var Umail=document.getElementById("assmail").value;
  var kind = "SPW";
  var url = "clientAccounts";
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
    UID : UID,
    Umail : Umail,
    kind : kind
  },
  success: function(message){
    if(message == "success"){
    	alert("Send Password Done.");
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