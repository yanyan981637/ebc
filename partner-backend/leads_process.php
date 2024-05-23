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
include("../EN/PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別  
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

include("countryCodeReplace.php");

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="AssignSales"){
  if($_POST['kind']!=""){
    $LeadsID=dowith_sql($_POST['LeadsID']);
    $LeadsID=filter_var($LeadsID);
  }else{
    $LeadsID="";
  }
  if($_POST['AssignSales']!=""){
    $AssignSales=dowith_sql($_POST['AssignSales']);
    $AssignSales=filter_var($AssignSales);
  }else{
    $AssignSales="";
  }
  if($_POST['AssignNote']!=""){
    $AssignNote=dowith_sql($_POST['AssignNote']);
    $AssignNote=filter_var($AssignNote);
  }else{
    $AssignNote="";
  }
  $str="SELECT CompanyID, UserID FROM partner_leads_quote WHERE ID='".$LeadsID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  $CompanyID=$data[0];
  //$UserID=$data[1];

  $up_sales="UPDATE `partner_leads_quote` SET SalesID='".$AssignSales."', U_DATE='".$now."' WHERE ID='".$LeadsID."'";
  if(mysqli_query($link_db,$up_sales)<1)
  {
    echo "up_sales error";
    mysqli_close($link_db);
    exit();
  }

  $up_Usales="UPDATE partner_user SET ResponsibleSales='".$AssignSales."', U_DATE='".$now."' WHERE CompanyID='".$CompanyID."'";
  if(mysqli_query($link_db,$up_Usales)<1)
  {
    echo "up_sales error";
    mysqli_close($link_db);
    exit();
  }

  $insert="INSERT INTO partner_leads_slog (LeadsID, Sales, NOTE, U_DATE) VALUES ('".$LeadsID."', '".$AssignSales."', '".$AssignNote."', '".$now."')";
  if(mysqli_query($link_db,$insert)<1)
  {
    echo "error";
    mysqli_close($link_db);
    exit();
  }else{
    
  }

  //****** To Sales *******
  $str="SELECT CompanyID, UserID, SalesID, SKU, ID, QuoteQty, Product_ID FROM partner_leads_quote WHERE ID='".$LeadsID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  $sku=explode(",", $data[3]);
  $UserID=$data[1];
  $SalesID=$data[2];
  $tmp=explode(",", $data[5]);
  $Product_ID=$data[6];
  foreach ($tmp as $key => $value) {
    if($value!=""){
      $tmp1=$value;
      $tmp2=explode("$", $tmp1);
      $qty[$tmp2[0]]=$tmp2[1];
    }
  }

  $str_user="SELECT ID, Name, Email FROM partner_sales WHERE ID='".$AssignSales."'";
  $cmd_user=mysqli_query($link_db,$str_user);
  $data_user=mysqli_fetch_row($cmd_user);
  $salesName=$data_user[1];
  $salesEmail=$data_user[2];

  $str_user="SELECT ID, Name, Email, CompanyName, CompanyID, CountryCode, Tel, Message FROM partner_user WHERE ID='".$UserID."'";
  $cmd_user=mysqli_query($link_db,$str_user);
  $data_user=mysqli_fetch_row($cmd_user);
  $username=$data_user[1];
  $email=$data_user[2];
  $CompanyName=$data_user[3];
  $CompanyID=$data_user[4];
  $CountryCode=$data_user[5];
  $Tel=$data_user[6];
  $Msg=$data_user[7];

  $str_country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CountryCode='".$CountryCode."'";
  $cmd_country=mysqli_query($link_db,$str_country);
  $CodeNumber=mysqli_fetch_row($cmd_country);
  $CodeNumber1=$CodeNumber[4];

  $sales_content = "
  <body style='margin: 0;padding: 0;'>

  <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td align='center'>
  <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td style='padding: 25px 0; text-align: center;'>
  <a href='https://www.mitacmct.com/partner-backend/login' >
  <img src='https://www.mitacmct.com/support_center/images/tyan_logo_email.gif' style='border:0px' /></a><br /><br />
  </td>
  </tr>
  <!-- Email Body -->
  <tr>
  <td style='width: 100%; margin: 0; padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;border-top: 1px solid #EDEFF2;border-bottom: 1px solid #EDEFF2; background-color: #FFFFFF;' width='100%' cellpadding='0' cellspacing='0'>
  <table style='width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #FFFFFF;' align='center' width='570' cellpadding='0' cellspacing='0'>
  <!-- Body content -->
  <tr>
  <td style='padding: 35px;'>
  <h2 style='font-family: Arial; line-height:130%; text-align:left; font-size:14px'>Hi ".$salesName.",</h2>

  <!-- Action -->
  <table style='width: 100%;  margin: 10px auto;  padding: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td align='center'>

  <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>

  There is a new request from MiTAC Partner Zone.<br />
  Here are the details.<br /><br />
  =============================<br />
  Lead ID: ".$LeadsID."<br />
    User Name: ".$username."<br />
    Company Name: ".$CompanyName." (ID : ".$CompanyID.")<br />
    Email Address: ".$email."<br />
    Contact Tel: +".$CodeNumber1." ".$Tel."<br />
    Message: ".$Msg."
    </p>
    <!--if there is RFQ, then show this-->

    <table style='width: 100%;  padding: 0px;  text-align: left; font-family: arial;' align='center' width='100%' cellpadding='0' cellspacing='0'>
    <tr><th colspan='2' ><h3>RFQ:</h3></th></tr>
    <tr style='background:#eee'><th style='padding:5px'>Product</th><th style='padding:5px'>Qty</th></tr>";
    $tmpPID=explode(",", $Product_ID);
    foreach ($tmpPID as $key => $value) {
      if($value!=""){
        $strPR="SELECT Product_SKU_Auto_ID, SKU, MODELCODE, Quote, ProductTypeID FROM product_skus WHERE Product_SKU_Auto_ID='".$value."'";
        $cmdPR=mysqli_query($link_db,$strPR);
        $resultPR=mysqli_fetch_row($cmdPR);
        $sales_content .= "<tr><td style='padding:5px; border-bottom:1px solid #eee'>".$resultPR[1]." (".$resultPR[2].")</td><td style='padding:5px; border-bottom:1px solid #eee'>".$qty[$resultPR[1]]."</td></tr>";
      }
    }                    
    $sales_content .= "
    </table>

  <!--end RFQ-->

  <br /><br />

  <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
  Please contact with the client ASAP. If there is no action for this request after 3 days, the system will update it to 'Invalid' status automatically. <br /><br />

  You can <a href='https://www.mitacmct.com/partner-backend/login' />log into MiTAC Partner Zone Back-end</a> and go to <strong>'Leads Mgt'</strong> to check / proceed this request.






  </p>
  <br /><br />
  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
  <td align='center'>
  <table border='0' cellspacing='0' cellpadding='0'>
  <tr> <td>
  <a href='https://www.mitacmct.com/partner-backend/login' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' >LOG IN</a>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <br /><br />
  <p style='font-family: arial; line-height:130%; font-size:12px; text-align:left;'>MiTAC Partner Zone</p>
  <!-- Sub copy -->

  </td>
  </tr>
  </table>
  </td>
  </tr>
  <tr>
  <td>
  <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0' style='border-top:1px solid #ccc'>
  <tr>
  <td style='padding: 35px;' align='center'>
  <p style='font-family: arial; line-height:130%; font-size: 12px; text-align: center;'>This is an automatic message. Please do not reply to this email. </p>

  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0'>
  <tr>
  <td style='padding: 35px;' align='center'>
  <p style='font-family: arial; line-height:130%; font-size: 12px;text-align: center;'>&copy; MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. <br />All Rights Reserved.</p>

  </td>
  </tr>
  </table>
  </body>";
  //****** To Sales *******
  $mail= new PHPMailer(); //建立新物件   
  $mail->IsSMTP(); //設定使用SMTP方式寄信   
  $mail->SMTPAuth = false; //設定SMTP需要驗證   
  //$mail->SMTPSecure = "ssl"; //ssl tls
  //$mail->SMTPDebug = 2;
  $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
  $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
  $mail->CharSet = "utf-8"; //設定郵件編碼   

  $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
  $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

  $mail->From = "noreply-to-tyan-partner-portal@tyan.com"; //設定寄件者信箱   
  $mail->FromName = "MiTAC Partner Zone"; //設定寄件者姓名   

  $mail->Subject = "New lead notification"; //設定郵件標題   
  $mail->Body = $sales_content; //設定郵件內容 
  $mail->IsHTML(true); //設定郵件內容為HTML   
  $mail->SMTPAutoTLS = false;   
  $mail->AddAddress($salesEmail, $salesName); //設定收件者郵件及名稱 
  //$mail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
  if(!$mail->Send()) {
    $errorMail=$mail->ErrorInfo;

    $admail= new PHPMailer(); //建立新物件   
    $admail->IsSMTP(); //設定使用SMTP方式寄信   
    $admail->SMTPAuth = false; //設定SMTP需要驗證   
    //$mail->SMTPSecure = "ssl"; //ssl tls
    //$mail->SMTPDebug = 2;
    $admail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
    $admail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
    $admail->CharSet = "utf-8"; //設定郵件編碼   

    $admail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
    $admail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

    $admail->From = "noreply@tyan.com"; //設定寄件者信箱   
    $admail->FromName = "Tyan Computer"; //設定寄件者姓名   

    $admail->Subject = "New lead notification to sales"; //設定郵件標題   
    $admail->Body = $errorMail; //設定郵件內容 
    $admail->IsHTML(true); //設定郵件內容為HTML  
    $admail->SMTPAutoTLS = false;    
    $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
    //$admail->AddCC("even.syao@tyan.com.tw", "even.syao");  
    $admail->Send();   
    echo "Mailer Error(Mapped): " . $mail->ErrorInfo;  
    mysqli_close($link_db);
    exit(); 
  }else{   
    
  }
  //****** To Sales END*******
  echo "success";
  mysqli_close($link_db);
  exit();

}

