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
//$select=mysqli_select_db($dataBase);

if(isset($_POST['MV_str01'])!=''){
$MV_str01=htmlspecialchars($_POST['MV_str01'], ENT_QUOTES);
}else{
$MV_str01="";
}

$str_New="select `ID` from `c_sp_hdd_size` order by `ID` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;

if($MV_str01==''){
   echo "<font color=red><b>Data is empty!</b></font>";
}else if($MV_str01<>''){
   
   $str_chk="SELECT `ID` FROM `c_sp_hdd_size` where `HDDSIZE`='".$MV_str01."'";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
 
   if(empty($chk_record)):        
   
	  $str_val="insert into `c_sp_hdd_size` (`ID`, `HDDSIZE`) values (".$MCount.",'".$MV_str01."')";
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";
   
   else:
   echo "<font color=red><b>Data is exist!</b></font>";
   endif;
   
}
mysqli_Close($link_db);
?>