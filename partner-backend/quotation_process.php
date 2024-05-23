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

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");


$SessionID=dowith_sql($_SESSION['ID']);
$SessionID=filter_var($SessionID);

if($kind=="selMember"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  $content="";
  $content.="<option selected>Select a member of this company </option>";
  $strName="SELECT ID, Name, Email FROM partner_user WHERE CompanyID='".$ID."'";
  $cdmName=mysqli_query($link_db,$strName);
  while ($Name=mysqli_fetch_row($cdmName)) {
    $content.="<option  value='".$Name[0]."'>".$Name[1]." (".$Name[2].")</option>";
  }
  echo $content;
  mysqli_close($link_db);
  exit();
}

if($kind=="addQT"){
  if($_POST['company']!=""){
    $company=dowith_sql($_POST['company']);
    $company=filter_var($company);
  }else{
    $company="";
  }
  if($_POST['member']!=""){
    $member=dowith_sql($_POST['member']);
    $member=filter_var($member);
  }else{
    $member="";
  }
  if($_POST['QT_Date']!=""){
    $QT_Date=dowith_sql($_POST['QT_Date']);
    $QT_Date=filter_var($QT_Date);
  }else{
    $QT_Date="";
  }
  if($_POST['Due_Date']!=""){
    $Due_Date=dowith_sql($_POST['Due_Date']);
    $Due_Date=filter_var($Due_Date);
  }else{
    $Due_Date="";
  }
  if($_POST['Terms']!=""){
    $Terms=dowith_sql($_POST['Terms']);
    $Terms=filter_var($Terms);
  }else{
    $Terms="";
  }
  if($_POST['Remarks']!=""){
    $Remarks=dowith_sql($_POST['Remarks']);
    $Remarks=filter_var($Remarks);
  }else{
    $Remarks="";
  }
  if($_POST['Order']!=""){ 
    $Order=dowith_sql($_POST['Order']);
    $Order=filter_var($Order);
  }else{
    $Order="";
  }
  if($_POST['pr']!=""){ 
    $pr=dowith_sql($_POST['pr']);
    $pr=filter_var($pr);
  }else{
    $pr="";
  }
  if($_POST['Qty']!=""){ 
    $Qty=dowith_sql($_POST['Qty']);
    $Qty=filter_var($Qty);
  }else{
    $Qty="";
  }
  if($_POST['UnitPrice']!=""){ 
    $UnitPrice=dowith_sql($_POST['UnitPrice']);
    $UnitPrice=filter_var($UnitPrice);
    $UnitPrice=str_replace(",","",$UnitPrice);
  }else{
    $UnitPrice="";
  }
  if($_POST['des']!=""){ 
    $des=dowith_sql($_POST['des']);
    $des=filter_var($des);
  }else{
    $des="";
  }
  if($_POST['Item']!=""){ 
    $Item=dowith_sql($_POST['Item']);
    $Item=filter_var($Item);
  }else{
    $Item="";
  }
  if($_POST['Price']!=""){ 
    $Price=dowith_sql($_POST['Price']);
    $Price=filter_var($Price);
    $Price=str_replace(",","",$Price);
  }else{
    $Price="";
  }
  if($_POST['ex_Order']!=""){ 
    $ex_Order=dowith_sql($_POST['ex_Order']);
    $ex_Order=filter_var($ex_Order);
  }else{
    $ex_Order="";
  }
  if($_POST['Items']!=""){  // Items length
    $Items=dowith_sql($_POST['Items']);
    $Items=filter_var($Items);
  }else{
    $Items="";
  }
  if($_POST['Extra']!=""){ // Extra length
    $Extra=dowith_sql($_POST['Extra']);
    $Extra=filter_var($Extra);
  }else{
    $Extra="";
  }

  $str_SRole="SELECT ID, Role FROM partner_sales WHERE ID='".$SessionID."'";
  $cmd_SRole=mysqli_query($link_db,$str_SRole);
  $SRole_data=mysqli_fetch_row($cmd_SRole);
  $Role=$SRole_data[1];
  if($Role=="SUAD" || $Role=="AD"){
    $salesid=0;
  }else{
    $salesid=$SRole_data[0];
  }

  $strQuoteID="SELECT QT_ID FROM partner_projects WHERE 1 ORDER BY QT_ID DESC";
  $cmdQuoteID=mysqli_query($link_db,$strQuoteID);
  $resultQuoteID=mysqli_fetch_row($cmdQuoteID);
  if($resultQuoteID[0]==""){

    $QuoteID="QT1000001";
  }else{
    $arr_ID=explode("QT" , $resultQuoteID[0]);
    $QuoteID=$arr_ID[1]+1;
    $QuoteID="QT".$QuoteID;
  }


  $str="INSERT INTO partner_projects (QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, C_DATE)";
  $str.=" VALUES('".$QuoteID."', '".$company."', '".$member."', '".$QT_Date."', '".$Due_Date."', '".$Terms."', '".$Remarks."', '".$salesid."', 'Contact', '".$now."')";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  

  }else{  
    echo "Insert projects error";
    mysqli_close($link_db);
    exit();
  }

  $tmp_Order=explode("+",$Order);
  $tmp_pr=explode("+",$pr);
  $tmp_Qty=explode("+",$Qty);
  $tmp_UnitPrice=explode("+",$UnitPrice);
  $tmp_des=explode("+",$des);

  
  for($i=0; $i < $Items; $i++){
    $strSKU="SELECT ID, SKU, CATEGORY_NAME, ProductType, MiTAC_PN FROM partner_model WHERE ID ='".$tmp_pr[$i]."'";
    $cmdSKU=mysqli_query($link_db, $strSKU);
    $dataSKU=mysqli_fetch_row($cmdSKU);
    if($dataSKU[1]==""){
      $products=$dataSKU[2];
      $MiTAC_PN=$dataSKU[4];
      $ProductTypeID=$dataSKU[3];
    }else{
      $products=$dataSKU[1];
      $MiTAC_PN="";
      $ProductTypeID=$dataSKU[3];
    }
 
    $str1="INSERT INTO partner_projects_items (QT_ID, ProductTypeID, ModelID, Products, MiTAC_PN, Qty, UnitPrice, Description, Sort, C_DATE)";
    $str1.=" VALUES('".$QuoteID."', '".$ProductTypeID."', '".$dataSKU[0]."', '".$products."', '".$MiTAC_PN."', '".$tmp_Qty[$i]."', '".$tmp_UnitPrice[$i]."', '".$tmp_des[$i]."', '".$tmp_Order[$i]."', '".$now."');";
    $cmd1=mysqli_query($link_db,$str1);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      $str1="";
    }else{  
      echo "Insert projects items error";
      mysqli_close($link_db);
      exit();
    }
  }
  
  $tmp_ex_Order=explode("+",$ex_Order);
  $tmp_Item=explode("+",$Item);
  $tmp_Price=explode("+",$Price);
  for($i=0; $i < $Extra; $i++){
    $str2="INSERT INTO partner_projects_extra (QT_ID, Item, Price, Sort, C_DATE)";
    $str2.=" VALUES('".$QuoteID."', '".$tmp_Item[$i]."', '".$tmp_Price[$i]."', '".$tmp_ex_Order[$i]."', '".$now."');";
    $cmd2=mysqli_query($link_db,$str2);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      $str2="";
    }else{  
      echo "Insert projects extra error";
      mysqli_close($link_db);
      exit();
    }
  }
  
  
  echo "success";
  mysqli_close($link_db);
  exit();
}