if($kind=="Log"){
  if($_POST['LeadsID']!=""){
    $LeadsID=dowith_sql($_POST['LeadsID']);
    $LeadsID=filter_var($LeadsID);
  }else{
    $LeadsID="";
  }
  $log_content="";
  $str="SELECT a.ID, a.LeadsID, a.Sales, a.Status, a.NOTE, a.U_DATE FROM partner_leads_slog a WHERE a.LeadsID='".$LeadsID."' ORDER BY a.U_DATE DESC";
  $cmd=mysqli_query($link_db,$str);
  while ($logs=mysqli_fetch_row($cmd)) {
    if($logs[2]!=""){
      $strSales="SELECT NAME FROM partner_sales WHERE ID='".$logs[2]."'";
      $cmdSales=mysqli_query($link_db,$strSales);
      $dateSales=mysqli_fetch_row($cmdSales);
      $SalesName=$dateSales[0];
    }
    $log_content.="<tr>";
    $log_content.="<td>".$logs[5]."</td>";
    if($logs[3]==""){
      $tmp="Assign Sales:".$SalesName;
    }else{
      $tmp="Status:".$logs[3];
    }
    $log_content.="<td>".$tmp."</td>";
    $log_content.="<td>".$logs[4]."</td>";
    $log_content.="</tr>";
  }
  echo $log_content;
  mysqli_close($link_db);
  exit();
}

