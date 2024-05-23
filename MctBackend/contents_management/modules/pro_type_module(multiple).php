<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
//$select=mysqli_select_db($dataBase);

if($_REQUEST['kinds']=="add_productType"){

$str_a1="select ProductTypeID FROM producttypes_las order by ProductTypeID desc limit 1";
$check_a1=mysqli_query($link_db,$str_a1);
$Max_MatrixID=mysqli_fetch_row($check_a1);
$MCount=$Max_MatrixID[0]+1;

$PT01=$_POST['PT01'];
$MD1=$_POST['MD01'];
$DS01=$_POST['DS01'];

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_POST['PMM_PT']!=''){
  
  foreach($_POST['PMM_PT'] as $check_pt) {
  $pmm=$pmm.$check_pt.",";
  }

}else{
  $pmm='';
}

$guid = com_create_guid();
$guid = strtr($guid,'{','');
$guid = strtr($guid,'}','');

if($_POST['ptypeLang']!=''){
  
  foreach($_POST['ptypeLang'] as $check_lang) {
  $ptlang=$ptlang.$check_lang.",";
  }

}else{
  $ptlang='';
}

$str_ins="insert into `producttypes_las` (`ProductTypeID`, `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `crea_d`, `crea_u`) values ($MCount,'$PT01','$MD01','$DS01','$pmm','$guid','$ptlang','$now','1706')";
$cmd_ins=mysqli_query($link_db,$str_ins);
echo "<script>alert('AddNew Product Type!');location.href='pro_type_module.php'</script>";
exit();

}else if($_REQUEST['kinds']=="mod_productType"){

$PT01m=$_POST['PT01m'];
$MD1m=$_POST['MD01m'];
$DS01m=$_POST['DS01m'];

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_POST['PMM_PTm']!=''){
  
  foreach($_POST['PMM_PTm'] as $check_ptm) {
  $pmm01=$pmm01.$check_ptm.",";
  }

}else{
  $pmm01='';
}

if($_POST['ptypeLangm']!=''){
  
  foreach($_POST['ptypeLangm'] as $check_langm) {
  $ptlangm=$ptlangm.$check_langm.",";
  }

}else{
  $ptlangm='';
}

$ptype_id01=$_POST['ptype_id'];

$str_upd="update `producttypes_las` set `ProductTypeName`='".$PT01m."', `Meta_desc`='".$MD1m."', `Prod_Descript`='".$DS01m."', `PMM_ProdType`='".$pmm01."', `slang`='".$ptlangm."', `upd_d`='$now', `upd_u`='1706' where `ProductTypeID`=".$ptype_id01;
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update Product Type!');location.href='pro_type_module.php'</script>";
exit();
}


if($_REQUEST['SEL_LANG']<>''){
  $str1="select count(*) from `producttypes_las` where slang like '%".$_REQUEST['SEL_LANG']."%'";  
}else{
  $str1="select count(*) from `producttypes_las`";
}  
  
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Product Type Module </title>
<link rel="stylesheet" type="text/css" href="../../css.css" />
<link rel=stylesheet type="text/css" href="../../backend.css">
<script type="text/javascript" src="../../jquery.min.js"></script>

<script language=""JavaScript">
<!--
function MM_LA(selobj){
window.open(document.getElementById('SEL_LANG').options[document.getElementById('SEL_LANG').selectedIndex].value,"_self");
}
function MM_o(selObj){
//window.open(document.all.values_page.options[document.all.values_page.selectedIndex].value,"_self");
window.open(document.getElementById('values_page').options[document.getElementById('values_page').selectedIndex].value,"_self");
}

function show_add(){
$("#ptype_module_add").show();
$("#ptype_module_mod").hide();
}
function hide_add(){
self.location="pro_type_module.php";
}

function show_edit(){
$("#ptype_module_mod").show();
$("#ptype_module_add").hide();
}
function hide_edit(){
self.location="pro_type_module.php";
}
//-->
</script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Product Type Module</h1></div>

<div id="logout"><a href="../../logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="../default.html">Products</a>

</li>
<li> <a href="../modules.html">Contents</a> 
      <ul>
		<li><a href="../modules.html">Modules</a></li>	  
      </ul>
</li>
<li ><a href="../newsletter.html">Newsletters</a>
<ul><li><a href="../subscribe.html">Subscription</a></li></ul>
</li>
</ul>
</div>


<div class="clear"></div>

<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.html">Modules</a>  &nbsp;&gt;&nbsp; Product Type Module</h2> 
</div>

<div id="content">

<br />
<div class="right">&nbsp; | &nbsp;<a href="pro_info.html" />Product Info</a>&nbsp; | &nbsp;<a href="category_module.html" />Category Product List</a>&nbsp; | &nbsp;</div>
<br />


<h3>Product Type Lists:
</h3>

