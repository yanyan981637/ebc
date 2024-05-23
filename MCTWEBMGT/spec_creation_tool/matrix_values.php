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

if(isset($_REQUEST['MValue_Mid'])<>''){
$M_Mid=intval($_REQUEST['MValue_Mid']);
}else{
$M_Mid="";
}

if(isset($_REQUEST['EMValue_Mid'])<>''){
$EM_Mid=intval($_REQUEST['EMValue_Mid']);
}else{
$EM_Mid="";
}

if(isset($_REQUEST['d_id'])!=""){
$d1=intval($_REQUEST['d_id']);
$str_d="delete FROM `matrix_values` where MValue_id=".$d1;
$cmd_d=mysqli_query($link_db,$str_d);
echo "<script>alert('Del Value !');location.href='matrix_values.php';</script>";
exit();
}

if(isset($_REQUEST['kinds'])=='add_matrvalues'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db); 

$str_values="select MValue_id FROM `matrix_values` order by MValue_id desc limit 1";
$check_values=mysqli_query($link_db,$str_values);
$Max_CValID=mysqli_fetch_row($check_values);
$MCount=$Max_CValID[0]+1;

if(isset($_POST['SEL_title01'])!=''){
$t1=trim($_POST['SEL_title01']);
}else{
$t1="";
}
if(isset($_POST['SEL_subtitle'])!=''){
$t2=trim($_POST['SEL_subtitle']);
}else{
$t2="";
}
if(isset($_POST['mvalue'])!=''){
$t3=trim($_POST['mvalue']);
}else{
$t3="";
}
if(isset($_POST['mtips'])!=''){
$t4=trim($_POST['mtips']);
}else{
$t4="";
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
$str1="insert into `matrix_values` (`MValue_id`, `MValue_Mid`, `MValue_SUBName`, `MValue_VName`, `SKUs`, `GUID`, `crea_d`, `crea_u`, `IsShow`, `Tooltips`) values ($MCount,$t1,'$t2','$t3','','$guid','$now','1782','1','$t4')";
$cmd1=mysqli_query($link_db,$str1);
echo "<script>alert('AddNew Product Matrix Values!');location.href='matrix_values.php'</script>";
exit();
}

if(isset($_REQUEST['kinds'])=='edit_matrvalues'){
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);

if(isset($_POST['ed_id'])!=''){
$tt0=intval($_POST['ed_id']);
}else{
$tt0="";
}
if(isset($_POST['SEL_etitle01'])!=''){
$tt1=trim($_POST['SEL_etitle01']);
}else{
$tt1="";
}
if(isset($_POST['SEL_esubtitle'])!=''){
$tt2=trim($_POST['SEL_esubtitle']);
}else{
$tt2="";
}
if(isset($_POST['emvalue'])!=''){
$tt3=trim($_POST['emvalue']);
}else{
$tt3="";
}
if(isset($_POST['emtips'])!=''){
$tt4=trim($_POST['emtips']);
}else{
$tt4="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str2="update `matrix_values` set `MValue_Mid`=$tt1, `MValue_SUBName`='$tt2', `MValue_VName`='$tt3', `upd_d`='$now', `upd_u`='1782', `IsShow`='1', `Tooltips`='$tt4' where `MValue_id`=".$tt0;
$cmd2=mysqli_query($link_db,$str2);
echo "<script>alert('Mod Product Matrix Values!');location.href='matrix_values.php'</script>";
exit();
}


