<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$t1="";$p_SKU="";$sp_id="";$pty_id="";
if(isset($_POST['t1'])!=''){
$t1=trim($_POST['t1']);
}
if(isset($_POST['p1'])!=''){
$p_SKU=trim($_POST['p1']);
}
if(isset($_REQUEST['sp_id'])!=''){
$sp_id=intval($_REQUEST['sp_id']);
}
if(isset($_REQUEST['pty_id'])!=''){
$pty_id=intval($_REQUEST['pty_id']);
}
if(isset($_REQUEST['set'])=='mod_ecategories'){
	$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	mysqli_query($link_db,'SET NAMES utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
	//$select=mysqli_select_db($dataBase, $link_db);
	$spc_mcateg_all="";
	
	if(isset($_POST['spc_MSPECCategoryID'])<>''){
	
	foreach($_POST['spc_MSPECCategoryID'] as $spc_mcateg){
	   $spc_mcateg_all.=$spc_mcateg.",";
	}
	
	$str_upset_m="update product_skus set SKU_CategorySort='".$spc_mcateg_all."' where Product_SKU_Auto_ID=".$_POST['psa_id'];
	$upset_m_cmd=mysqli_query($link_db,$str_upset_m);
	
	}

    setcookie("categor_cookie".$_REQUEST['PT_id'],$spc_mcateg_all,time()+1800); //set cookie約1800秒	
	echo "<script>alert('設定SPECCategories成功!');parent.location.reload();parent.jQuery.fancybox.close();</script>";
	exit();
    mysqli_close($link_db);
}


$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_sku_m="select * from product_skus where Product_SKU_Auto_ID=".$sp_id;
$cmd_sku_m=mysqli_query($link_db,$str_sku_m);
$record_sku_m=mysqli_fetch_row($cmd_sku_m);
  
if(empty($record_sku_m)):
else:
$SM13=$record_sku_m[24];
endif;
mysqli_close($link_db);

$data_type_s="";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s="select a.SPECTypeID from `specvalues` a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where a.SPECValue<>'' and Product_SKU_Auto_ID=".$p_SKU;
$type_result_s=mysqli_query($link_db,$str_type_s);
while($data_p=mysqli_fetch_row($type_result_s)){
$data_type_s.=$data_p[0].",";
}
mysqli_close($link_db);

$data_optionc_s="";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_optionc_s="select SPECTypeID from `specvalues` where SPECValue<>'' and (INSTR('".$data_type_s."',SPECTypeID)>0) and Product_SKU_Auto_ID=".$p_SKU;
$optionc_result_s=mysqli_query($link_db,$str_optionc_s);
while($data_optc=mysqli_fetch_row($optionc_result_s)){

$data_optionc_s.=$data_optc[0].",";
}
mysqli_close($link_db);

$data_optionc_s=str_replace(',,', ',', $data_optionc_s);

$data_SPEC1="";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECCat_1="select distinct SPECCategoryID from spectypes";
$SPECCat_result_1=mysqli_query($link_db,$str_SPECCat_1);
while($data_scc1=mysqli_fetch_row($SPECCat_result_1)){
$data_SPEC1.=$data_scc1[0].",";
}
mysqli_close($link_db);

//2013.11.27新寫法

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$pty_id;
$type_result_s=mysqli_query($link_db,$str_type_s);
$data_p=mysqli_fetch_row($type_result_s);
mysqli_close($link_db);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
?>
<form id="form4" name="form4" method="post" action="categories_eresult.php?set=mod_ecategories&PT_id=<?=$pty_id?>">
<table>
<tr>
<?php
if($t1!=''){
$str="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where SPECCategoryName like '%".$t1."%' order by SPECCategorySort";
}else{
$str="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies order by SPECCategorySort";
}
$SPCate_result=mysqli_query($link_db,$str);
$i=0;
while(list($SPECCategoryID,$SPECCategoryName,$IsShow)=mysqli_fetch_row($SPCate_result))
{
$i=$i+1;
if($i%4==0) echo "<tr>";
?>
<td><input name="spc_MSPECCategoryID[]" id="spc_MSPECCategoryID[]" type="checkbox" value="<?=$SPECCategoryID;?>" 
<?php
  if(isset($_COOKIE["categor_cookie".$pty_id.""])!=''){
	if(strpos(','.$_COOKIE["categor_cookie".$pty_id.""],','.$SPECCategoryID.',')!='' || strpos(','.$_COOKIE["categor_cookie".$pty_id.""],','.$SPECCategoryID.',')===0){
	  echo "checked";
	}
  }else if($SM13<>''){
	if(strpos(','.$SM13,','.$SPECCategoryID.',')!='' || strpos(','.$SM13,','.$SPECCategoryID.',')===0){
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
<tr><td><input name="psa_id" type="hidden" value="<?=$sp_id;?>"><input name="B1" type="submit" value="Done" /></td></tr>
</table>
</form>
<?php
mysqli_close($link_db);
?>