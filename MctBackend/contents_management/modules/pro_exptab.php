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

if(isset($_REQUEST['act'])!=''){
  if($_REQUEST['act']=='del'){
  $d_id01=intval($_REQUEST['d_id']);
  if($d_id01!=''){
  $str_del="delete from `spexptabs_list` where `ID`=".$d_id01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete The Data!');self.location='pro_exptab.php'</script>";
  exit();
  }
  }
}

if(isset($_REQUEST['kinds'])!=""){
if(trim($_REQUEST['kinds'])=="edit_pexp"){
if(isset($_REQUEST['m_id'])!=""){
$m_id01=intval($_POST['m_id']);
}
if(isset($_POST['dscname01'])!=''){
$dscname01=trim($_POST['dscname01']);
}else{
$dscname01="";
}
if(isset($_POST['name01'])!=""){
$name01=trim($_POST['name01']);
}else{
$name01="";
}
if(isset($_POST['descM'])!=""){
//$descM=htmlspecialchars($_POST['descM'], ENT_QUOTES);
$descM=trim($_POST['descM']);
//$descM=preg_replace('/"/i', '', $descM);
}else{
$descM="";
}
if(isset($_POST['forM'])!=""){
$forM=trim($_POST['forM']);
}else{
$forM="";
}
if(isset($_POST['relProd_valM'])!=""){
$relProd_val=trim($_POST['relProd_valM']);
}else{
$relProd_val="";
}
if(isset($_POST['url01M'])!=''){
$url01M=trim($_POST['url01M']);
}else{
$url01M="";
}
if(isset($_POST['status'])!=""){
$status01=trim($_POST['status']);
}else{
$status01=1;
}
if(isset($_POST['langM'])!=""){
$langM=trim($_POST['langM']);
}else{
$langM="en-US";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($url01M!=''){
$str_upd="UPDATE `spexptabs_list` SET `DESNAME`='".$dscname01."',`NAME`='".$name01."',`DESCS`='".$descM."',`LANG`='".$langM."',`MODEL`='".$relProd_val."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='".$now."',`STATUS`='".$status01."',`RETURN_URL`=".$forM.",`URL`='".$url01M."' WHERE `ID`=".$m_id01;
}else{
$str_upd="UPDATE `spexptabs_list` SET `DESNAME`='".$dscname01."',`NAME`='".$name01."',`DESCS`='".$descM."',`LANG`='".$langM."',`MODEL`='".$relProd_val."',`UPDATE_USER`='webmaster',`UPDATE_DATE`='".$now."',`STATUS`='".$status01."',`RETURN_URL`=".$forM." WHERE `ID`=".$m_id01;
}
$upd_cmd=mysqli_query($link_db,$str_upd);
echo "<script>alert('Update The Data!');location.href='pro_exptab.php'</script>";
exit();
}

if(trim($_REQUEST['kinds'])=="add_pexp"){
if(isset($_POST['dscname01A'])!=''){
$dscname01A=trim($_POST['dscname01A']);
}else{
$dscname01A="";
}
if(isset($_POST['name01A'])!=''){
$name01A=trim($_POST['name01A']);
}else{
$name01A="";
}
if(isset($_POST['descA'])!=''){
//$descA=htmlspecialchars($_POST['descA'], ENT_QUOTES);
$descA=trim(str_replace("'","&#39;",$_POST['descA']));
}else{
$descA="";
}
if(isset($_POST['forA'])!=""){
$forA=trim($_POST['forA']);
}else{
$forA="";
}
if(isset($_POST['relProd_val'])!=''){
$relProd_val=trim($_POST['relProd_val']);
}else{
$relProd_val="";
}
if(isset($_POST['url01A'])!=''){
$url01A=trim($_POST['url01A']);
}else{
$url01A="";
}
if(isset($_POST['statusA'])!=''){
$statusA01=trim($_POST['statusA']);
}else{
$statusA01=1;
}
if(isset($_POST['langA'])!=""){
$langA=trim($_POST['langA']);
}else{
$langA="en-US";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

$str_MULvalues="select `ID` FROM `spexptabs_list` order by `ID` desc limit 1";
$check_MULvalues=mysqli_query($link_db,$str_MULvalues);
$Max_CValID=mysqli_fetch_row($check_MULvalues);
$MCount=$Max_CValID[0]+1;
	
if($descA!=''){
$str_inst="INSERT INTO `spexptabs_list`(`ID`, `DESNAME`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS`, `RETURN_URL`, `URL`, `UPDATE_USER`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dscname01A."','".$name01A."','".$descA."','".$langA."','".$relProd_val."','".$statusA01."',".$forA.",'".$url01A."','webmaster','".$now."')";
}else{
$str_inst="INSERT INTO `spexptabs_list`(`ID`, `DESNAME`, `NAME`, `LANG`, `MODEL`, `STATUS`, `RETURN_URL`, `URL`, `UPDATE_USER`, `UPDATE_DATE`) VALUES (".$MCount.",'".$dscname01A."','".$name01A."','".$langA."','".$relProd_val."','".$statusA01."',".$forA.",'".$url01A."','webmaster','".$now."')";
}
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script>alert('AddNew The Data!');location.href='pro_exptab.php'</script>";
exit();
}
}
$slang="";
if(isset($_REQUEST['s_search'])<>'' && trim($_REQUEST['s_search'])!=""){
  $s_search=trim($_REQUEST['s_search']);
  //$s_search=eregi_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
    if(isset($_REQUEST['slang'])!='' && trim($_REQUEST['slang'])!=""){
	$slang=trim($_REQUEST['slang']);
	$str1="select count(ID) from `spexptabs_list` where (NAME like '%".$s_search."%' or `DESCS` like '%".$s_search."%') and `LANG`='".$slang."'";
	}else{
	$str1="select count(ID) from `spexptabs_list` where NAME like '%".$s_search."%' or `DESCS` like '%".$s_search."%'";
	}
  }else{
	if(isset($_REQUEST['slang'])!='' && trim($_REQUEST['slang'])!=""){		  
    $slang=trim($_REQUEST['slang']);
	$str1="select count(ID) from `spexptabs_list` where `LANG`='".$slang."'";
	}else{
	$str1="select count(ID) from `spexptabs_list`";
	}
  }
  $list1 =mysqli_query($link_db,$str1);
  list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Product DEscription</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />
	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
	
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
		
		$("a#dw_edit").click(function() {
         alert($(this).next('.uid').val());
        });

	</script>
	<script language="JavaScript">
	function MM_SL(selObj){
	   window.open(document.getElementById('SEL_SLang').options[document.getElementById('SEL_SLang').selectedIndex].value,"_self");
	}
	function MM_o(selObj){
       window.open(document.getElementById('pdesc_page').options[document.getElementById('pdesc_page').selectedIndex].value,"_self");
    }
	
	function search_value(){
	var slang;
    //self.location = "?s_search=" + document.form3.sear_txt.value;
    //self.location = slType + "&s_search=" + document.getElementById('sear_txt').value;
	slang=document.getElementById('SEL_SLang').value;
	self.location = slang + "&s_search=" + document.getElementById('sear_txt').value;
	return false;
    }
	
	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){
     //alert(keyCodeEntered);
       //if(confirm('Are you sure you want to search this word?')) {
	   document.location.href = "?s_search=" + document.getElementById('sear_txt').value;	   
	   //}   
     }
    }
	
	function show_add(){
	  $("#pexp_add").show();
	  $("#pexp_edit").hide();
	}
	function hide_add(){
	  self.location='pro_exptab.php';
	}
	function show_edit(){
	  $("#pexp_add").hide();
	  $("#pexp_edit").show();
	}
	function hide_edit(){
	  self.location='pro_exptab.php';
	}
	</script>