if($kind=="Detail"){
  if($_POST['LeadsID']!=""){
    $LeadsID=dowith_sql($_POST['LeadsID']);
    $LeadsID=filter_var($LeadsID);
  }else{
    $LeadsID="";
  }
  if($_POST['UserID']!=""){
    $UserID=dowith_sql($_POST['UserID']);
    $UserID=filter_var($UserID);
  }else{
    $UserID="";
  }

  $str1="SELECT FEregister FROM partner_leads_quote WHERE UserID='".$UserID."' AND ID='".$LeadsID."'";
  $cmd1=mysqli_query($link_db,$str1);
  $data=mysqli_fetch_row($cmd1);
  $FEregister=$data[0]; 
  $detail_content="";
  $s_user="SELECT ID, Name, CompanyName, Email, CountryCode, Tel, Message FROM partner_user WHERE ID='".$UserID."'";
  $cmd_USER=mysqli_query($link_db,$s_user);
  $USER=mysqli_fetch_row($cmd_USER);
  $USERID=$USER[0];
  $country=country($USER[4]);
  /*$str_country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CountryCode='".$USER[4]."'";
  $cmd_country=mysqli_query($link_db,$str_country);
  $CodeNumber=mysqli_fetch_row($cmd_country);
  $CodeNumber1=$CodeNumber[4];*/
  $detail_content.="<table class='table table-borderless table-hover' >";
  $detail_content.="<tr><th>Name:</th><td>".$USER[1]."</td></tr>";
  $detail_content.="<tr><th>Company Name:</th><td>".$USER[2]."</td></tr>";
  $detail_content.="<tr><th>Email:</th><td>".$USER[3]."</td></tr>";
  $detail_content.="<tr><th>Tel:</th><td>".$USER[5]."</td></tr>";
  $detail_content.="<tr><th>Country:</th><td>".$country."</td></tr>";
  if($FEregister==1){
    $detail_content.="<tr><th>Message:</th><td>".$USER[6]."</td></tr>"; 
  }
  $detail_content.="</table><br />";
  $detail_content.="<h3>Quote:</h3>";

  $str="SELECT MODEL, SKU, QuoteQty, FEregister FROM partner_leads_quote WHERE UserID='".$USERID."' AND ID='".$LeadsID."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num>0){
    while ($detail=mysqli_fetch_row($cmd)) {    
      $detail_content.="<table class='table table-sm table-hover bg-grey bg-lighten-4'  >";
      $detail_content.="<tr><th>Product</th><th>Qty</th></tr>";
      $arr_tmp=explode(",", $detail[1]);
      foreach ($arr_tmp as $key => $value) {
        $str="SELECT `Product_SKU_Auto_ID`, `SKU`, `MODELCODE` FROM `product_skus` WHERE SKU='".$value."'";
        $cmd=mysqli_query($link_db,$str);
        $result=mysqli_fetch_row($cmd);
        if($result[0]!=""){
          $detail_content.="<tr><td>".$result[1]." (".$result[2].")</td><td>N/A</td></tr>";
        }
      }
      
      /*$arr_tmp=explode(",", $detail[2]);
      foreach ($arr_tmp as $key => $value) {
        if($value!=""){
          $tmp=explode("$", $value);
          $str="SELECT `Product_SKU_Auto_ID`, `SKU`, `MODELCODE`, `Quote` FROM `product_skus` WHERE Product_SKU_Auto_ID>'700000000' AND SKU='".$tmp[0]."'";
          $cmd=mysqli_query($link_db,$str);
          $result=mysqli_fetch_row($cmd);
          if($result[0]!=""){
            $detail_content.="<tr><td>".$result[1]." (".$result[2].")</td><td>".$tmp[1]."</td></tr>";
          }
        }
      }*/
      $detail_content.="</table>";
    }
  }

  echo $detail_content;
  mysqli_close($link_db);
  exit();
}

