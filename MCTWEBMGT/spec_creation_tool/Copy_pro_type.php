<?php
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

$pr_PTYPEs=$_REQUEST['pr_id'];

if($_REQUEST['type']=='copy'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase, $link_db);

$str_m="select ProductTypeID FROM producttypes order by ProductTypeID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_COptionID=mysqli_fetch_row($check_m);
$MCount=$Max_COptionID[0]+1;

$m0=$_POST['M0'];
$m1=$_POST['M1'];
$guid = com_create_guid();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

foreach($_POST['speccate'] as $check1) {
$str1=$str1.$check1.",";
}

foreach($_POST['spectype'] as $check2){
$str2=$str2.$check2.",";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

if($_POST['SPEC_id']!=''){
$s_id=$_POST['SPEC_id'];
$str_sku="update producttypes set `ProductTypeName`='".$m0."',`SPECCategories`='".$str1."',`SPECType`='".$str2."' where `ProductTypeID`=".$s_id;
}else{
$str_sku="insert into producttypes (`ProductTypeID`, `ProductTypeName`, `SPECCategories`, `SPECType`, `GUID`, `crea_d`, `crea_u`) values ($MCount,'$m0','$str1','$str2','$guid','$now','1782')";
}
$cmd_sku=mysqli_query($link_db,$str_sku);
echo "<script>alert('Copy product Types !');parent.location.reload();parent.jQuery.fancybox.close();</script>";
mysqli_close($link_db);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Tool - copy a product Types</title>
<link type="text/css" href="../lib/css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../lib/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });

				// Progressbar
				$("#progressbar").progressbar({
					value: 20
				});

				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);

});
</script>
</head>
<body>
<form action="?type=copy&pr_id=<?=$pr_PTYPEs?>" name="form1" method="POST" onsubmit="return Final_Check();">
<table border="0" cellspacing="1" cellpadding="4" align="center" id="table1" bgcolor="darkgreen">
<?
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_ptype_m="select * from producttypes where ProductTypeID=".$pr_PTYPEs;
  $cmd_ptype_m=mysqli_query($link_db,$str_ptype_m);
  $record_ptype_m=mysqli_fetch_row($cmd_ptype_m);
  
  if(empty($record_ptype_m)):
  else:
    $PM0=$record_ptype_m[0];
    $PM1=$record_ptype_m[1];
    $PM2=$record_ptype_m[2];
    $PM3=$record_ptype_m[3];    
  endif;
?>
<tr bgcolor="Aquamarine">
<td align="center">ProductTypeName</td>
<td>
<?
if($_REQUEST['types']=='edit'){
$ed01=$PM1;
?>
<input type="hidden" name="SPEC_id" value="<?=$PM0?>">
<?
}
?>
<input type="text" name="M0" value="<?=$ed01?>"></td>
</td>
</tr>
<tr bgcolor="Aquamarine">
<td align="center">SPEC Categories</td>
<td>

<div id="accordion">
      <?
      $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
      //$select=mysqli_select_db($dataBase, $link_db);
	  $str_all="select sum(SPECCategoryID) as t_count from speccategroies order by SPECCategoryID";
      $result_all=mysqli_query($link_db,$str_all);
      $data_all=mysqli_fetch_array($result_all);
      $d_total=$data_all[t_count];      
      $str_type_s="select SPECCategoryID,SPECCategoryName,IsShow FROM speccategroies";
      $types_result=mysqli_query($link_db,$str_type_s);
      while($data=mysqli_fetch_row($types_result)){
      ?>
      <input name="speccate[]" type="checkbox" value="<?=$data[0];?>" <? if(preg_match("/".$data[0]."/i",$PM2)!='') { echo "checked"; } ?> /> <?=$data[1];?>
			<div>
				<h3> <a href="#"></a></h3>        
        <div>
        <table>
        <tr>
        <?
        $str_sectype="select SPECTypeID,SPECCategoryID,SPECTypeName,IsShow FROM spectypes where SPECCategoryID=".$data[0];
        $sectype_result=mysqli_query($link_db,$str_sectype);
        while($stdata=mysqli_fetch_row($sectype_result)){
        $i=$i+1;
        ?>
        <td><input name="spectype[]" type="checkbox" value="<?=$stdata[0];?>" <? if(preg_match("/".$stdata[0]."/i",$PM3)!='') { echo "checked"; } ?> /> <?=$stdata[2];?></td>
        <?
        }
        ?>
        </tr>        
        </table>
        </div>
			</div>
      <?
      }
      ?>
</div>
</td>
</tr>
</tr>
<tr bgcolor="Aquamarine">
<td align="center"></td>
<td></td>
</tr> 
<tr bgcolor="Aquamarine"><td align="center" colspan="2"><input type="submit" value="Copy"></td></tr>
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