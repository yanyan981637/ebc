<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

/* 20140312 Create */
$PT_id=$_REQUEST['PType_id'];
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s01="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$PT_id;
$type_result_s01=mysqli_query($link_db,$str_type_s01);
$data_p01=mysqli_fetch_row($type_result_s01);
//echo $data_p[0];
mysqli_close($link_db);
/* end */

if(isset($_REQUEST['SKU_id'])!=''){
$p_SKU=intval($_REQUEST['SKU_id']);
}

$data_type_s="";$data_optionc_s="";$data_SPEC1="";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s="select a.SPECTypeID from `specvalues` a inner join spectypes b on a.SPECTypeID=b.SPECTypeID where a.SPECValue<>'' and Product_SKU_Auto_ID=".$p_SKU;
$type_result_s=mysqli_query($link_db,$str_type_s);
while($data_p=mysqli_fetch_row($type_result_s)){
$data_type_s.=$data_p[0].",";
}
mysqli_close($link_db);

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_optionc_s="select SPECTypeID from `specvalues` where SPECValue<>'' and (INSTR('".$data_type_s."',SPECTypeID)>0) and Product_SKU_Auto_ID=".$p_SKU;
$optionc_result_s=mysqli_query($link_db,$str_optionc_s);
while($data_optc=mysqli_fetch_row($optionc_result_s)){

$data_optionc_s.=$data_optc[0].",";
}
mysqli_close($link_db);

$data_optionc_s=str_replace(',,', ',', $data_optionc_s);


$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECCat_1="select distinct SPECCategoryID from spectypes where INSTR('".$data_optionc_s."',SPECTypeID)>0";

$SPECCat_result_1=mysqli_query($link_db,$str_SPECCat_1);
while($data_scc1=mysqli_fetch_row($SPECCat_result_1)){
$data_SPEC1.=$data_scc1[0].",";
}
mysqli_close($link_db);

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>jQuery UI Sortable - Default functionality</title>
<link rel="stylesheet" href="./js/jquery-ui.css" />
<script src="./js/jquery-1.8.2.js"></script>
<script src="./js/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 55%; }
#sortable li { margin: 0 3px 3px 3px; padding: 0.8em; padding-left: 1.0em; font-size: 1.4em; height: 12px; }
#sortable li span { position: absolute; margin-left: -1.3em; }
</style>
<script>
$(function() {
$("#sortable").sortable({
//handle : '.handle',
opacity: 0.6,
//拖曳時透明
cursor: 'move',
//游標設定
axis:'y',
//y只能垂直拖曳
update : function () { 
var order = $('#sortable').sortable('serialize');
var sid='<?=$p_SKU?>'; 
$("#info").load("Categories_ESortable_include.php?sk_id="+sid+"&"+order);
/*
$('#sortable').remove();
jQuery(this).after('#sortable').remove();
alert(order); 
*/
}
});
$("#sortable").disableSelection();
});
</script>
</head>
<body>
<input type="button" value="Done" onclick="javascript:alert('Set SPECCategroies be Sore !');parent.location.reload();parent.jQuery.fancybox.close();">
<ul id="sortable">
<?php
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_sku_m="select * from product_skus where Product_SKU_Auto_ID=".$p_SKU;
  $cmd_sku_m=mysqli_query($link_db,$str_sku_m);
  $record_sku_m=mysqli_fetch_row($cmd_sku_m);
  
  if(empty($record_sku_m)):

  else:
     $SM13=$record_sku_m[24];
  endif;

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);  
  
  if($SM13!=''){
  //$str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where IsShow='1' and `SPECCategoryID` in (".substr($SM13, 0, strlen($SM13)-1).") order by FIELD(`SPECCategoryID`,".substr($SM13, 0, strlen($SM13)-1).")";
  $str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where `SPECCategoryID` in (".substr($SM13, 0, strlen($SM13)-1).") order by FIELD(`SPECCategoryID`,".substr($SM13, 0, strlen($SM13)-1).")";
  //$str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where `SPECCategoryID` in (".substr($SM13, 0, strlen($SM13)-1).") order by SPECCategorySort";
  }else{
  //$str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where IsShow='1' and INSTR('".$data_SPEC1."',SPECCategoryID)>0  order by SPECCategorySort";
  $str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where INSTR(',".$data_p01[0]."',concat(',',SPECCategoryID,','))>0 order by SPECCategorySort";
  }

$Cateresult=mysqli_query($link_db,$str_Cate);
$i=0;
while($data=mysqli_fetch_row($Cateresult))
{
$i=$i+1;
?>
<li id="cate_<?=$data[0];?>" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><center><font size=2><?=$data[1];?></font></center></li>
<?php
}
?>
</ul>
<div id="info"></div>
<form action="process-sortable.php" method="post" name="form1"> 
  <input type="hidden" name="test-log" id="test-log" /> 
</form>
</body>
</html> 