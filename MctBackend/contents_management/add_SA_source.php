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

if(isset($_POST['a_s_name'])!==''){
$a_s_name=filter_var($_POST['a_s_name']);
}else{
$a_s_name="";
}

if(isset($_POST['a_s_URL'])!==''){
$a_s_URL=filter_var($_POST['a_s_URL']);
}else{
$a_s_URL="";
}

$str_val="INSERT INTO dsg_sa_source (Name, URL, C_DATE) values ('".$a_s_name."','".$a_s_URL."','$now')";
if(mysqli_query($link_db,$str_val)){
   echo "refresh";    
}else{
   echo "error";
}
mysqli_Close($link_db);
exit();
?>