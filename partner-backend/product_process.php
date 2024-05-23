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

//error_reporting(0);

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
 // $str = str_replace("insert","",$str);
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

$ID=$_SESSION['ID'];

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="changeType"){
	if($_POST['ID']!=""){
    $ID=trim(dowith_sql($_POST['ID']));
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  if($_POST['tmp']!=""){
    $tmp=trim(dowith_sql($_POST['tmp']));
    $tmp=filter_var($tmp);
  }else{
    $tmp="";
  }
  if($_POST['prid']!=""){
    $prid=trim(dowith_sql($_POST['prid']));
    $prid=filter_var($prid);
  }else{
    $prid="";
  }
  if($tmp=="e"){
  	$str="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE FROM partner_model WHERE ID='".$ID."'";
    $cmd=mysqli_query($link_db,$str);
		$result=mysqli_fetch_row($cmd);
		$content="	
	  <option value=''>Select...</option>
	  <option value='ADD' class='red'>Add New</option>";
    $strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType='".$ID."' GROUP BY Model";
    $cmdModel=mysqli_query($link_db,$strModel);
	  while ($Model=mysqli_fetch_row($cmdModel)) {
	  	$content.="<option value='".$Model[0]."'>".$Model[1]."</option>";
	  }
  }else{
  	$content="
	  <option value=''>Select...</option>
	  <option value='ADD' class='red'>Add New</option>";
	  if($ID=="1" || $ID=="2"){
    $strModel="SELECT ID, CATEGORY_NAME, MiTAC_PN, ProductType FROM partner_model WHERE ProductType='".$ID."'";
    }else{
    $strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType='".$ID."' GROUP BY Model";
    }
	  $cmdModel=mysqli_query($link_db,$strModel);
	  while ($Model=mysqli_fetch_row($cmdModel)) {
      /*if($ID=="1" || $ID=="2"){
      $MiTAC_PN=$Model[2];
      }*/
	  	$content.="<option value='".$Model[0]."'>".$Model[1]."</option>";
	  }
  }
  echo $content;exit();
	mysqli_close($link_db);
  exit();

}

if($kind=="AddType"){
	if($_POST['Type']!=""){
    $Type=trim(dowith_sql($_POST['Type']));
    $Type=filter_var($Type);
  }else{
    $Type="";
  }

  $str="SELECT * FROM partner_products_type WHERE Type='".$Type."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "Type";
    mysqli_close($link_db);
    exit();
  }
  $str="SELECT ProductTypeID FROM partner_products_type WHERE 1 ORDER BY ProductTypeID DESC";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  $ProductTypeID=$data[0]+1;

  $str="INSERT INTO partner_products_type (ProductTypeID, Type, C_DATE) VALUES ('".$ProductTypeID."', '".$Type."', '".$now."')";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Insert type error";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="EditType"){
	if($_POST['ID']!=""){
    $ID=trim(dowith_sql($_POST['ID']));
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  if($_POST['Type']!=""){
    $Type=trim(dowith_sql($_POST['Type']));
    $Type=filter_var($Type);
  }else{
    $Type="";
  }

  $str="SELECT * FROM partner_products_type WHERE Type='".$Type."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "Type";
    mysqli_close($link_db);
    exit();
  }

  $str="UPDATE partner_products_type SET Type='".$Type."', U_DATE='".$now."' WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Insert type error";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editToType"){
	if($_POST['EditTypeID']!=""){
    $EditTypeID=trim(dowith_sql($_POST['EditTypeID']));
    $EditTypeID=filter_var($EditTypeID);
  }else{
    $EditTypeID="";
  }

  $str="SELECT Type FROM partner_products_type WHERE ProductTypeID='".$EditTypeID."'";
  $cmd=mysqli_query($link_db,$str);
  $date=mysqli_fetch_row($cmd);
  echo $date[0];
  mysqli_close($link_db);
  exit();
}

