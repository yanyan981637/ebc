<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_set_cookie_params(8*60*60); 
ini_set('session.gc_maxlifetime', '28800');
session_start();
/*
if(empty($_SESSION['user']) || empty($_SESSION['password']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}
*/
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

if($act=='flg_set'){
 if(isset($_REQUEST['Pvla_if_id'])!=''){
 $Pvla_if_id=intval($_REQUEST['Pvla_if_id']);
 }
 if(isset($_REQUEST['pro_if_id'])!=''){
 $pro_if_id=intval($_REQUEST['pro_if_id']);
 }
 $Pvla_if_flag=trim($_REQUEST['Pvla_if_flag']);
 if($Pvla_if_id!=''){
    if($Pvla_if_flag==1){
	$flags=0;
	}else if($Pvla_if_flag==0){
	$flags=1;
	}
	$str_Uset="update `product_infovalue_las` set `PIV_disabled`=".$flags." where `PIV_id`=".$Pvla_if_id;
	$Uset_cmd=mysqli_query($link_db,$str_Uset);
	echo "<script>alert('Update The Data!');self.location='pro_info.php?pro_if_id=".$pro_if_id."&types=edit#pro_info_mod'</script>";
	exit();
 }
}

if($act=='del'){
$pro_if_id=intval($_REQUEST['pro_if_id']);
$str_del="delete from `product_info_las` where `PI_id` =".$pro_if_id;
$del_cmd=mysqli_query($link_db,$str_del);
echo "<script>alert('Delete the data!');self.location='pro_info.php'</script>";
exit();
}

/*if($act=='delVal'){
$str_vdel="delete from `product_infovalue_las` WHERE `PIV_flag`=0 AND `PIV_disabled`=0";
$vdel_cmd=mysqli_query($link_db,$str_vdel);
echo "<script>self.location='pro_info.php'</script>";
exit();
}*/

if($act=="copy"){
$pro_if_id=$_REQUEST['pro_if_id'];
$page01=$_REQUEST['page'];
if($page01!=''){
$page_str="?page=".$page01;
}else{
$page_str="";
}
$str_copy="insert into `product_info_las` (`PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts`) SELECT `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where `PI_id`=".$pro_if_id." limit 1";
//echo $str_copy;
$copy_cmd=mysqli_query($link_db,$str_copy);
echo "<script>alert('Copy the data!');self.location='pro_info.php".$page_str."'</script>";
exit();
}


}else{
$act="";
}

