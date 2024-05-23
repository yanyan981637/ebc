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
//$select=mysqli_select_db($dataBase);

if($_REQUEST['act']=='del'){
  if($_REQUEST['d_id']!=''){
    $did01=$_REQUEST['d_id'];
	$str_del="delete from `document_type` where `ID`=".$did01;
	$del_cmd=mysqli_query($link_db,$str_del);
	echo "<script>alert('Delete the Data!');self.location='lb_doc_type.php'</script>";
	exit();
  }  
}

$str1="select count(*) from `document_type`";
$list1 =mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Document management - Doc Type</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />
<style type="text/css">
</style>
<script type="text/javascript" src="../../jquery.min.js"></script>
<script language="javascript">

function show_AddVal(){
  $("#MValue_ADD01").show();
  $("#MValue_MOD01").hide();
}

function show_ModVal(id){
  self.location='lb_doc_type.php?mid='+id;
}

function show_ModVal01(){
  $("#MValue_MOD01").show();
  $("#MValue_ADD01").hide();
}

</script>
<script type="text/javascript">
$(function() {
	
  $("#MVaBtn").click(function() {  
  var params = $('input').serialize();
  var url = "add_DOCTYVals.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
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
  var params = $('input').serialize();
  var url = "mod_DOCTYVals.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(data){
    
    if(data == "refresh"){	
    //window.location.reload(true);
    self.location="lb_doc_type.php";
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
<h2>Edit / Add Doc Type:</h2><p class="clear"></p>
<p>Total: <span class="w14bblue"><?=$public_count;?></span> records </p>
</div>
<p class="clear"></p>
<form id="form2" name="form2" method="post" action="lb_chipset_vender.php">
<table class="list_table">
  <tr>
    <th >Doc Type</th><th><div class="button14" style="width:50px;" onClick="show_AddVal();">Add</div></th>
  </tr>
<!--add a HDD/SSD Interface-->
  <tr>
    <td colspan="2">
	<DIV id="MValue_ADD01" style="display:none"><input id="MV_str01" name="MV_str01" type="text" size="18" value="" /> <input id="MVaBtn" type="button" value="Done" /><input id="MVaCel" type="button" value="Cancel" /><DIV id="MVal_MGT"></DIV><DIV id="MVal_error"></DIV></div>
	<?
	if($_REQUEST['mid']!=''){
	 $mid01=$_REQUEST['mid'];
	 $str_MVm="SELECT `ID`, `TYPE_NAME`, `STATUS` FROM `document_type` where `ID`=".$mid01;
	 $MVm_cmd=mysqli_query($link_db,$str_MVm);
	 $MVm_data=mysqli_fetch_row($MVm_cmd);
	?>
	<DIV id="MValue_MOD01" style="display:none"><input id="MValue_id" name="MValue_id" type="hidden" value="<?=$_REQUEST['mid'];?>"><input id="MVm_str01" name="MVm_str01" type="text" size="18" value="<?=$MVm_data[1];?>" /> <input id="MVaBtnm" type="button" value="Done" /><input id="MVaCelm" type="button" value="Cancel" /><DIV id="MValm_MGT"></DIV><DIV id="MValm_error"></DIV></div>
	<?
	}
	?>
	</td>	
  </tr>
<!--end add a HDD/SSD Interface-->
  <?php
  if($_REQUEST['page']==""){
  $page="1";
  }else{
  $page=$_REQUEST['page'];
  }
      
  if(empty($page))$page="1";
      
  $read_num="10";
  $start_num=$read_num*($page-1);
  $str_m1="SELECT `ID`, `TYPE_NAME`, `STATUS` FROM `document_type` order by `TYPE_NAME` limit $start_num,$read_num;";
  
  $m1_result=mysqli_query($link_db,$str_m1);
  while($m1_data=mysqli_fetch_row($m1_result)){
  ?>  
  <tr>
    <td ><?=$m1_data[1];?></td><td ><a href="#" onclick="show_ModVal(<?=$m1_data[0];?>);">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$m1_data[0];?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?
  }
  ?>
</table>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
</body>
</html>
<?php
 if($_REQUEST['mid']!=''){
 echo "<script>show_ModVal01();</script>\n";
 exit();
 }
?>