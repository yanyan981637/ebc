<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

if(isset($_REQUEST['SPCT_ID'])!=''){
$SPCT_ID=intval($_REQUEST['SPCT_ID']);
}else{
$SPCT_ID="";
}

if(isset($_REQUEST['kinds'])!=''){

if(trim($_REQUEST['kinds'])=='add_options'){

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_POST['T1'])!=''){
$T1=htmlspecialchars($_POST['T1'], ENT_QUOTES);
}else{
$T1="";
}

if(isset($_REQUEST['SPCT_ID'])!=''){
$SPCT_ID01=intval($_REQUEST['SPCT_ID']);
}else{
$SPCT_ID01="";
}

$str_c="select SPECOptionValue FROM specoptions where SPECOptionValue='".$T1."'";
$check_c=mysqli_query($link_db,$str_c);
$record_c=mysqli_fetch_row($check_c);

if(empty($record_c)):
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

      $str_m="select SPECOptionID FROM specoptions order by SPECOptionID desc limit 1";
      $check_m=mysqli_query($link_db,$str_m);
      $Max_COptionID=mysqli_fetch_row($check_m);
      $MCount=$Max_COptionID[0]+1;

$str_t="insert into specoptions(SPECOptionID,SPECTypeID,SPECOptionValue,SPECOptionURL,crea_d,crea_u) values ($MCount,$SPCT_ID,'$T1','','$now','1782')";
$cmd_t=mysqli_query($link_db,$str_t);
 if($cmd_t==true): 
 $Mcount01=$MCount.",".$_COOKIE["options_cookie".$SPCT_ID.""]; 
 setcookie("options_cookie".$SPCT_ID01,$Mcount01,time()+1800); //set cookie約1800秒 
 echo "<script>alert('Add Options it!');self.location='lb_options.php?SPCT_ID=$SPCT_ID'</script>";
 endif;
else:
echo "<script>alert('SPECOptionsName目前已經存在,請重新輸入!');self.location='lb_options.php?SPCT_ID=$SPCT_ID'</script>";
endif;
mysqli_close($link_db);
exit();
}

if(trim($_REQUEST['kinds'])=='options_set'){

if(isset($_REQUEST['SPCT_ID'])!=''){
$SPCT_ID01=intval($_REQUEST['SPCT_ID']);
}else{
$SPCT_ID01="";
}

if(isset($_POST['spo'])<>''){
$spo_check="";
foreach($_POST['spo'] as $spo_str){
$spo_check.=$spo_str.",";
}
}else{
$spo_check='';
}

setcookie("options_cookie".$SPCT_ID01,$spo_check,time()+1800); //set cookie約1800秒
echo "<script>alert('Add Option Done.');parent.location.reload();parent.jQuery.fancybox.close();</script>";
exit();
}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Edit Product Types's Options</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<style type="text/css">
table{border:1px solid #c0c0c0; width:95%}
thead{background:#00a0e9; color:#fff; font-weight:bolder;padding:5px 15px;}
td{ padding:5px 15px;}
td.two{padding-left:50px}
tr{  cursor: pointer; }
tr:hover{background: #dcf2fd;}
tbody:nth-child(even) {
background: #f8f8f8;
}
</style>
<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript">
<!--
  var ST,SP,SK,UP,PN1,PN2,PN3,PN4,PN5,PN6,PN7,PN8,PN9,PN10;
  ST=parent.form1.PT1.value;
  SP=parent.form1.SEL_PMODEL.value;
  SK=parent.form1.SKU_value.value;
  UP=parent.form1.UPC_value.value;
  
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
<script language="JavaScript">
<!--
function Final_Check(){
  if(document.form2.T1.value==''){
  alert ("請輸入Options！");
  document.form2.T1.focus();
  return false;
  }
  return true;
}
//-->
</script>
</head>
<body style="backbround:#f9f9f9">
<p>
<form id="form2" name="form2" method="post" action="?kinds=add_options&SPCT_ID=<?=$SPCT_ID?>" onsubmit="return Final_Check();">
Options <input name="T1" type="text" size="25" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;Enter tooltips <input name="T2" type="text" size="25" value=""  />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Add"  /> <a href="#" onclick="javascript:parent.location.reload();parent.jQuery.fancybox.close();">Close</a></p>
</form>
<form id="form1" name="form1" method="post" action="?kinds=options_set&SPCT_ID=<?=$SPCT_ID?>">
<table>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_Types="select SPECTypeID,SPECTypeName from spectypes where SPECTypeID=".$SPCT_ID;
$Typesresult=mysqli_query($link_db,$str_Types);
$data=mysqli_fetch_row($Typesresult);
?>
<thead><tr><td ><?=$data[1];?> :</td></tr></thead>
<tbody>
<?php
  $str_s="";$str_s01="";
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_Options="select SPECOptionID,SPECTypeID,SPECOptionValue,IsShow FROM specoptions where SPECTypeID=".$SPCT_ID." order by SPECOptionValue";
  $Optionsresult=mysqli_query($link_db,$str_Options);  
  while(list($SPECOptionID,$SPECTypeID,$SPECOptionValue,$IsShow)=mysqli_fetch_row($Optionsresult)){
  $str_s=$str_s."spo_".$SPECOptionID.",";
  $str_s01=$str_s01.$SPECOptionID.",";
?>
<tr><td ><input name="spo[]" type="checkbox" value="<?=$SPECOptionID?>" 
<?php 
if(isset($_COOKIE["options_cookie".$SPCT_ID.""])!=''){
if(preg_match("/".$SPECOptionID."/i",$_COOKIE["options_cookie".$SPCT_ID.""])!='') echo "checked"; 
}
?> /> <?=$SPECOptionValue;?></td></tr>
<?php
 }
 mysqli_close($link_db);
?>
<tr><td><p style="padding:5px 20px; "><input type="submit" value="Done" /></p></td></tr>
</tbody>
</table>
</form>
<P style="color:#0F0;display:none">
- show 這個 category 下面所有設定的types, check to set.<br>
- Add New box 可輸入新的type, add後出現在下面table
- 參考
http://dbushell.github.com/Nestable/  &  http://mjsarfatti.com/sandbox/nestedSortable/<br>
以table 方式呈現兩層，可用拖拉 rows 進行兩層grouping & 排序
</p>
</body>
</html>