if(isset($_REQUEST['kinds'])!=''){

if(trim($_REQUEST['kinds'])=="add_proinfo"){
	
//$str_dellog01="delete FROM `product_infovalue_las` WHERE `PIV_flag`=0 AND `PIV_disabled`=0";
$dellog01_cmd=mysqli_query($link_db,$str_dellog01);

$str_a1="select PI_id FROM product_info_las order by PI_id desc limit 1";
$check_a1=mysqli_query($link_db,$str_a1);
$Max_MatrixID=mysqli_fetch_row($check_a1);
$MCount=$Max_MatrixID[0]+1;

$INA01=htmlspecialchars($_POST['INA01'], ENT_QUOTES);
$IN_LANG=str_replace("pro_info.php?in_alang=", '', $_POST['IN_LANG']);

$ppts01="";$str_pupd="";$stat01="";

if(isset($_POST['PPTS'])!=''){
  
  foreach($_POST['PPTS'] as $check_ppts) {
  $ppts01=$ppts01.$check_ppts.",";
  }
  
}else{
  $ppts01="";
}

if(isset($_POST['PV_lists'])!=''){
$PV_lists01=trim($_POST['PV_lists']);

//$PV_lists_ar=preg_split(',',$_POST['PV_lists']);
$PV_lists_ar=explode(',',$_POST['PV_lists'],-1);

for($p=0;$p<=count($PV_lists_ar)-1;$p++){
  //echo $PV_lists_ar[$p]."<br />";
  
  $str_pupd="update `product_infovalue_las` set `PI_id`=".$MCount.", `PIV_flag`=1 where `PIV_id`=".$PV_lists_ar[$p];
  $pupd_cmd=mysqli_query($link_db,$str_pupd);
  
}
}

if(isset($_POST['stat01'])!=''){
$stat01=htmlspecialchars(trim($_POST['stat01']), ENT_QUOTES);
}

if(isset($_POST['sshow01'])!=''){
$sshow01=intval($_POST['sshow01']);
}else{
$sshow01=1;
}

$str_insert="insert into `product_info_las` (`PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts`, `PI_SW_VAL`) values (".$MCount.",'".$INA01."','".$IN_LANG."','".$PV_lists01."','".$ppts01."',".$stat01.",".$sshow01.")"; 
$insert_cmd=mysqli_query($link_db,$str_insert);

//Clear_Cookie();
echo "<script>alert('AddNew Product Info!');location.href='pro_info.php'</script>";
exit();
}else if(trim($_REQUEST['kinds'])=="mod_proinfo"){

$PV_str00m=intval($_POST['PV_str00m']);

$INA01m=$_POST['INA01m'];
//$IN_LANGm=str_replace("pro_info.php?in_alang=", '', $_POST['IN_LANGm']);

$IN_LANGm_val=trim($_POST['IN_LANGm_val']);

$pptm01='';
if(isset($_POST['PPTSm'])!=''){
  
  foreach($_POST['PPTSm'] as $check_pptm) {
  $pptm01=$pptm01.$check_pptm.",";
  }
  
}else{
  $pptm01='';
}

if(isset($_POST['stat01m'])!=''){
$stat01m=htmlspecialchars($_POST['stat01m'], ENT_QUOTES);
}else{
$stat01m=1;
}

if(isset($_POST['sshow01m'])!=''){
$sshow01m=intval($_POST['sshow01m']);
}else{
$sshow01m=1;
}

$str_update="update `product_info_las` set `PI_Name`='".$INA01m."', `slang`='".$IN_LANGm_val."', `PTYPE_Value`='".$pptm01."', `Sorts`=".$stat01m.", `PI_SW_VAL`=".$sshow01m." where `PI_id`=".$PV_str00m;
//echo $str_update;
$update_cmd=mysqli_query($link_db,$str_update);

Clear_Cookie();
echo "<script>alert('Update Product Info!');location.href='pro_info.php'</script>";
exit();
}
}

if(isset($_REQUEST['Del_Pval'])!=""){      
  
  if(trim($_REQUEST['Del_Pval'])=="Del"){ 
  $D_id01=intval($_REQUEST['D_id']);
  $in_alang=trim($_REQUEST['in_alang']);
  
  //$str_d01="Delete FROM `product_infovalue_las` where `PIV_flag`=0 and `PIV_id`=".$D_id01;
  $str_d01="Delete FROM `product_infovalue_las` where `PIV_id`=".$D_id01;
  $d01_cmd=mysqli_query($link_db,$str_d01); 
  echo "<script>alert('Del proinfo Value!');location.href='pro_info.php?in_alang=".$in_alang."'</script>";
  exit();
  }
}

if(isset($_REQUEST['Del_Pvalm'])!=""){
  
  if(trim($_REQUEST['Del_Pvalm'])=="Del"){
  $D_id01=intval($_REQUEST['D_id']);
  $pro_if_id01=intval($_REQUEST['pro_if_id']);
  
  $str_d01m="Delete FROM `product_infovalue_las` where `PIV_id`=".$D_id01;
  $d01m_cmd=mysqli_query($link_db,$str_d01m);
  
  $str_up01="update `product_info_las` set `PI_Value`=REPLACE(`PI_Value`, '".$D_id01.",' , '') where `PI_id`=".$pro_if_id01;
  //echo $str_up01;
  $up01_cmd=mysqli_query($link_db,$str_up01);
  
  echo "<script>alert('Del proinfo Value!');location.href='pro_info.php?pro_if_id=".$pro_if_id01."&types=edit#pro_info_mod'</script>";
  exit();
  }
  
}


