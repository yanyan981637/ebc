<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_REQUEST['PT_id'])!=''){
$PT_id=intval($_REQUEST['PT_id']);
}else{
$PT_id="";
}
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_type_s="select SPECCategories,SPECType,SPECType_Sub from producttypes where ProductTypeID=".$PT_id;
$type_result_s=mysqli_query($link_db,$str_type_s);
$data_p=mysqli_fetch_row($type_result_s);
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
$("#info").load("Categories_Sortable_include.php?PType_id=<?=$PT_id?>&"+order);
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
if(isset($_COOKIE["categor_cookie".$PT_id.""])!=''){
$str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where INSTR('".$_COOKIE["categor_cookie".$PT_id.""]."',SPECCategoryID)>0 order by SPECCategorySort";
}else{
$str_Cate="select `SPECCategoryID`,`SPECCategoryName`,`IsShow` from speccategroies where INSTR('".$data_p[0]."',SPECCategoryID)>0 order by SPECCategorySort";
}
$Cateresult=mysqli_query($link_db,$str_Cate);
$i=0;
while($data=mysqli_fetch_row($Cateresult))
{
$i=$i+1;
?>
<li id="cate_<?=$data[0];?>" class="ui-state-default"><center><font size=2><?=$data[1];?></font></center><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></li>
<?php
}
?>
</ul>
<div id="info"></div>
<form action="process-sortable.php" method="post" name="form1"> 
  <input type="hidden" name="test-log" id="test-log" /> 
</form>
</table>
</body>
</html> 