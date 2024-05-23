<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/404.htm'</script>";
  exit;
}

error_reporting(0);

session_start();
if($_SESSION['user']=="" || $_SESSION['ID']==""){
  echo "<script language='javascript'>self.location='login'</script>";
  exit;
}

require "../config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  /*$str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);*/
  $str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
  $str = str_replace("'","&#39;",$str);
  $str = str_replace('"',"&quot;",$str);
//$str = str_replace(".","",$str);
//$str = str_replace("or","",$str);
  $str = str_replace("=","",$str);
  $str = str_replace("?","",$str);
  $str = str_replace("%","",$str);
  $str = str_replace("0x02BC","",$str);
//$str = str_replace("%20","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  $str = str_replace("<style>","",$str);
  $str = str_replace("</style>","",$str);
  $str = str_replace("<img>","",$str);
  $str = str_replace("</img>","",$str);
  $str = str_replace("<a>","",$str);
  $str = str_replace("</a>","",$str);
  return $str;
}

function arrayToString($arr) {
  if (is_array($arr)){
    return implode(',', array_map('arrayToString', $arr));
  }
  return $arr;
}

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="AddMapping"){
  if($_POST['country']!=""){
    $country=dowith_sql($_POST['country']);
    $country=arrayToString($_POST['country']);
    $country=filter_var($country);
  }else{
    $country="";
  }
  if($_POST['sales']!=""){
    $sales=trim(dowith_sql($_POST['sales']));
    $sales=filter_var($sales);
  }else{
    $sales="";
  }

  $add_mapping="INSERT INTO `partner_mapping` (Sales, CountryCode, C_DATE) VALUES ('".$sales."', '".$country."', '".$now."')";
  if(mysqli_query($link_db,$add_mapping)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="EditMapping"){
  if($_POST['editID']!=""){
    $editID=dowith_sql($_POST['editID']);
    $editID=filter_var($editID);
  }else{
    $country="";
  }
  if($_POST['sales']!=""){
    $sales=trim(dowith_sql($_POST['sales']));
    $sales=filter_var($sales);
  }else{
    $sales="";
  }
  if($_POST['country']!=""){
    $country=dowith_sql($_POST['country']);
    $country=arrayToString($_POST['country']);
    $country=filter_var($country);
  }else{
    $country="";
  }
  if($_POST['sales']!=""){
    $sales=trim(dowith_sql($_POST['sales']));
    $sales=filter_var($sales);
  }else{
    $sales="";
  }

  $edit_mapping="UPDATE `partner_mapping` SET Sales='".$sales."', CountryCode='".$country."', U_DATE='".$now."' WHERE ID='".$editID."'";
  if(mysqli_query($link_db,$edit_mapping)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="Del"){
  if($_POST['DelID']!=""){
    $DelID=dowith_sql($_POST['DelID']);
    $DelID=filter_var($DelID);
  }else{
    $DelID="";
  }
  
  $delete_mapping="DELETE FROM `partner_mapping` WHERE ID='". $DelID."'";
//$cmd=mysqli_query($link_db,$add_mapping);
  if(mysqli_query($link_db,$delete_mapping)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

?>