<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

error_reporting(0);

if(isset($_REQUEST['Category'])!=''){
  $Category=$_REQUEST['Category'];
}else{
  $Category="";
}
if(isset($_REQUEST['Type'])!=''){
  $Type=$_REQUEST['Type'];
}else{
  $Type="";
}
if(isset($_REQUEST['TType'])!=''){
  $TType=$_REQUEST['TType'];
}else{
  $TType="";
}

if(isset($_REQUEST['Value'])!=''){
  $Value=intval($_REQUEST['Value']);
}else{
  $Value="";
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

$str_Option="SELECT * FROM `specoptions` WHERE `SPECOptionID` = '".$Value."'";
$Option_result=mysqli_query($link_db,$str_Option);
$Option_data=mysqli_fetch_row($Option_result);
//$SPECTypeID = $Option_data[1];
$Option_value = $Option_data[2];

//找value套用那些Product_SKU_Auto_ID
$str_skuID="SELECT DISTINCT `Product_SKU_Auto_ID` FROM `specvalues` WHERE `SPECValue` like '%".$Value."%'";
$skuID_result=mysqli_query($link_db,$str_skuID);
$i=0;
while ($skuID_data=mysqli_fetch_row($skuID_result)) {
  $skuID[$i] = $skuID_data[0];
  $i++;
}
//print_r($skuID);
for ($j=0; $j < $i ; $j++) { 
  //找SKU
  $Product_ID = $skuID[$j];
  $str_productID="SELECT * FROM `contents_product_skus` WHERE `Product_SContents_Auto_ID` = '".$Product_ID."' and slang = 'EN,' ";
  $productID_result=mysqli_query($link_db,$str_productID);
  $productID_data=mysqli_fetch_row($productID_result);
  $arraysku[$j] = $productID_data[3];
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$ptype?></title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<style type="text/css">
table{border:1px solid #c0c0c0; width:100%}
thead{background:#00a0e9; color:#fff; font-weight:bolder;padding:5px 15px;}
td{ padding:5px 15px;}
td.two{padding-left:50px}
tr{  cursor: pointer; }
tr:hover{background: #dcf2fd;}
tbody:nth-child(even) {
	background: #f8f8f8;
	}
</style>

<script language="JavaScript">


</script>
</head>

<body style="backbround:#f9f9f9">
  <div>
    <div>
      <table><thead><tr><td ></td></tr></thead></table></div>
      <div>
        <table>
          <tr>
            <td>Category</td>
            <td>(Top Type) Type</td>
            <td>Value</td>
          </tr>
          <tr>
            <td><?=$Category?></td>
            <?php
            if ($TType!=null) {
                echo "<td>(".$TType.")".$Type."</td>";
            }else{
                echo "<td>".$Type."</td>";
            }
            ?>
            <td><?=$Option_value?></td>
          </tr>
          <tr>
            <td colspan="2">
              <?php
              $skus_count;
              /*$str_skus = "SELECT SKU FROM `contents_product_skus` WHERE `Product_Info` LIKE '%".$SPECTypeID."%'";
              $result_skus=mysqli_query($link_db,$str_skus, $link_db);
              while ($skus_data=mysqli_fetch_row($result_skus)) {
                $skus_count .= $skus_data[0]."<br>";
              }*/
              for ($k=0; $k < $j ; $k++) { 
                $SKUsname = $arraysku[$k];
                $skus_count.= $SKUsname."<br>";
              }
              echo $skus_count;
              ?>
            </td>
          </tr>
        </table>
      </div>
</div>


</body>
</html>
<?php
mysqli_close($link_db);
?>