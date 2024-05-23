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
//$select=mysqli_select_db($dataBase, $link_db);

$MV_strOS01=htmlspecialchars($_POST['MV_strOS01'], ENT_QUOTES);

//$str_new="select `LISTVALUE` FROM `c_all_selectlist` where `CATEGORY`='OS' order by `LISTVALUE` desc limit 1";
$str_new="select `LISTVALUE` FROM `c_all_selectlist` where `CATEGORY`='OS' order by CAST(`LISTVALUE` AS UNSIGNED) desc limit 1";
$Check_new=mysqli_query($link_db,$str_new);
$Max_OS=mysqli_fetch_row($Check_new);
$MCount=intval($Max_OS[0])+1;

$str_sort="select `SORT` FROM `c_all_selectlist` where `CATEGORY`='OS' order by `SORT` desc limit 1";
$Check_sort=mysqli_query($link_db,$str_sort);
$Max_sort=mysqli_fetch_row($Check_sort);
$SRCount=$Max_sort[0]+1;

if($MV_strOS01=='' || empty($MV_strOS01)){
  echo "<font color=red><b>Data is empty!</b></font>";
}else if($MV_strOS01!=''){
  
  $str_check="SELECT `LISTVALUE`, `SORT`, `LISTNAME`, `DESCRIPTION`, `CATEGORY`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `c_all_selectlist` where `LISTNAME`='".$MV_strOS01."'";
  $check_cmd=mysqli_query($link_db,$str_check);
  $check_record=mysqli_fetch_row($check_cmd);
  if(empty($check_record)):
     
	 $str_inst="INSERT INTO `c_all_selectlist`(`LISTVALUE`, `SORT`, `LISTNAME`, `DESCRIPTION`, `CATEGORY`, `STATUS`) VALUES ('".$MCount."',".$SRCount.",'".$MV_strOS01."','".$MV_strOS01."','OS',1);";
	 $inst_cmd=mysqli_query($link_db,$str_inst);
	 echo "refresh";
	 
  else:
  echo "<font color=red><b>Data is exist!</b></font>";
  endif;
}
mysqli_close($link_db);
?>