if(isset($_REQUEST['pt_lang'])<>''){
  $str1="select count(*) from `product_info_las` where slang like '%".$_REQUEST['pt_lang']."%'";  
}else{
  $str1="select count(*) from `product_info_las`";
}  
  
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Product Info</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
	<link rel="stylesheet" type="text/css" href="../../css.css" />
    <script type="text/javascript" src="../../jquery.min.js"></script>
    <script type="text/javascript" src="jquery.cookie.js"></script>
    <script language="JavaScript">
    <!--
	function cookie_val(){
	 if($.cookie("INA01")!=null){
      document.getElementById("INA01").value=$.cookie("INA01");
     }
	 if($.cookie("stat01")!=null){
      document.getElementById("stat01").value=$.cookie("stat01");
     }
	 if($.cookie("PPTS")!=null){
	   var PPTS_cookies="";
	   PPTS_cookies=$.cookie("PPTS");
	   //alert($.cookie("PPTS"));
	   $("input[name='PPTS[]']:checkbox").each(function () {
	   
	   if(PPTS_cookies.match($(this).attr("value"))!=null){ //jquery 正規
	   //if($(this).attr("value").match(PPTS_cookies)!=null){
	   //alert($(this).attr("value").match(PPTS_cookies));
	   $(this).attr("checked",true);
	   }
	   
       })
	   
	 }
	}
	
	$(document).ready(function(){ 
    $('#PPTS').click(function() {
          
		  var PPTS_str='';
	      var PPTS_flag='';
	      $("input[name='PPTS[]']:checkbox").each(function () { 
          if ($(this).attr("checked")) {
	      PPTS_str+=$(this).attr("value")+",";
	      PPTS_flag='Yes';
          }
          })
		  
    });     
    });
	
    function MM_LA(selobj){
    window.open(document.getElementById('SEL_LANG').options[document.getElementById('SEL_LANG').selectedIndex].value,"_self");
    }	
	function MM_LNLA(selobj){
	$.cookie("INA01", $("#INA01").val(), { expires: 1 });
	$.cookie("stat01", $("#stat01").val(), { expires: 1 });
	//$.cookie("PPTS", $("#PPTS").attr("value"), { expires: 1 });
	
	//if($.cookie("PPTS")!=null){
	var PPTS_str='';
	var PPTS_flag='';
	$("input[name='PPTS[]']:checkbox").each(function () { 
    if ($(this).attr("checked")) {
	PPTS_str+=$(this).attr("value")+",";
	PPTS_flag='Yes';
    }
    })
	
	if(PPTS_flag!=''){ $.cookie("PPTS", PPTS_str, { expires: 1 }); }
	//}
	
	window.open(document.getElementById('IN_LANG').options[document.getElementById('IN_LANG').selectedIndex].value,"_self");
	}	
	function MM_MLNLA(selobj){
	window.open(document.getElementById('IN_LANGm').options[document.getElementById('IN_LANGm').selectedIndex].value,"_self");
	}
	
	function show_add(){
	$("#pro_info_add").show();
	$("#pro_info_mod").hide();
	}
	function hide_add(){
	self.location="pro_info.php";
	}
	function show_edit(){
	$("#pro_info_mod").show();
	$("#pro_info_add").hide();
	}
	function hide_edit(){
	self.location="pro_info.php";
	}
	
	function show_AddVal(){
	$("#PValue_ADD01").show();
	}
	function show_ModVal(){
	$("#PValue_MOD01").show();
	}
	function show_IFedit(){
	$("#PValue_MMOD01").show();
	}
	//-->
    </script>
	
