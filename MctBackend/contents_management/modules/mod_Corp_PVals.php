<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$PV_str00m=$_POST['PV_str00m'];
$PV_str01m=htmlspecialchars($_POST['PV_str01m'], ENT_QUOTES);
$PV_str02m=htmlspecialchars($_POST['PV_str02m'], ENT_QUOTES);
$PV_str03m=htmlspecialchars($_POST['PV_str03m'], ENT_QUOTES);

$PV_myFilem=$_FILES['PV_myFilem']['name'];

if(($PV_myFilem != "none" && $PV_myFilem != "")){   
   $UploadPath = "../../corp_pic/";
   $flag = copy($_FILES['PV_myFilem']['tmp_name'], $UploadPath.basename($_FILES['PV_myFilem']['name']));  
   if($flag) echo "";   
   $url="./corp_pic/";   
}else{   
   $url="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($PV_str01m=='' || $PV_str02m==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($PV_str01m<>'' && $PV_str02m<>''){
   
   if($PV_myFilem!=''){      
	$str_val="update `product_corpval` set `PCV_name`='".$PV_str01m."', `PCV_img`='$url$PV_myFilem', `PCV_url`='".$PV_str02m."', `PCV_brief`='".$PV_str03m."', `PCV_flag`=0 where `PCV_id`=".$PV_str00m;
   }else{
    $str_val="update `product_corpval` set `PCV_name`='".$PV_str01m."', `PCV_url`='".$PV_str02m."', `PCV_brief`='".$PV_str03m."', `PCV_flag`=0 where `PCV_id`=".$PV_str00m;
   }
	$val_cmd=mysqli_query($link_db,$str_val);
	echo "refresh";	  

}
mysqli_Close($link_db);
?>