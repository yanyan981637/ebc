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
if($_SESSION['FEuser']=="" || $_SESSION['FEID']==""){
  echo "<script language='javascript'>self.location='index.html'</script>";
  exit;
}

require "config.php";
include("PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別

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

if($_POST['kind']!=""){
  $kind=dowith_sql($_POST['kind']);
  $kind=filter_var($kind);
}else{
  $kind="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="addMembers"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['name']!=""){
    $name=dowith_sql($_POST['name']);
    $name=filter_var($name);
  }else{
    $name="";
  }
  if($_POST['email']!=""){
    $email=dowith_sql($_POST['email']);
    $email=filter_var($email);
  }else{
    $email="";
  }
  if($_POST['title']!=""){
    $title=dowith_sql($_POST['title']);
    $title=filter_var($title);
  }else{
    $title="";
  }
  if($_POST['countryCode']!=""){
    $countryCode=dowith_sql($_POST['countryCode']);
    $countryCode=filter_var($countryCode);
  }else{
    $countryCode="";
  }
  if($_POST['tel']!=""){
    $tel=dowith_sql($_POST['tel']);
    $tel=filter_var($tel);
  }else{
    $tel="";
  }
  if($_POST['Count']!=""){
    $Count=dowith_sql($_POST['Count']);
    $Count=filter_var($Count);
  }else{
    $Count="";
  }
  $tmp_name=explode("+",$name);
  $tmp_email=explode("+",$email);
  $tmp_title=explode("+",$title);
  $tmp_countryCode=explode("+",$countryCode);
  $tmp_tel=explode("`",$tel);
  $i=0; // display mail error number[][]
  foreach ($tmp_email as $key => $value) {

      $str_user="SELECT ID, Name, Email FROM partner_user WHERE Email='".$value."'";
      $cmd_user=mysqli_query($link_db,$str_user);
      $num=mysqli_num_rows($cmd_user);

      if($num>0){
        echo $i;
        mysqli_close($link_db);
        exit();
      }
      $i++;

  }

  // Title Company Name
  $str="SELECT distinct CompanyName, ID, CompanyID, CompanyAddress, Name, Email, Title, CountryCode, Tel, ResponsibleSales, C_DATE, U_DATE FROM partner_user WHERE CompanyID='".$CompanyID."' ";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_fetch_row($cmd);
  // Title Company Name End

  for ($j=0; $j < $Count; $j++) {
    $country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CodeNumber='".$tmp_countryCode[$j]."'";
    $cmd_country=mysqli_query($link_db,$country);
    $result_country=mysqli_fetch_row($cmd_country);
    if($result_country[2]==""){
      $CountryCode=$tmp_countryCode[$j];
    }else{
      $CountryCode=$result_country[2];
    }

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
      $password=$password.$b;
    }
    //**********************************

    $str="INSERT INTO partner_user (CompanyID, Name, CompanyName, CompanyAddress, Title, Email, Password, CountryCode, Tel, ResponsibleSales, FirstLogin, C_DATE)";
    $str.=" VALUES ('".$result[2]."','".$tmp_name[$j]."', '".$result[0]."', '".$result[3]."', '".$tmp_title[$j]."', '".$tmp_email[$j]."', '".$password."', '".$CountryCode."', '".$tmp_tel[$j]."', '".$result[9]."', '1', '".$now."')";
    if(mysqli_query($link_db,$str)<1)
    {
      echo "Insert member error";
      mysqli_close($link_db);
      exit();
    }else{
    }

    $email=$tmp_email[$j];
    $username=$tmp_name[$j];

    $user_content = "
    <body style='margin: 0;padding: 0;'>

    <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
    <tr>
    <td align='center'>
    <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
    <tr>
    <td style='padding: 25px 0; text-align: center; '>
    <a href='#' >
    <img src='https://ipc.mitacmdt.com/support_center/images/tyan_logo_email.gif' style='border:0px' /></a>&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-family: Arial; line-height:130%; font-size:20px; font-weight:bold; color:#434343;'>MiTAC Partner Zone</span>

    </a>
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

    We're emailing to notify your account info for MiTAC Partner Zone. Now you can use your email with password below to log in MiTAC Partner Zone.<br /><br />

    <span style='font-weight:bold; color:#000000; font-size:14px'>Password: ".$password." </span>
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
    <a href='https://ipc.mitacmdt.com/' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' target='_blank'>LOG IN</a>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>Thanks,
    <br>MiTAC Partner Zone</p>
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
    <p style='font-family: arial; line-height:130%; font-size: 12px; text-align: center;'>This is an automatic message. Please do not reply to this email. <a href='https://ipc.mitacmdt.com/EN/contact/' />Contact us via here. </a></p>

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

    $mail->Subject = "Account info for MiTAC Partner Zone"; //設定郵件標題
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

      $admail->Subject = "Account info for MiTAC Partner Zone"; //設定郵件標題
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
    //****** To USER END*******
   }

  echo "success";
  mysqli_close($link_db);
  exit();
}

