<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$spectype_id=$_REQUEST['spectype_id'];

if($_REQUEST['Speccat_id']==''){
$_REQUEST['Speccat_id']=101;
$Speccat_id=$_REQUEST['Speccat_id'];
}else{
$Speccat_id=$_REQUEST['Speccat_id'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Tool - copy a SPEC Types</title>

<script language="JavaScript">
function MM_o(selObj){
window.open(document.all.SEL_spccateg.options[document.all.SEL_spccateg.selectedIndex].value,"_self");
}    
</script>
</head>

<body>
<form action="?type=edit&spectype_id=<?=$spectype_id?>" name="form1" method="POST" onsubmit="return Final_Check();">
<table border="0" cellspacing="1" cellpadding="4" align="center" id="table1" bgcolor="darkgreen">
<?
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_stype_m="select * from spectypes where SPECTypeID=".$spectype_id;
  $cmd_stype_m=mysqli_query($link_db,$str_stype_m);
  $record_stype_m=mysqli_fetch_row($cmd_stype_m);
  
  if(empty($record_stype_m)):
  else:
    $PM0=$record_stype_m[0];
    $PM1=$record_stype_m[1];
    $PM2=$record_stype_m[2];    
  endif;
?>
<tr bgcolor="Aquamarine">
<td align="center">Category Name</td>
<td>
<select id="SEL_spccateg" name="SEL_spccateg" onChange="MM_o(this)">
<option value="">Select...</option>
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECC="select * from speccategroies";
$SPECC_result=mysqli_query($link_db,$str_SPECC);
while(list($SPECCategoryID,$SPECCategoryName,$producttypeList)=mysqli_fetch_row($SPECC_result))
{
?>
<option value="?spectype_id=<?=$spectype_id;?>&Speccat_id=<?=$SPECCategoryID;?>" <? if($Speccat_id==$SPECCategoryID){ echo "selected"; }?>><?=$SPECCategoryName?></option>
<?
}
mysqli_close($link_db);
?>
</select>
</td>
</tr>

<tr bgcolor="Aquamarine">
<td>Type Name:</td>
<td><input name="SM0" type="hidden" value="<?=$PM0;?>"  /> <input name="SM1" type="text" size="30" value="<?=$PM2;?>"  /> </td>
</tr>

<tr bgcolor="Aquamarine">
<td>Tooltips:</td>
<td><input name="SM2" type="text" size="30" value=""  /></td>
</tr>

<tr bgcolor="Aquamarine">
<td>Applied Product Types:</td>
<td>
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECC="select * from speccategroies where SPECCategoryID=".$Speccat_id;
$SPECC_cmd=mysqli_query($link_db,$str_SPECC);
$SPECC_str=mysqli_fetch_row($SPECC_cmd);
$SPECC_value = preg_split(",",$SPECC_str[2]);
    
    for($m=0;$m<count($SPECC_value)-1;$m++){    
    $strw="select ProductTypeID,ProductTypeName FROM producttypes where ProductTypeID=".$SPECC_value[$m];
    $strw_result=mysqli_query($link_db,$strw);
    $data4=mysqli_fetch_row($strw_result);
    echo $data4[1].",  ";      
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