<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if(isset($_POST['kind'])!==''){
$kind=filter_var($_POST['kind']);
}else{
$kind="";
}

if(isset($_POST['MID'])!==''){
$mid=filter_var($_POST['MID']);
}else{
$mid="";
}

if(isset($_POST['edit_CMPT'])!==''){
$edit_CMPT=filter_var($_POST['edit_CMPT']);
}else{
$edit_CMPT="";
}

if(isset($_POST['edit_Order'])!==''){
$edit_Order=filter_var($_POST['edit_Order']);
}else{
$edit_Order="";
}

$str_val="UPDATE c_sp_cmpt SET Name='".$edit_CMPT."', CMPT_Order='".$edit_Order."', U_DATE='".$now."' WHERE ID='".$mid."' AND Type='".$kind."'";
if(mysqli_query($link_db,$str_val)){
   echo "refresh";    
}else{
   echo "error";
}
mysqli_Close($link_db);
exit();
?>