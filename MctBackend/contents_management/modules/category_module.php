<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');
error_reporting(0);

session_set_cookie_params(8*60*60); 
ini_set('session.gc_maxlifetime', '28800');
@session_start();

if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

function Clear_Cookie(){
 if (isset($_SERVER['HTTP_COOKIE']))
 {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie)
        {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
 }
}

if(isset($_REQUEST['act'])!=''){
$act=trim($_REQUEST['act']);
}else{
$act="";
}

if($act=="del"){
$ca_id01=intval($_REQUEST['ca_id']);
$page01=intval($_REQUEST['page']);
$str_del="delete from category_module_las where CategoryModuID=".$ca_id01;
$del_cmd=mysqli_query($link_db,$str_del);
echo "<script>alert('Delete the data!');self.location='category_module.php?page=".$page01."'</script>";
exit();
}

if($act=="copy"){
$ca_id01=intval($_REQUEST['ca_id']);
$page01=intval($_REQUEST['page']);
if($page01!=''){
$page_str="?page=".$page01;
}else{
$page_str="";
}
$str_copy="insert into `category_module_las` (`CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `GUID`, `slang`, `Meta_Des`, `Prod_Info_Sorting`, `Web_Disable`, `crea_d`, `crea_u`, `upd_d`, `upd_u`) SELECT `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `GUID`, `slang`, `Meta_Des`, `Prod_Info_Sorting`, `Web_Disable`, `crea_d`, `crea_u`, `upd_d`, `upd_u` from `category_module_las` where `CategoryModuID`=".$ca_id01."  limit 1";
$copy_cmd=mysqli_query($link_db,$str_copy);
echo "<script>alert('Copy the data!');self.location='category_module.php".$page_str."'</script>";
exit();
}

if(isset($_REQUEST['kinds'])!=''){
$kinds=trim($_REQUEST['kinds']);
}else{
$kinds="";
}

