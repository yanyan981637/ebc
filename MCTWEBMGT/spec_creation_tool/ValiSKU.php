<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_POST['SKU_value'])!=''){
$sid=intval($_POST['SKU_value']);
}else{
$sid="";
}
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

$str_CSKU="select SKU from product_skus where SKU='".$sid."'";
$CSKU_result=mysqli_query($link_db,$str_CSKU);
$check1=mysqli_fetch_row($CSKU_result);
if(empty($check1)):
//echo "<font color=blue>".$sid." 可以使用</font>";
else:
echo "<font color=red>Repeated SKU. Please enter a new one.</font>";
endif;
mysqli_close($link_db);
?>
