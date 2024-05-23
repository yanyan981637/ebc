<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase);

$str1="SELECT `SKUs_Mid`, `SKUs_MiName` FROM `skus_mainsub` order by SKUs_Mid desc limit 1";
$cmd1=mysqli_query($link_db,$str1);
$record_id=mysqli_fetch_row($cmd1);
$MCount=$record_id[0]+1;

$val01=$_POST['CON_01'];

if($val01!=''){
 $str_s="insert into `skus_mainsub` (`SKUs_Mid`, `SKUs_MiName`, `IsShow`) values (".$MCount.",'".$val01."','1')";
 $scmd=mysqli_query($link_db,$str_s);
 echo "refresh";
}else{
 echo "<font color=red>Please input Data!</font>";
}
 mysqli_close($link_db);
?>