<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$NM1=$_POST['MN_01'];
$NM2=$_POST['MN_02'];
$NM3=$_POST['MN_03'];

if($NM2==''){
echo "<font color=red><b>Data be empty!</b></font>";
}else{
if(function_exists('com_create_guid')){
    $guid = com_create_guid();
}else{
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = chr(123)// "{"
           .substr($charid, 0, 8).$hyphen
           .substr($charid, 8, 4).$hyphen
           .substr($charid,12, 4).$hyphen
           .substr($charid,16, 4).$hyphen
           .substr($charid,20,12)
           .chr(125);// "}"
    $guid = $uuid;
}
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str_m="select ModelID FROM product_models order by ModelID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;

$str_checkm="select ModelCode,ProductCateID from product_models where ModelCode='".$NM2."' and ProductCateID=".$NM3;
$checkm_cmd=mysqli_query($link_db,$str_checkm);
$record_checkm=mysqli_fetch_row($checkm_cmd);
if(empty($record_checkm)):
  setcookie("NM002",$NM2,time()+3600);  
  $str="insert into product_models (ModelID,ModelName,ModelCode,ProductCateID,GUID,crea_d,crea_u) values ($MCount,'$NM1','$NM2',$NM3,'$guid','$now','1782')";
  $cmd_model=mysqli_query($link_db,$str);
  echo "refresh";
else:
  echo "<font color=red><b>Data be exist!</b></font>";
endif;

}
mysqli_close($link_db);
?>