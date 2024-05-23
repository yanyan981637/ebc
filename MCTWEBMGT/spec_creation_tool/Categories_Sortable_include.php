<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

$a='"';$itam_all="";
if($_GET['cate']!=''){
foreach ($_GET['cate'] as $position => $item) :
$sql[] = "UPDATE `speccategroies` SET `SPECCategorySort` = $position WHERE `SPECCategoryID` = $item";
$itam_all.=$item.",";
endforeach; 
setcookie("categor_cookie".$_REQUEST['PType_id'],$itam_all,time()+1800); //set cookie 約 1800 Sec

  for($i=0;$i<count($sql);$i++){  
  $cmd=mysqli_query($link_db,$sql[$i]);  
  }
  mysqli_close($link_db);
}
?>