if($kind=="AddPR"){
	if($_POST['Type']!=""){
    $Type=trim(dowith_sql($_POST['Type']));
    $Type=filter_var($Type);
  }else{
    $Type="";
  }
  if($_POST['Model']!=""){
    $Model=trim(dowith_sql($_POST['Model']));
    $Model=filter_var($Model);
    $strModel="SELECT ID, Model, SKU FROM partner_model WHERE ID='".$Model."'";
    $cmdModel=mysqli_query($link_db,$strModel);
    $date=mysqli_fetch_row($cmdModel);
    if($date[1]!=""){
      $Model=$date[1];
    }
  }else{
    $Model="";
  }
  if($_POST['SKU']!=""){
    $SKU=trim(dowith_sql($_POST['SKU']));
    $SKU=filter_var($SKU);
  }else{
    $SKU="";
  }
  if($_POST['MiTAC']!=""){
    $MiTAC=trim(dowith_sql($_POST['MiTAC']));
    $MiTAC=filter_var($MiTAC);
  }else{
    $MiTAC="";
  }
  if($_POST['Cate']!=""){
    $Cate=trim(dowith_sql($_POST['Cate']));
    $Cate=filter_var($Cate);
  }else{
    $Cate="";
  }
  $str="SELECT * FROM partner_model WHERE Model='".$Model."'";
  $cmd=mysqli_query($link_db,$str);
  $Modelnum=mysqli_num_rows($cmd);
  /*if($Modelnum>0){
    echo "Model";
    mysqli_close($link_db);
    exit();
  }*/

  if($Type=="1" || $Type=="2"){
    $str="SELECT * FROM partner_model WHERE MiTAC_PN='".$MiTAC."'";
    $cmd1=mysqli_query($link_db,$str);
    $num=mysqli_num_rows($cmd1);
    if($num==1){
      echo "MiTAC";
      mysqli_close($link_db);
      exit();
    }
  }else{
    $str="SELECT * FROM partner_model WHERE SKU='".$SKU."'";
    $cmd=mysqli_query($link_db,$str);
    $num=mysqli_num_rows($cmd);
    if($num>0){
      echo "SKU";
      mysqli_close($link_db);
      exit();
    }
  }
	

  $str="INSERT INTO partner_model (Model, SKU, ProductType, MiTAC_PN, CATEGORY_NAME,  C_DATE)";
  $str.=" VALUES ('".$Model."','".$SKU."', '".$Type."', '".$MiTAC."', '".$Cate."','".$now."')";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit();  
  }else{  
    echo "Insert model error";
    mysqli_close($link_db);
    exit();
  }
 
  /*$str="INSERT INTO partner_products (ProductType, Model, SKU, MiTAC_PN, Category, SalesID, C_DATE)";
  $str.=" VALUES ('".$Type."', '".$Model."','".$SKU."','".$MiTAC."','".$Cate."','".$ID."','".$now."')";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Insert product error";
    mysqli_close($link_db);
    exit();
  }*/
}

if($kind=="EditPR"){
	if($_POST['prid']!=""){
    $prid=trim(dowith_sql($_POST['prid']));
    $prid=filter_var($prid);
  }else{
    $prid="";
  }
	if($_POST['Type']!=""){
    $Type=trim(dowith_sql($_POST['Type']));
    $Type=filter_var($Type);
  }else{
    $Type="";
  }
  if($_POST['Model']!=""){
    $Model=trim(dowith_sql($_POST['Model']));
    $Model=filter_var($Model);
    $strModel="SELECT ID, Model, SKU FROM partner_model WHERE ID='".$Model."'";
    $cmdModel=mysqli_query($link_db,$strModel);
    $date=mysqli_fetch_row($cmdModel);
    if($date[1]!=""){
      $Model=$date[1];
    }else{
      $Model="";
    }
  }else{
    $Model="";
  }

  if($_POST['SKU']!=""){
    $SKU=trim(dowith_sql($_POST['SKU']));
    $SKU=filter_var($SKU);
  }else{
    $SKU="";
  }
  if($_POST['MiTAC']!=""){
    $MiTAC=trim(dowith_sql($_POST['MiTAC']));
    $MiTAC=filter_var($MiTAC);
  }else{
    $MiTAC="";
  }
  if($_POST['Cate']!=""){
    $Cate=trim(dowith_sql($_POST['Cate']));
    $Cate=filter_var($Cate);
  }else{
    $Cate="";
  }
  /*$str="SELECT * FROM partner_model WHERE Model='".$Model."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "Model";
    mysqli_close($link_db);
    exit();
  }
  $str="SELECT * FROM partner_model WHERE SKU='".$SKU."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "SKU";
    mysqli_close($link_db);
    exit();
  }
	$str="SELECT * FROM partner_model WHERE MiTAC_PN='".$SKU."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    echo "MiTAC";
    mysqli_close($link_db);
    exit();
  }*/

  $str="UPDATE partner_model SET Model='".$Model."', SKU='".$SKU."', ProductType='".$Type."', MiTAC_PN='".$MiTAC."', CATEGORY_NAME='".$Cate."', U_DATE='".$now."' WHERE ID='".$prid."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){ 
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{  
    echo "Update model error";
    mysqli_close($link_db);
    exit();
  }
 
  /*$str="UPDATE partner_products SET ProductType='".$Type."', Model='".$Model."', SKU='".$SKU."', MiTAC_PN='".$MiTAC."', Category='".$Cate."', SalesID='".$ID."', U_DATE='".$now."' WHERE ID='".$prid."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Upate product error";
    mysqli_close($link_db);
    exit();
  }*/
}

