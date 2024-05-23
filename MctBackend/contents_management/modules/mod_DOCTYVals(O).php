<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_id=$_POST['MValue_id'];
$MVm_str01=$_POST['MVm_str01'];

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($MVm_str01==''){
  echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01!=''){  
  $str_upd="update `document_type` set `TYPE_NAME`='".$MVm_str01."' where `ID`=".$MValue_id;
  $upd_cmd=mysqli_query($link_db,$str_upd);
  echo "refresh";
}
mysqli_Close($link_db);
?>