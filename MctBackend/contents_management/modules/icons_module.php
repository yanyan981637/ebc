<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "../../config.php";
include_once('../../page.class.php');

session_start();
if(empty($_SESSION['user']) || empty($_SESSION['login_time'])){
echo "<script language='JavaScript'>location='../../login.php'</script>";
exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['act'])=='del'){
  $d_id01=intval($_REQUEST['d_id']);
  if($d_id01!=''){
   $str_delpic="select `img` from `c_sp_icon` where `id`=".$d_id01;
   $delpic_result=mysqli_query($link_db,$str_delpic);
   $delpic_data=mysqli_fetch_row($delpic_result);
   
   $files01='../../'.str_replace("./","../",$delpic_data[0]);
   if(file_exists($files01)) {
   unlink('../../'.str_replace("./","../",$delpic_data[0]));//刪除實體路徑圖示
   }
   $str_del="delete from `c_sp_icon` where `id`=".$d_id01;
   $del_cmd=mysqli_query($link_db,$str_del);
   echo "<script>alert('Delete the Data !');self.location='icons_module.php'</script>";
   exit();
  }
}

$str_order="SELECT `order` FROM `c_sp_icon` order by `order` desc limit 1";
$order_result=mysqli_query($link_db,$str_order);
$order_data=mysqli_fetch_row($order_result);
$order_num=$order_data[0]+1;

$str1="select count(*) from `c_sp_icon`";
$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Website Contents Management - Products Management - Contents: Modules - Icons Module</title>
<link rel="stylesheet" type="text/css" href="../../backend.css">
<link rel="stylesheet" type="text/css" href="../../css.css" />
<script type="text/javascript" src="../../jquery.min.js"></script>
<script language="JavaScript">
   function MM_o(selObj){
     window.open(document.getElementById('icons_page').options[document.getElementById('icons_page').selectedIndex].value,"_self");
    }
   function show_AddVal(){
     $('#MValue_ADD01').show();
	 $('#MValue_MOD01').hide();
   }
   
   function show_ModVal(id){
     self.location="icons_module.php?mid=" + id;
   }
   
   function show_ModVal01(){
     $('#MValue_MOD01').show();
	 $('#MValue_ADD01').hide();
   }
</script>
<script type="text/javascript">
$(function() {
	
  $("#MVaBtn").click(function() {
  
  var form = $('#form2');
  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form2').serialize();
  //var params = $('input').serialize();
  var url = "add_icons_MVals.php";  
  
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
    window.location.reload(true);
    }
    else{
    $("#MVal_MGT").html(data);
	$("#MVal_error").html('');
    }
  }  
  });  
  });
  
  $("#MVaBtnm").click(function() {
  
  var form = $('#form2');
  
  var formdata = false;
  if (window.FormData){
      formdata = new FormData(form[0]);
  }
  
  var params = $('#form2').serialize();
  var url = "mod_icons_MVals.php";
  
  $.ajax({
  type: "post",
  url: url,
  dataType: "html",
  data: formdata ? formdata : form.serialize(),
  cache: false,
  contentType: false,
  processData: false,
  
  success: function(data){
    
    if(data == "refresh"){	
    //window.location.reload(true);
    self.location='icons_module.php';
	}
    else{
    $("#MValm_MGT").html(data);
	$("#MValm_error").html('');
    }
  }  
  });  
  });  
  
  $("#MVaCel").click(function() {
    $("#MValue_ADD01").hide();
	$("#MV_str01").val("");
	$("#MV_str02").val("");
	$("#MV_str03").val("");
	$("#MyFile").val("");
    $("#MVal_MGT").html('');
    $("#MVal_error").html('');
    });
	
	$("#MVaCelm").click(function() {
	/*
    $("#MValue_MOD01").hide();
	$("#MVm_str01").val("");
	$("#MVm_str02").val("");
	$("#MVm_str03").val("");
	$("#MyFilem").val("");
    $("#MValm_MGT").html('');
    $("#MValm_error").html('');
    */
	self.location='icons_module.php';
	});
  
});
</script>
</head>