if($kind=="editQT"){
  if($_POST['editID']!=""){
    $editID=dowith_sql($_POST['editID']);
    $editID=filter_var($editID);
  }else{
    $editID="";
  }
  if($_POST['QT_ID']!=""){
    $QT_ID=dowith_sql($_POST['QT_ID']);
    $QT_ID=filter_var($QT_ID);
  }else{
    $QT_ID="";
  }
  if($_POST['company']!=""){
    $company=dowith_sql($_POST['company']);
    $company=filter_var($company);
  }else{
    $company="";
  }
  if($_POST['member']!=""){
    $member=dowith_sql($_POST['member']);
    $member=filter_var($member);
  }else{
    $member="";
  }
  if($_POST['QT_Date']!=""){
    $QT_Date=dowith_sql($_POST['QT_Date']);
    $QT_Date=filter_var($QT_Date);
  }else{
    $QT_Date="";
  }
  if($_POST['Due_Date']!=""){
    $Due_Date=dowith_sql($_POST['Due_Date']);
    $Due_Date=filter_var($Due_Date);
  }else{
    $Due_Date="";
  }
  if($_POST['Terms']!=""){
    $Terms=dowith_sql($_POST['Terms']);
    $Terms=filter_var($Terms);
  }else{
    $Terms="";
  }
  if($_POST['Remarks']!=""){
    $Remarks=dowith_sql($_POST['Remarks']);
    $Remarks=filter_var($Remarks);
  }else{
    $Remarks="";
  }
  if($_POST['Order']!=""){ 
    $Order=dowith_sql($_POST['Order']);
    $Order=filter_var($Order);
  }else{
    $Order="";
  }
  if($_POST['pr']!=""){ 
    $pr=dowith_sql($_POST['pr']);
    $pr=filter_var($pr);
  }else{
    $pr="";
  }
  if($_POST['Qty']!=""){ 
    $Qty=dowith_sql($_POST['Qty']);
    $Qty=filter_var($Qty);
  }else{
    $Qty="";
  }
  if($_POST['UnitPrice']!=""){ 
    $UnitPrice=dowith_sql($_POST['UnitPrice']);
    $UnitPrice=filter_var($UnitPrice);
    $UnitPrice=str_replace(",","",$UnitPrice);
  }else{
    $UnitPrice="";
  }
  if($_POST['des']!=""){ 
    $des=dowith_sql($_POST['des']);
    $des=filter_var($des);
  }else{
    $des="";
  }
  if($_POST['Item']!=""){ 
    $Item=dowith_sql($_POST['Item']);
    $Item=filter_var($Item);
  }else{
    $Item="";
  }
  if($_POST['Price']!=""){ 
    $Price=dowith_sql($_POST['Price']);
    $Price=filter_var($Price);
    $Price=str_replace(",","",$Price);
  }else{
    $Price="";
  }
  if($_POST['ex_Order']!=""){ 
    $ex_Order=dowith_sql($_POST['ex_Order']);
    $ex_Order=filter_var($ex_Order);
  }else{
    $ex_Order="";
  }
  if($_POST['Items']!=""){  // Items length
    $Items=dowith_sql($_POST['Items']);
    $Items=filter_var($Items);
  }else{
    $Items="";
  }
  if($_POST['Extra']!=""){ // Extra length
    $Extra=dowith_sql($_POST['Extra']);
    $Extra=filter_var($Extra);
  }else{
    $Extra="";
  }

 
  $str="UPDATE partner_projects SET Company='".$company."', ToUser='".$member."', QT_DATE='".$QT_Date."', Due_DATE='".$Due_Date."', Terms='".$Terms."', Remarks='".$Remarks."', U_DATE='".$now."' WHERE ID='".$editID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  

  }else{  
    echo "UPDATE projects error";
    mysqli_close($link_db);
    exit();
  }

  $tmp_Order=explode("+",$Order);
  $tmp_pr=explode("+",$pr);
  $tmp_Qty=explode("+",$Qty);
  $tmp_UnitPrice=explode("+",$UnitPrice);
  $tmp_des=explode(",",$des);

  $delItems="DELETE FROM partner_projects_items WHERE QT_ID='".$QT_ID."'";
  mysqli_query($link_db,$delItems);
  
  for($i=0; $i < $Items; $i++){
    $strSKU="SELECT ID, SKU, CATEGORY_NAME, ProductType, MiTAC_PN FROM partner_model WHERE ID ='".$tmp_pr[$i]."'";
    $cmdSKU=mysqli_query($link_db, $strSKU);
    $dataSKU=mysqli_fetch_row($cmdSKU);
    if($dataSKU[1]==""){
      $products=$dataSKU[2];
      $MiTAC_PN=$dataSKU[4];
      $ProductTypeID=$dataSKU[3];
    }else{
      $products=$dataSKU[1];
      $MiTAC_PN="";
      $ProductTypeID=$dataSKU[3];
    }
    $str1="INSERT INTO partner_projects_items (QT_ID, ProductTypeID, ModelID, Products, MiTAC_PN, Qty, UnitPrice, Description, Sort, C_DATE)";
    $str1.=" VALUES('".$QT_ID."', '".$ProductTypeID."', '".$dataSKU[0]."', '".$products."', '".$MiTAC_PN."', '".$tmp_Qty[$i]."', '".$tmp_UnitPrice[$i]."', '".$tmp_des[$i]."', '".$tmp_Order[$i]."', '".$now."');";
    $cmd=mysqli_query($link_db,$str1);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      $str1="";
    }else{  
      echo "Insert projects items error";
      mysqli_close($link_db);
      exit();
    }
  }
  $delExtra="DELETE FROM partner_projects_extra WHERE QT_ID='".$QT_ID."'";
  mysqli_query($link_db,$delExtra);

  $tmp_ex_Order=explode("+",$ex_Order);
  $tmp_Item=explode("+",$Item);
  $tmp_Price=explode("+",$Price);
  for($i=0; $i < $Extra; $i++){
    $str2="INSERT INTO partner_projects_extra (QT_ID, Item, Price, Sort, C_DATE)";
    $str2.=" VALUES('".$QT_ID."', '".$tmp_Item[$i]."', '".$tmp_Price[$i]."', '".$tmp_ex_Order[$i]."', '".$now."');";
    $cmd=mysqli_query($link_db,$str2);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
      $str2="";
    }else{  
      echo "Insert projects extra error";
      mysqli_close($link_db);
      exit();
    }
  }
  
  
  echo "success";
  mysqli_close($link_db);
  exit();
}

