<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

error_reporting(0);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$kind=$_POST['kind'];
$SID=$_POST['SID'];
$MID=$_POST['MID'];
$pID=$_POST['pID'];
$Mname=$_POST['Mname'];


if($kind == "add"){
	$insert = "INSERT INTO skus_sublist (SKUs_Mid, SKUs_Mname, ProductTypeID) VALUES ('".$MID."', '".$Mname."', '".$pID."')";
    $insert_result=mysqli_query($link_db,$insert);
    $num=mysqli_num_rows($insert_result);
    if($num != "0"){
    	echo "susses";
    }else{
    	echo "failure";
    }   
}

if($kind == "edit"){
    //*****update spec 套用sku 的 value**********
    $str_msub = "SELECT * FROM `skus_mainsub` WHERE `SKUs_Mid`='".$MID."'";
    $cmd_msub=mysqli_query($link_db,$str_msub);
    $msub_data=mysqli_fetch_row($cmd_msub);
    if($msub_data[1] == "Networking"){
        $msub="Networking";
    }elseif ($msub_data[1] == "SAS") {
        $msub="SAS";
    }elseif ($msub_data[1] == "Form Factor") {
        $msub="FormFactor";
    }elseif ($msub_data[1] == "PCI-E slot") {
        $msub="PCI-E_slot";
    }elseif ($msub_data[1] == "HDD Bay") {
        $msub="HDD_Bay";
    }elseif ($msub_data[1] == "PSU") {
        $msub="PSU";
    }elseif ($msub_data[1] == "Host I/F") {
        $msub="Host_IF";
    }elseif ($msub_data[1] == "Conn. Type") {
        $msub="Conn_Type";
    }elseif ($msub_data[1] == "Conn. Qty") {
        $msub="Conn_Qty";
    }elseif ($msub_data[1] == "FAN") {
        $msub="FAN";
    }elseif ($msub_data[1] == "Chip") {
        $msub="Chip";
    }
    $str = "SELECT a.SKU, a.MODELCODE, b.SKUs_Mname FROM `product_skus` a INNER JOIN `skus_sublist` b on a.`ProductTypeID`=b.`ProductTypeID` WHERE b.`SKUs_Sid`='".$SID."' and b.`SKUs_Mid`='".$MID."' AND a.`".$msub."`=b.`SKUs_Mname`";
    $cmd=mysqli_query($link_db,$str);
    while ($cmd_data=mysqli_fetch_row($cmd)) {
        $SKU_update = "UPDATE product_skus SET `".$msub."`='".$Mname."' WHERE SKU='".$cmd_data[0]."' and MODELCODE='".$cmd_data[1]."'";
        $SKUup_result=mysqli_query($link_db,$SKU_update);
    }
    //*******************************************

    $update = "UPDATE skus_sublist SET SKUs_Mname='".$Mname."' WHERE SKUs_Sid='".$SID."'";
    $update_result=mysqli_query($link_db,$update);
    $num=mysqli_num_rows($update_result);


    if($num != "0"){
    	echo "susses";
    }else{
    	echo "failure";
    } 
}


if($kind == "search"){
    $str_msub = "SELECT * FROM `skus_mainsub` WHERE `SKUs_Mid`='".$MID."'";
    $cmd_msub=mysqli_query($link_db,$str_msub);
    $msub_data=mysqli_fetch_row($cmd_msub);
    if($msub_data[1] == "Networking"){
        $msub="Networking";
    }elseif ($msub_data[1] == "SAS") {
        $msub="SAS";
    }elseif ($msub_data[1] == "Form Factor") {
        $msub="FormFactor";
    }elseif ($msub_data[1] == "PCI-E slot") {
        $msub="PCI-E_slot";
    }elseif ($msub_data[1] == "HDD Bay") {
        $msub="HDD_Bay";
    }elseif ($msub_data[1] == "PSU") {
        $msub="PSU";
    }elseif ($msub_data[1] == "Host I/F") {
        $msub="Host_IF";
    }elseif ($msub_data[1] == "Conn. Type") {
        $msub="Conn_Type";
    }elseif ($msub_data[1] == "Conn. Qty") {
        $msub="Conn_Qty";
    }elseif ($msub_data[1] == "FAN") {
        $msub="FAN";
    }elseif ($msub_data[1] == "Chip") {
        $msub="Chip";
    }

	$str = "SELECT a.SKU, a.MODELCODE, b.SKUs_Mname FROM `product_skus` a INNER JOIN `skus_sublist` b on a.`ProductTypeID`=b.`ProductTypeID` WHERE b.`SKUs_Sid`='".$SID."' and b.`SKUs_Mid`='".$MID."' AND a.`".$msub."`=b.`SKUs_Mname`";
	$cmd=mysqli_query($link_db,$str);
    $result="<tr><td>SKU</td><td>MODELCODE</td><td>SKUs_Mname</td></tr>";
	while($sku_data=mysqli_fetch_row($cmd)){
		$i="<tr><td>".$sku_data[0]."</td><td>".$sku_data[1]."</td><td>".$sku_data[2]."</td></tr>";
		$result.=$i;
	}
  	echo $result;
}

mysqli_close($link_db);
?>