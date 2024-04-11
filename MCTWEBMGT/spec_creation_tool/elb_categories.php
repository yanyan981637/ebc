<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_REQUEST['kinds'])=='add_categories')
{
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

$t2=$_POST['t2'];


$str_c="select SPECCategoryName from speccategroies where SPECCategoryName='".$t2."'";
$check_c=mysqli_query($link_db,$str_c);
$record_c=mysqli_fetch_row($check_c);

if(empty($record_c)):

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str1="insert into speccategroies (`SPECCategoryName`,`WebOrder`,`crea_d`,`crea_u`) values ('$t2','','$now','1782')";
$cmd_cresult=mysqli_query($link_db,$str1);
echo "<script>alert('Add Categroies it!');self.location='lb_categories.php'</script>";

else:
echo "<script>alert('SPECCategoryName目前已經存在,請重新輸入!');location.href='elb_categories.php'</script>";
exit();
endif;
mysqli_close($link_db);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Edit Product Categories</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<style type="text/css">
table{width:95%}
thead{background:#00a0e9; color:#fff; font-weight:bolder; padding:5px 15px;}
td{ padding:5px 15px;}
tbody{background:#dcf2fd}
</style>

<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

  var sid='<?=$_REQUEST["p_id"];?>';
  var pt_id='<?=$_REQUEST["PType_id"];?>';
  var params = $('input').serialize();
  var url = "categories_eresult.php?sp_id="+sid+"&pty_id="+pt_id;

  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(msg){

  $("#categ_list").html(msg);

  }
  });

});
</script>
<script language="JavaScript">
<!--
function Final_Check(){
  if(document.form2.t2.value==''){
  alert ("請輸入Categories！");
  document.form2.t2.focus();
  return false;
  }
  return true;
}
//-->
</script>
</head>

<body style="backbround:#f9f9f9; padding: 0px 15px">
<div align="right">
<form id="form1" name="form1" method="post">
<input id="p1" name="p1" type="hidden" value="<?=$_REQUEST['p_id']?>" />&nbsp;
</form>
</div>
<p class="clear"></p>
<table>
<tbody>
<tr>
<td>
<table>
<tr>
<td>
<div id="categ_list" style="height:450px;display:''"></div>
</td>
</tr>
</table>
</td>
</tr>
</tbody>
</table>
<P style="color:#0F0;display:none">
- 列出所有的categories (順序跟據 SPEC Settings => Categories 所設定的顯示), checked 已經show 的categories <br>
- 當Filter box輸入英文字第一個字母，下面會動態show出其相同第一個字母的 category。
點選All 會show 出全部，default 為show 出全部。<br>
-  Add New box 可輸入新的category, add後出現在下面並checked<br>
- 被選的Categories, 可排序
</p>
</body>
</html>