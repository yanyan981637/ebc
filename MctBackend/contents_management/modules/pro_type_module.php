<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_set_cookie_params(8*60*60); 
ini_set('session.gc_maxlifetime', '28800');

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

/*
$db=new CMysql();
$db->CMysql();
*/

if(isset($_REQUEST['kinds_prodtype'])=="Build_MB"){
  if($_REQUEST['pt_lang']=='EN'){
  $m_mb_lang="en-US";
  $c_pskus_lang="EN,";
  }else if($_REQUEST['pt_lang']=='JP'){
  $m_mb_lang="ja-JP";
  $c_pskus_lang="JP,";
  }else if($_REQUEST['pt_lang']=='CN'){
  $m_mb_lang="zh-CN";
  $c_pskus_lang="CN,";
  }else if($_REQUEST['pt_lang']=='ZH'){
  $m_mb_lang="zh-TW";
  $c_pskus_lang="ZH,";
  }
  
  $drop_b_mb="DROP TABLE p_s_main_systemboards_Contents_pskus;";
  $b_dmb_cmd=mysqli_query($link_db,$drop_b_mb);
  
  $str_b_mb="CREATE TABLE p_s_main_systemboards_Contents_pskus SELECT distinct Product_SKUs.SKU,p_s_main_systemboards.SYSTEMBOARDID, 
p_s_main_systemboards.MODELNAME, p_s_main_systemboards.MODELCODE, p_s_main_systemboards.CPUID, p_s_main_systemboards.SOCKETID, 
p_s_main_systemboards.HIGHLIGHT, p_s_main_systemboards.CHIPSETID, p_s_main_systemboards.CPUSORT, p_s_main_systemboards.SOCKETNum, 
p_s_main_systemboards.FORMFACTOR, p_s_main_systemboards.ISDUALCORE, p_s_main_systemboards.SMALLIMG, p_s_main_systemboards.IMG, 
p_s_main_systemboards.BIGIMG, c_s_cpu.CPUNAME, c_s_chipset.CHIPSETNAME, c_s_socket.SOCKETNAME, c_s_formfactor.FORMFACTORNAME, 
Product_SKUs.Product_SKU_Auto_ID, Product_SKUs.MODELCODE as SMODE, CASE WHEN length(c_s_chipset.CHIPSETNAME) > 1 AND length
(c_s_chipset.CHIPSETNAME) < 10 THEN c_s_chipset.CHIPSETNAME ELSE LEFT(c_s_chipset.CHIPSETNAME, length(c_s_chipset.CHIPSETNAME) - 8) 
END AS SHORTCHIPSET, LEFT(c_s_cpu.CPUNAME, length(c_s_cpu.CPUNAME) - 13) AS SHORTCPU, LEFT(c_s_socket.SOCKETNAME, length
(c_s_socket.SOCKETNAME) - 8) AS SHORTSOCKET, '.' + RIGHT(p_s_main_systemboards.SMALLIMG, length(p_s_main_systemboards.SMALLIMG) - 
1) AS SMALLIMG2, '<img src=.' + RIGHT(p_s_main_systemboards.SMALLIMG, length(p_s_main_systemboards.SMALLIMG) - 1) + '>' AS 
SMALLIMG3,Product_SKUs.IS_EOL,contents_product_skus.Product_Info,p_s_main_systemboards.LANG,p_s_main_systemboards.STATUS,contents_product_skus.slang,p_s_main_systemboards.LAUNCH_DATE FROM p_s_main_systemboards INNER JOIN c_s_cpu ON p_s_main_systemboards.CPUID = c_s_cpu.CPUID INNER JOIN c_s_chipset ON 
p_s_main_systemboards.CHIPSETID = c_s_chipset.CHIPSETID INNER JOIN c_s_socket ON p_s_main_systemboards.SOCKETID = 
c_s_socket.SOCKETID INNER JOIN c_s_formfactor ON p_s_main_systemboards.FORMFACTOR = c_s_formfactor.FORMFACTORID INNER JOIN Product_SKUs ON p_s_main_systemboards.MODELCODE = Product_SKUs.MODELCODE INNER JOIN 
contents_product_skus ON p_s_main_systemboards.MODELCODE = contents_product_skus.MODELCODE WHERE (p_s_main_systemboards.LANG = 
'en-US') AND (p_s_main_systemboards.STATUS = '1') AND (contents_product_skus.slang = 'EN,') AND (contents_product_skus.Product_Info <> '');";
  $b_mb_cmd=mysqli_query($link_db,$str_b_mb);
  
  echo "<script>alert('build MB completed!');self.location='pro_type_module.php'</script>";
  exit();
  
}else if(isset($_REQUEST['kinds_prodtype'])=="Build_BB"){
  if($_REQUEST['pt_lang']=='EN'){
  $m_bb_lang="en-US";
  $c_pskus_lang="EN,";
  }else if($_REQUEST['pt_lang']=='JP'){
  $m_bb_lang="ja-JP";
  $c_pskus_lang="JP,";
  }else if($_REQUEST['pt_lang']=='CN'){
  $m_bb_lang="zh-CN";
  $c_pskus_lang="CN,";
  }else if($_REQUEST['pt_lang']=='ZH'){
  $m_bb_lang="zh-TW";
  $c_pskus_lang="ZH,";
  }
  
  $drop_b_bb="DROP TABLE p_b_main_serverbarebones_Contents_pskus;";
  $b_dbb_cmd=mysqli_query($link_db,$drop_b_bb);
  
  $str_b_bb="CREATE TABLE p_b_main_serverbarebones_Contents_pskus SELECT distinct Product_SKUs.SKU, p_b_main_serverbarebones.SERVERID, 
p_b_main_serverbarebones.MODELNAME, p_b_main_serverbarebones.SHORTCODE, p_b_main_serverbarebones.MODELCODE, 
p_b_main_serverbarebones.RACKMOUNTID, p_b_rackmount.RACKMOUNT, p_b_main_serverbarebones.MOTHERBOARDID, 
p_b_main_serverbarebones.CPUTYPEID, p_s_main_systemboards.SOCKETID, c_s_socket.SOCKETNAME, p_s_main_systemboards.CHIPSETID, 
c_s_chipset.CHIPSETNAME, p_b_main_serverbarebones.HDDBAYID, p_b_main_serverbarebones.POWERSUPPLYID, 
p_b_main_serverbarebones.SOCKETNum, p_b_main_serverbarebones.BENEFITS, p_b_main_serverbarebones.SMALLIMG, 
p_b_main_serverbarebones.IMG, p_b_main_serverbarebones.BIGIMG, p_b_main_serverbarebones.STATUS, c_b_cputype.BRAND, 
Product_SKUs.Product_SKU_Auto_ID, Product_SKUs.MODELCODE as SMODE, '.'+RIGHT (p_b_main_serverbarebones.SMALLIMG, length(p_b_main_serverbarebones.SMALLIMG)-1) AS SMALLIMG2, '<img src=.'+RIGHT (p_b_main_serverbarebones.SMALLIMG, length(p_b_main_serverbarebones.SMALLIMG)-1)+'>' AS SMALLIMG3,Product_SKUs.IS_EOL,contents_product_skus.Product_Info,p_b_main_serverbarebones.LANG,contents_product_skus.slang,p_s_main_systemboards.LAUNCH_DATE FROM p_b_main_serverbarebones INNER JOIN c_b_hddbay ON p_b_main_serverbarebones.HDDBAYID = c_b_hddbay.HDDBAYID INNER JOIN c_b_powersupply ON p_b_main_serverbarebones.POWERSUPPLYID = c_b_powersupply.POWERSUPPLYID INNER JOIN c_b_cputype ON p_b_main_serverbarebones.CPUTYPEID = c_b_cputype.CPUTYPEID INNER JOIN Product_SKUs ON p_b_main_serverbarebones.MODELCODE = Product_SKUs.MODELCODE LEFT OUTER JOIN p_s_main_systemboards ON p_b_main_serverbarebones.MOTHERBOARDID = p_s_main_systemboards.SYSTEMBOARDID INNER JOIN c_s_chipset ON p_s_main_systemboards.CHIPSETID = c_s_chipset.CHIPSETID INNER JOIN c_s_socket ON p_s_main_systemboards.SOCKETID = c_s_socket.SOCKETID INNER JOIN p_b_rackmount ON p_b_main_serverbarebones.RACKMOUNTID = p_b_rackmount.RACKMOUNTID INNER JOIN contents_product_skus ON p_b_main_serverbarebones.MODELCODE = contents_product_skus.MODELCODE WHERE (p_b_main_serverbarebones.LANG = 'en-US') AND (p_b_main_serverbarebones.STATUS = '1') AND (contents_product_skus.slang = 'EN,') AND (contents_product_skus.Product_Info <> '');";
  $b_bb_cmd=mysqli_query($link_db,$str_b_bb);
  
  echo "<script>alert('build BB completed!');self.location='pro_type_module.php'</script>";
  exit();
  
}else if(isset($_REQUEST['kinds_prodtype'])=="Build_CHASSIS"){
  if($_REQUEST['pt_lang']=='EN'){
  $m_chassis_lang="en-US";
  $c_pskus_lang="EN,";
  }else if($_REQUEST['pt_lang']=='JP'){
  $m_chassis_lang="ja-JP";
  $c_pskus_lang="JP,";
  }else if($_REQUEST['pt_lang']=='CN'){
  $m_chassis_lang="zh-CN";
  $c_pskus_lang="CN,";
  }else if($_REQUEST['pt_lang']=='ZH'){
  $m_chassis_lang="zh-TW";
  $c_pskus_lang="ZH,";
  }
  
  $drop_b_chassis="DROP TABLE p_r_main_rackchassis_Contents_pskus;";
  $b_dch_cmd=mysqli_query($link_db,$drop_b_chassis);
  
  $str_b_chassis="CREATE TABLE p_r_main_rackchassis_Contents_pskus SELECT distinct  Product_SKUs.SKU,p_r_main_rackchassis.SERVERID,Product_SKUs.Product_SKU_Auto_ID,p_r_rackmount.RACKMOUNTNAME,c_r_powersupply.POWERSUPPLY,p_r_main_rackchassis.SMALLIMG,p_r_main_rackchassis.IMG,p_r_main_rackchassis.BIGIMG,'.'+RIGHT(p_r_main_rackchassis.SMALLIMG, length(p_r_main_rackchassis.SMALLIMG)-1) as SMALLIMG2,'<img src=.'+RIGHT (p_r_main_rackchassis.SMALLIMG, length(p_r_main_rackchassis.SMALLIMG)-1)+'>' AS  SMALLIMG3,Product_SKUs.FormFactor,p_r_main_rackchassis.MODELCODE,contents_product_skus.Product_Info,p_r_main_rackchassis.LANG,p_r_main_rackchassis.STATUS,contents_product_skus.slang from p_r_main_rackchassis inner join Product_SKUs ON p_r_main_rackchassis.MODELCODE = Product_SKUs.MODELCODE inner join p_r_rackmount on p_r_main_rackchassis.RACKMOUNTID=p_r_rackmount.RACKMOUNTID inner join c_r_powersupply on p_r_main_rackchassis.POWERSUPPLYID=c_r_powersupply.POWERSUPPLYID INNER JOIN contents_product_skus ON p_r_main_rackchassis.MODELCODE = contents_product_skus.MODELCODE where p_r_main_rackchassis.LANG='en-US' and (p_r_main_rackchassis.STATUS = '1' and Product_SKUs.Web_Disable=0) AND (contents_product_skus.slang = 'EN,');";
  $b_chassis_cmd=mysqli_query($link_db,$str_b_chassis);
  
  echo "<script>alert('build Chassis completed!');self.location='pro_type_module.php'</script>";
  exit();
}else if(isset($_REQUEST['kinds_prodtype'])=="Build_JBOD"){
  $drop_b_jbod="DROP TABLE p_r_main_jbod_Contents_pskus;";
  $b_djd_cmd=mysqli_query($link_db,$drop_b_jbod);
  
  $str_b_jbod="CREATE TABLE p_r_main_jbod_Contents_pskus SELECT distinct  Product_SKUs.SKU,p_r_main_jbod.SERVERID,Product_SKUs.Product_SKU_Auto_ID,p_r_rackmount.RACKMOUNTNAME,c_r_powersupply.POWERSUPPLY,p_r_main_jbod.SMALLIMG,p_r_main_jbod.IMG,p_r_main_jbod.BIGIMG,'.'+RIGHT(p_r_main_jbod.SMALLIMG, length(p_r_main_jbod.SMALLIMG)-1) as SMALLIMG2,'<img src=.'+RIGHT (p_r_main_jbod.SMALLIMG, length(p_r_main_jbod.SMALLIMG)-1)+'>' AS  SMALLIMG3,Product_SKUs.FormFactor,p_r_main_jbod.MODELCODE,p_r_main_jbod.HDD,contents_product_skus.Product_Info,p_r_main_jbod.LANG,p_r_main_jbod.STATUS,contents_product_skus.slang from p_r_main_jbod inner join Product_SKUs ON p_r_main_jbod.MODELCODE = Product_SKUs.MODELCODE inner join p_r_rackmount on p_r_main_jbod.RACKMOUNTID=p_r_rackmount.RACKMOUNTID inner join c_r_powersupply on p_r_main_jbod.POWERSUPPLYID=c_r_powersupply.POWERSUPPLYID INNER JOIN contents_product_skus ON p_r_main_jbod.MODELCODE = contents_product_skus.MODELCODE where p_r_main_jbod.LANG='en-US' and (p_r_main_jbod.STATUS = '1' and Product_SKUs.Web_Disable=0) AND (contents_product_skus.slang = 'EN,');";
  $b_jbod_cmd=mysqli_query($link_db,$str_b_jbod);
  
  echo "<script>alert('build JBOD completed!');self.location='pro_type_module.php'</script>";
  exit();
}

