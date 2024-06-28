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

$Role=$_SESSION['role'];
if($Role=="SA"){
	echo "<script language='javascript'>self.location='BEdashboard'</script>";
}

$Type="SELECT ID, FileType FROM partner_files_type WHERE 1";
$cmdType1=mysqli_query($link_db,$Type);
while ($dataType1=mysqli_fetch_row($cmdType1)) {
	$typ_arr[$dataType1[0]]=$dataType1[1];
}

$switch="";
if($_GET['kind']!=""){
  $kind=dowith_sql($_GET['kind']);
  $kind=filter_var($kind);
}
if($_GET['type']!=""){
  $type=dowith_sql($_GET['type']);
  $type=filter_var($type);
  $switch.="A";
}
if($_GET['file']!=""){
  $file=dowith_sql($_GET['file']);
  $file=filter_var($file);
  $switch.="B";
}

if($kind=="search"){
  $url="kind=search&type="+$type+"&file=".$file."&";
  switch ($switch) {
    case 'A':
      $str_count="SELECT COUNT(*) FROM partner_files WHERE FileType LIKE '%".$type."%'";
      break;
    case 'AB':
      $str_count="SELECT COUNT(*) FROM partner_files WHERE FileType LIKE '%".$type."%' AND Name='".$file."'";
			break;
    case 'B':
      $str_count="SELECT COUNT(*) FROM partner_files WHERE Name='".$file."'";
			break;
    default:
      $str_count="SELECT COUNT(*) FROM partner_files WHERE 1";
      break;
  }
}else{
  $str_count="SELECT COUNT(*) FROM partner_files WHERE 1";
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
	<title>BACKEND - Files Management - MiTAC Partner Zone</title>


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
							<li class="breadcrumb-item active"> Files Management
							</li>
						</ol>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">



			<div class="row">
				<div class="col-xl-8 col-lg-12">
					<div class="card no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">




								<h1>Files Management</h1>
								<hr>
								<!--search & sorting-->
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<select id="searchType" class="form-control" >
												<option value="" selected>All Types</option>
												<?php
												foreach ($typ_arr as $key => $value) {
													echo "<option  value='".$key."'>".$value."</option>";
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input id="searchFile" type="text" class="form-control" placeholder="File Name">
										</div>
									</div>
									<div class="col-md-7">
										<button id="SearchOK" type="button" class="btn btn-info mr-1 mb-1">Search</button>
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
															<li class="page-item"><a href="?<?=$url?>page=1" class="page-link">1</a></li>
															<li class="page-item"><a href="" class="page-link">...</a></li>
															<?php
														}
														if($i>=$first && $i<=$last){
															if ($page==$i) {
																?>
																<li class="page-item active"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
																<?php
															}else{
																?>
																<li class="page-item"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
																<?php
															}
														}
														if($i==$pages_totle && $last<$pages_totle){
															?>
															<li class="page-item"><a href="" class="page-link">...</a></li>
															<li class="page-item"><a href="?<?=$url?>page=<?=$i?>" class="page-link"><?=$i?></a></li>
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

								<div class="text-left"><a href="addFile"  /><button type="button" class="btn btn-info mr-1 mb-1"><i class="ft-plus"></i> Add </button></a></div>


								<!--file list table-->

								<table class="table table-hover table-responsive">
									<thead class="bg-grey bg-lighten-4">
										<tr>
											<th>Date Created</th>
											<th>File Name</th>
											<th>File Date</th>
											<th>Status</th>
											<th>Type</th>
											<th>To</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($kind=="search"){
										  $url="kind=search&type="+$type+"&file=".$file."&";
										  switch ($switch) {
										    case 'A':
													$str="SELECT ID, Name, FileDate, Status, FileType, ToWho, C_DATE FROM partner_files WHERE FileType LIKE '%".$type."%' ORDER BY C_DATE DESC LIMIT $start, $per";
										      break;
										    case 'AB':
													$str="SELECT ID, Name, FileDate, Status, FileType, ToWho, C_DATE FROM partner_files WHERE FileType LIKE '%".$type."%' AND Name='".$file."' ORDER BY C_DATE DESC LIMIT $start, $per";
													break;
										    case 'B':
													$str="SELECT ID, Name, FileDate, Status, FileType, ToWho, C_DATE FROM partner_files WHERE Name='".$file."' ORDER BY C_DATE, U_DATE DESC LIMIT $start, $per";
													break;
										    default:
													$str="SELECT ID, Name, FileDate, Status, FileType, ToWho, C_DATE FROM partner_files WHERE 1 ORDER BY C_DATE DESC LIMIT $start, $per";
										      break;
										  }
										}else{
											$str="SELECT ID, Name, FileDate, Status, FileType, ToWho, C_DATE FROM partner_files WHERE 1 ORDER BY C_DATE DESC LIMIT $start, $per";
										}
										$cmd=mysqli_query($link_db,$str);
										while ($data=mysqli_fetch_row($cmd)) {
											$ToWho="";
											$typetmp=explode(" / ", $data[4]);
											$typeName="";
											foreach ($typetmp as $key => $value) {
												if($typeName==""){
													$typeName.=$typ_arr[$value];
												}else{
													$typeName.=" / ";
													$typeName.=$typ_arr[$value];
												}
											}
											if($data[3]=="1"){
												$status="Online";
											}else{
												$status="Offline";
											}

											if($data[5]=="1"){
												$ToWho="Marketplace";
											}else{
												//$strCName="SELECT DISTINCT a.CompanyID, a.CompanyName, a.CountryCode, b.SKU FROM partner_user a INNER JOIN partner_myproducts b ON a.CompanyID=b.CompanyID WHERE b.ID='".$data[5]."'";
												$strCName="SELECT a.CompanyID, a.CompanyName, a.CountryCode, b.SKU FROM partner_user a INNER JOIN partner_myproducts b ON a.CompanyID=b.CompanyID WHERE FIND_IN_SET(b.ID, '".$data[5]."') GROUP BY a.CompanyID";
												$cdmCName=mysqli_query($link_db,$strCName);
												while($CName=mysqli_fetch_row($cdmCName)) {
													$ToWho.=$CName[1]."-".$CName[3]." / ";
												}
											}

										?>
										<tr>
											<td><?=$data[6];?></td>
											<td><?=$data[1];?></td>
											<td><?=$data[2];?></td>
											<td><?=$status;?></td>
											<td><?=$typeName;?></td>
											<td><p class="JQellipsis"><?=$ToWho;?></P></td>
											<td>
												<a href="editFile@<?=$data[0];?>"  /><button type="button" class="btn btn-outline-info btn-sm mr-b-1">Edit</button></a>
												<a href="" data-toggle="modal" data-target="#del-file" style=""><button type="button" class="btn btn-outline-info btn-sm mr-b-1"  onclick="editToID('<?=$data[0]?>','DFile', '')">Delete</button></a>
												<input id="delcompany_<?=$data[0]?>" type="hidden" value="<?=$data[1]?>">
											</td>
										</tr>
										<?php
										}
										?>

									</tbody>
								</table>
								<input id="EditFileID" type="hidden" value="">
								<!--end file list table-->

							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-4 col-lg-12">
					<div class="card  no-border box-shadow-1">
						<div class="card-content">
							<div class="card-body">
								<h1>File Types</h1>
								<hr>
								<a href="" data-toggle="modal" data-target="#add-tag" /><div class="badge badge-pill badge-secondary mr-b-2"><h4><i class="ft-plus"></i> ADD</h4></div></a>
								<?php
								/*$strType="SELECT ID, FileType FROM partner_files_type WHERE 1";
								$cmdType=mysqli_query($link_db,$strType);
  							while ($dataType=mysqli_fetch_row($cmdType)) {*/
  							foreach ($typ_arr as $key => $value) {
  								$str_Tcount="SELECT COUNT(*) FROM partner_files WHERE FileType LIKE '%".$key."%'";
  								$cmd__Tcount =mysqli_query($link_db,$str_Tcount);
									list($public_count) = mysqli_fetch_row($cmd__Tcount);
									if($public_count==0){
										$view="";
									}else{
										$view="display:none";
									}
  							?>
  							<div class="badge badge-pill badge-primary mr-b-2">
  								<h5 class="m-5-p-5">
  									<a href="" data-toggle="modal" data-target="#edit-tag" onclick="editToID(<?=$key;?>, 'Type')"/><?=$value?> (<?=$public_count?>)</a> &nbsp;&nbsp;&nbsp;&nbsp;
  									<a href="" data-toggle="modal" data-target="#del-tag" style="<?=$view?>" onclick="editToID(<?=$key;?>, 'Delete', '<?=$value?>')"/><i class="ft-x"></i></a>
  								</h5>
  							</div>
  							<?php
  							}
								?>
								<input id="Edit_TypeID" type="hidden" value="">
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




<!--add a tag Modal -->
<div class="modal fade text-left" id="add-tag" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1>Add a type:</h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#">
				<div class="modal-body">
					<div class="form-group">
						<label>Type: </label>
						<input id="add_type" type="text" placeholder="" size="100" class="form-control">
						<div id="err_atype" class="alert alert-danger mb-1" role="alert" style="display:none">Repeated Type.</div>
					</div>

				</div>
				<div class="modal-footer">
					<input id="TypeOK" type="button" class="btn btn-info btn-lg" value="Create">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- end add a tag Modal -->


<!--edit a tag Modal -->
<div class="modal fade text-left" id="edit-tag" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-text-bold-600" ><h1>Edit the type:</h1></label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Type: </label>
						<input id="edit_type" type="text" placeholder="" class="form-control" value="[type name]">
						<div id="err_etype" class="alert alert-danger mb-1" role="alert" style="display:none">Repeated Type.</div>
					</div>

				</div>
				<div class="modal-footer">
					<input id="EditOK" type="button" class="btn btn-info btn-lg" value="Save">
				</div>
		</div>
	</div>
</div>

<!--end edit a tag Modal -->







<!--delete file Modal -->
<div class="modal fade text-left" id="del-file" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="red"><i class="ft-trash-2"></i><h1>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form>
				<div class="modal-body" id="D_file">

				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-info " value="Yes, Delete it." onclick="deleteFT('File');">
					<input type="button" class="btn btn-secondary " data-dismiss="modal" aria-label="Close" value="No">
				</div>
		</div>
	</div>
</div>

	<!-- end delete file Modal -->


	<!--delete tag Modal -->
	<div class="modal fade text-left" id="del-tag" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="red"><i class="ft-trash-2"></i><h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
						<div class="modal-body" id="tagName">

						</div>

						<div class="modal-footer">
							<input type="button" class="btn btn-info " value="Yes, Delete it." onclick="deleteFT('Type');">
							<input type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" value="No">
						</div>
				</div>
			</div>
		</div>

		<!-- end delete tag Modal -->










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
<!-- END PAGE LEVEL JS-->

<script type="text/javascript">
$("#TypeOK").click(function(){
	var addType = document.getElementById("add_type").value;
	var kind="addType";
	var url = "filesProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	addType : addType,
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Add Type Done.");
  		document.location.href="BEfilesMgt";
  	}else if(message == "repeated"){
  		$("#err_atype").show();
  	}else{
  		alert(message);
  	}
  }
	});
})

