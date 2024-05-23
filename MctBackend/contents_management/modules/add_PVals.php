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

$PV_str01=trim($_POST['PV_str01']);
$PV_str02=trim($_POST['PV_str02']);

$str_New="select PIV_id FROM product_infovalue_las order by PIV_id desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

if($PV_str01=='' || $PV_str02==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($PV_str01<>'' && $PV_str02<>''){
   
   $str_chk="SELECT `PIV_id`, `PI_id`, `PIV_Value`, `PIV_Sort` FROM `product_infovalue_las` where `PIV_Value`='".$PV_str02."' and `PIV_flag`=0";
   //$str_chk="SELECT `PIV_id`, `PI_id`, `PIV_Value`, `PIV_Sort` FROM `product_infoValue_las`";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):   
      
	  $str_val="insert into `product_infovalue_las` (`PIV_id`, `PI_id`, `PIV_Value`, `PIV_Sort`, `PIV_flag`) values (".$MCount.",1,'".$PV_str02."','".$PV_str01."',0)";
	  $val_cmd=mysqli_query($link_db,$str_val);
	  //if($val_cmd==true){
	  echo "refresh";	  
      //}
	  
   else:
   echo "<font color=red><b>Data be exist!</b></font>";
   endif;
}
mysqli_Close($link_db);
?>