<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

$MV_strDT01=htmlspecialchars($_POST['MV_strDT01'], ENT_QUOTES);
$MV_strDT02=htmlspecialchars($_POST['MV_strDT02'], ENT_QUOTES);
$MV_strDT03=htmlspecialchars($_POST['MV_strDT03'], ENT_QUOTES);
$MV_strDT04=htmlspecialchars($_POST['MV_strDT04'], ENT_QUOTES);

if($MV_strDT01=='' || $MV_strDT02==''){
  echo "<font color=red><b>Data is empty!</b></font>";
}else if($MV_strDT01!='' && $MV_strDT02!=''){
  
  $str_check="SELECT `LISTVALUE`, `SORT`, `LISTNAME`, `DESCRIPTION`, `CATEGORY`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_all_selectlist` where `CATEGORY`<>'OS' and `LISTNAME`='".$MV_strDT01."'";
  $check_cmd=mysqli_query($link_db,$str_check);
  $check_record=mysqli_fetch_row($check_cmd);
  if(empty($check_record)):
     
	 $str_inst="INSERT INTO `c_all_selectlist`(`LISTVALUE`, `SORT`, `LISTNAME`, `DESCRIPTION`, `CATEGORY`, `STATUS`) VALUES ('".$MV_strDT01."',0,'".$MV_strDT02."','".$MV_strDT03."','".$MV_strDT04."',1);";
	 $inst_cmd=mysqli_query($link_db,$str_inst);
	 echo "refresh";
	 
  else:
  echo "<font color=red><b>Data is exist!</b></font>";
  endif;
}
mysqli_close($link_db);
?>