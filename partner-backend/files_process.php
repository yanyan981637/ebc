<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
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
  //$str = str_replace("declare","",$str);
  //$str = str_replace("select","",$str);
  //$str = str_replace("create","",$str);
  //$str = str_replace("delete","",$str);
  //$str = str_replace("insert","",$str);
  $str = str_replace("'","&#39;",$str);
  $str = str_replace('"',"&quot;",$str);
//$str = str_replace(".","",$str);
//$str = str_replace("or","",$str);
  //$str = str_replace("=","",$str);
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

include("countryCodeReplace.php");

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="addType"){
  if($_POST['addType']!=""){
    $addType=dowith_sql($_POST['addType']);
    $addType=filter_var($addType);
  }else{
    $addType="";
    echo "Type null";
    exit;
  }

  $str="SELECT * FROM `partner_files_type` WHERE FileType='".$addType."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0)
  {
    echo "repeated";
    mysqli_close($link_db);
    exit();
  }

  $insert="INSERT INTO partner_files_type (FileType, C_DATE) VALUES ('".$addType."', '".$now."')";
  if(mysqli_query($link_db,$insert)<1)
  {
    echo " Insert error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editToValue"){
  if($_POST['EditTypeID']!=""){
    $EditTypeID=trim(dowith_sql($_POST['EditTypeID']));
    $EditTypeID=filter_var($EditTypeID);
  }else{
    $EditTypeID="";
  }

  $str="SELECT ID, FileType FROM partner_files_type WHERE ID='".$EditTypeID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  echo $data[1];
  mysqli_close($link_db);
  exit();
}

if($kind=="editType"){
  if($_POST['Edit_TypeID']!=""){
    $EditTypeID=trim(dowith_sql($_POST['Edit_TypeID']));
    $EditTypeID=filter_var($EditTypeID);
  }else{
    $EditTypeID="";
  }
  if($_POST['edit_type']!=""){
    $edit_type=dowith_sql($_POST['edit_type']);
    $edit_type=filter_var($edit_type);
  }else{
    $edit_type="";
    echo "Type null";
    exit();
  }
  $str="SELECT * FROM `partner_files_type` WHERE FileType='".$edit_type."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0)
  {
    echo "repeated";
    mysqli_close($link_db);
    exit();
  }

  $update="UPDATE partner_files_type SET FileType='".$edit_type."' WHERE ID='".$EditTypeID."'";
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

if($kind=="addFile"){

  if($_POST['Name']!=""){
    $Name=trim(dowith_sql($_POST['Name']));
    $Name=filter_var($Name);
  }else{
    $Name="";
  }
  if($_POST['sel_type']!=""){
    $sel_type=trim(dowith_sql($_POST['sel_type']));
    $sel_type=filter_var($sel_type);
  }else{
    $sel_type="";
  }
  if($_POST['Des']!=""){
    $Des=dowith_sql($_POST['Des']);
    $Des=filter_var($Des);
  }else{
    $Des="";
  }
  if($_POST['Fsize']!=""){
    $Fsize=dowith_sql($_POST['Fsize']);
    $Fsize=filter_var($Fsize);
  }else{
    $Fsize="";
  }
  if($_POST['Fdate']!=""){
    $Fdate=dowith_sql($_POST['Fdate']);
    $Fdate=filter_var($Fdate);
  }else{
    $Fdate="";
  }
  if($_POST['ImageURL']!=""){
    $ImageURL=dowith_sql($_POST['ImageURL']);
    $ImageURL=filter_var($ImageURL);
  }else{
    $ImageURL="";
  }
  if($_POST['DownloadURL']!=""){
    $DownloadURL=dowith_sql($_POST['DownloadURL']);
    $DownloadURL=filter_var($DownloadURL);
  }else{
    $DownloadURL="";
  }
  if($_POST['status']!=""){
    $status=dowith_sql($_POST['status']);
    $status=filter_var($status);
  }else{
    $status="";
  }
  if($_POST['ToWho']!=""){
    $ToWho=dowith_sql($_POST['ToWho']);
    $ToWho=filter_var($ToWho);
  }else{
    $ToWho="";
  }

  $insert="INSERT partner_files (Name, FileType, Description, FormatSize, FileDate, ImageURL, DownloadURL, Status, ToWho, C_DATE)";
  $insert.=" VALUES ('".$Name."', '".$sel_type."', '".$Des."', '".$Fsize."', '".$Fdate."', '".$ImageURL."', '".$DownloadURL."', '".$status."', '".$ToWho."', '".$now."')";
  if(mysqli_query($link_db,$insert)<1)
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


if($kind=="editFile"){
  if($_POST['FileID']!=""){
    $FileID=trim(dowith_sql($_POST['FileID']));
    $FileID=filter_var($FileID);
  }else{
    $FileID="";
  }

  if($_POST['Name']!=""){
    $Name=trim(dowith_sql($_POST['Name']));
    $Name=filter_var($Name);
  }else{
    $Name="";
  }
  if($_POST['sel_type']!=""){
    $sel_type=trim(dowith_sql($_POST['sel_type']));
    $sel_type=filter_var($sel_type);
  }else{
    $sel_type="";
  }
  if($_POST['Des']!=""){
    $Des=dowith_sql($_POST['Des']);
    $Des=filter_var($Des);
  }else{
    $Des="";
  }
  if($_POST['Fsize']!=""){
    $Fsize=dowith_sql($_POST['Fsize']);
    $Fsize=filter_var($Fsize);
  }else{
    $Fsize="";
  }
  if($_POST['Fdate']!=""){
    $Fdate=dowith_sql($_POST['Fdate']);
    $Fdate=filter_var($Fdate);
  }else{
    $Fdate="";
  }
  if($_POST['ImageURL']!=""){
    $ImageURL=dowith_sql($_POST['ImageURL']);
    $ImageURL=filter_var($ImageURL);
  }else{
    $ImageURL="";
  }
  if($_POST['DownloadURL']!=""){
    $DownloadURL=dowith_sql($_POST['DownloadURL']);
    $DownloadURL=filter_var($DownloadURL);
  }else{
    $DownloadURL="";
  }
  if($_POST['status']!=""){
    $status=dowith_sql($_POST['status']);
    $status=filter_var($status);
  }else{
    $status="";
  }
  if($_POST['ToWho']!=""){
    $ToWho=dowith_sql($_POST['ToWho']);
    $ToWho=filter_var($ToWho);
  }else{
    $ToWho="";
  }

  $update="UPDATE partner_files SET Name='".$Name."', FileType='".$sel_type."', Description='".$Des."', FormatSize='".$Fsize."', FileDate='".$Fdate."', ImageURL='".$ImageURL."', DownloadURL='".$DownloadURL."', Status='".$status."', ToWho='".$ToWho."', U_DATE='".$now."' WHERE ID='".$FileID."'";
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

if($kind=="DeleteFile"){
  if($_POST['FileID']!=""){
    $FileID=trim(dowith_sql($_POST['FileID']));
    $FileID=filter_var($FileID);
  }else{
    $FileID="";
  }

  $str="DELETE FROM partner_files WHERE ID='".$FileID."'";
  mysqli_query($link_db,$str);
  if(mysqli_affected_rows($link_db)<1)
  {
    echo "Delete file error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="DeleteType"){
  if($_POST['TypeID']!=""){
    $TypeID=trim(dowith_sql($_POST['TypeID']));
    $TypeID=filter_var($TypeID);
  }else{
    $TypeID="";
  }
  $str="DELETE FROM partner_files_type WHERE ID='".$TypeID."'";
  mysqli_query($link_db,$str);
  if(mysqli_affected_rows($link_db)<1)
  {
    echo "Delete Type error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

mysqli_close($link_db);
exit();
?>