<script type="text/javascript">
$(function() {

  $("#PVaBtn").click(function() {  
  var params = $('input').serialize();
  var url = "add_PVals.php";

  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: params,
  success: function(data){
    if(data == "refresh"){	
    window.location.reload(true);
    }
    else{
    $("#PVal_MGT").html(data);
	$("#PVal_error").html('');
    }
  }  
  });  
  });
  
  $("#PVaCel").click(function() { 
    $("#PValue_ADD01").hide();
    $("#PVal_MGT").html('');
    $("#PVal_error").html('');
  });
  
  $("#MPVaBtn").click(function() {  
  var paramsM = $('input').serialize();
  var urlM = "add_PVals_m.php";

  $.ajax({
  type: "post",
  url: urlM,
  dataType: "html",
  data: paramsM,
  success: function(data){
    if(data == "refresh"){	
    window.location.reload(true);
    }
    else{
    $("#MPVal_MGT").html(data);
	$("#MPVal_error").html('');
    }
  }  
  });  
  });
  
  $("#MPVaCel").click(function() { 
    $("#PValue_MOD01").hide();
    $("#MPVal_MGT").html('');
    $("#MPVal_error").html('');
  });
  
  $("#MMPVaBtn").click(function() {  
  var paramsM = $('input').serialize();
  var urlM = "mod_IFPVals_m.php";

  $.ajax({
  type: "post",
  url: urlM,
  dataType: "html",
  data: paramsM,
  success: function(data){
    if(data == "refresh"){	
    window.location.reload(true);
    }
    else{
    $("#MMPVal_MGT").html(data);
	$("#MMPVal_error").html('');
    }
  }  
  });  
  });
  
  $("#MMPVaCel").click(function() { 
    $("#PValue_MMOD01").hide();
    $("#MMPVal_MGT").html('');
    $("#MMPVal_error").html('');
  });
  
  
});
</script>

	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			// Change title type, overlay opening speed and opacity
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedIn : 500,
						opacity : 0.95
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background-color' : '#eee'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

			/*
			 *  Open manually
			 */

			$("#fancybox-manual-a").click(function() {
				$.fancybox.open('1_b.jpg');
			});

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});


		});
	</script>
	

</head>

<body onload="cookie_val()">
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Product Info</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<?php
include("menus.php");
?>

<div class="clear"></div>

<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Product Info</h2> 
</div>

<div id="content">

<br />
<div class="right">&nbsp; | &nbsp; <a href="pro_type_module.php" />Product Type</a>&nbsp; | &nbsp;<a href="category_module.php" />Category Product List</a>&nbsp; | &nbsp;</div>
<br />

<p class="clear">&nbsp;</p>


<h3>Product Info Lists:</h3>
<?php
$pt_lang="";
if(isset($_REQUEST['pt_lang'])!=''){
$pt_lang=trim($_REQUEST['pt_lang']);
}else{
$pt_lang="";
}
?>
<div>
<div class="pagination left">
<select id="SEL_LANG" onChange="MM_LA(this)">
<option selected value="pro_info.php?pt_lang=">All</option>
<option value="pro_info.php?pt_lang=EN" <?php if($pt_lang=="EN"){ echo "selected"; }?>>English</option>
<option value="pro_info.php?pt_lang=JP" <?php if($pt_lang=="JP"){ echo "selected"; }?>>JAPAN</option>
<option value="pro_info.php?pt_lang=ZH" <?php if($pt_lang=="ZH"){ echo "selected"; }?>>繁體中文</option>
<option value="pro_info.php?pt_lang=CN" <?php if($pt_lang=="CN"){ echo "selected"; }?>>簡體中文</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
</div>
</div>

<table class="list_table">
<tr>
<th>Order</th><th>Name</th><th>Language</th><th>Values</th><th>Product Types</th><th><div class="button14" style="width:50px;"><a href="#pro_info_add" onClick="show_add()">Add</a></div></th>
</tr>
<?php
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=$_REQUEST['page'];
      }
      
      if(empty($page))$page="1";
      
      $read_num="20";
      $start_num=$read_num*($page-1);
			
      if(isset($_REQUEST['pt_lang'])<>''){      
        $str="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` where slang ='".$_REQUEST['pt_lang']."' ORDER BY PI_id desc limit $start_num,$read_num;";
      }else{
        $str="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts` FROM `product_info_las` ORDER BY PI_id desc limit $start_num,$read_num;";
      }      
      $result=mysqli_query($link_db, $str);
	  $i=0;
      while(list($PI_id,$PI_Name,$slang,$PI_Value,$PTYPE_Value,$Sorts)=mysqli_fetch_row($result))      
	  {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
?>
<tr>
<td><?=$Sorts;?></td><td><?=$PI_Name?></td><td><?=$slang;?></td>
<td>
<?php
    if($PI_Value!=''){
	$PI_split=explode(",",$PI_Value,-1);
	if(count($PI_split)>0){
	foreach($PI_split as $PI_val){
	  $str01="select PIV_Value from product_infovalue_las where PIV_id=".$PI_val." and PI_id=".$PI_id;
	  $picmd=mysqli_query($link_db,$str01);
	  while($pidata=mysqli_fetch_row($picmd)){
	    echo $pidata[0].", ";
	  }	  
	}
	}
	}
?>
</td>
<td>
<?php
	$PTYV_split=explode(",",$PTYPE_Value,-1);

	if(count($PTYV_split)>0){
	foreach($PTYV_split as $PTYV_val){
	  $str02="select ProductTypeName from producttypes_las where ProductTypeID=".$PTYV_val;
	  $ptyvcmd=mysqli_query($link_db,$str02);
	  while($ptyvdata=mysqli_fetch_row($ptyvcmd)){
	    echo $ptyvdata[0].", ";
	  }
	  
	}
	}
	?>
<?php
$PTYPE_Value;
?>
</td>
<td><a href="pro_info.php?pro_if_id=<?=$PI_id;?>&types=edit#pro_info_mod">Edit</a>&nbsp;&nbsp;<a href="pro_info.php?act=del&pro_if_id=<?=$PI_id;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a>&nbsp;&nbsp;<a href="?act=copy&pro_if_id=<?=$PI_id;?>&page=<?=$_REQUEST['page'];?>">Copy</a></td>
</tr>
<?php
      }
