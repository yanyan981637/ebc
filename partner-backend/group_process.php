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

if($kind=="selSKU"){
  if($_POST['ID']!=""){ // SKU ID
    $SKUID=dowith_sql($_POST['ID']);
    $SKUID=filter_var($SKUID);
  }else{
    $SKUID="";
  }
  if($_POST['CID']!=""){ // Company ID
    $companyID=dowith_sql($_POST['CID']);
    $companyID=filter_var($companyID);
  }else{
    $companyID="";
  }
  $tmpCID=explode(",", $companyID);

  $strCID="SELECT DISTINCT CompanyID, CompanyName FROM partner_user WHERE 1";
  $cmdCID=mysqli_query($link_db,$strCID);
  while($dataCID=mysqli_fetch_row($cmdCID)) {
    $arrCompany[$dataCID[0]]=$dataCID[1];
  }

  $strSKU="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ID='".$SKUID."'";
  $cmdSKU=mysqli_query($link_db,$strSKU);
  $dataSKU=mysqli_fetch_row($cmdSKU);
  $SKU=$dataSKU[2];

  $content="";
  //$strCompany="SELECT Company FROM partner_projects_client a INNER JOIN partner_projects_items_client b ON a.QT_ID=b.QT_ID WHERE b.Products='".$SKU."'";
  $strCompany="SELECT a.CompanyID FROM partner_myproducts a WHERE a.SKU='".$SKU."'";
  $cmdCompany=mysqli_query($link_db,$strCompany);
  while($dataCompany=mysqli_fetch_row($cmdCompany)) {
    $status="";
    $cid=$dataCompany[0]; // company ID
    if($companyID!=""){
      foreach ($tmpCID as $key => $value) {
        if($value!=""){
          if($cid==$value){
            $status="checked";
          }
        }
      }
    }
    $content.="<fieldset class='checkboxsas'><label><input id='CID' name='CID' type='checkbox' value='".$cid."' ".$status." > ".$arrCompany[$cid]." (".$cid.")</label></fieldset>";
  }
  echo $content;
  mysqli_close($link_db);
  exit();
}

if($kind=="addFile"){
  if($_POST['checkboxID']!=""){ // SKU ID
    $checkboxID=dowith_sql($_POST['checkboxID']);
    $checkboxID=filter_var($checkboxID);
  }else{
    $checkboxID="";
  }

  $tmp=explode(",", $checkboxID);
  $filecontent="";
  foreach ($tmp as $key => $value) {

    if($value!=""){
      $strFile="SELECT a.ID, a.Name, a.FileType, b.ID, b.FileType FROM partner_files a INNER JOIN partner_files_type b ON a.FileType=b.ID WHERE a.ID='".$value."'";
      $cmdFile =mysqli_query($link_db,$strFile);
      $dataFile = mysqli_fetch_row($cmdFile);
      $filecontent.="<p>".$dataFile[1]." (".$dataFile[4].")</p>";
    }
  }

  echo $filecontent;
  mysqli_close($link_db);
  exit();
}