if($kinds=="add_categoryM"){

$str_n="select CategoryModuID FROM category_module_las order by CategoryModuID desc limit 1";
$check_n=mysqli_query($link_db,$str_n);
$Max_MatrixID=mysqli_fetch_row($check_n);
$MCount=$Max_MatrixID[0]+1;

if(isset($_POST['CA01'])!=''){
$CA01=htmlspecialchars($_POST['CA01'], ENT_QUOTES);
}else{
$CA01="";
}
if(isset($_POST['SEL_APTYPE'])!=''){
$SEL_APTYPE=str_replace('category_module.php?capt_aid=', '', $_POST['SEL_APTYPE']);
}else{
$SEL_APTYPE="";
}
if(isset($_POST['SEL_APTYPE_Val'])!=''){
$SEL_APTYPE_Val=trim($_POST['SEL_APTYPE_Val']);
}else{
$SEL_APTYPE_Val="";
}

if(isset($_POST['SEL_LANG'])!=''){
  $SEL_LANG=trim($_POST['SEL_LANG']);
  if($SEL_LANG=="EN" || $SEL_LANG==""){
	  $PLang_si01="EN";
	  $PLang_si="en-US";
	  //$Top_Block=@file_get_contents("../../../top.htm");
	  $Top_Block="<?php include('../top.htm'); ?>";
	  //$Foot_Block=@file_get_contents("../../../foot.htm");
	  $Foot_Block="<?php include('../foot.htm'); ?>";
	  //$memo_PType=@file_get_contents("../../../PT_Sorting.htm");
	  $memo_PType="<?php include('../PT_Sorting.htm'); ?>";
  }else if($SEL_LANG=="JP"){
	  $PLang_si01="JP";
	  $PLang_si="ja-JP";
	  //$Top_Block=@file_get_contents("../../../top_jp.htm");
	  $Top_Block="<?php include('../top_jp.htm'); ?>";
	  //$Foot_Block=@file_get_contents("../../../foot_jp.htm");
	  $Foot_Block="<?php include('../foot_jp.htm'); ?>";
	  //$memo_PType=@file_get_contents("../../../PT_Sorting_jp.htm");
	  $memo_PType="<?php include('../PT_Sorting_jp.htm'); ?>";
  }else if($SEL_LANG=="CN"){
	  $PLang_si01="CN";
	  $PLang_si="zh-CN";
	  //$Top_Block=@file_get_contents("../../../top_cn.htm");
	  $Top_Block="<?php include('../top_cn.htm'); ?>";
	  //$Foot_Block=@file_get_contents("../../../foot_cn.htm");
	  $Foot_Block="<?php include('../foot_cn.htm'); ?>";
	  //$memo_PType=@file_get_contents("../../../PT_Sorting_cn.htm");
	  $memo_PType="<?php include('../PT_Sorting_cn.htm'); ?>";
  }else if($SEL_LANG=="ZH"){
	  $PLang_si01="ZH";
	  $PLang_si="zh-TW";
	  //$Top_Block=@file_get_contents("../../../top_zh.htm");
	  $Top_Block="<?php include('../top_zh.htm'); ?>";
	  //$Foot_Block=@file_get_contents("../../../foot_zh.htm");
	  $Foot_Block="<?php include('../foot_zh.htm'); ?>";
	  //$memo_PType=@file_get_contents("../../../PT_Sorting_zh.htm");
	  $memo_PType="<?php include('../PT_Sorting_zh.htm'); ?>";
  }
}else{
$SEL_LANG="";
}
if(isset($_POST['Intro'])!=''){
//$Intro=htmlspecialchars($_POST['Intro'], ENT_QUOTES);
$Intro=trim($_POST['Intro']);
}else{
$Intro="";
}

if(isset($_POST['stat01'])!=''){
$stat01=htmlspecialchars($_POST['stat01'], ENT_QUOTES);
}else{
$stat01="";
}

$pinfo01="";
if(isset($_POST['pro_info_Tp'])!=''){
  
  foreach($_POST['pro_info_Tp'] as $check_pinfo) {
  $pinfo01=$pinfo01.$check_pinfo.",";
  }

}else{
  $pinfo01='';
}

$str_type_n1="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las` where `ProductTypeID`=".$SEL_APTYPE;
$type_n1_cmd=mysqli_query($link_db,$str_type_n1);
$type_n1_data=mysqli_fetch_row($type_n1_cmd);

/*
$SEL_SKType=trim($_POST['SEL_SKType']);

$chipset_vals_All="";
if(isset($_POST['chipset_Vals_Set'])!=''){
	foreach($_POST['chipset_Vals_Set'] as $chipset_vals){
		$chipset_vals_All.=$chipset_vals.",";
	}
}
$chipset_vals_Alls=substr($chipset_vals_All,0,strlen($chipset_vals_All)-1);

$SEL_Sockets=(int)$_POST['SEL_Sockets'];
$SEL_CPUid=intval($_POST['SEL_CPUid']);
$SEL_cputype=intval($_POST['SEL_cputype']);

$rackmount_vals_All="";
if(isset($_POST['rackmount_Vals_Set'])!=''){
	foreach($_POST['rackmount_Vals_Set'] as $rackmount_vals){
		$rackmount_vals_All.=$rackmount_vals.",";
	}
}
$rackmount_vals_Alls=substr($rackmount_vals_All,0,strlen($rackmount_vals_All)-1);



$chipset_total=count(explode(',',$chipset_vals_Alls,-1));
$rockmount_total=count(explode(',',$rackmount_vals_Alls,-1));

if($SEL_APTYPE_Val==1){
    $ProductTypename01="Motherboards";
	$category_content="SELECT p_s_main_systemboards.SYSTEMBOARDID, p_s_main_systemboards.SMALLIMG, p_s_main_systemboards.IMG, p_s_main_systemboards.BIGIMG, Product_SKUs.MODELCODE, Product_SKUs.SKU, LEFT(c_s_cpu.CPUNAME, length(c_s_cpu.CPUNAME) - 13) AS SHORTCPU, c_s_chipset.CHIPSETNAME, c_s_socket.SOCKETNAME, p_s_main_systemboards.SOCKETNum, c_s_formfactor.FORMFACTORNAME FROM p_s_main_systemboards INNER JOIN c_s_cpu ON p_s_main_systemboards.CPUID = c_s_cpu.CPUID INNER JOIN c_s_chipset ON p_s_main_systemboards.CHIPSETID = c_s_chipset.CHIPSETID INNER JOIN c_s_socket ON p_s_main_systemboards.SOCKETID = c_s_socket.SOCKETID INNER JOIN c_s_formfactor ON p_s_main_systemboards.FORMFACTOR = c_s_formfactor.FORMFACTORID INNER JOIN Product_SKUs ON p_s_main_systemboards.MODELCODE=Product_SKUs.MODELCODE WHERE (p_s_main_systemboards.LANG ='en-US') AND (p_s_main_systemboards.STATUS = '1') AND (p_s_main_systemboards.SOCKETID = '".$SEL_SKType."') AND (p_s_main_systemboards.CPUID = '".$SEL_CPUid."') AND (p_s_main_systemboards.CHIPSETID in (".$chipset_vals_Alls.")) AND (p_s_main_systemboards.SOCKETNum = '".$SEL_Sockets."') AND (Product_SKUs.Web_Disable='0') ORDER BY p_s_main_systemboards.MODELCODE, p_s_main_systemboards.LAUNCH_DATE DESC";
}else if($SEL_APTYPE_Val==2){
    $ProductTypename01="Barebones";
    if($chipset_total>0 && $rockmount_total>0){
	$category_content="SELECT p_b_main_serverbarebones.SERVERID, p_b_main_serverbarebones.SMALLIMG, p_b_main_serverbarebones.IMG, p_b_main_serverbarebones.BIGIMG, Product_SKUs.MODELCODE, Product_SKUs.SKU, c_b_cputype.cputype AS SHORTCPU, c_s_chipset.CHIPSETNAME, c_s_socket.SOCKETNAME, p_b_main_serverbarebones.SOCKETNum, p_b_rackmount.RACKMOUNT FROM p_b_main_serverbarebones INNER JOIN c_b_hddbay ON  p_b_main_serverbarebones.HDDBAYID = c_b_hddbay.HDDBAYID INNER JOIN c_b_powersupply ON  p_b_main_serverbarebones.POWERSUPPLYID = c_b_powersupply.POWERSUPPLYID  INNER JOIN c_b_cputype ON  p_b_main_serverbarebones.CPUTYPEID = c_b_cputype.CPUTYPEID INNER JOIN Product_SKUs ON  p_b_main_serverbarebones.MODELCODE = Product_SKUs.MODELCODE LEFT OUTER  JOIN p_s_main_systemboards ON  p_b_main_serverbarebones.MOTHERBOARDID = p_s_main_systemboards.SYSTEMBOARDID  INNER JOIN c_s_chipset ON  p_s_main_systemboards.CHIPSETID = c_s_chipset.CHIPSETID INNER JOIN c_s_socket ON  p_s_main_systemboards.SOCKETID = c_s_socket.SOCKETID INNER JOIN p_b_rackmount ON p_b_main_serverbarebones.RACKMOUNTID = p_b_rackmount.RACKMOUNTID WHERE (p_b_main_serverbarebones.CPUTYPEID='".$SEL_cputype."') AND (p_s_main_systemboards.SOCKETID='".$SEL_SKType."') AND (p_s_main_systemboards.CHIPSETID in (".$chipset_vals_Alls.")) AND (p_b_main_serverbarebones.LANG='en-US') AND (p_b_main_serverbarebones.STATUS='1') AND (p_b_main_serverbarebones.SOCKETNum='".$SEL_Sockets."') AND (p_b_main_serverbarebones.RACKMOUNTID in (".$rackmount_vals_Alls.")) AND (Product_SKUs.Web_Disable = 0) ORDER BY p_b_main_serverbarebones.SHORTCODE";
	}else if($chipset_total>0 && $rockmount_total==0){
	$category_content="SELECT p_b_main_serverbarebones.SERVERID, p_b_main_serverbarebones.SMALLIMG, p_b_main_serverbarebones.IMG, p_b_main_serverbarebones.BIGIMG, Product_SKUs.MODELCODE, Product_SKUs.SKU, c_b_cputype.cputype AS SHORTCPU, c_s_chipset.CHIPSETNAME, c_s_socket.SOCKETNAME, p_b_main_serverbarebones.SOCKETNum, p_b_rackmount.RACKMOUNT FROM p_b_main_serverbarebones INNER JOIN c_b_hddbay ON  p_b_main_serverbarebones.HDDBAYID = c_b_hddbay.HDDBAYID INNER JOIN c_b_powersupply ON  p_b_main_serverbarebones.POWERSUPPLYID = c_b_powersupply.POWERSUPPLYID  INNER JOIN c_b_cputype ON  p_b_main_serverbarebones.CPUTYPEID = c_b_cputype.CPUTYPEID INNER JOIN Product_SKUs ON  p_b_main_serverbarebones.MODELCODE = Product_SKUs.MODELCODE LEFT OUTER  JOIN p_s_main_systemboards ON  p_b_main_serverbarebones.MOTHERBOARDID = p_s_main_systemboards.SYSTEMBOARDID  INNER JOIN c_s_chipset ON  p_s_main_systemboards.CHIPSETID = c_s_chipset.CHIPSETID INNER JOIN c_s_socket ON  p_s_main_systemboards.SOCKETID = c_s_socket.SOCKETID INNER JOIN p_b_rackmount ON p_b_main_serverbarebones.RACKMOUNTID = p_b_rackmount.RACKMOUNTID WHERE (p_b_main_serverbarebones.CPUTYPEID='".$SEL_cputype."') AND (p_s_main_systemboards.SOCKETID='".$SEL_SKType."') AND (p_s_main_systemboards.CHIPSETID in (".$chipset_vals_Alls.")) AND (p_b_main_serverbarebones.LANG='en-US') AND (p_b_main_serverbarebones.STATUS='1') AND (p_b_main_serverbarebones.SOCKETNum='".$SEL_Sockets."') AND (p_b_main_serverbarebones.RACKMOUNTID=".$rackmount_vals_Alls.") AND (Product_SKUs.Web_Disable = 0) ORDER BY p_b_main_serverbarebones.SHORTCODE";
	}else if($chipset_total==0 && $rockmount_total>0){
	$category_content="SELECT p_b_main_serverbarebones.SERVERID, p_b_main_serverbarebones.SMALLIMG, p_b_main_serverbarebones.IMG, p_b_main_serverbarebones.BIGIMG, Product_SKUs.MODELCODE, Product_SKUs.SKU, c_b_cputype.cputype AS SHORTCPU, c_s_chipset.CHIPSETNAME, c_s_socket.SOCKETNAME, p_b_main_serverbarebones.SOCKETNum, p_b_rackmount.RACKMOUNT FROM p_b_main_serverbarebones INNER JOIN c_b_hddbay ON  p_b_main_serverbarebones.HDDBAYID = c_b_hddbay.HDDBAYID INNER JOIN c_b_powersupply ON  p_b_main_serverbarebones.POWERSUPPLYID = c_b_powersupply.POWERSUPPLYID  INNER JOIN c_b_cputype ON  p_b_main_serverbarebones.CPUTYPEID = c_b_cputype.CPUTYPEID INNER JOIN Product_SKUs ON  p_b_main_serverbarebones.MODELCODE = Product_SKUs.MODELCODE LEFT OUTER  JOIN p_s_main_systemboards ON  p_b_main_serverbarebones.MOTHERBOARDID = p_s_main_systemboards.SYSTEMBOARDID  INNER JOIN c_s_chipset ON  p_s_main_systemboards.CHIPSETID = c_s_chipset.CHIPSETID INNER JOIN c_s_socket ON  p_s_main_systemboards.SOCKETID = c_s_socket.SOCKETID INNER JOIN p_b_rackmount ON p_b_main_serverbarebones.RACKMOUNTID = p_b_rackmount.RACKMOUNTID  WHERE (p_b_main_serverbarebones.CPUTYPEID='".$SEL_cputype."') AND (p_s_main_systemboards.SOCKETID='".$SEL_SKType."') AND (p_s_main_systemboards.CHIPSETID=".$chipset_vals_Alls.") AND (p_b_main_serverbarebones.LANG='en-US') AND (p_b_main_serverbarebones.STATUS='1') AND (p_b_main_serverbarebones.SOCKETNum='".$SEL_Sockets."') AND (p_b_main_serverbarebones.RACKMOUNTID in (".$rackmount_vals_Alls.")) AND (Product_SKUs.Web_Disable = 0) ORDER BY p_b_main_serverbarebones.SHORTCODE";		
	}
}else if($SEL_APTYPE_Val==3){

}else if($SEL_APTYPE_Val==4){

}else if($SEL_APTYPE_Val==5){

}

$category_content_cmd=mysqli_query($link_db,$category_content);

$memo='
<table cellspacing="2" align="Center" border="0" style="background-color:White;border-width:0px;border-style:None;font-size:8pt;width:613px;">
<tr align="center" valign="middle" style="color:#262626;border-width:0px;border-style:None;font-size:8pt;font-weight:bold;text-decoration:none;height:20px;white-space:nowrap;">
<th scope="col">Images</th>
<th scope="col"><a href="#" style="color:#262626;">Standard Model</a></th>
<th scope="col"><a href="#" style="color:#262626;">CPU Mfr</a></th>
<th scope="col"><a href="#" style="color:#262626;">Socket Type</a></th>
<th scope="col"><a href="#" style="color:#262626;">Chipset</a></th>
<th scope="col"><a href="#" style="color:#262626;"># Sockets</a></th>
<th scope="col"><a href="#" style="color:#262626;">Form Factor</a></th>
</tr>';

while($category_content_data=mysqli_fetch_row($category_content_cmd)){
$memo.='<tr align="left" valign="middle" style="border-width:0px;border-style:None;white-space:nowrap;">
<td align="center" style="width:10%;"><img align=middle id="imgPhoto" src="'.str_replace("~/","/new_tyan/",$category_content_data[1]).'"  width="17" height="17" /></td>
<td><a href="/new_tyan/'.$ProductTypename01.'_'.$category_content_data[4].'_'.$category_content_data[5].'">'.$category_content_data[5].'</a></td>
<td>'.$category_content_data[6].'</td><td>'.$category_content_data[7].'</td>
<td>'.$category_content_data[8].'</td>
<td>'.$category_content_data[9].'</td>
<td>'.$category_content_data[10].'</td>
</tr>';
}
*/

$pinfo01_All=substr($pinfo01,0,strlen($pinfo01)-1);
$str_pinfo01="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where `PI_id` in (".$pinfo01_All.")";
$pinfo01_cmd=mysqli_query($link_db,$str_pinfo01);
while($pinfo01_data=mysqli_fetch_row($pinfo01_cmd)){
	$td01.="<th>".$pinfo01_data[1]."</th>";
}

$Tabl='
<table class="table table-hover">
<tr>
'.$td01.'
</tr>
</table>';


$memo='
<div class="content_bg">
<div class="container content_center" >
<div class="row content_row_center" >
<!--Breadcrumbs-->
<div class="row" style="padding:0px 50px">
TYAN > '.$type_n1_data[1].' > '.$CA01.'
<span itemscope itemtype="https://schema.org/breadcrumb"><a itemprop="url" href="#"><span itemprop="title"> </span></a></span>
<hr>
</div>
<!--end Breadcrumbs-->
<!--Product name-->
<div class="row" >
<h1 class="product_name" > '.$CA01.'  </h1>
</div>
<!--end Product name-->
<div class="row">
  <div class="col-md-3 col_padding20 rightborder"  >
 <!--product search box-->
 <div class="jumbotron_search" >
    <div class="input-group">
	<form target="_self" id="form1" name="form1" method="post" action="/search_result.php" >
      <input name="sear_txt" type="text" class="form-control" value="" maxlength="26">
	  <input type="hidden" name="search_method" value="normal" />
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit">Search</button>
      </span>
	</form>
	<script language="javascript">
	function Final_Check(){
	 if(document.form1.sear_txt.value == "" || document.form1.sear_txt.value.length < 3){
	 alert("Requires input a Searched words ! \nInput data is less than 3 bit");
	 document.form1.sear_txt.focus();
	 return false;
	 }
	 return true;
	}
	</script>
    </div>
	<div class="search_note">(Enter a SKU / Model name)</div>
 </div>
 <!--end product search box--> 
 
  <!--product filter boxes-->
   <div class="jumbotron_search" >
   <form target="_self" id="form2" name="form2" method="post" action="/sorting_result.php?PLang='.$PLang_si.'">
 <button class="btn btn-primary btn-xs" type="submit">Find Product</button> ';
   
 $memo.=$memo_PType;

   $memo.='<input type="hidden" name="search_method" value="type" />
   <button class="btn btn-primary btn-xs" type="submit">Find Product</button>
   </form>
   </div>  
   <!--end product filter boxes--> 
  </div>
  
  <div class="col-md-9 col_padding20" >    
    <h2>'.$CA01.' </h2>  
    <!--Category Introduction show on this box. if no introduction, then hide this box-->
    <div class="jumbotron jumbotron_transparent" >
      '.$Intro.'  
	</div>
    <!--end Category Introduction--> 
<div class="clearfix">&nbsp;</div>
  <div class="jumbotron jumbotron_transparent" >
  <div class="table-responsive">
  '.$Tabl.'
  </div>
  </div>    
  <div class="clearfix">&nbsp;</div>
  </div>
</div>
</div>
</div>
</div>
';

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

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
$guid = preg_replace("/{/", '', $guid);
$guid = preg_replace("/}/", '', $guid);

if(isset($_POST['MD01'])!=''){
$MD01=trim($_POST['MD01']);
}else{
$MD01="";
}

$Top_Block1='<div class="jumbotron header_bg">		
<nav class="navbar navbar-blue fhmm navbar-fixed-top" role="navigation" style="background: rgba(0,0,0,0.8);  ">
<div class="container">
<div class="navbar-header">
<button type="button" data-toggle="collapse" data-target="#inversemenu" class="navbar-toggle" style="margin-top:20px"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a href="../" ><img src="../images/TYAN_logo.png" style="margin:0 30px 0px 20px"  /></a>
</div><!-- end navbar-header -->
<div id="inversemenu" class="navbar-collapse collapse">
<ul class="nav navbar-nav" style="margin-top:60px">
<!-- PRODUCTS -->
<li class="dropdown fhmm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle">PRODUCTS <b class="caret"></b></a>
<ul class="dropdown-menu fullwidth" >
<li class="fhmm-content withoutdesc">
<div class="row">
<div class="col-sm-4">
<h3 class="title">Intel</h3>
<div class="head_blue">Server Motherboards</div>
<ul>
<li><a href="/product_motherboards_up_intel_xeon_e3-1200_v5.php"><i class="glyphicon glyphicon-chevron-right"></i> UP Xeon E3-1200 v5 (Skylake)</a></li>
<li><a href="/product_motherboards_up_intel_xeon_e5-2600-v3.php"><i class="glyphicon glyphicon-chevron-right"></i> UP Xeon E5-2600 v3 (Haswell-EP)</a></li>
<li><a href="/product_motherboards_up_intel_xeon_e3-1200_v3.php"><i class="glyphicon glyphicon-chevron-right"></i> UP Xeon E3-1200 v3 or Core i3/i5/i7 (Haswell)</a></li>
<li><a href="/product_motherboards_up_intel_xeon_1200.php"><i class="glyphicon glyphicon-chevron-right"></i> UP Xeon E3-1200 v2 or Core i3/i5/i7 (Ivy Bridge / Sandy Bridge)</a></li>
<li><a href="/product_motherboards_dp_intel_xeon_e5-2400.php"><i class="glyphicon glyphicon-chevron-right"></i> DP Xeon E5-2400 v2 (Ivy Bridge-EN)</a></li>
<li><a href="/product_motherboards_dp_intel_xeon_e5-2600.php"><i class="glyphicon glyphicon-chevron-right"></i> DP Xeon E5-2600 v2 (Ivy Bridge-EP)</a></li>
<li><a href="/product_motherboards_dp_intel_xeon_e5-2600-v3.php"><i class="glyphicon glyphicon-chevron-right"></i> DP Xeon E5-2600 v3 (Haswell-EP)</a></li>
<li><a href="/product_motherboards_dp_intel_xeon_5500.php"><i class="glyphicon glyphicon-chevron-right"></i> DP Xeon 5500/5600 (Nehalem / Westmere)</a></li>
</ul>
<div class="head_blue">Server Barebones</div>
<ul>
<li><a href="/product_barebones_4u_intel_xeon_e3-1200_v3.php"><i class="glyphicon glyphicon-chevron-right"></i> 2U/4U Xeon E3-1200 v3 (Haswell)</a></li>
<li><a href="/product_barebones_2u4u_intel_xeon_e3-1200_i3-2100.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U/2U/4U Xeon E3-1200 v2 or Core i3-2100 (Ivy Bridge / Sandy Bridge)</a></li>
<li><a href="/product_barebones_intel_xeon_e5-2600-v3.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U/2U/4U Xeon E5-2600 v3 (Haswell-EP)</a></li>
<li><a href="/product_barebones_2u_intel_xeon_e5-2600.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U/2U/4U Xeon E5-2600 v2 (Ivy Bridge-EP)</a></li>
<li><a href="/product_barebones_intel_xeon_e5-2400.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U Xeon E5-2400 v2 (Ivy Bridge-EN)</a></li>
<li><a href="/product_barebones_intel_xeon_E7-8800_E7-4800.php"><i class="glyphicon glyphicon-chevron-right"></i> 4U Xeon E7-8800 v3 / E7-4800 v3 (Haswell-EX)</a></li>
<li><a href="/product_barebones_4u_intel_xeon_e5-4600.php"><i class="glyphicon glyphicon-chevron-right"></i> 4U Xeon E5-4600 v2 (Ivy Bridge-EP)</a></li>
<li><a href="/product_barebones_intel_xeon_5500_5600.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U/2U/4U/5U Xeon 5500/5600 (Nehalem / Westmere)</a></li>
</ul>
</div><!-- end col-4 -->
<div class="col-sm-4">
<h3 class="title"><a href="#">AMD</a></h3>
<div class="head_blue">Server Motherboards</div>
<ul>
<li><a href="/product_motherboards_up_amd_opteron_1300.php"><i class="glyphicon glyphicon-chevron-right"></i> UP Opteron 1300 (AM3 / Suzuka)</a></li>
<li><a href="/product_motherboards_up_amd_opteron_4100.php"><i class="glyphicon glyphicon-chevron-right"></i> UP Opteron 4100/4200/4300 (C32 / Lisbon, Valencia, Seoul)</a></li>
<li><a href="/product_motherboards_dp_amd_opteron_4100.php"><i class="glyphicon glyphicon-chevron-right"></i> DP Opteron 4100/4200/4300 (C32 / Lisbon, Valencia, Seoul)</a></li>
<li><a href="/product_motherboards_dp_amd_opteron_6100.php"><i class="glyphicon glyphicon-chevron-right"></i> DP Opteron 6100/6200/6300 (G34 / Magny-Cours, Interlagos, Abu Dhabi)</a></li>
<li><a href="/product_motherboards_mp_amd_opteron_6100.php"><i class="glyphicon glyphicon-chevron-right"></i> MP Opteron 6100/6200/6300 (G34 / Magny-Cours, Interlagos, Abu Dhabi)</a></li>
</ul>
<div class="head_blue">Server Barebones</div>
<ul>
<li><a href="/product_barebones_1u_amd_opteron_1300.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U Opteron 1300 (AM3 / Suzuka)</a></li>
<li><a href="/product_barebones_1u_amd_opteron_4100.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U Opteron 4100/4200 (C32 / Lisbon, Valencia）</a></li>
<li><a href="/product_barebones_1u_amd_opteron_6100.php"><i class="glyphicon glyphicon-chevron-right"></i> 1U Opteron 6100/6200/6300 (G34 / Magny-Cours, Interlagos, Abu Dhabi)</a></li>
<li><a href="/product_barebones_2u_amd_opteron_6100.php"><i class="glyphicon glyphicon-chevron-right"></i> 2U Opteron 6100/6200/6300 (G34 / Magny-Cours, Interlagos, Abu Dhabi)</a></li>
<li><a href="/product_barebones_4u_amd_opteron_1300.php"><i class="glyphicon glyphicon-chevron-right"></i> 4U Opteron 3200/1300 (Zurich / Budapest / Suzuka)</a></li>
<li><a href="/product_barebones_4u_5u_amd_opteron_6100.php"><i class="glyphicon glyphicon-chevron-right"></i> 4U Opteron 6100/6200/6300 (G34 / Magny-Cours, Interlagos, Abu Dhabi)</a></li>
</ul>
<h3 class="title">OpenPOWER Foundation</h3>
<ul>
<li><a href="/product_barebones_openpower_power8.php"><i class="glyphicon glyphicon-chevron-right"></i> 2U IBM Power8</a></li>
</ul>	
<h3 class="title"><a href="#">TYAN JBOD</a></h3>
<h3 class="title"><a href="#">TYAN Server Chassis</a></h3>
<h3 class="title">TYAN Solutions</h3>
<ul>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Coprocessor Platforms</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> GPU Computing Platforms</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> HPC Platforms</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Cloud Platforms</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Embedded Platforms</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> SMB Platforms</a></li>
</ul>
</div><!-- end col-4 -->
<div class="col-sm-4">
<h3 class="title"><a href="#">Server Adapters</a></h3>
<h3 class="title"><a href="#">Accessories</a></h3>
<h3 class="title">Archive</h3>
<ul>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Motherboards</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Barebones</a></li>
</ul>
<div style="margin-top:60px">
<button type="button" class="btn btn-default" style="margin-bottom:2px"><i class="fa fa-bars "></i>&nbsp;&nbsp;Product Matrix</button><br />
<button type="button" class="btn btn-default" style=" margin-bottom:2px"><i class="fa fa-folder "></i>&nbsp;&nbsp;Catalogs</button>
</div>
</div><!-- end col-4 -->
</div><!-- end row -->
</li><!-- fhmm-content -->
</ul><!-- dropdown-menu -->
</li><!-- PRODUCTS -->
<!-- list SUPPORTS  -->
<li class="dropdown fhmm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle">SUPPORTS <b class="caret"></b></a>
<ul class="dropdown-menu half">
<li class="fhmm-content withoutdesc">
<div class="row">
<div class="col-sm-4">
<h3 class="title">Compatibility</h3>
<ul>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> CPU Support Lists</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> VMware Support Lists</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> OS Matrix</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Video Compatibility Lists</li>
</ul>
</div>
<div class="col-sm-4">
<h3 class="title">Warranty Service</h3>
<ul>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> General Warranty</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> RMA Service Procedure</li>
</ul>
</div>
<div class="col-sm-4">
<ul>
<li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> &nbsp;&nbsp;Online Service</li>
<li><a href="#"><span class="glyphicon glyphicon-headphones"></span> &nbsp;&nbsp;HelpStar</li>
<li><a href="#"><span class="glyphicon glyphicon-phone-alt"></span> &nbsp;&nbsp;Contact Us</a></li>
</ul>
</div>
</div><!-- end row -->
</li><!-- end grid demo -->
</ul><!-- end drop down menu -->
</li><!-- end SUPPORTS  -->
<!-- WHERE TO BUY -->
<li class="dropdown fhmm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle">WHERE TO BUY<b class="caret"></b></a>
<ul class="dropdown-menu half">
<li class="fhmm-content withoutdesc">
<div class="row">
<div class="col-sm-4">
<ul>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> United States</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Central / South America</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Europe</a></li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Middle East / Africa</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Asia</li>
<li><a href="#"><i class="glyphicon glyphicon-chevron-right"></i> Others</a></li>
</ul>									
</div>
<div class="col-sm-8">
<div class="head_blue"> <i class="fa fa-star"></i> Recommended Resellers <i class="fa fa-star"></i></div>
<div class="row">
<div class="col-xs-6 col-md-4" >
<a href="#" class="thumbnail" target="wtb" title="">
<img src="images/top_menu/where_to_buy/gtm_s1.png" alt="" class="img-responsive"  />
</a>
</div>
<div class="col-xs-6 col-md-4" >
<a href="#" class="thumbnail" target="wtb" title="">
<img src="images/top_menu/where_to_buy/gtm_s2.png" alt="" class="img-responsive" />
</a>
</div>						
<div class="col-xs-6 col-md-4" >
<a href="#" class="thumbnail" target="wtb" title="">
<img src="images/top_menu/where_to_buy/gtm_s3.png" alt="" class="img-responsive" />
</a>
</div>
<div class="col-xs-6 col-md-4" >
<a href="#" class="thumbnail" target="wtb" title="">
<img src="images/top_menu/where_to_buy/gtm_s3.png" alt="" class="img-responsive" />
</a>
</div>
<div class="col-xs-6 col-md-4" >
<a href="#" class="thumbnail" target="wtb" title="">
<img src="images/top_menu/where_to_buy/gtm_s3.png" alt="" class="img-responsive" />
</a>
</div>
<div class="col-xs-6 col-md-4" >
<a href="#" class="thumbnail" target="wtb" title="">
<img src="images/top_menu/where_to_buy/gtm_s3.png" alt="" class="img-responsive" />
</a>
</div>						  
</div>
</div>
</div> 								
</li><!-- grid demo -->
</ul><!-- end dropdown-menu -->
</li><!-- end dropdown fhmm-fw -->					   
</ul><!-- end nav navbar-nav -->    
<!-- Search -->			
<ul class="nav navbar-nav navbar-right" style="margin-top:60px; ">
<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-search"></span> Search<b class="caret"></b></a>
<ul class="dropdown-menu" >
<li>
<div style="padding:20px">					  
<form name="form_search" method="post" action="./search_result.php">
<div class="form-group">
<input id="txtInput" name="txtInput" type="text" placeholder="Enter a Model / SKU name or keywords" class="form-control" maxlength="26">
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary">Search</button>
</div>
</form>					  
</div>
</li>
</ul>
</li>
</ul>			
<!-- end Search -->				
<!-- Languages -->
<ul class="nav navbar-nav navbar-right" style="margin-top:60px; margin-right:10px ">  
<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-globe"></span> English<b class="caret"></b></a>
<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" style="width:231px">
<li><a href="#">简体中文</a></li>
<li><a href="#">繁體中文</a></li>
<li><a href="#">日本語</a></li>
<li>&nbsp;</li>
</ul>
</li>
</ul>			
<!-- end Languages -->				
</div><!-- end #navbar-collapse-1 -->
</div>
</nav><!-- end navbar navbar-default fhmm -->
<!-- end container -->
</div><!-- end jumbo -->';

$Foot_Block1='<div class="footer_index">
<div class="container">
<div class="row" > 
<!--footer:Corporation-->
<div class="col-md-4" >
<div class="footer_index_con">
<h2>Corporation:</h2>
<div class="row">
<div class="col-xs-6"> 
<p><a href="" />About TYAN</a></p>
<p><a href="" />Success Stories</a></p>
<p><a href="" />Partnerships</a></p>
<p><a href="" />Environments</a></p>	
<p><a href="" />Jobs</a></p>	
<p><a href="" />TYAN Logo</a></p>	
<p><a href="" />Contact Us</a></p>
</div>
<div class="col-xs-6"> 
<p><a href="" />Press Release</a></p>
<p><a href="" />Newsletters</a></p>
<p><a href="" />Events</a></p>
<p><a href="" />Awards</a></p>
</div>
</div>
</div>
</div>
<!--end footer:Corporation-->
<!--footer:Products-->
<div class="col-md-4" >
<div class="footer_index_con">
<h2>Discover:</h2>
<div class="row">
<div class="col-xs-6"> 
<p><a href="" />Motherboards</a></p>
<p><a href="" />Barebones</a></p>	
<p><a href="" />Chassis</a></p>
<p><a href="" />Adapters</a></p>	
<p><a href="" />Accessories</a></p>	
<p><a href="" />Product Archive</a></p>	
<p><a href="" />Product Matrix</a></p>	
</div>
<div class="col-xs-6"> 
<p><a href="" />Coprocessor Platforms</a></p>
<p><a href="" />AMD Open 3.0</a></p>
<p><a href="" />GPU Platforms</a></p>
<p><a href="" />HPC Platforms</a></p>
<p><a href="" />Cloud Platforms</a></p>
<p><a href="" />Embedded Platforms</a></p>
<p><a href="" />SMB Platforms</a></p>
</div>
</div>
</div>  
</div>
<!--end footer:Products-->
<div class="col-md-4" >
<div class="footer_index_con">
<h2>Join TYAN Newsletter:</h2>
<!--footer:newsletter-->
<form id="form_nletter" name="form_nletter" method="post" action="#">
<div class="input-group">
<input id="mail" name="mail" type="text" class="form-control" value="Please enter your e-mail" onkeypress="checkComments()" />	  
<div class="input-group-btn">
<select id="nlang" name="nlang" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<option selected value="en-US">English</option>
<option value="zh-TW">繁體中文</option>
<option value="zh-CN">简体中文</option>
</select>
</div>
</div>
<div style="margin:10px 0px 30px 0px"><button id="MVaBtn" type="button" class="btn btn-primary" >Subscribe</button></div>
<div class="alert alert-success" id="sucss_msg" style="display:none">Thank you for your subscription.</div>
<div class="alert alert-danger" id="err_msg" style="display:none">Invalid e-mail address or the account that you inputed has exsited!</div>
<div id="get_msg"></div>
</form>
<div id="auth-status" style="display:none">
<div id="auth-loggedout">
<div class="fb-login-button" autologoutlink="true" scope="email,user_checkins">Subscribe with facebook</div>
</div>
<div id="auth-loggedin" style="display:none">
<!--Hi, <span id="auth-displayname"></span> <br /> <input id="GetMail" runat="server" type="text" /><br />
<input id="uid" runat="server" type="text" /><br />
<img id="Img1" runat="server" alt="" src="" /><br /> <asp:TextBox ID="txtURL" runat="server"></asp:TextBox> <br /> <span id="auth-displayEmail"></span>-->(<a href="#" id="auth-logoutlink">logout</a>)
</div>
</div>	
<!--end footer:newsletter-->
<h2>Get connected with TYAN:</h2> 
<!--social networking icons-->
<p class="footer_social_icons">
<a href="http://www.facebook.com/tyancomputer" target="_blank" /><i class="fa fa-facebook fa-3x" ></i></a> &nbsp;&nbsp;&nbsp;
<a href="http://twitter.com/#!/tyanusa" target="_blank" /><i class="fa fa-twitter fa-3x" ></i></a> &nbsp;&nbsp;&nbsp;
<a href="http://www.linkedin.com/company/tyan-computer" target="_blank" /><i class="fa fa-linkedin fa-3x" ></i></a> &nbsp;&nbsp;&nbsp;
<a href="http://www.youtube.com/user/tyancomputer" target="_blank" /><i class="fa fa-youtube fa-3x" ></i></a> &nbsp;&nbsp;&nbsp;
<a href="https://plus.google.com/109587363131452881010?prsrc=3" target="_blank" /><i class="fa fa-google-plus fa-3x" ></i></a> &nbsp;&nbsp;&nbsp;
</p>  <!--end social networking icons-->
</div>
</div>		   
</div>	 
</div>
</div>	  
<footer>
<div class="container">
<div class="row"> 
<div style="text-align:center">
Copyright&copy; 2004-2014 MiTAC International Corporation and/or any of its affiliates. All Rights Reserved. <br />
Information published on TYAN.com is subject to change without notice. All other trademarks are property of their respective companies.<br />
This site is best viewed using the latest versions of  Internet Explorer, Firefox, and Chrome.<br />
<a href="#" target="tos" />Terms of Use</a> &middot; <a href="#" target="tos" />Privacy Policy</a>
</div>		
</div>  
</div>
</footer>
<div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>	
	<script>
	$("#myTab a").click(function (e) {
	e.preventDefault()
	$(this).tab("show")
	})
	</script>	
	<script>
	$(".collapse").collapse()	
	</script>';


$htmlcode = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../images/ico/favicon.ico">	
<title>TYAN Computer</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<link href="../css/font-awesome.css" rel="stylesheet">
<link href="../css/fhmm.css" rel="stylesheet">	
<!--[if lt IE 9]>	
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="../js/gtm/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script language="JavaScript">
  function check_result(){
  var tInput = document.form_search.txtInput.value;
    if(tInput=="" || tInput.length<3){
		alert("Requires input a Searched words ! \nInput data is less than 3 bit");
		document.form_search.txtInput.focus();
		return false;
	}
	return true;  
  }
  function checkData(m,tm,pf_Val){
  
  var tp_id="0"+m+""+tm;
  var n=$("#PINFO_SecNum"+m).val();
  
  var s=0;
  for(s=0;s<document.form2.elements.length;s++){

   if((document.form2.elements[s].type == "checkbox") && (document.form2.elements[s].value==tp_id))
   { 
		 var TPname="#PINFO_TPVal"+tp_id+"[]";		 
         var Fname = ".PINFO_Val_S"+tp_id;
         var lenA = $(Fname+":checked").length;
         if(lenA>0){
         document.form2.elements[s].checked=true;
		    if(lenA>1){
			$(Fname).prop("checked", false);
			$(TPname).prop("checked", false);
			}else{
			document.form2.elements[s].disabled=false;
			}
         }else{
         document.form2.elements[s].checked=false;
         }        
   }

  } 
  
  var checkedCount=0;
  var checkbox = document.getElementsByName("PINFO_Val"+m+"[]");

      for(var i=0;i<checkbox.length;i++){
         if(checkbox[i].checked){		  
         checkedCount++;
		 }
		 
      }
       if(checkedCount>n){
           return false;
      }
  }
  </script>
<script type="text/javascript">
function checkComments(){
if(( event.keyCode > 32 && event.keyCode < 46) || // 46=.
   ( event.keyCode > 57 && event.keyCode < 64) || // 64=@
   ( event.keyCode > 90 && event.keyCode < 97) ||
   ( event.keyCode > 123 && event.keyCode < 127)) { // 124=~,125=},126=|
     event.returnValue = false; 
   }
}
</script>
<script>
  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");

  ga("create", "UA-113958064-1", "auto");
  ga("send", "pageview");
</script>
</head>
<body>
'.$Top_Block.'
'.$memo.'
'.$Foot_Block.'
</body>
</html>
';

$CAS01=str_replace(" ", '_', $CA01);
$CAS01=str_replace("/", '_', $CAS01);
$CAS01=str_replace("/", '_', $CAS01);
$CAS01=str_replace("(", '_', $CAS01);
$CAS01=str_replace(")", '', $CAS01);
$CAS01=str_replace("）", '', $CAS01);
$CAS01=str_replace("___", '_', $CAS01);
$CAS01=str_replace("__", '_', $CAS01);

ob_start();
file_put_contents($SEL_LANG."/".$CAS01.".htm", $htmlcode);
ob_end_clean();

if($SEL_LANG!='EN'){
$SEL_LANGS=$SEL_LANG."/";
}else{
$SEL_LANGS="";
}
copy($SEL_LANG."/".$CAS01.".htm","../../../".$SEL_LANGS.$CAS01.".htm");
unlink($SEL_LANG."/".$CAS01.".htm"); //刪除該檔案


$str_add="insert into `category_module_las` (`CategoryModuID`, `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `GUID`, `slang`, `Meta_Des`, `Prod_Info_Sorting`, `Web_Disable`, `crea_d`, `crea_u`, `upd_d`, `upd_u`) values (".$MCount.",'".$CA01."',".$SEL_APTYPE_Val.",'".$Intro."','".$CAS01.".htm','".$guid."','".$SEL_LANG."','".$MD01."','".$pinfo01."',".$stat01.",'".$now."','1706','".$now."','1706')";
//echo $str_add;exit();
$add_cmd=mysqli_query($link_db,$str_add);

Clear_Cookie();
echo "<script>alert('AddNew Category Module!');location.href='category_module.php'</script>";
exit();

}else if($kinds=="mod_categoryM"){
$Introm="";$memo_M="";$Top_Block="";$td01="";$Foot_Block="";
if(isset($_POST['CA01m'])!=''){
$CA01m=htmlspecialchars($_POST['CA01m'], ENT_QUOTES);
}else{
$CA01m="";
}

if(isset($_POST['SEL_PTYPEm_Val'])!=''){
$SEL_PTYPEm=trim($_POST['SEL_PTYPEm_Val']);
}else{
$SEL_PTYPEm=str_replace('category_module.php?ca_id=&pt_mid=', '', trim($_POST['SEL_PTYPEm']));
}

if(isset($_POST['SEL_LANGm'])!=''){
$SEL_LANGm=trim($_POST['SEL_LANGm']);
}else{
$SEL_LANGm="";
}

if($SEL_LANGm=="EN" || $SEL_LANGm==""){
	  $PLang_si01="EN";
	  $PLang_si="en-US";
	  $Top_Block=@file_get_contents("../../../top.htm");
	  $Foot_Block=@file_get_contents("../../../foot.htm");
	  $memo_M_PType=@file_get_contents("../../../PT_Sorting.htm");
  }else if($SEL_LANGm=="JP"){
	  $PLang_si01="JP";
	  $PLang_si="ja-JP";
	  $Top_Block=@file_get_contents("../../../top_jp.htm");
	  $Foot_Block=@file_get_contents("../../../foot_jp.htm");
	  $memo_M_PType=@file_get_contents("../../../PT_Sorting_jp.htm");
  }else if($SEL_LANGm=="CN"){
	  $PLang_si01="CN";
	  $PLang_si="zh-CN";
	  $Top_Block=@file_get_contents("../../../top_cn.htm");
	  $Foot_Block=@file_get_contents("../../../foot_cn.htm");
	  $memo_M_PType=@file_get_contents("../../../PT_Sorting_cn.htm");
  }else if($SEL_LANGm=="ZH"){
	  $PLang_si01="ZH";
	  $PLang_si="zh-TW";
	  $Top_Block=@file_get_contents("../../../top_zh.htm");
	  $Foot_Block=@file_get_contents("../../../foot_zh.htm");
	  $memo_M_PType=@file_get_contents("../../../PT_Sorting_zh.htm");
  }

 
if(isset($_POST['Introm'])!=''){
//$Introm=htmlspecialchars($_POST['Introm'], ENT_QUOTES);
$Introm=trim($_POST['Introm']);
}else{
$Introm="";
}

if(isset($_POST['stat01m'])!=''){
$stat01m=htmlspecialchars($_POST['stat01m'], ENT_QUOTES);
}else{
$stat01m="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if(isset($_POST['MD01m'])!=''){
$MD01m=trim(str_replace("'","&#39;",$_POST['MD01m']));
}else{
$MD01m="";
}

$pinfoM01="";
if(isset($_POST['pro_info_TpM'])!=''){
  
  foreach($_POST['pro_info_TpM'] as $check_pinfoM) {
  $pinfoM01=$pinfoM01.$check_pinfoM.",";
  }

}else{
  $pinfoM01='';
}

$str_type_n1m="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las` where `ProductTypeID`=".$SEL_PTYPEm;
$type_n1m_cmd=mysqli_query($link_db,$str_type_n1m);
$type_n1m_data=mysqli_fetch_row($type_n1m_cmd);


$pinfoM01_All=substr($pinfoM01,0,strlen($pinfoM01)-1);
$str_pinfoM01="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where `PI_id` in (".$pinfoM01_All.")";
$pinfoM01_cmd=mysqli_query($link_db,$str_pinfoM01);
while($pinfoM01_data=mysqli_fetch_row($pinfoM01_cmd)){
	$td01.="<th style='font-size: x-small;'>".$pinfoM01_data[1]."</th>";
}

$Tabl_M='
<table class="table table-hover">
<tr>
'.$td01.'
</tr>
</table>';

$memo_M='
<div class="content_bg">
<div class="container content_center" >
<div class="row content_row_center" >
<!--Breadcrumbs-->
<div class="row" style="padding:0px 50px">
TYAN > '.$type_n1m_data[1].' > '.$CA01m.'
<span itemscope itemtype="https://schema.org/breadcrumb"><a itemprop="url" href="#"><span itemprop="title"> </span></a></span>
<hr>
</div>
<!--end Breadcrumbs-->
<!--Product name-->
<div class="row" >
<h1 class="product_name"> '.$CA01m.'  </h1>
</div>
<!--end Product name-->
<div class="row">
  <div class="col_padding20 rightborder"  >
 
  </div>
  
  <div class="col-md-9 col_padding20" >    
    <h2 style="font-size: xx-large;">'.$CA01m.' </h2>  
    <!--Category Introduction show on this box. if no introduction, then hide this box-->
    <div class="jumbotron jumbotron_transparent" style="font-size: x-small;">
      '.$Introm.'  
	</div>
    <!--end Category Introduction--> 
<div class="clearfix">&nbsp;</div>
  <div class="jumbotron jumbotron_transparent" >
  <div class="table-responsive">
  '.$Tabl_M.'
  </div>
  </div>    
  <div class="clearfix">&nbsp;</div>
  </div>
</div>
</div>
</div>
</div>
';


if(isset($_POST['catg_id'])!=''){
$catg_id=$_POST['catg_id'];
}

$htmlcodem = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="/images/ico/favicon.ico">	
<title>TYAN Computer</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
<script src="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/js/bootstrap.min.js" type="text/javascript"></script>
<link href="/css/bootstrap.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet">
<link href="/css/font-awesome.css" rel="stylesheet">
<link href="/css/fhmm.css" rel="stylesheet">	
<link href="/css/carousel.css" rel="stylesheet">	
<!-- Just for debugging purposes. Dont actually copy this line! -->
<!--[if lt IE 9]>	
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="/js/gtm/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>

<script type="text/javascript">
	function checkComments(){
	if(( event.keyCode > 32 && event.keyCode < 46) || // 46=.
	   ( event.keyCode > 57 && event.keyCode < 64) || // 64=@
       ( event.keyCode > 90 && event.keyCode < 97) ||
	   ( event.keyCode > 123 && event.keyCode < 127)) { // 124=~,125=},126=|
       event.returnValue = false; 
       }
	}
</script>
<script>
  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");

  ga("create", "UA-22726154-5", "auto");
  ga("send", "pageview");
</script>
</head>
<body>
'.$Top_Block.'
'.$memo_M.'
'.$Foot_Block.'
<div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>	
	<script>
	$("#myTab a").click(function (e) {
	e.preventDefault()
	$(this).tab("show")
	})
	</script>	
	<script>
	$(".collapse").collapse()	
	</script>
</body>
</html>
';

$CAS01m=str_replace(" ", '_', $CA01m);
$CAS01m=str_replace("/", '_', $CAS01m);
$CAS01m=str_replace("/", '_', $CAS01m);
$CAS01m=str_replace("(", '_', $CAS01m);
$CAS01m=str_replace(")", '', $CAS01m);
$CAS01m=str_replace("）", '', $CAS01m);
$CAS01m=str_replace("___", '_', $CAS01m);
$CAS01m=str_replace("__", '_', $CAS01m);

ob_start();
file_put_contents($SEL_LANGm."/".$CAS01m.".htm", $htmlcodem);
ob_end_clean();

copy($SEL_LANGm."/".$CAS01m.".htm","../../../".$SEL_LANGm."/".$CAS01m.".php");
unlink($SEL_LANGm."/".$CAS01m.".htm"); //刪除該檔案

$str_upd="update `category_module_las` set `CategoryModuName`='".$CA01m."', `ProdTypeID`=".$SEL_PTYPEm.", `CategIntroduction`='".$Introm."', `urls`='".$CAS01m.".htm', `slang`='".$SEL_LANGm."', `Meta_Des`='".$MD01m."', `Prod_Info_Sorting`='".$pinfoM01."', `Web_Disable`=".$stat01m.", `upd_d`='".$now."', `upd_u`='1706' where `CategoryModuID`=".$catg_id;
$upd_cmd=mysqli_query($link_db,$str_upd);
//Clear_Cookie();

echo "<script>alert('Update Category Module!');location.href='category_module.php'</script>";
exit();
}

