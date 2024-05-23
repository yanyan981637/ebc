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

if(isset($_REQUEST['kinds'])!=''){
if(trim($_REQUEST['kinds'])=='add_stories'){

$str_a1="select `cs_id` from `corp_suces_stories` order by `cs_id` desc limit 1";
$check_a1=mysqli_query($link_db,$str_a1);
$Max_corpID=mysqli_fetch_row($check_a1);
$MCount=$Max_corpID[0]+1;

if(isset($_POST['n1A'])!=''){
$n1A=trim($_POST['n1A']);
}else{
$n1A="";
}
if(isset($_FILES['myFileA']['name'])!=''){
$myFileA=trim($_FILES['myFileA']['name']);

if(($myFileA != "none" && $myFileA != "")){   
   $UploadPath = "../../corp_pic/";
   $flag = copy($_FILES['myFileA']['tmp_name'], $UploadPath.basename($_FILES['myFileA']['name']));  
   if($flag) echo "";   
   $url="./corp_pic/";   
}else{   
   $url="";
}
}else{
$myFileA="";
}

if(isset($_POST['editor1'])!=''){
$editor1=htmlspecialchars($_POST['editor1'], ENT_QUOTES);
}else{
$editor1="";
}
if(isset($_POST['ctA'])!=''){
$ctA=trim($_POST['ctA']);
}else{
$ctA="";
}
if(isset($_POST['regA'])!=''){
$regA=trim($_POST['regA']);
}else{
$regA="";
}
if(isset($_POST['idsA'])!=''){
$idsA=trim($_POST['idsA']);
}else{
$idsA="";
}
if(isset($_POST['langA'])!=''){
$langA=trim($_POST['langA']);
}else{
$langA="";
}
if(isset($_POST['statusA'])!=''){
$statusA=trim($_POST['statusA']);
}else{
$statusA="";
}

$str_corpval="UPDATE `product_corpval` SET `PCS_id`=".$MCount.",`PCV_flag`=1 WHERE `PCV_flag`=0";
$corpval_cmd=mysqli_query($link_db,$str_corpval);

$str_inst="INSERT INTO `corp_suces_stories`(`cs_id`, `cs_title`, `cs_img`, `cs_conts`, `cs_cstr`, `cs_rego`, `cs_inds`, `cs_lang`, `cs_stats`) VALUES (".$MCount.",'".$n1A."','$url$myFileA','".$editor1."','".$ctA."','".$regA."','".$idsA."','".$langA."',".$statusA.")";
$inst_cmd=mysqli_query($link_db,$str_inst);
echo "<script>alert('AddNew The Data !');location.href='corp_stories.php'</script>";
exit();
}
}

