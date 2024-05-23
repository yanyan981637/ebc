<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MV_str01=$_POST['MV_str01'];

$str_Mcount="select `ID` from `document_type` order by `ID` desc limit 1";
$Mcount_cmd=mysqli_query($link_db,$str_Mcount);
$Mcount_Val=mysqli_fetch_row($Mcount_cmd);
$Mcount=$Mcount_Val[0]+1;

if($MV_str01==''){
echo "<font color=red><b>Data be empty!</b></font>";
}else if($MV_str01!=''){
  
  $str_chk="select `TYPE_NAME` from `document_type` where `TYPE_NAME`='".$MV_str01."'";
  $chk_cmd=mysqli_query($link_db,$str_chk);
  $chk_record=mysqli_fetch_row($chk_cmd);
  
  if(empty($chk_record)):
    $str_inst="INSERT INTO `document_type`(`ID`, `TYPE_NAME`, `STATUS`) VALUES (".$Mcount.",'".$MV_str01."','1')";
    $inst_cmd=mysqli_query($link_db,$str_inst);
    echo "refresh";
  else:
    echo "<font color='red'><b>Data be exist!</b></font>";
  endif;
}
mysqli_Close($link_db);
?>