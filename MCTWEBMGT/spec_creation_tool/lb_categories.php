<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_REQUEST['PType_id'])!=''){
$PType_id=intval($_REQUEST['PType_id']);
}else{
$PType_id="";
}

if(isset($_REQUEST['kinds'])=='add_categories'){

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

$p1=trim($_POST['p1']);
$t2=trim($_POST['t2']);

$str_c="select SPECCategoryName from speccategroies where SPECCategoryName='".$t2."'";
$check_c=mysqli_query($link_db,$str_c);
$record_c=mysqli_fetch_row($check_c);

if(empty($record_c)):

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str1="insert into speccategroies (`SPECCategoryName`,`producttypeList`,`WebOrder`,`crea_d`,`crea_u`) values ('$t2','101,102,103,104,105,106,107,','','$now','1782')";
$cmd_cresult=mysqli_query($link_db,$str1);
echo "<script>alert('Add Categroies it!');self.location='lb_categories.php?PType_id=".$p1."'</script>";

else:
echo "<script>alert('SPECCategoryName目前已經存在,請重新輸入!');location.href='lb_categories.php?PType_id=".$p1."'</script>";
exit();
endif;
mysqli_close($link_db);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Edit Product Categories</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<style type="text/css">
table{width:95%}
thead{background:#00a0e9; color:#fff; font-weight:bolder; padding:5px 15px;}
td{ padding:5px 15px;}
tbody{background:#dcf2fd}
</style>

<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript">
<!--
  var ST,SP,SK,UP,PN1,PN2,PN3,PN4,PN5,PN6,PN7,PN8,PN9,PN10;
  var PMT03,PMT04,PMT05,PMT06,PMT07,PMT08,PMT09,PMT10,PMT11,PMT12,PMT13,PMT14,PMT15,PMT16,PMT17,PMT18,PMT19;
  ST=parent.form1.PT1.value;
  SP=parent.form1.SEL_PMODEL.value;
  SK=parent.form1.SKU_value.value;
  UP=parent.form1.UPC_value.value;

  //PMT03=$("#SEL_PMT003").parent("selected").find("option:selected").text();  
  
  n003=parent.form1.SEL_PMT003.selectedIndex;  
  PMT03=parent.form1.SEL_PMT003.options[n003].text;
  n004=parent.form1.SEL_PMT004.selectedIndex;
  PMT04=parent.form1.SEL_PMT004.options[n004].text;
  n005=parent.form1.SEL_PMT005.selectedIndex;
  PMT05=parent.form1.SEL_PMT005.options[n005].text;
  n006=parent.form1.SEL_PMT006.selectedIndex;
  PMT06=parent.form1.SEL_PMT006.options[n006].text;
  n007=parent.form1.SEL_PMT007.selectedIndex;
  PMT07=parent.form1.SEL_PMT007.options[n007].text;
  n008=parent.form1.SEL_PMT008.selectedIndex;
  PMT08=parent.form1.SEL_PMT008.options[n008].text;
  n009=parent.form1.SEL_PMT009.selectedIndex;
  PMT09=parent.form1.SEL_PMT009.options[n009].text;
  n010=parent.form1.SEL_PMT010.selectedIndex;
  PMT10=parent.form1.SEL_PMT010.options[n010].text;
  n011=parent.form1.SEL_PMT011.selectedIndex;
  PMT11=parent.form1.SEL_PMT011.options[n011].text;
  n012=parent.form1.SEL_PMT012.selectedIndex;
  PMT12=parent.form1.SEL_PMT012.options[n012].text;
  n013=parent.form1.SEL_PMT013.selectedIndex;
  PMT13=parent.form1.SEL_PMT013.options[n013].text;  


  if(ST==101 || ST==102){
  PN1=parent.form1.SEL_PN1.value;
  PN2=parent.form1.SEL_PN2.value;
  PN3=parent.form1.SEL_PN3.value;
  
  n014=parent.form1.SEL_PMT014.selectedIndex;
  PMT14=parent.form1.SEL_PMT014.options[n014].text;
  n015=parent.form1.SEL_PMT015.selectedIndex;
  PMT15=parent.form1.SEL_PMT015.options[n015].text;
  n016=parent.form1.SEL_PMT016.selectedIndex;
  PMT16=parent.form1.SEL_PMT016.options[n016].text;  
    
    $.cookie("c_seVal03", PMT03);
	$.cookie("c_seVal04", PMT04);
	$.cookie("c_seVal05", PMT05);
	$.cookie("c_seVal06", PMT06);
	$.cookie("c_seVal07", PMT07);
	$.cookie("c_seVal08", PMT08);
	$.cookie("c_seVal09", PMT09);
	$.cookie("c_seVal10", PMT10);
    $.cookie("c_seVal11", PMT11);
	$.cookie("c_seVal12", PMT12);
	$.cookie("c_seVal13", PMT13);
	$.cookie("c_seVal14", PMT14);
	$.cookie("c_seVal15", PMT15);
	$.cookie("c_seVal16", PMT16);   
  
	if(parent.form1.SEL_PN1.length>0){
	$.cookie("SEL_PN1", PN1);
	}
	if(parent.form1.SEL_PN2.length>0){
	$.cookie("SEL_PN2", PN2);
	}
	if(parent.form1.SEL_PN3.length>0){
	$.cookie("SEL_PN3", PN3);
	}
  
  }else if(ST==103 || ST==104){
  PN4=parent.form1.SEL_PN4.value;
  PN5=parent.form1.SEL_PN5.value;
  PN6=parent.form1.SEL_PN6.value;
  
  n014=parent.form1.SEL_PMT014.selectedIndex;
  PMT14=parent.form1.SEL_PMT014.options[n014].text;
  n015=parent.form1.SEL_PMT015.selectedIndex;
  PMT15=parent.form1.SEL_PMT015.options[n015].text;
  n016=parent.form1.SEL_PMT016.selectedIndex;
  PMT16=parent.form1.SEL_PMT016.options[n016].text;
  n017=parent.form1.SEL_PMT017.selectedIndex;
  PMT17=parent.form1.SEL_PMT017.options[n017].text;
  n018=parent.form1.SEL_PMT018.selectedIndex;
  PMT18=parent.form1.SEL_PMT018.options[n018].text;
  n019=parent.form1.SEL_PMT019.selectedIndex;
  PMT19=parent.form1.SEL_PMT019.options[n019].text;
  
    $.cookie("c_seVal03", PMT03);
	$.cookie("c_seVal04", PMT04);
	$.cookie("c_seVal05", PMT05);
	$.cookie("c_seVal06", PMT06);
	$.cookie("c_seVal07", PMT07);
	$.cookie("c_seVal08", PMT08);
	$.cookie("c_seVal09", PMT09);
	$.cookie("c_seVal10", PMT10);
    $.cookie("c_seVal11", PMT11);
	$.cookie("c_seVal12", PMT12);
	$.cookie("c_seVal13", PMT13);
	$.cookie("c_seVal14", PMT14);
	$.cookie("c_seVal15", PMT15);
	$.cookie("c_seVal16", PMT16);
    $.cookie("c_seVal17", PMT17);
	$.cookie("c_seVal18", PMT18);
	$.cookie("c_seVal19", PMT19);	
    
	if(parent.form1.SEL_PN4.length>0){
    $.cookie("SEL_PN4", PN4);
    }
    if(parent.form1.SEL_PN5.length>0){
    $.cookie("SEL_PN5", PN5);
    }
    if(parent.form1.SEL_PN6.length>0){
    $.cookie("SEL_PN6", PN6);
    }
  
  }else if(ST==105 || ST==106){
  PN7=parent.form1.SEL_PN7.value;
  PN8=parent.form1.SEL_PN8.value;
  PN9=parent.form1.SEL_PN9.value;
    
	if(parent.form1.SEL_PN7.length>0){
    $.cookie("SEL_PN7", PN7);
    }
    if(parent.form1.SEL_PN8.length>0){
    $.cookie("SEL_PN8", PN8);
    }
    if(parent.form1.SEL_PN9.length>0){
    $.cookie("SEL_PN9", PN9);
    }
  
  }else if(ST==107){
  PN5=parent.form1.SEL_PN5.value;
  PN6=parent.form1.SEL_PN6.value;
  PN10=parent.form1.SEL_PN10.value;
    
	if(parent.form1.SEL_PN5.length>0){
    $.cookie("SEL_PN5", PN5);
    }
    if(parent.form1.SEL_PN6.length>0){
    $.cookie("SEL_PN6", PN6);
	}
	if(parent.form1.SEL_PN10.length>0){
    $.cookie("SEL_PN10", PN10);
    }
	
  }
  
  $.cookie("SEL_PMODEL01", SP);
  $.cookie("SKU_value01", SK);
  $.cookie("UPC_value01", UP);  
  
  
//-->
</script>


<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  var params = $('input').serialize();
  var url = "categories_result.php";

  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(msg){

  $("#categ_list").html(msg);

  }
  });
  
  /*
  $("#subbtn").click(function() {
  var params = $('input').serialize();
  var url = "categories_result.php";

  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(msg){
  $("#categ_list").html(msg);
  
  $("#order_list1").css({color: "green"});
  }
  });
  }); 
  */
});

