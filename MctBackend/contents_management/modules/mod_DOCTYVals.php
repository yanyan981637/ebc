<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_id=$_POST['MValue_id'];
$MVm_str01=$_POST['MVm_str01'];

$MyFilem=$_FILES['MyFilem']['name'];

if(($MyFilem != "none" && $MyFilem != "")){   
   $UploadPath = "../../../images/";
   $flag = copy($_FILES['MyFilem']['tmp_name'], $UploadPath.basename($_FILES['MyFilem']['name']));  
   if($flag) echo "";   
   $url="./images/";   
}else{   
   $url="";
}

if($MVm_str01==''){
  echo "<font color='red'><b>Data be empty!</b></font>";
}else if($MVm_str01!=''){
  if($MyFilem != "none" && $MyFilem != ""){
  $str_upd="update `c_sp_itemlist` set `NAME`='".$MVm_str01."' and `IMG`='$url$MyFilem' where `ID`=".$MValue_id;
  }else{
  $str_upd="update `c_sp_itemlist` set `NAME`='".$MVm_str01."' where `ID`=".$MValue_id;
  }
  $upd_cmd=mysqli_query($link_db,$str_upd);
  echo "refresh";
}
mysqli_Close($link_db);
?>