if($kind=="delQT"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  $str1="SELECT QT_ID FROM partner_projects WHERE ID='".$ID."'";
  $cmd1=mysqli_query($link_db,$str1);
  $data=mysqli_fetch_row($cmd1);
  $QT_ID=$data[0];

  $str="DELETE FROM partner_projects WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $str1="DELETE FROM partner_projects_client WHERE QT_ID='".$QT_ID."'";
  $cmd1=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);
  if($result>0){
    
  }else{ 
    /*echo "Delete projects error";
    mysqli_close($link_db);
    exit();*/
  }

  $delItems="DELETE FROM partner_projects_items WHERE QT_ID='".$QT_ID."'";
  mysqli_query($link_db,$delItems);
  $delItems1="DELETE FROM partner_projects_items_client WHERE QT_ID='".$QT_ID."'";
  mysqli_query($link_db,$delItems1);
  if($result>0){
    
  }else{ 
    /*echo "Delete projects error";
    mysqli_close($link_db);
    exit();*/
  }

  $delExtra="DELETE FROM partner_projects_extra WHERE QT_ID='".$QT_ID."'";
  mysqli_query($link_db,$delExtra);
  $delExtra1="DELETE FROM partner_projects_extra_client WHERE QT_ID='".$QT_ID."'";
  mysqli_query($link_db,$delExtra1);

  $result=mysqli_affected_rows($link_db);
  if($result>0){
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{ 
    echo "Delete projects error";
    mysqli_close($link_db);
    exit();
  }
  
}


