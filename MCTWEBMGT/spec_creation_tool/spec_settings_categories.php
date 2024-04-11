<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../login.php'</script>";
exit();
}

require "../config.php";
include_once('../page.class.php');

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_REQUEST['d_id'])!="")
{
$d1=intval($_REQUEST['d_id']);
$str_d="delete FROM speccategroies where SPECCategoryID=".$d1;
$cmd_d=mysqli_query($link_db,$str_d);
echo "<script>alert('Dele SPEC Categories !');location.href='spec_settings_categories.php';</script>";
exit();
}

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='edit_SPECCategroies'){
if(isset($_POST['EPM1'])!=''){
	$em1=str_replace("'","&#39;",$_POST['EPM1']);
//$em1=trim($_POST['EPM1']);
}else{
$em1="";
}

if(isset($_POST['EProductTID'])!=''){
foreach($_POST['EProductTID'] as $check2) {
$str2=$str2.$check2.",";
}
}else{
$str2="";
}

if(isset($_POST['e_tips'])!=''){
	$e_tips=str_replace("'","&#39;",$_POST['e_tips']);
}else{
	$e_tips="";
}


putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

if(isset($_POST['SPEC_id'])!=''){
$s_id=intval($_POST['SPEC_id']);
$str_c="update speccategroies set SPECCategoryName='".$em1."',producttypeList='".$str2."',upd_d='".$now."',upd_u='1782', Tooltips='".$e_tips."'  where SPECCategoryID=".$s_id;
$cmd_c=mysqli_query($link_db,$str_c);
}
echo "<script>alert('Mod SPEC Category !');location.href='spec_settings_categories.php';</script>";
exit();
}
}

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='add_SPECCategroies'){
$str_m="select SPECCategoryID FROM speccategroies order by SPECCategoryID desc limit 1";
$check_m=mysqli_query($link_db,$str_m);
$Max_SOptionID=mysqli_fetch_row($check_m);
$MCount=$Max_SOptionID[0]+1;

$str_s="select max(SPECCategorySort) as SC_Count FROM speccategroies";
$check_s=mysqli_query($link_db,$str_m);
$Max_SOptionSort=mysqli_fetch_row($check_m);
$SCount=$Max_SOptionSort[0]+1;

if(isset($_POST['PM1'])!=''){
	$m1=str_replace("'","&#39;",$_POST['PM1']);
}else{
	$m1="";
}
if(isset($_POST['add_tips'])!=''){
	$tips=str_replace("'","&#39;",$_POST['add_tips']);
}else{
	$tips="";
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
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
        return $uuid;
    }
}
$guid = getGUID();
$guid = preg_replace("/{/i", '', $guid);
$guid = preg_replace("/}/i", '', $guid);

if(isset($_POST['ProductTID'])!=''){
foreach($_POST['ProductTID'] as $check1) {
$str1=$str1.$check1.",";
}
}else{
$str1="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

$str_sku="insert into speccategroies (SPECCategoryID, SPECCategoryName, producttypeList, WebOrder, crea_d, crea_u, IsShow, SPECCategorySort, Tooltips) values ($MCount,'$m1','$str1','','$now','1782','1','$SCount', '$tips')";
$cmd_sku=mysqli_query($link_db,$str_sku);
echo "<script>alert('Add SPEC Category !');location.href='spec_settings_categories.php';</script>";
exit();
}
}

if(isset($_REQUEST['s_search'])<>''){
$s_search=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['s_search']));
$str1="select count(*) from speccategroies where SPECCategoryName like '%".$s_search."%'";
}else{
$str1="select count(*) from speccategroies";
}
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Creation Tool - SPEC Settings</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<link rel="stylesheet" type="text/css" href="../css/css.css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<script language="JavaScript">
<!--
 document.onkeydown = function() {   
 if (window.event)   
 if (event.keyCode == 13 && event.srcElement.nodeName != "TEXTAREA" && event.srcElement.type != "submit")   
 event.keyCode = 9;   
 }
  function Del_id(t_id){    
    if(confirm("確定要刪除此筆資料嗎？")) {
    self.location="?d_id="+t_id;
    }else{
    }
  }
  function search_value(){
    self.location = "?s_search=" + document.form3.sear_txt.value;
    return false;
 }
//-->
</script>

<script language="JavaScript">
function hiden_add(){
self.location="spec_settings_categories.php";
}
function hiden_edit(){
self.location="spec_settings_categories.php";
}
function show_add(){
$("#categories_add").show();//顯示
$("#categories_edit").hide();
}
function show_edit(){
$("#categories_add").hide();
$("#categories_edit").show();//顯示
}
function MM_o(selObj){
window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}    
</script>

