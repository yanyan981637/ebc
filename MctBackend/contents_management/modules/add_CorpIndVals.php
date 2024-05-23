<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MV_str01=htmlspecialchars($_POST['MV_str01'], ENT_QUOTES);


$str_New="select `ci_id` from `corp_stor_industry` order by `ci_id` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

$MyFile=$_FILES['MyFile']['name'];

if(($MyFile != "none" && $MyFile != "")){   
   $UploadPath = "../../Indus_pic/";
   $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.basename($_FILES['MyFile']['name']));  
   if($flag) echo "";   
   $url="./Indus_pic/";   
}else{   
   $url="";
}

if($MV_str01==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MV_str01<>''){
   
   $str_chk="SELECT `ci_id` FROM `corp_stor_industry` where `ci_name`='".$MV_str01."'";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):   
      
	  if($MyFile!=''){
	  $str_val="insert into `corp_stor_industry` (`ci_id`, `ci_name`, `ci_img`) values (".$MCount.",'".$MV_str01."','$url$MyFile')";
	  }else{
	  $str_val="insert into `corp_stor_industry` (`ci_id`, `ci_name`) values (".$MCount.",'".$MV_str01."')";
	  }
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