<div>
<div class="pagination left">
<select id="SEL_LANG" onChange="MM_LA(this)">
<option selected value="pro_type_module.php?pt_lang=" >All</option>
<option value="pro_type_module.php?pt_lang=EN" <? if($_REQUEST['pt_lang']=="EN"){ echo "selected"; }?>>English</option>
<option value="pro_type_module.php?pt_lang=JP" <? if($_REQUEST['pt_lang']=="JP"){ echo "selected"; }?>>JAPAN</option>
<option value="pro_type_module.php?pt_lang=ZH" <? if($_REQUEST['pt_lang']=="ZH"){ echo "selected"; }?>>繁體中文</option>
<option value="pro_type_module.php?pt_lang=CN" <? if($_REQUEST['pt_lang']=="CN"){ echo "selected"; }?>>簡體中文</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;</div>
 </div>

<table class="list_table">
  <tr>
    <th >*Product Type Name</th><th  >*Associated Product Type(s) in PMM system</th><th>*Language</th><th>*Update Date</th><th><div class="button14" style="width:50px;" onClick="show_add()">Add</div></th>
  </tr>  
  <?
      if ($_REQUEST['page']==""){
      $page="1";
      }else{
      $page=$_REQUEST['page'];
      }
      
      if(empty($page))$page="1";
      
      $read_num="20";
      $start_num=$read_num*($page-1);
			
      if($_REQUEST['pt_lang']<>''){      
        $str="SELECT ProductTypeID,ProductTypeName,PMM_ProdType,slang,upd_d FROM `producttypes_las` where slang like '%".$_REQUEST['pt_lang']."%' ORDER BY ProductTypeID limit $start_num,$read_num;";
      }else{
        $str="SELECT ProductTypeID,ProductTypeName,PMM_ProdType,slang,upd_d FROM `producttypes_las` ORDER BY ProductTypeID limit $start_num,$read_num;";
      }
      
      $result=mysqli_query($link_db, $str);
      while(list($ProductTypeID,$ProductTypeName,$PMM_ProdType,$slang,$upd_d)=mysqli_fetch_row($result))
      
	  {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td><?=$ProductTypeName;?></td><td>
	<?php
	$PMM_split=explode(",",$PMM_ProdType,-1);
	//for($k=0;$k<=count($PMM_split);$k++){

	if(count($PMM_split)>1){
	foreach($PMM_split as $PMM_val){
	  $str01="select ProductTypeName from producttypes where ProductTypeID=".$PMM_val;
	  $ptcmd=mysqli_query($link_db,$str01);
	  while($ptdata=mysqli_fetch_row($ptcmd)){
	    echo $ptdata[0].", ";
	  }
	  
	}
	}
	?>
	</td><td><?=$slang;?></td><td ><?=$upd_d;?></td><td ><a href="pro_type_module.php?pt_id=<?=$ProductTypeID;?>&types=edit#ProductType_edit">Edit</a></td>
  </tr> 
  <?
      }
  ?>
  
  <tr>
     <td colspan=5>
     <?php
        $all_page=ceil($public_count/$read_num);
        $pageSize=$page;
		$total=$all_page;
		pageft($total,$pageSize,1,0,0,15);       
     ?>
     </td>
  </tr>
  
</table>
<br />
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="values_page" name="values_page" onChange="MM_o(this)">
<?
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>" <? if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>

<p style="color:#0F0">** 此處設定TYAN 網站 Products Type 的大類別，以及其關連對應到 PMM 系統的類別</p>

<p >&nbsp;</p>
<p class="clear">&nbsp;</p>

<!--Click Edit and add -->							
<div id="ptype_module_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_productType" onsubmit="return Final_Check();">
<h1>Add a Product Type</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Product Type Name:  </th>
<td><input name="PT01" type="text" size="40" value=""  />
</td>
</tr>
<tr>
<th>Meta description:  </th>
<td><input name="MD01" type="text" size="40" value=""  />
</td>
</tr>
<tr>
<th>Description:  </th>
<td><textarea name="DS01" rows="1" cols="30" style="max-width: 250px; max-height: 250px;"></textarea><span style="color:#0F0">允許輸入html,  (), 空白, -, /</span>
</td>
</tr>

<tr>
<th>Associated Product Type(s) in PMM system: </th>
<td>
<?
$str_type="select b.ProductTypeID,a.ProductCateID,a.ProductCateName from ProductCategories a inner join ProductTypes b on a.ProductCateName=b.ProductTypeName";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductCateID,$ProductCateName)=mysqli_fetch_row($type_result))
{
?>
<p><input name="PMM_PT[]" type="checkbox" value="<?=$ProductTypeID;?>"  /> <?=$ProductCateName;?></p> 
<?
}
?>
<p style="color:#0F0">這裡列出所有在PMM 系統中的 Product Types，可選擇多個，也可以不選。</p>
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<INPUT name="ptypeLang[]" type="checkbox" value="EN" checked="checked" /> English &nbsp;&nbsp;
<INPUT name="ptypeLang[]" type="checkbox" value="CN" checked="checked" /> 簡中 &nbsp;&nbsp;
<INPUT name="ptypeLang[]" type="checkbox" value="ZH" checked="checked" /> 繁中 &nbsp;&nbsp;
<INPUT name="ptypeLang[]" type="checkbox" value="JP" checked="checked" /> 日本語 &nbsp;&nbsp;<span style="color:#0F0">*必選欄位</span>
</td>
</tr>

<tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;
<input name="C1" type="button" value="Cancel" onclick="javascript:self.location='pro_type_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {

if(document.form1.PT01.value == ""){
alert("請輸入 Product Type！");
document.form1.PT01.focus();
return false;
}

if(document.form1.MD01.value == "") {
alert ("請選擇 Meta description！");
document.form1.MD01.focus();
return false;
}

if(document.form1.ptypeLang.value == "") {
alert ("請選擇 Languages！");
document.form1.ptypeLang.focus();
return false;
}

return true;
}
</script>
</div>

<?php
if($_REQUEST['pt_id']<>""){
$pt_id01=$_REQUEST['pt_id'];

//"insert into  (`ProductTypeID`, `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `crea_d`, `crea_u`)

$str_m="select `ProductTypeID`, `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang` from `producttypes_las` where `ProductTypeID`=".$pt_id01;
$mcmd=mysqli_query($link_db,$str_m);
$mdata=mysqli_fetch_row($mcmd);
?>
<div id="ptype_module_mod" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=mod_productType" onsubmit="return Final_MCheck();">
<h1>Edit a Product Type</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Product Type Name:  </th>
<td><input name="PT01m" type="text" size="40" value="<?=$mdata[1];?>"  />
</td>
</tr>
<tr>
<th>﹤Meta description﹥:  </th>
<td><input name="MD01m" type="text" size="40" value="<?=$mdata[2];?>"  />
</td>
</tr>
<tr>
<th>Description:  </th>
<td><textarea  name="DS01m" rows="1" cols="30" style="max-width: 250px; max-height: 250px;"><?=$mdata[3];?></textarea><span style="color:#0F0">允許輸入html,  (), 空白, -, /</span>
</td>
</tr>

<tr>
<th>Associated Product Type(s) in PMM system: </th>
<td>
<?
$str_type="select b.ProductTypeID,a.ProductCateID,a.ProductCateName from ProductCategories a inner join ProductTypes b on a.ProductCateName=b.ProductTypeName";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductCateID,$ProductCateName)=mysqli_fetch_row($type_result))
{
?>
<p><input name="PMM_PTm[]" type="checkbox" value="<?=$ProductTypeID;?>" <? if(eregi($ProductTypeID,$mdata[4])!='') {echo "checked";} ?> /> <?=$ProductCateName;?></p> 
<?
}
?>
<p style="color:#0F0">這裡列出所有在PMM 系統中的 Product Types，可選擇多個，也可以不選。</p>
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<INPUT name="ptypeLangm[]" type="checkbox" value="EN" <? if(eregi("EN",$mdata[6])!='') {echo "checked";} ?> /> English &nbsp;&nbsp;
<INPUT name="ptypeLangm[]" type="checkbox" value="CN" <? if(eregi("CN",$mdata[6])!='') {echo "checked";} ?> /> 簡中 &nbsp;&nbsp;
<INPUT name="ptypeLangm[]" type="checkbox" value="ZH" <? if(eregi("ZH",$mdata[6])!='') {echo "checked";} ?> /> 繁中 &nbsp;&nbsp;
<INPUT name="ptypeLangm[]" type="checkbox" value="JP" <? if(eregi("JP",$mdata[6])!='') {echo "checked";} ?> /> 日本語 &nbsp;&nbsp;<span style="color:#0F0">*必選欄位</span>
</td>
</tr>

<tr><td colspan="2"><input name="ptype_id" type="hidden" value="<?=$mdata[0];?>"><input type="submit" value="Done" />&nbsp;&nbsp;
<input name="C01m" type="button" value="Cancel" onClick="javascript:self.location='pro_type_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
<script language="JavaScript">
function Final_MCheck( ) {

if(document.form1.PT01m.value == ""){
alert("請輸入 Product Type！");
document.form1.PT01m.focus();
return false;
}

if(document.form1.MD01m.value == "") {
alert ("請選擇 Meta description！");
document.form1.MD01m.focus();
return false;
}

if(document.form1.ptypeLangm.value == "") {
alert ("請選擇 Languages！");
document.form1.ptypeLangm.focus();
return false;
}

return true;
}
</script>
</div>
<?
}
?>
<p class="clear">&nbsp;</p>
</div>

<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>

</body>
</html>
<?php
 if($_REQUEST['pt_id']<>""){
 echo "<script language='Javascript'>show_edit();</script>\n";
 }
?>