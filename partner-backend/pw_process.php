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
 // $str = str_replace("delete","",$str);
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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_POST['UID']!=""){
  $UID=dowith_sql($_POST['UID']);
  $UID=filter_var($UID);
}else{
  $UID="";
}
if($_POST['PW1']!=""){
  $PW1=dowith_sql($_POST['PW1']);
  $PW1=filter_var($PW1);
}else{
  $PW1="";
}
if($_POST['PW2']!=""){
  $PW2=dowith_sql($_POST['PW2']);
  $PW2=filter_var($PW2);
}else{
  $PW2="";
}

$str="SELECT ID, NAME, EMAIL, Role, PassWord, First FROM partner_sales WHERE ID='".$UID."'";
$cmd=mysqli_query($link_db,$str);
$data=mysqli_fetch_row($cmd);

if($data[5]=="1"){
  if($data[4]==$PW1){
    echo "N";
    mysqli_close($link_db);
    exit();
  }
}else{
  $O_PW=$data[4];
  if (password_verify($PW1, $O_PW)) {
    echo "N";
    mysqli_close($link_db);
    exit();
  }
}
$hash = password_hash($PW1, PASSWORD_DEFAULT);
$str="UPDATE partner_sales SET PassWord='".$hash."', U_DATE='".$now."', First='0' WHERE ID='".$UID."'";
$cmd=mysqli_query($link_db,$str);
$result=mysqli_affected_rows($link_db);  
if($result>0){
  echo "success";
  mysqli_close($link_db);
  exit();  
}else{  
  echo "Update error";
  mysqli_close($link_db);
  exit();
}
?>
