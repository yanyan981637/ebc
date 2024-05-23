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

if(isset($_POST['MValue_id'])!=''){
$MValue_id=intval($_POST['MValue_id']);
}else{
$MValue_id="";	
}
if(isset($_POST['MVm_str01'])!=''){
$MVm_str01=htmlspecialchars($_POST['MVm_str01'], ENT_QUOTES);
}else{
$MVm_str01="";
}
if(isset($_POST['MVm_str02'])!=''){
$MVm_str02=trim($_POST['MVm_str02']);
}else{
$MVm_str02="";
}
if(isset($_FILES['MyFilem']['name'])!=''){
$MyFilem=trim($_FILES['MyFilem']['name']);

if(($MyFilem != "none" && $MyFilem != "")){   
   $UploadPath = "../../images/";
   $flag = copy($_FILES['MyFilem']['tmp_name'], $UploadPath.basename($_FILES['MyFilem']['name']));  
   if($flag) echo "";   
   $url="./images/";   
}else{   
   $url="";   
}
}else{
$MyFilem="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($MVm_str01==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01<>''){      
	  if($MyFilem!=''){
	  $str_val="UPDATE `c_sp_hdd_modulevender` SET `MODULEVENDER`='".$MVm_str01."',`ICON`='$url$MyFilem',`URL`='".$MVm_str02."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='".$now."',`STATUS`=1 where `ID`=".$MValue_id;
	  }else{
	  $str_val="UPDATE `c_sp_hdd_modulevender` SET `MODULEVENDER`='".$MVm_str01."',`URL`='".$MVm_str02."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='".$now."',`STATUS`=1 where `ID`=".$MValue_id;
	  }
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";	  
}
mysqli_Close($link_db);
?>