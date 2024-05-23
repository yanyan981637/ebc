<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['kinds'])!=''){

if($_REQUEST['kinds']=='add_corp'){

$str_a1="select id FROM `corp_contents` order by id desc limit 1";
$check_a1=mysqli_query($link_db,$str_a1);
$Max_MatrixID=mysqli_fetch_row($check_a1);
$MCount=$Max_MatrixID[0]+1;

if(isset($_POST['nm1A'])!=''){
$nm1A=htmlspecialchars($_POST['nm1A'], ENT_QUOTES);
}else{
$nm1A="";
}
if(isset($_POST['clangA'])!=''){
$clangA=trim($_POST['clangA']);
}else{
$clangA="";
}
if(isset($_POST['n1A'])!=''){
$n1A=trim($_POST['n1A']);
}else{
$n1A="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str_inst="INSERT INTO `corp_contents`(`id`, `name`, `lang`, `content_info`,`upd_u`,`upd_d`) VALUES (".$MCount.",'".$nm1A."','".$clangA."','".$n1A."', 'webmaster','".$now."')";
//echo $str_inst;exit();
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script>alert('AddNew the Data!');self.location='corporation.php'</script>";
exit();
}

if($_REQUEST['kinds']=='edit_corp'){

if(isset($_POST['m_id'])!=''){
$m_id01=intval($_POST['m_id']);
}else{
$m_id01="";
}
if(isset($_POST['nm1'])!=''){
$nm1=htmlspecialchars($_POST['nm1'], ENT_QUOTES);
}else{
$nm1="";
}
if(isset($_POST['clang'])!=''){
$clang=trim($_POST['clang']);
}else{
$clang="";
}
if(isset($_POST['n1'])!=''){
$n1=trim($_POST['n1']);
}else{
$n1="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str_upd="UPDATE `corp_contents` SET `name`='".$nm1."',`lang`='".$clang."',`content_info`='".$n1."',`upd_u`='webmaster',`upd_d`='$now' WHERE `id`=".$m_id01;
//echo $str_upd;
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update the Data!');self.location='corporation.php'</script>";
exit();
}
}

if(isset($_REQUEST['cp_lang'])!=''){
$str1="select count(*) from `corp_contents` where `lang` like '%".$_REQUEST['cp_lang']."%'";
}else{
$str1="select count(*) from `corp_contents`";
}
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Corporation </title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />
<script type="text/javascript" src="../../jquery.min.js"></script>
<script language="JavaScript">
function MM_LA(selobj){
window.open(document.getElementById('SEL_LANG').options[document.getElementById('SEL_LANG').selectedIndex].value,"_self");
}
function MM_o(selobj){
window.open(document.getElementById('corp_page').options[document.getElementById('corp_page').selectedIndex].value,"_self");
}
function show_add(){
$("#corp_add").show();
$("#corp_edit").hide();
}
function hide_add(){
self.location='corporation.php';
}
function show_edit(){
$("#corp_edit").show();
$("#corp_add").hide();
}
function hide_edit(){
self.location='corporation.php';
}
</script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Corporation</h1></div>

<div id="logout"><a href="../logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="../default.php">Products</a>
</li>
<li> <a href="../modules.php">Contents</a> 
<ul>
<li><a href="../modules.php">Modules</a></li>	  
</ul>
</li>
<li ><a href="../newsletter.php">Newsletters</a>
<ul><li><a href="../subscribe.php">Subscription</a></li></ul>
</li>
</ul>
</div>
<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Corporation</h2> 
</div>

<div id="content">
<br />
<div class="right">| &nbsp;<a href="corp_stories.php" />Success Stories</a>&nbsp; | </div>
<br />
<h3>Corporation Contents Lists:&nbsp;&nbsp;
<select id="SEL_LANG" onChange="MM_LA(this)">
<option selected value="corporation.php?cp_lang=" >All</option>
<option value="corporation.php?cp_lang=EN" <?php if(isset($_REQUEST['cp_lang'])=="EN"){ echo "selected"; }?>>English</option>
<option value="corporation.php?cp_lang=JP" <?php if(isset($_REQUEST['cp_lang'])=="JP"){ echo "selected"; }?>>JAPAN</option>
<option value="corporation.php?cp_lang=ZH" <?php if(isset($_REQUEST['cp_lang'])=="ZH"){ echo "selected"; }?>>繁體中文</option>
<option value="corporation.php?cp_lang=CN" <?php if(isset($_REQUEST['cp_lang'])=="CN"){ echo "selected"; }?>>簡體中文</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
</h3><div>Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;</div>

<table class="list_table">
  <tr>
    <th >Name</th><th>Language</th><th  >Contents</th><th>&nbsp;<div class="button14" style="width:50px;"><a href="#corp_add" onclick="show_add();">Add</a></th>
  </tr>
  <?php
      if(isset($_REQUEST['page'])!=""){
	  $page=intval($_REQUEST['page']);
      }else{
      $page="1";
      }
      
      if(empty($page))$page="1";
      
      $read_num="10";
      $start_num=$read_num*($page-1);
			
      if(isset($_REQUEST['cp_lang'])<>''){      
        $str="SELECT `id`, `name`, `lang`, `content_info`, `upd_u`, `upd_d` FROM `corp_contents` where `lang` ='".$_REQUEST['cp_lang']."' ORDER BY `id` limit $start_num,$read_num;";
      }else{
        $str="SELECT `id`, `name`, `lang`, `content_info`, `upd_u`, `upd_d` FROM `corp_contents` ORDER BY `id` limit $start_num,$read_num;";
      }
      
      $result=mysqli_query($link_db, $str);
	  $i=0;
      while(list($id,$name,$lang,$content_info,$upd_d)=mysqli_fetch_row($result))      
	  {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td ><?=$name;?></td><td><?=$lang;?></td>
	<td>
	<?php
	if(strlen($content_info)>100){
	echo substr($content_info,0 ,150)."...";
	}else{
	echo $content_info;
	}
	?>
	</td><td ><a href="?mid=<?=$id;?>#corp_edit">Edit</a></td>
  </tr>
  <?php
      }
  ?>
  <tr>
     <td colspan="4">
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
<select id="corp_page" name="corp_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>" <? if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav;?>
</div>
<p class="clear">&nbsp;</p>

<!--Click Edit and add -->							
<div id="corp_add" class="subsettings" style="display:none">
<h1>Add / Edit a Corportaion content</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_Add();"> [close] </a></div><!--end of close-->
<form id="form1" name="form1" method="post" action="?kinds=add_corp" onsubmit="return Final_Check()">
<table class="addspec">
<tr>
<th>Name:  </th>
<td><input id="nm1A" name="nm1A" type="text" size="40" value="" />
</td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="clangA" name="clangA">
<option value="EN" selected>English</option>
<option value="CN">簡體</option><option value="ZH">繁體</option><option value="JP">日文</option>
</select>
</td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="n1A" name="n1A" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"></textarea>
<p style="color:#0F0">** web editor : Alow HTML code</p>
</td>
</tr>
<tr><td colspan="2">
<input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C1" type="button" value="Cancel" onclick="javascript:self.location='corporation.php'" />
<span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check( ) {

if(document.form1.nm1A.value == ""){
alert("Required Input Name！");
document.form1.nm1A.focus();
return false;
}
/*
if(document.form1.n1A.value == "") {
alert ("Required Input Contents！");
document.form1.n1A.focus();
return false;
}
*/
if(document.form1.clangA.value == "") {
alert ("Required Select Languages！");
document.form1.clangA.focus();
return false;
}

return true;
}
</script>
</div>

<?php
if(isset($_REQUEST['mid'])!=''){

 $mid01=intval($_REQUEST['mid']);
 $str_m="SELECT `id`, `name`, `lang`, `content_info`, `upd_u`, `upd_d` FROM `corp_contents` where `id`=".$mid01;
 $m_result=mysqli_query($link_db,$str_m);
 $m_data=mysqli_fetch_row($m_result);
 
?>
<div id="corp_edit" class="subsettings" style="display:none">
<h1>Edit a Corportaion content</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
<form id="form2" name="form2" method="post" action="?kinds=edit_corp" onsubmit="return MFinal_Check()">
<table class="addspec">
<tr>
<th>Name:  </th>
<td><input id="nm1" name="nm1" type="text" size="40" value="<?=$m_data[1];?>" />
</td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="clang" name="clang">
<option value="EN" <?php if($m_data[2]=='EN'){ echo "selected"; }?>>English</option>
<option value="CN" <?php if($m_data[2]=='CN'){ echo "selected"; }?>>簡體</option><option value="ZH" <?php if($m_data[2]=='ZH'){ echo "selected"; }?>>繁體</option><option value="JP" <?php if($m_data[2]=='JP'){ echo "selected"; }?>>日文</option>
</select>
</td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="n1" name="n1" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"><?=$m_data[3];?></textarea>
<p style="color:#0F0">** web editor : Alow HTML code</p>
</td>
</tr>
<tr><td colspan="2">
<input name="m_id" type="hidden" value="<?=$m_data[0];?>"><input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C1" type="button" value="Cancel" onclick="javascript:self.location='corporation.php'" />
<span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function MFinal_Check( ) {

if(document.form2.nm1.value == ""){
alert("Required Input Name！");
document.form2.nm1.focus();
return false;
}

if(document.form2.clang.value == "") {
alert ("Required Select Languages！");
document.form2.clang.focus();
return false;
}

return true;
}
</script>
</div>
<?php
}
?>
<p class="clear">&nbsp;</p>
</div>
<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'n1A', {
    });
</script>
<script>
  CKEDITOR.replace( 'n1', {
    });
</script>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])){
echo "<script language='javascript'>show_edit();</script>\n";
exit();
}
?>