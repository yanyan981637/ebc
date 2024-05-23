<?php
if($_REQUEST['kinds']=='add_icon'){
  
  if($_POST['getIcon']!=''){
  foreach($_POST['getIcon'] as $getIcon)
  {
	$getIconlist=$getIconlist.$getIcon.",";
  }
  }else{
    $getIconlist='';
  }
//echo $getIconlist;
echo "<script language='Javascript'>";
echo "try{";
echo "  if(parent.window.opener != null && !parent.window.opener.closed)";
echo "  {";
echo "    parent.window.opener.document.forms['form1'].iconvals.value = '".$getIconlist."'";
//echo "	  parent.window.opener.test_call()";
echo "  }";
echo "  ";
echo "  }catch(e){ alert(e.description);}";
//echo "parent.location.reload();parent.jQuery.fancybox.close()";
echo "parent.jQuery.fancybox.close()";
echo "</script>\n";
//echo "<script language='Javascript'>alert('".$getIconlist."');parent.jQuery.fancybox.close();</script>\n";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Product icons</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<script type="text/javascript" src="../jquery.min.js"></script>
<style type="text/css">
table{border:0px solid #c0c0c0; width:90%}
td{ padding:5px 15px; cursor: pointer;}
td:hover{background: #dcf2fd;}
</style>
<script language="JavaScript">
<!--
  /*
  function icon_val() {  
  try{
        if(parent.window.opener != null && !parent.window.opener.closed)
        {
          parent.window.opener.document.forms["form1"].iconvals.value = "test";
        }

    }catch(e){ alert(e.description);} 
  parent.jQuery.fancybox.close();
  }
  */
//-->
</script>
</head>
<body style="backbround:#f9f9f9">
<h2 >Select icons:</h2>
<p class="clear"></p>
<!--<input type="button" value="change Value" onclick="icon_val()">-->
<form id="form_child" name="form_child" method="post" action="?kinds=add_icon">
<table>
<tr>
<td >
<?
$path = '../../images/logo/';
$ite = new RecursiveDirectoryIterator($path);

foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
  $i+=1;
  $fn = $cur->getBasename();
  if($cur->isDir() || ($fn == '.' || $fn == '..')) continue;
  $filename=str_replace('../../images/logo', '', $filename);
  
  $ext = substr($filename, strrpos($filename, '.') + 1); //得到副檔名稱
  
  if($ext=='gif' || $ext=='jpg' || $ext=='png'){
  
  //if(strpos($filename,"")!=''){
   //echo stripslashes($filename), '<br />';
   $filename=stripslashes($filename);
   $filename_vals=str_replace('big', '', $filename);
   $filename_src=$path.$filename_vals;
  //}
  
  }
  if($i%6==0){
  $br01="<br />";
  }else{
  $br01="";
  }
?>
<input id="getIcon[]" name="getIcon[]" type="checkbox" value="<?=$filename_vals;?>" /> <img src="<?=$filename_src;?>" alt="<?=$filename_vals;?>" /><?=$br01;?>
<?
}
?>
</td>
</tr>
</table>
<p style="padding:5px 20px;"><input type="submit" value="Done" /></p>
</form>
<P style="color:#0F0">- default列出在icon module 中所建立的所有icons, 可以選擇(多選)。最新增的列在最前面 <br></p>
</body>
</html>