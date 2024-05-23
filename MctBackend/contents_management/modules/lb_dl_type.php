<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

$d_cate01="";$d_num01="";$d_id01="";
if(isset($_REQUEST['act'])!=''){
if($_REQUEST['act']=='del'){
 $d_cate01=trim($_REQUEST['d_cate']);
 $d_num01=trim($_REQUEST['d_num']);
 //$d_id01=$_REQUEST['d_id'];
 if($d_num01!=''){
   $str_del="delete from `c_all_selectlist` where `CATEGORY`='".$d_cate01."' and `LISTVALUE`='".$d_num01."'";
   $del_cmd=mysqli_query($link_db,$str_del);
   echo "<script>alert('Delete the Data !');self.location='lb_dl_type.php'</script>";
   exit();
 }
}
}

$str1="select count(`LISTVALUE`) from `c_all_selectlist` where `CATEGORY`='OS'";
$cmd1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($cmd1);

$str11="select count(`LISTVALUE`) from `c_all_selectlist` where `CATEGORY`<>'OS'";
$cmd11=mysqli_query($link_db,$str11);
list($public_Maincount)=mysqli_fetch_row($cmd11);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Download Type</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />
<style type="text/css"></style>
<script type="text/javascript" src="../../jquery.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>-->
<script language="JavaScript">
function MM_main(selobj){
    window.open(document.getElementById('DoLoMa_page').options[document.getElementById('DoLoMa_page').selectedIndex].value+"#Dolo_pannel","_self");
}
function MM_o(selObj){
    window.open(document.getElementById('DoLoOS_page').options[document.getElementById('DoLoOS_page').selectedIndex].value+"#os_pannel","_self");
}

function show_AddDTVal(){
$("#MValue_DTADD01").show();
$("#MValue_DTMOD01").hide();
}
function show_DLModVal(id){
  self.location='lb_dl_type.php?aid='+id+' #Dolo_pannel';
}
function show_DLModVal01(){
$("#MValue_DTADD01").hide();
$("#MValue_DTMOD01").show();
}

function show_AddOSVal(){
$("#MValue_OSADD01").show();
$("#MValue_OSMOD01").hide();
}
function show_OSModVal(id){
  self.location='lb_dl_type.php?mid='+id+' #os_pannel';
}
function show_OSModVal01(){
$("#MValue_OSADD01").hide();
$("#MValue_OSMOD01").show();
}
</script>
<script type="text/javascript">
$(function() {
$("#MVaBtnDT").click(function() {  
  var form = $('#form1');
  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form1').serialize();
  //var params = $('input').serialize();
  var url = "add_DoLoDT.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: formdata ? formdata : form.serialize(),
  cache: false,
  contentType: false,
  processData: false,
  
  success: function(data){
    if(data == "refresh"){	
    window.location.reload(true);
    }
    else{
    $("#MValDT_MGT").html(data);
	$("#MValDT_error").html('');
    }
  }
  });
});

$("#MVaBtnDTm").click(function() {  
  var form = $('#form1');
  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form1').serialize();
  //var params = $('input').serialize();
  var url = "mod_DoLoDT.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: formdata ? formdata : form.serialize(),
  cache: false,
  contentType: false,
  processData: false,  
  
  success: function(data){
    if(data == "refresh"){	
    //window.location.reload(true);
	self.location='lb_dl_type.php';
    }
    else{
    $("#MValDTm_MGT").html(data);
	$("#MValDTm_error").html('');
    }
  }  
  });  
});

$("#MVaCelDT").click(function(){
$("#MValue_DTADD01").hide();
$("#MV_strDT01").val("");
$("#MV_strDT02").val("");
$("#MV_strDT03").val("");
$("#MV_strDT04").val("");
$("#MValDT_MGT").html('');
$("#MValDT_error").html('');
});

$("#MVaCelDTm").click(function(){
$("#MValue_DTMOD01").hide();
$("#MVm_strDT01").val("");
$("#MVm_strDT02").val("");
$("#MVm_strDT03").val("");
$("#MValDTm_MGT").html('');
$("#MValDTm_error").html('');
});

$("#MVaBtnOS").click(function() {  
  var params = $('input').serialize();
  var url = "add_DoLoOS.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(data){
    if(data == "refresh"){	
    //window.location.reload(true);
	self.location='lb_dl_type.php';
    }
    else{
    $("#MValOS_MGT").html(data);
	$("#MValOS_error").html('');
    }
  }
  });
});

$("#MVaBtnOSm").click(function() {  
  var params = $('input').serialize();
  var url = "mod_DoLoOS.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(data){
    if(data == "refresh"){	
    //window.location.reload(true);
	self.location='lb_dl_type.php';
    }
    else{
    $("#MValOSm_MGT").html(data);
	$("#MValOSm_error").html('');
    }
  }  
  });  
});


