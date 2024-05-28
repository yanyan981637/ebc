<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header('Content-Type: text/html; charset=utf-8');
header("Cache-control: private");

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}


require "./config.php";
$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

session_cache_limiter('private, must-revalidate');
session_start();


if(isset($_SESSION["Checknum"])!=''){
  if($_SESSION["Checknum"]==$_POST['Checknum1'] ){
 }else{ 
   echo "Wrong Security Code! Please enter again.";  
   exit(); 
 }
}

function dowith_sql($str)
{
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);
  //$str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  $str = str_replace("select","",$str);
  $str = str_replace("create","",$str);
  $str = str_replace("delete","",$str);
  $str = str_replace("insert","",$str);
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


if($_POST['name']!=""){
  $name=dowith_sql($_POST['name']);
  $name=filter_var($name);
}else{
  $name="";
}
if($_POST['company']!=""){
  $company=dowith_sql($_POST['company']);
  $company=filter_var($company);
}else{
  $company="";
}
if($_POST['mail']!=""){
  $mail=dowith_sql($_POST['mail']);
  $mail=filter_var($mail);
}else{
  $mail="";
}
if($_POST['region']!=""){
  $region=dowith_sql($_POST['region']);
  $region=filter_var($region);
}else{
  $region="";
}
if($_POST['type']!=""){
  $type=dowith_sql($_POST['type']);
  $type=filter_var($type);
  if($type=="c"){
  	$type="CBU";
  }else{
  	$type="EBU";
  }
}else{
  $type="";
}
if($_POST['News_S']!=""){
  $News_S=dowith_sql($_POST['News_S']);
  $News_S=filter_var($News_S);
}else{
  $News_S="";
}
if($_POST['cateName']!=""){
  $cateName=dowith_sql($_POST['cateName']);
  $cateName=filter_var($cateName);
}else{
  $cateName="";
}
$str_inst_sq="INSERT INTO downloadcatalog(Name, Company, Mail, Region, Type, Newsletter_Subscription, Source, C_DATE)";
$str_inst_sq.=" VALUES ('".$name."','".$company."','".$mail."','".$region."','".$type."','".$News_S."','".$cateName."','".$now."')";
$cmd_sq=mysqli_query($link_db,$str_inst_sq);
$result=mysqli_affected_rows($link_db);  
if($result>0){  
 echo "success";
 exit();
}else{  
	echo "Insert download catalog error";
	mysqli_close($link_db);
	exit();
}
