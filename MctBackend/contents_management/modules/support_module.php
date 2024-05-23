<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

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

if(isset($_REQUEST['act'])=='del'){
  
  if(isset($_REQUEST['d_id'])!=''){
    $d_id01=intval($_REQUEST['d_id']);
	$str_del="delete from `sp_list` where `ID`=".$d_id01;
	$del_cmd=mysqli_query($link_db,$str_del);
    echo "<script>alert('Delete a Data!');self.location='support_module.php'</script>";
	exit();
  }
  
}

if(isset($_REQUEST['kinds'])!=""){
if(trim($_REQUEST['kinds'])=="add_suplist"){

$str_desc="select `ID` FROM `sp_list` order by `ID` desc limit 1";
$desc_cmd=mysqli_query($link_db,$str_desc);
$NCount=mysqli_fetch_row($desc_cmd);
$MCount=$NCount[0]+1;
  
  $lsn01A=htmlspecialchars(trim($_POST['lsn01A']), ENT_QUOTES);
  $lbn01A=htmlspecialchars(trim($_POST['lbn01A']), ENT_QUOTES);
  if(isset($_POST['ul01A'])!=''){
  $ul01A=trim($_POST['ul01A']);
  }
  if(isset($_POST['relProd_val'])!=''){
  $relProd_val=trim($_POST['relProd_val']);
  }
  if(isset($_POST['status01A'])!=''){
  $status01A=trim($_POST['status01A']);
  }
  if(isset($_POST['descA'])!=''){
	//$descA=htmlspecialchars($_POST['descA'], ENT_QUOTES);
  	//$descA=trim(str_replace("'","&#39;",$_POST['descA']));
  	$descA=$_POST['descA'];
  }else{
  	$descA="";
  }
  if(isset($_POST['forA'])!=""){
  	$forA=trim($_POST['forA']);
  }else{
  	$forA="";
  }

  if(isset($_POST['S_tab'])!=""){
  	$S_tab=trim($_POST['S_tab']);
  }else{
  	$S_tab="";
  }
  
  $str_inst="INSERT INTO `sp_list`(`ID`, `List_NAME`, `Label_NAME`, `DESCS`, `Url`, `MODEL`, `STATUS`, `RETURN_URL`, `Tab_Name`) VALUES (".$MCount.",'".$lsn01A."','".$lbn01A."','".$descA."','".$ul01A."','".$relProd_val."','".$status01A."','".$forA."', '".$S_tab."')";
  $inst_cmd=mysqli_query($link_db,$str_inst);
  echo "<script>alert('AbbNew a Data!');window.location.href='support_module.php';</script>";
  exit();
}

if(trim($_REQUEST['kinds'])=="update_suplist"){
  if(isset($_POST['m_id'])!=''){
  $m_id=intval($_POST['m_id']);
  }
  $lsn01=htmlspecialchars(trim($_POST['lsn01']), ENT_QUOTES);
  $lbn01=htmlspecialchars(trim($_POST['lbn01']), ENT_QUOTES);
  $ul01=trim($_POST['ul01']);
  $relProd_valM=trim($_POST['relProd_valM']);
  $status01=trim($_POST['status01']);

  if(isset($_POST['descM'])!=''){
	//$descA=htmlspecialchars($_POST['descA'], ENT_QUOTES);
  	$descM=trim(str_replace("'","&#39;",$_POST['descM']));
  }else{
  	$descM="";
  }
  if(isset($_POST['forM'])!=""){
  	$forM=trim($_POST['forM']);
  }else{
  	$forM="";
  }

  if(isset($_POST['S_tabM'])!=""){
  	$S_tabM=trim($_POST['S_tabM']);
  }else{
  	$S_tabM="";
  }
  
  putenv("TZ=Asia/Taipei");
  $now=date("Y/m/d H:i:s");
  
  $upd_str="UPDATE `sp_list` SET `List_NAME`='".$lsn01."',`Label_NAME`='".$lbn01."',`DESCS`='".$descM."', `Url`='".$ul01."',`MODEL`='".$relProd_valM."',`UPDATE_USER`='admin',`UPDATE_DATE`='".$now."',`STATUS`='".$status01."', `RETURN_URL`='".$forM."', `Tab_Name`='".$S_tabM."' where `ID`=".$m_id;
  $upd_cmd=mysqli_query($link_db,$upd_str);
  echo "<script>alert('Update a Data!');window.location.href='support_module.php';</script>";
  exit();
}
}

