<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/index.html'</script>";
  exit;
}

error_reporting(0);

session_start();
if($_SESSION['FEuser']=="" || $_SESSION['FEID']==""){
  echo "<script language='javascript'>self.location='index.html'</script>";
  exit;
}

require "config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str)
{
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  //$str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);
  $str = str_replace("char","",$str);
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

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="cancelCard"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  $str="UPDATE partner_user SET IndexCard='1' WHERE ID='".$UID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Update Company error";
    mysqli_close($link_db);
    exit();
  }  
}

if($kind=="ann"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['cardID']!=""){
    $cardID=dowith_sql($_POST['cardID']);
    $cardID=filter_var($cardID);
  }else{
    $cardID="";
  }
  $str="SELECT IndexAnn FROM partner_user WHERE ID='".$UID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);  
  if($data[0]==""){
    $up_str="UPDATE partner_user SET IndexAnn='".$cardID."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Noticeboard error";
      mysqli_close($link_db);
      exit();
    }  
  }else{
    $cardID1=$data[0].",".$cardID;
    $up_str="UPDATE partner_user SET IndexAnn='".$cardID1."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Noticeboard error";
      mysqli_close($link_db);
      exit();
    } 
  }
}

if($kind=="anntable"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['IN']!=""){
    $IN=dowith_sql($_POST['IN']);
    $IN=filter_var($IN);
  }else{
    $IN="";
  }
  $content="";
  $str_ann="SELECT ID, Title, ReleaseTo, Schedule, Message, Status, C_DATE FROM partner_announcement WHERE ID NOT IN ('".$IN."')";
  $cmd_ann=mysqli_query($link_db,$str_ann);
  while($data_ann=mysqli_fetch_row($cmd_ann)){
    $content.="
    <tr>
      <td class='grey darken-4'>
        <button type='button' class='close font-large-1' aria-label='Close' onclick=cancelCard('ann',".$data_ann[0].")>
          <span aria-hidden='true'>×</span>
        </button>
        <span class='t-Italic'>".$data_ann[6]."</span>
        <h2>".$data_ann[1]."</h2>
        <p>".$data_ann[4]."</p>
      </td>
    </tr>
    ";
  }
  echo $content;
  mysqli_close($link_db);
  exit();
}

if($kind=="release"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['cardID']!=""){
    $cardID=dowith_sql($_POST['cardID']);
    $cardID=filter_var($cardID);
  }else{
    $cardID="";
  }
  $str="SELECT IndexRelease FROM partner_user WHERE ID='".$UID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);  
  if($data[0]==""){
    $up_str="UPDATE partner_user SET IndexRelease='".$cardID."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Release error";
      mysqli_close($link_db);
      exit();
    }  
  }else{
    $cardID1=$data[0].",".$cardID;
    $up_str="UPDATE partner_user SET IndexRelease='".$cardID1."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Release error";
      mysqli_close($link_db);
      exit();
    } 
  }
}

if($kind=="releasetable"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['IN']!=""){
    $IN=dowith_sql($_POST['IN']);
    $IN=filter_var($IN);
  }else{
    $IN="";
  }
  $content="";
  $str="SELECT ID, Name, FileDate, Status, FileType, ToWho, Description, FileType, FormatSize FROM partner_files WHERE ToWho='All' AND ID NOT IN ('".$IN."')";
  $cmd=mysqli_query($link_db,$str);
  while($data=mysqli_fetch_row($cmd)){
    $content.="
    <tr>
      <td class='grey darken-4'>
        <button type='button' class='close font-large-1' aria-label='Close' onclick=cancelCard('ann',".$data[0].")>
          <span aria-hidden='true'>×</span>
        </button>
        <span class='t-Italic'>".$data[6]."</span>
        <h2>".$data[1]."</h2>
        <p>".$data[4]."</p>
      </td>
    </tr>
    ";
  }
  echo $content;
  mysqli_close($link_db);
  exit();
}

if($kind=="quote"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['cardID']!=""){
    $cardID=dowith_sql($_POST['cardID']);
    $cardID=filter_var($cardID);
  }else{
    $cardID="";
  }
  $str="SELECT IndexQuote FROM partner_user WHERE ID='".$UID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);  
  if($data[0]==""){
    $up_str="UPDATE partner_user SET IndexQuote='".$cardID."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Quote error";
      mysqli_close($link_db);
      exit();
    }  
  }else{
    $cardID1=$data[0].",".$cardID;
    $up_str="UPDATE partner_user SET IndexQuote='".$cardID1."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Quote error";
      mysqli_close($link_db);
      exit();
    } 
  }
}