$("#MVaCelOS").click(function(){
$("#MValue_OSADD01").hide();
$("#MV_strOS01").val("");
$("#MValOS_MGT").html('');
$("#MValOS_error").html('');
});

$("#MVaCelOSm").click(function(){
$("#MValue_OSMOD01").hide();
$("#MVm_strOS01").val("");
$("#MValOSm_MGT").html('');
$("#MValOSm_error").html('');
});

});
</script>
</head>
<body style="backbround:#f9f9f9">
<h2>Edit / Add Download Type:</h2><p class="clear"></p>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_Maincount;?></span> records </div>
<p class="clear"></p>
<div id="Dolo_pannel">
<form id="form1" name="form1" method="post" action="lb_dl_type.php">
<table class="list_table">
  <tr>
    <th>abbreviate</th><th>Name</th><th>Introduction</th><th>Subcategory</th><th>OS</th><th><div class="button14" style="width:50px;" onClick="show_AddDTVal();">Add</div></th>
  </tr>
<!--add a download Type-->
  <!--<tr>
    <td><input name="" type="text" size="20" value=""  /></td><td><input name="" type="text" size="20" value=""  /></td><td ><textarea  name="" rows="1" cols="50" style="max-width: 100px; max-height: 20px;"></textarea></td>
	<td style="width:120px"><input type="checkbox" name="" value="subcategory" checked > Yes&nbsp;&nbsp;<img src="../../images/icon_edit.png" alt="Edit" />
	</td>
	<td style="width:120px"><input type="checkbox" name="" value="OS" checked > Yes&nbsp;&nbsp;<img src="../../images/icon_edit.png" alt="Edit" />
	</td>
	<td style="width:150px"><input name="" type="button" value="Done" /><input name="" type="button" value="Cancel" /></td>
  </tr>-->

