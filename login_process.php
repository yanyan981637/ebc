<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

session_start();

error_reporting(0);

require "config.php";
include("EN/PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

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

if($_COOKIE['RFQsku']!=""){
  $RFQsku=dowith_sql($_COOKIE['RFQsku']);
  $RFQsku=filter_var($RFQsku);
}else{
  $RFQsku="";
}

if($_COOKIE['RFQnum']!=""){
  $RFQnum=dowith_sql($_COOKIE['RFQnum']);
  $RFQnum=filter_var($RFQnum);
}else{
  $RFQnum="";
}

putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");

if($kind=="Login"){
  if($_POST['mail']!=""){
    $mail=trim(dowith_sql($_POST['mail']));
    $mail=filter_var($mail);
  }else{
    $mail="";
  }
  if($_POST['topPW']!=""){
    $topPW=trim(dowith_sql($_POST['topPW']));
    $topPW=filter_var($topPW);
  }else{
    $topPW="";
  }
  if($_POST['Checknum1']!=""){
    $Checknum1=trim(dowith_sql($_POST['Checknum1']));
    $Checknum1=filter_var($Checknum1);
  }else{
    $Checknum1="";
  }
  if($_POST['terms']!=""){  // keep login
    $terms=trim(dowith_sql($_POST['terms']));
    $terms=filter_var($terms);
  }else{
    $terms="";
  }

  $str="SELECT ID, Name, Email, Password, FirstLogin FROM partner_user WHERE Email='".$acc_mail."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num==0){
    echo "errMsg";
    mysqli_close($link_db);
    exit();
  }
  if(isset($_SESSION["Checknum"])!=''){
    if($_SESSION["Checknum"]==$Checknum1){


      $cmd=mysqli_query($link_db,$str);
      $user=mysqli_fetch_row($cmd);
      $UID=$user[0];

      if($RFQsku!="" && $RFQnum!=""){
        $RFQ=addRFQ($RFQsku, $RFQnum, $UID,$link_db,$select);
        if($RFQ=="susses"){
          setcookie("RFQsku","",time()-3600*24*7);
          setcookie("RFQnum","",time()-3600*24*7);
        }else{
          echo $RFQ;
          exit();
        }
      }


      if($user[4]=="1"){

        if($user[3]==$password) {
          //echo 'Password is valid!';
        }else{

            echo "errMsg"; //error
            mysqli_close($link_db);
            exit();
        }
      }else{
        if(password_verify($password, $user[3])) {
          //echo 'Password is valid!';
        }else{
            echo "errMsg"; //error
            mysqli_close($link_db);
            exit();
        }
      }

      putenv("TZ=Asia/Taipei");
      $login_time=date("Y,m d,h:i:s A");

      $_SESSION['FEID']=$user[0];
      $_SESSION['FEuser']=$user[1];
      $_SESSION['login_time']=$login_time;

      if($terms=="true"){ // keep login
        $key = 'T!Y^A@N*';
        $encrypt = encrypt($user[2], $key);
        setcookie("cuser",$encrypt,time()+3600*24*7);
        //setcookie("cun",$user[1]);
        setcookie("IN", "1", time()+3600, '/', "tyan.com");// login status
        //setcookie("cp",$PW,time()+3600*24*7);
      }else{
        $datetime="";
        setcookie("cuser","",time()-3600*24*7);
        //setcookie("cun",$user[1]);
        setcookie("IN", "1", time()+3600, '/', "tyan.com");// login status
        //setcookie("cp","",time()-3600*24*7);
      }

      setcookie("RFQsku","",time()-3600*24*7);

      if($user[4]=="1"){
        echo "FEpassword@".$user[0];
      }else{
        echo "success";
      }
      $_SESSION['start'] = time(); // Taking now logged in time.
      // Ending a session in 30 minutes from the starting time.
      $_SESSION['expire'] = $_SESSION['start'] + (30*60);
      mysqli_close($link_db);
      exit();
    }else{
      echo "captacha";
      mysqli_close($link_db);
      exit();
    }
  }else{
    echo "captacha";
    mysqli_close($link_db);
    exit();
  }
}

