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

if(isset($_REQUEST['act'])=='del' && isset($_REQUEST['d_id'])!=''){
  $d_id01=intval($_REQUEST['d_id']);
  $str_d="delete from `c_sp_memory_chipvender` where `ID`=".$d_id01;
  $dcmd=mysqli_query($link_db,$str_d);
  echo "<script>alert('Delete the Data!');self.location='lb_chipset_vender.php'</script>";
  exit();
}

  if(isset($_REQUEST['s_search'])<>''){
     $s_search=trim($_REQUEST['s_search']);
     $str1="select count(*) from `c_sp_memory_chipvender` where (`CHIPVENDER` like '%".$s_search."%')";
  }else{
	 $str1="select count(*) from `c_sp_memory_chipvender`";
  }
  $list1 =mysqli_query($link_db,$str1);
  list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Memory Chipset Vendors</title>
<link rel="stylesheet" type="text/css" href="../../backend.css" />
<link rel="stylesheet" type="text/css" href="../../css/css.css" />
<style type="text/css">

</style>
<script type="text/javascript" src="../../jquery.min.js"></script>
<script language="JavaScript">
	function MM_o(selObj){
       window.open(document.getElementById('mchipv_page').options[document.getElementById('mchipv_page').selectedIndex].value,"_self");
    }
	
	function search_value(){
    //self.location = "?s_search=" + document.form3.sear_txt.value;
    self.location = "?s_search=" + document.getElementById('sear_txt').value;
    return false;
    }
	
	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){
     //alert(keyCodeEntered);
     search_value();     
     }
    }
	
	function show_AddVal(){
	  $('#MValue_ADD01').show();
	  $('#MValue_MOD01').hidden();
	}
	
	function show_ModVal(id){
	 self.location = "lb_chipset_vender.php?mid=" + id;
	}
	function show_ModVal01(){
	  $('#MValue_MOD01').show();
	  $('#MValue_ADD01').shidden();	  
	} 

	function hiden_add(){
	  self.location = "lb_chipset_vender.php";
	}
	
	function show_edit(){
	  $('#nrawds_edit').show();
	  $('#nrawds_add').hidden();
	}
	
	function hiden_edit(){
	  self.location = "lb_chipset_vender.php";
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
  var url = "add_CHVVals.php";
  
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
  var url = "mod_CHVVals.php";
  
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
    self.location="lb_chipset_vender.php";
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
	$("#MV_str02").val("");
    $("#MVal_MGT").html('');
    $("#MVal_error").html('');
    });
	
	$("#MVaCelm").click(function() { 
    $("#MValue_MOD01").hide();
	$("#MVm_str01").val("");
	$("#MVm_str02").val("");
    $("#MValm_MGT").html('');
    $("#MValm_error").html('');
    });
  
});
</script>
</head>
<body style="backbround:#f9f9f9">
<h2>Edit / Add Memory Chipset Vendors:</h2><p class="clear"></p>
<div class="pagination left">
<p>
<form id="form1" name="form1" method="post" action="lb_chipset_vender.php?sear=ok">
<input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" />  <span style="color:#0F0">**Key word search: "Vendor" 欄位 </span> </p>
</form>
</p>
<p>Total: <span class="w14bblue"><?=$public_count;?></span> records </p>
</div>
<p class="clear"></p>
<form id="form2" name="form2" method="post" action="lb_chipset_vender.php">
<table class="list_table">

  <tr>
    <th >Vendor</th><th >LOGO</th><th >Website</th><th><div class="button14" style="width:50px;" onClick="show_AddVal();">Add</div></th>
  </tr>
<!--add a vendor-->
  <tr>
    <td colspan="4">
	<DIV id="MValue_ADD01" style="display:none"><input id="MV_str01" name="MV_str01" type="text" size="18" value="" /> <input type="file" id="MyFile" name="MyFile" size="30" /> <input id="MV_str02" name="MV_str02" type="text" size="30" value=""  /> <input id="MVaBtn" type="button" value="Done" /><input id="MVaCel" type="button" value="Cancel" /><DIV id="MVal_MGT"></DIV><DIV id="MVal_error"></DIV></div>
	<?php
	if(isset($_REQUEST['mid'])!=''){
	 $mid01=intval($_REQUEST['mid']);
	 $str_MVm="SELECT `ID`, `CHIPVENDER`, `ICON`, `URL` FROM `c_sp_memory_chipvender` where `ID`=".$mid01;
     $MVm_cmd=mysqli_query($link_db,$str_MVm);
	 $MVm_data=mysqli_fetch_row($MVm_cmd);
	?>
	<DIV id="MValue_MOD01" style="display:none"><input id="MValue_id" name="MValue_id" type="hidden" value="<?=$mid01;?>"><input id="MVm_str01" name="MVm_str01" type="text" size="18" value="<?=$MVm_data[1];?>" /> <input type="file" id="MyFilem" name="MyFilem" size="30" /> <input id="MVm_str02" name="MVm_str02" type="text" size="30" value="<?=$MVm_data[3];?>" /> <input id="MVaBtnm" type="button" value="Done" /><input id="MVaCelm" type="button" value="Cancel" /><DIV id="MValm_MGT"></DIV><DIV id="MValm_error"></DIV></div>
	<?php
	}
	?>
	</td>
  </tr>
<!--end add a vendor-->
  <?php
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";
      
      $read_num="10";
      $start_num=$read_num*($page-1);
  
  if(isset($_REQUEST['s_search'])<>''){
     $s_search=trim($_REQUEST['s_search']);
     $str_m1="SELECT `ID`, `CHIPVENDER`, `ICON`, `URL` FROM `c_sp_memory_chipvender` where (`CHIPVENDER` like '%".$s_search."%') order by `CHIPVENDER` limit $start_num,$read_num;";
  }else{
	 $str_m1="SELECT `ID`, `CHIPVENDER`, `ICON`, `URL` FROM `c_sp_memory_chipvender` order by `CHIPVENDER` limit $start_num,$read_num;";
  }
  
  $m1_result=mysqli_query($link_db,$str_m1);
  while($m1_data=mysqli_fetch_row($m1_result)){
  ?>
  <tr>
    <td ><?=$m1_data[1];?></td><td ><?=$m1_data[2];?></td><td ><?=$m1_data[3];?></td><td ><a href="#" onClick="show_ModVal(<?=$m1_data[0];?>)">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$m1_data[0];?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?php
  }
  ?>
  <tr>
  <td colspan="4">
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
<select id="mchipv_page" name="mchipv_page" onChange="MM_o(this)">
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
<p style="color:#0F0">- 資料整合：http://www.tyan.com/TYANWEBMGT/c_sp_memory_chipvender.aspx<br />- List 順序：由新至舊</p>
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