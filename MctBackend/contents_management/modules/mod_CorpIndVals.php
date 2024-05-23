<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_id=$_POST['MValue_id'];
$MVm_str01=htmlspecialchars($_POST['MVm_str01'], ENT_QUOTES);

$MyFilem=$_FILES['MyFilem']['name'];

if(($MyFilem != "none" && $MyFilem != "")){   
   $UploadPath = "../../Indus_pic/";
   $flag = copy($_FILES['MyFilem']['tmp_name'], $UploadPath.basename($_FILES['MyFilem']['name']));  
   if($flag) echo "";   
   $url="./Indus_pic/";   
}else{   
   $url="";   
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($MVm_str01==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01<>''){
	  if($MyFilem!=''){
	  $str_val="UPDATE `corp_stor_industry` SET `ci_name`='".$MVm_str01."',`ci_img`='$url$MyFilem' where `ci_id`=".$MValue_id;
	  }else{
	  $str_val="UPDATE `corp_stor_industry` SET `ci_name`='".$MVm_str01."' where `ci_id`=".$MValue_id;
	  }
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";	  
}
mysqli_Close($link_db);
?>