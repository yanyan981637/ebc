<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_POST['t1'])!=''){
$t1=trim($_POST['t1']);
}else{
$t1="";
}
if(isset($_POST['p1'])!=''){
$p1=trim($_POST['p1']);
}else{
$p1="";
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_REQUEST['set'])=='mod_categories'){

	$spc_categ_all="";
	foreach($_POST['spc_SPECCategoryID'] as $spc_categ){
		 $spc_categ_all.=$spc_categ.",";
	}
	setcookie("categor_cookie".$_REQUEST['PT_id'],$spc_categ_all,time()+1800); //set cookie約1800秒
	
	echo "<script>alert('設定SPECCategories成功!');parent.location.reload();</script>";
	echo "<script language='Javascript'>Set_Cookies_values();</script>\n";
	echo "<script>parent.jQuery.fancybox.close();</script>";
	exit();
}

$str_type_s="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$p1;
$type_result_s=mysqli_query($link_db,$str_type_s);
$data_p=mysqli_fetch_row($type_result_s);
?>
<form id="form4" name="form4" method="post" action="categories_result.php?set=mod_categories&PT_id=<?=$p1?>&PC_id=<?=$_REQUEST['PCate_id']?>">
<table>
<tr>
<?php
$str="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where SPECCategoryName like '%".$t1."%' order by SPECCategorySort";
$SPCate_result=mysqli_query($link_db,$str);
$i=0;
while(list($SPECCategoryID,$SPECCategoryName,$IsShow)=mysqli_fetch_row($SPCate_result))
{
$i=$i+1;
if($i%4==0) echo "<tr>";
?>
<td><input name="spc_SPECCategoryID[]" id="spc_SPECCategoryID[]" type="checkbox" value="<?=$SPECCategoryID;?>" 
<?php
  if(isset($_COOKIE["categor_cookie".$p1.""])!=''){
    if(strpos(','.$_COOKIE["categor_cookie".$p1.""],','.$SPECCategoryID.',')!='' || strpos(','.$_COOKIE["categor_cookie".$p1.""],','.$SPECCategoryID.',')===0){
	  echo "checked";
	}
  }else{
	if(strpos(','.$data_p[0],','.$SPECCategoryID.',')!='' || strpos(','.$data_p[0],','.$SPECCategoryID.',')===0){
	  echo "checked";
	}
  }
?>> <?=$SPECCategoryName;?>&nbsp;</td>
<?php
if($i%4==0) echo "</tr>";
}
?>
</tr>
<tr><td><input type="submit" value="Done" /></td></tr>
</table>
</form>
<?php
//}
mysqli_close($link_db);
?>