if($kind=="UpdateStatus"){
  if($_POST['LeadsID']!=""){
    $LeadsID=dowith_sql($_POST['LeadsID']);
    $LeadsID=filter_var($LeadsID);
  }else{
    $LeadsID="";
  }
  if($_POST['up_sel_status']!=""){
    $up_sel_status=dowith_sql($_POST['up_sel_status']);
    $up_sel_status=filter_var($up_sel_status);
  }else{
    $up_sel_status="";
  }
  if($_POST['status_note']!=""){
    $status_note=dowith_sql($_POST['status_note']);
    $status_note=filter_var($status_note);
  }else{
    $status_note="";
  }

  $up_status="UPDATE `partner_leads_quote` SET STATUS='".$up_sel_status."', NOTE='".$status_note."', U_DATE='".$now."' WHERE ID='".$LeadsID."'";
  if(mysqli_query($link_db,$up_status)<1)
  {
    echo "up_status error";
    mysqli_close($link_db);
    exit();
  }else{

  }

  $str="SELECT CompanyID, UserID, SalesID, SKU, ID, QuoteQty, Product_ID, C_DATE, FEregister FROM partner_leads_quote WHERE ID='".$LeadsID."'";
  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  $sku=explode(",", $data[3]);
  $UserID=$data[1];
  $SalesID=$data[2];
  $tmp=explode(",", $data[5]);
  $Product_ID=$data[6];
  $leads_Cdate=explode(",", $data[7]);
  $FEregister=$data[8];
  foreach ($tmp as $key => $value) {
    if($value!=""){
      $tmp1=$value;
      $tmp2=explode("$", $tmp1);
      $qty[$tmp2[0]]=$tmp2[1];
    }
  }

  if($up_sel_status=="Verified"){
    $strConfirm="UPDATE partner_user SET confirm_member='1' WHERE ID='".$UserID."' ";
    $cmdConfirm=mysqli_query($link_db,$strConfirm);

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
    

    $insert="INSERT INTO partner_projects_client (QT_ID, Company, ToUser, QT_DATE, Sales, STATUS, Version, LeadsID, C_DATE) VALUES ('".$QuoteID."','".$data[0]."', '".$data[1]."', '".$leads_Cdate[0]."', '".$data[2]."', 'Contact', '1','".$data[4]."', '".$now."')";
    $cmd_insert=mysqli_query($link_db,$insert);
    $insert="INSERT INTO partner_projects (QT_ID, Company, ToUser, QT_DATE, Sales, STATUS, Version, LeadsID, C_DATE) VALUES ('".$QuoteID."','".$data[0]."', '".$data[1]."', '".$leads_Cdate[0]."', '".$data[2]."', 'Contact', '1', '".$data[4]."', '".$now."')";
    $cmd_insert=mysqli_query($link_db,$insert);

    foreach ($sku as $key => $value) {
      if($value!=""){
        $strType="SELECT ProductType FROM partner_model WHERE SKU='".$value."'";
        $cmdType=mysqli_query($link_db,$strType);
        $dataType=mysqli_fetch_row($cmdType);
        $insert_item="INSERT INTO partner_projects_items_client (QT_ID, ProductTypeID, Products, Qty, Version, C_DATE) VALUES ('".$QuoteID."', '".$dataType[0]."','".$value."', '".$qty[$value]."', '1', '".$now."')";
        $cmd_item=mysqli_query($link_db,$insert_item);
        $insert_item="INSERT INTO partner_projects_items (QT_ID, ProductTypeID, Products, Qty, Version, C_DATE) VALUES ('".$QuoteID."', '".$dataType[0]."','".$value."', '".$qty[$value]."', '1', '".$now."')";
        $cmd_item=mysqli_query($link_db,$insert_item);
      }
    }
    
    $insert_extra="INSERT INTO partner_projects_extra_client (QT_ID, Version, C_DATE) VALUES ('".$QuoteID."', '1','".$now."')";
    $cmd_extra=mysqli_query($link_db,$insert_extra);
    $insert_extra="INSERT INTO partner_projects_extra (QT_ID, Version, C_DATE) VALUES ('".$QuoteID."', '1', '".$now."')";
    $cmd_extra=mysqli_query($link_db,$insert_extra);
  }
  $tmp=1;
  $insert="INSERT INTO partner_leads_slog (LeadsID, Status, NOTE, U_DATE) VALUES ('".$LeadsID."', '".$up_sel_status."', '".$status_note."', '".$now."')";
  if(mysqli_query($link_db,$insert)<1)
  {
    echo "insert error";
    mysqli_close($link_db);
    exit();
  }else{
    if($up_sel_status=="Verified" && $FEregister==1){
      $str_user="SELECT ID, Name, Email, CompanyName, CompanyID, CountryCode, Tel, Message FROM partner_user WHERE ID='".$UserID."'";
      $cmd_user=mysqli_query($link_db,$str_user);
      $data_user=mysqli_fetch_row($cmd_user);
      $username=$data_user[1];
      $email=$data_user[2];
      $CompanyName=$data_user[3];
      $CompanyID=$data_user[4];
      $CountryCode=$data_user[5];
      $Tel=$data_user[6];
      $Msg=$data_user[7];

      //******** rand 產生新密碼 ********
      $random=6; //亂數長度
      for ($i=1;$i<=$random;$i++){
        $c=rand(1,3);
        //chr()將數值轉變為對應英文
        if($c==1){
          $a=rand(97,122);$b=chr($a);
        }
        if($c==2){
          $a=rand(65,90);$b=chr($a);
        }
        if($c==3){
          $b=rand(0,9);
        }
        $newpassword=$newpassword.$b;
      }
      //**********************************

      $up_user="UPDATE partner_user SET Password='".$newpassword."', FirstLogin='1' WHERE ID='".$UserID."'";
      mysqli_query($link_db,$up_user);

      /*$user_content = "
      <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td align='center'>
      <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td style='padding: 25px 0;  '>
      <table  align='center'>
      <tr>
      <td style='width:220px'><img src='https://www.mitacmct.com/images/mct-logo-email.png' style='border:0px;' /></td>
      <td vlign='middle' align='center'> <div style='font-family: Arial; line-height:100%; font-size:20px; font-weight:bold; color:#434343;'> Partner Zone <br /><span style=' font-size:12px; font-weight:normal'>MiTAC Computing Technology</span></div></td>
      </tr>
      </table>
      </td>
      </tr>
      <!-- Email Body -->
      <tr>
      <td style='width: 100%; margin: 0; padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;border-top: 1px solid #EDEFF2;border-bottom: 1px solid #EDEFF2; background-color: #FFFFFF;' width='100%' cellpadding='0' cellspacing='0'>
      <table style='width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #FFFFFF;' align='center' width='570' cellpadding='0' cellspacing='0'>
      <!-- Body content -->
      <tr>
      <td style='padding: 35px;'>
      <h1 style='font-family: Arial; line-height:130%; text-align:left; font-size:16px'>Hi ".$username.",</h1>
      <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>

      Welcome to join MiTAC Partner Zone.  Now you can use your email with password below to log in Mitac Partner Zone.<br /><br />

      <span style='font-weight:bold; color:#000000; font-size:14px'>Password: ".$newpassword." </span>
      <br /><br />
      For your account security, please be sure to change your password after login. 

      </p>

      <table style='width: 100%;  margin: 30px auto;  padding: 0;  -premailer-width: 100%;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td align='center'>


      <br />
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
      <td align='center'>
      <table border='0' cellspacing='0' cellpadding='0'>
      <tr> <td>
      <a href='https://www.mitacmct.com/partner-backend/login' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' target='_blank'>LOG IN</a>
      </td>
      </tr>
      </table>
      </td>
      </tr>
      </table>
      <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>Thanks,
      <br>Partner Zone | MiTAC Computing Technology</p>
      <!-- Sub copy -->

      </td>
      </tr>
      </table>
      </td>
      </tr>
      <tr>
      <td>
      <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0' style='border-top:1px solid #ccc'>
      <tr>
      <td style='padding: 35px;' align='center'>
      <p style='font-family: arial; line-height:130%; font-size: 12px; text-align: center;'>This is an automatic message. Please do not reply to this email. <a href='https://www.mitacmct.com/EN/contact/' />Contact us via here. </a></p>

      </td>
      </tr>
      </table>
      </td>
      </tr>
      </table>
      </td>
      </tr>
      </table>
      <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0'>
      <tr>
      <td style='padding: 35px;' align='center'>
      <p style='font-family: arial; line-height:130%; font-size: 12px;text-align: center;'>&copy; MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. <br />All Rights Reserved.</p>

      </td>
      </tr>
      </table>";

      //****** To USER *******
      $mail= new PHPMailer(); //建立新物件   
      $mail->IsSMTP(); //設定使用SMTP方式寄信   
      $mail->SMTPAuth = false; //設定SMTP需要驗證   
      //$mail->SMTPSecure = "ssl"; //ssl tls
      //$mail->SMTPDebug = 2;
      $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
      $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
      $mail->CharSet = "utf-8"; //設定郵件編碼   

      $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
      $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

      $mail->From = "noreply-to-partner-zone@mitacmct.com"; //設定寄件者信箱   
      $mail->FromName = "Partner Zone | MiTAC Computing Technology"; //設定寄件者姓名   

      $mail->Subject = "Welcome to join MiTAC Partner Zone"; //設定郵件標題   
      $mail->Body = $user_content; //設定郵件內容 
      $mail->IsHTML(true); //設定郵件內容為HTML   
  $mail->SMTPAutoTLS = false;   
      $mail->AddAddress($email, $username); //設定收件者郵件及名稱 
      //$mail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
      if(!$mail->Send()) {
        $errorMail=$mail->ErrorInfo;

        $admail= new PHPMailer(); //建立新物件   
        $admail->IsSMTP(); //設定使用SMTP方式寄信   
        $admail->SMTPAuth = false; //設定SMTP需要驗證   
        //$mail->SMTPSecure = "ssl"; //ssl tls
        //$mail->SMTPDebug = 2;
        $admail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
        $admail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
        $admail->CharSet = "utf-8"; //設定郵件編碼   

        $admail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
        $admail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

        $admail->From = "noreply@tyan.com"; //設定寄件者信箱   
        $admail->FromName = "Tyan Computer"; //設定寄件者姓名   

        $admail->Subject = "Welcome to join MiTAC Partner Zone(lead Verified)"; //設定郵件標題   
        $admail->Body = $errorMail; //設定郵件內容 
        $admail->IsHTML(true); //設定郵件內容為HTML  
    $admail->SMTPAutoTLS = false;    
        $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
        //$admail->AddCC("even.syao@tyan.com.tw", "even.syao");  
        $admail->Send();   
        echo "Mailer Error(Mapped): " . $mail->ErrorInfo;  
        mysqli_close($link_db);
        exit(); 
      }else{

      }*/
    }elseif($up_sel_status=="Verified"){ 
      $str_user="SELECT ID, Name, Email, CompanyName, CompanyID, CountryCode, Tel, Message FROM partner_user WHERE ID='".$UserID."'";
      $cmd_user=mysqli_query($link_db,$str_user);
      $data_user=mysqli_fetch_row($cmd_user);
      $username=$data_user[1];
      $email=$data_user[2];
      $CompanyName=$data_user[3];
      $CompanyID=$data_user[4];
      $CountryCode=$data_user[5];
      $Tel=$data_user[6];
      $Msg=$data_user[7];

      /*$user_content = "
      <body style='margin: 0;padding: 0;'>

      <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td align='center'>
      <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td style='padding: 25px 0; text-align: center;'>
      <a href='https://www.mitacmct.com/SupportCenter' >
      <img src='https://www.mitacmct.com/support_center/images/tyan_logo_email.gif' style='border:0px' /></a><br /><br />
      </td>
      </tr>
      <!-- Email Body -->
      <tr>
      <td style='width: 100%; margin: 0; padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;border-top: 1px solid #EDEFF2;border-bottom: 1px solid #EDEFF2; background-color: #FFFFFF;' width='100%' cellpadding='0' cellspacing='0'>
      <table style='width: 570px; margin: 0 auto; padding: 0; -premailer-width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; background-color: #FFFFFF;' align='center' width='570' cellpadding='0' cellspacing='0'>
      <!-- Body content -->
      <tr>
      <td style='padding: 35px;'>
      <h2 style='font-family: Arial; line-height:130%; text-align:left; font-size:16px'>Hi ".$username.",</h2>

      <!-- Action -->
      <table style='width: 100%;  margin: 10px auto;  padding: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td align='center'>

      <p style='font-family: arial; line-height:130%;  text-align:left; font-size:16px'>

      There is a quotation ".$QuoteID." sent to you from MiTAC Partner Zone.
      Please log in MiTAC Partner Zone to check it.

      </p>
      <br />

      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
      <td align='center'>
      <table border='0' cellspacing='0' cellpadding='0'>
      <tr> <td>
      <a href='https://www.mitacmct.com/PartnerZone/' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' target='_blank'>LOG IN</a>
      </td>
      </tr>
      </table>
      </td>
      </tr>
      </table>    
      <p style='font-family: arial; line-height:130%; font-size:16px; text-align:left;'>Thanks!<br>MiTAC Partner Zone</p>
      <!-- Sub copy -->

      </td>
      </tr>
      </table>
      </td>
      </tr>
      <tr>
      <td>
      <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0' style='border-top:1px solid #ccc'>
      <tr>
      <td style='padding: 35px;' align='center'>
      <p style='font-family: arial; line-height:130%; font-size: 12px; text-align: center;'>This is an automatic message. Please do not reply to this email. </p>

      </td>
      </tr>
      </table>
      </td>
      </tr>
      </table>
      </td>
      </tr>
      </table>
      <table style='width: 570px;  margin: 0 auto;  padding: 0;  -premailer-width: 570px;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='570' cellpadding='0' cellspacing='0'>
      <tr>
      <td style='padding: 35px;' align='center'>
      <p style='font-family: arial; line-height:130%; font-size: 12px;text-align: center;'>&copy; MiTAC Computing Technology Corporation (MiTAC Group) and/or any of its affiliates. <br />All Rights Reserved.</p>

      </td>
      </tr>
      </table>
      </body>";

      //****** To USER *******
      $mail= new PHPMailer(); //建立新物件   
      $mail->IsSMTP(); //設定使用SMTP方式寄信   
      $mail->SMTPAuth = false; //設定SMTP需要驗證   
      //$mail->SMTPSecure = "ssl"; //ssl tls
      //$mail->SMTPDebug = 2;
      $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
      $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
      $mail->CharSet = "utf-8"; //設定郵件編碼   

      $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
      $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

      $mail->From = "noreply-to-tyan-partner-portal@tyan.com"; //設定寄件者信箱   
      $mail->FromName = "MiTAC Partner Zone"; //設定寄件者姓名   

      $mail->Subject = "Quotation Notification"; //設定郵件標題   
      $mail->Body = $user_content; //設定郵件內容 
      $mail->IsHTML(true); //設定郵件內容為HTML   
  $mail->SMTPAutoTLS = false;   
      $mail->AddAddress($email, $username); //設定收件者郵件及名稱 
      //$mail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
      if(!$mail->Send()) {
        $errorMail=$mail->ErrorInfo;

        $admail= new PHPMailer(); //建立新物件   
        $admail->IsSMTP(); //設定使用SMTP方式寄信   
        $admail->SMTPAuth = false; //設定SMTP需要驗證   
        //$mail->SMTPSecure = "ssl"; //ssl tls
        //$mail->SMTPDebug = 2;
        $admail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
        $admail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
        $admail->CharSet = "utf-8"; //設定郵件編碼   

        $admail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
        $admail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

        $admail->From = "noreply@tyan.com"; //設定寄件者信箱   
        $admail->FromName = "Tyan Computer"; //設定寄件者姓名   

        $admail->Subject = "Quotation Notification(lead Verified)"; //設定郵件標題   
        $admail->Body = $errorMail; //設定郵件內容 
        $admail->IsHTML(true); //設定郵件內容為HTML  
    $admail->SMTPAutoTLS = false;    
        $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
        //$admail->AddCC("even.syao@tyan.com.tw", "even.syao");  
        $admail->Send();   
        echo "Mailer Error(Mapped): " . $mail->ErrorInfo;  
        mysqli_close($link_db);
        exit(); 
      }*/
    }else{

    }
    //****** To USER END*******

    echo "success";
    mysqli_close($link_db);
    exit();
  }
}

?>