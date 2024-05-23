<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['act'])!=''){
if(trim($_REQUEST['act'])=='del'){
  
  if(isset($_REQUEST['d_id'])!=''){
  $d_id01=intval($_REQUEST['d_id']);
  $str_del="Delete FROM `c_sp_hdd_type` where `ID`=".$d_id01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete the Data !');self.location='lb_hddssd_type.php';</script>";
  exit();  
  }
  
}
}

$str1="SELECT count(`ID`) FROM `c_sp_hdd_type`";
$cmd1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($cmd1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit HDD/SSD Type</title>
<link rel="stylesheet" type="text/css" href="../../backend.css" />
<link rel="stylesheet" type="text/css" href="../../css.css" />
<style type="text/css">
</style>
<script type="text/javascript" src="../../jquery.min.js"></script>
<script language="JavaScript">
  function MM_o(selObj){
    window.open(document.getElementById('hddtyp_page').options[document.getElementById('hddtyp_page').selectedIndex].value,"_self");
  }
  function show_AddVal(){
	$("#MValue_ADD01").show();
	$("#MValue_MOD01").hidden();
  }
  function show_ModVal01(){
    $("#MValue_MOD01").show();
	$("#MValue_ADD01").hidden();
  }
</script>
<script type="text/javascript">
$(function() {
	
  $("#MVaBtn").click(function() {  
  
  var form = $('#form2');
  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form2').serialize();
  var url = "add_HDDTYVals.php";
  
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
    $("#MVal_MGT").html(data);
	$("#MVal_error").html('');
    }
  }  
  });  
  });
  
  $("#MVaBtnm").click(function() {
  
  var form = $('#form2');
  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form2').serialize();
  var url = "mod_HDDTYVals.php";
  
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
    self.location="lb_hddssd_type.php";
	}
    else{
    $("#MValm_MGT").html(data);
	$("#MValm_error").html('');
    }
  }  
  });  
  });
	
	$("#MVaCel").click(function() { 
    $("#MValue_ADD01").hide();
	$("#MV_str01").val("");
    $("#MVal_MGT").html('');
    $("#MVal_error").html('');
    });
	
	$("#MVaCelm").click(function() { 
    $("#MValue_MOD01").hide();
	$("#MVm_str01").val("");
    $("#MValm_MGT").html('');
    $("#MValm_error").html('');
    });
  
});
</script>
</head>

<body style="backbround:#f9f9f9">
<h2>Edit / Add HDD/SSD Type:</h2><p class="clear"></p>
<p>Total: <span class="w14bblue"><?=$public_count;?></span> records </p>
</div>

<p class="clear"></p>
<form id="form2" name="form2" method="post" action="lb_hddssd_type.php">
<table class="list_table">
  <tr>
    <th >HDD/SSD Type </th><th><div class="button14" style="width:50px;" onClick="show_AddVal();">Add</div></th>
  </tr>
<!--add a HDD/SSD Type-->
  <tr>
    <td colspan="2">
	<DIV id="MValue_ADD01" style="display:none"><input id="MV_str01" name="MV_str01" type="text" size="30" value="" />&nbsp;&nbsp;<select id="MV_status01" name="MV_status01"><option value="1">On</option><option value="0">Off</option></select> <input id="MVaBtn" type="button" value="Done" />&nbsp;&nbsp;<input id="MVaCel" type="button" value="Cancel" /><DIV id="MVal_MGT"></DIV><DIV id="MVal_error"></DIV></div>
	<?php
	if(isset($_REQUEST['mid'])!=''){
	 $mid01=intval($_REQUEST['mid']);
	 $str_MVm="SELECT `ID`, `HDDTYPE`, `STATUS` FROM `c_sp_hdd_type` where `ID`=".$mid01;
     $MVm_cmd=mysqli_query($link_db,$str_MVm);
	 $MVm_data=mysqli_fetch_row($MVm_cmd);
	?>
	<DIV id="MValue_MOD01" style="display:none"><input id="MValue_id" name="MValue_id" type="hidden" value="<?=$_REQUEST['mid'];?>"><input id="MVm_str01" name="MVm_str01" type="text" size="30" value="<?=$MVm_data[1];?>" />&nbsp;&nbsp;<select id="MVm_status01" name="MVm_status01"><option value="1" <?php if($MVm_data[2]=="1"){ echo "selected"; }?>>On</option><option value="0" <?php if($MVm_data[2]=="0"){ echo "selected"; }?>>Off</option></select> <input id="MVaBtnm" type="button" value="Done" /><input id="MVaCelm" type="button" value="Cancel" /><DIV id="MValm_MGT"></DIV><DIV id="MValm_error"></DIV></div>
	<?php
	}
	?>
	</td>
  </tr>
<!--end add a HDD/SSD Type-->
  <?php
     if(isset($_REQUEST['page'])!=""){
	 $page=intval($_REQUEST['page']);
     }else{
     $page="1";
     }
      
     if(empty($page))$page="1";      
     $read_num="10";
     $start_num=$read_num*($page-1);
  
	 $str_m1="SELECT `ID`, `HDDTYPE`, `STATUS` FROM `c_sp_hdd_type` order by `HDDTYPE` limit $start_num,$read_num;";  
     $m1_result=mysqli_query($link_db,$str_m1);
     while($m1_data=mysqli_fetch_row($m1_result)){
  ?>
  <tr>
    <td><?=$m1_data[1];?> &nbsp; <?php if($m1_data[2]=="1"){ echo "<font color='blue'>Online</font>"; }else if($m1_data[2]=="0"){ echo "<font color='red'>Offline</font>"; } ?></td><td ><a href="lb_hddssd_type.php?mid=<?=$m1_data[0];?>">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$m1_data[0];?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
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
<select id="hddtyp_page" name="hddtyp_page" onChange="MM_o(this)">
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
<p style="color:#0F0">- 資料整合：http://www.tyan.com/TYANWEBMGT/c_sp_hdd_type.aspx。<br />- 只匯入 "HDD Type" 欄位資料至 "HDD/SSD Type" 欄位<br />- List 順序：由新至舊</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
echo "<script>show_ModVal01();</script>\n";
exit();
}
?>