<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");

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

if(isset($_REQUEST['brand_id'])<>""){
  $brand_id=intval($_REQUEST['brand_id']);
}else{
  $brand_id="";
}

if(isset($_REQUEST['d_id'])!=""){
  $d1=intval($_REQUEST['d_id']);
  $str_d="delete FROM brand_name where BRANDID=".$d1;
//$cmd_d=mysqli_query($link_db,$str_d);
  if($cmd_d=mysqli_query($link_db,$str_d)){
   echo "<script>alert('Dele Brand Name !');location.href='brand_name.php';</script>";
   exit();
 }
}

if(isset($_REQUEST['kinds'])!=''){
  if(trim($_REQUEST['kinds'])=='edit_brand'){
    $USER=str_replace('@mic.com.tw','',$_SESSION['user']);
    if(isset($_POST['bname_id'])!=''){
      $bname_id=trim($_POST['bname_id']);
    }
    if(isset($_POST['brand_name02'])!=''){
      $brand_name02=trim($_POST['brand_name02']);
    }

    putenv("TZ=Asia/Taipei");
    $now=date("Y/m/d H:i:s");

    $str1="update `brand_name` set `BRANDNAME`='".$brand_name02."',`UPDATE_DATE`='".$now."',`UPDATE_USER`='".$USER."' where `BRANDID`=".$bname_id;
    $cmd_c=mysqli_query($link_db,$str1);
    echo "<script>alert('Edit Brand Name !');location.href='brand_name.php?brand_id=".$bname_id."#types_edit';</script>";
    exit();
  }
} 

if(isset($_REQUEST['kinds'])!=''){
  if(trim($_REQUEST['kinds'])=='add_brand'){
    $USER=str_replace('@mic.com.tw','',$_SESSION['user']);
    $str_m="select BRANDID FROM brand_name order by BRANDID desc limit 1";
    $check_m=mysqli_query($link_db,$str_m);
    $Max_SOptionID=mysqli_fetch_row($check_m);
    $MCount=$Max_SOptionID[0]+1;

    if(isset($_POST['brand_name01'])!=''){
      $brand_name01=trim($_POST['brand_name01']);
    }else{
      $brand_name01="";
    }

    putenv("TZ=Asia/Taipei");
    $now=date("Y/m/d H:i:s"); 

    $str_sku="insert into brand_name (`BRANDID`, `BRANDNAME`, `UPDATE_DATE`, `UPDATE_USER`) values ('$MCount','$brand_name01','$now','$USER')";
    $cmd_sku=mysqli_query($link_db,$str_sku);
    echo "<script>alert('Add Brand Name !');location.href='brand_name.php';</script>";
    exit();
  }
}


