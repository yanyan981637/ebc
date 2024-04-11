<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");

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

if(isset($_REQUEST['Speccat_id'])<>""){
$Speccat_id=intval($_REQUEST['Speccat_id']);
}else{
$Speccat_id="";
}

if(isset($_REQUEST['d_id'])!=""){
$d1=intval($_REQUEST['d_id']);
$str_d="delete FROM SPECTypes where SPECTypeID=".$d1;
//$cmd_d=mysqli_query($link_db,$str_d);
 if($cmd_d=mysqli_query($link_db,$str_d)){
 echo "<script>alert('Dele SPEC Types !');location.href='spec_settings_types.php';</script>";
 exit();
 }
}

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='edit_spectypes'){

if(isset($_POST['Check_EPSPEC'])!=''){
$Check_EPSPEC=trim($_POST['Check_EPSPEC']);
}else{
$Check_EPSPEC="";
}
if(isset($_POST['ESM00'])!=''){
$em00=trim($_POST['ESM00']);
}else{
$em00="";
}
if(isset($_POST['ESM0'])!=''){
$em0=trim($_POST['ESM0']);
}else{
$em0="";
}
if(isset($_POST['ESM1'])!=''){
$em1=trim($_POST['ESM1']);
$em1 = str_replace("'","&#39;",$em1);
}else{
$em1="";
}
if(isset($_POST['SEL_EPSPEC'])!=''){
$sepc1=trim($_POST['SEL_EPSPEC']);	
}else{
$sepc1="";
}
if(isset($_POST['spectype_esorts'])!=''){
$ste01=trim($_POST['spectype_esorts']);
}else{
$ste01="";
}
if(isset($_POST['spectype_ePsorts'])!=''){
$Pste01=trim($_POST['spectype_ePsorts']);
}else{
$Pste01="";
}

if(isset($_POST['ESM3'])!=''){
$em3=trim($_POST['ESM3']);
$em3 = str_replace("'","&#39;",$em3);
}else{
$em3="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($Check_EPSPEC=='ETop1'){  
  if($em00!=''){                                                                        
  $str1="update `spectypes` set `SPECCategoryID`=".$em0.",`SPECTypeName`='".$em1."',`ParentSpec`=NULL,`InputTypeID`=3,`upd_d`='".$now."',`upd_u`='1782',`SPECTypeSort`=".$ste01.", `ParentSort`='".$Pste01."', `Tooltips`='".$em3."' where `SPECTypeID`=".$em00;
  }
}else{
  if($em00!=''){
  $str1="update `spectypes` set `SPECCategoryID`=".$em0.",`SPECTypeName`='".$em1."',`ParentSpec`=".$sepc1.",`InputTypeID`=1,`upd_d`='".$now."',`upd_u`='1782',`SPECTypeSort`=".$ste01.", `ParentSort`='".$Pste01."', `Tooltips`='".$em3."' where `SPECTypeID`=".$em00;
  }
}
//echo $str1;exit();
$cmd_c=mysqli_query($link_db,$str1);
//echo "<script>alert('Mod SPEC Types !');location.href='spec_settings_types.php?spectype_id=".$em00."#types_edit';</script>";
echo "<script>alert('Mod SPEC Types !');location.href='spec_settings_types.php?page=1&c_search=".$em0."#types_edit';</script>";
exit();
}