<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
	  $(document).ready(function() {     
      $("#Fancy_iframe_edit1").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit2").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit3").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit4").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit5").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit6").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit7").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit8").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit9").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit10").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit11").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit12").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit13").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit14").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit15").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit16").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit17").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit18").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit19").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      
      $("#Fancy_iframe_edit20").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit21").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit22").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit23").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit24").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      $("#Fancy_iframe_edit25").fancybox({
				'width'				: '80%',
				'height'			: '60%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
      

    });
</script>    
 
</head>

<body><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
<div id="logout">Hi <b><?=str_replace('@mic.com.tw', '', $_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("./menu.php");
?>
<div class="clear"></div>
<div id="Search" ><h2><a href="spec_settings.php">SPEC Settings</a> &nbsp;&gt;&nbsp; Categories</h2></div>
<p class="clear"></p>
<div id="content">
<h3 class="left">SPEC Settings - Categories List</h3>
<!--datatable start here-->
<p class="clear"></p>
<div>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
<div class="left">
<form id="form3" name="form3" method="post" action="spec_settings_categories.php">
 <input name="sear_txt" type="text" size="20" value="" onkeydown="{if(event.keyCode==13)search_value();else if(event.which==13)search_value();else if(event.charCode==13)search_value()}" /> <input type="button" value="Search" onclick="search_value();">
</form> 
 </div>
</div>
<p class="clear"></p>
<?php
      if(isset($_REQUEST['PSPEC'])<>''){
      
          $PSPEC_Value_str=trim($_REQUEST['PSPEC']);      
          
          $PSC01="SPECCategoryName";
          $CD01="crea_d";
          $CU01="crea_u";
          $PD01="upd_d";
          $PU01="upd_u";
          
          if($PSPEC_Value_str=="SPECCategoryName"){
          $PSPEC_Value=$PSPEC_Value_str;
          $PSC01="SPECCategoryName_A";
          $P_value="Desc";          
          }else if($PSPEC_Value_str=="SPECCategoryName_A"){
          $PSPEC_Value="SPECCategoryName";
          $PSC01="SPECCategoryName";
          $P_value="Asc";
          }
      
          if($PSPEC_Value_str=="crea_d"){
          $PSPEC_Value=$PSPEC_Value_str;
          $CD01="crea_d_A";
          $P_value="Desc";          
          }else if($PSPEC_Value_str=="crea_d_A"){
          $PSPEC_Value="crea_d";
          $CD01="crea_d";
          $P_value="Asc";
          }
          
          if($PSPEC_Value_str=="crea_u"){
          $PSPEC_Value=$PSPEC_Value_str;
          $CU01="crea_u_A";
          $P_value="Desc"; 
          }else if($PSPEC_Value_str=="crea_u_A"){
          $PSPEC_Value="crea_u";
          $CU01="crea_u";
          $P_value="Asc";
          }
          
          if($PSPEC_Value_str=="upd_d"){
          $PSPEC_Value=$PSPEC_Value_str;
          $PD01="upd_d_A";
          $P_value="Desc"; 
          }else if($PSPEC_Value_str=="upd_d_A"){
          $PSPEC_Value="upd_d";
          $PD01="upd_d";
          $P_value="Asc";
          }
          
          if($PSPEC_Value_str=="upd_u"){
          $PSPEC_Value=$PSPEC_Value_str;
          $PU01="upd_u_A";
          $P_value="Desc"; 
          }else if($PSPEC_Value_str=="upd_u_A"){
          $PSPEC_Value="upd_u";
          $PU01="upd_u";
          $P_value="Asc";
          }
          
      }else{
      
          $PSPEC_Value="upd_d";
      
          $PSC01="SPECCategoryName";
          $CD01="crea_d";
          $CU01="crea_u";
          $PD01="upd_d";
          $PU01="upd_u";
          $P_value="Desc";
      }
?>
<table class="list_table">
	<tr>
	<th ><a href="?PSPEC=<?=$PSC01;?>" STYLE="text-decoration:none">*Category Name</a></th>
	<th width="160"><a href="?PSPEC=<?=$CD01;?>" STYLE="text-decoration:none">*Creation Date</a></th>
	<th width="100"><a href="?PSPEC=<?=$CU01;?>" STYLE="text-decoration:none">*Created by</a></th>
	<th width="160"><a href="?PSPEC=<?=$PD01;?>" STYLE="text-decoration:none">*Update Date</a></th>
    <th width="100"><a href="?PSPEC=<?=$PU01;?>" STYLE="text-decoration:none">*Updated by</a></th>
    <th onClick="" width="120"><div class="button14" style="width:100px;"><a href="#categories_add" onClick="show_add();">Add New</a></div></th>
	</tr>
  <?php
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";
      
      $read_num="20";
      $start_num=$read_num*($page-1);      
			
      if(isset($_REQUEST['s_search'])<>''){
      	$s_search=preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['s_search']));
      //$str="SELECT * FROM speccategroies where SPECCategoryName like '%".$s_search."%' ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
      	$str="SELECT * FROM speccategroies where SPECCategoryName like '%".$s_search."%' ORDER BY crea_d desc limit $start_num,$read_num;";
      }else{
      //$str="SELECT * FROM speccategroies ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
      	$str="SELECT * FROM speccategroies ORDER BY crea_d desc limit $start_num,$read_num;";
      	
      }
      
      $result=mysqli_query($link_db, $str);
      $i=0;
	  while(list($SPECCategoryID,$SPECCategoryName,$producttypeList,$WebOrder,$crea_d,$crea_u,$upd_d,$upd_u,$IsShow,$SPECCategorySort)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
	<tr >
		<td><?=$SPECCategoryName;?></td>
		<td><?=$crea_d;?></td>
		<td><?=$crea_u;?></td> 
		<td><?=$upd_d;?></td>
		<td><?=$upd_u;?></td>
		<!--<td>-->
    <?php
    ?>
    <!--</td>-->
		<td><a href="spec_settings_categories.php?csc_id=<?=$SPECCategoryID;?>&types=edit#categories_edit">Edit</a>&nbsp;&nbsp;<!--<input type="button" name="D_This" value="Del" onClick="Del_id(<?=$SPECCategoryID;?>);" disabled>--></td>
	</tr>
  <?php
      }
  ?>
  <tr>
    <td colspan="7">
    <?php
        $all_page=ceil($public_count/$read_num);
        $pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);       
    ?>
    </td>
  </tr>