</script>
<script language="JavaScript">
<!--
function Final_Check(){
  if(document.form2.t2.value==''){
  alert ("請輸入Categories！");
  document.form2.t2.focus();
  return false;
  }
  return true;
}
//-->
</script>
</head>

<body style="backbround:#f9f9f9; padding: 0px 15px">
<div align="right">
<form id="form2" name="form2" method="post" action="?kinds=add_categories" onsubmit="return Final_Check();">
<input id="t2" name="t2" type="hidden" size="25" value="" /><input id="p1" name="p1" type="hidden" value="<?=$PType_id;?>" />&nbsp; <!--<input type="submit" value="Add"  />-->
</form>
<form id="form1" name="form1" method="post">
<!--<input id="t1" name="t1" type="text" size="15" value=""  />-->
<!--<input id="subbtn" type="button" value="查詢" />&nbsp;<input id="subbtn" type="reset" value="清除" onclick="if (confirm('清除?') ) f.reset() ; return false" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
</form>
</div>
<p class="clear"></p>
<table>
<tbody>
<tr>
<td>
<table>
<tr>
<td>
<div id="categ_list" style="height:1200px;display:''"></div>
</td>
</tr>
</table>
</td>
</tr>
</tbody>
</table>
<!--<p ><input type="submit" value="Done"  /></p>-->

<P style="color:#0F0;display:none">
- 列出所有的categories (順序跟據 SPEC Settings => Categories 所設定的顯示), checked 已經show 的categories <br>
- 當Filter box輸入英文字第一個字母，下面會動態show出其相同第一個字母的 category。
點選All 會show 出全部，default 為show 出全部。<br>
-  Add New box 可輸入新的category, add後出現在下面並checked<br>
- 被選的Categories, 可排序
</p>
</body>
</html>