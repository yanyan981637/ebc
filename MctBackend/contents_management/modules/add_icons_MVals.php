<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MV_str01=$_POST['MV_str01'];
$MV_str02=$_POST['MV_str02'];
$MV_str03=$_POST['MV_str03'];
$MV_str04=$_POST['MV_str04'];

$MV_str04=str_replace(" ","&nbsp;",$MV_str04);

$str_New="select `id` from `c_sp_icon` order by `id` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

$MyFile=$_FILES['MyFile']['name'];


if(($MyFile != "none" && $MyFile != "")){   
   $UploadPath = "../../../images/logo/";
   $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.basename($_FILES['MyFile']['name']));
   if($flag) echo "";   
   $url="./images/logo/";   
}else{   
   $url="";
}

if($MV_str01=='' || $MV_str02==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MV_str01<>'' && $MV_str02<>''){
   
   $str_chk="SELECT `id` FROM `c_sp_icon` where `icon_name`='".$MV_str01."' and `url`='".$MV_str02."' and `order`='".$MV_str03."'";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):   
      
	  if($MyFile!=''){
	  $str_val="insert into `c_sp_icon` (`id`, `icon_name`, `img`, `tooltips`, `URL`, `order`) values (".$MCount.",'".$MV_str01."','$url$MyFile','".$MV_str04."','".$MV_str02."','".$MV_str03."')";
	  }else{
	  $str_val="insert into `c_sp_icon` (`id`, `icon_name`, `tooltips`, `URL`, `order`) values (".$MCount.",'".$MV_str01."','".$MV_str04."','".$MV_str02."','".$MV_str03."')";
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