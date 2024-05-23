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
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);*/
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


if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
$now1=date("Y/m/d");

if($kind=="addAnn"){
  if($_POST['title']!=""){
    $title=dowith_sql($_POST['title']);
    $title=filter_var($title);
  }else{
    $title="";
  }
  if($_POST['release']!=""){
    $release=dowith_sql($_POST['release']);
    $release=filter_var($release);
  }else{
    $release="";
  }
  if($_POST['schedule']!=""){
    $schedule=dowith_sql($_POST['schedule']);
    $schedule=filter_var($schedule);
  }else{
    $schedule="";
  }
  if($_POST['message']!=""){
    //$message=dowith_sql($_POST['message']);
    $message=filter_var($_POST['message']);
  }else{
    $message="";
  }
  if($_POST['sel_status']!=""){
    $sel_status=dowith_sql($_POST['sel_status']);
    $sel_status=filter_var($sel_status);
  }else{
    $sel_status="";
  }

  $insert="INSERT INTO partner_announcement (Title, ReleaseTo, Schedule, Message, Status, C_DATE) VALUES ('".$title."', '".$release."', '".$schedule."', '".$message."', '".$sel_status."', '".$now."')";
  if(mysqli_query($link_db,$insert)<1)
  {
    echo "insert error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editAnn"){
  if($_POST['editID']!=""){
    $editID=dowith_sql($_POST['editID']);
    $editID=filter_var($editID);
  }else{
    $editID="";
  }
  if($_POST['title']!=""){
    $title=dowith_sql($_POST['title']);
    $title=filter_var($title);
  }else{
    $title="";
  }
  if($_POST['release']!=""){
    $release=dowith_sql($_POST['release']);
    $release=filter_var($release);
  }else{
    $release="";
  }
  if($_POST['schedule']!=""){
    $schedule=dowith_sql($_POST['schedule']);
    $schedule=filter_var($schedule);
  }else{
    $schedule="";
  }
  if($_POST['message']!=""){
    //$message=dowith_sql($_POST['message']);
    $message=filter_var($_POST['message']);
  }else{
    $message="";
  }
  if($_POST['sel_status']!=""){
    $sel_status=dowith_sql($_POST['sel_status']);
    $sel_status=filter_var($sel_status);
  }else{
    $sel_status="";
  }

  $update="UPDATE partner_announcement SET Title='".$title."', ReleaseTo='".$release."', Schedule='".$schedule."', Message='".$message."', Status='".$sel_status."', U_DATE='".$now."' WHERE ID='".$editID."'";
  if(mysqli_query($link_db,$update)<1)
  {
    echo "Update error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="Delete"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  
  $delete="DELETE FROM partner_announcement WHERE ID='".$ID."'";
  if(mysqli_query($link_db,$delete)<1)
  {
    echo "Delete error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}
?>