if(trim($_REQUEST['kinds'])=='add_spectypes'){

$str_m="select SPECTypeID FROM spectypes order by SPECTypeID desc";
$check_m=mysqli_query($link_db,$str_m);
$Max_SOptionID=mysqli_fetch_row($check_m);
$MCount=$Max_SOptionID[0]+1;

if(isset($_POST['Check_PSPEC'])!=''){
$Chk_Types=trim($_POST['Check_PSPEC']);
}else{
$Chk_Types="";
}
if(isset($_POST['SEL_PSPEC'])!=''){
$methods=trim($_POST['SEL_PSPEC']);
}else{
$methods="";
}
if(isset($_POST['SM0'])!=''){
$m0=trim($_POST['SM0']);
}else{
$m0="";
}
if(isset($_POST['SM1'])!=''){
$m1=trim($_POST['SM1']);
$m1 = str_replace("'","&#39;",$m1);
}else{
$m1="";
}
if(isset($_POST['spectype_sorts'])!=''){
$st01=trim($_POST['spectype_sorts']);
}else{
$st01="";
}
if(isset($_POST['spectype_Psorts'])!=''){
$Pst01=trim($_POST['spectype_Psorts']);
}else{
$Pst01="";
}

if(isset($_POST['SM3'])!=''){
$m3=trim($_POST['SM3']);
$m3 = str_replace("'","&#39;",$m3);
}else{
$m3="";
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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s"); 

if($Chk_Types=='Top1'){
$str_sku="insert into spectypes (`SPECTypeID`, `SPECCategoryID`, `SPECTypeName`, `WebOrder`, `InputTypeID`, `GUID`, `crea_d`, `crea_u`, `IsShow`, `SPECTypeSort`, `ParentSort`, `Tooltips`) values ($MCount,$m0,'$m1',1,2,'$guid','$now','1782','1','$st01', '$Pst01', '$m3')";
}else{
$str_sku="insert into spectypes (`SPECTypeID`, `SPECCategoryID`, `SPECTypeName`, `WebOrder`, `ParentSpec`, `InputTypeID`, `GUID`, `crea_d`, `crea_u`, `IsShow`, `SPECTypeSort`, `ParentSort`, `Tooltips`) values ($MCount,$m0,'$m1',1,$methods,1,'$guid','$now','1782','1','$st01', '$Pst01', '$m3')";
}

$cmd_sku=mysqli_query($link_db,$str_sku);
echo "<script>alert('Add SPEC Types !');location.href='spec_settings_types.php';</script>";
exit();
}
}

if(isset($_REQUEST['c_search'])!=''){
$c_search=trim($_REQUEST['c_search']);
$str1="select count(*) from spectypes where SPECCategoryID=".$c_search;
}else if(isset($_REQUEST['c_search'])==''){
$str1="select count(*) from spectypes";
}
$list1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Creation Tool - SPEC Settings</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<link rel="stylesheet" type="text/css" href="../css/css.css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script language="JavaScript">
function Chk_Type(){

  var CK_SPE=document.form1.elements["Check_PSPEC"];
  if(CK_SPE.checked){
    $("#PESPEC_add01").show();
    $("#SEL_PSPEC").hide();
	//$("#spectype_sorts").hide();
  }else{
    $("#PESPEC_add01").show();
    $("#SEL_PSPEC").show();
	//$("#spectype_sorts").show();
  }
}

function Chk_EType(){

  var CK_ESPE=document.form3.elements["Check_EPSPEC"];
  if(CK_ESPE.checked){
    $("#SEL_EPSPEC").hide();
  }else{
    $("#SEL_EPSPEC").show();
  }
}

function Del_id(t_id){    
if(confirm("確定要刪除此筆資料嗎?")){
self.location="?d_id="+t_id;
}else{
}
}

function hiden_add(){
//$("#types_add").hide();//隱藏
self.location="spec_settings_types.php";
}

function hiden_edit(){
//$("#types_edit").hide();//隱藏
self.location="spec_settings_types.php";
}

function show_add(){
$("#types_add").show();//顯示
$("#types_edit").hide();
}