$pt_id="";$pt_lang="";
if(isset($_REQUEST['pt_id'])!=''){
 if(trim($_REQUEST['pt_id'])!=''){  
 //$pt_id=eregi_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['pt_id']);
  $pt_id=preg_replace("/['\"\$ \r\n\t;<>\?]/i", '', intval($_REQUEST['pt_id']));
  if($pt_id==0){
  $pt_id="";
  }
 }else{
 $pt_id="";
 }
}else{
$pt_id="";
}

if(isset($_REQUEST['pt_lang'])<>''){
//$pt_lang=eregi_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['pt_lang']);
$pt_lang=preg_replace("/['\"\$ \r\n\t;<>\?]/i", '', trim($_REQUEST['pt_lang']));
}else{
$pt_lang="";
}

if($pt_id<>''){
  if($pt_lang<>''){  
  $str1="select count(*) from category_module_las where ProdTypeID=".$pt_id." and slang='".$pt_lang."'";
  }else{
  $str1="select count(*) from category_module_las where ProdTypeID=".$pt_id;
  }
}else{
  if($pt_lang<>''){
  $str1="select count(*) from category_module_las where slang='".$pt_lang."'";
  }else{
  $str1="select count(*) from category_module_las";
  }
}
  
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Category Module </title>
<link rel="stylesheet" type="text/css" href="../../css.css" />
<link rel="stylesheet" type="text/css" href="../../backend.css">
<script type="text/javascript" src="../../jquery.min.js"></script>
<script type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript">
function cookie_val(){
 
 if($.cookie("CA01")!=null){
  document.getElementById("CA01").value=$.cookie("CA01");
 }
 if($.cookie("Intro")!=null){
  document.getElementById("Intro").value=$.cookie("Intro");
 }
 if($.cookie("MD01")!=null){
  document.getElementById("MD01").value=$.cookie("MD01");
 }
 
}
function MM_o(selObj){
window.open(document.getElementById('SEL_PTYPE').options[document.getElementById('SEL_PTYPE').selectedIndex].value,"_self");
}
function MM_LA(selObj){
window.open(document.getElementById('SEL_LANGS').options[document.getElementById('SEL_LANGS').selectedIndex].value,"_self");
}
function MM_PT(selobj){
$.cookie("CA01", $("#CA01").val(), { expires: 1 });
$.cookie("Intro", $("#Intro").val(), { expires: 1 });
$.cookie("MD01", $("#MD01").val(), { expires: 1 });
//alert(document.getElementById('SEL_APTYPE').selectedIndex);
window.open(document.getElementById('SEL_APTYPE').options[document.getElementById('SEL_APTYPE').selectedIndex].value+"#category_module_add","_self");

//var AP01 = document.getElementById('SEL_APTYPE').selectedIndex;
//Product_check(AP01);
}
function MM_PTm(selobj){
window.open(document.getElementById('SEL_PTYPEm').options[document.getElementById('SEL_PTYPEm').selectedIndex].value+"#category_module_mod","_self");
}

