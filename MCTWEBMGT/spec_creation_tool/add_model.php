<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if($_REQUEST['type']=='model'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$m1=$_POST['M1'];
$m2=$_POST['M2'];
$m3=$_POST['M3'];

if(function_exists('com_create_guid')){
    $guid = com_create_guid();
}else{
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = chr(123)// "{"
           .substr($charid, 0, 8).$hyphen
           .substr($charid, 8, 4).$hyphen
           .substr($charid,12, 4).$hyphen
           .substr($charid,16, 4).$hyphen
           .substr($charid,20,12)
           .chr(125);// "}"
    $guid = $uuid;
}
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str_m="select ModelID FROM Product_Models order by ModelID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;

$str="insert into Product_Models (ModelID,ModelName,ModelCode,ProductCateID,GUID,crea_d,crea_u) values ($MCount,'$m1','$m2',$m3,'$guid','$now','1782')";
$cmd_model=mysqli_query($link_db,$str);
echo "<script>alert('Add Model it!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
mysqli_close($link_db);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Creation Tool - Add a Model</title>
</head>
<body>
<form action="?type=model" name="form1" method="POST" onsubmit="return Final_Check();">
<table border="0" cellspacing="1" cellpadding="4" align="center" id="table1" bgcolor="darkgreen">

<tr bgcolor="Aquamarine">
<td align="center">Model Name</td><td><input type="text" name="M1" size="20"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Model Code</td><td><input type="text" name="M2" size="20"></td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">Product Categories</td><td>
<select name="M3" id="M3">
    <option selected="selected">--Select--</option>
    <?php
    
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
    //$select=mysqli_select_db($dataBase, $link_db);
    
    $str_PCategories="select ProductCateID,ProductCateName from ProductCategories";
    $PCategories_result=mysqli_query($link_db,$str_PCategories);
    while(list($ProductCateID,$ProductCateName)=mysqli_fetch_row($PCategories_result)){
    ?>
    <option value="<?=$ProductCateID;?>"><?=$ProductCateName;?></option>
    <?
    }
    mysqli_close($link_db);
    ?>
    </select>
</td>
</tr> 
<tr bgcolor="Aquamarine"><td align="center" colspan="2"><input type="submit" value="新增"></td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {
if ( document.form1.M1.value == "" ) {
alert ("請輸入Model Name！");
document.form1.M1.focus();
return false;
}
if ( document.form1.M2.value == "" ) {
alert ("請輸入Model Code！");
document.form1.M2.focus();
return false;
}
if ( document.form1.M3.value == "" ) {
alert ("請輸入Product Categories！");
document.form1.M3.focus();
return false;
}
return true;
}
</script>
</body>
</html>