$str1="select count(*) from brand_name where 1";
$list1=mysqli_query($link_db,$str1);
list($public_count)=mysqli_fetch_row($list1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SPEC Creation Tool - SPEC Settings</title>
<link rel="stylesheet" type="text/css" href="../backend.css">
<link rel="stylesheet" type="text/css" href="../css/css.css" />
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script language="JavaScript">

function Del_id(t_id){    
  if(confirm("確定要刪除此筆資料嗎?")){
    self.location="?d_id="+t_id;
  }else{
  }
}

function hiden_add(){
//$("#types_add").hide();//隱藏
self.location="brand_name.php";
}

function hiden_edit(){
//$("#types_edit").hide();//隱藏
self.location="brand_name.php";
}

function show_add(){
$("#types_add").show();//顯示
$("#types_edit").hide();
}

function show_edit(){
$("#types_add").hide();
$("#types_edit").show();//顯示
}
function MM_o(selObj){
//window.open(document.all.pskus_page.options[document.all.pskus_page.selectedIndex].value,"_self");
window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

function MM_sc(selObj){
window.open(document.getElementById('sear_Category').options[document.getElementById('sear_Category').selectedIndex].value,"_self");
}

function MM_u(selObj){
//window.open(document.all.SEL_spccateg.options[document.all.SEL_spccateg.selectedIndex].value,"_self");
window.open(document.getElementById('SEL_spccateg').options[document.getElementById('SEL_spccateg').selectedIndex].value,"_self");
}
function MM_e(selObj){
//window.open(document.all.SEL_espccateg.options[document.all.SEL_espccateg.selectedIndex].value,"_self");
window.open(document.getElementById('SEL_espccateg').options[document.getElementById('SEL_espccateg').selectedIndex].value,"_self");
}    
</script>

<script type="text/javascript">
$(function() {
  
  $("#Check_PSPEC").change(function() {
    if($(this).val()=="Top"){
    $("#PESPEC_add01").show();
    $("#PESPEC_add02").hide();
    $("#SEL_PSPEC").hide();
    }else if($(this).val()==""){
    $("#PESPEC_add01").hide();
    $("#PESPEC_add02").hide();
    $("#SEL_PSPEC").hide();
    }else if($(this).val()=="Sub"){
    $("#PESPEC_add02").show();
    $("#PESPEC_add01").hide();
    $("#SEL_PSPEC").show();
    }
  });  
});

</script>


</head>
<body><a name="top"></a>
<div>
<div class="left"><h1>&nbsp;&nbsp;Website Backends - SPEC Creation Tool</h1></div>
<div id="logout">Hi <b><?=str_replace('@mic.com.tw','',$_SESSION['user']);?></b> <a href="./logo.php">Log out &gt;&gt;</a></div>
</div>
<div class="clear"></div>
<?php
include("./menu.php");
?>
<div class="clear"></div>
<div id="Search">
<h2><a href="spec_settings.php">SPEC Settings</a> &nbsp;&gt;&nbsp; Brand Names</h2>
</div>
<p class="clear"></p>
<div id="content">
  <h3 class="left">SPEC Settings - Brand Name List</h3>
  <!--datatable start here-->
  <p class="clear"></p>
  <div>
    <div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;
    </div>
  </div>
  <p class="clear"></p>
  <table class="list_table">
   <tr>
    <th onclick="">Brand Name</th>
    <th onclick="">Update Date</th>
    <th onclick="">Updated by</th>
    <th onClick="#" width="120"><div class="button14" style="width:100px;"><a href="#types_add" onClick="show_add();" STYLE="text-decoration:none">Add New</a></div></th> 
  </tr>
  <?php
  if(isset($_REQUEST['page'])==""){
    $page="1";
  }else{
    $page=intval($_REQUEST['page']);
  }      
  if(empty($page))$page="1";

  $read_num="25";
  $start_num=$read_num*($page-1);      

  $str_bname = "Select BRANDID, BRANDNAME, UPDATE_DATE, UPDATE_USER FROM brand_name where 1 limit $start_num,$read_num;";
  $b_result=mysqli_query($link_db,$str_bname);
  while($brand=mysqli_fetch_row($b_result)){
    ?>
    <tr>
      <td><?=$brand[1];?></td>
      <td><?=$brand[2];?></td>
      <td><?=$brand[3];?></td>
      <td>
        <a href="brand_name.php?brand_id=<?=$brand[0];?>#types_edit">Edit</a>&nbsp;&nbsp;
        <input type=button name="D_This" value="Del" onClick="Del_id(<?="$brand[0]"?>)">&nbsp;&nbsp;
      </td>
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
<div class="sabrosus">
  <span class="w14bblue"><?=$read_num?></span> Records Per Page &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
  <select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
    <?php
    for($j=1;$j<=$total;$j++){
      ?>
      <option value="?page=<?=$j?>&s_search=<?=$s_search?>&c_search=<?=$c_search;?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
      <?php
    }
    ?>
  </select>&nbsp;&nbsp;
  <?php echo $pagenav;?></div>
  <p>&nbsp;</p><p>&nbsp;</p><p class="clear"></p>
  <!--end of datatable -->

  <!--Click Edit, Add Category & View category-->

  <div id="types_add" class="subsettings" style="display:none">
    <form id="form1" name="form1" method="post" action="?kinds=add_brand" >
      <!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_add()"> [close] </a></div><!--end of close-->
      <table class="addspec">
        <tr><td colspan="2"><!--<input name="" type="button" value="Delete" disabled /> --></td></tr>
        <tr>
          <th>Brand Name:</th>
          <td><input name="brand_name01" type="text" size="40" /></td>
        </tr>
        <tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
      </table>
    </form>
  </div>


  <!--end of ADD -->
</div>


<!--Edit -->
<div id="types_edit" class="subsettings" style="display:none">
  <form id="form3" name="form3" method="post" action="?kinds=edit_brand">
    <!--Click close to close this subsettings div--><div class="right"><a href="#" onclick="hiden_edit()"> [close] </a></div><!--end of close-->
    <table class="addspec">
      <tr><td colspan="2"><!--<input name="" type="button" value="Delete" disabled /> --> </td></tr>
      <tr>
        <th>Brand Name:</th>
        <?php
        if(isset($_REQUEST['brand_id'])<>""){
          $brand_id=intval($_REQUEST['brand_id']);
          $link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
          mysqli_query($link_db, 'SET NAMES utf8');
          mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
          mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
          //$select=mysqli_select_db($dataBase, $link_db);
          $str_brand="select BRANDID, BRANDNAME from brand_name where BRANDID = '$brand_id'";
          $result=mysqli_query($link_db,$str_brand);
          $Bname=mysqli_fetch_row($result);
        }
        ?>
        <td>
          <input type="hidden" name="bname_id" value="<?=$Bname[0]?>">
          <input name="brand_name02" type="text" size="40" value="<?=$Bname[1]?>" />
        </td>
        <?php
        mysqli_close($link_db);
        ?>
      </tr>
      <tr><td colspan="2"><input type="submit" value="Done" />&nbsp;&nbsp;</td></tr>
    </table>
  </form>
</div>

<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2012 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>
<?php
if(isset($_REQUEST['brand_id'])<>""){
echo "<script language='Javascript'>show_edit();</script>\n";
}
exit();
?>