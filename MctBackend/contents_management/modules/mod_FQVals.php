<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MValue_id=$_POST['MValue_id'];
$MVm_str01=$_POST['MVm_str01'];
$MVm_str01hid=$_POST['MVm_str01hid'];
$MVm_str02=$_POST['MVm_str02'];
$mod_order=$_POST['mod_order'];

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($MVm_str01=='' || $MVm_str02==''){
   echo "<font color=red><b>Data be empty!</b></font>";
}else if($MVm_str01<>'' && $MVm_str02<>''){

	$str="select * from sp_memory where `MEMORY_FREQUENCE` = '".$MVm_str01hid."'";
	$cmd=mysqli_query($link_db,$str);
	$i=0;
	$mod=array();
	while ($result = mysqli_fetch_row($cmd)) {
		$mod[$i]=$result[0];
		$i++;
	}
	$count = $i;
	//echo $count;
	for ($j=0; $j <= $i; $j++) { 
		$spID = $mod[$j];
		$sp_memory = "UPDATE `sp_memory` SET `MEMORY_FREQUENCE`='".$MVm_str01."' WHERE `ID` = '".$spID."' ";
		$cmd2=mysqli_query($link_db,$sp_memory);
	}

	$str_val="UPDATE `c_sp_memory_frequence` SET `FREQUENCE`='".$MVm_str01."',`DESCRIPTION`='".$MVm_str02."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."',`STATUS`=1,`Order_val`='".$mod_order."' where `ID`=".$MValue_id;
	$val_cmd=mysqli_query($link_db,$str_val);
	echo "refresh";	 
}
mysqli_Close($link_db);
?>