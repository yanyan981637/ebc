<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

error_reporting(0);
require "../config.php";
include_once('../page.class.php');
@session_start();

if(empty($_SESSION['user']) || empty($_SESSION['login_time'])){
  echo "<script language='JavaScript'>location.href='../login.php'</script>";
  exit();
}

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase);

if(isset($_REQUEST['d_id'])!=""){
  $d1=intval($_REQUEST['d_id']);
  $str_d="delete FROM contact_us_new where ID=".$d1;
//$cmd_d=mysqli_query($link_db,$str_d);
  if($cmd_d=mysqli_query($link_db,$str_d)){
   echo "<script>alert('Delete Contact !');location.href='default.php';</script>";
   exit();
 }
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_GET['kind']!=""){
  $kind=filter_var($_GET['kind']);
}else{
  $kind="";
}

if($kind=="del"){
  if(isset($_GET['ID'])){
    $ID=filter_var($_GET['ID']);
  }else{
    $ID="";
  }
  $str="DELETE FROM downloadcatalog WHERE ID='".$ID."'";
  mysqli_query($link_db,$str);
  echo "<script>alert('Delete Done!');self.location='default.php'</script>";
   exit();
}

if($kind=="search"){
  if(isset($_GET['source'])){
    $source=filter_var($_GET['source']);
  }else{
    $source="";
  }
  $str1="SELECT count(*) FROM downloadcatalog WHERE Source='".$source."'";
}else{
  $str1="SELECT count(*) FROM downloadcatalog WHERE 1";
}

$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);

if(isset($_REQUEST['page'])==""){
  $page="1";
}else{
  $page=$_REQUEST['page'];
}    
$read_num="10";

$start_num=$read_num*($page-1);
$all_page=ceil($public_count/$read_num);
$pageSize=$page;
$total=$all_page;
pageft($total,$pageSize,1,0,0,15);       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>MCT Website Backends – Catalog Email List</title>
  <link rel="stylesheet" type="text/css" href="../backend.css" />
  <link rel="stylesheet" type="text/css" href="../css/css.css" />
  <script type="text/javascript" src="../jquery.min.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  
</head>
<body><a name="top"></a>
  <div>
    <div class="left"><h1>&nbsp;&nbsp;MCT Website Backends - Contact Management</h1></div>
    <div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="./logo.php">Log out &gt;&gt;</a></div>
  </div>
  <div class="clear"></div>

  <div class="clear"></div>

  <!-- <div id="Search">
    <div class="left" >
      <form id="top_form" name="top_form" method="post" action="excel.php">
        <input id="s_mail" name="s_mail" type="text" size="30" value="" placeholder="Enter an email"  />
        <input name="" type="button" value="Search" onClick="search()" />
        &nbsp;&nbsp;&nbsp;&nbsp; /  &nbsp;&nbsp;&nbsp;&nbsp;
        Export: 
        
        <input id="sDateM" name="sDateM" type="text" size="20" value="" onfocus="HS_setDate(this)" />
        &nbsp;  to &nbsp;  
        <input id="eDateM" name="eDateM" type="text" size="20" value="" onfocus="HS_setDate(this)" />
        <input id="scheck_export" name="scheck_export" type="submit" value="Download"  /> 
      </form>

    </div>
  </div> -->

  <p class="clear"></p>
  <div id="content">
    <h3 class="left">Emails List:</h3><p class="clear"></p>



    <!--datatable starts here-->

    <div>

      <div class="pagination left">Total: <span class="w14bblue"><?=$public_count?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
        <select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
          <?php
          for($j=1;$j<=$total;$j++){
            ?>
            <option value="?page=<?=$j?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
            <?php
          }
          ?>
        </select>
        &nbsp;&nbsp;| &nbsp;&nbsp;
        Source :
        <select id="se_value" name="se_value">
          <?php
          $str_value="SELECT DISTINCT Source FROM downloadcatalog WHERE 1 ";
          $cmd_value=mysqli_query($link_db,$str_value);
          while ($data_value=mysqli_fetch_row($cmd_value)) {
            ?>
            <option value="<?=$data_value[0]?>" ><?=$data_value[0]?></option>
            <?php
          }
          ?>
        </select> 
        <input  id="search" name="search" type="button" value="Search" onclick="search_value();"/>
      </div> <div class="right">

      <div class="right button14" style="width:50px;" onClick="location='campaign.php?kind=add'">Add</div>
    </div>
  </div>

<p class="clear"></p>
<table class="list_table">
  <tr>
    <th onClick="" >Date</th>
    <th onClick="" >Email</th>
    <th onClick="" >Company</th>    
    <th onClick="" >Name</th>
    <th onClick="" >Region</th>
    <th onClick="" >Newsletter Subscription</th>
    <th onClick="" >Name</th>
    <th></th>
  </tr>
  <?php
  if($kind=="search"){
    if(isset($_GET['source'])){
      $source=filter_var($_GET['source']);
    }else{
      $source="";
    }
    $str2="SELECT ID, Name, Company, Mail, Region, Type, Newsletter_Subscription, Source, C_DATE FROM downloadcatalog WHERE Source='".$source."' ORDER BY C_DATE DESC limit ".$start_num.",".$read_num;
  }else{
    $str2="SELECT ID, Name, Company, Mail, Region, Type, Newsletter_Subscription, Source,C_DATE FROM downloadcatalog WHERE 1 ORDER BY C_DATE DESC limit ".$start_num.",".$read_num;
  }
  $list2 =mysqli_query($link_db,$str2);
  while ($data = mysqli_fetch_row($list2)) {
  ?>
    <tr>
    <td><?=$data[8]?></td>
    <td><?=$data[3]?></td>        
    <td><?=$data[2]?></td>
    <td><?=$data[1]?></td>
    <td><?=$data[4]?></td>
    <td><?=$data[6]?></td>
    <td><?=$data[7]?></td>
    <td><input id="Del" name="Del" type="button" value="Delete" onclick="Del(<?=$data[0]?>)"  /></td> 
  </tr>
  <?php
  }
  ?>
  
</table>      
<!--end of datatable--> 

</div>
<p class="clear">&nbsp;</p>

<div id="footer"> Copyright &copy; 2013 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
<script type="text/javascript">
function search(){
  var search = document.getElementById("s_mail").value;
  var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
  if(search_str.test(search)){

  }else{
    alert("Please enter a valid email.");
    exit;
  }
  document.location.href="campaign.php?kind=search&mail="+search;
}
function MM_o(selObj){
  window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
}

function Del(i){
  var ID=i
  document.location.href="campaign.php?kind=del&ID="+ID;
}

function search_value(){
  self.location ="?kind=search&source=" + document.getElementById('se_value').value;
  return false;
}
</script>
<script type="text/javascript" src="../lib/calendar.js"></script>

</script>
</body>
</html>
