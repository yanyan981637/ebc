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


session_start();

require "./config.php";
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

$kind="RFQ";
putenv("TZ=Asia/Taipei");
$now=date("Y/m/d H:i:s");
$now1=date("Y/m/d");

if($kind1=="done"){ // 由panrtner loginRFQ 登入成功後轉tyan清cookie
  setcookie("RFQsku", "", time()-3600);// login status
  setcookie("RFQnum", "", time()-3600);// login status
  header('Location: https://ipc.mitacmdt.com/PartnerZone/FEdashboard');
  exit();
}

if($kind=="RFQ"){
	if($_SESSION['FEID']!=""){
		$UID=$_SESSION['FEID'];
		$UID=dowith_sql($UID);
		$UID=filter_var($UID);
	}
	/*if($_COOKIE["cun"]!=""){ //user name
		$cun=$_COOKIE["cun"];
		$cun=dowith_sql($cun);
		$cun=filter_var($cun);
	}*/
	if($_GET['rfq']!=""){
	  $RFQ_SKU=dowith_sql($_GET['rfq']);
	  $RFQ_SKU=filter_var($RFQ_SKU);
	}else{
	  $RFQ_SKU="";
	}
	if($_GET['qty']!=""){
	  $Qnum=dowith_sql($_GET['qty']);
	  $Qnum=filter_var($Qnum);
	}else{
	  $Qnum="";
	}

	if($RFQ_SKU!=""){
		$arr_sku=explode("+" , $RFQ_SKU);
    $arr_Qty=explode("+" , $Qnum);
    foreach ($arr_sku as $key => $value) {
      $new_arrQty[$value]=$arr_Qty[$key];
    }
		$j=0;
    foreach ($arr_sku as $key => $value) {
      if($value!=""){
        $Quote=$arr_Qty[$key]; // 之後要抓前台值
        $str="SELECT Product_SKU_Auto_ID, SKU, MODELCODE, Quote, ProductTypeID FROM product_skus WHERE SKU='".$value."' AND Product_SKU_Auto_ID>'700000000'";
        $cmd=mysqli_query($link_db,$str);
        $result=mysqli_fetch_row($cmd);
        $arrPID.=$result[0].",";
        $arrPTID.=$result[4].",";
        $arrSKU.=$result[1].",";
        $arrMODEL.=$result[2].",";
        $arrQty.=$result[1]."$".$Quote.",";


      }
      $j++;
    }

    $str_UID="SELECT ID, CompanyName, Email, CompanyID, Name, ResponsibleSales, CountryCode, Tel FROM partner_user WHERE ID='".$UID."'";
    $cmd_UID=mysqli_query($link_db,$str_UID);
    $result_UID=mysqli_fetch_row($cmd_UID);
    $CompanyID=$result_UID[3];
    $companyname=$result_UID[1];
    $username=$result_UID[4];
    $email=$result_UID[2];
    $salesID=$result_UID[5];
    $countryCode=$result_UID[6];
    $tel=$result_UID[7];

    $strQuoteID="SELECT ID FROM partner_leads_quote WHERE 1 ORDER BY ID DESC";
    $cmdQuoteID=mysqli_query($link_db,$strQuoteID);
    $resultQuoteID=mysqli_fetch_row($cmdQuoteID);
    if($resultQuoteID[0]==""){

      $QuoteID="LD1000001";
    }else{
      $arr_ID=explode("LD" , $resultQuoteID[0]);
      $QuoteID=$arr_ID[1]+1;
      $QuoteID="LD".$QuoteID;
    }
    $Verification=date("Y/m/d H:i:s", strtotime("+1 months", strtotime($now)));

    if($arrSKU!=""){
      $str_inst_sq="INSERT INTO partner_leads_quote(ID, SalesID, UserID, CompanyID, Product_ID, ProductTypeID, MODEL, SKU, QuoteQty, Verification, STATUS, C_DATE)";
      $str_inst_sq.=" VALUES ('".$QuoteID."','".$salesID."','".$UID."','".$CompanyID."','".$arrPID."','".$arrPTID."','".$arrMODEL."','".$arrSKU."','".$arrQty."','".$Verification."','Processing','".$now."')";
      $cmd_sq=mysqli_query($link_db,$str_inst_sq);
      $result=mysqli_affected_rows($link_db);
      if($result>0){

      }else{
        echo "Insert partner_leads_quote error";
        mysqli_close($link_db);
        exit();
      }
    }

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
                        <h2 style='font-family: Arial; line-height:130%; text-align:left; font-size:14px'>Hi ".$username.",</h2>

                        <!-- Action -->
                        <table style='width: 100%;  margin: 10px auto;  padding: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                          <tr>
                            <td align='center'>

                              <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>

                               Thank you for your interest in Tyan Computer. <br />
                               Our sales representative will contact with you shortly via telephone or email to check your requirements.
                               <br />
                               Here are the request info.<br /><br />
                               =============================<br />
                               Lead ID: ".$QuoteID."<br />
                               Company Name: ".$companyname.". (".$CompanyID.")

                             </p>
                             <!--if there is RFQ, then show this-->

                             <table style='width: 100%;  padding: 0px;  text-align: left; font-family: arial;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                              <tr><th colspan='2' ><h3>RFQ:</h3></th></tr>
                              <tr style='background:#eee'><th style='padding:5px'>Product</th><th style='padding:5px'>Qty</th></tr>";
                              $tmp_sku=explode("," , $arrSKU);
                              $tmp_MODEL=explode("," , $arrMODEL);
                              foreach ($tmp_sku as $key => $value) {
                                if($value!=""){
                                  $user_content .= "<tr><td style='padding:5px; border-bottom:1px solid #eee'>".$value." (".$tmp_MODEL[$key].")</td><td style='padding:5px; border-bottom:1px solid #eee'>".$new_arrQty[$value]."</td></tr>";
                                }
                              }
                              $user_content .= "

                            </table>

                            <!--end RFQ-->

                            <br /><br />


                          </p><p style='font-family: arial; line-height:130%; font-size:12px; text-align:left;'>With Regards<br />MiTAC Partner Zone</p>
                          <br /><br />


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

      $mail->Subject = "Thank you for requesting a quote"; //設定郵件標題
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

        $admail->Subject = "Thank you for requesting a quote(TO user)"; //設定郵件標題
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

      $str_country="SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CountryCode='".$countryCode."'";
      $cmd_country=mysqli_query($link_db,$str_country);
      $CodeNumber=mysqli_fetch_row($cmd_country);
      $CodeNumber1=$CodeNumber[4];
      $srt_sales="SELECT ID, NAME, EMAIL FROM partner_sales WHERE ID='".$salesID."'";
      $cmd_sales=mysqli_query($link_db,$srt_sales);
      $data_sales=mysqli_fetch_row($cmd_sales);
      $Semail=$data_sales[2];
      $Susername=$data_sales[1];
      //****** To Sales *******
      $Sales_content = "
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
      <h2 style='font-family: Arial; line-height:130%; text-align:left; font-size:14px'>Hi, ".$Susername."</h2>

      <!-- Action -->
      <table style='width: 100%;  margin: 10px auto;  padding: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
      <tr>
      <td align='center'>

      <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>

      There is a new request from MiTAC Partner Zone.<br />
      Here are the details.<br /><br />
      =============================<br />
      Lead ID: ".$QuoteID."<br />
      User Name: ".$username."<br />
      Company Name: ".$companyname." (".$CompanyID.")<br />
      Email Address: ".$email."<br />
      Contact Tel: +".$CodeNumber1." ".$tel."<br />
      Message: ".$Msg."
      </p>
      <!--if there is RFQ, then show this-->

      <table style='width: 100%;  padding: 0px;  text-align: left; font-family: arial;' align='center' width='100%' cellpadding='0' cellspacing='0'>
      <tr><th colspan='2' ><h3>RFQ:</h3></th></tr>
      <tr style='background:#eee'><th style='padding:5px'>Product</th><th style='padding:5px'>Qty</th></tr>";
      $tmp_sku=explode("," , $arrSKU);
      $tmp_MODEL=explode("," , $arrMODEL);
      foreach ($tmp_sku as $key => $value) {
        if($value!=""){
          $Sales_content .= "<tr><td style='padding:5px; border-bottom:1px solid #eee'>".$value." (".$tmp_MODEL[$key].")</td><td style='padding:5px; border-bottom:1px solid #eee'>".$new_arrQty[$value]."</td></tr>";
        }
      }
      $Sales_content .= "
      </table>

      <!--end RFQ-->

      <br /><br />

      <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
      Please contact with the client ASAP. If there is no action for this request after 3 days, the system will update it to 'Invalid' status automatically. <br /><br />

      You can <a href='https://www.tyan.com/partner-backend/login' />log into MiTAC Partner Zone Back-end</a> and go to <strong>'Leads Mgt'</strong> to check / proceed this request.

      </p>
      <br /><br />
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
      <td align='center'>
      <table border='0' cellspacing='0' cellpadding='0'>
      <tr> <td>
      <a href='https://www.tyan.com/partner-backend/' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' >LOG IN</a>
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
      <p style='font-family: arial; line-height:130%; font-size: 12px;text-align: center;'>&copy; MiTAC Digital Technology Corporation and/or any of its affiliates. <br />All Rights Reserved.</p>

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

      $mail->Subject = "New lead notification"; //設定郵件標題
      $mail->Body = $Sales_content; //設定郵件內容
      $mail->IsHTML(true); //設定郵件內容為HTML
  $mail->SMTPAutoTLS = false;

      $mail->AddAddress($Semail, $Susername); //設定收件者郵件及名稱
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

        $admail->From = "no-reply@tyan.com"; //設定寄件者信箱
        $admail->FromName = "MiTAC Partner Zone"; //設定寄件者姓名

        $admail->Subject = "New lead notification (SALES)"; //設定郵件標題
        $admail->Body = $errorMail; //設定郵件內容
        $admail->IsHTML(true); //設定郵件內容為HTML
    $admail->SMTPAutoTLS = false;
        $admail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱
        //$admail->AddCC("even.syao@tyan.com.tw", "even.syao");
        $admail->Send();
        echo "Mailer Error(Company): " . $mail->ErrorInfo;
        mysqli_close($link_db);
        exit();
      }else{
        //echo "success";
        header('Location: https://www.tyan.com/RFQprocess@done');
        mysqli_close($link_db);
        exit();
      }
      //****** To Sales END*******

	}else{
		echo "N";
		mysqli_close($link_db);
	  exit();
	}
}

mysqli_close($link_db);
exit();
?>