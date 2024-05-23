<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if($_REQUEST['kinds']=="addnew"){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase);

$str1="select SKUs_Mid FROM `skus_mainsub` order by SKUs_Mid desc limit 1";
$check1=mysqli_query($link_db,$str1);
$Max_ID=mysqli_fetch_row($check1);
$MCount=$Max_ID[0]+1;

$t1=$_POST['t1'];
$str_c="select SKUs_MiName from `skus_mainsub` where SKUs_MiName='".$t1."'";
$check_c=mysqli_query($link_db,$str_c);
$record_c=mysqli_fetch_row($check_c);

if(empty($record_c)):
$str1="insert into `skus_mainsub` (`SKUs_Mid`,`SKUs_MiName`,`IsShow` ) values ($MCount,'$t1','1')";
$cmd_cresult=mysqli_query($link_db,$str1);
echo "<script>alert('AddNew ok!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
else:
echo "<script>alert('目前已經存在,請重新輸入!');location.href='add_conditions.php'</script>";
exit();
endif; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<div >
<form id="form1" name="form1" method="post" action="?kinds=addnew" onsubmit="return Final_Check();">
Conditions : <input id="t1" name="t1" type="text" size="25" value=""  />&nbsp;  <input type="submit" value="Add"  />
</form>
</div>
</body>
</html>