$("#EditOK").click(function(){
	var edit_type = document.getElementById("edit_type").value;
	var Edit_TypeID = document.getElementById("Edit_TypeID").value;
	var kind="editType";
	var url = "filesProcess";
	$.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: {
  	edit_type : edit_type,
  	Edit_TypeID : Edit_TypeID,
  	kind : kind
  },
  success: function(message){
  	if(message == "success"){
  		alert("Edit Type Done.");
  		document.location.href="BEfilesMgt";
  	}else if(message == "repeated"){
  		$("#err_etype").show();
  	}else{
  		alert(message);
  	}
  }
	});
})

$("#SearchOK").click(function(){
	var searchType = document.getElementById("searchType").value;
	var searchFile = document.getElementById("searchFile").value;
	document.location.href="?kind=search&type="+searchType+"&file="+searchFile;
})

function editToID(i,j,k){
	var kind=j;
	if(kind=="Type"){
		var EditTypeID=i;
		var kind="editToValue";
		var url = "filesProcess";
		$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	EditTypeID : EditTypeID,
      kind : kind
    },
	    success: function(message){
	    	if(message == "success"){

	    	}else{
	    		document.getElementById("edit_type").value=message;
	    		document.getElementById("Edit_TypeID").value=EditTypeID;
	    	}
			}
		});
	}else if(kind=="Delete"){
		var EditTypeID=i;
		var tag=k;
		var tmp="Are you sure you want to delete "+tag+"?";
		document.getElementById("Edit_TypeID").value=EditTypeID;
		document.getElementById("tagName").innerHTML="";
		$("#tagName").append(tmp);

	}else if(kind=="DFile"){
		var Edit_FileID=i;
		var tmp="delcompany_"+Edit_FileID;
		var File=document.getElementById(tmp).value;
		var tmp="Are you sure you want to delete this file -<br /> "+File+"?";
		document.getElementById("EditFileID").value=Edit_FileID;
		document.getElementById("D_file").innerHTML="";
		$("#D_file").append(tmp);
	}
}

function deleteFT(i){
	var kind=i;
	if(kind=="File"){
		var FileID=document.getElementById("EditFileID").value;
		var kind="DeleteFile";
		var url = "filesProcess";
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
	    		alert("Delete File Done.");
	    		location.reload();
	    	}else{
	    		alert(message);
	    	}
			}
		});
	}else if(kind=="Type"){
		var TypeID=document.getElementById("Edit_TypeID").value;
		var kind="DeleteType";
		var url = "filesProcess";
		$.ajax({
    type: "post",
    url: url,
    dataType: "html",
    data: {
    	TypeID : TypeID,
      kind : kind
    },
	    success: function(message){
	    	if(message == "success"){
	    		alert("Delete Type Done.");
	    		location.reload();
	    	}else{
	    		alert(message);
	    	}
			}
		});

	}
}

$(function(){
    var len = 50; // 超過50個字以"..."取代
    $(".JQellipsis").each(function(i){
        if($(this).text().length>len){
            $(this).attr("title",$(this).text());
            var text=$(this).text().substring(0,len-1)+"...";
            $(this).text(text);
        }
    });
});
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>