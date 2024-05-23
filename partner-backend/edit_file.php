<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
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

if($_GET['ID']!=""){
  $fileID=dowith_sql($_GET['ID']);
  $fileID=filter_var($fileID);
}
$strCName="SELECT DISTINCT CompanyID, CompanyName, CountryCode FROM partner_user WHERE 1";
$cdmCName=mysqli_query($link_db,$strCName);
while ($data=mysqli_fetch_row($cdmCName)) {
	$CompanyName[$data[0]]=$data[1];
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>BACKEND - Edit Files - MiTAC Partner Zone</title>


	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
	<link rel="shortcut icon" href="/images/ico/favicon.ico">
	<link rel="manifest" href="images/favicon/site.webmanifest">
	<link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

	<!-- BEGIN VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
	<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">
	<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/icheck.css">
	<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/icheck/custom.css">
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
	<link rel="stylesheet" type="text/css" href="app-assets/css/plugins/forms/checkboxes-radios.css">
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
								<li class="breadcrumb-item"><a href="BE-BEdashboard.html">Dashboard</a>
								</li>
								<li class="breadcrumb-item">Contents Management
								</li>
								<li class="breadcrumb-item"><a href="BEfilesMgt">Files Management</a>
								</li>
								<li class="breadcrumb-item active">Edit a File
								</li>
							</ol>
						</div>
					</div>
				</div>

			</div>
			<div class="content-body">
				<?php
				$str="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.Description, a.FormatSize, a.ImageURL, a.DownloadURL, a.ToWho, a.C_DATE, b.FileType FROM partner_files a INNER JOIN partner_files_type b ON a.FileType=b.ID WHERE a.ID='".$fileID."'";
				$cmd=mysqli_query($link_db,$str);
				$data=mysqli_fetch_row($cmd);
				$statusOn="";
				$statusOff="";
				if($data[3]=="1"){
					$statusOn="selected";
				}else{
					$statusOff="selected";
				}
				$ToAll="";
				$ToWho="";
				if($data[9]=="1"){
					$ToAll="checked";
				}else{
					$ToWho="checked";
				}
				$to_who=explode(",", $data[9]);
				foreach ($to_who as $key => $value) {
					if($value!=""){
						$tmp[$value]=$value;
					}
				}
				?>
				<div class="row ">
					<div class="col-12">
						<div class="card no-border box-shadow-1">
							<div class="card-content">
								<div class="card-body">
									<h1>Edit a File:</h1>
									<hr>
									<form>
										<div class="form-group">
											<label><strong>Name: </strong></label>
											<input id="Name" type="text" placeholder="" class="form-control" value="<?=$data[1];?>" required>
										</div>
										<div class="form-group">
											<label><strong>Please select file type(s): </strong></label>
											<select id="sel_type"  class="select2 form-control block" multiple="multiple" style="width: 100%">
												<?php
												$strType="SELECT ID, FileType FROM partner_files_type WHERE 1";
												$cmdType=mysqli_query($link_db,$strType);
				  							while ($dataType=mysqli_fetch_row($cmdType)) {
				  								if(preg_match("/{$dataType[0]}/i", $data[4])) {
														$sel_Typestatus="selected";
													}else{
														$sel_Typestatus="";
													}
				  								echo "<option value='".$dataType[0]."' ".$sel_Typestatus.">".$dataType[1]."</option>";
				  							}
												?>
											</select>
										</div>
										<div class="form-group">
											<label><strong>Description: </strong></label>
											<textarea id="Des" class="form-control" rows="3" placeholder="(Allow HTML code)"><?=$data[5]?></textarea>
										</div>
										<div class="form-group">
											<label><strong>File Format / Size: </strong></label>
											<input id="Fsize" type="text" placeholder="pdf / 12.56M" class="form-control" value="<?=$data[6]?>">
										</div>
										<div class="form-group">
											<label><strong>File Date: </strong></label>
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<span class="fa fa-calendar-o"></span>
													</span>
												</div>
												<input id="Fdate" type='text' class="form-control pickadate" placeholder="" value="<?=$data[2]?>"/>
											</div>
										</div>
										<div class="form-group">
											<label><strong>Image URL: </strong></label>
											<input id="ImageURL" type="text" placeholder="" class="form-control" value="<?=$data[7]?>">
										</div>
										<div class="form-group">
											<label><strong>Download URL: </strong></label>
											<input id="DownloadURL" type="text" placeholder="" class="form-control" value="<?=$data[8]?>" required>
										</div>
										<div class="form-group">
											<label><strong>Status: </strong></label>
											<select id="status" class=" form-control">
												<option value="1" <?=$statusOn?>>Online</option>
												<option value="0" <?=$statusOff?>>Offline</option>
											</select>
										</div>
										<div class="form-group">
											<label><strong>To: </strong></label>

											<div class="form-check" style="margin-bottom:10px">
												<input id="ToAll" name="2" class="form-check-input" type="radio" value="1" <?=$ToAll?>>
												<label class="form-check-label" for="2">Marketplace</label>
											</div>
											<div class="form-check">
												<input id="ToWho" name="2" class="form-check-input" type="radio" value="" <?=$ToWho?>>
												<label class="form-check-label" for="2">Specific Company's product(s)</label>
											</div>
											<!-- <select id="sel_who" class="select2 form-control block" multiple="multiple" style="width: 100%"> -->
												<select id="sel_who" class="select2 form-control block" multiple="multiple" style="width: 100%">
													<?php
													$strCName="SELECT a.ID, a.CompanyID, a.ModelID, a.SalesID, b.Model, b.SKU FROM partner_myproducts a INNER JOIN partner_model b ON a.ModelID=b.ID";
													echo $strCName;
													$strCName.=" WHERE 1 ORDER BY CompanyID ASC";
													$cdmCName=mysqli_query($link_db,$strCName);
													while ($SEL_CName=mysqli_fetch_row($cdmCName)) {
														$selected="";
														if($SEL_CName[5]!=""){
															if($SEL_CName[0]==$tmp[$SEL_CName[0]]){
															/*$con = explode($SEL_CName[0],$data[9]); 
															if(count($con)>1){*/
																$selected="selected";
															}else{
																$selected="";
															}
															$value=$CompanyName[$SEL_CName[1]]."-".$SEL_CName[5];
															echo "<option  value='".$SEL_CName[0]."' ".$selected.">".$value."</option>";
														}
													}
													?>	
											</select>
											<br />
										</div>



										<br />
										<button id="EditFile" type="button" class="btn btn-info mr-1 mb-1"><i class="ft-save"></i> SAVE </button></a>
										<a href="BEfilesMgt"  /><button type="button" class="btn btn-light mr-1 mb-1"><i class="ft-chevrons-left"></i> BACK </button></a>
										<input id="FileID" type="hidden" value="<?=$fileID?>">
								</div>
							</div>
						</div>
					</div>


				</div>

			</div>
		</div>
	</div>
	<!-- ////////////////////////////////////////////////////////////////////////////-->


	<footer class="footer footer-static footer-dark navbar-border">
		<p class="clearfix  lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright&copy; 2004-2021 MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. All Rights Reserved. Please use the latest version of Firefox or Chrome to view this site.</span></p>
	</footer>






<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="app-assets/vendors/js/forms/icheck/icheck.min.js"></script>


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
<script src="app-assets/js/scripts/forms/checkbox-radio.js"></script>
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

$("#EditFile").click(function(){
	var FileID = document.getElementById("FileID").value;
	var Name = document.getElementById("Name").value;
	var sel_type = "";
	selector1 = document.getElementById("sel_type");
  	for (var i = 0; i < selector1.options.length; i++ ) { 
  		if (selector1.options[i].selected) { 
  			if(sel_type==""){
  				sel_type += selector1.options[i].value; 
  			}else{
  				sel_type += "/"; 
  				sel_type += selector1.options[i].value; 
  			}
  		} 
  	} 

	var Des = document.getElementById("Des").value;
	var Fsize = document.getElementById("Fsize").value;
	var date=document.getElementById("Fdate").value;
	Fdate = new Date(date).format("yyyy-MM-dd");

	var ImageURL = document.getElementById("ImageURL").value;
	var DownloadURL = document.getElementById("DownloadURL").value;
	var status = document.getElementById("status").value;

	var ToWho ="";
	if(document.getElementById("ToAll").checked==true) {
    ToWho = document.getElementById("ToAll").value
  }else if(document.getElementById("ToWho").checked==true) {
    selector = document.getElementById("sel_who");
  	for (var i = 0; i < selector.options.length; i++ ) { 
  		if (selector.options[i].selected) { 
  			if(ToWho==""){
  				ToWho += selector.options[i].value; 
  				ToWho += ","; 
  			}else{
  				ToWho += selector.options[i].value; 
  				ToWho += ","; 
  			}
  		} 
  	} 
  }
	var kind="editFile";
	var url = "filesProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	FileID : FileID,
  	Name : Name,
  	sel_type : sel_type,
  	Des : Des,
  	Fsize : Fsize,  
  	Fdate : Fdate,
  	ImageURL : ImageURL,
  	DownloadURL : DownloadURL,
  	status : status,
  	ToWho : ToWho,
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Edit File Done.");
  		document.location.href="BEfilesMgt";
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