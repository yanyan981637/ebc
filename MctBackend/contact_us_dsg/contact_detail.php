<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

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

if(isset($_REQUEST['view_id'])!=""){
  $view1=intval($_REQUEST['view_id']);
  $str1 = "select ID, NAME, COMPANYNAME, EMAIL, PHONE, REGION, ProductType, Type, MESSAGE, CREATEDATE FROM contact_us_new where ID=".$view1;
  $result =mysqli_query($link_db,$str1);
  $contact_data = mysqli_fetch_row($result);
}

$reg = $contact_data[6];
$type = $contact_data[7];

if($reg == "en-US"){
  $reg = "United States";
}else if($reg == "SA"){
  $reg = "Central / South America";
}else if($reg == "EUR"){
  $reg = "Europe";
}else if($reg == "ME"){
  $reg = "Middle East / Africa";
}else if($reg == "ASIA"){
  $reg = "Asia";
}

if($type=="enquiry"){
  $type="Enquiry";
}else if($type == "TS"){
  $type = "Technical Support";
}else if($type == "other"){
  $type = "Others";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Us - <?=$contact_data[0]?></title>
<link rel=stylesheet type="text/css" href="../backend.css">
<style type="text/css">
body{padding:30px 50px; backbround:#fff}
</style>
</head>

<body>
<h1>Contact Us - <?=$contact_data[0]?>&nbsp;<?=$contact_data[7]?></h1>
<div class="box">
<table class="addspec" style="width:100%">
	<tbody >
	<tr ><th style="width:160px"> Name: </th>
	<td>
    <?=$contact_data[1]?>
	</td>
	</tr>
	<tr ><th >Company Name:</th>
	<td>
	<?=$contact_data[2]?>
	</td>
	</tr>
	<tr ><th >Email:</th>
	<td>
	<?=$contact_data[3]?>
	</td>
	</tr>
	<tr ><th >Phone:</th>
	<td>
	<?=$contact_data[4]?>
	</td>
	</tr>
	<tr ><th >Region:</th>
	<td>
	<?=$reg?>
	</td>
	</tr>
	<tr ><th >Product Type:</th>
	<td>
	<?=$contact_data[5]?>
	</td>
	</tr>
	<tr ><th >Request Type:</th>
	<td>
	<?=$type?>
	</td>
	</tr>
	<tr ><th >Message:</th>
	<td>
	<?=$contact_data[8]?>
	</td>
	</tr>
	
	</tbody>
	</table>
</div>

<p class="clear"></p>

</body>
</html>