if($kind=="Sales"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }

  $str="SELECT Sales FROM partner_projects WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $Sales=mysqli_fetch_row($cmd);
  $Sales=$Sales[0];

  $content="";
  $content="<option value='none'>Please select...</option>";
  $str_teams="SELECT ID, Team FROM partner_teams WHERE 1";
  $cmd_teams=mysqli_query($link_db,$str_teams);
  while ($result_teams=mysqli_fetch_row($cmd_teams)) {
    
    $content.="<optgroup label='".$result_teams[1]."'>";

    $str_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE Team='".$result_teams[0]."'";
    $cmd_sales=mysqli_query($link_db,$str_sales);
    while ($result_sales=mysqli_fetch_row($cmd_sales)) { 
      if($Sales==$result_sales[0]){
        $status="selected";
      }else{
        $status="";
      }
      $content.="<option value='".$result_sales[0]."' ".$status.">".$result_sales[1]." / ".$result_sales[2]."</option>"; 
    }
    $content.="</optgroup>";
    
  }
  $content.="</select>";
  echo $content;
  mysqli_close($link_db);
  exit();
}

if($kind=="assSales"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  if($_POST['editSales']!=""){
    $editSales=dowith_sql($_POST['editSales']);
    $editSales=filter_var($editSales);
  }else{
    $editSales="";
  }
  if($_POST['sales_note']!=""){
    $sales_note=dowith_sql($_POST['sales_note']);
    $sales_note=filter_var($sales_note);
  }else{
    $sales_note="";
  }  

  /*$str1="SELECT ToUser, LeadsID FROM partner_projects WHERE ID='".$ID."'";
  $cmd1=mysqli_query($link_db,$str1);
  $data1=mysqli_fetch_row($cmd1);
  $LeadsID=$data1[1];
  $ToUser=$data1[2];*/

  $str="UPDATE partner_projects SET Sales='".$editSales."' WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  

  }else{  
    echo "Update Sales error";
    mysqli_close($link_db);
    exit();
  }

  $str="SELECT NAME FROM partner_sales WHERE ID='".$editSales."'";
  $cmd=mysqli_query($link_db,$str);
  $Sales=mysqli_fetch_row($cmd);
  $action="Assign Sales: ".$Sales[0];

  $str="SELECT QT_ID FROM partner_projects WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $QT_ID=mysqli_fetch_row($cmd);

  $str="INSERT INTO partner_projects_log (QT_ID, Action, Note, U_DATE) VALUES ('".$QT_ID[0]."','".$action."','".$sales_note."','".$now."')";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{  
    echo "Insert log(sales) error";
    mysqli_close($link_db);
    exit();
  }

}

