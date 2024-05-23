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

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="Send"){
  if($_POST['QTID']!=""){
    $QTID=dowith_sql($_POST['QTID']);
    $QTID=filter_var($QTID);
  }else{
    $QTID="";
  }

  if($_POST['AD']!=""){
    $AD=dowith_sql($_POST['AD']);
    $AD=filter_var($AD);
  }else{
    $AD="";
  }
  $strQT="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, Version, LeadsID, C_DATE, U_DATE FROM partner_projects WHERE QT_ID='".$QTID."'";
  $cmdQT=mysqli_query($link_db,$strQT);
  $dataQT=mysqli_fetch_row($cmdQT);
  $salesID=$dataQT[8];
  $QTID=$dataQT[1];
  $Version=$dataQT[12];
  if($Version=="" || $Version<1){
    $Version="1";
  }else{
    $Version=$Version+1;
  }

  // Sales先寫入下一版號, 若沒更新send則目前版號-1
  $u_str="UPDATE partner_projects SET Version='".$Version."' WHERE QT_ID='".$QTID."'";
  mysqli_query($link_db,$u_str);
  $u_str="UPDATE partner_projects_extra SET Version='".$Version."' WHERE QT_ID='".$QTID."'";
  mysqli_query($link_db,$u_str);
  $u_str="UPDATE partner_projects_items SET Version='".$Version."' WHERE QT_ID='".$QTID."'";
  mysqli_query($link_db,$u_str);


  //  project
  $Insert="INSERT INTO partner_projects_tmp (QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Version, LeadsID, ADID, C_DATE, U_DATE)";
  $Insert.=" VALUES ('".$QTID."', '".$dataQT[2]."', '".$dataQT[3]."', '".$dataQT[4]."', '".$dataQT[5]."', '".$dataQT[6]."', '".$dataQT[7]."', '".$dataQT[8]."', '".$dataQT[9]."', '".$Version."', '".$dataQT[13]."','".$AD."', '".$now."', '".$now."')";
  
  $cmd_project=mysqli_query($link_db,$Insert);
  $result=mysqli_affected_rows($link_db);  
  if($result>0){  
  }else{  
    echo "Projects error";
    mysqli_close($link_db);
    exit();
  } 
  //  project end

  // items
  $str_I="SELECT ID, QT_ID, ProductTypeID, ModelID, Products, Qty, UnitPrice, Description, Version, Sort, C_DATE, MiTAC_PN FROM partner_projects_items WHERE QT_ID='".$QTID."'";
  $cmdQT_I=mysqli_query($link_db,$str_I);
  while ($dataQT_I=mysqli_fetch_row($cmdQT_I)) {
    $Insert_I="INSERT INTO partner_projects_items_tmp (QT_ID, ProductTypeID, ModelID, Products, Qty, UnitPrice, Description, Version, Sort, MiTAC_PN, C_DATE)";
    $Insert_I.=" VALUES ('".$dataQT_I[1]."', '".$dataQT_I[2]."', '".$dataQT_I[3]."', '".$dataQT_I[4]."', '".$dataQT_I[5]."','".$dataQT_I[6]."','".$dataQT_I[7]."','".$Version."','".$dataQT_I[9]."','".$dataQT_I[11]."', '".$now."')";
    $cmd_items=mysqli_query($link_db,$Insert_I);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){  
    }else{  
      echo "Projects items error";
      mysqli_close($link_db);
      exit();
    } 
  }
  // items end

  // extra
  $str_E="SELECT ID, QT_ID, Item, Price, Version, Sort, C_DATE FROM partner_projects_extra WHERE QT_ID='".$QTID."'";
  $cmdQT_E=mysqli_query($link_db,$str_E);
  while ($dataQT_E=mysqli_fetch_row($cmdQT_E)) {

    $Insert_E="INSERT INTO partner_projects_extra_tmp (QT_ID, Item, Price, Version, Sort, C_DATE)";
    $Insert_E.=" VALUES ('".$dataQT_E[1]."', '".$dataQT_E[2]."', '".$dataQT_E[3]."', '".$Version."', '".$dataQT_E[5]."', '".$now."')";
    $cmd_extra=mysqli_query($link_db,$Insert_E);
    $result=mysqli_affected_rows($link_db);  
    if($result>0){   
    }else{  
      echo "Projects extra error";
      mysqli_close($link_db);
      exit();
    } 
  }
  // extra end

  /*$str="SELECT CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE ID='".$AD."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_fetch_row($cmd);
  $mail=$result[5];
  $username=$result[4];*/

  $str_reSales="SELECT ID, NAME, EMAIL, Role FROM partner_sales WHERE ID='".$salesID."'"; // general sales
  $cmd_reSales=mysqli_query($link_db,$str_reSales);
  $data_reSales=mysqli_fetch_row($cmd_reSales);
  $SalesName=$data_reSales[1];

  $strSales="SELECT ID, NAME, EMAIL, Role FROM partner_sales WHERE ID='".$AD."' AND Role='AD' AND checkbox='1'"; // AD sales
  $cmdSales=mysqli_query($link_db,$strSales);
  $Sales=mysqli_fetch_row($cmdSales);
  $email=$Sales[2]; 
  $username=$Sales[1];
  $content="
  <body style='margin: 0;padding: 0;'>
  
  <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td align='center'>
  <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td style='padding: 25px 0; text-align: center;'>
  <a href='https://www.tyan.com/SupportCenter' >
  <img src='https://www.tyan.com/support_center/images/tyan_logo_email.gif' style='border:0px' /></a><br /><br />
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

  ".$SalesName." is sending you this quotation for your approval.
  </p>




  <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
  <a href='https://www.mitacmct.com/PartnerZone/emailNotification/quoteApproval@".$QTID."' />Please click here to check and approve.</a>

  </p>
  <br />      
  <p style='font-family: arial; line-height:130%; font-size:16px; text-align:left;'>MiTAC Partner Zone</p>
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

  $mail->From = "no-reply@tyan.com"; //設定寄件者信箱   
  $mail->FromName = "MiTAC Partner Zone"; //設定寄件者姓名   

  $mail->Subject = "Require quotation approval"; //設定郵件標題   
  $mail->Body = $content; //設定郵件內容 
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

    $admail->Subject = "Send Quote"; //設定郵件標題   
    $admail->Body = $errorMail; //設定郵件內容 
    $admail->IsHTML(true); //設定郵件內容為HTML  
    $admail->SMTPAutoTLS = false;    
    $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱 
    $admail->AddCC("even.syao@tyan.com.tw", "even.syao");  
    $admail->Send();   
    echo "Mailer Error: " . $mail->ErrorInfo;  
    mysqli_close($link_db);
    exit(); 
  } else {   
    echo "success";
    mysqli_close($link_db);
    exit();
  }

}

?>