//2017.11.09 add
function select_langA(){
	//var lang = document.getElementById("selectlang").value;
	window.open(document.getElementById('selectlangA').options[document.getElementById('selectlangA').selectedIndex].value+"#category_module_add","_self");
	//document.getElementById('test').value=lang;
}

function select_lang(){
	//var lang = document.getElementById("selectlang").value;
	window.open(document.getElementById('selectlang').options[document.getElementById('selectlang').selectedIndex].value+"#category_module_mod","_self");
	//document.getElementById('test').value=lang;
}
//end

function show_add(){
$("#category_module_add").show();
$("#category_module_mod").hide();
}
function hide_add(){
self.location="category_module.php";
}

function show_edit(){
$("#category_module_mod").show();
$("#category_module_add").hide();
}
function hide_edit(){
self.location="category_module.php";
}

function Product_check(pid){
	var pidVal =parseInt(pid);
	alert(pidval);
	if(pidVal==1 || pidVal==6 || pidVal==11 || pidVal==16){
		
		//$(".sockettype_A").show();$(".chipset_A").show();$(".sockets_A").show();$(".cpu_A").show();$(".cputype_A").hide();$(".rackmount_A").hide();
		//document.getElementById("cputype_A").style.display = "none";		
		$(".addspec .sockettype_A").show();
		$(".addspec .chipset_A").show();
		$(".addspec .cputype_A").hide();
		$(".addspec .rackmount_A").hide();
		
	}else if(pidVal==2 || pidVal==7 || pidVal==12 || pidVal==17){
		//$("#cpu_A").hide(); 
		//$("#sockettype_A").show();$("#chipset_A").show();$("#sockets_A").show();$("#cputype_A").show();$("#rackmount_A").show();
		//$('.addspec .sockettype_A').show();$('.addspec .chipset_A').show();
		
		//$('.addspec .cpu_A').hide();
		//$('.addspec .cputype_A').show();
		//$('.addspec .rackmount_A').show();
	}
}
</script>
</head>

