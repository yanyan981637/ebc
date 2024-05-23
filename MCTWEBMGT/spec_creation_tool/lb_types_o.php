<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$SPCC_ID=$_REQUEST['SPCC_ID'];

if($_REQUEST['kinds']=='add_types'){

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase);

$T1=$_POST['T1'];


$str_c="select SPECTypeName from SPECTypes where SPECTypeName='".$T1."'";
$check_c=mysqli_query($link_db,$str_c);
$record_c=mysqli_fetch_row($check_c);

if(empty($record_c)):

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$guid = com_create_guid();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

$str_t="insert into SPECTypes (SPECCategoryID,SPECTypeName,WebOrder,ParentSpec,InputTypeID,GUID,crea_d,crea_u) values ($SPCC_ID,'$T1','',0,2,'$guid','$now','1782')";
$cmd_t=mysqli_query($link_db,$str_t);
 if($cmd_t==true):
 echo "<script>alert('Add Types it!');self.location='lb_types.php?SPCC_ID=$SPCC_ID'</script>";
 endif;
else:

echo "<script>alert('SPECTypesName目前已經存在,請重新輸入!');self.location='lb_types.php?SPCC_ID=$SPCC_ID'</script>";
exit();

endif;
mysqli_close($link_db);
}


if($_REQUEST['kinds']=='types_set'){

$typs_name = explode(",", $_POST['typs_name'],-1);
$typs_count = count($typs_name); //Types總數
//echo $typs_count;
for($i=0;$i<$typs_count;$i++){

$typs_name_re=str_replace("spt_","",$typs_name[$i]);

//echo $typs_name_re."  ".$_POST[$typs_name[$i]]."<br>";

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_Ts="update SPECTypes set IsShow='".$_POST[$typs_name[$i]]."' where SPECTypeID=".$typs_name_re;
  $Tysresult=mysqli_query($link_db,$str_Ts); 

}

$optons_name = explode(",", $_POST['optons_name'],-1);
$optons_count = count($optons_name);

for($j=0;$j<$optons_count;$j++){

$optons_name_re=str_replace("spo_","",$optons_name[$j]);

//echo $typs_name_re."  ".$_POST[$typs_name[$i]]."<br>";

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_Op="update SPECOptions set IsShow='".$_POST[$optons_name[$j]]."' where SPECTypeID=".$optons_name_re;
  $Opsresult=mysqli_query($link_db,$str_Op); 

}


echo "<script>alert('設定SPECTypes成功!');self.location='lb_types.php?SPCC_ID=$SPCC_ID'</script>";

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Edit Product Category's Types</title>
<link rel=stylesheet type="text/css" href="../backend.css">
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
<script language="JavaScript">
<!--
function Final_Check(){
  if(document.form2.T1.value==''){
  alert ("請輸入Types！");
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
<form id="form2" name="form2" method="post" action="?kinds=add_types&SPCC_ID=<?=$SPCC_ID?>" onsubmit="return Final_Check();">
Types <input name="T1" type="text" size="25" value=""  /> &nbsp;&nbsp;&nbsp;&nbsp;Enter tooltips <input name="T2" type="text" size="25" value=""  />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Add"  /></p>
</form>
<form id="form1" name="form1" method="post" action="?kinds=types_set&SPCC_ID=<?=$SPCC_ID?>">
<table>
<?
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);
$str_Category="select SPECCategoryID,SPECCategoryName from SPECCategroies where SPECCategoryID=".$SPCC_ID;
$Categoryresult=mysqli_query($link_db,$str_Category);
  
  $data=mysqli_fetch_row($Categoryresult);
?>
<thead><tr><td ><?=$data[1];?> :</td></tr></thead>
<tbody>
<?
  
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);
  $str_Types="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow from SPECTypes where SPECCategoryID=".$SPCC_ID;
  $Typesresult=mysqli_query($link_db,$str_Types);
  
  while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName,$IsShow)=mysqli_fetch_row($Typesresult)){
  $str=$str."spt_".$SPECTypeID.",";
?>
<tr><td ><input name="typs_name" type="hidden" value="<?=$str;?>"><input name="spt_<?=$SPECTypeID?>" type="checkbox" value="1" <? if($IsShow=='1') echo "checked"; ?> /> <?=$SPECTypeName;?></td></tr>

   <?
   $str_Options="select * from SPECOptions where SPECTypeID=".$SPECTypeID;
   $Optionsresult=mysqli_query($link_db,$str_Options);
   if($Optionsresult==true){  
   while(list($SPECOptionID,$SPECTypeID,$SPECOptionValue)=mysqli_fetch_row($Optionsresult)){
   $str_s=$str_s."spo_".$SPECOptionID.",";
   ?>
   <tr><td class="two"><input name="optons_name" type="hidden" value="<?=$str_s;?>"><input name="spo_<?=$SPECOptionID?>" type="checkbox" value="1" <? if($IsShow=='1') echo "checked"; ?> /> <?=$SPECOptionValue;?></td></tr>
   <?
   }
   }
   ?>
<?
 }
 mysqli_close($link_db);
?>
</tbody>
<br><p style="padding:5px 20px; "><input type="submit" value="Done"  /></p>
</table>
</form>



<P style="color:#0F0">
- show 這個 category 下面所有設定的types, check to set.<br>
- Add New box 可輸入新的type, add後出現在下面table
- 參考
http://dbushell.github.com/Nestable/  &  http://mjsarfatti.com/sandbox/nestedSortable/<br>
以table 方式呈現兩層，可用拖拉 rows 進行兩層grouping & 排序
</p>




</body>
</html>
