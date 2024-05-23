<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../login.php'</script>";
exit();
}

require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['kinds'])!=''){
$getIconlist="";
if(trim($_REQUEST['kinds'])=='add_icon'){
  if(isset($_POST['getIcon'])!=''){
  foreach($_POST['getIcon'] as $getIcon)
  {
	$getIconlist=$getIconlist.$getIcon.",";
  }
  }else{
    $getIconlist='';
  }
//echo $getIconlist;
echo "<script language='Javascript'>parent.document.forms['form1'].iconvals.value='".$getIconlist."';";
/*echo "<script language='Javascript'>";
echo "try{";
echo "  if(parent.window.opener != null && !parent.window.opener.closed)";
echo "  {";
echo "    parent.window.opener.document.forms['form1'].iconvals.value = '".$getIconlist."'";
//echo "	  parent.window.opener.test_call()";
echo "  }";
echo "  ";
echo "  }catch(e){ alert(e.description);}";*/
//echo "parent.location.reload();parent.jQuery.fancybox.close()";
echo "parent.jQuery.fancybox.close()";
echo "</script>\n";
//echo "<script language='Javascript'>alert('".$getIconlist."');parent.jQuery.fancybox.close();</script>\n";
exit();
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Product icons</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<script type="text/javascript" src="../jquery.min.js"></script>
<!--<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>-->

<style type="text/css">
table{border:0px solid #c0c0c0; width:90%}
td{ padding:5px 15px; cursor: pointer;}
td:hover{background: #dcf2fd;}
</style>
</head>
<body style="backbround:#f9f9f9">
<h2 >Select icons:</h2>
<p class="clear"></p>
<!--<input type="button" value="change Value" onclick="icon_val()">-->
<form id="form_child" name="form_child" method="post" action="?kinds=add_icon">
<table>
<tr>
<td >
<?php
$path = '../../images/logo/';

$str_ico="SELECT `id`, `icon_name`, `img`, `url` FROM `c_sp_icon` order by `id` desc";
$ico_cmd=mysqli_query($link_db,$str_ico);
$i=0;
while($ico_data=mysqli_fetch_row($ico_cmd)){
$i+=1;
  $filename=$ico_data[2];
  $filename_vals=str_replace('./images/logo/', '', $filename);
  $filename_src=$path.$filename_vals;  

  if($i%6==0){
  $br01="<br />";
  }else{
  $br01="";
  }
?>
<input id="getIcon[]" name="getIcon[]" type="checkbox" value="<?=$filename_vals;?>" /> <img src="<?=$filename_src;?>" alt="<?=$filename_vals;?>" /><?=$br01;?>
<?php
}
?>
</td>
</tr>
</table>
<p style="padding:5px 20px;"><input type="submit" value="Done" /></p>
</form>
<P style="color:#0F0">- default列出在icon module 中所建立的所有icons, 可以選擇(多選)。最新增的列在最前面 <br></p>
</body>
</html>