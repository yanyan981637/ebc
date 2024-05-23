<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_POST['MValue_id'])!=''){
$MValue_id=intval($_POST['MValue_id']);
}else{
$MValue_id="";
}
if(isset($_POST['MVm_str01'])!=''){
$MVm_str01=trim($_POST['MVm_str01']);
}else{
$MVm_str01="";
}
if(isset($_POST['MVm_str02'])!=''){
$MVm_str02=trim($_POST['MVm_str02']);
}else{
$MVm_str02="";
}
if(isset($_POST['MVm_str03'])!=''){
$MVm_str03=trim($_POST['MVm_str03']);
}else{
$MVm_str03="";
}
if(isset($_FILES['MyFilem']['name'])!=''){
$MyFilem=$_FILES['MyFilem']['name'];
}else{
$MyFilem="";
}
if(isset($_POST['MVm_str04'])!=''){
$MVm_str04=trim($_POST['MVm_str04']);
$MVm_str04=str_replace(" ","&nbsp;",$MVm_str04);
}else{
$MVm_str04="";
}


if($MyFilem != "none" && $MyFilem != ""){   
   $UploadPath = "../../../images/logo/";
   $flag = copy($_FILES['MyFilem']['tmp_name'], $UploadPath.basename($_FILES['MyFilem']['name'])) or die("無法複製檔案");
   //$flag = move_uploaded_file($_FILES['MyFilem']['tmp_name'], iconv("utf-8", "big5", $UploadPath.basename($_FILES['MyFilem']['name'])));
   
   if($flag) echo "";   
   $url="./images/logo/";   
}else{   
   $url="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($MVm_str01=='' || $MVm_str02=='' || $MVm_str03==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01<>'' && $MVm_str02<>'' && $MVm_str03<>''){
	  if($MyFilem!=''){
	  $str_val="UPDATE `c_sp_icon` SET `icon_name`='".$MVm_str01."',`img`='$url$MyFilem',`tooltips`='$MVm_str04',`url`='".$MVm_str02."',`update_user`='admin',`update_date`='".$now."',`order`='".$MVm_str03."' where `id`=".$MValue_id;
	  }else{
	  $str_val="UPDATE `c_sp_icon` SET `icon_name`='".$MVm_str01."',`tooltips`='$MVm_str04',`url`='".$MVm_str02."',`update_user`='admin',`update_date`='".$now."',`order`='".$MVm_str03."' where `id`=".$MValue_id;
	  }
	  $val_cmd=mysqli_query($link_db,$str_val);
	  echo "refresh";	  
}
mysqli_Close($link_db);
?>