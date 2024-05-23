<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MV_str01=$_POST['MV_str01'];
$MV_str02=$_POST['MV_str02'];

$str_New="select `ID` from `c_sp_memory_type` order by `ID` desc limit 1";
$check_New=mysqli_query($link_db,$str_New);
$Max_COptionID=mysqli_fetch_row($check_New);
$MCount=$Max_COptionID[0]+1;


if($MV_str01=='' || $MV_str02==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MV_str01<>'' && $MV_str02<>''){

   $str_chk="SELECT `ID` FROM `c_sp_memory_type` where `MEMORYTYPE`='".$MV_str01."' and `DESCRIPTION`='".$MV_str02."' and `STATUS`=1";
   $chk_cmd=mysqli_query($link_db,$str_chk);
   $chk_record=mysqli_fetch_row($chk_cmd);
   
   if(empty($chk_record)):        

	  $str_val="insert into `c_sp_memory_type` (`ID`, `MEMORYTYPE`, `DESCRIPTION`, `STATUS`) values (".$MCount.",'".$MV_str01."','".$MV_str02."','1')";
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";
	  
   else:
   echo "<font color=red><b>Data be exist!</b></font>";
   endif;
}
mysqli_Close($link_db);
?>