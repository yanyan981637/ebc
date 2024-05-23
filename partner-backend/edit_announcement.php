<?php
header("X-Frame-Options: DENY");
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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_GET['ID']!=""){
	$edidID=dowith_sql($_GET['ID']);
	$edidID=filter_var($edidID);
}

$str_ann="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE ID='".$edidID."'";
$cmd_ann=mysqli_query($link_db,$str_ann);
$data_ann=mysqli_fetch_row($cmd_ann);
$tmp_who=preg_replace('/\s(?=)/', '', $data_ann[2]); //移除空白
$release=explode("/", $tmp_who);
foreach ($release as $key => $value) {
	if($value!=""){
		$tmp[$value]=$value;
	}
}

if($data_ann[2]=="All"){ //ReleaseTo
	$checkall="checked";
}else{
	$checkto="checked";
}

if($data_ann[3]=="0000-00-00 00:00:00"){ //Schedule
	$checkNow="checked";
}else{
	$checkSch="checked";
	$date=explode(" ", $data_ann[3]);
	$SchDate=$date[0];
	$SchTime=$date[1];
}

if($data_ann[5]=="1"){
	$statusOn="selected";
}else{
	$statusOff="selected";
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>BACKEND - Edit Announcement - Contents Management - MiTAC Partner Zone</title>
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
	<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark navbar-shadow">
		<div class="navbar-wrapper">
			<div class="navbar-header">
				<ul class="nav navbar-nav flex-row">
					<li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>

					<li class="nav-item"><a class="navbar-brand" href="#"><img class="brand-logo" alt="" src="app-assets/images/logo/logo-light-sm.png"><h3 class="brand-text">MiTAC Partner Zone</h3></a></li>


					<li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
				</ul>
			</div>
			<div class="navbar-container content">
				<div class="collapse navbar-collapse" id="navbar-mobile">
					<ul class="nav navbar-nav mr-auto float-left">
						<li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
					</ul>
					<ul class="nav navbar-nav float-right">



						<!--user-->
						<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar "><img src="app-assets/images/user.png" ><i></i></span><span class="user-name">username</span></a>
							<div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-lock"></i> Change Password</a>
								<div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="ft-log-out"></i> Logout</a>
							</div>
						</li>
						<!--end user-->			  
					</ul>
				</div>
			</div>
		</div>
	</nav>

	<!-- ////////////////////////////////////////////////////////////////////////////-->

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
								<li class="breadcrumb-item"><a href="BEcontents">Announcements</a>
								</li>
								<li class="breadcrumb-item active">Edit Announcement
								</li>
							</ol>
						</div>
					</div>
				</div>

			</div>
			<div class="content-body">
				<div class="row ">
					<div class="col-xl-12 col-lg-12">
						<div class="card no-border box-shadow-1">
							<div class="card-content">
								<div class="card-body">

									<h1>Edit an Announcement</h1>
									<hr>

									<div class="form-group">
										<label><strong>Title:</strong> </label>
										<input id="title" type="text" placeholder="" class="form-control" value="<?=$data_ann[1]?>" required>
									</div>
									<div class="form-group" style="background:#eee; padding:10px 20px">
										<label><strong>Release to:</strong> </label>
										<div class="form-check" style="margin-bottom:10px">
											<input id="releaseAll" name="1" class="form-check-input" type="radio" value="All" <?=$checkall;?>>
											<label class="form-check-label" for="1">All</label>
										</div>
										<div class="form-check">
											<input id="releaseTO" name="1" class="form-check-input" type="radio" value="" <?=$checkto?>>
											Please select:
											<select id="sel_release" class="select2 form-control block" multiple="multiple" style="width: 50%">
											<?php
											$str="SELECT ID, Name, CompanyName FROM partner_user WHERE 1 GROUP BY CompanyName";
											$cmd=mysqli_query($link_db,$str);
											while ($data=mysqli_fetch_row($cmd)) {
												$CompanyName=preg_replace('/\s(?=)/', '', $data[2]); //移除空白
												if($tmp[$CompanyName]==$CompanyName){
															$sel_schstatus="selected";
														}else{
															$sel_schstatus="";
															
														}
												/*if(preg_match("/{$data[2]}/i", $data_ann[2])) {
													$sel_schstatus="selected";
												}else{
													$sel_schstatus="";
												}*/

												echo "<option value='".$data[2]."' ".$sel_schstatus.">".$data[2]."</option>";
											}
											?>
											</select>	
										</div>
									</div>	
									<div class="form-group" style="background:#eee; padding:10px 20px">
										<label><strong>Release Schedule:</strong></label>

										<div class="form-check" style="margin-bottom:10px">
											<input id="ReleaseNow" name="Schedule" class="form-check-input" type="radio"value="0000-00-00 00:00:00" <?=$checkNow?>>
											<label class="form-check-label" for="2">Release Now</label>
										</div>
										<div class="form-check">
											<input id="radioSchedule" name="Schedule" class="form-check-input" type="radio" value="" <?=$checkSch?>>
											<label class="form-check-label" for="2">Create a schedule</label>
										</div>


										<div class="row">
											<div class="col-6">
												<label>Pick a date:</label>
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<span class="fa fa-calendar-o"></span>
														</span>
													</div>
													<input id="scheduleDate" type='text' class="form-control pickadate" placeholder="" value="<?=$SchDate?>" />
												</div>
											</div>
											<div class="col-6">
												<div class="form-group">
													<label>Enter a Time</label>
													<div class="input-group">
														<input id="scheduleTime" type="text" placeholder="24:02:09" class="form-control" value="<?=$SchTime?>">
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label><strong>Message:</strong> </label>
										<textarea id="message" class="form-control" rows="3" placeholder="(Allow HTML code)"><?=$data_ann[4]?></textarea>
									</div>
									<div class="form-group">
										<label><strong>Status: </strong></label>
										<select id="sel_status" class=" form-control">
											<option value="1" <?=$statusOn?>>Online</option>
											<option value="0" <?=$statusOff?>>Offline</option>
										</select>
									</div>
									<br />
									<br />
									<div class="text-left">
										<button id="EditOK" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> Save</button>
										<a href="BEcontents"  /><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> BACK </button></a>
										<input id="editID" type="hidden" value="<?=$edidID?>"
									</div>
								</div>
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


<!-- BEGIN VENDOR JS-->
<script src="app-assets/js/core/libraries/jquery.min.js"></script>
<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>

<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>

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

Date.prototype.format = function(fmt) { 
var o = { 
  "M+" : this.getMonth()+1,                 //月份 
  "d+" : this.getDate(),                    //日 
  "h+" : this.getHours(),                   //小時
  "m+" : this.getMinutes(),                 //分 
  "s+" : this.getSeconds(),                 //秒 
  "q+" : Math.floor((this.getMonth()+3)/3), //季
  "S"  : this.getMilliseconds()             //毫秒 
}; 
  if(/(y+)/.test(fmt)) {
  	fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
  }
  for(var k in o) {
  	if(new RegExp("("+ k +")").test(fmt)){
  		fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
  	}
  }
  return fmt; 
}     

$("#EditOK").click(function(){

	var editID = document.getElementById("editID").value;
	var title = document.getElementById("title").value;
	var release="";
	if (document.getElementById("releaseAll").checked==true) {
    release =document.getElementById("releaseAll").value; 
  }else if(document.getElementById("releaseTO").checked==true){

  	selector = document.getElementById("sel_release");
  	for (var i = 0; i < selector.options.length; i++ ) { 
  		if (selector.options[i].selected) { 
  			if(release==""){
  				release += selector.options[i].value; 
  			}else{
  				release += "/"; 
  				release += selector.options[i].value; 
  			}
  		} 
  	} 
  }
  var schedule="";
  if (document.getElementById("ReleaseNow").checked==true) {
    schedule =document.getElementById("ReleaseNow").value; 
  }else if(document.getElementById("radioSchedule").checked==true){
  	date=document.getElementById("scheduleDate").value;
  	time=document.getElementById("scheduleTime").value;
  	if(time==""){
  		alert("Please Enter a Time");
  		exit;
  	}
  	schedule = new Date(date).format("yyyy-MM-dd");
  	schedule = schedule+" "+time;
  }

	var message = document.getElementById("message").value;
	var sel_status = document.getElementById("sel_status").value;
	var kind="editAnn";
	var url = "AnnProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	editID : editID,  
  	title : title,  
  	release : release,  
  	schedule : schedule,  
  	message : message,
  	sel_status : sel_status,
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Edit Done.");
  		document.location.href="BEcontents";
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