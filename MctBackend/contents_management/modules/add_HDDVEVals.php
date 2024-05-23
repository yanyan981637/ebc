<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

@session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_POST['MV_str01'])!=''){
$MV_str01=htmlspecialchars($_POST['MV_str01'], ENT_QUOTES);
}else{
$MV_str01="";
}
if(isset($_POST['MV_str02'])!=''){
$MV_str02=trim($_POST['MV_str02']);
}else{
$MV_str02="";
}
$str_New="select `ID` from `c_sp_hdd_modulevender` order by `ID` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

if(isset($_FILES['MyFile']['name'])!=''){
$MyFile=trim($_FILES['MyFile']['name']);

if(($MyFile != "none" && $MyFile != "")){   
   $UploadPath = "../../images/";
   $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.basename($_FILES['MyFile']['name']));  
   if($flag) echo "";   
   $url="./images/";   
}else{   
   $url="";
}
}else{
$MyFile="";
}

if($MV_str01==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MV_str01<>''){
   
   $str_chk="SELECT `ID` FROM `c_sp_hdd_modulevender` where `MODULEVENDER`='".$MV_str01."' and `STATUS`=1";
   //SELECT `ID`, `MODULEVENDER`, `ICON`, `URL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_sp_hdd_modulevender`
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):   
      
	  if($MyFile!=''){
	  $str_val="insert into `c_sp_hdd_modulevender` (`ID`, `MODULEVENDER`, `ICON`, `URL`, `STATUS`) values (".$MCount.",'".$MV_str01."','$url$MyFile','".$MV_str02."','1')";
	  }else{
	  $str_val="insert into `c_sp_hdd_modulevender` (`ID`, `MODULEVENDER`, `URL`, `STATUS`) values (".$MCount.",'".$MV_str01."','".$MV_str02."','1')";
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