if(isset($_REQUEST['act'])!=''){

if($_REQUEST['act']=="del"){
$pt_id=intval($_REQUEST['pt_id']);
$str_del="delete from `producttypes_las` where `ProductTypeID`=".$pt_id;
//echo $str_del;
$del_cmd=mysqli_query($link_db,$str_del);
echo "<script>alert('Delete the data!');self.location='pro_type_module.php'</script>";
exit();
}

if($_REQUEST['act']=="copy"){
$pt_id=intval($_REQUEST['pt_id']);
$page01=intval($_REQUEST['page']);
if($page01!=''){
$page_str="?page=".$page01;
}else{
$page_str="";
}
$str_copy="insert into `producttypes_las` (`ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `crea_d`, `crea_u`) select `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `crea_d`, `crea_u` from `producttypes_las` where `ProductTypeID`=".$pt_id." limit 1";
//echo $str_copy;exit();
$copy_cmd=mysqli_query($link_db,$str_copy);
echo "<script>alert('Copy the data!');self.location='pro_type_module.php".$page_str."'</script>";
exit();
}

}
if(isset($_REQUEST['kinds'])!=''){

if($_REQUEST['kinds']=="add_productType"){

$PT01="";$MD01="";$DS01="";

$str_a1="select ProductTypeID FROM producttypes_las order by ProductTypeID desc limit 1";
$check_a1=mysqli_query($link_db,$str_a1);
$Max_MatrixID=mysqli_fetch_row($check_a1);
$MCount=$Max_MatrixID[0]+1;

//htmlspecialchars(, ENT_QUOTES)

$PT01=htmlspecialchars($_POST['PT01'], ENT_QUOTES);
$MD01=htmlspecialchars($_POST['MD01'], ENT_QUOTES);
$DS01=htmlspecialchars($_POST['DS01'], ENT_QUOTES);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$pmm='';
if(isset($_POST['PMM_PT'])!=''){
  
  foreach($_POST['PMM_PT'] as $check_pt) {
  $pmm=$pmm.$check_pt.",";
  }

}else{
  $pmm='';
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

$ptlang=trim($_POST['ptypeLang']);

$str_ins="insert into `producttypes_las` (`ProductTypeID`, `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `crea_d`, `crea_u`) values ($MCount,'$PT01','$MD01','$DS01','$pmm','$guid','$ptlang','$now','1706')";
$cmd_ins=mysqli_query($link_db,$str_ins);
echo "<script>alert('AddNew Product Type!');location.href='pro_type_module.php'</script>";
exit();

}else if($_REQUEST['kinds']=="mod_productType"){

$PT01m="";$MD01m="";$DS01m="";

$PT01m=htmlspecialchars($_POST['PT01m'], ENT_QUOTES);
$MD1m=htmlspecialchars($_POST['MD01m'], ENT_QUOTES);
$DS01m=htmlspecialchars($_POST['DS01m'], ENT_QUOTES);

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$pmm01="";
if(isset($_POST['PMM_PTm'])!=''){
  
  foreach($_POST['PMM_PTm'] as $check_ptm) {
  $pmm01=$pmm01.$check_ptm.",";
  }

}else{
  $pmm01='';
}

$ptlangm=trim($_POST['ptypeLangm']);

if(isset($_POST['show_PIm'])!=''){
	foreach($_POST['show_PIm'] as $check_pim){
	$pim01=$pim01.$check_pim.",";
	}
}

$ptype_id01=intval($_POST['ptype_id']);

$str_upd="update `producttypes_las` set `ProductTypeName`='".$PT01m."', `Meta_desc`='".$MD1m."', `Prod_Descript`='".$DS01m."', `PMM_ProdType`='".$pmm01."', `slang`='".$ptlangm."', `upd_d`='$now', `upd_u`='1706', `prodty_show`='".$pim01."' where `ProductTypeID`=".$ptype_id01;
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update Product Type!');location.href='pro_type_module.php'</script>";
exit();
}

}

if(isset($_REQUEST['pt_lang'])<>''){
  $str1="select count(*) from `producttypes_las` where slang like '%".$_REQUEST['pt_lang']."%'";  
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
<link rel="stylesheet" type="text/css" href="../../backend.css">
<script type="text/javascript" src="../../jquery.min.js"></script>

<script language="JavaScript">
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
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<div id="menu">
<ul>
<li><a href="../default.php">Products</a></li>
<li><a href="../modules.php">Contents</a>
<ul>
<li><a href="../modules.php">Modules</a></li>	  
</ul>
</li>
<li><a href="../newsletter.php">Newsletters</a>
<ul><li><a href="../subscribe.php">Subscription</a></li></ul>
</li>
</ul>
</div>

<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Product Type Module</h2> 
</div>
<div id="content">
<br />
<div class="right">&nbsp; | &nbsp;<a href="pro_info.php" />Product Info</a>&nbsp; | &nbsp;<a href="category_module.php" />Category Product List</a>&nbsp; | &nbsp;</div>
<br />
<h3>Product Type Lists:
</h3>

<?php
$pt_lang='';
if(isset($_REQUEST['pt_lang'])){
$pt_lang=trim($_REQUEST['pt_lang']);
}else{
$pt_lang="";
}
?>

<div>
<div class="pagination left">
<select id="SEL_LANG" onChange="MM_LA(this)">
<option selected value="pro_type_module.php?pt_lang=" >All</option>
<option value="pro_type_module.php?pt_lang=EN" <?php if($pt_lang=="EN"){ echo "selected"; }?> >English</option>
<option value="pro_type_module.php?pt_lang=JP" <?php if($pt_lang=="JP"){ echo "selected"; }?> >JAPAN</option>
<option value="pro_type_module.php?pt_lang=ZH" <?php if($pt_lang=="ZH"){ echo "selected"; }?> >繁體中文</option>
<option value="pro_type_module.php?pt_lang=CN" <?php if($pt_lang=="CN"){ echo "selected"; }?> >簡體中文</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;</div>
 </div>

<table class="list_table">
  <tr>
    <th >*Product Type Name</th><th>*Associated Product Type(s) in PMM system</th><th>*Language</th><th>*Update Date</th><th><div class="button14" style="width:50px;"><a href="#ptype_module_add" onclick="show_add();">Add</a></div></th>
  </tr>  
  <?php
      if(isset($_REQUEST['page'])!=""){
      $page=intval($_REQUEST['page']);
      }else{      
	  $page="1";
      }
      $prod_typeVal="";
	  
      if(empty($page))$page="1";
      
      $read_num="20";
      $start_num=$read_num*($page-1);
			
      if(isset($_REQUEST['pt_lang'])!=''){     
        $str="SELECT ProductTypeID,ProductTypeName,PMM_ProdType,slang,upd_d FROM `producttypes_las` where slang ='".$_REQUEST['pt_lang']."' ORDER BY ProductTypeID limit $start_num,$read_num;";
      }else{
        $str="SELECT ProductTypeID,ProductTypeName,PMM_ProdType,slang,upd_d FROM `producttypes_las` ORDER BY ProductTypeID limit $start_num,$read_num;";
      }

      $result=mysqli_query($link_db,$str);
	  $i=0;
      while(list($ProductTypeID,$ProductTypeName,$PMM_ProdType,$slang,$upd_d)=mysqli_fetch_row($result))
	  {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
	  
	  if($ProductTypeID==1){
	  $prod_typeVal="Build_MB";
	  }else if($ProductTypeID==2){
	  $prod_typeVal="Build_BB";
	  }else if($ProductTypeID==5){
	  $prod_typeVal="Build_CHASSIS";
	  }else if($ProductTypeID==22){
	  $prod_typeVal="Build_JBOD";
	  }else{
	  $prod_typeVal="";
	  }
  ?>
  <tr>
    <td><?=$ProductTypeName;?></td>
	<td>
	<?php
	if($PMM_ProdType!=''){
	$PMM_split=explode(",",$PMM_ProdType,-1);
	//for($k=0;$k<=count($PMM_split);$k++){

	 if(count($PMM_split)>0){
	 foreach($PMM_split as $PMM_val){
	  $str01="select ProductTypeName from producttypes where ProductTypeID=".$PMM_val;
	  $ptcmd=mysqli_query($link_db,$str01);
	  while($ptdata=mysqli_fetch_row($ptcmd)){
	    echo $ptdata[0].", ";
	  }	  
	 }
	 }
	}
	?>
	</td>
	<td><?=$slang;?></td><td ><?=$upd_d;?></td><td ><a href="pro_type_module.php?kinds_prodtype=<?=$prod_typeVal;?>&pt_lang=<?=$slang;?>">Build</a>&nbsp;&nbsp;<a href="pro_type_module.php?pt_id=<?=$ProductTypeID;?>&types=edit#ptype_module_mod">Edit</a>&nbsp;&nbsp;<a href="pro_type_module.php?act=del&pt_id=<?=intval($ProductTypeID);?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a>&nbsp;&nbsp;<a href="?act=copy&pt_id=<?=intval($ProductTypeID);?>&page=<?=$page;?>">Copy</a></td>
  </tr> 
  <?php
      }
  ?>  
  <tr>
     <td colspan="5">
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
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
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
<td><textarea id="DS01" name="DS01" rows="1" cols="30" style="max-width: 250px; max-height: 250px;"></textarea><span style="color:#0F0">允許輸入html,  (), 空白, -, /</span>
</td>
</tr>

<tr>
<th>Associated Product Type(s) in PMM system: </th>
<td>
<p>
<?php
$str_type="select b.ProductTypeID,a.ProductCateID,a.ProductCateName from productcategories a inner join producttypes b on a.ProductCateName=b.ProductTypeName";
$type_result=mysqli_query($link_db,$str_type);
$j=0;
while(list($ProductTypeID,$ProductCateID,$ProductCateName)=mysqli_fetch_row($type_result))
{
$j+=1;
if($j<>5){
$br1="";
}else{
$br1="<br />";
}
?>
<input name="PMM_PT[]" type="checkbox" value="<?=$ProductTypeID;?>" /> <?=$ProductCateName;?>&nbsp;&nbsp;<?=$br1;?>
<?php
}
?>
</p>
<p style="color:#0F0">這裡列出所有在PMM 系統中的 Product Types，可選擇多個，也可以不選。</p>
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<SELECT id="ptypeLang" name="ptypeLang">
<OPTION selected="selected" value="EN">English</OPTION>
<OPTION value="CN">簡中</OPTION>
<OPTION value="ZH">繁中</OPTION>
<OPTION value="JP">日本語</OPTION>
</SELECT>
<span style="color:#0F0">*必選欄位</span>
</td>
</tr>

<tr><td colspan="2"><input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C1" type="button" value="Cancel" onclick="javascript:self.location='pro_type_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
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
if(isset($_REQUEST['pt_id'])<>""){
$pt_id01=intval($_REQUEST['pt_id']);

//"insert into  (`ProductTypeID`, `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `crea_d`, `crea_u`)

$str_m="select `ProductTypeID`, `ProductTypeName`, `Meta_desc`, `Prod_Descript`, `PMM_ProdType`, `GUID`, `slang`, `prodty_show` from `producttypes_las` where `ProductTypeID`=".$pt_id01;
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
<td><input id="MD01m" name="MD01m" type="text" size="40" value="<?=$mdata[2];?>"  />
</td>
</tr>
<tr>
<th>Description:  </th>
<td><textarea id="DS01m" name="DS01m" rows="1" cols="30" style="max-width: 250px; max-height: 250px;"><?=$mdata[3];?></textarea><span style="color:#0F0">允許輸入html,  (), 空白, -, /</span>
</td>
</tr>

<tr>
<th>Associated Product Type(s) in PMM system: </th>
<td>
<p>
<?php
$str_type="select b.ProductTypeID,a.ProductCateID,a.ProductCateName from productcategories a inner join producttypes b on a.ProductCateName=b.ProductTypeName";
$type_result=mysqli_query($link_db,$str_type);
$k=0;
while(list($ProductTypeID,$ProductCateID,$ProductCateName)=mysqli_fetch_row($type_result))
{
$k+=1;
if($k<>5){
$br="";
}else{
$br="<br />";
}
?>
<input name="PMM_PTm[]" type="checkbox" value="<?=$ProductTypeID;?>" <?php if(strpos($mdata[4],$ProductTypeID.",")!="" || strpos($mdata[4],$ProductTypeID.",")===0){ echo "checked"; } //if(eregi($ProductTypeID,$mdata[4])!='') {echo "checked";} ?> /> <?=$ProductCateName;?>&nbsp;&nbsp;<?=$br;?>
<?php
}
?>
</p>
<p style="color:#0F0">這裡列出所有在PMM 系統中的 Product Types，可選擇多個，也可以不選。</p>
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<SELECT id="ptypeLangm" name="ptypeLangm">
<OPTION value="EN" <?php if(strpos($mdata[6],"EN")!='' || strpos($mdata[6],"EN")===0){ echo "selected"; } //if(eregi("EN",$mdata[6])!='') {echo "selected";} ?>>English</OPTION>
<OPTION value="CN" <?php if(strpos($mdata[6],"CN")!='' || strpos($mdata[6],"CN")===0){ echo "selected"; } //if(eregi("CN",$mdata[6])!='') {echo "selected";} ?>>簡中</OPTION>
<OPTION value="ZH" <?php if(strpos($mdata[6],"ZH")!='' || strpos($mdata[6],"ZH")===0){ echo "selected"; } //if(eregi("ZH",$mdata[6])!='') {echo "selected";} ?>>繁中</OPTION>
<OPTION value="JP" <?php if(strpos($mdata[6],"JP")!='' || strpos($mdata[6],"JP")===0){ echo "selected"; } //if(eregi("JP",$mdata[6])!='') {echo "selected";} ?>>日本語</OPTION>
</SELECT>
<span style="color:#0F0">*必選欄位</span>
</td>
</tr>
<tr>
<th>Show Product Info: </th>
<td>
<p>
<?php
$str_pinfo="SELECT a.PI_id, a.PI_Name, a.slang, b.ProductTypeName,b.ProductTypeID FROM `product_info_las` a inner join `producttypes_las` b on instr(CONCAT(',',a.PTYPE_Value),CONCAT(',',b.ProductTypeID,','))>0 where b.ProductTypeID=".$pt_id01." and a.slang='".$mdata[6]."'";
$pinfo_result=mysqli_query($link_db,$str_pinfo);
$k=0;
while(list($PI_id,$PI_Name,$slang,$ProductTypeName,$ProductTypeID)=mysqli_fetch_row($pinfo_result)){
$k+=1;
if($k<>5){
$br="";
}else{
$br="<br />";
}
?>
<input name="show_PIm[]" type="checkbox" value="<?=$PI_id;?>" <?php if(strpos(",".$mdata[7],",".$PI_id.",")!='' || strpos(",".$mdata[7],",".$PI_id.",")===0){ echo "checked"; } ?> /> <?=$PI_Name;?>&nbsp;&nbsp;<?=$br;?>
<?php
}
?>
</p>
</td>
</tr>
<tr><td colspan="2"><input name="ptype_id" type="hidden" value="<?=$mdata[0];?>"><input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;
<input class="button14" style="width:75px;" name="C01m" type="button" value="Cancel" onClick="javascript:self.location='pro_type_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
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
  CKEDITOR.replace( 'DS01', {
    });
</script>
<script>
  CKEDITOR.replace( 'DS01m', {
    });
</script>
</body>
</html>
<?php
 if(isset($_REQUEST['pt_id'])<>""){
 echo "<script language='Javascript'>show_edit();</script>\n";
 exit();
 }
?>