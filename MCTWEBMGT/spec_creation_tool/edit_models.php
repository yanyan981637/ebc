<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$MName1=$_POST['MN'];
$modelID=$_POST['MID'];
$S_model=$_POST['S_model'];
$Sku=$_POST['skuvalue'];
$PCateID=$_POST['PCateID'];

/*if($NM2==''){
echo "<font color=red><b>Data be empty!</b></font>";
}*/

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
//******** product_models 與 vw_modelname 連動 ************
$select =  "SELECT * FROM `product_models` WHERE `ModelCode`='".$S_model."' and `SKU`='".$Sku."' and `ProductCateID`='".$PCateID."' ";
$cmdselect=mysqli_query($link_db,$select);
if(mysqli_num_rows($cmdselect) < 1){
	$insert = "INSERT INTO `product_models`(ModelName, ModelCode, SKU, ProductCateID, crea_d) VALUES ('".$MName1."', '".$S_model."', '".$Sku."', '".$PCateID."', '".$now."')";
	$cmd=mysqli_query($link_db,$insert);
	echo "refresh";
} else {
	$str = "update product_models set ModelName='".$MName1."', upd_d='".$now."' where ModelID='".$modelID."' and ModelCode='".$S_model."' and `SKU`='".$Sku."'";
	$cmd=mysqli_query($link_db,$str);
	//$record_checkm=mysqli_fetch_row($cmd);
	if(mysqli_num_rows($cmd)!=""){
	  echo "refresh";
	}else{
	  echo "Edit Failure";
	}
}


mysqli_close($link_db);
?>