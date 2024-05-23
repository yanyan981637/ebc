<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_Dnum01=$_POST['MValue_Dnum'];
$MVm_strDT01=htmlspecialchars($_POST['MVm_strDT01'], ENT_QUOTES);
$MVm_strDT02=htmlspecialchars($_POST['MVm_strDT02'], ENT_QUOTES);
//$MVm_strDT03=htmlspecialchars($_POST['MVm_strDT03'], ENT_QUOTES);
$MVm_strDT03=trim(str_replace("'","''",$_POST['MVm_strDT03']));
$MVm_strDT04=htmlspecialchars($_POST['MVm_strDT04'], ENT_QUOTES);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H;i:s");

if($MVm_strDT01=='' || $MVm_strDT02=='' || $MVm_strDT04==''){
  echo "<font color=red><b>Data is empty!</b></font>";
}else if($MValue_Dnum01!='' && $MVm_strDT02!='' && $MVm_strDT04!=''){
  
  //$str_chk="SELECT `LISTVALUE` FROM `c_all_selectlist` where `CATEGORY`<>'OS' and `LISTNAME`='".$MVm_strDT02."'";
  $str_chk="SELECT `LISTVALUE` FROM `c_all_selectlist` where `CATEGORY`='".$MVm_strDT04."' and `LISTNAME`='".$MVm_strDT02."'";
  $chk_cmd=mysqli_query($link_db,$str_chk);
  $chk_record=mysqli_fetch_row($chk_cmd);
  if(empty($chk_record)):	
  else:
    $str_upd="UPDATE `c_all_selectlist` SET `DESCRIPTION`='".$MVm_strDT03."',`CATEGORY`='".$MVm_strDT04."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."' WHERE `CATEGORY`<>'OS' and `LISTVALUE`='".$MVm_strDT01."'";
	$upd_cmd=mysqli_query($link_db,$str_upd);
    echo "refresh";
    //echo "<font color=red><b>Data be exist!</b></font>";
  endif;
}
mysqli_close($link_db);
?>