?>
<tr>
<td colspan="6">
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

<p style="color:#0F0">** 此處設定TYAN 網站 Products Type 大類別中，相關的資料欄位及其下面的值。當create 新產品時，要設定該產品的這些相關資料的值。</p>
<p>&nbsp;</p><p>&nbsp;</p>

<!--Click Edit and add -->							
<div id="pro_info_add" class="subsettings" style="display:none">
<?php
$str_Add1="select PI_id FROM product_info_las order by PI_id desc limit 1";
$check_Add1=mysqli_query($link_db,$str_Add1);
$Max_AMatrixID=mysqli_fetch_row($check_Add1);
$MCount01=$Max_AMatrixID[0]+1;

$in_alang="";
if(isset($_REQUEST['in_alang'])!=''){
$in_alang=trim($_REQUEST['in_alang']);
}else{
$in_alang="";
}
?>
<form id="form1" name="form1" method="post" action="?kinds=add_proinfo" onsubmit="return Final_Check();">
<h1>Add an Info</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add();"> [close] </a></div><!--end of close-->
<table class="addspec">

<tr>
<th>Info Name:  </th>
<td><input id="INA01" name="INA01" type="text" size="40" value="" />&nbsp;&nbsp;
<select id="IN_LANG" name="IN_LANG"  onChange="MM_LNLA(this)">
<option value="pro_info.php?in_alang=">All</option>
<option value="pro_info.php?in_alang=EN" <?php if($in_alang=="EN"){ echo "selected"; }?>>English</option>
<option value="pro_info.php?in_alang=JP" <?php if($in_alang=="JP"){ echo "selected"; }?>>JAPAN</option>
<option value="pro_info.php?in_alang=ZH" <?php if($in_alang=="ZH"){ echo "selected"; }?>>繁體中文</option>
<option value="pro_info.php?in_alang=CN" <?php if($in_alang=="CN"){ echo "selected"; }?>>簡體中文</option>
</select>
</td>
</tr>
<tr>
<th>Product Types:</th>
<td>
<div style="color:#0F0">依據上面選擇的language，列出在 Contents => Module => (Product) Product Type 中該與系所建立的所有type。這裡被勾選的type 要在 create product 時，顯示出來這個Info 設定該Product的 value。</div>
<?php
if(isset($_REQUEST['in_alang'])!=''){
$p=0;
$str_PMTY="select ProductTypeID,ProductTypeName from producttypes_las where slang='".trim($_REQUEST['in_alang'])."'";
$PMTY_cmd=mysqli_query($link_db,$str_PMTY);
while($PMTY_Data=mysqli_fetch_row($PMTY_cmd)){
$p+=1;
?>
<input name="PPTS[]" type="checkbox" value="<?=$PMTY_Data[0];?>"  /> <?=$PMTY_Data[1];?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php
}
}
?>
</td>
</tr>

<tr>
<th>Value: </th>
<td>

<table class="list_table" style="width:500px">

  <tr>
    <th>ID</th><th >Value</th><th><div class="button14" style="width:50px;" onClick="show_AddVal();">Add</div></th>
  </tr>