if($kind=="Quotetable"){

  function sqlin($str){
    if($str!=""){
      $tmp=explode(",", $str);
      $tmp1="";
      foreach ($tmp as $key => $value) {
        if($tmp1=="" ){
          if($value!=""){
            $tmp1=$value;
          }
        }elseif($value!=""){
          $tmp1.="','";
          $tmp1.=$value;
        }
      }
      return $tmp1;
    }
    return $str;
  }

  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['IN']!=""){
    $IN=dowith_sql($_POST['IN']);
    $IN=sqlin($IN);
    $IN=filter_var($IN);
  }else{
    $IN="";
  }
  $content="";
  $tmpQID="";
  $str_quote="SELECT a.ID, a.QT_ID, a.Version, a.C_DATE, b.Products, b.Qty FROM partner_projects_client a INNER JOIN partner_projects_items_client b ON a.QT_ID=b.QT_ID";
  $str_quote.=" WHERE a.Version=b.Version AND a.ID NOT IN ('".$IN."')";
  $cmd_quote=mysqli_query($link_db,$str_quote);
  while ($data_quote=mysqli_fetch_row($cmd_quote)) {
    if($tmpQID==""){
      $tmpQID=$data_quote[1];
      $content.="
      <tr>
      <td class='grey darken-4'>
      <button type='button' class='close font-large-1' aria-label='Close'>
      <span aria-hidden='true' onclick=cancelCard('quote',".$data_quote[0].")>×</span>
      </button>
      <span class='t-Italic'>".$data_quote[3]."</span>
      <h3><a href='#' target='_blank' onclick=window.location.href='FEquoteDetails@".$data_quote[1]."';>".$data_quote[1]."</a></h3>
      <ul>
      <li>".$data_quote[4]." x ".$data_quote[5]."</li>";
    }elseif($tmpQID==$data_quote[1]){
      $content.="<li>".$data_quote[4]." x ".$data_quote[5]."</li>";
    }else{
      $tmpQID=$data_quote[1];
      $content.="
      <ul>
      </td>
      </tr>
      <tr>
      <td class='grey darken-4'>
      <button type='button' class='close font-large-1' aria-label='Close'>
      <span aria-hidden='true' onclick=cancelCard('quote',".$data_quote[0].")>×</span>
      </button>
      <span class='t-Italic'>".$data_quote[3]."</span>
      <h3><a href='#' target='_blank' onclick=window.location.href='FEquoteDetails@".$data_quote[1]."';>".$data_quote[1]."</a></h3>
      <ul>
      <li>".$data_quote[4]." x ".$data_quote[5]."</li>";
    }
  }

  $content.="<ul></td></tr>";
  echo $content;
  mysqli_close($link_db);
  exit();
}

if($kind=="file"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['cardID']!=""){
    $cardID=dowith_sql($_POST['cardID']);
    $cardID=filter_var($cardID);
  }else{
    $cardID="";
  }
  $str="SELECT IndexProduct FROM partner_user WHERE ID='".$UID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);  
  if($data[0]==""){
    $up_str="UPDATE partner_user SET IndexProduct='".$cardID."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Product error";
      mysqli_close($link_db);
      exit();
    }  
  }else{
    $cardID1=$data[0].",".$cardID;
    $up_str="UPDATE partner_user SET IndexProduct='".$cardID1."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Product error";
      mysqli_close($link_db);
      exit();
    } 
  }
}

if($kind=="FGroup"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['cardID']!=""){
    $cardID=dowith_sql($_POST['cardID']);
    $cardID=filter_var($cardID);
  }else{
    $cardID="";
  }
  $str="SELECT IndexFGroup FROM partner_user WHERE ID='".$UID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);  
  if($data[0]==""){
    $up_str="UPDATE partner_user SET IndexFGroup='".$cardID."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Product error";
      mysqli_close($link_db);
      exit();
    }  
  }else{
    $cardID1=$data[0].",".$cardID;
    $up_str="UPDATE partner_user SET IndexFGroup='".$cardID1."' WHERE ID='".$UID."'";
    $up_cmd=mysqli_query($link_db,$up_str);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      echo "success";
      mysqli_close($link_db);
      exit(); 
    }else{  
      echo "Update Product error";
      mysqli_close($link_db);
      exit();
    } 
  }
}

if($kind=="Proucttable"){
  if($_POST['UID']!=""){
    $UID=dowith_sql($_POST['UID']);
    $UID=filter_var($UID);
  }else{
    $UID="";
  }
  if($_POST['IN']!=""){
    $IN=dowith_sql($_POST['IN']);
    $IN=sqlin($IN);
    $IN=filter_var($IN);
  }else{
    $IN="";
  }
  $content="";
  $tmpQID="";
  $str_file="SELECT a.ID, a.Name, a.FileDate, a.Status, a.FileType, a.ToWho, a.Description, a.FormatSize, c.SKU FROM partner_files a INNER JOIN partner_myproducts b ON a.ToWho=b.ID INNER JOIN partner_products c ON b.ModelID=c.ID";
  $str_file.=" WHERE b.CompanyID='".$UID."' AND a.ID NOT IN ('".$IN."')";
  $cmd_file=mysqli_query($link_db,$str_file);
  while ($data_file=mysqli_fetch_row($cmd_file)) {
  $content.="
    <tr>
      <td class='grey darken-4'>
        <button type='button' class='close font-large-1' aria-label='Close'>
          <span aria-hidden='true' onclick=cancelCard('file',".$data_file[0].")>×</span>
        </button>
        <div class='badge badge-pill  font-medium-3 bg-grey'>".$data_file[8]."</div>
        <div class='clearfix'><br /></div>
        <span class='t-Italic'>".$data_file[2]."</span>
        <h3>".$data_file[4]." - ".$data_file[1]." (".$data_file[6].") </h3>
        <p>Description: ".$data_file[6]."</p>
      </td>
    </tr>";
  }

  echo $content;
  mysqli_close($link_db);
  exit();
}
?>