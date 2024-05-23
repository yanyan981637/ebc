<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_id=$_POST['MValue_id'];
$MVm_str01=htmlspecialchars($_POST['MVm_str01'], ENT_QUOTES);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H;i:s");

if($MVm_str01==''){
	echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01!=''){
   $str_chk="SELECT `ID` FROM `c_sp_hdd_size` where `HDDSIZE`='".$MVm_str01."'";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):        

	  $str_val="update `c_sp_hdd_size` set `HDDSIZE`='".$MVm_str01."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='$now',`STATUS`='1' where `ID`=".$MValue_id;
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";
	  
   else:
   echo "<font color=red><b>Data be exist!</b></font>";
   endif;
}
mysqli_close($link_db);
?>