<!--add a Value-->
  <tr>
    <td colspan="3">
	<DIV id="PValue_ADD01" style="display:none"><input name="PV_str01" type="text" size="5" value=""  /> <input name="PV_str02" type="text" size="30" value=""  /> <input id="PVaBtn" type="button" value="Done" /><input id="PVaCel" type="button" value="Cancel" /><DIV id="PVal_MGT"></DIV><DIV id="PVal_error"></DIV></div>
	</td>
  </tr>
<!--end add a Value-->
  <?php
   $Value_array="";
   $str_Vlist="SELECT `PIV_id`, `PIV_Value`, `PIV_Sort` FROM `product_infovalue_las` where `PIV_flag`=0 and `PIV_disabled`=0";
   $Vlist_cmd=mysqli_query($link_db,$str_Vlist);
   
   while($Vlist_Data=mysqli_fetch_row($Vlist_cmd)){
   $Value_array.=$Vlist_Data[0].",";
  ?>
  <tr>
    <td ><?=$Vlist_Data[2];?></td><td ><?=$Vlist_Data[1];?></td><td >&nbsp;&nbsp;<a href="?Del_Pval=Del&D_id=<?=$Vlist_Data[0]?>&in_alang=<?=$_REQUEST['in_alang']?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
  </tr>
  <?php
  }
  ?>
  
</table>
 <P style="color:#0F0">
 - ID：數字愈大愈前面 。決定出現在首頁左側 Filter 的 Info name 的 下的 Value 順序。
 </p>

</td>
</tr>
<tr>
<th>Order: </th>
<td>
<input id="stat01" name="stat01" type="text" size="5" value="<?=$MCount01;?>"  />
 <P style="color:#0F0">
 - 數字：數字愈大愈前面 。決定出現在首頁左側 Filter 的 Info name 的條件順序。
 </p>
</td>
</tr>
<tr>
<th>是否顯示: </th>
<td>
<select id="sshow01" name="sshow01">
<option value="1">ON</option>
<option value="0">OFF</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<input name="PV_lists" type="hidden" value="<?=$Value_array;?>" ><input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:60px;" name="C01" type="button" value="Cancel" onclick="javascript:location.href='pro_info.php?act=delVal'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_Check( ) {

if(document.form1.INA01.value == ""){
alert("請輸入 Info Name！");
document.form1.INA01.focus();
return false;
}

if(document.form1.IN_LANG.value == "") {
alert ("請選擇 Languages！");
document.form1.IN_LANG.focus();
return false;
}

if(document.form1.PPTS.value == "") {
alert ("請選擇 Product Types！");
document.form1.PPTS.focus();
return false;
}

if(document.form1.stat01.value == "") {
alert ("請輸入 Order！");
document.form1.stat01.focus();
return false;
}

return true;
}
</script>
</div>

