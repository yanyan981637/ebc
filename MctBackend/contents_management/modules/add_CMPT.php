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

if(isset($_POST['add_CMPT'])!==''){
$add_CMPT=filter_var($_POST['add_CMPT']);
}else{
$add_CMPT="";
}

if(isset($_POST['add_Order'])!==''){
$add_Order=filter_var($_POST['add_Order']);
}else{
$add_Order="";
}

$str_val="INSERT INTO c_sp_cmpt (Name, Type, CMPT_Order, C_DATE) values ('".$add_CMPT."','".$kind."','".$add_Order."','$now')";
if(mysqli_query($link_db,$str_val)){
   echo "refresh";    
}else{
   echo "error";
}
mysqli_Close($link_db);
exit();
?>