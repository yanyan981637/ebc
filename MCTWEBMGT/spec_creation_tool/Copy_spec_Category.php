<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$csc_id=$_REQUEST['csc_id'];

if($_REQUEST['types']=='mod_data'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$str_m="select SPECCategoryID FROM speccategroies order by SPECCategoryID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;

$m0=$_POST['M0'];
$guid = com_create_guid();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

foreach($_POST['ProductTID'] as $check1) {
$str1=$str1.$check1.",";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

if($_POST['SPEC_id']!=''){
$s_id=$_POST['SPEC_id'];
$str_sku="update speccategroies set `SPECCategoryName`='".$m0."',`producttypeList`='".$str1."',`upd_d`='".$now."',`upd_u`='1782'  where `SPECCategoryID`=".$s_id;
}
$cmd_sku=mysqli_query($link_db,$str_sku);
echo "<script>alert('edit SPEC Category !');parent.location.reload();parent.jQuery.fancybox.close();</script>";
mysqli_close($link_db);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Tool - Edit a SPEC Categroies</title>
</head>
<body>
<form action="?types=mod_data&csc_id=<?=$csc_id?>" name="form1" method="POST" onsubmit="return Final_Check();">
<table border="0" cellspacing="1" cellpadding="4" align="center" id="table1" bgcolor="darkgreen">
<?
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_sc_m="select * from speccategroies where SPECCategoryID=".$csc_id;
  $cmd_sc_m=mysqli_query($link_db,$str_sc_m);
  $record_sc_m=mysqli_fetch_row($cmd_sc_m);  
  if(empty($record_sc_m)):
  else:
    $PM0=$record_sc_m[0];
    $PM1=$record_sc_m[1];
    $PM2=$record_sc_m[2];    
  endif;
?>
<tr bgcolor="Aquamarine">
<td align="center">Category Name:</td>
<td>
<input type="hidden" name="SPEC_id" value="<?=$PM0?>">
<input type="text" name="M0" value="<?=$PM1?>"></td>
</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">SPEC Categories</td><td>
<?
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    //$select=mysqli_select_db($dataBase, $link_db);
   
    $str_all="select sum(ProductTypeID) as t_count from producttypes order by ProductTypeID";
    $result_all=mysqli_query($link_db,$str_all);
    $data_all=mysqli_fetch_array($result_all);
    $d_total=$data_all[t_count];
    
    $i=0;
    $str_type_s="select ProductTypeID,ProductTypeName FROM producttypes";
    $types_result=mysqli_query($link_db,$str_type_s);
    while($data=mysqli_fetch_row($types_result))
    {
    $i=$i+1;
?>                                                                      
    <input name="ProductTID[]" type="checkbox" value="<?=$data[0];?>" <? if(preg_match("/".$data[0]."/i",$PM2)!='') { echo "checked"; } ?> /> <?=$data[1];?>
<?    
     if($i%3==0)
     {
     echo "<br />";
     }
    }
    mysqli_close($link_db);
?>
</td>
</tr>
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
alert ("請選擇 ProductTypeName！");
document.form1.M0.focus();
return false;
}
return true;
}
</script>
</body>
</html>