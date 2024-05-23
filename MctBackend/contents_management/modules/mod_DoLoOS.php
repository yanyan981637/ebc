<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_num01=$_POST['MValue_num'];
$MVm_strOS01=htmlspecialchars($_POST['MVm_strOS01'], ENT_QUOTES);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H;i:s");

if($MValue_num01!='' && $MVm_strOS01==''){
  echo "<font color=red><b>Data is empty!</b></font>";
}else if($MValue_num01!='' && $MVm_strOS01!=''){
  
  $str_chk="SELECT `LISTVALUE` FROM `c_all_selectlist` where `CATEGORY`='OS' and `LISTNAME`='".$MVm_strOS01."'";
  $chk_cmd=mysqli_query($link_db,$str_chk);
  $chk_record=mysqli_fetch_row($chk_cmd);
  if(empty($chk_record)):
	$str_upd="UPDATE `c_all_selectlist` SET `LISTNAME`='".$MVm_strOS01."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."' WHERE `CATEGORY`='OS' and `LISTVALUE`='".$MValue_num01."'";
    $upd_cmd=mysqli_query($link_db,$str_upd);
    echo "refresh";
  else:
    echo "<font color=red><b>Data be exist!</b></font>";
  endif;
}
mysqli_close($link_db);
?>