function show_edit(){
$("#types_add").hide();
$("#types_edit").show();//顯示
}
function MM_o(selObj){
//window.open(document.all.pskus_page.options[document.all.pskus_page.selectedIndex].value,"_self");
window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

function MM_sc(selObj){
window.open(document.getElementById('sear_Category').options[document.getElementById('sear_Category').selectedIndex].value,"_self");
}

function MM_u(selObj){
//window.open(document.all.SEL_spccateg.options[document.all.SEL_spccateg.selectedIndex].value,"_self");
window.open(document.getElementById('SEL_spccateg').options[document.getElementById('SEL_spccateg').selectedIndex].value,"_self");
}
function MM_e(selObj){
//window.open(document.all.SEL_espccateg.options[document.all.SEL_espccateg.selectedIndex].value,"_self");
window.open(document.getElementById('SEL_espccateg').options[document.getElementById('SEL_espccateg').selectedIndex].value,"_self");
}    
</script>

<script type="text/javascript">
$(function() {
  
  $("#Check_PSPEC").change(function() {
    if($(this).val()=="Top"){
    $("#PESPEC_add01").show();
    $("#PESPEC_add02").hide();
    $("#SEL_PSPEC").hide();
    }else if($(this).val()==""){
    $("#PESPEC_add01").hide();
    $("#PESPEC_add02").hide();
    $("#SEL_PSPEC").hide();
    }else if($(this).val()=="Sub"){
    $("#PESPEC_add02").show();
    $("#PESPEC_add01").hide();
    $("#SEL_PSPEC").show();
    }
  });
  
});
</script>
</head>
<body><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
<div id="logout">Hi <b><?=str_replace('@mic.com.tw','',$_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("./menu.php");
?>
<div class="clear"></div>
<div id="Search">
<h2><a href="spec_settings.php">SPEC Settings</a> &nbsp;&gt;&nbsp; Types</h2>
</div>
<p class="clear"></p>
<div id="content">
<h3 class="left">SPEC Settings - Types List</h3>
<!--datatable start here-->
<p class="clear"></p>
<div>

<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
<div class="left" style="margin-right:20px">
<!--<form id="form2" name="form2" method="post" action="spec_settings_types.php">-->
<!--<input name="sear_txt" type="text" size="20" value=""  />-->
<select id="sear_Category" name="sear_Category" onChange="MM_sc(this)">
<option selected="selected" value="">Select Category..</option>
<?php
$str="select SPECCategoryID,SPECCategoryName,producttypeList from speccategroies where 1 order by SPECCategoryName";
$str_result=mysqli_query($link_db,$str);
while($data_ss=mysqli_fetch_row($str_result)){
?>
<option value="?page=<?php echo "1"; //$page;?>&c_search=<?=$data_ss[0];?>"><?=$data_ss[1];?></option>
<?php
}
?>
</select> <!--<input type="submit" value="Search"  />-->
</form>
</div>

</div>
<p class="clear"></p>
<?php
      if(isset($_REQUEST['PSPEC'])<>''){
        
        $PSPEC_Value_str=trim($_REQUEST['PSPEC']);
        
        $PSG01="SPECCategoryID";
        $PST01="SPECTypeName";
        $PPR01="ParentSpec";
        $PD01="upd_d";
        $PU01="upd_u";
        
        if($PSPEC_Value_str=="SPECCategoryID"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PSG01="SPECCategoryID_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="SPECCategoryID_A"){
        $PSPEC_Value="SPECCategoryID";
        $PSG01="SPECCategoryID";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="SPECTypeName"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PST01="SPECTypeName_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="SPECTypeName_A"){
        $PSPEC_Value="SPECTypeName";
        $PST01="SPECTypeName";
        $P_value="Asc";
        }
        
        if($PSPEC_Value_str=="ParentSpec"){
        $PSPEC_Value=$PSPEC_Value_str;
        $PPR01="ParentSpec_A";
        $P_value="Desc";
        }else if($PSPEC_Value_str=="ParentSpec_A"){
        $PSPEC_Value="ParentSpec";
        $PPR01="ParentSpec";
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
        
        $PSG01="SPECCategoryID";
        $PST01="SPECTypeName";
        $PPR01="ParentSpec";
        $PD01="upd_d";
        $PU01="upd_u";
        $P_value="Desc";
      }
?>
<table class="list_table">
	<tr>
	<th><a href="?PSPEC=<?=$PSG01;?>" STYLE="text-decoration:none">*Category Name</a></th>
	<th width="400"><a href="?PSPEC=<?=$PST01;?>" STYLE="text-decoration:none">*Type Name</a></th>
	<th width="100"><a href="?PSPEC=<?=$PPR01;?>" STYLE="text-decoration:none">*Top Type</a></th>
  <th width="100"><a href="" STYLE="text-decoration:none">*Order</a></th>
  <th width="100"><a href="" STYLE="text-decoration:none">*ParentOrder</a></th>
	<th width="160"><a href="?PSPEC=<?=$PU01;?>" STYLE="text-decoration:none">*Update Date</a></th>
  <th width="100"><a href="?PSPEC=<?=$PU01;?>" STYLE="text-decoration:none">*Updated by</a></th>
  
    <!--<th><a href="?PSPEC=" STYLE="text-decoration:none">Product Types</a></th>-->
    <th onClick="#" width="120"><div class="button14" style="width:100px;"><a href="#types_add" onClick="show_add();" STYLE="text-decoration:none">Add New</a></div></th> 
	</tr>
  <?php
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }      
      if(empty($page))$page="1";
      
      $read_num="25";
      $start_num=$read_num*($page-1);      
            
      //if($_POST['sear_txt']<>'' || $_POST['sear_Category']<>''){
      if(isset($_REQUEST['c_search'])<>''){
        $c_search=trim($_REQUEST['c_search']);
        $str="SELECT `SPECTypeID`, `SPECCategoryID`, `SPECTypeName`, `ParentSpec`, `crea_d`, `crea_u`, `upd_d`, `upd_u`, `SPECTypeSort`, `ParentSort` from spectypes where SPECCategoryID=".$c_search." and SPECTypeName like '%%' ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
      }else{
		    $str="SELECT `SPECTypeID`, `SPECCategoryID`, `SPECTypeName`, `ParentSpec`, `crea_d`, `crea_u`, `upd_d`, `upd_u`, `SPECTypeSort`, `ParentSort` FROM spectypes ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
	    }
      $result=mysqli_query($link_db, $str);
      $i=0;
	   while(list($SPECTypeID,$SPECCategoryID,$SPECTypeName,$ParentSpec,$crea_d,$crea_u,$upd_d,$upd_u,$SPECTypeSort,$ParentSort)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
	<td>
    <?php
    $str1="select SPECCategoryID,SPECCategoryName,producttypeList from speccategroies where SPECCategoryID=".$SPECCategoryID;
    $str1_result=mysqli_query($link_db,$str1);
    $data_s=mysqli_fetch_row($str1_result);
    echo $data_s[1];
    ?></td>
	<td><?=$SPECTypeName;?></td>
	<td>
    <?php
    if($ParentSpec!=''){
    $str_type_p="select SPECTypeName from `spectypes` where SPECTypeID=".$ParentSpec;
	$type_presult=mysqli_query($link_db,$str_type_p);
    $data_p=mysqli_fetch_row($type_presult);
    echo $data_p[0];
    }
    ?></td>
  <td><?=$SPECTypeSort;?></td> 
  <td><?=$ParentSort;?></td> 
	<td><?=$upd_d;?></td>
	<td><?=$upd_u;?></td>
	<!--<td>-->
    <?php
    /*
    $producttypeList = split(",",$data_s[2]);    
    for($k=0;$k<count($producttypeList)-1;$k++){    
    $str_type="select ProductTypeID,ProductTypeName FROM producttypes where ProductTypeID=".$producttypeList[$k];
    $type_result=mysqli_query($link_db,$str_type);
    $data=mysqli_fetch_array($type_result);
    echo $data[1].",";  
    }
    */ 
    ?>
    <!--</td>-->
	<td><a href="spec_settings_types.php?spectype_id=<?=$SPECTypeID;?>#types_edit">Edit</a>&nbsp;&nbsp;
    <?php //echo "<input type=button name=D_This value=Del onClick=Del_id(".$SPECTypeID.");>"; ?>
    </td>
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
<option value="?page=<?=$j?>&s_search=<?=$s_search?>&c_search=<?=$c_search;?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?></div>
<p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
<!--end of datatable -->
<!--Click Edit, Add Category & View category-->

<div id="types_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_spectypes" onsubmit="return Final_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"><!--<input name="" type="button" value="Delete" disabled /> --></td></tr>
<tr>
<th>Category Name:</th>
<td>
<select id="SEL_spccateg" name="SEL_spccateg" onChange="MM_u(this)">
<option value="">Select...</option>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECC="select * from speccategroies order by SPECCategoryName";
$SPECC_result=mysqli_query($link_db,$str_SPECC);
while(list($SPECCategoryID,$SPECCategoryName,$producttypeList)=mysqli_fetch_row($SPECC_result))
{
?>
<option value="?Speccat_id=<?=$SPECCategoryID;?> #types_add" <?php if(intval($Speccat_id)==$SPECCategoryID){ echo "selected"; }?>><?=$SPECCategoryName?></option>
<?php
}
mysqli_close($link_db);
?>
</select>
<input name="SM0" type="hidden" value="<?=intval($Speccat_id);?>" />
</td>
</tr>
<tr>
<th>Type Name:</th>
<td>
<?php
if(isset($_REQUEST['Speccat_id'])<>''){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_tyMax="select SPECTypeSort FROM spectypes where ParentSpec IS NULL and SPECCategoryID=".intval($_REQUEST['Speccat_id'])." order by SPECTypeID desc limit 1";
$tyMax_m=mysqli_query($link_db,$str_tyMax);
$Max_tyMaxID=mysqli_fetch_row($tyMax_m);
$MTCount=$Max_tyMaxID[0]+1;
mysqli_close($link_db);
}else{
$MTCount="";
}
?>
<div id="PESPEC_add01" style="display:''"><input name="SM1" type="text" size="40" value=""  /><input type="hidden" name="SM2" value="<?=intval($Speccat_id);?>"></div> Order: <input id="spectype_sorts" name="spectype_sorts" style="display:''" type="text" size="2" value="<?=$MTCount;?>" /> ParentOrder: <input id="spectype_Psorts" name="spectype_Psorts" style="display:''" type="text" size="2" value="" /> <input type="checkbox" id="Check_PSPEC" name="Check_PSPEC" value="Top1" onclick="Chk_Type()" <?php echo "checked"; ?> style="display:none" /> <!--As a Top Type-->
</td>
</tr>
<tr>
<th>Top Type:
<?php
/*
if(isset($_REQUEST['Speccat_id'])!=''){
}else{
$_REQUEST['Speccat_id']=108;
}
*/
$pspec_chk_val="";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
//$str_pspec_chk="select distinct ParentSpec from spectypes where ParentSpec IS NOT NULL and SPECCategoryID=".intval($Speccat_id);
$str_pspec_chk="select distinct SPECTypeID from spectypes where ParentSpec IS NULL and SPECCategoryID=".intval($Speccat_id);
$pspec_chk_result=mysqli_query($link_db,$str_pspec_chk);
while($pspec_chk_data=mysqli_fetch_row($pspec_chk_result)){
	$pspec_chk_val.=$pspec_chk_data[0].",";
}
//echo substr($pspec_chk_val,0,strlen($pspec_chk_val)-1);
mysqli_close($link_db);
?>
</th>
<td> <!--下拉選單列出這個category 下的所有types-->
    <select id="SEL_PSPEC" name="SEL_PSPEC" style="display:none">
    <option selected="selected" value="">Select from extisting: </option>
    <?php   
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	mysqli_query($link_db,'SET NAMES utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
    mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);
    //$str_pspec="select SPECTypeID,SPECTypeName from SPECTypes where ParentSpec IS NULL and InputTypeID >1 and SPECCategoryID=".$_REQUEST['Speccat_id'];
    $str_pspec="select SPECTypeID,SPECTypeName from spectypes where SPECTypeID in (".substr($pspec_chk_val,0,strlen($pspec_chk_val)-1).") and SPECCategoryID=".intval($Speccat_id);
	$pspec_result=mysqli_query($link_db,$str_pspec);
    while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($pspec_result)){
    ?>
    <option value="<?=$SPECTypeID;?>"><?=$SPECTypeName;?></option>
    <?php
    }
    mysqli_close($link_db);
    ?>
    </select>
</td>
</tr>
<!--新增前端頁面在 mouse rollover 時, 顯示的文字說明-->
<tr>
<th>Tooltips:</th>
<td> <input name="SM3" type="text" size="40" value="" /> </td>
</tr>
<tr>
<th>Applied Product Types:</th>
<td>
<?php
if(intval($Speccat_id)<>""){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECC="select * from speccategroies where SPECCategoryID=".$Speccat_id;
$SPECC_cmd=mysqli_query($link_db,$str_SPECC);
$SPECC_str=mysqli_fetch_row($SPECC_cmd);
//echo $SPECC_str[2];

$SPECC_value=preg_split("/,/i",$SPECC_str[2]);
    
    for($m=0;$m<count($SPECC_value)-1;$m++){    
    $strw="select ProductTypeID,ProductTypeName FROM producttypes where ProductTypeID=".$SPECC_value[$m];
    $strw_result=mysqli_query($link_db,$strw);
    $data4=mysqli_fetch_row($strw_result);
    echo $data4[1].", ";      
    } 
}
?>
</td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {
if ( document.form1.SM1.value == "" ) {
alert ("請選擇 TypeName！");
document.form1.SM1.focus();
return false;
}
return true;
}
</script>
</div>
<!--end of edit -->
</div>
<?php
$PM0="";$PM1="";$PM2="";$PM4="";$PM12="";
if(isset($_REQUEST['spectype_id'])<>"")
{
  $spectype_id=intval($_REQUEST['spectype_id']);
  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_stype_m="select * from spectypes where SPECTypeID=".$spectype_id;
  $cmd_stype_m=mysqli_query($link_db,$str_stype_m);
  $record_stype_m=mysqli_fetch_row($cmd_stype_m);
  if(empty($record_stype_m)):
  else:
    $PM0=$record_stype_m[0];
    $PM1=$record_stype_m[1];
    $PM2=$record_stype_m[2];
    $PM4=$record_stype_m[4];
    $PM12=$record_stype_m[12]; 
    $PM13=$record_stype_m[13]; 
    $PM14=$record_stype_m[14];    
  endif;
}

if(isset($_REQUEST['Speccat_id'])!=''){
$Speccat_id=intval($_REQUEST['Speccat_id']);
}else{
$Speccat_id=$PM1;
}
?>

<div id="types_edit" class="subsettings" style="display:none">
<form id="form3" name="form3" method="post" action="?kinds=edit_spectypes" onsubmit="return EFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"><!--<input name="" type="button" value="Delete" disabled /> --> </td></tr>
<tr>
<th>Category Name:</th>
<td>

<select id="SEL_espccateg" name="SEL_espccateg" onChange="MM_e(this)">
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECC="select * from speccategroies where SPECCategoryID=".intval($Speccat_id)." order by SPECCategoryName";
$SPECC_result=mysqli_query($link_db,$str_SPECC);
list($SPECCategoryID,$SPECCategoryName,$producttypeList)=mysqli_fetch_row($SPECC_result);
//while(list($SPECCategoryID,$SPECCategoryName,$producttypeList)=mysqli_fetch_row($SPECC_result))
//{
?>
<option value="?Speccat_id=<?=$SPECCategoryID;?>" <?php if($Speccat_id==$SPECCategoryID){ echo "selected"; }?>><?=$SPECCategoryName?></option>
<?php
//}
mysqli_close($link_db);
?>
</select>
<input name="ESM0" type="hidden" value="<?=$Speccat_id;?>"  />
</td>
</tr>
<tr>
<th>Type Name:
<?php
$pspec_echk_val="";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
//$str_pspec_echk="select distinct ParentSpec from spectypes where ParentSpec IS NOT NULL and SPECCategoryID=".intval($Speccat_id);
$str_pspec_echk="select distinct SPECTypeID from spectypes where ParentSpec IS NULL and SPECCategoryID=".intval($Speccat_id);
$pspec_echk_result=mysqli_query($link_db,$str_pspec_echk);
while($pspec_echk_data=mysqli_fetch_row($pspec_echk_result)){
	$pspec_echk_val.=$pspec_echk_data[0].",";
}
//echo substr($pspec_echk_val,0,strlen($pspec_echk_val)-1);
mysqli_close($link_db);
?>
</th>
<td>
<input name="ESM1" type="text" size="40" value="<?=$PM2?>"  /> Order: <input id="spectype_esorts" name="spectype_esorts" style="display:''" type="text" size="2" value="<?=$PM12;?>" /> ParentOrder: <input id="spectype_ePsorts" name="spectype_ePsorts" style="display:''" type="text" size="2" value="<?=$PM13;?>" /> <input type="checkbox" id="Check_EPSPEC" name="Check_EPSPEC" value="ETop1" onclick="Chk_EType()" <?php if($PM4==NULL){echo "checked"; } ?> style="display:none"/> <!--As a Top Type-->
</td>
</tr>
<tr>
<th>Top Type:</th>
<td> <!--下拉選單列出這個category 下的所有types-->
    <select id="SEL_EPSPEC" name="SEL_EPSPEC">
    <?php
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  	mysqli_query($link_db,'SET NAMES utf8');
  	mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  	mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);
    //$str_epspec="select SPECTypeID,SPECTypeName from SPECTypes where ParentSpec is NULL and InputTypeID >1 and SPECCategoryID=".$Speccat_id;
    $str_epspec="select SPECTypeID,SPECTypeName from spectypes where SPECTypeID in (".substr($pspec_echk_val,0,strlen($pspec_echk_val)-1).") and SPECTypeID!=".$PM0." and SPECCategoryID=".$Speccat_id;
	  
    $epspec_result=mysqli_query($link_db,$str_epspec);
    while(list($SPECTypeID,$SPECTypeName)=mysqli_fetch_row($epspec_result)){
    ?>
    <option value="<?=$SPECTypeID;?>" <?php if($SPECTypeID==$PM4) { echo "selected"; } ?>><?=$SPECTypeName;?></option>
    <?php
    }
    mysqli_close($link_db);
    ?>
    </select> <input name="ESM00" type="hidden" value="<?=$PM0;?>" />
</td>
</tr>
<!--新增前端頁面在 mouse rollover 時, 顯示的文字說明-->
<tr>
<th>Tooltips:</th>
<td> <input name="ESM3" type="text" size="40" value="<?=$PM14;?>" /> </td>
</tr>
<tr>
<th>Applied Product Types:</th>
<td>
<?php
if(intval($Speccat_id)<>''){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_SPECC="select * from speccategroies where SPECCategoryID=".$Speccat_id;
$SPECC_cmd=mysqli_query($link_db,$str_SPECC);
$SPECC_str=mysqli_fetch_row($SPECC_cmd);
//echo $SPECC_str[2];

	$SPECC_value=preg_split("/,/i",$SPECC_str[2]);    
    for($m=0;$m<count($SPECC_value)-1;$m++){    
    $strw="select ProductTypeID,ProductTypeName FROM producttypes where ProductTypeID=".$SPECC_value[$m];
    $strw_result=mysqli_query($link_db,$strw);
    $data4=mysqli_fetch_row($strw_result);
    echo $data4[1].", ";      
    } 
}
?>
</td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function EFinal_Check(){
if(document.form3.ESM1.value == ""){
alert ("請選擇 TypeName！");
document.form3.ESM1.focus();
return false;
}
return true;
}
</script>
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>
<?php
if($PM4==NULL){
echo "<script language='Javascript'>Chk_EType();</script>\n";
}else{
echo "<script language='Javascript'>Chk_EType();</script>\n";
}

if(isset($_REQUEST['Speccat_id'])!=""){
echo "<script language='Javascript'>show_add();</script>\n";
}else if(isset($_REQUEST['spectype_id'])!=""){
echo "<script language='Javascript'>show_edit();</script>\n";
}
exit();
?>