if($kind=="Status"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }
  if($_POST['sel_status']!=""){
    $sel_status=dowith_sql($_POST['sel_status']);
    $sel_status=filter_var($sel_status);
  }else{
    $sel_status="";
  }
  if($_POST['status_note']!=""){
    $status_note=dowith_sql($_POST['status_note']);
    $status_note=filter_var($status_note);
  }else{
    $status_note="";
  }  

  $str="UPDATE partner_projects SET STATUS='".$sel_status."' WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  

  }else{  
    echo "Update Status error";
    mysqli_close($link_db);
    exit();
  }
  
  $action="Status: ".$sel_status;

  $str="SELECT QT_ID FROM partner_projects WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  $QT_ID=$data[0];

  if($sel_status=="Confirmed"){
    $str1="SELECT a.ID, a.QT_ID, a.Company, a.Sales, b.Products FROM partner_projects a INNER JOIN partner_projects_items b ON a.QT_ID=b.QT_ID WHERE a.ID='".$ID."'";
    $cmd1=mysqli_query($link_db,$str1);
    while ($result1=mysqli_fetch_row($cmd1)) {

      $str2="SELECT ID, Model, SKU, CATEGORY_NAME, MiTAC_PN FROM partner_model WHERE SKU='".$result1[4]."'";
      $cmd2=mysqli_query($link_db,$str2);
      $result2=mysqli_fetch_row($cmd2);
      $ModelID=$result2[0];
      if($ModelID!=""){
        if($result2[1]==""){
          $Model=$result2[4];
          $SKU=$result2[3];
          $Insert="INSERT INTO partner_myproducts (CompanyID, ModelID, Model, SKU, SalesID, C_DATE) VALUES ('".$result1[2]."', '".$ModelID."', '".$Model."', '".$SKU."', '".$result1[3]."', '".$now."')";
          $cmd3=mysqli_query($link_db,$Insert);
          $result=mysqli_affected_rows($link_db); 
        }else{
          $Model=$result2[1];
          $SKU=$result2[2];
          $str3="SELECT ID FROM partner_myproducts WHERE CompanyID='".$result1[2]."' AND SKU='".$SKU."' AND Model='".$Model."'";
          $cmd3=mysqli_query($link_db,$str3);
          $result3=mysqli_fetch_row($cmd3);
          if($result3[0]==""){
            $Insert="INSERT INTO partner_myproducts (CompanyID, ModelID, Model, SKU, SalesID, C_DATE) VALUES ('".$result1[2]."', '".$ModelID."', '".$Model."', '".$SKU."', '".$result1[3]."', '".$now."')";
            $cmd3=mysqli_query($link_db,$Insert);
            $result=mysqli_affected_rows($link_db);  
            
          }
        }
      }
      
      if($result>0){  

      }else{  
        echo "INSERT partner_myproducts error";
        mysqli_close($link_db);
        exit();
      }
    }
  }else{
    //$str1="SELECT a.Company, a.Sales, b.Products FROM partner_projects a INNER JOIN partner_projects_items b ON a.QT_ID=b.QT_ID WHERE a.QT_ID='".$QT_ID."'";
    /*$str1="SELECT a.Company, a.Sales, b.Products FROM partner_projects a INNER JOIN partner_projects_items b ON a.QT_ID=b.QT_ID WHERE a.QT_ID='".$QT_ID."'";
    $cmd1=mysqli_query($link_db,$str1);
    while ($data1=mysqli_fetch_row($cmd1)) {
      $CompanyID=$data1[0];
      $SalesID=$data1[1];
      $str2="SELECT ID FROM partner_model WHERE ID='".$data1[2]."'";
      $cmd2=mysqli_query($link_db,$str2);
      $data2=mysqli_fetch_row($cmd2);
      $str3="INSERT INTO partner_myproducts (CompanyID, ModelID, SalesID, C_DATE) VALUES ('".$CompanyID."','".$data2[0]."','".$SalesID."','".$now."')";
      $cmd3=mysqli_query($link_db,$str3);
    }*/
  }

  $str="INSERT INTO partner_projects_log (QT_ID, Action, Note, U_DATE) VALUES ('".$QT_ID."','".$action."','".$status_note."','".$now."')";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{  
    echo "Insert log(status) error";
    mysqli_close($link_db);
    exit();
  }

}

if($kind=="LogView"){
  if($_POST['ID']!=""){
    $ID=dowith_sql($_POST['ID']);
    $ID=filter_var($ID);
  }else{
    $ID="";
  }

  $str="SELECT QT_ID FROM partner_projects WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $QT_ID=mysqli_fetch_row($cmd);

  $content="";
  $str="SELECT Action, Note, U_DATE FROM partner_projects_log WHERE QT_ID='".$QT_ID[0]."' ORDER BY U_DATE DESC";
  $cmd=mysqli_query($link_db,$str);
  while ($result=mysqli_fetch_row($cmd)) {
    $content.="<tr>";
    $content.="<td>".$result[2]."</td>";
    $content.="<td>".$result[0]."</td>";
    $content.="<td>".$result[1]."</td>";
    $content.="</tr>";
  }
  echo $content;
  mysqli_close($link_db);
  exit();
}
?>