</table>
<div class="sabrosus">
<span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?></div>
<p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
<!--end of datatable -->
<?php
$PM0="";$PM1=0;$PM2="";
if(isset($_REQUEST['csc_id'])<>""){
  $csc_id=intval($_REQUEST['csc_id']);
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_sc_m="select * from speccategroies where SPECCategoryID=".$csc_id;
  $cmd_sc_m=mysqli_query($link_db,$str_sc_m);
  $record_sc_m=mysqli_fetch_row($cmd_sc_m);
  
  if(empty($record_sc_m)):
  else:
    $PM0=$record_sc_m[0];
    $PM1=$record_sc_m[1];
    $PM2=$record_sc_m[2];
    $etips=$record_sc_m[10];
  endif;
}  
?>
<div id="categories_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=edit_SPECCategroies" onsubmit="return EFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
<table class="editspec">
<tr><td colspan="2"></td></tr>
<tr>
<th>Category Name:</th>
<td><input type="hidden" name="SPEC_id" value="<?=$PM0?>"><input name="EPM1" type="text" size="40" value="<?=$PM1?>" />  </td>
</tr>
<tr>
<th>Tooltips:</th>
<td><input name="e_tips" type="text" size="40" value="<?=$etips?>" />  </td>
</tr>

<tr>
<th><!--Applied Product Types:--></th>
<td>
<?php
$str2="select ProductTypeID,ProductTypeName FROM producttypes";
$cmd_str2=mysqli_query($link_db,$str2);
while($data2=mysqli_fetch_row($cmd_str2)){
?>
<input name="EProductTID[]" type="checkbox" value="<?=$data2[0];?>" <?php if(strpos($PM2,$data2[0])!='' || strpos($PM2,$data2[0])===0){ echo "checked"; } //if(eregi($data2[0],$PM2)!='') { echo "checked"; } ?> style="display:none" /> <? //echo $data2[1];?>&nbsp;
<?php
}
?>
</td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function EFinal_Check( ) {

if ( document.form2.EPM1.value == "" ) {
alert ("請選擇 CategoryName！");
document.form2.EPM1.focus();
return false;
}

return true;
}
</script>
</div>

<!--Click Edit, Add Category & View category-->
<div id="categories_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_SPECCategroies" onsubmit="return Final_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"></td></tr>
<tr>
<th>Category Name:</th>
<td><input name="PM1" type="text" size="40" value=""  />  </td>
</tr>
<th>Tooltips:</th>
<td><input name="add_tips" type="text" size="40" value=""  />  </td>
</tr>
<tr>
<th><!--Applied Product Types:--></th>
<td>
<?php
$str2="select ProductTypeID,ProductTypeName FROM producttypes";
$cmd_str2=mysqli_query($link_db,$str2);
while($data2=mysqli_fetch_row($cmd_str2)){
?>
<input name="ProductTID[]" type="checkbox" value="<?=$data2[0];?>" style="display:none" /> <? //echo $data2[1];?>&nbsp;
<?php
}
?>
</td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check(){
if ( document.form1.PM1.value == "" ) {
alert ("請選擇 CategoryName！");
document.form1.PM1.focus();
return false;
}
return true;
}
</script>
</div>
<!--end of edit -->	
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>
<?php
if(isset($_REQUEST['csc_id'])<>""){
echo "<script language='Javascript'>show_edit();</script>\n";
}
exit();
?>