if(isset($_REQUEST['s_search'])<>''){
$s_search=$_REQUEST['s_search'];
$str1="select count(`ID`) from `sp_list` where `List_NAME` like '%".$s_search."%' or `Label_NAME` like '%".$s_search."%' or `MODEL` like '%".$s_search."%'";
}else{
$str1="select count(`ID`) from `sp_list`";
}

$list1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Support Lists management (General)</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />

	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
	<script language="JavaScript">
	function MM_o(selObj){
       window.open(document.getElementById('suplist_page').options[document.getElementById('suplist_page').selectedIndex].value,"_self");
    }
	
	function search_value(){
    self.location = "?s_search=" + document.getElementById('sear_txt').value;
    return false;
    }
	
	function doEnter(event){
    var keyCodeEntered = (event.which) ? event.which : window.event.keyCode;
     if (keyCodeEntered == 13){
	   //if(confirm('Are you sure you want to search this word?')) {
	   document.location.href = "?s_search=" + document.getElementById('sear_txt').value;	   
	   //}
       //alert(keyCodeEntered);
     }
    }
	
	function add_show(){
	$("#splist_add").show();
	$("#splist_edit").hide();
	}	
	function hiden_show(){
	self.location="support_module.php";
	}
	function show_edit(){
	$("#splist_edit").show();
	$("#splist_add").hide();
	}
	function hiden_edit(){
	self.location="support_module.php";
	}
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
	<script type="text/javascript">
	function forUrlA(a){
  		var val = (a.value);
  		alert(val);
  		if(val == 1){
  			$("#forUrlA").show();
  			$("#desceditA").hide();
  		}else{
  			$("#forUrlA").hide();
  			$("#desceditA").show();
  		}
	}
	function forUrlM(a){
  		var val = (a.value);
  		alert(val);
  		if(val == 1){
  			$("#forUrlM").show();
  			$("#desceditM").hide();
  		}else{
  			$("#forUrlM").hide();
  			$("#desceditM").show();
  		}
	}
	</script>

</head>

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Support Lists management (General)</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="../logo.php">Log out &gt;&gt;</a></div>
</div>

<div class="clear"></div>
<div id="menu">
<ul>
<li ><a href="../default.php">Products</a></li>
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
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Support Lists management (General)</h2> 
</div>
<div id="content">
<br />
<div class="right">| &nbsp;<a href="support_memory.php" />Memory Lists</a>&nbsp; | &nbsp;<a href="support_hdd.php" />HDD/SSD Lists</a>&nbsp; | &nbsp;</div>
<br />
<h3>Support Lists:
</h3>
<div class="pagination left">
<p>
<form id="form3" name="form3" method="post" action="support_module.php" onsubmit="return false;">
 <input id="sear_txt" name="sear_txt" type="text" size="20" value="" onkeydown="doEnter(event);" /> <input type="button" value="Search" onclick="search_value();" />
</form><span style="color:#0F0">**Key word search: "Support List Name" & "Label Name" & "Compatible Products" 欄位 </span> </p>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div> 
</div>

