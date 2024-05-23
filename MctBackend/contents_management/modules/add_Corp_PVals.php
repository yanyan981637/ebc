<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$PV_str01=htmlspecialchars($_POST['PV_str01'], ENT_QUOTES);
$PV_str02=htmlspecialchars($_POST['PV_str02'], ENT_QUOTES);
$PV_str03=htmlspecialchars($_POST['PV_str03'], ENT_QUOTES);

$str_New="select `PCV_id` FROM product_corpval order by `PCV_id` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

$PV_myFile=$_FILES['PV_myFile']['name'];

if(($PV_myFile != "none" && $PV_myFile != "")){   
   $UploadPath = "../../corp_pic/";
   $flag = copy($_FILES['PV_myFile']['tmp_name'], $UploadPath.basename($_FILES['PV_myFile']['name']));  
   if($flag) echo "";   
   $url="./corp_pic/";   
}else{   
   $url="";
}

if($PV_str01=='' || $PV_str02==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($PV_str01<>'' && $PV_str02<>''){
   
   $str_chk="SELECT `PCV_id`, `PCV_name`, `PCV_img`, `PCV_url`, `PCV_brief` FROM `product_corpval` where `PCV_name`='".$PV_str01."' and `PCV_flag`=0";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):   
      
	  $str_val="insert into `product_corpval` (`PCV_id`, `PCV_name`, `PCV_img`, `PCV_url`, `PCV_brief`, `PCV_flag`) values (".$MCount.",'".$PV_str01."','$url$PV_myFile','".$PV_str02."','".$PV_str03."',0)";
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