if($kind=="addGroup"){
  if($_POST['SKUID']!=""){
    $SKUID=dowith_sql($_POST['SKUID']);
    $SKUID=filter_var($SKUID);
  }else{
    $SKUID="";
  }
  if($_POST['companyID']!=""){
    $companyID=dowith_sql($_POST['companyID']);
    $companyID=filter_var($companyID);
  }else{
    $companyID="";
  }
  if($_POST['FileID']!=""){
    $FileID=dowith_sql($_POST['FileID']);
    $FileID=filter_var($FileID);
  }else{
    $FileID="";
  }

  $strSKU="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ID='".$SKUID."'";
  $cmdSKU=mysqli_query($link_db,$strSKU);
  $dataSKU=mysqli_fetch_row($cmdSKU);
  $SKU=$dataSKU[2];

  $ToWHO="";
  $strTOWHO="SELECT ID FROM partner_myproducts WHERE SKU='".$SKU."' AND FIND_IN_SET(CompanyID, '".$companyID."')";
  $cmdTOWHO=mysqli_query($link_db,$strTOWHO);
  while ($dataTOWHO=mysqli_fetch_row($cmdTOWHO)) {
    $ToWHO.=$dataTOWHO[0].",";
  }

  $strFILE="SELECT ID, ToWho FROM partner_files WHERE FIND_IN_SET(ID, '".$FileID."')";
  $cmdFILE=mysqli_query($link_db,$strFILE);
  while ($dataFILE=mysqli_fetch_row($cmdFILE)) {
    $ToWHO1="";
    $FILEDID=$dataFILE[0];
    if(strpos($ToWHO,$dataFILE[1]) !== false){
      $ToWHO1=$ToWHO;
    }else{
      $ToWHO1=$dataFILE[1].$ToWHO;
    }
    $upFILE="UPDATE partner_files SET ToWho='".$ToWHO1."' WHERE ID='".$FILEDID."'";
    mysqli_query($link_db,$upFILE);
  }

  $Insert="INSERT INTO partner_files_group (SKU, FileID, CompanyID, C_DATE) VALUES ('".$SKU."', '".$FileID."', '".$companyID."', '".$now."')";
  if(mysqli_query($link_db,$Insert)<1)
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

if($kind=="delGroup"){
  if($_POST['FileID']!=""){
    $FileID=dowith_sql($_POST['FileID']);
    $FileID=filter_var($FileID);
  }else{
    $FileID="";
  }

  $Delete="DELETE FROM partner_files_group WHERE ID='".$FileID."'";
  if(mysqli_query($link_db,$Delete)<1)
  {
    echo "delete error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editGroup"){
  if($_POST['GroupID']!=""){
    $GroupID=dowith_sql($_POST['GroupID']);
    $GroupID=filter_var($GroupID);
  }else{
    $GroupID="";
  }
  if($_POST['SKUID']!=""){
    $SKUID=dowith_sql($_POST['SKUID']);
    $SKUID=filter_var($SKUID);
  }else{
    $SKUID="";
  }
  if($_POST['companyID']!=""){
    $companyID=dowith_sql($_POST['companyID']);
    $companyID=filter_var($companyID);
  }else{
    $companyID="";
  }
  if($_POST['FileID']!=""){
    $FileID=dowith_sql($_POST['FileID']);
    $FileID=filter_var($FileID);
  }else{
    $FileID="";
  }

  $strSKU="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ID='".$SKUID."'";
  $cmdSKU=mysqli_query($link_db,$strSKU);
  $dataSKU=mysqli_fetch_row($cmdSKU);
  $SKU=$dataSKU[2];

  $ToWHO="";
  $strTOWHO="SELECT ID FROM partner_myproducts WHERE SKU='".$SKU."' AND FIND_IN_SET(CompanyID, '".$companyID."')";
  $cmdTOWHO=mysqli_query($link_db,$strTOWHO);
  while ($dataTOWHO=mysqli_fetch_row($cmdTOWHO)) {
    $ToWHO.=$dataTOWHO[0].",";
  }

  $strFILE="SELECT ID, ToWho FROM partner_files WHERE FIND_IN_SET(ID, '".$FileID."')";
  $cmdFILE=mysqli_query($link_db,$strFILE);
  while ($dataFILE=mysqli_fetch_row($cmdFILE)) {
    $ToWHO1="";

    $FILEDID=$dataFILE[0];
    if(strpos($ToWHO,$dataFILE[1]) !== false){
      $ToWHO1=$ToWHO;
    }else{
      $ToWHO1=$dataFILE[1].$ToWHO;
    }
    //$ToWHO1=$dataFILE[1].$ToWHO;
    $upFILE="UPDATE partner_files SET ToWho='".$ToWHO1."' WHERE ID='".$FILEDID."'";
    mysqli_query($link_db,$upFILE);
  }

  $Update="UPDATE partner_files_group SET SKU='".$SKU."', FileID='".$FileID."', CompanyID='".$companyID."', U_DATE='".$now."' WHERE ID='".$GroupID."'";
  if(mysqli_query($link_db,$Update)<1)
  {
    echo "update error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
}


?>