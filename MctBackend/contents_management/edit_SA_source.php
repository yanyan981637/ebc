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

if(isset($_POST['id'])!==''){
$mid=filter_var($_POST['id']);
}else{
$mid="";
}

if(isset($_POST['edit_sourceN'])!==''){
$edit_sourceN=filter_var($_POST['edit_sourceN']);
}else{
$edit_sourceN="";
}
if(isset($_POST['edit_sourceU'])!==''){
$edit_sourceU=filter_var($_POST['edit_sourceU']);
}else{
$edit_sourceU="";
}

$str_val="UPDATE dsg_sa_source SET Name='".$edit_sourceN."', URL='".$edit_sourceU."', U_DATE='".$now."' WHERE ID='".$mid."'";
if(mysqli_query($link_db,$str_val)){
  echo "refresh";  
}else{
  echo "error";
}
mysqli_Close($link_db);
exit();
?>