<tr>
<td colspan="6">
<DIV id="MValue_DTADD01" style="display:none"><input style="vertical-align:top" id="MV_strDT01" name="MV_strDT01" type="text" size="20" value="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="vertical-align:top" id="MV_strDT02" name="MV_strDT02" type="text" size="20" value="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id="MV_strDT03" name="MV_strDT03" rows="5" cols="50" style="max-width: 100px; max-height: 100px;"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select style="vertical-align:top" id="MV_strDT04" name="MV_strDT04">
<?php
$str_cate01="SELECT distinct `CATEGORY` FROM `c_all_selectlist` where `CATEGORY`<>'OS' order by `CATEGORY` limit 2";
$cate01_result=mysqli_query($link_db,$str_cate01);
while($cate01_data=mysqli_fetch_row($cate01_result)){
?>
<option value="<?=$cate01_data[0];?>"><?=$cate01_data[0];?></option>
<?php
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;<input style="vertical-align:top" id="MVaBtnDT" type="button" value="Done" />&nbsp;&nbsp;<input style="vertical-align:top" id="MVaCelDT" type="button" value="Cancel" /><DIV id="MValDT_MGT"></DIV><DIV id="MValDT_error"></DIV></div>
<?php
if(isset($_REQUEST['aid'])!=''){
$aid01=trim($_REQUEST['aid']);
$str_MVm="SELECT `LISTVALUE`, `LISTNAME`, `DESCRIPTION`, `CATEGORY` FROM `c_all_selectlist` where `CATEGORY`<>'OS' and `LISTVALUE`='".$aid01."'";
$MVm_cmd=mysqli_query($link_db,$str_MVm);
$MVm_data=mysqli_fetch_row($MVm_cmd);
?>
<DIV id="MValue_DTMOD01" style="display:none"><input id="MValue_Dnum" name="MValue_Dnum" type="hidden" value="<?=intval($_REQUEST['aid']);?>"><input style="vertical-align:top" id="MVm_strDT01" name="MVm_strDT01" type="text" size="20" value="<?=$MVm_data[0];?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input style="vertical-align:top" id="MVm_strDT02" name="MVm_strDT02" type="text" size="20" value="<?=$MVm_data[1];?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id="MVm_strDT03" name="MVm_strDT03" rows="5" cols="50" style="max-width: 100px; max-height: 100px;"><?=$MVm_data[2];?></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select style="vertical-align:top" id="MVm_strDT04" name="MVm_strDT04">
<?php
$str_cate01m="SELECT distinct `CATEGORY` FROM `c_all_selectlist` where `CATEGORY`<>'OS' order by `CATEGORY` limit 2";
$cate01m_result=mysqli_query($link_db,$str_cate01m);
while($cate01m_data=mysqli_fetch_row($cate01m_result)){
?>
<option value="<?=$cate01m_data[0];?>" <?php if($MVm_data[3]==$cate01m_data[0]){ echo "selected"; } ?>><?=$cate01m_data[0];?></option>
<?php
}
?>
</select>
<input style="vertical-align:top" id="MVaBtnDTm" type="button" value="Done" />&nbsp;&nbsp;<input style="vertical-align:top" id="MVaCelDTm" type="button" value="Cancel" /><DIV id="MValDTm_MGT"></DIV><DIV id="MValDTm_error"></DIV></div>
<?php
}
?>
</td>
</tr> 
<!--end add a download Type-->
<?php
if(isset($_REQUEST['page'])!=""){
$page=intval($_REQUEST['page']);
}else{
$page="1";
}
      
if(empty($page))$page="1";

$mainval="";
$str_chksub="SELECT distinct `CATEGORY` FROM `c_all_selectlist` where `CATEGORY`<>'OS'";
$chksub_result=mysqli_query($link_db,$str_chksub);
while($chksub_data=mysqli_fetch_row($chksub_result)){
$mainval=$mainval.$chksub_data[0].",";
}
$read_Main_num="20";
$start_Main_num=$read_Main_num*($page-1);
$str_DLm1="SELECT `LISTVALUE`, `LISTNAME`, `DESCRIPTION`, `CATEGORY` FROM `c_all_selectlist` where `CATEGORY`<>'OS' order by `LISTNAME` limit $start_Main_num,$read_Main_num;";
$DLm1_result=mysqli_query($link_db,$str_DLm1);
while($DLm1_data=mysqli_fetch_row($DLm1_result)){
?>
  <tr>
    <td><?=$DLm1_data[0];?></td><td><?=$DLm1_data[1];?></td>
	<td>
	<?php
	if(strlen($DLm1_data[2])>60){
	echo substr(htmlspecialchars($DLm1_data[2]),0,60)."...";
	}else{
	echo htmlspecialchars($DLm1_data[2]);
	}
	?></td>
	<td>
	<?php
	 if($DLm1_data[1]=='Drivers'){
	 $DLm1_val="driver";
	 }else{
	 $DLm1_val=$DLm1_data[1];
	 }	 
	 if(strpos($mainval,strtoupper($DLm1_val).",")!='' || strpos($mainval,strtoupper($DLm1_val).",")===0){
	 //echo "Yes";
	 }else{
	 //echo "No";
	 }
	 echo $DLm1_data[3];
	?>
	</td>
	<td>NO</td><td ><a href="#" onclick="show_DLModVal('<?=$DLm1_data[0];?>');">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_cate=<?=$DLm1_data[3];?>&d_num=<?=$DLm1_data[0];?>">Del</a></td>
  </tr>
<?php
}
?>
  <tr>
    <td colspan="2">
	<?php
	$all_mpage=ceil($public_Maincount/$read_Main_num);
	$mpageSize=$page;
	$mtotal=$all_mpage;
	pageft($mtotal,$mpageSize,1,0,0,15);       
	?>
	</td>
  </tr>
</table>
</form>
</div>
<br />
<div class="sabrosus"><span class="w14bblue"><?=$read_Main_num;?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="DoLoMa_page" name="DoLoMa_page" onChange="MM_main(this)">
<?php
for($k=1;$k<=$mtotal;$k++){
?>
<option value="?page=<?=$k?>" <?php if($page==$k){ echo "selected"; } ?>><?=$k?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>
<p style="color:#0F0">- 與舊系統整合4個 download type: BIOS, IPMI/iKVM Firmware, Drivers, Utility。其中的 Drivers & Utility 有 Subcategory 的設定跟舊資料整合。<br />- 舊資料整合：(1) OS lists=> http://www.tyan.com/TYANWEBMGT/c_sp_os.aspx<br /> - 舊資料整合：(2) http://www.tyan.com/TYANWEBMGT/c_sp_drivers_category.aspx => Drivers 下面的 subcategory<br />- 舊資料整合：(3) http://www.tyan.com/TYANWEBMGT/c_sp_utility_category.aspx => Utility 下面的 subcategory<br />
- Introduction textarea 要能允許html code<br />- List 順序：由新至舊</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<!--編輯subcategory: 有勾選 Subcategory yes 後，click edit icon 才會show 出-->
<div class="subsettings" style="display:none">
<h1>Add / Edit subcategories for "抓[Downlaod Type]"</h1>
	<div>
<table id="insidebox_module" >
<tr><th>Name</th><th>Image</th><th>URL</th><th>Description</th><th><input name="" type="button" value="Add" /></th></tr>
<!--add an new subcategory-->
<tr ><td ><input name="" type="text" size="20" value=""  /></td><td ><input name="" type="text" size="15" value=""  /> <input name="" type="button" value="Browse"  /></td><td ><input name="" type="text" size="15" value=""  /></td><td ><textarea  name="" rows="2" cols="30" style="max-width: 100px; max-height: 100px;"></textarea></td><td >&nbsp;</td></tr>
<!--end adding an new subcategory-->
<tr><td >TSM</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="#" />[Edit]</a>&nbsp;<a href="#" />[Del]</a></td></tr>
<tr><td >Audio</td><td>/drivers/images/driver_icon_audio.gif</td><td>&nbsp;</td><td>&nbsp;</td><td><a href="#" />[Edit]</a>&nbsp;<a href="#" />[Del]</a></td></tr>
</table></div>
</div>
<p style="color:#0F0">- List 順序：由新至舊</p>
<!--end 編輯subcategory-->
<p class="clear">&nbsp;</p>
<!--編輯 OS: 有勾選 OS yes 後，click edit icon 才會show 出-->
<div class="subsettings" >
<h1>Add / Edit OS List</h1>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
<div id="os_pannel">
<form id="form2" name="form2" method="post" enctype="multipart/form-data" action="lb_dl_type.php">
<table id="insidebox_module" >
<tr><th>OS Name</th><th><div class="button14" style="width:50px;" onClick="show_AddOSVal();">Add</div></th></tr>
<!--add an new OS-->
<tr >
<td colspan="2">
<DIV id="MValue_OSADD01" style="display:none"><input id="MV_strOS01" name="MV_strOS01" type="text" size="30" value="" /> <input id="MVaBtnOS" type="button" value="Done" />&nbsp;&nbsp;<input id="MVaCelOS" type="button" value="Cancel" /><DIV id="MValOS_MGT"></DIV><DIV id="MValOS_error"></DIV></div>
<?php
if(isset($_REQUEST['mid'])!=''){
$mid01=trim($_REQUEST['mid']);
$str_MVm="SELECT `LISTVALUE`, `LISTNAME` FROM `c_all_selectlist` where `CATEGORY`='OS' and `LISTVALUE`=".$mid01;
$MVm_cmd=mysqli_query($link_db,$str_MVm);
$MVm_data=mysqli_fetch_row($MVm_cmd);
?>
<DIV id="MValue_OSMOD01" style="display:none"><input id="MValue_num" name="MValue_num" type="hidden" value="<?=$_REQUEST['mid'];?>"><input id="MVm_strOS01" name="MVm_strOS01" type="text" size="30" value="<?=$MVm_data[1];?>" /> <input id="MVaBtnOSm" type="button" value="Done" />&nbsp;&nbsp;<input id="MVaCelOSm" type="button" value="Cancel" /><DIV id="MValOSm_MGT"></DIV><DIV id="MValOSm_error"></DIV></div>
<?php
}
?>
</td>
</tr>
<!--end adding an new OS-->
<?php
if(isset($_REQUEST['page'])!=""){
$page=$_REQUEST['page'];
}else{
$page="1";
}
      
if(empty($page))$page="1";
     
$read_num="10";
$start_num=$read_num*($page-1);
$str_OSm1="SELECT `LISTVALUE`, `LISTNAME` FROM `c_all_selectlist` where `CATEGORY`='OS' order by `LISTNAME` limit $start_num,$read_num;";
  
$OSm1_result=mysqli_query($link_db,$str_OSm1);
while($OSm1_data=mysqli_fetch_row($OSm1_result)){
?>
<tr><td ><?=$OSm1_data[1];?></td><td><a href="#" onclick="show_OSModVal(<?=$OSm1_data[0];?>);" />[Edit]</a>&nbsp;<a href="?act=del&d_cate=OS&d_num=<?=$OSm1_data[0];?>" onclick="return confirm('Are you sure you want to delete this item?');" />[Del]</a></td></tr>
<?php
}
?>
<tr>
<td colspan="2">
<?php
$all_page=ceil($public_count/$read_num);
$pageSize=$page;
$total=$all_page;
pageft($total,$pageSize,1,0,0,15);       
?>
</td>
</tr>
</table>
</form>
<br />
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="DoLoOS_page" name="DoLoOS_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>
</div>
</div>
<p style="color:#0F0">- List 順序：由新至舊</p>
<!--end 編輯 OS-->
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
echo "<script language='JavaScript'>show_OSModVal01();</script>";
exit();
}
if(isset($_REQUEST['aid'])!=''){
echo "<script language='JavaScript'>show_DLModVal01();</script>";
exit();
}
?>