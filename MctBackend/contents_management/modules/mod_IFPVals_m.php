<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

$IFPV_str00mm=intval($_POST['IFPV_str00mm']);
$PV_str00mm=intval($_POST['PV_str00mm']);
$PV_str01mm=trim($_POST['PV_str01mm']);
$PV_str02mm=trim($_POST['PV_str02mm']);

if($IFPV_str00mm=='' || $PV_str00mm=='' || $PV_str01mm=='' || $PV_str02mm==''){
  echo "<font color=red><b>Data be empty!</b></font>";
}else if($IFPV_str00mm<>'' && $PV_str01mm<>'' && $PV_str02mm<>''){
	  
	  $str_up="update `product_infovalue_las` set `PIV_Value`='".$PV_str02mm."',`PIV_Sort`='".$PV_str01mm."' where `PIV_id`=".$IFPV_str00mm." and `PI_id`=".$PV_str00mm;
	  $up_cmd=mysqli_query($link_db,$str_up);
	  //if($val_cmd==true){
	  echo "refresh";	  
      //}
}

mysqli_Close($link_db);
?>