if($kind=="editList"){
  if($_POST['EditID']!=""){
    $EditID=trim(dowith_sql($_POST['EditID']));
    $EditID=filter_var($EditID);
  }else{
    $EditID="";
  }

  $strType="SELECT ID, ProductTypeID, Type FROM partner_products_type WHERE 1";
  $cmdType=mysqli_query($link_db,$strType);
  while ($Type=mysqli_fetch_row($cmdType)) {
    $type[$Type[1]]=$Type[2];
  }

  $str="SELECT ID, ProductType, Model, SKU, MiTAC_PN, CATEGORY_NAME, C_DATE, U_DATE FROM partner_model WHERE ID='".$EditID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_fetch_row($cmd);
  $content="
  <div class='form-group'>
    <label>Product Type: </label>
    <select id='s_eType' class='form-control' onchange=changeType('e')>
      <option value=''>Select...</option>";

      foreach ($type as $key => $value) {
        if($value!=""){
          if($result[1]==$key){
            $status="selected"; 
            $typeID=$key;
          }else{
            $status="";
          }
        }
        
        $content.="<option value='".$key."' ".$status.">".$value."</option>";
      }
      $display="";
      $display1="";
      if($result[1]==1 || $result[1]==2){
        $display="style='display:none'";
      }else{
        $display1="style='display:none'";
      }

    $content.="
    </select>
  </div>
  <div id='div_eModel' class='form-group' ".$display.">
    <label>Model Name: </label>
    <select id='s_eModel' class='form-control' onchange=sel_eModel()>
      <option value=''>Select...</option>
      <option value='ADD' class='red'>Add New</option>";

      $strModel="SELECT ID, Model, SKU, ProductType FROM partner_model WHERE ProductType='".$typeID."'";
      $cmdModel=mysqli_query($link_db,$strModel);
      while ($Model=mysqli_fetch_row($cmdModel)) {
        if($Model[1]==$result[2]){
          $statusM="selected";
        }else{
          $statusM="";
        }
        $content.="<option value='".$Model[0]."'  ".$statusM.">".$Model[1]."</option>";
      }
    $content.="
    </select>
    <input id='eModel' type='text' placeholder='' class='form-control' value='' style='display:none' >
    <div id='err_eModel' class='alert alert-danger mb-1' role='alert' style='display:none' >
      Repeated Model Name
    </div>
  </div>
  <div id='div_eSKU' class='form-group' ".$display.">
    <label>SKU: </label>
    <input id='eSKU' type='text' placeholder='' class='form-control' value='".$result[3]."'>
    <div id='err_eSKU' class='alert alert-danger mb-1' role='alert' style='display:none' >Repeated SKU.</div>
  </div>
  <div id='div_eMiTAC' class='form-group' ".$display1.">
    <label>MiTAC P/N: </label>
    <input id='eMiTAC' type='text' placeholder='' class='form-control' value='".$result[4]."'>
    <div id='err_eMitac' class='alert alert-danger mb-1' role='alert' style='display:none' >Repeated MiTAC P/N.</div>
  </div>
  <div id='div_eCate' class='form-group' ".$display1.">
    <label>Category: </label>
    <input id='eCate' type='text' placeholder='' class='form-control' value='".$result[5]."'>
  </div>
    ";

  echo $content;
  mysqli_close($link_db);
  exit();
  /*$str="UPDATE partner_products_type SET Type='".$Type."', U_DATE='".$now."' WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Insert type error";
    mysqli_close($link_db);
    exit();
  }*/
}

if($kind=="DelPR"){
  if($_POST['prid']!=""){
    $prid=trim(dowith_sql($_POST['prid']));
    $prid=filter_var($prid);
  }else{
    $prid="";
  }
 
  $str="DELETE FROM partner_model WHERE ID='".$prid."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Delete products error";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="DelType"){
  if($_POST['EditTypeID']!=""){
    $EditTypeID=trim(dowith_sql($_POST['EditTypeID']));
    $EditTypeID=filter_var($EditTypeID);
  }else{
    $EditTypeID="";
  }
 
  $str="DELETE FROM partner_products_type WHERE ID='".$EditTypeID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit(); 
  }else{  
    echo "Delete type error";
    mysqli_close($link_db);
    exit();
  }
}
?>