<body onload="cookie_val()">
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Category Module</h1></div>
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
<li ><a href="../newsletter.php">Newsletters</a>
<ul><li><a href="../subscribe.html">Subscription</a></li></ul>
</li>
</ul>
</div>

<div class="clear"></div>

<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Category Module</h2> 
</div>

<div id="content">
<br />
<div class="right">&nbsp; | &nbsp;<a href="pro_type_module.php" />Product Type</a>&nbsp; | &nbsp;<a href="pro_info.php" />Product Info</a>&nbsp; | &nbsp;</div>
<br />
<h3>Category Lists:
</h3>

<div>
<div class="pagination left">
<?php
if(isset($_REQUEST['pt_lang'])!=''){
$pt_lang=trim($_REQUEST['pt_lang']);
}else{
$pt_lang="";
}
?>
<SELECT id="SEL_PTYPE" name="SEL_PTYPE" onChange="MM_o(this)">
<option value="category_module.php?pt_id=">All Types</option>
<?php
$str_type="select ProductTypeID,ProductTypeName from producttypes_las";
$type_result=mysqli_query($link_db,$str_type);
while(list($ProductTypeID,$ProductTypeName)=mysqli_fetch_row($type_result)){
?>
<option value="category_module.php?pt_id=<?=$ProductTypeID;?>&pt_lang=<?=$pt_lang;?>" <?php if($pt_id==$ProductTypeID){ echo "selected"; } ?> ><?=$ProductTypeName;?></option>
<?php
}
?>
</select>&nbsp;&nbsp;

