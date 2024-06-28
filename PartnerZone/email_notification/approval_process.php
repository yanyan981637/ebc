<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
  echo "<script language='javascript'>self.location='/index.html'</script>";
  exit;
}
error_reporting(0);

session_start();
/*if($_SESSION['FEuser']=="" || $_SESSION['FEID']==""){
  echo "<script language='javascript'>self.location='index.html'</script>";
  exit;
}*/

require "../config.php";
include("../PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別

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

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($_POST['QT']!=""){ // 非QT_ID
  $QT=dowith_sql($_POST['QT']);
  $QT=filter_var($QT);
}else{
  $QT="";
}
if($_POST['QT_ID']!=""){
  $QT_ID=dowith_sql($_POST['QT_ID']);
  $QT_ID=filter_var($QT_ID);
}else{
  $QT_ID="";
}
if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

if($kind=="N"){

  $update="UPDATE partner_projects_tmp SET Approval_N='1' WHERE ID='".$QT."'";
  $cmd_up=mysqli_query($link_db,$update);

  $str="SELECT COUNT(*) FROM partner_projects_tmp WHERE QT_ID='".$QT_ID."' AND Approval_N='1'";
  $cmd=mysqli_query($link_db,$str);
  $num_N=mysqli_fetch_row($cmd);
  if($num_N[0]==0){
    $total=1;
  }else{
    $total=$num_N[0];
  }
  $update1="UPDATE partner_projects SET Approval_N='".$total."' WHERE QT_ID='".$QT_ID."'";
  $cmd_up1=mysqli_query($link_db,$update1);

  echo "success";
  exit();

}else{

  $update="UPDATE partner_projects_tmp SET Approval_Y='1' WHERE ID='".$QT."'";
  $cmd_up=mysqli_query($link_db,$update);

  $str="SELECT COUNT(*) FROM partner_projects_tmp WHERE QT_ID='".$QT_ID."' AND Approval_Y='1'";
  $cmd=mysqli_query($link_db,$str);
  $num_N=mysqli_fetch_row($cmd);
  if($num_N[0]==0){
    $total=1;
  }else{
    $total=$num_N[0];
  }
  $update1="UPDATE partner_projects SET Approval_Y='".$total."' WHERE QT_ID='".$QT_ID."'";
  $cmd_up1=mysqli_query($link_db,$update1);

  $strQT="SELECT ID, QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, Version, LeadsID, C_DATE, U_DATE FROM partner_projects_tmp WHERE ID='".$QT."'";
  $cmdQT=mysqli_query($link_db,$strQT);
  $dataQT=mysqli_fetch_row($cmdQT);
  $QT_ID=$dataQT[1];
  $userID=$dataQT[3];
  $user_version=$dataQT[12];
  /*$strQT_U="SELECT Version FROM partner_projects_client WHERE QT_ID='".$QT_ID."'  ORDER BY Version DESC";
  $cmdQT_U=mysqli_query($link_db,$strQT_U);
  $dataQT_U=mysqli_fetch_row($cmdQT_U);
  $user_version=$dataQT_U[0];
  if($user_version==0 || $user_version==""){
    $user_version=1;
  }else{
    $user_version=$user_version+1;
  }*/

  $Insert="INSERT INTO partner_projects_client (QT_ID, Company, ToUser, QT_DATE, Due_DATE, Terms, Remarks, Sales, STATUS, Approval_Y, Approval_N, Version, LeadsID, C_DATE, U_DATE)";
  $Insert.=" VALUES ('".$QT_ID."', '".$dataQT[2]."', '".$dataQT[3]."', '".$dataQT[4]."', '".$dataQT[5]."', '".$dataQT[6]."', '".$dataQT[7]."', '".$dataQT[8]."', '".$dataQT[9]."', '".$dataQT[10]."', '".$dataQT[11]."', '".$user_version."', '".$dataQT[13]."', '".$now."', '".$now."')";
  $cmd=mysqli_query($link_db,$Insert);
  $result=mysqli_affected_rows($link_db);
  if($result>0){

  }else{
    echo "Projects error";
    mysqli_close($link_db);
    exit();
  }


  // items
  $str_I="SELECT ID, QT_ID, ProductTypeID, ModelID, Products, Qty, UnitPrice, Description, Version, Sort, C_DATE, MiTAC_PN FROM partner_projects_items_tmp WHERE QT_ID='".$QT_ID."' AND Version='".$dataQT[12]."'";
  $cmdQT_I=mysqli_query($link_db,$str_I);
  while ($dataQT_I=mysqli_fetch_row($cmdQT_I)) {
    $Insert_I="INSERT INTO partner_projects_items_client (QT_ID, ProductTypeID, ModelID, Products, MiTAC_PN, Qty, UnitPrice, Description, Version, Sort, C_DATE)";
    $Insert_I.=" VALUES ('".$dataQT_I[1]."', '".$dataQT_I[2]."', '".$dataQT_I[3]."', '".$dataQT_I[4]."', '".$dataQT_I[11]."', '".$dataQT_I[5]."','".$dataQT_I[6]."','".$dataQT_I[7]."','".$user_version."','".$dataQT_I[9]."', '".$now."')";
    $cmd_I=mysqli_query($link_db,$Insert_I);
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
  $str_E="SELECT ID, QT_ID, Item, Price, Version, Sort, C_DATE FROM partner_projects_extra_tmp WHERE QT_ID='".$QT_ID."' AND Version='".$dataQT[12]."'";
  $cmdQT_E=mysqli_query($link_db,$str_E);
  while ($dataQT_E=mysqli_fetch_row($cmdQT_E)) {
    $Insert_E="INSERT INTO partner_projects_extra_client (QT_ID, Item, Price, Version, Sort, C_DATE)";
    $Insert_E.=" VALUES ('".$dataQT_E[1]."', '".$dataQT_E[2]."', '".$dataQT_E[3]."', '".$user_version."', '".$dataQT_E[5]."', '".$now."')";
    $cmd=mysqli_query($link_db,$Insert_E);
    $result=mysqli_affected_rows($link_db);
    if($result>0){

    }else{
      echo "Projects extra error";
      mysqli_close($link_db);
      exit();
    }
  }
  // extra end

  $user="SELECT Name, Email FROM partner_user WHERE ID='".$userID."'";
  $cmd_user=mysqli_query($link_db,$user);
  $data_user=mysqli_fetch_row($cmd_user);
  $email=$data_user[1];
  $username=$data_user[0];
  $user_content = "
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

  There is a quotation - ".$QT_ID." sent to you from MiTAC Partner Zone.
  Please log in MiTAC Partner Zone to check it.

  </p>




  <br />

  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
  <td align='center'>
  <table border='0' cellspacing='0' cellpadding='0'>
  <tr> <td>
  <a href='https://ipc.mitacmdt.com/PartnerZone/' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' target='_blank'>LOG IN</a>
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
  <p style='font-family: arial; line-height:130%; font-size: 12px;text-align: center;'>&copy; MiTAC Digital Technology Corporation and/or any of its affiliates. <br />All Rights Reserved.</p>

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
      $admail->FromName = "MiTAC Partner Zone"; //設定寄件者姓名

      $admail->Subject = "Approval to user"; //設定郵件標題
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
      echo "success";
      mysqli_close($link_db);
      exit();
    }
    //****** To USER END*******


}



?>