if($kind=="eCompany"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['name']!=""){
    $name=dowith_sql($_POST['name']);
    $name=filter_var($name);
  }else{
    $name="";
  }
  if($_POST['Address']!=""){
    $Address=dowith_sql($_POST['Address']);
    $Address=filter_var($Address);
  }else{
    $Address="";
  }

  $str="UPDATE partner_user SET CompanyName='".$name."', CompanyAddress='".$Address."', U_DATE='".$now."' WHERE CompanyID='".$CompanyID."'";
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

if($kind=="delMembers"){
  if($_POST['Delete']!=""){
    $Delete=dowith_sql($_POST['Delete']);
    $Delete=filter_var($Delete);
  }else{
    $Delete="";
  }

  $str="DELETE FROM partner_user WHERE ID='".$Delete."' ";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);
  if($result>0){
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{
    echo "Delete member error";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="editMembers"){
  if($_POST['CompanyID']!=""){
    $CompanyID=dowith_sql($_POST['CompanyID']);
    $CompanyID=filter_var($CompanyID);
  }else{
    $CompanyID="";
  }
  if($_POST['editID']!=""){
    $editID=dowith_sql($_POST['editID']);
    $editID=filter_var($editID);
  }else{
    $editID="";
  }
  if($_POST['name']!=""){
    $name=dowith_sql($_POST['name']);
    $name=filter_var($name);
  }else{
    $name="";
  }
  if($_POST['email']!=""){
    $email=dowith_sql($_POST['email']);
    $email=filter_var($email);
  }else{
    $email="";
  }
  if($_POST['title']!=""){
    $title=dowith_sql($_POST['title']);
    $title=filter_var($title);
  }else{
    $title="";
  }
  if($_POST['countryCode']!=""){
    $countryCode=dowith_sql($_POST['countryCode']);
    $countryCode=filter_var($countryCode);
  }else{
    $countryCode="";
  }
  if($_POST['tel']!=""){
    $tel=dowith_sql($_POST['tel']);
    $tel=filter_var($tel);
  }else{
    $tel="";
  }

  /*$country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CountryCode='".$countryCode."'";
  $cmd_country=mysqli_query($link_db,$country);
  $result_country=mysqli_fetch_row($cmd_country);
  $CountryCode=$result_country[2];*/

  $str_user="SELECT ID, Name, Email FROM partner_user WHERE Email='".$email."'";
  $cmd_user=mysqli_query($link_db,$str_user);
  $num=mysqli_num_rows($cmd_user);
  if($num>0){
    /*echo "repeat";
    mysqli_close($link_db);
    exit();*/
  }

  $str="UPDATE partner_user SET Name='".$name."', Email='".$email."', Title='".$title."', CountryCode='".$countryCode."', Tel='".$tel."'";
  $str.=" WHERE ID='".$editID."'";
  $cmd=mysqli_query($link_db,$str);
  if(mysqli_query($link_db,$str)<1)
  {
    echo "Update Members error";
    mysqli_close($link_db);
    exit();
  }else{
    echo "success";
    mysqli_close($link_db);
    exit();
  }
  /*$result=mysqli_affected_rows($cmd);
  if($result>0){
    echo "success";
    mysqli_close($link_db);
    exit();
  }else{
    echo "Update Members error";
    mysqli_close($link_db);
    exit();
  }  */
}
mysqli_close($link_db);
exit();

?>