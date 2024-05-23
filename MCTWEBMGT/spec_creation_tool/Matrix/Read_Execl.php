<?php
header('Content-Type: text/html; charset=utf-8');
require_once './reader.php';
require "./config.php";
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" src="./jquery.min.js"></script>

</head>
<body>
<br />
<div id="Div1">
<form action="?type=upload" name="form1" id="form1" method="post" enctype="multipart/form-data">
<input type="file" id="MyFile" name="MyFile" size="20" /><input id="MNBtn" type="submit" value="Done" />
</form>
</div>

<?php

if($_REQUEST['type']=='upload'){

 
  /*
  $str_m="select MaxtrixID FROM prdouct_matrix_all order by MaxtrixID desc limit 1";
  $check_m=mysqli_query($link_db,$str_m);
  $Max_PMaxtrixID=mysqli_fetch_row($check_m);
  $MCount=$Max_PMaxtrixID[0]+1;
  */
  


  $MyFile=$_FILES['MyFile']['name'];
  
  if ($MyFile != "none" && $MyFile != "") {

  $UploadPath = "./tmp_doc/";
  $flag = copy($_FILES['MyFile']['tmp_name'], $UploadPath.$_FILES['MyFile']['name']);
  //$_SESSION['doc_url'] = $UploadPath.$MyFile;
  $file_a = $UploadPath.$MyFile;
  }
echo "<br /><br />";  
  
$data = new Spreadsheet_Excel_Reader(); 
$data->setOutputEncoding('utf-8');
$data->read($file_a);
$conn= mysqli_connect($db_host,$db_user,$db_pwd) or die("Can not connect to database.");  
mysqli_query("set names 'utf-8'");//設定編碼輸出

mysqli_select_db($dataBase, $conn);

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
  
  $str_m="select MaxtrixID FROM prdouct_matrix_all order by MaxtrixID desc limit 1";
  $check_m=mysqli_query($link_db,$str_m,$conn);
  $Max_PMaxtrixID=mysqli_fetch_row($check_m);
  $MCount=$Max_PMaxtrixID[0]+1;
  
  //$sql = "INSERT INTO product_martix_all (`MaxtrixID`,`SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `CPU_QPI`, `Chipset`, `PCIx`, `PCI`, `PCIe`, `Mem_Max`, `Mem_Type`, `IFeatures_A`, `IFeatures_G`, `IFeatures_N`, `IFeatures_R`, `Sr_Mgt`, `RHS_typ`) VALUES ($MCount,$data->sheets[0]['cells'][$i][1],'".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."','".$data->sheets[0]['cells'][$i][7]."','".$data->sheets[0]['cells'][$i][8]."','".$data->sheets[0]['cells'][$i][9]."','".$data->sheets[0]['cells'][$i][10]."','".$data->sheets[0]['cells'][$i][11]."','".$data->sheets[0]['cells'][$i][12]."','".$data->sheets[0]['cells'][$i][13]."','".$data->sheets[0]['cells'][$i][14]."','".$data->sheets[0]['cells'][$i][15]."','".$data->sheets[0]['cells'][$i][16]."','".$data->sheets[0]['cells'][$i][17]."')"; 
  $sql = "INSERT INTO `prdouct_matrix_all` (`MaxtrixID`,`SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `CPU_QPI`, `Chipset`, `PCIx`, `PCI`, `PCIe`, `Mem_Max`, `Mem_Type`, `IFeatures_A`, `IFeatures_G`, `IFeatures_N`, `IFeatures_R`, `Sr_Mgt`, `RHS_typ`) VALUES (".$MCount.",".$data->sheets[0]['cells'][$i][1].",'".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."','".$data->sheets[0]['cells'][$i][7]."','".$data->sheets[0]['cells'][$i][8]."','".$data->sheets[0]['cells'][$i][9]."','".$data->sheets[0]['cells'][$i][10]."','".$data->sheets[0]['cells'][$i][11]."','".$data->sheets[0]['cells'][$i][12]."','".$data->sheets[0]['cells'][$i][13]."','".$data->sheets[0]['cells'][$i][14]."','".$data->sheets[0]['cells'][$i][15]."','".$data->sheets[0]['cells'][$i][16]."','".$data->sheets[0]['cells'][$i][17]."')"; 
  //$sql = "INSERT INTO product_martix_all (`SocketR_NameID`, `ModelCode`, `SKU`, `FormFactor`, `CPU_QPI`, `Chipset`, `PCIx`, `PCI`, `PCIe`, `Mem_Max`, `Mem_Type`, `IFeatures_A`, `IFeatures_G`, `IFeatures_N`, `IFeatures_R`, `Sr_Mgt`, `RHS_typ`) VALUES (".$data->sheets[0]['cells'][$i][1].",'".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','','','','','','','".$data->sheets[0]['cells'][$i][10]."','','','','','','','')";
  //$sql = "INSERT INTO `prdouct_matrix_all` (`SocketR_NameID`, `ModelCode`, `SKU`) VALUES (".$data->sheets[0]['cells'][$i][1].", '".$data->sheets[0]['cells'][$i][2]."', '".$data->sheets[0]['cells'][$i][3]."')";
  $query=mysqli_query($link_db,$sql,$conn);
  
  
  echo $data->sheets[0]['cells'][$i][1]."-".$data->sheets[0]['cells'][$i][2]."-".$data->sheets[0]['cells'][$i][3]."-".$data->sheets[0]['cells'][$i][4]."-".$data->sheets[0]['cells'][$i][5]."-".$data->sheets[0]['cells'][$i][6]."-".$data->sheets[0]['cells'][$i][7]."-".$data->sheets[0]['cells'][$i][8]."-".$data->sheets[0]['cells'][$i][9]."-".$data->sheets[0]['cells'][$i][10]."-".$data->sheets[0]['cells'][$i][11]."-".$data->sheets[0]['cells'][$i][12]."-".$data->sheets[0]['cells'][$i][13]."-".$data->sheets[0]['cells'][$i][14]."-".$data->sheets[0]['cells'][$i][15]."-".$data->sheets[0]['cells'][$i][16]."-".$data->sheets[0]['cells'][$i][17]."<br />";
  
}

}
?>
</body>
</html>