<?php
if(isset($_REQUEST['pro_if_id'])<>''){

$pro_if_id01=intval($_REQUEST['pro_if_id']);
$str_m="SELECT `PI_id`, `PI_Name`, `slang`, `PI_Value`, `PTYPE_Value`, `Sorts`, `PI_SW_VAL` FROM `product_info_las` where `PI_id`=".$pro_if_id01;
$mcmd=mysqli_query($link_db,$str_m);
$mdata=mysqli_fetch_row($mcmd);

if(isset($_REQUEST['in_alang'])<>''){
$in_alang001=trim($_REQUEST['in_alang']);
}else{
$in_alang001=$mdata[2];
}
?>
<div id="pro_info_mod" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=mod_proinfo" onsubmit="return MFinal_Check();">
<h1>Edit an Info</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_edit();"> [close] </a></div><!--end of close-->
<table class="addspec">

<tr>
<th>Info Name:  </th>
<td><input id="INA01m" name="INA01m" type="text" size="40" value="<?=$mdata[1]?>" />&nbsp;&nbsp;
<select id="IN_LANGm" name="IN_LANGm"  onChange="MM_MLNLA(this)">
<option value="pro_info.php?in_alang=&pro_if_id=<?=$pro_if_id01?>">All</option>
<option value="pro_info.php?in_alang=EN&pro_if_id=<?=$pro_if_id01?>" 
<?php 
 if(isset($_REQUEST['in_alang'])=="EN"){
   echo "selected";
 }else{
   if($mdata[2]=="EN"){ echo "selected"; }
 }
?>>English</option>
<option value="pro_info.php?in_alang=JP&pro_if_id=<?=$pro_if_id01?>" 
<?php
 if(isset($_REQUEST['in_alang'])=="JP"){
   echo "selected";
 }else{
   if($mdata[2]=="JP"){ echo "selected"; }
 }
?>>JAPAN</option>
<option value="pro_info.php?in_alang=ZH&pro_if_id=<?=$pro_if_id01?>" 
<?php
 if(isset($_REQUEST['in_alang'])=="ZH"){
   echo "selected";
 }else{
   if($mdata[2]=="ZH"){ echo "selected"; }
 }
?>>繁體中文</option>
<option value="pro_info.php?in_alang=CN&pro_if_id=<?=$pro_if_id01?>" 
<?php
 if(isset($_REQUEST['in_alang'])=="CN"){
   echo "selected";
 }else{
   if($mdata[2]=="CN"){ echo "selected"; }
 }
?>>簡體中文</option>
</select><input id="IN_LANGm_val" name="IN_LANGm_val" type="hidden" value="<?=$in_alang001;?>">
</td>
</tr>
<tr>
<th>Product Types:</th>
<td>
<div style="color:#0F0">依據上面選擇的language，列出在 Contents => Module => (Product) Product Type 中該與系所建立的所有type。這裡被勾選的type 要在 create product 時，顯示出來這個Info 設定該Product的 value。</div>
<?php
if($mdata[2]<>''){

if(isset($_REQUEST['in_alang'])<>""){
$str_PMTYm="select ProductTypeID,ProductTypeName from producttypes_las where slang='".trim($_REQUEST['in_alang'])."'";
}else{
$str_PMTYm="select ProductTypeID,ProductTypeName from producttypes_las where slang='".$mdata[2]."'";
}
$PMTYm_cmd=mysqli_query($link_db,$str_PMTYm);
$p=0;
while($PMTYm_Data=mysqli_fetch_row($PMTYm_cmd)){
$p+=1;
?>
<input name="PPTSm[]" type="checkbox" value="<?=$PMTYm_Data[0];?>" <?php if(preg_match("/\b".$PMTYm_Data[0].",/i",$mdata[4])){ echo "checked"; } ?> /> <?=$PMTYm_Data[1];?>&nbsp;&nbsp;&nbsp;&nbsp;
<?php
}
}
?>
</td>
</tr>

<tr>
<th>Value: </th>
<td>

<table class="list_table" style="width:500px">

  <tr>
    <th >ID</th><th >Value</th><th><div class="button14" style="width:50px;" onClick="show_ModVal()">Add</div></th>
  </tr>
<!--add a Value-->
  <tr>
    <td colspan="3">
	<DIV id="PValue_MOD01" style="display:none"><input name="PV_str00m" type="hidden" value="<?=$mdata[0];?>"><input name="PV_str01m" type="text" size="5" value=""  /> <input name="PV_str02m" type="text" size="30" value=""  /> <input id="MPVaBtn" type="button" value="Done" /><input id="MPVaCel" type="button" value="Cancel" /><DIV id="MPVal_MGT"></DIV><DIV id="MPVal_error"></DIV></div>
	<DIV id="PValue_MMOD01" style="display:none">
	<?php
	$str_IFpval="SELECT `PIV_id`, `PI_id`, `PIV_Value`, `PIV_Sort` FROM `product_infovalue_las` where `PIV_id`=".$_REQUEST['Pvla_if_id'];
	$IFpval_result=mysqli_query($link_db,$str_IFpval);
	$IFpval_data=mysqli_fetch_row($IFpval_result);
	?>
	<input name="IFPV_str00mm" type="hidden" value="<?=$_REQUEST['Pvla_if_id'];?>"><input name="PV_str00mm" type="hidden" value="<?=$mdata[0];?>"><input name="PV_str01mm" type="text" size="5" value="<?=$IFpval_data[3];?>"  /> <input name="PV_str02mm" type="text" size="30" value="<?=$IFpval_data[2];?>"  /> <input id="MMPVaBtn" type="button" value="Done" /><input id="MMPVaCel" type="button" value="Cancel" /><DIV id="MMPVal_MGT"></DIV><DIV id="MMPVal_error"></DIV>
	</div>
	</td>
  </tr>
<!--end add a Value-->
  <?php
   if($mdata[3]!=''){
   $PI_Vlistm_ar=explode(',',$mdata[3],-1);
   $Valuem_array="";
   for($s=0;$s<count($PI_Vlistm_ar);$s++){   
   
   $str_Vlistm="SELECT `PIV_id`, `PIV_Value`, `PIV_Sort`, `PIV_disabled` FROM `product_infovalue_las` where `PIV_id`=".$PI_Vlistm_ar[$s]." and `PI_id`=".$mdata[0]." order by `PIV_Sort` desc";
   $Vlistm_cmd=mysqli_query($link_db,$str_Vlistm);
   
   while($Vlistm_Data=mysqli_fetch_row($Vlistm_cmd)){
   $Valuem_array.=$Vlistm_Data[0].",";
   if($Vlistm_Data[3]==0){
   $Vlistm_vals="(<b>ON</b>)";
   }else{
   $Vlistm_vals="(<b>OFF</b>)";
   }
   $Valuem_flg="?act=flg_set&Pvla_if_id=".$Vlistm_Data[0]."&pro_if_id=".$mdata[0]."&Pvla_if_flag=".$Vlistm_Data[3];
  ?>
  <tr>
    <td ><?=$Vlistm_vals?>&nbsp;&nbsp;<a href="<?=$Valuem_flg?>"><?=$Vlistm_Data[2];?></a></td><td ><?=$Vlistm_Data[1];?></td><td width="250">&nbsp;&nbsp;<a href="?Del_Pvalm=Del&D_id=<?=$Vlistm_Data[0];?>&pro_if_id=<?=$mdata[0];?>">Del</a>&nbsp;&nbsp;<a href="?Pvla_if_id=<?=$Vlistm_Data[0];?>&pro_if_id=<?=$mdata[0];?>#pro_info_mod">Edit</a></td>
  </tr>
  <?php
   }
   }
   }
  ?>
</table>
 <P style="color:#0F0">
 - ID：數字愈大愈前面 。決定出現在首頁左側 Filter 的 Info name 的 下的 Value 順序。
 </p>

</td>
</tr>
<tr>
<th>Order: </th>
<td>
<input name="stat01m" type="text" size="5" value="<?=$mdata[5];?>" />
 <P style="color:#0F0">
 - 數字：數字愈大愈前面 。決定出現在首頁左側 Filter 的 Info name 的條件順序。
 </p>
</td>
</tr>
<tr>
<th>是否顯示: </th>
<td>
<select id="sshow01m" name="sshow01m">
<option value="1" <?php if($mdata[6]==1){ echo "selected"; }?>>ON</option>
<option value="0" <?php if($mdata[6]==0){ echo "selected"; }?>>OFF</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<input class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input class="button14" style="width:60px;" name="C01M" type="button" value="Cancel" onclick="javascript:location.href='pro_info.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<script language="JavaScript">
function Final_MCheck( ) {

if(document.form2.INA01m.value == ""){
alert("請輸入 Info Name！");
document.form2.INA01m.focus();
return false;
}

if(document.form2.IN_LANGm.value == "") {
alert ("請選擇 Languages！");
document.form2.IN_LANGm.focus();
return false;
}

if(document.form2.PPTSm.value == "") {
alert ("請選擇 Product Types！");
document.form2.PPTSm.focus();
return false;
}

if(document.form2.stat01m.value == "") {
alert ("請輸入 Order！");
document.form2.stat01m.focus();
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

</body>
</html>
<?php
 if(isset($_REQUEST['in_alang'])<>""){
 echo "<script>show_add();</script>\n";
 }
 if(isset($_REQUEST['pro_if_id'])<>""){
 echo "<script>show_edit();</script>\n";
 }
 if(isset($_REQUEST['Pvla_if_id'])<>""){
 echo "<script>show_IFedit();</script>";
 }
?>