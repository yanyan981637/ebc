<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if($_REQUEST['type']=='edit'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$m00=$_POST['M00'];
$m0=$_POST['M0'];
$m1=$_POST['M1'];
$sr1=$_POST['SR1'];
$sr2=$_POST['SR2'];
$guid = com_create_guid();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

foreach($_POST['prosku'] as $check) {
$prosku=$prosku.$check.",";
}
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 
 
$str_mar_c="update product_matrix_categories set `ProductTypeID`=$m0, `Page_Status`='$sr1',`Matrix_CategoryName`='$m1',`IsStatus`='$sr2',`Matrix_SKUs`='$prosku' where `Product_Matrix_Cid`=".$m00;
$cmd_mar_c=mysqli_query($link_db,$str_mar_c);

echo "<script>alert('Mod product Matrix!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
mysqli_close($link_db);
}

  $p_marx=$_REQUEST['pr_id'];
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_matr_m="select * from product_matrix_categories where Product_Matrix_Cid=".$p_marx;
  $cmd_matr_m=mysqli_query($link_db,$str_matr_m);
  $record_matr_m=mysqli_fetch_row($cmd_matr_m);
  
  if(empty($record_matr_m)):

  else:
    $MA0=$record_matr_m[1];
    $MA1=$record_matr_m[2];
    $MA2=$record_matr_m[3];
    $MA3=$record_matr_m[4];
    $MA4=$record_matr_m[5];
  endif;


if($_REQUEST['SType_id']==""){
$SType_id=$MA0;
}else{
$SType_id=$_REQUEST['SType_id'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Tool - Edit a product Matrix categories</title>
<script language="JavaScript">
function MM_ST(selObj){
window.open(document.all.SM1.options[document.all.SM1.selectedIndex].value,"_self");
}
</script>
</head>

<body>
<form action="?type=edit" name="form1" method="POST" onsubmit="return Final_Check();">
<table border="0" cellspacing="1" cellpadding="4" align="center" id="table1" bgcolor="darkgreen">
<tr bgcolor="Aquamarine">
<td align="center">Product Type</td>
<td>
<select id="SM1" onChange="MM_ST(this)">
<option value="">Select...</option>
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_type1="select ProductTypeID,ProductTypeName from ProductTypes where ProductTypeID=".$SType_id;
$type_result1=mysqli_query($link_db,$str_type1);
list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result1);
?>
<option value="?SType_id=<?=$ProductTypeID?>&pr_id=<?=$p_marx?>" <? if($ProductTypeID==$SType_id){ echo "selected"; }?>><?=$ProductTypeName?></option>
<?
mysqli_close($link_db);
?>
</select>
<input type="hidden" name="M00" value="<?=$p_marx;?>"><input type="hidden" name="M0" value="<?=$MA0;?>">
</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Page Status</td><td><input type="radio" value="1" name="SR1" <? if($MA1=="1") { echo "checked"; } ?>> Enabled <input type="radio" value="0" name="SR1" <? if($MA1=="0") { echo "checked"; } ?>> Disabled </td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Matrix Category Name</td><td><input type="text" name="M1" size="40" value="<?=$MA2;?>"></td>
</tr>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Status</td><td><input type="radio" value="1" name="SR2" <? if($MA3=="1") { echo "checked"; } ?>> Online <input type="radio" value="0" name="SR2" <? if($MA3=="0") { echo "checked"; } ?>> Offline </td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">SKUs</td>
<td>
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_sku="select Product_SKU_Auto_ID,SKU FROM Product_SKUs where ProductTypeID=".$SType_id;
$sku_result=mysqli_query($link_db,$str_sku);
while($stdata=mysqli_fetch_row($sku_result)){
$i=$i+1;
?>
<input name="prosku[]" type="checkbox" value="<?=$stdata[0];?>" <? if(preg_match("/".$stdata[0]."/i",$MA4)!='') echo "checked"; ?> /> <? if(preg_match("/".$stdata[0]."/i",$MA4)!='') { echo "<font color=red>".$stdata[1]."</font>"; } else { echo $stdata[1]; } ?>
<?
if($i%5==0){ echo "<br>"; }
}
?>
</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center"></td>
<td></td>
</tr> 
<tr bgcolor="Aquamarine"><td align="center" colspan="2"><input type="submit" value="Done"></td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {

if ( document.form1.SM1.value == "" ) {
alert ("請選擇 ProductType！");
document.form1.SM1.focus();
return false;
}

if ( document.form1.M1.value == "" ) {
alert ("請輸入 Matrix Category Name！");
document.form1.M1.focus();
return false;
}

return true;
}
</script>
</body>
</html>