if($kind=="reset"){
  if($_POST['mail']!=""){
    $mail=trim(dowith_sql($_POST['mail']));
    $mail=filter_var($mail);
  }else{
    $mail="";
  }

  $str="SELECT ID, Name, Email, Password, FirstLogin FROM partner_user WHERE Email='".$mail."'";
  $cmd=mysqli_query($link_db,$str);
  $num=mysqli_num_rows($cmd);
  if($num==0){
    echo "errMsg";
    mysqli_close($link_db);
    exit();
  }

  $cmd=mysqli_query($link_db,$str);
  $data=mysqli_fetch_row($cmd);
  $ID=$data[0];
  $username=$data[1];
  $email=$data[2];

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

  $hash = password_hash($password, PASSWORD_DEFAULT);

  $str="UPDATE partner_user SET Password='".$password."', FirstLogin='1', U_DATE='".$now."' WHERE ID='".$ID."'";
  $cmd=mysqli_query($link_db,$str);
  $result=mysqli_affected_rows($link_db);
  if($result>0){
  }else{
    echo "Update error";
    mysqli_close($link_db);
    exit();
  }
  $content="
  <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td align='center'>
  <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td style='padding: 25px 0; text-align: center; '>
  <a href='https://www.tyan.com/SupportCenter' >
  <img src='https://www.tyan.com/support_center/images/tyan_logo_email.gif' style='border:0px' /></a>&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-family: Arial; line-height:130%; font-size:20px; font-weight:bold; color:#434343;'>Tyan Partner Portal</span>

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
  <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>Your password for logging in Tyan Partner Portal has been reset to:<br /><span style='font-weight:bold; color:#000000; font-size:14px'>".$password."</span></p>
  <!-- Action -->
  <table style='width: 100%;  margin: 30px auto;  padding: 0;  -premailer-width: 100%;  -premailer-cellpadding: 0;  -premailer-cellspacing: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
  <tr>
  <td align='center'>

  <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>Please use this new password to log in Tyan Partner Portal. For your account security, please change your password after login.</p>
  <br />
  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
  <td align='center'>
  <table border='0' cellspacing='0' cellpadding='0'>
  <tr> <td>
  <a href='https://partner.tyan.com/' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' target='_blank'>LOG IN</a>
  </td>
  </tr>
  </table>
  </td>
  </tr>
  </table>
  <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>Thanks,
  <br>Tyan Partner Portal</p>
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
  <p style='font-family: arial; line-height:130%; font-size: 12px; text-align: center;'>This is an automatic message. Please do not reply to this email. <a href='https://www.tyan.com/EN/contact/' />Contact us via here. </a></p>

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
    ";

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
  $mail->FromName = "Tyan Partner Portal"; //設定寄件者姓名

  $mail->Subject = "Your password has been reset."; //設定郵件標題
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

    $admail->From = "noreply-to-tyan-partner-portal@tyan.com"; //設定寄件者信箱
    $admail->FromName = "Tyan Partner Portal";; //設定寄件者姓名

    $admail->Subject = "Your password has been reset."; //設定郵件標題
    $admail->Body = $errorMail; //設定郵件內容
    $admail->IsHTML(true); //設定郵件內容為HTML
    $admail->SMTPAutoTLS = false;
    $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱
    //$admail->AddCC("even.syao@tyan.com.tw", "even.syao");
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

if($kind=="logout"){
  header("Content-Type:text/html; charset=utf-8");
  //開啟Session
  session_start();
  //清除Session
  session_destroy();
  setcookie("IN", "", time()-3600, '/', "tyan.com");// login status
  echo "success";
  mysqli_close($link_db);
  exit();
}
?>
