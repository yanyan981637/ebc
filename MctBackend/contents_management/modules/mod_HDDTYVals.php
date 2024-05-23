<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_POST['MValue_id'])!=''){
$MValue_id=intval($_POST['MValue_id']);
}

if(isset($_POST['MVm_str01'])!=''){
//$MVm_str01=htmlspecialchars($_POST['MVm_str01'], ENT_QUOTES); //2017.10.26 註解特殊符號轉代碼
$MVm_str01=$_POST['MVm_str01'];
}else{
$MVm_str01="";
}

if(isset($_POST['MVm_status01'])!=''){
$MVm_status01=trim($_POST['MVm_status01']);
}else{
$MVm_status01="0";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($MVm_str01==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01<>''){

   $str_upd="UPDATE `c_sp_hdd_type` SET `HDDTYPE`='".$MVm_str01."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='$now',`STATUS`='".$MVm_status01."' where `ID`=".$MValue_id;
   $upd_cmd=mysqli_query($link_db,$str_upd);
   echo "refresh";
   
}
mysqli_close($link_db);
?>