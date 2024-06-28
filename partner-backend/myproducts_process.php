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

$ID=$_SESSION['ID'];

if($kind=="AddPR"){
  if($_POST['company']!=""){
    $company=dowith_sql($_POST['company']);
    $company=filter_var($company);
  }else{
    $company="";
  }
  if($_POST['product']!=""){
    $product=dowith_sql($_POST['product']);
    $product=filter_var($product);
  }else{
    $product="";
  }
  //$str_model="SELECT SKU, Model FROM partner_model WHERE ID='".$product."'";
  $str_model="SELECT SKU, Model, CATEGORY_NAME, MiTAC_PN FROM partner_model WHERE ID='".$product."'";
  $cmd_model=mysqli_query($link_db,$str_model);
  $model=mysqli_fetch_row($cmd_model);
  if($model[0]==""){
      $str="INSERT INTO partner_myproducts (CompanyID, ModelID, CATEGORY_NAME, MiTAC_PN, SalesID, C_DATE) VALUES ('".$company."', '".$product."', '".$model[2]."', '".$model[3]."','".$ID."', '".$now."')";
  }else{
      $str="INSERT INTO partner_myproducts (CompanyID, ModelID, Model, SKU, SalesID, C_DATE) VALUES ('".$company."', '".$product."', '".$model[1]."', '".$model[0]."','".$ID."', '".$now."')";
  }
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);
  if($result>0){
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{
    echo "Insert my product error";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="EditPR"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  if($_POST['company']!=""){
    $company=dowith_sql($_POST['company']);
    $company=filter_var($company);
  }else{
    $company="";
  }
  if($_POST['product']!=""){
    $product=dowith_sql($_POST['product']);
    $product=filter_var($product);
  }else{
    $product="";
  }

  $str_model="SELECT SKU, Model, CATEGORY_NAME, MiTAC_PN FROM partner_model WHERE ID='".$product."'";
  $cmd_model=mysqli_query($link_db,$str_model);
  $model=mysqli_fetch_row($cmd_model);
  if($model[0]==""){
    $str="UPDATE partner_myproducts SET CompanyID='".$company."', ModelID='".$product."', CATEGORY_NAME='".$model[2]."', MiTAC_PN='".$model[3]."', SalesID='".$ID."', U_DATE='".$now."' WHERE ID='".$ID."'";
  }else{
    $str="UPDATE partner_myproducts SET CompanyID='".$company."', ModelID='".$product."', Model='".$model[1]."', SKU='".$model[0]."', SalesID='".$ID."', U_DATE='".$now."' WHERE ID='".$ID."'";
  }
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);
  if($result>0){
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{
    echo "Insert my product error";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="DelPR"){
  if($_POST['prid']!=""){
    $prid=trim(dowith_sql($_POST['prid']));
    $prid=filter_var($prid);
  }else{
    $prid="";
  }

  $str="DELETE FROM partner_myproducts WHERE ID='".$prid."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);
  if($result>0){
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{
    echo "Delete my products error";
    mysqli_close($link_db);
    exit();
  }
}
?>