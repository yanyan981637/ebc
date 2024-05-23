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

//************* loadind count *******************
$s_ID="";$s_Name="";$s_Email="";$s_Email="";$s_cName="";$s_date1="";$s_date2="";$s_reg="";
$s_ptype="";

if(isset($_REQUEST['s_ID'])!=''){
  $s_ID=trim($_REQUEST['s_ID']);
  $str1 = "select count(*) FROM contact_us_new WHERE ID = '".$s_ID."' Order by CREATEDATE";
}elseif (isset($_REQUEST['s_Name'])!='') {
  $s_Name=trim($_REQUEST['s_Name']);
  $str1 = "select count(*) FROM contact_us_new WHERE NAME = '".$s_Name."' Order by CREATEDATE";
}elseif (isset($_REQUEST['s_Email'])!='') {
  $s_Email=trim($_REQUEST['s_Email']);
  $str1 = "select count(*) FROM contact_us_new WHERE EMAIL = '".$s_Email."' Order by CREATEDATE";
}elseif (isset($_REQUEST['s_cName'])!='') {
  $s_cName=trim($_REQUEST['s_cName']);
  $str1 = "select count(*) FROM contact_us_new WHERE COMPANYNAME = '".$s_cName."' Order by CREATEDATE";
}elseif (isset($_REQUEST['s_date1'])!='' && isset($_REQUEST['s_date2'])!='') {
  $s_date1=trim($_REQUEST['s_date1']);
  $s_date2=trim($_REQUEST['s_date2']);
  $str1 = "select count(*) FROM contact_us_new WHERE CREATEDATE BETWEEN '".$s_date1." 00:00:00' AND '".$s_date2." 00:00:00' Order by CREATEDATE";
}elseif (isset($_REQUEST['s_reg'])!='') {
  $s_reg=trim($_REQUEST['s_reg']);
  if ($_REQUEST['s_reg']=='all') {
    $str1 = "select count(*) FROM contact_us_new WHERE 1 Order by CREATEDATE";
  }else{
    $str1 = "select count(*) FROM contact_us_new WHERE REGION = '".$s_reg."' Order by CREATEDATE";
  }
}elseif (isset($_REQUEST['s_ptype'])!='') {
  $s_ptype=trim($_REQUEST['s_ptype']);
  switch ($s_ptype) {
    case "Embedded":
      $s_ptype="Embedded";
      break;
    case "HGS":
      $s_ptype="HPC / GPGPU Server";
      break;
    case "CCP":
      $s_ptype="Cloud Computing Platform";
      break;
    case "SSP":
      $s_ptype="Storage Server Platform";
      break;
    case "SP":
      $s_ptype="Storage Platform";
      break;
    case "NS":
      $s_ptype="Network Solution";
      break; 
    case "DC":
      $s_ptype="Data Center";
      break;
    case "OCP":
      $s_ptype="OCP";
      break;
    default:
  }
  $str1 = "select count(*) FROM contact_us_new WHERE `ProductType`='".$s_ptype."' Order by CREATEDATE";
}else{
  $str1 = "select count(*) FROM contact_us_new WHERE 1 Order by CREATEDATE";
}

//************* loadind count end *******************

$list1 =mysqli_query($link_db,$str1);
list($public_count) = mysqli_fetch_row($list1);

$read_num="20";
$all_page=ceil($public_count/$read_num);
$pageSize=$page;
$total=$all_page;
pageft($total,$pageSize,1,0,0,15);       