<table class="list_table">
  <tr>
    <th >*Support List</th><th  >*Label Name</th><th  >*Status</th><th>Compatible Products</th><th><div class="button14" ><a href="#splist_add" style="width:50px;" onClick="add_show();">Add</a></div></th>
  </tr>
  <?php
  if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";
      
      $read_num="10";
      $start_num=$read_num*($page-1); 
      
        if(isset($_REQUEST['s_search'])<>''){
		//$s_search=preg_replace("['\"\$ \r\n\t;<>\*%\?]", '', $_REQUEST['s_search']);
		   $s_search=$_REQUEST['s_search'];
		   $str="SELECT `ID`, `List_NAME`, `Label_NAME`, `Url`, `MODEL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `sp_list` where (`List_NAME` like '%".$s_search."%' or `Label_NAME` like '%".$s_search."%' or `MODEL` like '%".$s_search."%') ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
		}else{ 
		   $str="SELECT `ID`, `List_NAME`, `Label_NAME`, `Url`, `MODEL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS` FROM `sp_list` ORDER BY `UPDATE_DATE` desc limit $start_num,$read_num;";
		}
      $result=mysqli_query($link_db,$str);
      $i=0;
	  while(list($ID, $List_NAME, $Label_NAME, $Url, $MODEL, $UPDATE_USER, $UPDATE_DATE, $STATUS)=mysqli_fetch_row($result))
      {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td ><a href="<?=$Url;?>" target="_blank"><?=$List_NAME;?></a></td><td><?=$Label_NAME;?></td><td><?php if($STATUS=='1'){ echo "Enabled"; }else if($STATUS=='0'){ echo "Disabled"; } ?></td><td><?php if(strlen($MODEL)>70){ echo substr($MODEL,0,70)."...."; }else if(strlen($MODEL)<=70){ echo $MODEL; } ?></td><td ><a href="support_module.php?mid=<?=$ID;?>&type=edit#splist_edit">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$ID;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a> </td>
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
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="suplist_page" name="suplist_page" onChange="MM_o(this)">
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
<p >&nbsp;</p><p >&nbsp;</p>
  <P style="color:#0F0">
  - 這裏管理一般的 hard code html page 的 support lists，有哪些產品會link 到<br >
  - Support List Name 的 link：點選另開視窗至所設定的 URL<br >
  - "Status" 決定這個 tab 是否會出現在被套用的 SKU page 上的 "Support Lists" 中 <br >
  - click "Del" 要popup a confirmation window to proceed<br >
    - * 表可sorting<br >
  </p>
<p class="clear">&nbsp;</p>

<!--Click add -->							
<div id="splist_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_suplist" onsubmit="return Final_Check();">
<h1>Add a Support List:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_show();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Tab added to: </th>
<td>
	<select id="S_tab" name="S_tab" >
		<option value="AVL">Support/AVL</option>
		<option value="DL">Download</option>
	</select>
</td>
</tr>
<tr>
<th>Support List Name: </th>
<td><input id="lsn01A" name="lsn01A" type="text" size="40" value="" /></td>
</tr>
<tr>
<th>Label Name: </th>
<td><input id="lbn01A" name="lbn01A" type="text" size="20" value="" />&nbsp;&nbsp;</td>
</tr>
<!-- <tr>
<th>URL:</th>
<td><input id="ul01A" name="ul01A" type="text" size="40" value="" />
<span style="color:#0F0">前端click 該tab 要另開視窗至此 URL</span>
</td>
</tr> -->
<tr>
<th>Compatible Products:</th>
<td> <div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../lb_supported_pros.php" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_val" name="relProd_val" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Format:</th>
<td>
<select id="forA" name="forA" onchange="forUrlA(this)">
<option value="0">本頁顯示</option>
<option value="1">開新視窗</option>
</select>&nbsp;&nbsp;
<div id="forUrlA" name="forUrlA" style="display:none">
	<input id="ul01A" name="ul01A" type="text" size="40" value="" />
	<span style="color:#0F0">前端click 該tab 要另開視窗至此 URL</span>
</div>
</td>
</tr>
<tr>
<th>Contents:</th>
<td>
<div id="desceditA" name="desceditA" style="">
<textarea id="descA" name="descA" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"></textarea>
</div>
</td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status01A" name="status01A"><option value="1" selected="selected">Enabled</option><option value="0">Disabled</option></select><span style="color:#0F0">預設Enabled</span>
</td>
</tr>
<tr><td colspan="2">
<input name="b2" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="c2" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:self.location='support_module.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<?php
/*include_once "../ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("descA");*/
?>
<script language="JavaScript">
function Final_Check(){
 if(document.form1.lsn01A.value==''){
 alert('Required Input a Support List Name!');
 document.form1.lsn01A.focus();
 return false;
 }
 if(document.form1.lbn01A.value==''){
 alert('Required Input a Label Name!');
 document.form1.lbn01A.focus();
 return false;
 }
 if(document.form1.status01A.value==''){
 alert('Required select a Status!');
 document.form1.status01A.focus();
 return false;
 }
 return true;
}
</script>
<p class="clear">&nbsp;</p>
</div>
<!--Click Add End  -->		

<?php
if(isset($_REQUEST['mid'])!=''){
   $mid01=intval($_REQUEST['mid']);
   $str_m="SELECT `ID`, `List_NAME`, `Label_NAME`, `Url`, `MODEL`, `UPDATE_USER`, `UPDATE_DATE`, `STATUS`, `DESCS`, `RETURN_URL`, `Tab_Name` FROM `sp_list` where `ID`=".$mid01;
   $m_cmd=mysqli_query($link_db,$str_m);
   $mdata=mysqli_fetch_row($m_cmd);   
?>

<!--Click Edit  -->		
<div id="splist_edit" class="subsettings" style="display:none">
<form id="form2" name="form2" method="post" action="?kinds=update_suplist" onsubmit="return MFinal_Check();">
<h1>Edit a Support List:</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_show();"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Tab added to: </th>
<td>
	<select id="S_tabM" name="S_tabM" >
		<option value="AVL" <?if($mdata[10]=="AVL"){echo "selected";}?>>Support/AVL</option>
		<option value="DL" <?if($mdata[10]=="DL"){echo "selected";}?>>Download</option>
	</select>
</td>
</tr>
<tr>
<th>Support List Name: </th>
<td><input id="lsn01" name="lsn01" type="text" size="40" value="<?=$mdata[1];?>" /></td>
</tr>
<tr>
<th>Label Name: </th>
<td><input id="lbn01" name="lbn01" type="text" size="20" value="<?=$mdata[2];?>" /> &nbsp;&nbsp;</td>
</tr>
<!-- <tr>
<th>URL:</th>
<td><input id="ul01" name="ul01" type="text" size="40" value="<?//=$mdata[3];?>" />
<span style="color:#0F0">前端click 該tab 要另開視窗至此 URL</span>
</td>
</tr> -->
<tr>
<th>Compatible Products:</th>
<td> <div class="button14" style="width:60px;" ><a class="fancybox fancybox.iframe" href="../elb_sumodule_pros.php?cid=<?=$mdata[0];?>" style="color:#ffffff">Edit</a></div>
 <!--列出被勾選的Products-->
 <textarea id="relProd_valM" name="relProd_valM" rows="5" cols="80" style="border: none;max-width: 800px; max-height: 200px;" readonly><?=$mdata[4];?></textarea>
 <p><span id="relProd"></span></p><!--end of 列出被勾選的Products-->
 </td>
</tr>
<tr>
<th>Format:</th>
<td>
<select id="forM" name="forM" onchange="forUrlM(this)">
<option value="0" <?php if($mdata[9]==0){ echo "selected"; }?>>本頁顯示</option>
<option value="1" <?php if($mdata[9]==1){ echo "selected"; }?>>開新視窗</option>
</select>&nbsp;&nbsp;
<div id="forUrlM" name="forUrlM" style="display:none">
<input id="ul01" name="ul01" type="text" size="40" value="<?=$mdata[3];?>" />
<span style="color:#0F0">前端click 該tab 要另開視窗至此 URL</span>
</div>
</td>
</tr>	
<tr>
<th>Contents:</th>
<td>
<div id="desceditM" name="desceditM" style=":none">
<textarea id="descM" name="descM" rows="4" cols="50" style="max-width: 250px; max-height: 250px;"><?=$mdata[8];?></textarea>
</div>
</td>
</tr>
<tr>
<th>Status:</th>
<td><select id="status01" name="status01"><option value="1" <?php if($mdata[7]=='1'){ echo "selected";} ?>>Enabled</option><option value="0" <?php if($mdata[7]=='0'){ echo "selected";} ?>>Disabled</option></select><span style="color:#0F0">預設Enabled</span>
</td>
</tr>
<tr><td colspan="2">
<input type="hidden" name="m_id" value="<?=$mdata[0];?>"><input name="b3" class="button14" style="width:60px;" type="submit" value="Done" />&nbsp;&nbsp;<input name="c3" class="button14" style="width:60px;" type="button" value="Cancel" onclick="javascript:self.location='support_hdd.php'" /> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>
<?php
/*include_once "../ckeditor/ckeditor.php";
$CKEditor = new CKEditor();
$CKEditor->basePath = 'ckeditor/';
$CKEditor->replace("descM");*/
?>
<script language="JavaScript">
function MFinal_Check(){
 if(document.form2.lsn01.value==''){
 alert('Required Input a Support List Name!');
 document.form2.lsn01.focus();
 return false;
 }
 if(document.form2.lbn01.value==''){
 alert('Required Input a Label Name!');
 document.form2.lbn01.focus();
 return false;
 }
 if(document.form2.status01.value==''){
 alert('Required select a Status!');
 document.form2.status01.focus();
 return false;
 }
 return true;
}
</script>
</div>
<?php
}
?>
<!--Click Edit End  -->		

<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
  echo "<script>show_edit();</script>\n";
  exit();
}
?>