<select id="SEL_LANGS" onChange="MM_LA(this)">
<option selected value="category_module.php?pt_id=&pt_lang=">All</option>
<option value="category_module.php?pt_id=<?=$_REQUEST['pt_id'];?>&pt_lang=EN" <?php if($pt_lang=="EN"){ echo "selected"; }?>>English</option>
<option value="category_module.php?pt_id=<?=$_REQUEST['pt_id'];?>&pt_lang=JP" <?php if($pt_lang=="JP"){ echo "selected"; }?>>JAPAN</option>
<option value="category_module.php?pt_id=<?=$_REQUEST['pt_id'];?>&pt_lang=ZH" <?php if($pt_lang=="ZH"){ echo "selected"; }?>>繁體中文</option>
<option value="category_module.php?pt_id=<?=$_REQUEST['pt_id'];?>&pt_lang=CN" <?php if($pt_lang=="CN"){ echo "selected"; }?>>簡體中文</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
 </div>

<table class="list_table">
  <tr>
    <th >*Category Name</th><th >URL</th><th >*Product Type</th><th>*Language</th><th>*Status</th><th>*Update Date</th><th><div class="button14" style="width:50px;"><a href="#category_module_add" onClick="show_add()">Add</a></div></th>
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
      
	  if($pt_id<>''){
       if($pt_lang<>''){  
		 $str="SELECT `CategoryModuID`, `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `slang`, `Meta_Des`, `Web_Disable`, `upd_d` FROM `category_module_las` where `ProdTypeID`=".$pt_id." and `slang`='".$pt_lang."' ORDER BY `upd_d` desc limit $start_num,$read_num;";
       }else{
         $str="SELECT `CategoryModuID`, `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `slang`, `Meta_Des`, `Web_Disable`, `upd_d` FROM `category_module_las` where `ProdTypeID`=".$pt_id." ORDER BY `upd_d` desc limit $start_num,$read_num;";
       }
      }else{
       if($pt_lang<>''){
         $str="SELECT `CategoryModuID`, `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `slang`, `Meta_Des`, `Web_Disable`, `upd_d` FROM `category_module_las` where `slang`='".$pt_lang."' ORDER BY `upd_d` desc limit $start_num,$read_num;";
       }else{
         $str="SELECT `CategoryModuID`, `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `urls`, `slang`, `Meta_Des`, `Web_Disable`, `upd_d` FROM `category_module_las` ORDER BY `upd_d` desc limit $start_num,$read_num;";
       }
      }

      $result=mysqli_query($link_db, $str);
	  $i=0;
      while(list($CategoryModuID,$CategoryModuName,$ProdTypeID,$CategIntroduction,$urls,$slang,$Meta_Des,$Web_Disable,$upd_d)=mysqli_fetch_row($result))
	  {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td ><?=$CategoryModuName;?></td><td ><a href="<?php echo "/".$slang."/".str_replace(".htm","",$urls);?>/" target="_blank"><?=str_replace(".htm","",$urls);?></a></td>
	<td>
	<?php	
	$str1="select ProductTypeName from producttypes_las where ProductTypeID=".$ProdTypeID;
    $result1=mysqli_query($link_db,$str1);
    list($ProductTypeName)=mysqli_fetch_row($result1);
	echo $ProductTypeName;	
	?></td>
	<td><?=$slang;?></td>
	<td>
	<?php
	if($Web_Disable==1){
	echo "Offline";
	}else if($Web_Disable==0){
	echo "Online";
	}
	?>
	</td><td ><?=$upd_d;?></td><td ><a href="?ca_id=<?=$CategoryModuID;?> #category_module_mod">Edit</a>&nbsp;&nbsp;<a href="?act=del&ca_id=<?=$CategoryModuID;?>&page=<?=$_REQUEST['page'];?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a>&nbsp;&nbsp;<a href="?act=copy&ca_id=<?=$CategoryModuID;?>&page=<?=$_REQUEST['page'];?>">Copy</a></td>
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

<P style="color:#0F0">**設定 Global Top Menu 下 Products => Product Type 所列的 每個 categories name 以及其 Landing page 上的資料。  這裡所設定的 Category 會在 Create product 時，讓其選擇該 product 是於否會列在這個 category landing page 上。<br />
** 設定完成一個 Category, 會自動產生一個頁面,  URL 為設定的 Category Name.html ( Category Name 若有空白,()，則以 "_" 底線代替)</p>

<p >&nbsp;</p><p >&nbsp;</p>
<p class="clear">&nbsp;</p>

<!--Click Edit and add -->							
<div id="category_module_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_categoryM" onsubmit="return Final_Check();">
<h1>Add a Category</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Category Name:  </th>
<td><input id="CA01" name="CA01" type="text" size="40" value="" /><span style="color:#0F0">允許輸入 (), 空白, -, /</span>
</td>
</tr>
<tr>
<th>Product Type:  </th>
<td>
<?php
if(isset($_REQUEST['capt_aid'])!=''){
$capt_aid=intval($_REQUEST['capt_aid']);
}else{
$capt_aid="";
}
?>
<select id="selectlangA" name="selectlangA" onChange="select_langA(this)">
<option value="">Select</option>
<option value="category_module.php?capt_aid=<?=$tpdata[0];?>&tlangA=EN"
<?php
 if(isset($_REQUEST['tlangA'])<>""){
  if($_REQUEST['tlangA']==EN){ echo "selected"; } 
 }
?>>English</option> 
<option value="category_module.php?capt_aid=<?=$tpdata[0];?>&tlangA=ZH"
<?php
if(isset($_REQUEST['tlangA'])<>""){
  if($_REQUEST['tlangA']==ZH){ echo "selected"; } 
}
?>>繁體</option> 
<option value="category_module.php?capt_aid=<?=$tpdata[0];?>&tlangA=CN"
<?php
 if(isset($_REQUEST['tlangA'])<>""){
  if($_REQUEST['tlangA']==CN){ echo "selected"; } 
 }
?>>簡體</option> 
<option value="category_module.php?capt_aid=<?=$tpdata[0];?>&tlangA=JP"
<?php
 if(isset($_REQUEST['tlangA'])<>""){
  if($_REQUEST['tlangA']==JP){ echo "selected"; } 
 }
?>>日文</option> 
</select>
<SELECT id="SEL_APTYPE" name="SEL_APTYPE" onChange="MM_PT(this)">
<option value="category_module.php?capt_aid=">Select</option>
<?php
$tlangA = $_REQUEST['tlangA'];
if($tlangA!=""){
	$str_tp="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las` WHERE slang = '".$tlangA."'";
}else{
	$str_tp="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las` ";
}
$tp_cmd=mysqli_query($link_db,$str_tp);
while($tpdata=mysqli_fetch_row($tp_cmd)){
?>
<option value="category_module.php?capt_aid=<?=$tpdata[0];?>&tlangA=<?=$tlangA?>" <?php if($capt_aid==$tpdata[0]){ echo "selected"; } ?>><?=$tpdata[1];?></option>
<?php
}
?>
</select><input name="SEL_APTYPE_Val" type="hidden" value="<?=$capt_aid;?>">
<span style="color:#0F0">Product Type 下拉選單，列出 module => Product Type 裏設定的 Product Types</span>
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<?php
if(isset($_REQUEST['capt_lang'])!=''){
$capt_lang=trim($_REQUEST['capt_lang']);
}else{
$capt_lang="";
}
?>
<select id="SEL_LANG" name="SEL_LANG">
<option value="EN" <?php if($capt_lang=='EN'){ echo "selected"; }?>>English</option>
<option value="CN" <?php if($capt_lang=='CN'){ echo "selected"; }?>>簡體</option>
<option value="ZH" <?php if($capt_lang=='ZH'){ echo "selected"; }?>>繁體</option>
<option value="JP" <?php if($capt_lang=='JP'){ echo "selected"; }?>>日文</option>
</select>
</td>
</tr>
<tr>
<th>Introduction: </th>
<td><textarea id="Intro" name="Intro" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"></textarea>
<p style="color:#c00">** Alow HTML code</p>
</td>
</tr>
<tr>
<th>Sorting conditions:  </th>
<td>
<?php
if(isset($_REQUEST['capt_lang'])!=''){
$capt_lang=trim($_REQUEST['capt_lang']);
}else{
$capt_lang="";
}

if($capt_lang!=''){
//$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where `PTYPE_Value` like '%".$capt_aid.",%' and `slang`='".$capt_lang."'";
$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where instr(concat(',',`PTYPE_Value`), concat(',','$capt_aid',','))>0 and `slang`='".$capt_lang."'";
}else{
$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where instr(concat(',',`PTYPE_Value`), concat(',','$capt_aid',','))>0";
}
$pinfo_result=mysqli_query($link_db, $str_pinfo);
while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($pinfo_result))      
{
?>
<input name="pro_info_Tp[]" type="checkbox" value="<?=$PI_id;?>"  /> <?=$PI_Name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
}
?>
<p style="color:#0F0">**列出該語言在 Contents  >  Modules  >  Product Info 中該語言，上面所選擇的 Product Type 下，被套用到的所有 "Info Name"。這裏勾選的 Info Name 會在前端網頁上的 Sorting 下拉選單中出現。</p>
</td>
</tr>
<tr class="sockettype_A" style="display:none">
<th>Socket Type:  </th>
<td>
<select id="SEL_SKType" name="SEL_SKType">
<option value="">-- Selected --</option>
<?php
$str_SKType="SELECT `SOCKETID`, `SOCKETNAME`, `STATUS` FROM `c_s_socket` WHERE `STATUS`='1'";
$SKType_cmd=mysqli_query($link_db,$str_SKType);
while($SKType_data=mysqli_fetch_row($SKType_cmd)){
?>
<option value="<?=$SKType_data[0];?>"><?=$SKType_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr class="chipset_A" style="display:none">
<th>Chipset:  </th>
<td>
<?php
$br02="";
$str_Chipsets="SELECT `CHIPSETID`, `CHIPSETNAME`, `STATUS` FROM `c_s_chipset` WHERE `STATUS`='1'";
$Chipsets_cmd=mysqli_query($link_db,$str_Chipsets);
while($Chipsets_data=mysqli_fetch_row($Chipsets_cmd)){
$chi+=1;
  if($chi%3==0){
  $br02="<br />";
  }else{
  $br02="";
  }  
?>
<input name="chipset_Vals_Set[]" type="checkbox" value="<?=$Chipsets_data[0];?>" />&nbsp;<?=$Chipsets_data[1];?>&nbsp;<?=$br02;?>
<?php
}
?>
</td>
</tr>
<tr class="sockets_A" style="display:none">
<th>Sockets:  </th>
<td>
<select id="SEL_Sockets" name="SEL_Sockets">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select>
</td>
</tr>
<tr class="cpu_A" style="display:none">
<th>CPU:  </th>
<td>
<select id="SEL_CPUid" name="SEL_CPUid">
<?php
$str_cpuid="SELECT `CPUID`, `CPUNAME`, `STATUS` FROM `c_s_cpu` where `STATUS`='1'";
$cpuid_cmd=mysqli_query($link_db,$str_cpuid);
while($cpuid_data=mysqli_fetch_row($cpuid_cmd)){
?>
<option value="<?=$cpuid_data[0];?>"><?=$cpuid_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr class="cputype_A" style="display:none">
<th>CPUtype:  </th>
<td>
<select id="SEL_cputype" name="SEL_cputype">
<?php
$str_cputype="SELECT `CPUTYPEID`, `CPUTYPE`, `STATUS` FROM `c_b_cputype` where `STATUS`=1";
$cputype_cmd=mysqli_query($link_db,$str_cputype);
while($cputype_data=mysqli_fetch_row($cputype_cmd)){
?>
<option value="<?=$cputype_data[0];?>"><?=$cputype_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>

<tr class="rackmount_A" style="display:none">
<th>RACKMOUNT:  </th>
<td>
<input name="rackmount_Vals_Set[]" type="checkbox" value="1" />&nbsp;1&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="2" />&nbsp;2&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="3" />&nbsp;3&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="4" />&nbsp;4&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="5" />&nbsp;5&nbsp;
</td>
</tr>
<tr>
<th>Status:</th>
<td>
<select id="stat01" name="stat01">
<option value="0" selected>Online</option>
<option value="1">Offline</option>
</select><span style="color:#0F0">**設定此 Category 是否會出現在 top drop mega menu 上</span>
</td>
</tr>
<tr>
<th>&#65124;Meta description&#65125;:</th>
<td><textarea id="MD01" name="MD01" rows="6" cols="80" style="max-width: 250px; max-height: 250px;"></textarea>
<span style="color:#0F0">**設定此 Category Product List 頁的html Meta description的值 (for SEO)</span>
</td>
</tr>

<tr><td colspan="2">
<input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C1" type="button" value="Cancel" onclick="javascript:self.location='category_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {

if(document.form1.CA01.value == ""){
alert("請輸入 Category Name！");
document.form1.CA01.focus();
return false;
}

if(document.form1.SEL_APTYPE.value == "" || document.form1.SEL_APTYPE.value == "category_module.php?capt_aid="){
alert("請選擇 Product Type！");
document.form1.SEL_APTYPE.focus();
return false;
}

if(document.form1.SEL_LANG.value == "") {
alert ("請選擇 Languages！");
document.form1.SEL_LANG.focus();
return false;
}
/*
if(document.form1.Intro.value == ""){
alert("請輸入 Introduction！");
document.form1.Intro.focus();
return false;
}

if(document.form1.MD01.value == "") {
alert ("請選擇 Meta description！");
document.form1.MD01.focus();
return false;
}
*/
return true;
}
</script>
</div>


<?php
if(isset($_REQUEST['ca_id'])<>""){
$ca_id01=intval($_REQUEST['ca_id']);
$str_m="SELECT `CategoryModuID`, `CategoryModuName`, `ProdTypeID`, `CategIntroduction`, `slang`, `Meta_Des`, `Prod_Info_Sorting`, `Web_Disable` FROM `category_module_las` where `CategoryModuID`=".$ca_id01;
$mcmd=mysqli_query($link_db,$str_m);
$mdata=mysqli_fetch_row($mcmd);
?>
<div id="category_module_mod" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=mod_categoryM" onsubmit="return Final_MCheck();">
<h1>Edit a Category</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Category Name:  </th>
<td><input id="CA01m" name="CA01m" type="text" size="40" value="<?=$mdata[1];?>" /><span style="color:#0F0">允許輸入 (), 空白, -, /</span>
</td>
</tr>
<tr>
<th>Product Type:  </th>
<td>
<select id="selectlang" name="selectlang" onChange="select_lang(this)">
<option value="">Select</option>
<option value="category_module.php?ca_id=<?=$ca_id01;?>&tlang=EN"
<?php
 if(isset($_REQUEST['tlang'])<>""){
  if($_REQUEST['tlang']==EN){ echo "selected"; } 
 }else{
 	if($mdata[4]==EN){ echo "selected"; }
 }
?>>English</option> 
<option value="category_module.php?ca_id=<?=$ca_id01;?>&tlang=ZH"
<?php
if(isset($_REQUEST['tlang'])<>""){
  if($_REQUEST['tlang']==ZH){ echo "selected"; } 
}else{
	if($mdata[4]==ZH){ echo "selected"; }
}
?>>繁體</option> 
<option value="category_module.php?ca_id=<?=$ca_id01;?>&tlang=CN"
<?php
 if(isset($_REQUEST['tlang'])<>""){
  if($_REQUEST['tlang']==CN){ echo "selected"; } 
 }else{
 	if($mdata[4]==CN){ echo "selected"; }
 }
?>>簡體</option> 
<option value="category_module.php?ca_id=<?=$ca_id01;?>&tlang=JP"
<?php
 if(isset($_REQUEST['tlang'])<>""){
  if($_REQUEST['tlang']==JP){ echo "selected"; } 
 }else{
 	if($mdata[4]==JP){ echo "selected"; }
 }
?>>日文</option> 
</select>
<select id="SEL_PTYPEm" name="SEL_PTYPEm" onChange="MM_PTm(this)">
<option value="category_module.php?pt_mid=">Select</option>
<?php
$tlang = $_REQUEST['tlang'];
if($tlang!=""){
	$str_tp="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las` WHERE slang = '".$tlang."'";
}else{
	$str_tp="SELECT `ProductTypeID`, `ProductTypeName` FROM `producttypes_las` WHERE slang = '".$mdata[4]."'";
}
$tp_cmd=mysqli_query($link_db,$str_tp);
while($tpdata=mysqli_fetch_row($tp_cmd)){
 if($mdata[2]==$tpdata[0]){
 $tpdata_id=$tpdata[0];
 }

?>
<option value="category_module.php?ca_id=<?=$ca_id01;?>&tlang=<?=$tlang?>&pt_mid=<?=$tpdata[0];?>" 
<?php
 if(isset($_REQUEST['pt_mid'])<>""){
  if($_REQUEST['pt_mid']==$tpdata[0]){ echo "selected"; } 
 }else{
  if($mdata[2]==$tpdata[0]){ echo "selected"; } 
 }
?> ><?=$tpdata[1];?></option>
<?php
}
?>
</select>
<?php
if(isset($_REQUEST["pt_mid"])<>''){
$SEL_PTYPEm_Val01=$_REQUEST["pt_mid"];
}else{
$SEL_PTYPEm_Val01=$tpdata_id;
}
?>
<input name="SEL_PTYPEm_Val" type="hidden" value="<?=$SEL_PTYPEm_Val01;?>">
<span style="color:#0F0">Product Type 下拉選單，列出 module => Product Type 裏設定的 Product Types</span>
</td>
</tr>
<tr>
<th>Languages:</th>
<td>
<select id="SEL_LANGm" name="SEL_LANGm">
<option value="EN" <?php if($mdata[4]=="EN"){ echo "selected"; } ?>>English</option>
<option value="CN" <?php if($mdata[4]=="CN"){ echo "selected"; } ?>>簡體</option>
<option value="ZH" <?php if($mdata[4]=="ZH"){ echo "selected"; } ?>>繁體</option>
<option value="JP" <?php if($mdata[4]=="JP"){ echo "selected"; } ?>>日文</option>
</select>
</td>
</tr>
<tr>
<th>Introduction: </th>
<td><textarea id="Introm" name="Introm" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"><?=$mdata[3];?></textarea>
<p style="color:#c00">** Alow HTML code</p>
</td>
</tr>
<tr>
<th>Sorting conditions:  </th>
<td>
<?php
//$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where `PTYPE_Value`='".$_REQUEST['capt_aid'].",'";
if(isset($_REQUEST["pt_mid"])<>''){
	if($_REQUEST["tlang"]!=""){
		$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where instr(concat(',',`PTYPE_Value`),concat(',',".$_REQUEST["pt_mid"].",','))>0 and `slang`='".$_REQUEST["tlang"]."'";
	}else{
		$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where instr(concat(',',`PTYPE_Value`),concat(',',".$_REQUEST["pt_mid"].",','))>0 and `slang`='".$mdata[4]."'";
	}
}else{
	if($_REQUEST['tlang']!=""){
		$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where instr(concat(',',`PTYPE_Value`),concat(',',".$tpdata_id.",','))>0 and `slang`='".$_REQUEST["tlang"]."'";
	}else{
		//$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where `PTYPE_Value` like '%".$mdata[6]."%'";
		$str_pinfo="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where instr(concat(',',`PTYPE_Value`),concat(',',".$tpdata_id.",','))>0 and `slang`='".$mdata[4]."'";
	}

}
$pinfo_result=mysqli_query($link_db, $str_pinfo);
while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($pinfo_result))      
{
?>
<input name="pro_info_TpM[]" type="checkbox" value="<?=$PI_id;?>" <?php if(strpos($mdata[6],$PI_id.",")!='' || strpos($mdata[6],$PI_id.",")===0){ echo "checked"; } //if(eregi($mdata[6],$PTYPE_Value)!=''){ echo "checked"; } ?>  /> <?=$PI_Name;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
}
?>

<p style="color:#0F0">**列出該語言在 Contents  >  Modules  >  Product Info 中該語言，上面所選擇的 Product Type 下，被套用到的所有 "Info Name"。這裏勾選的 Info Name 會在前端網頁上的 Sorting 下拉選單中出現。</p>
</td>
</tr>
<tr class="sockettype_A" style="display:none">
<th>Socket Type:  </th>
<td>
<select id="SEL_SKType01m" name="SEL_SKType01m">
<option value="">-- Selected --</option>
<?php
$str_SKType="SELECT `SOCKETID`, `SOCKETNAME`, `STATUS` FROM `c_s_socket` WHERE `STATUS`='1'";
$SKType_cmd=mysqli_query($link_db,$str_SKType);
while($SKType_data=mysqli_fetch_row($SKType_cmd)){
?>
<option value="<?=$SKType_data[0];?>"><?=$SKType_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr class="chipset_A" style="display:none">
<th>Chipset:  </th>
<td>
<?php
$br02="";
$str_Chipsets="SELECT `CHIPSETID`, `CHIPSETNAME`, `STATUS` FROM `c_s_chipset` WHERE `STATUS`='1'";
$Chipsets_cmd=mysqli_query($link_db,$str_Chipsets);
while($Chipsets_data=mysqli_fetch_row($Chipsets_cmd)){
$chi+=1;
  if($chi%3==0){
  $br02="<br />";
  }else{
  $br02="";
  }  
?>
<input name="chipset_Vals_Set[]" type="checkbox" value="<?=$Chipsets_data[0];?>" />&nbsp;<?=$Chipsets_data[1];?>&nbsp;<?=$br02;?>
<?php
}
?>
</td>
</tr>
<tr class="sockets_A" style="display:none">
<th>Sockets:  </th>
<td>
<select id="SEL_Sockets01m" name="SEL_Sockets01m">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select>
</td>
</tr>
<tr class="cpu_A" style="display:none">
<th>CPU:  </th>
<td>
<select id="SEL_CPUid01m" name="SEL_CPUid01m">
<?php
$str_cpuid="SELECT `CPUID`, `CPUNAME`, `STATUS` FROM `c_s_cpu` where `STATUS`='1'";
$cpuid_cmd=mysqli_query($link_db,$str_cpuid);
while($cpuid_data=mysqli_fetch_row($cpuid_cmd)){
?>
<option value="<?=$cpuid_data[0];?>"><?=$cpuid_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr class="cputype_A" style="display:none">
<th>CPUtype:  </th>
<td>
<select id="SEL_cputype01m" name="SEL_cputype01m">
<?php
$str_cputype="SELECT `CPUTYPEID`, `CPUTYPE`, `STATUS` FROM `c_b_cputype` where `STATUS`=1";
$cputype_cmd=mysqli_query($link_db,$str_cputype);
while($cputype_data=mysqli_fetch_row($cputype_cmd)){
?>
<option value="<?=$cputype_data[0];?>"><?=$cputype_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>

<tr class="rackmount_A" style="display:none">
<th>RACKMOUNT:  </th>
<td>
<input name="rackmount_Vals_Set[]" type="checkbox" value="1" />&nbsp;1&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="2" />&nbsp;2&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="3" />&nbsp;3&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="4" />&nbsp;4&nbsp;
<input name="rackmount_Vals_Set[]" type="checkbox" value="5" />&nbsp;5&nbsp;
</td>
</tr>
<tr>
<th>Status:</th>
<td>
<select id="stat01m" name="stat01m">
<option value="0" <?php if($mdata[7]==0){ echo "selected"; } ?>>Online</option>
<option value="1" <?php if($mdata[7]==1){ echo "selected"; } ?>>Offline</option>
<span style="color:#0F0">**設定此 Category 是否會出現在 top drop mega menu 上</span>
</td>
</tr>
<tr>
<th>&#65124;Meta description&#65125;:</th>
<td><textarea id="MD01m" name="MD01m" rows="6" cols="80" style="max-width: 250px; max-height: 250px;"><?=$mdata[5];?></textarea>

<span style="color:#0F0">**設定此 Category Product List 頁的html Meta description的值 (for SEO)</span>
</td>
</tr>

<tr><td colspan="2">
<input name="catg_id" type="hidden" value="<?=$mdata[0];?>"><input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:75px;" name="C2" type="button" value="Cancel" onclick="javascript:locat.href='category_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_MCheck( ) {

if(document.form2.CA01m.value == ""){
alert("請輸入 Category Name！");
document.form2.CA01m.focus();
return false;
}

if(document.form2.SEL_PTYPEm.value == ""){
alert("請選擇 Product Type！");
document.form2.SEL_PTYPEm.focus();
return false;
}

if(document.form2.SEL_LANGm.value == "") {
alert ("請選擇 Languages！");
document.form2.SEL_LANGm.focus();
return false;
}
/*
if(document.form2.MD01m.value == "") {
alert ("請選擇 Meta description！");
document.form2.MD01m.focus();
return false;
}
*/
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
  CKEDITOR.replace( 'Intro', {
    });
</script>
<script>
  CKEDITOR.replace( 'Introm', {
    });
</script>
</body>
</html>
<?php
 if(isset($_REQUEST['ca_id'])<>""){
 echo "<script language='Javascript'>show_edit();</script>\n";
 exit();
 }
 if(isset($_REQUEST['capt_aid'])<>""){
 echo "<script language='Javascript'>show_add();</script>\n";
 exit();
 }
?>