if(isset($_REQUEST['Mart_id'])<>''){

  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  $str1="select count(*) from `matrix_values` where MValue_VName like '%".$s_search."%' and MValue_Mid=".intval($_REQUEST['Mart_id']);
  }else{
  $str1="select count(*) from `matrix_values` where MValue_Mid=".intval($_REQUEST['Mart_id']);
  }
  
}else{

  if(isset($_REQUEST['s_search'])<>''){
  $s_search=trim($_REQUEST['s_search']);
  $str1="select count(*) from `matrix_values` where MValue_VName like '%".$s_search."%'";
  }else{
  $str1="select count(*) from `matrix_values`";
  }

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

<script language="JavaScript">
<!--
 document.onkeydown = function() {   
 if (window.event)   
 if (event.keyCode == 13 && event.srcElement.nodeName != "TEXTAREA" && event.srcElement.type != "submit")   
 event.keyCode = 9;   
 }
 
 function search_value(){
    self.location = "?s_search=" + document.form3.sear_txt.value;
    return false;
 }
//-->
</script>

<script language="JavaScript">
<!--
function show_add(){
$("#Matrix_values_add").show();//顯示
$("#Matrix_values_edit").hide();
}

function show_edit(){
$("#Matrix_values_add").hide();
$("#Matrix_values_edit").show();//顯示
}

function hiden_add(){
self.location="matrix_values.php";
}

function hiden_edit(){
self.location="matrix_values.php";
}

function MM_o(selObj){
window.open(document.getElementById('values_page').options[document.getElementById('values_page').selectedIndex].value,"_self");
}
function MM_t(selObj){
window.open(document.getElementById('SEL_title').options[document.getElementById('SEL_title').selectedIndex].value,"_self");
}
function MM_MT(selobj){
window.open(document.getElementById('SEL_MATR').options[document.getElementById('SEL_MATR').selectedIndex].value,"_self");
}
function MM_et(selObj){
window.open(document.getElementById('SEL_etitle').options[document.getElementById('SEL_etitle').selectedIndex].value,"_self");
}

function Del_id(t_id){    
    if(confirm("確定要刪除此筆資料嗎？")) {
    self.location="?d_id="+t_id;
    }else{
    }
  }
//-->
</script>
</head>
<body><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
<div id="logout">Hi <b><?=str_replace('@mic.com.tw','',$_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<div id="menu">
<ul>
<li> <a href="default.php">Product SPEC</a> </li>
<li> <a href="#">SPEC Settings</a> 
<ul>
<li><a href="spec_settings_pro_types.php">Product Types</a></li>
<li><a href="spec_settings_categories.php">Categories</a></li>
<li><a href="spec_settings_types.php">Types</a></li>
<a href="spec_settings.php">Values </a>
</ul>
</li>
<li> <a href="matrix.php">Product Matrix</a>
<ul>
<li><a href="matrix_values.php">Matrix Values</a></li>
</ul>
</li>
<li> <a href="group_sku.php">Group SKUs</a> </li>
<li> <a href="admin_list.php">Account List</a> </li>
</ul>
</div>

<div class="clear"></div>
<?php
if(isset($_REQUEST['Mart_id'])!=''){
$Mart_id=intval($_REQUEST['Mart_id']);
}else{
$Mart_id="";
}
?>
<div id="Search" >
<div >
<select id="SEL_MATR" onChange="MM_MT(this)">
<option value="matrix_values.php">Select...</option>
<?php
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db,'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase, $link_db);
$str_MVA="select MValue_Mid,MValue_MiName from `matrix_values_type` order by MValue_Mid";
$MVA_result=mysqli_query($link_db,$str_MVA);
while(list($MValue_Mid,$MValue_MiName)=mysqli_fetch_row($MVA_result))
{
?>
<option value="matrix_values.php?Mart_id=<?=$MValue_Mid?>" <?php if($Mart_id==$MValue_Mid){ echo "selected"; }?>><?=$MValue_MiName?></option>
<?php
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
</div>
</div>
<p class="clear"></p>
<div id="content">
<h3 class="left">Matrix Value Settings:</h3>
<!--datatable start here-->
<p class="clear"></p>
<div>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
<div class="left">
<form id="form3" name="form3" method="post" action="matrix_values.php">
 <input name="sear_txt" type="text" size="20" value="" onkeydown="{if(event.keyCode==13)search_value();else if(event.which==13)search_value();else if(event.charCode==13)search_value()}" /> <input type="button" value="Search" onclick="search_value();">
</form> 
 </div>
</div>
<p class="clear"></p>
<?php
  if(isset($_REQUEST['PSPEC'])<>''){
  
   $PSPEC_Value_str=trim($_REQUEST['PSPEC']);
        
   $MV01="MValue_id";
   $MN01="MValue_SUBName";
   $VN01="MValue_VName";
   $UD01="upd_d";
   $UU01="upd_u";
   
   if($PSPEC_Value_str=="MValue_id"){
   $PSPEC_Value=$PSPEC_Value_str;
   $MV01="MValue_id_A";
   $P_value="Desc";
   }else if($PSPEC_Value_str=="MValue_id_A"){
   $PSPEC_Value="MValue_id";
   $MV01="MValue_id";
   $P_value="Asc";
   }
   
   if($PSPEC_Value_str=="MValue_SUBName"){
   $PSPEC_Value=$PSPEC_Value_str;
   $MN01="MValue_SUBName_A";
   $P_value="Desc";
   }else if($PSPEC_Value_str=="MValue_SUBName_A"){
   $PSPEC_Value="MValue_SUBName";
   $MN01="MValue_SUBName";
   $P_value="Asc";
   }
   
   if($PSPEC_Value_str=="MValue_VName"){
   $PSPEC_Value=$PSPEC_Value_str;
   $VN01="MValue_VName_A";
   $P_value="Desc";
   }else if($PSPEC_Value_str=="MValue_VName_A"){
   $PSPEC_Value="MValue_VName";
   $VN01="MValue_VName";
   $P_value="Asc";
   }
   
   if($PSPEC_Value_str=="upd_d"){
   $PSPEC_Value=$PSPEC_Value_str;
   $UD01="upd_d_A";
   $P_value="Desc";
   }else if($PSPEC_Value_str=="upd_d_A"){
   $PSPEC_Value="upd_d";
   $UD01="upd_d";
   $P_value="Asc";
   }
   
   if($PSPEC_Value_str=="upd_u"){
   $PSPEC_Value=$PSPEC_Value_str;
   $UU01="upd_u_A";
   $P_value="Desc";
   }else if($PSPEC_Value_str=="upd_u_A"){
   $PSPEC_Value="upd_u";
   $UU01="upd_u";
   $P_value="Asc";
   }    
  
  }else{
  
   $PSPEC_Value="upd_d";
   $MV01="MValue_id";
   $MN01="MValue_SUBName";
   $VN01="MValue_VName";
   $UD01="upd_d";
   $UU01="upd_u";
    
   $P_value="Desc";
  }
?>

<table class="list_table">
	<tr>
	  <th width="100"><a href="?PSPEC=<?=$MV01;?>">*Title</a></th>
	  <th width="100"><a href="?PSPEC=<?=$MN01;?>">*Subtitle</a></th>
	  <th ><a href="?PSPEC=<?=$VN01;?>">*Value</a></th>
	  <th width="100"><a href="?PSPEC=<?=$UD01;?>">*Updated by</a></th>	
    <th width="160"><a href="?PSPEC=<?=$UU01;?>">*Update Date</a></th>	
    <th onClick="" width="120"><div class="button14" style="width:100px;"><a href="#Matrix_values_add" onClick="show_add();">Add New</a></div></th> 		
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
			
      if(isset($_REQUEST['Mart_id'])<>''){
      
        if(isset($_REQUEST['s_search'])<>''){
        $s_search=trim($_REQUEST['s_search']);
        $str="SELECT * FROM `matrix_values` where (MValue_SUBName like '%".$s_search."%' or MValue_VName like '%".$s_search."%') and MValue_Mid=".intval($_REQUEST['Mart_id'])." ORDER BY ".$PSPEC_Value." limit $start_num,$read_num;";
        }else{
        $str="SELECT * FROM `matrix_values` where MValue_Mid=".intval($_REQUEST['Mart_id'])." ORDER BY ".$PSPEC_Value." limit $start_num,$read_num;";
        }
      
      }else{
      
        if(isset($_REQUEST['s_search'])<>''){
        $s_search=trim($_REQUEST['s_search']);
        $str="SELECT * FROM `matrix_values` where (MValue_SUBName like '%".$s_search."%' or MValue_VName like '%".$s_search."%') ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }else{
        $str="SELECT * FROM `matrix_values` ORDER BY ".$PSPEC_Value." ".$P_value." limit $start_num,$read_num;";
        }
      
      }      
      $result=mysqli_query($link_db, $str);
	  $i=0;
      while(list($MValue_id,$MValue_Mid,$MValue_SUBName,$MValue_VName,$GUID,$crea_d,$crea_u,$upd_d,$upd_u,$IsShow,$Tooltips)=mysqli_fetch_row($result)){
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
	?>
	<tr >
	<td>
    <?php
    $str_v="select MValue_Mid,MValue_MiName from `matrix_values_type` where MValue_Mid=".$MValue_Mid;
    $result_v=mysqli_query($link_db,$str_v, $link_db);
    if($result_v==true){
    $data_v=mysqli_fetch_row($result_v);
    echo $data_v[1];
    }
    ?></td>
		<td><?=$MValue_SUBName;?></td>
		<td><?=$MValue_VName;?></td> 
		<td><?=$upd_d;?></td>
		<td><?=$upd_u;?></td>
		<td><a href="matrix_values.php?mva_id=<?=$MValue_id;?>&types=edit#Matrix_values_edit">Edit</a>
    <?php
    echo "<input type='button' name='D_This' value='Del' onClick='Del_id(".$MValue_id.");'>";
    ?>
    </td>
	</tr>
  <?php
      }
  
      $all_page=ceil($public_count/$read_num);
      $pageSize=$page;
	  $total=$all_page;
	  pageft($total,$pageSize,1,0,0,15);
  ?>
</table><br />
<div class="sabrosus">
<span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="values_page" name="values_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>

<p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
<!--end of datatable -->
<!--Click Edit-->

<div id="Matrix_values_add" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=add_matrvalues" onsubmit="return AFinal_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"></td></tr>
<tr>
<th id="title">Title:</th>
<td>
<select id="SEL_title" name="SEL_title" onChange="MM_t(this)">
    <option selected="selected" value="">Select Title: </option>
    <?php   
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	mysqli_query($link_db,'SET NAMES utf8');
	mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
	mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);
    $str_t="select MValue_Mid,MValue_MiName from `matrix_values_type` order by MValue_Mid";    
    $t_result=mysqli_query($link_db,$str_t);
    while(list($MValue_Mid,$MValue_MiName)=mysqli_fetch_row($t_result)){
    ?>
    <option value="?MValue_Mid=<?=$MValue_Mid;?> #title" <?php if($M_Mid==$MValue_Mid) { echo "selected"; } ?> ><?=$MValue_MiName;?></option>
    <?php
    }
    mysqli_close($link_db);
    ?>
</select><input name="SEL_title01" type="hidden" value="<?=$M_Mid;?>"  />
</td>
</tr>
<tr>
<th>Subtitle:</th>
<td>
<select id="SEL_subtitle" name="SEL_subtitle">    
    <?php
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
	mysqli_query($link_db,'SET NAMES utf8');
	mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
	mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);    
	$str_s="SELECT MValue_SUBName, MValue_Mid FROM `matrix_values` where MValue_SUBName<>'' and MValue_Mid=".$M_Mid." group by MValue_SUBName HAVING COUNT(*) > 1"; 
    $s_result=mysqli_query($link_db,$str_s);
	$srecord=mysqli_fetch_row($s_result);	
	if(empty($srecord)):
	?>
	<option value="" disabled>select...</option>
	<?php
    else:
	?>
	<option selected="selected" value="">select...</option>
	<?php
	$str_st="SELECT MValue_SUBName, MValue_Mid FROM `matrix_values` where MValue_SUBName<>'' and MValue_Mid=".$M_Mid." group by MValue_SUBName"; 
    $st_result=mysqli_query($link_db,$str_st);
    $i=0;
	while($SUBRecord=mysqli_fetch_row($st_result)){
	$i+=1;
	?>
    <option value="<?=$SUBRecord[0];?>"><?=$SUBRecord[0];?></option>
    <?php
	}
    endif;	
	mysqli_close($link_db);	
    ?>
</select>
<input name="SEL_subtitle01" type="hidden" value=""  />
</td>
</tr>
<tr>
<th>Value:</th>
<td> <input name="mvalue" type="text" size="50" value="" /> </td>
</tr>
<tr>
<th>URL:</th>
<td> <input name="murl" type="text" size="50" value="" /> </td>
</tr>
<tr>
<th>Tooltips:</th>
<td><input name="mtips" type="text" size="50" value=""  /></td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function AFinal_Check( ) {
if ( document.form2.SEL_title.value == "" ) {
alert ("請選擇 Title！");
document.form2.SEL_title.focus();
return false;
}

if ( document.form2.mvalue.value == "" ) {
alert ("請選擇 Value！");
document.form2.mvalue.focus();
return false;
}

return true;
}
</script>
</div>
<!--end of edit -->
<?php
if(isset($_REQUEST['mva_id'])<>""){

  $mva_values=intval($_REQUEST['mva_id']);

  $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  mysqli_query($link_db,'SET NAMES utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
  //$select=mysqli_select_db($dataBase, $link_db);  
  $str_value_m="select * from `matrix_values` where MValue_id=".$mva_values;
  $cmd_value_m=mysqli_query($link_db,$str_value_m);
  $record_value_m=mysqli_fetch_row($cmd_value_m);  
  if(empty($record_value_m)):
  else:
    $VM0=$record_value_m[0];
    $VM1=$record_value_m[1];
    $VM2=$record_value_m[2];
    $VM3=$record_value_m[3];
    $VM11=$record_value_m[11];
  endif;
}
?>
<div id="Matrix_values_edit" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=edit_matrvalues" onsubmit="return Final_Check();">
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr><td colspan="2"> </td></tr>
<tr>
<th id="title_e">Title:</th>
<td>
<select id="SEL_etitle" name="SEL_etitle" onChange="MM_et(this)">
    <?php
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  	mysqli_query($link_db,'SET NAMES utf8');
  	mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  	mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);
    $str_t="select MValue_Mid,MValue_MiName from `matrix_values_type` where MValue_Mid=".$VM1." order by MValue_Mid";    
    $t_result=mysqli_query($link_db,$str_t);
    list($MValue_Mid,$MValue_MiName)=mysqli_fetch_row($t_result);
	?>
    <option value="?EMValue_Mid=<?=$MValue_Mid;?> #title_e" <?php if($VM1==$MValue_Mid) { echo "selected"; } ?> ><?=$MValue_MiName;?></option>
    <?php
    //}
    mysqli_close($link_db);
    ?>
</select><input name="ed_id" type="hidden" value="<?=$VM0;?>" /><input name="SEL_etitle01" type="hidden" value="<?=$VM1;?>" />
</td>
</tr>
<tr>
<th>Subtitle:</th>
<td>
<select id="SEL_esubtitle" name="SEL_esubtitle">    
    <?php
    $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
  	mysqli_query($link_db,'SET NAMES utf8');
  	mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
  	mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
    //$select=mysqli_select_db($dataBase, $link_db);
    $str_s="SELECT MValue_SUBName,MValue_Mid,MValue_id,MValue_VName FROM `matrix_values` where MValue_SUBName<>'' and MValue_Mid=".$VM1." order by MValue_SUBName";
    $e_result=mysqli_query($link_db,$str_s);
	   $erecord=mysqli_fetch_row($e_result);
	
	if(empty($erecord)):
	?>
	<option selected="selected" value="" disabled>Select...</option>
	<?php
	else:
	?>
	<option selected="selected" value="">Select...</option>
	<?php
	$str_st="SELECT MValue_SUBName,MValue_Mid,MValue_id,MValue_VName FROM `matrix_values` where MValue_SUBName<>'' and MValue_Mid=".$VM1." group by MValue_SUBName";
    $et_result=mysqli_query($link_db,$str_st);
    while(list($MValue_SUBName,$MValue_Mid,$MValue_id,$MValue_VName)=mysqli_fetch_row($et_result)){
    ?>
    <option value="<?=$MValue_SUBName;?>" <?php if($VM1==$MValue_Mid) { echo "selected"; } ?>><?=$MValue_SUBName;?></option>
    <?php
    }
	endif;
    mysqli_close($link_db);
    ?>
</select>
<input name="SEL_esubtitle01" type="hidden" value="<?=$MValue_SUBName;?>" />
</td>
</tr>

<tr>
<th>Value:</th>
<td> <input name="emvalue" type="text" size="50" value="<?=htmlspecialchars($VM3, ENT_QUOTES)?>" /> </td>
</tr>
<tr>
<th>URL:</th>
<td> <input name="emurl" type="text" size="50" value="" /> </td>
</tr>
<tr>
<th>Tooltips:</th>
<td><input name="emtips" type="text" size="50" value="<?=$VM11;?>" /></td>
</tr>
<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {

if ( document.form1.SEL_etitle.value == "" ) {
alert ("請選擇 Title！");
document.form1.SEL_etitle.focus();
return false;
}

if ( document.form.emvalue.value == "" ) {
alert ("請選擇 Value！");
document.form1.emvalue.focus();
return false;
}

return true;
}
</script>
</div>
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>
<?php
if(isset($_REQUEST['MValue_Mid'])<>""){
echo "<script language='Javascript'>show_add();</script>\n";
}else if(isset($_REQUEST['mva_id'])<>"" || isset($_REQUEST['EMValue_Mid'])<>""){
echo "<script language='Javascript'>show_edit();</script>\n";
}
exit();
?>