<body>
<a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - Website Contents Management - Contents: Icons Module</h1></div>
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
<h2>Contents &nbsp;&gt;&nbsp;  <a href="../modules.php">Modules</a>  &nbsp;&gt;&nbsp; Icons Module</h2> 
</div>
<div id="content">
<br />
<h3>Icons List:</h3>
<div>
<div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records </div>
</div>
<form id="form2" name="form2" method="post" enctype="multipart/form-data" action="icons_module.php">
<table class="list_table">
  <tr>
    <th>ID</th><th >Icon Name</th><th >Image</th><th>URL</th><th>Order</th><th>Tooltips</th><th><div class="button14" style="width:50px;" onClick="show_AddVal();">Add</div></th>
  </tr>
  <!--點選Add 會出現下面的row, 進行新增-->
  <tr>
    <td colspan="7">
    <div id="MValue_ADD01" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input id="MV_str01" name="MV_str01" type="text" size="20" value="" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="file" id="MyFile" name="MyFile" size="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input id="MV_str02" name="MV_str02" type="text" size="10" value="http://" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input id="MV_str03" name="MV_str03" type="text" size="10" value="<?=$order_num;?>" placeholder="Order" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input id="MV_str04" name="MV_str04" type="text" size="30" value="" placeholder="Tooltips" />&nbsp;
      <input id="MVaBtn" type="button" value="Done" />&nbsp;
      <input id="MVaCel" type="button" value="Cancel" />
      <div id="MVal_MGT"></div>
      <div id="MVal_error"></div>
    </div>
	<?php
	if(isset($_REQUEST['mid'])!=''){
	  $str_MVm="SELECT `id`, `icon_name`, `img`, `url`, `update_user`, `update_date`, `order`, `tooltips` FROM `c_sp_icon` where `id`=".intval($_REQUEST['mid']);
	  $MVm_cmd=mysqli_query($link_db,$str_MVm);
	  $MVm_data=mysqli_fetch_row($MVm_cmd);
	?>
	<div id="MValue_MOD01" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input id="MValue_id" name="MValue_id" type="hidden" value="<?=$_REQUEST['mid'];?>">
    <input id="MVm_str01" name="MVm_str01" type="text" size="20" value="<?=$MVm_data[1];?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="file" id="MyFilem" name="MyFilem" size="20" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input id="MVm_str02" name="MVm_str02" type="text" size="10" value="<?=$MVm_data[3];?>"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input id="MVm_str03" name="MVm_str03" type="text" size="10" value="<?=$MVm_data[6];?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input id="MVm_str04" name="MVm_str04" type="text" size="30" value="<?=$MVm_data[7];?>" placeholder="Tooltips" />&nbsp;
    <input id="MVaBtnm" type="button" value="Done" />&nbsp;
    <input id="MVaCelm" type="button" value="Cancel" />
    <div id="MValm_MGT"></div>
    <div id="MValm_error"></div>
  </div>
	<?php
	}
	?>
	</td>	
  </tr>
  <!--end 新增icon-->
  <?php
      if(isset($_REQUEST['page'])==""){
      $page="1";
      }else{
      $page=intval($_REQUEST['page']);
      }
      
      if(empty($page))$page="1";      
      $read_num="40";
      $start_num=$read_num*($page-1);  
	  $str_m1="SELECT `id`, `icon_name`, `img`, `url`, `update_user`, `update_date`, `order`, `tooltips` FROM `c_sp_icon` order by `id` desc limit $start_num,$read_num;";
  
  $m1_result=mysqli_query($link_db,$str_m1);
  while($m1_data=mysqli_fetch_row($m1_result)){
  ?>
  <tr>
    <td><?=$m1_data[0];?></td>
    <td><?=$m1_data[1];?></td>
    <td ><img src="../../<?=str_replace("./","../",$m1_data[2]);?>" /></td>
    <td ><?=$m1_data[3];?></td>
    <td ><?=$m1_data[6];?></td>
    <td ><?=$m1_data[7];?></td>
    <td ><a href="#" onClick="show_ModVal(<?=$m1_data[0];?>);">Edit</a>&nbsp;&nbsp;<a href="?act=del&d_id=<?=$m1_data[0];?>" onclick="return confirm('Are you sure you want to delete this item?');">Del</a></td>
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
</form>
<br />
<div class="sabrosus"><span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
<select id="icons_page" name="icons_page" onChange="MM_o(this)">
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
<p >&nbsp;</p><p >&nbsp;</p>
<P style="color:#0F0">
<ul style="color:#0F0">
<li>倒資料：http://www.tyan.com/TYANWEBMGT/c_all_cpusort.aspx<br >
(PRODUCTS => ServerBoards分類管理 =>  CPU LOGO清單)<br >
CPUSORTID -> ID (新系統：當新增一筆資料，系統自動產生ID，新的ID 接著舊系統的ID數字之後)<br >
CPU分類 -> Icon Name<br >
Logo  -> Image<br >
URL：新增欄位<br > Order 可以排順序 ：新增欄位   </li>
<li>order 為設定當產品SPEC 被勾選的icons，這些icons網頁上呈現的順序。舊資料的此欄位值，將舊系統的CPUSORTID值匯入。前端網頁呈現順序要由大至小遞減</li>
</ul>
</p>
<p class="clear">&nbsp;</p>
</div>
<div id="footer">Copyright &copy; 2014 Company Co. All rights reserved.
<div class="gotop" onClick="location='#top'">Top</div>
</div>
</body>
</html>
<?php
  if(isset($_REQUEST['mid'])!=''){
  echo "<script>show_ModVal01();</script>\n";
  exit();
  }
?>