</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Expansion tabs</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("menus.php");
?>
<div class="clear"></div>
<div id="Search" >
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Expansion tabs</h2> 
</div>
<div id="content">
<br />
<h3>Expansion tabs:
</h3>
<div class="pagination left">
<p>
<form id="form3" name="form3" method="post" action="pro_exptab.php" onsubmit="return false;">
<select id="SEL_SLang" name="SEL_SLang" onChange="MM_SL(this)">
<option value="pro_exptab.php?slang=">All</option>
<option value="pro_exptab.php?slang=en-US" <?php if($slang=='en-US'){ echo "selected";} ?>>English</option>
<option value="pro_exptab.php?slang=zh-CN" <?php if($slang=='zh-CN'){ echo "selected";} ?>>簡體</option>
<option value="pro_exptab.php?slang=zh-TW" <?php if($slang=='zh-TW'){ echo "selected";} ?>>繁體</option>
<option value="pro_exptab.php?slang=ja-JP" <?php if($slang=='ja-JP'){ echo "selected";} ?>>日文</option>
</select> <input id="sear_txt" name="sear_txt" type="text" size="30" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" /></form>  
<span style="color:#0F0">**Key word search: Doc NAME & Products欄位 </span> 
</p>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>

<table class="list_table">
  <tr>
    <th>Description</th><th>Label Name</th><th>Products</th><th>*Status</th><th>Language</th><th><div class="button14" style="width:50px;"><a href="#pexp_add" STYLE="text-decoration:none" onClick="show_add();">Add</a></div></th>
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
      
      if(isset($_REQUEST['s_search'])<>'' && trim($_REQUEST['s_search'])!=""){
	  //$s_search=eregi_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
	    $s_search=trim($_REQUEST['s_search']);
	    if(isset($_REQUEST['slang'])!='' && trim($_REQUEST['slang'])!=""){
		$slang=trim($_REQUEST['slang']);
		$str="SELECT `ID`, `DESNAME`, `NAME`, `LANG`, `MODEL`, `STATUS` FROM `spexptabs_list` where (NAME like '%".$s_search."%' or `DESCS` like '%".$s_search."%') and `LANG`='".$slang."' ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
		}else{
		$str="SELECT `ID`, `DESNAME`, `NAME`, `LANG`, `MODEL`, `STATUS` FROM `spexptabs_list` where NAME like '%".$s_search."%' or `DESCS` like '%".$s_search."%' ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
	    }
	  }else{
		if(isset($_REQUEST['slang'])!='' && trim($_REQUEST['slang'])!=""){
		$slang=trim($_REQUEST['slang']);
		$str="SELECT `ID`, `DESNAME`, `NAME`, `LANG`, `MODEL`, `STATUS` FROM `spexptabs_list` where `LANG`='".$slang."' ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
		}else{
	    $str="SELECT `ID`, `DESNAME`, `NAME`, `LANG`, `MODEL`, `STATUS` FROM `spexptabs_list` ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
	    }
	  }
	  $result=mysqli_query($link_db,$str);
	  $i=0;
      while(list($ID,$DESNAME,$NAME,$LANG,$MODEL,$STATUS)=mysqli_fetch_row($result)){
      $i=$i+1;
      //putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td><?=$DESNAME;?></td><td><?=$NAME;?></td><td><?=$MODEL;?></td><td><?=$LANG;?></td><td><?php if($STATUS==1){ echo "Online"; }else if($STATUS==0){ echo "Offline"; } ?></td><td ><a id="dw_edit" href="?mid=<?=$ID;?> #pexp_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
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

<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="pdesc_page" name="pdesc_page" onChange="MM_o(this)">
<?php
for($j=1;$j<=$total;$j++){
?>
<option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
<?php
}
?>
</select>&nbsp;&nbsp;
<?php echo $pagenav; ?>
</div>

<p style="color:#0F0">- click "Del" 要popup a confirmation window to proceed<br />- List順序:新至舊</p>
<p >&nbsp;</p><p >&nbsp;</p>
<p class="clear">&nbsp;</p>
<!--Click Edit and add -->
<div id="pexp_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_pexp" onsubmit="return Final_Check();">							
<h1>Add a Expansion tabs</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hide_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Description:</th>
<td><input type="text" name="dscname01A" value="" /></td>
</tr>
<tr>
<th>Name:</th>
<td><input type="text" name="name01A" value="" /></td>
</tr>
<tr>
<th>Products:</th>
<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_dcmould_mo.php" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
 <p><span id="relProd"></span></p></td>
</tr>
<tr>
<th>Format:</th>
<td>
<select id="forA" name="forA">
<option value="0">本頁顯示</option>
<option value="1">開新視窗</option>
</select>&nbsp;&nbsp;<input type="text" name="url01A" value="" />
</td>
</tr>	
<tr>
<th>Contents:</th>
<td>
<textarea id="deseA" name="descA" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"></textarea>
</td>
</tr>
<tr>
<th>Status:</th>
<td><select id="statusA" name="statusA"><option value="1" selected>Online</option><option value="0">Offline</option></select>
</td>
</tr>
<tr><th>Language:</th>
<td>
<select id="langA" name="langA">
<option value="en-US">English</option>
<option value="zh-CN">簡中</option>
<option value="zh-TW">繁中</option>
<option value="ja-JP">日本語</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<input name="B2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="C2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:location.href='doc_mgt.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check(){
	if(document.form1.dscname01A.value == ""){
	alert("Required input a Description！");
	document.form1.dscname01A.focus();
	return false;
	}
	if(document.form1.name01A.value == ""){
	alert("Required input a Name！");
	document.form1.name01A.focus();
	return false;
	}
	return true;
}
</script>
</div>
<p class="clear">&nbsp;</p>
</div>
<?php
if(isset($_REQUEST['mid'])!=''){
  $mid=intval($_REQUEST['mid']);
  $str_m="SELECT `ID`, `DESNAME`, `NAME`, `DESCS`, `LANG`, `MODEL`, `STATUS`, `RETURN_URL`, `URL` FROM `spexptabs_list` where `ID`=".$mid;
  $m_result=mysqli_query($link_db,$str_m);
  $m_data=mysqli_fetch_row($m_result);
  $id01=$m_data[0];
  $dsname01=$m_data[1];
  $name01=$m_data[2];
  $descs01=$m_data[3];
  $lang01=$m_data[4];
  $model01=$m_data[5];  
  $status01=$m_data[6];
  $rurl01=intval($m_data[7]);
  $url01=trim($m_data[8]);
?>
<div id="pexp_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=edit_pexp" onsubmit="return Final_MCheck();">
<input type="hidden" name="m_id" value="<?=$id01;?>">
<h1>Edit a Expansion tabs</h1>
<div class="right"><a href="#" onclick="hide_edit()"> [close] </a></div>
<table class="addspec">
<tr>
<th>Description:</th>
<td><input type="text" name="dscname01" value="<?=$dsname01;?>" /></td>
</tr>
<tr>
<th>Name:</th>
<td><input type="text" name="name01" value="<?=$name01;?>" /></td>
</tr>
<tr>
<th>Products:</th>
<td><div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_exptab_mo.php?cid=<?=$id01;?>" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$model01;?></textarea>
 <p><span id="relProd"></span></p></td>
</tr>
<tr>
<th>Format:</th>
<td>
<select id="forM" name="forM">
<option value="0" <?php if($rurl01==0){ echo "selected"; }?>>本頁顯示</option>
<option value="1" <?php if($rurl01==1){ echo "selected"; }?>>開新視窗</option>
</select>&nbsp;&nbsp;<input type="text" name="url01M" value="<?=$url01;?>" />
</td>
</tr>
<tr>
<th>Contents:</th>
<td>
<textarea id="descM" name="descM" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"><?=$descs01;?></textarea>
</td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status" name="status"><option value="1" <?php if($status01=='1'){ echo "selected"; } ?>>Online</option><option value="0" <?php if($status01=='0'){ echo "selected"; } ?>>Offline</option></select>
</td>
</tr>
<tr><th>Language:</th>
<td>
<select id="langM" name="langM">
<option value="en-US" <?php if($lang01=="en-US"){ echo "selected"; }?>>English</option>
<option value="zh-CN" <?php if($lang01=="zh-CN"){ echo "selected"; }?>>簡中</option>
<option value="zh-TW" <?php if($lang01=="zh-TW"){ echo "selected"; }?>>繁中</option>
<option value="ja-JP" <?php if($lang01=="ja-JP"){ echo "selected"; }?>>日本語</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<input name="B2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="C2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:location.href='pro_exptab.php'" />
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check(){
	if(document.form2.dscname01.value == ""){
	alwert("Required input a Description！");
	document.form2.dscname01.focus();
	return false;
	}
	if(document.form2.name01.value == ""){
	alert("Required input a Name！");
	document.form2.name01.focus();
	return false;
	}
	return true;
}
</script>
</div>
<?php
}
?>
<div id="footer">	Copyright &copy; 2016 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'descA', {
    });
</script>
<script>
  CKEDITOR.replace( 'descM', {
    });
</script>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
echo "<script language='JavaScript'>show_edit();</script>";
exit();
}
?>