$demo_url="";
if(isset($_REQUEST['page'])==""){
  $page="1";
}else{
  $page=$_REQUEST['page'];
}      
if(empty($page))$page="1";      
//$read_num="20";
$start_num=$read_num*($page-1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Website Contents Management - Products Management: Products </title>
  <link rel="stylesheet" type="text/css" href="../backend.css" />
  <link rel="stylesheet" type="text/css" href="../css/css.css" />
  <script type="text/javascript" src="../jquery.min.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
  <script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <script language="JavaScript">
  function MM_PT(selObj){
    //window.open(document.getElementById('sel_reg').options[document.getElementById('sel_reg').selectedIndex].value,"_self");
    self.location = "?s_reg=" + document.getElementById('sel_reg').value;
    return false;
  }

    function MM_Tpye(selObj){
    //window.open(document.getElementById('sel_reg').options[document.getElementById('sel_reg').selectedIndex].value,"_self");
    self.location = "?s_ptype=" + document.getElementById('sel_type').value;
    return false;
  }

  function MM_o(selObj){
    window.open(document.getElementById('pskus_page').options[document.getElementById('pskus_page').selectedIndex].value,"_self");
    //self.location = document.getElementById('pskus_page').value;
  }

  function search_value(){
    var stype= document.getElementById('s_type').value;
    self.location ="?" + stype + "=" + document.getElementById('se_value').value;
    return false;
  }

  function search_date(){
    self.location = "?s_date1=" + document.getElementById('date_value01').value + "&s_date2=" + document.getElementById('date_value02').value;
    return false;
  }

/*function Lang_check(){

 var P01 = '<?=$PType_id?>'; 
 var eol = document.getElementsByName('seol'); 
 if (eol[0].checked==true){
  eol = "1";
}else{
  eol = "";
}
var str_lang="";
var lang01 = document.getElementsByName('slang');
for(var i=0;i<lang01.length;i++){
 if(lang01[i].checked==true){	   
  str_lang=str_lang + lang01[i].value + "|";       	   
}
}

self.location="?PType_id=" + P01 + "&slang=" + str_lang + "&seol=" + eol;

} */

function Del_id(t_id){    
  if(confirm("確定要刪除此筆資料嗎?")){
    self.location="?d_id="+t_id;
  }else{
  }
}
var View_id;
function  View_id(t_id){    
  window.open('contact_detail.php?view_id='+t_id);
}

function Export(){    
    window.open('excel.php');
}

</script>
</head>
<body><a name="top"></a>
  <div>
    <div class="left"><h1>&nbsp;&nbsp;MCT Website Backends - Contact Management</h1></div>
    <div id="logout">Hi <?=str_replace("@mic.com.tw", "", $_SESSION['user']);?> <a href="./logo.php">Log out &gt;&gt;</a></div>
  </div>
  <div class="clear"></div>
  <div id="menu">
    <ul>
      <li ><a href="default.php">Contact Us List</a>
      </li>
    </ul>
  </div>
  <div class="clear"></div>
  <p class="clear"></p>
  <div id="content"><h2>Contact Us List:</h2>
    <p class="clear"></p>
    <!--datatable starts here-->
    <div>
      <div class="pagination left">Total: <span class="w14bblue"><?=$public_count;?></span> records &nbsp;&nbsp;| &nbsp;&nbsp;Page: &nbsp;
        <select id="pskus_page" name="pskus_page" onChange="MM_o(this)">
          <?php
          for($j=1;$j<=$total;$j++){
            if($s_ptype!=""){
            ?>
              <option value="?page=<?=$j?>&s_ptype=<?=$s_ptype?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
            <?php
            }elseif(isset($_REQUEST['s_date1'])!='' && isset($_REQUEST['s_date2'])!=''){
            ?>
              <option value="?page=<?=$j?>&s_date1=<?=$s_date1?>&s_date2=<?=$s_date2?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
            <?php            
            }else{
            ?>
              <option value="?page=<?=$j?>&s_search=<?=$s_search?>" <?php if($page==$j){ echo "selected"; } ?>><?=$j?></option>
            <?php
            }
          }
          ?>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <select id="s_type" name="s_type">
          <option>Selete Type</option>
          <option value="s_ID">ID#</option>
          <option value="s_Name">Name</option>
          <option value="s_Email">Email</option>
          <option value="s_cName">Company Name</option>
        </select>
        <input id="se_value" name="se_value" type="text" size="30" value="" />&nbsp;&nbsp;
        <input  id="search" name="search" type="button" value="Search" onclick="search_value();"/>
        &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="date_value01" name="date_value01" type="date" value="<?=$s_date1?>" /> ~ <input id="date_value02" name="date_value02" type="date" value="<?=$s_date2?>" /> 
        <input id="date" name="date" type="button" value="Search" onclick="search_date();" />
        &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;
        <select id="sel_reg" name="sel_reg" onChange="MM_PT(this)">
          <option value="all">All Regions</option>
          <option value="en-US" <?php if($s_reg=="en-US"){ echo "selected"; }?>>United States</option>
          <option value="SA" <?php if($s_reg=="SA"){ echo "selected"; }?>>Central / South America</option>
          <option value="EUR" <?php if($s_reg=="EUR"){ echo "selected"; }?>>Europe</option>
          <option value="ME" <?php if($s_reg=="ME"){ echo "selected"; }?>>Middle East / Africa</option>
          <option value="ASIA" <?php if($s_reg=="ASIA"){ echo "selected"; }?>>Asia</option>
        </select>
        <br>
        <select id="sel_type" name="sel_type" onChange="MM_Tpye(this)">
          <option selected value="">Select Product Type...</option>
          <option value="Embedded">Embedded (Industrial Motherboard/ system/ Panel PC/ Tablet)</option>
          <option value="HGS">HPC / GPGPU Server</option>
          <option value="CCP">Cloud Computing Platform</option>
          <option value="SSP">Storage Server Platform</option>
          <option value="SP">Storage Platform</option>
          <option value="NS">Networking Solution</option>
          <option value="DC">Data Center</option>
          <option value="OCP">OCP</option>
        </select>
      </div>


    </div>
    <p class="clear"></p>
    <form id="form2" name="form2" method="post" action="default.php">
      <table class="list_table">
       <tr>
        <th STYLE="text-decoration:none">ID#</th>
        <th STYLE="text-decoration:none">Date</th>
        <th STYLE="text-decoration:none">E-mail</th>		
        <th STYLE="text-decoration:none">Name</th>
        <th STYLE="text-decoration:none">Company Name</th>
        <th STYLE="text-decoration:none">Region</th>
        <th STYLE="text-decoration:none">Product Type</th>
        <th STYLE="text-decoration:none">Request Type</th>
        <th STYLE="text-decoration:none">Message</th>
        <th STYLE="text-decoration:none">
          <button class="btn-lg btn bg-pink waves-effect" type="button" onclick="Export()">Export All</button>
        </th>
      </tr>
      <?php
      if(isset($_REQUEST['s_ID'])<>''){
        $s_ID=trim($_REQUEST['s_ID']);
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE ID = '".$s_ID."' Order by CREATEDATE DESC limit $start_num,$read_num;";
      }elseif (isset($_REQUEST['s_Name'])<>'') {
        $s_Name=trim($_REQUEST['s_Name']);
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE NAME = '".$s_Name."' Order by CREATEDATE DESC limit $start_num,$read_num;";
      }elseif (isset($_REQUEST['s_Email'])<>'') {
        $s_Email=trim($_REQUEST['s_Email']);
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE EMAIL = '".$s_Email."' Order by CREATEDATE DESC limit $start_num,$read_num;";
      }elseif (isset($_REQUEST['s_cName'])<>'') {
        $s_cName=trim($_REQUEST['s_cName']);
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE COMPANYNAME = '".$s_cName."' Order by CREATEDATE DESC limit $start_num,$read_num;";
      }elseif (isset($_REQUEST['s_date1'])<>'' && isset($_REQUEST['s_date2'])<>'') {
        $s_date1=trim($_REQUEST['s_date1']);
        $s_date2=trim($_REQUEST['s_date2']);
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE CREATEDATE BETWEEN '".$s_date1." 00:00:00' AND '".$s_date2." 00:00:00' Order by CREATEDATE DESC limit $start_num,$read_num;";
      }elseif (isset($_REQUEST['s_reg'])<>'') {
        $s_reg=trim($_REQUEST['s_reg']);
        if ($_REQUEST['s_reg']=='all') {
           $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE 1 Order by CREATEDATE DESC limit $start_num,$read_num;";
        }else{
          $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE REGION = '".$s_reg."' Order by CREATEDATE DESC limit $start_num,$read_num;";
        }
      }elseif (isset($_REQUEST['s_ptype'])!='') {
        $s_ptype=trim($_REQUEST['s_ptype']);
        switch ($s_ptype) {
          case "Embedded":
            $s_ptype="Embedded";
            break;
          case "HGS":
            $s_ptype="HPC / GPGPU Server";
            break;
          case "CCP":
            $s_ptype="Cloud Computing Platform";
            break;
          case "SSP":
            $s_ptype="Storage Server Platform";
            break;
          case "SP":
            $s_ptype="Storage Platform";
            break;
          case "NS":
            $s_ptype="Network Solution";
            break; 
          case "DC":
            $s_ptype="Data Center";
            break;
          case "OCP":
            $s_ptype="OCP";
            break;
          default:
        }
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE `ProductType` LIKE '%".$s_ptype."%' Order by CREATEDATE DESC limit $start_num,$read_num;";
      }else{
        $str_contact = "select ID, NAME, COMPANYNAME, EMAIL, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new WHERE 1 Order by CREATEDATE DESC limit $start_num,$read_num;";
      }

      $result=mysqli_query($link_db,$str_contact);
      while ($contact_data = mysqli_fetch_row($result)) {
        $type=$contact_data[6];
        if($type=="enquiry"){
          $type="Enquiry";
        }else if($type == "TS"){
          $type = "Technical Support";
        }else if($type == "other"){
          $type = "Others";
        }
        ?>
        <tr>
          <td><?=$contact_data[0]?></td>
          <td><?=$contact_data[8]?></td>
          <td><?=$contact_data[3]?></td>
          <td><?=$contact_data[1]?></td>
          <td><?=$contact_data[2]?></td>
          <td><?=$contact_data[4]?></td>
          <td><?=$contact_data[5]?></td>
          <td><?= $type?></td>
          <td><span><?=$contact_data[7]?></span></td>
          <td>
            <input name="View" type="button" value="View" onClick="View_id(<?="$contact_data[0]"?>)" >&nbsp;&nbsp;&nbsp;&nbsp;
            <input type=button name="D_This" value="Delete" onClick="Del_id(<?="$contact_data[0]"?>)">&nbsp;&nbsp;
          </td>
        </tr>
        <?php 
      }
      ?>
      <tr>

        <td colspan="8">
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
  <!--end of datatable-->	
</div>
<p class="clear">&nbsp;</p>
<div id="footer">	Copyright &copy; 2013 Company Co. All rights reserved.<div class="gotop" onClick="location='#top'">Top</div></div>
</body>
</html>