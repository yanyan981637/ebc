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

if(isset($_POST['MV_str01'])!==''){
$MV_str01=trim($_POST['MV_str01']);
}else{
$MV_str01="";
}

if(isset($_POST['MV_str02'])!==''){
$MV_str02=trim($_POST['MV_str02']);
}else{
$MV_str02="";
}

$str_New="select `ID` from `c_sp_memory_chipvender` order by `ID` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

$MyFile=$_FILES['MyFile']['name'];

if(($MyFile != "none" && $MyFile != "")){   
   $UploadPath = "../../images/";
   $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.$_FILES['MyFile']['name']);  
   if($flag) echo "";   
   $url="./images/";   
}else{   
   $url="";   
}


//if($MV_str01=='' || $MV_str02==''){
if($MV_str01==''){	
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MV_str01<>''){
   
   $str_chk="SELECT `ID` FROM `c_sp_memory_chipvender` where `CHIPVENDER`='".$MV_str01."' and `URL`='".$MV_str02."' and `STATUS`=1";
   //SELECT `ID`, `CHIPVENDER`, `ICON`, `URL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_sp_memory_chipvender`
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):      
	  if($MyFile!=''){
	  $str_val="insert into `c_sp_memory_chipvender` (`ID`, `CHIPVENDER`, `ICON`, `URL`, `STATUS`) values (".$MCount.",'".$MV_str01."','$url$MyFile','".$MV_str02."','1')";
	  }else{
	  $str_val="insert into `c_sp_memory_chipvender` (`ID`, `CHIPVENDER`, `URL`, `STATUS`) values (".$MCount.",'".$MV_str01."','".$MV_str02."','1')";
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