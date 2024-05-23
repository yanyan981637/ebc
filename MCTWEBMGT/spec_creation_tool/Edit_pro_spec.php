<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if($_REQUEST['type']=='edit'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$str_m="select Product_SKU_Auto_ID FROM product_skus order by Product_SKU_Auto_ID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;

$m0=$_POST['M0'];
$m1=$_POST['M1'];
$m2=$_POST['M2'];
$m3=$_POST['M3'];
$m4=$_POST['M4'];
$m5=$_POST['M5'];
$m6=$_POST['M6'];
$m7=$_POST['M7'];
$m8=$_POST['M8'];
$sr1=$_POST['SR1'];
$sr2=$_POST['SR2'];
$guid = com_create_guid();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

foreach($_POST['SR3'] as $check) {
$sr3=$sr3.$check.",";
}
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str_sku="update product_skus set `ProductTypeID`=$m0,`SKU`='$m1',`MODELCODE`='$m2',`NetWorking`='$m3',`SAS`='$m4',`FormFactor`='$m5',`UPCcode`='$m6',`FAN`='$m7',`IS_EOL`='$sr1',`Web_Disable`='$sr2',`upd_d`='$now',`upd_u`='1782',`slang`='$sr3' where `Product_SKU_Auto_ID`=".$m8;
$cmd_sku=mysqli_query($link_db,$str_sku);

echo "<script>alert('Mod product SPEC !');parent.location.reload();parent.jQuery.fancybox.close();</script>";
mysqli_close($link_db);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Tool - Edit a product SPEC</title>
</head>

<body>
<form action="?type=edit" name="form1" method="POST" onsubmit="return Final_Check();">
<table border="0" cellspacing="1" cellpadding="4" align="center" id="table1" bgcolor="darkgreen">
<?
  
  $p_SKU=$_REQUEST['p_id'];
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_sku_m="select * from product_skus where Product_SKU_Auto_ID=".$p_SKU;
  $cmd_sku_m=mysqli_query($link_db,$str_sku_m);
  $record_sku_m=mysqli_fetch_row($cmd_sku_m);
  
  if(empty($record_sku_m)):

  else:
    $SM0=$record_sku_m[1];
    $SM1=$record_sku_m[2];
    $SM2=$record_sku_m[3];
    $SM3=$record_sku_m[4];
    $SM4=$record_sku_m[5];
    $SM5=$record_sku_m[6];
    $SM6=$record_sku_m[7];
    $SM7=$record_sku_m[8];
    $SM8=$record_sku_m[9];
    $SM9=$record_sku_m[10];
    $SM10=$record_sku_m[12];
    $SM11=$record_sku_m[13];
    $SM12=$record_sku_m[16];

  endif;
?>
<tr bgcolor="Aquamarine">
<td align="center">ProductTypeID</td>
<td>
<select name="M0" id="M0">
    <option>--Select--</option>
    <?php
    
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    //$select=mysqli_select_db($dataBase, $link_db);
    
    $str_PType="select ProductTypeID,ProductTypeName from producttypes";
    $PType_result=mysqli_query($link_db,$str_PType);
    while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($PType_result)){
    ?>
    <option value="<?=$ProductTypeID;?>" <? if($SM0==$ProductTypeID){ echo "selected"; }?>><?=$ProductTypeName;?></option>
    <?
    }
    mysqli_close($link_db);
    ?>
    </select>
</td>
</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">SKU</td><td><input type="text" name="M1" size="30" value="<?=$SM1;?>"><input type="hidden" name="M8" value="<?=$p_SKU;?>"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">MODELCODE</td><td><input type="text" name="M2" size="30" value="<?=$SM2;?>"></td>
</tr>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">NetWorking</td><td><input type="text" name="M3" size="30" value="<?=$SM3;?>"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">SAS</td><td><input type="text" name="M4" size="30" value="<?=$SM4;?>"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">FormFactor</td><td><input type="text" name="M5" size="30" value="<?=$SM5;?>"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">UPCcode</td><td><input type="text" name="M6" size="30" value="<?=$SM6;?>"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">FAN</td><td><input type="text" name="M7" size="30" value="<?=$SM7;?>"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">IS_EOL</td><td><input type="radio" value="1" <? if($SM8=='1') { echo "checked"; }?> name="SR1">Y<input type="radio" value="0" <? if($SM8=='0') { echo "checked"; }?> name="SR1">N</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Web_Disable</td><td><input type="radio" value="1" <? if($SM9=='1') { echo "checked"; }?> name="SR2">Y<input type="radio" value="0" <? if($SM9=='1') { echo "checked"; }?> name="SR2">N</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Language</td>
<td>
<input name="SR3[]" type="checkbox" value="EN" <? if(eregi("EN",$SM12)!='') echo "checked"; ?> />EN 
<input name="SR3[]" type="checkbox" value="CN" <? if(eregi("CN",$SM12)!='') echo "checked"; ?> />CN 
<input name="SR3[]" type="checkbox" value="ZH" <? if(eregi("ZH",$SM12)!='') echo "checked"; ?> />ZH 
<input name="SR3[]" type="checkbox" value="JP" <? if(eregi("JP",$SM12)!='') echo "checked"; ?> />JP
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

if ( document.form1.M0.value == "" ) {
alert ("請選擇 ProductTypeID！");
document.form1.M0.focus();
return false;
}

if ( document.form1.M1.value == "" ) {
alert ("請輸入 SKU！");
document.form1.M1.focus();
return false;
}

if ( document.form1.M2.value == "" ) {
alert ("請輸入 MODELCODE！");
document.form1.M2.focus();
return false;
}

return true;
}
</script>
</body>
</html>