if(isset($_REQUEST['d_id'])!='' && isset($_REQUEST['act'])!=''){
  if(trim($_REQUEST['act'])=="del"){
  $d_id01=intval($_REQUEST["d_id"]);
  $str_del="DELETE FROM `product_corpval` where `PCV_id`=".$d_id01;
  $del_cmd=mysqli_query($link_db,$str_del);
  echo "<script>alert('Delete the Data !');self.location='corp_stories.php'</script>";
  exit();
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Corporation: Success Stories </title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css/css.css" />

	<script type="text/javascript" src="../../lib/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="../../source/jquery.fancybox.js?v=2.0.6"></script>
	<link rel="stylesheet" type="text/css" href="../../source/jquery.fancybox.css?v=2.0.6" media="screen" />
	<link rel="stylesheet" type="text/css" href="../../source/helpers/jquery.fancybox-buttons.css?v=1.0.2" />
	<script type="text/javascript" src="../../source/helpers/jquery.fancybox-buttons.js?v=1.0.2"></script>
	<script language="JavaScript">
	function MM_SL(selObj)
	{
	   window.open(document.getElementById('SEL_SLang').options[document.getElementById('SEL_SLang').selectedIndex].value,"_self");
	}
	function show_add(){
	  $("#cstories_add").show();
	}
	function hiden_add(){
	  $("#cstories_add").hide();
	}
	function show_AddVal(){
	  $("#PValue_ADD01").show();
	  $("#PValue_MOD01").hide();
	}
	function show_ModVal(){
	  $("#cstories_add").show();
	  $("#PValue_MOD01").show();
	  $("#PValue_ADD01").hide();
	}
	</script>
	<script type="text/javascript">
    $(function() {
  
  $("#PVaBtn").click(function() {
  
  var form = $('#form1');  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form1').serialize();
  var url = "add_Corp_PVals.php";  
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: formdata ? formdata : form.serialize(),  
  //data: params,
  cache: false,
  contentType: false,
  processData: false,
  
  success: function(data){
    if(data == "refresh"){	
    //window.location.reload(true);
	self.location="corp_stories.php?kind=show_add";
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
	  
  $("#PVaBtnm").click(function() {
  
  var form = $('#form1');  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form1').serialize();
  var url = "mod_Corp_PVals.php";  
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: formdata ? formdata : form.serialize(),  
  //data: params,
  cache: false,
  contentType: false,
  processData: false,
  
  success: function(data){
    if(data == "refresh"){	
    //window.location.reload(true);
	self.location="corp_stories.php?kind=show_add";
    }
    else{
    $("#PValm_MGT").html(data);
	$("#PValm_error").html('');
    }
  }  
  });  
  });
  	
	  $("#PVaCelm").click(function() { 
	    $("#PValue_MOD01").hide();
		$("#PValm_MGT").html('');
		$("#PValm_error").html('');
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

<body>
<a name="top"></a>
<div >
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Corporation Success Stories</h1></div>
<div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?>  <a href="../logo.php">Log out &gt;&gt;</a></div>
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
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Corporation Success Stories</h2> 
</div>

<div id="content">

<br />
<div class="right">| &nbsp;<a href="corporation.php" />Corporation</a>&nbsp; | </div>
<br />
<h3>Corporation Success Stories Lists:&nbsp;&nbsp;
<select id="SEL_SLang" name="SEL_SLang" onChange="MM_SL(this)">
<option value="corp_stories.php?slang=en-US" selected>English</option>
<option value="corp_stories.php?slang=zh-CN">簡中</option>
<option value="corp_stories.php?slang=zh-TW">繁中</option>
<option value="corp_stories.php?slang=ja-JP">日文</option>
</select>
</h3>

<table class="list_table">
  <tr>
    <th>Title</th><th>*Industry <a class="fancybox fancybox.iframe" href="lb_corp_story_industry.php" /><img src="../../images/icon_edit.png" alt="Edit" /></a></th><th>Language</th><th  >Contents</th><th  >Products</th><th  >Status</th><th><div class="button14" style="width:50px;"><a href="#cstories_add" STYLE="text-decoration:none" onClick="show_add()">Add</a></div></th>
  </tr>
  <?php
      if(isset($_REQUEST['page'])!=""){
      $page=intval($_REQUEST['page']);
      }else{
      $page="1";
      }
      
      if(empty($page))$page="1";
      
      $read_num="20";
      $start_num=$read_num*($page-1);
			
      if(isset($_REQUEST['pt_lang'])!=''){      
        $str="SELECT `cs_id`, `cs_title`, `cs_img`, `cs_conts`, `cs_cstr`, `cs_rego`, `cs_inds`, `cs_lang`, `cs_stats` FROM `corp_suces_stories` where `cs_lang` ='".$_REQUEST['pt_lang']."' ORDER BY `cs_id` limit $start_num,$read_num;";
      }else{
        $str="SELECT `cs_id`, `cs_title`, `cs_img`, `cs_conts`, `cs_cstr`, `cs_rego`, `cs_inds`, `cs_lang`, `cs_stats` FROM `corp_suces_stories` ORDER BY `cs_id` limit $start_num,$read_num;";
      }      
      $result=mysqli_query($link_db, $str);
      $i=0;
	  while(list($cs_id,$cs_title,$cs_img,$cs_conts,$cs_cstr,$cs_rego,$cs_inds,$cs_lang,$cs_stats)=mysqli_fetch_row($result))      
	  {
      $i=$i+1;
      putenv("TZ=Asia/Taipei");
  ?>
  <tr>
    <td><?=$cs_title;?></td>
	<td>
	<?php
	$str_ids="SELECT `ci_id`, `ci_name`, `ci_img` FROM `corp_stor_industry` where `ci_id`=".$cs_inds;
	$ids_result=mysqli_query($link_db,$str_ids);
	$ids_data=mysqli_fetch_row($ids_result);
	echo $ids_data[1];
	?>
	</td><td><?=$cs_lang;?></td>
	<td>
	<?php
	if(strlen($cs_conts)>100){
	echo substr($cs_conts,0,100);
	}else{
	echo $cs_conts;
	}
	?>
	</td>
	<td >
	<?php
	$str_p="SELECT `PCV_id`, `PCS_id`, `PCV_name`, `PCV_img`, `PCV_url`, `PCV_brief`, `PCV_flag` FROM `product_corpval` where `PCS_id`=".$cs_id;
	$p_result=mysqli_query($link_db,$str_p);
	while($p_data=mysqli_fetch_row($p_result)){
	echo $p_data[2].",";
	}
	?>
	</td><td >
	<?php
	if($cs_stats==1){
	echo "Online";
	}else if($cs_stats==0){
	echo "Offline";
	}
	?></td><td ><a href="#">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$cs_id;?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a> </td>
  </tr>
  <?php
      }
  ?>
</table>

<p class="clear">&nbsp;</p>

<!--Click Edit and add -->							
<div id="cstories_add" class="subsettings" style="display:none">
<form id="form1" name="form1" method="post" action="?kinds=add_stories" enctype="multipart/form-data" onsubmit="return Final_Check();">
<h1>Add / Edit a Success Story</h1>
<!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
<table class="addspec">
<tr>
<th>Title:  </th>
<td><input id="n1A" name="n1A" type="text" size="40" value="" />
</td>
</tr>
<tr>
<th>Image:  </th>
<td><input type="file" id="myFileA" name="myFileA" size="20">
</td>
</tr>
<tr>
<th>Contents: </th>
<td><textarea id="editor1" name="editor1" rows="5" cols="100" style="max-width: 500px; max-height: 500px;"></textarea>
<p style="color:#0F0">** web editor : Alow HTML code</p>
</td>
</tr>
<tr>
<th>Customer:  </th>
<td><input id="ctA" name="ctA" type="text" size="40" value="" />
</td>
</tr>
<tr>
<th>Region:  </th>
<td><input id="regA" name="regA" type="text" size="40" value="" />
</td>
</tr>
<tr>
<th>Industry:</th>
<td>
<select name="idsA">
<option value="" selected>Select...</option>
<?php
$str_ids="select `ci_id`, `ci_name`, `ci_img` from `corp_stor_industry`";
$ids_result=mysqli_query($link_db,$str_ids);
while($ids_data=mysqli_fetch_row($ids_result)){
?>
<option value="<?=$ids_data[0];?>"><?=$ids_data[1];?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<th>Products:</th>
<td>

<table class="list_table">
  <tr>
    <th >Name</th><th >Image</th><th >URL</th><th >Brief</th ><th><div class="button14" style="width:50px;" onClick="show_AddVal();">Add</div></th>
  </tr>
<!--add a product-->
  <tr>
    <td colspan="5">
	<DIV id="PValue_ADD01" style="display:none"><input name="PV_str01" type="text" size="5" value="" /> <input type="file" id="PV_myFile" name="PV_myFile" size="20"> <input name="PV_str02" type="text" size="30" value=""  /> <textarea name="PV_str03" rows="4" cols="20" style="max-width: 400px; max-height: 50px;"></textarea> <input id="PVaBtn" type="button" value="Done" /><input id="PVaCel" type="button" value="Cancel" /><DIV id="PVal_MGT"></DIV><DIV id="PVal_error"></DIV></div>
    <?php
	if(isset($_REQUEST['mid'])!=''){
	$mid=intval($_REQUEST['mid']);
	}else{
	$mid="";
	}
	if($mid!=''){
	$str_mVal="SELECT `PCV_id`, `PCS_id`, `PCV_name`, `PCV_img`, `PCV_url`, `PCV_brief` FROM `product_corpval` where `PCV_id`=".$mid;
	$mVal_result=mysqli_query($link_db,$str_mVal);
	$mVal_data=mysqli_fetch_row($mVal_result);
	?>
	<DIV id="PValue_MOD01" style="display:none"><input name="PV_str00m" type="hidden" value="<?=$mVal_data[0];?>"><input name="PV_str01m" type="text" size="5" value="<?=$mVal_data[2];?>" /> <input type="file" id="PV_myFilem" name="PV_myFilem" size="20"> <input name="PV_str02m" type="text" size="30" value="<?=$mVal_data[4];?>"  /> <textarea name="PV_str03m" rows="4" cols="20" style="max-width: 400px; max-height: 50px;"><?=$mVal_data[5];?></textarea> <input id="PVaBtnm" type="button" value="Done" /><input id="PVaCelm" type="button" value="Cancel" /><DIV id="PValm_MGT"></DIV><DIV id="PValm_error"></DIV></div>
	<?php
	}
	?>
	</td>
  </tr>
<!--end add a product-->
  <?php
  $str_corpval="SELECT `PCV_id`, `PCS_id`, `PCV_name`, `PCV_img`, `PCV_url`, `PCV_brief` FROM `product_corpval` where `PCV_flag`=0";
  $corpval_cmd=mysqli_query($link_db,$str_corpval);
  while($corpval_data=mysqli_fetch_row($corpval_cmd)){
  ?>
  <tr>
    <td ><?=$corpval_data[2];?> </td><td ><?=$corpval_data[3];?></td><td ><?=$corpval_data[4];?></td><td><?=$corpval_data[5];?></td><td ><a href="corp_stories.php?mid=<?=$corpval_data[0];?>">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$corpval_data[0];?>">Del</a></td>
  </tr>
  <?php
  }
  ?>
</table>
</td>
</tr>
<tr>
<th>Language:</th>
<td>
<select id="langA" name="langA">
<option value="en-US" selected>English</option>
<option value="zh-CN">簡體</option>
<option value="zh-TW">繁體</option>
<option value="ja-JP">日文</option>
</select>
</td>
</tr>
<tr>
<th>Status:</th>
<td>
<select id="statusA" name="statusA">
<option value="1" selected>Online</option>
<option value="0">Offline</option>
</select>
</td>
</tr>
<tr><td colspan="2">
<BUTTON name="submitbutton01" id="submitbutton01" style="width:70px; margin-right:10px" type="submit" class="big_button left">Done</BUTTON><BUTTON name="submitbutton02" id="submitbutton02" style="width:86px; margin-right:10px" type="reset" class="big_button left" onclick="javascript:self.location='corp_stories.php'">Cancel</BUTTON> <span style="color:#0F0">Cancel: 不save, 直接close 這個add/edit box</span>
</td></tr>
</table>
</form>

<script language="JavaScript">
function Final_Check(){
if(document.form1.n1A.value == ""){
 alert("Required input a Title！");
 document.form1.n1A.focus();
 return false;
}
if(document.form1.myFileA.value == ""){
 alert("Please select To upload Image！");
 document.form1.myFileA.focus();
 return false;
}
if(document.form1.editor1.value == ""){
 alert("Required input a Contents！");
 document.form1.editor1.focus();
 return false;
}
if(document.form1.ctA.value == ""){
 alert("Required input a Customer！");
 document.form1.ctA.focus();
 return false;
}
if(document.form1.regA.value == ""){
 alert("Required input a Region！");
 document.form1.regA.focus();
 return false;
}
if(document.form1.idsA.value == ""){
 alert("Required input a Industry！");
 document.form1.idsA.focus();
 return false;
}
 return true;
}
</script>
</div>

<p class="clear">&nbsp;</p>
</div>

<div id="footer">	Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'editor1', {
    });
</script>
</body>
</html>
<?php
if(isset($_REQUEST['mid'])!=''){
echo "<script>show_ModVal();</script>";
exit();
}
if(isset($_REQUEST['kind'])=='show_add'){
echo "<script>show_add();</script>";
exit();
}
?>