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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H;i:s");

if($MVm_str01==''){
	echo "<font color=red><b>Data is empty!</b></font>";
}else if($MVm_str01!=''){
   /*
   $str_chk="SELECT `ID` FROM `c_sp_hdd_capacity` where `Capacity`='".$MVm_str01."'";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):        
   */
	  $str_val="update `c_sp_hdd_capacity` set `Capacity`='".$MVm_str01."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='$now',`STATUS`='1' where `ID`=".$MValue_id;
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";
   /* 
   else:
   echo "<font color=red><b>Data be exist!</b></font>";
   endif;
   */
}
mysqli_close($link_db);
?>