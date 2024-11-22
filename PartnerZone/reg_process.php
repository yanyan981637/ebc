<?php
// ini_set('display_errors', 1);
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
// header("X-Frame-Options: DENY");
// header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://ipc.mitacmdt.com/");
// header("Cache-Control: no-store, no-cache, must-revalidate");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header('Content-Type: text/html; charset=utf-8');
// if (strpos(trim(getenv('REQUEST_URI')), '?') != '' || strpos(trim(getenv('REQUEST_URI')), '?') === 0 || strpos(trim(getenv('REQUEST_URI')), "'") != '' || strpos(trim(getenv('REQUEST_URI')), "'") === 0 || strpos(trim(getenv('REQUEST_URI')), "script") != '' || strpos(trim(getenv('REQUEST_URI')), ".php") != '') {
//     echo "<script language='javascript'>self.location='/index.html'</script>";
//     exit;
// }
// error_reporting(1);
// session_start();
if (isset($_SESSION["Checknum"]) != '') {
    if ($_SESSION["Checknum"] == $_POST['Checknum']) {
        //$msg = "You enter the correct verification code！";
        //echo "susses";
    } else {
        //$msg = "Wrong Security Code! Please enter again.";
        //echo "<script>alert('".$msg."');history.go(-1);</script>";
        echo "Wrong Security Code! Please enter again.";
        exit();
    }
}
require "config.php";
require "countryCodeReplace.php";
require "../mail_setting.php";

include("PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別
$link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
function dowith_sql($str)
{
    $str = str_replace("and", "", $str);
    $str = str_replace("execute", "", $str);
    $str = str_replace("update", "", $str);
    $str = str_replace("count", "", $str);
    $str = str_replace("chr", "", $str);
    $str = str_replace("mid", "", $str);
    $str = str_replace("master", "", $str);
    $str = str_replace("truncate", "", $str);
    //$str = str_replace("char","",$str);
    $str = str_replace("declare", "", $str);
    $str = str_replace("select", "", $str);
    $str = str_replace("create", "", $str);
    $str = str_replace("delete", "", $str);
    $str = str_replace("insert", "", $str);
    $str = str_replace("'", "&#39;", $str);
    $str = str_replace('"', "&quot;", $str);
    //$str = str_replace(".","",$str);
    //$str = str_replace("or","",$str);
    $str = str_replace("=", "", $str);
    $str = str_replace("?", "", $str);
    $str = str_replace("%", "", $str);
    $str = str_replace("0x02BC", "", $str);
    //$str = str_replace("%20","",$str);
    $str = str_replace("<script>", "", $str);
    $str = str_replace("</script>", "", $str);
    $str = str_replace("<style>", "", $str);
    $str = str_replace("</style>", "", $str);
    $str = str_replace("<img>", "", $str);
    $str = str_replace("</img>", "", $str);
    $str = str_replace("<a>", "", $str);
    $str = str_replace("</a>", "", $str);
    return $str;
}
if ($_POST['kind'] != "") {
    $kind = dowith_sql($_POST['kind']);
    $kind = filter_var($kind);
} else {
    $kind = "";
}
putenv("TZ=Asia/Taipei");
$now = date("Y/m/d H:i:s");
$now1 = date("Y/m/d");
if ($kind == "register") {
    if ($_POST['username'] != "") {
        $username = dowith_sql($_POST['username']);
        $username = filter_var($username);
    } else {
        $username = "";
    }
    if ($_POST['companyname'] != "") {
        $companyname = dowith_sql($_POST['companyname']);
        $companyname = filter_var($companyname);
    } else {
        $companyname = "";
    }
    if ($_POST['email'] != "") {
        $email = dowith_sql($_POST['email']);
        $email = filter_var($email);
    } else {
        $email = "";
    }
    if ($_POST['countryCode'] != "") {
        $countryCode = dowith_sql($_POST['countryCode']);
        $countryCode = filter_var($countryCode);
    } else {
        $countryCode = "";
    }
    if ($_POST['tel'] != "") {
        $tel = dowith_sql($_POST['tel']);
        $tel = filter_var($tel);
    } else {
        $tel = "";
    }
    if ($_POST['Msg'] != "") {
        $mailMsg = filter_var($_POST['Msg']);
        $Msg = dowith_sql($_POST['Msg']);
        $Msg = filter_var($Msg);
    } else {
        $Msg = "";
    }
    // Remove the existed partner_user check
    // $str = "SELECT ID, CompanyName, Email FROM partner_user WHERE Email='" . $email . "'";
    // $cmd = mysqli_query($link_db, $str);
    // $result = mysqli_fetch_row($cmd);
    // if ($result[2] == $email) {
    //     echo "email";
    //     mysqli_close($link_db);
    //     exit();
    // }
    $Verification = date("Y/m/d H:i:s", strtotime("+1 months", strtotime($now)));
    //******** rand 產生新密碼 ********
    $random = 6; //亂數長度
    for ($i = 1; $i <= $random; $i++) {
        $c = rand(1, 3);
        //chr()將數值轉變為對應英文
        if ($c == 1) {
            $a = rand(97, 122);
            $b = chr($a);
        }
        if ($c == 2) {
            $a = rand(65, 90);
            $b = chr($a);
        }
        if ($c == 3) {
            $b = rand(0, 9);
        }
        $password = $password . $b;
    }
    //**********************************
    $strCompanyID = "SELECT CompanyID FROM partner_user WHERE 1 ORDER BY CompanyID DESC";
    $cmdCompanyID = mysqli_query($link_db, $strCompanyID);
    $resultCompanyID = mysqli_fetch_row($cmdCompanyID);
    if ($resultCompanyID[0] == "") {
        $CompanyID = "CP1000001";
    } else {
        $arr_ID = explode("CP", $resultCompanyID[0]);
        $CompanyID = $arr_ID[1] + 1;
        $CompanyID = "CP" . $CompanyID;
    }
    $salesID = "";
    // Remove the existed partner_user insert
    // $str_inst_u = "INSERT INTO partner_user(CompanyID, Name, CompanyName, Email, Password, CountryCode, Tel, Message, ResponsibleSales, FirstLogin, C_DATE
    // , IndexCard, IndexAnn, IndexRelease, IndexQuote, IndexProduct, IndexFGroup, confirm_member)";
    // $str_inst_u .= " VALUES ('" . $CompanyID . "','" . $username . "','" . $companyname . "','" . $email . "','" . $password . "','" .
    //     $countryCode . "','" . $tel . "','" . $Msg . "','0','1','" . $now . "',1,'','','','','',0)";
    // $cmd_u = mysqli_query($link_db, $str_inst_u);
    // $str_UID = "SELECT ID FROM partner_user WHERE Email='" . $email . "'";
    // $cmd_UID = mysqli_query($link_db, $str_UID);
    // $result_UID = mysqli_fetch_row($cmd_UID);
    // $UserID = $result_UID[0];
    if (isset($_GET["RFQsku"])) {
        $RFQsku = "";
    } else {
        $RFQsku = dowith_sql($_COOKIE['RFQsku']);
        $RFQsku = filter_var($RFQsku);
    }
    if ($RFQsku != "") {
        $arr_sku = explode(",", $RFQsku);
        $j = 0;
        $arrMail = [];
        foreach ($arr_sku as $key => $value) {
            if ($value != "") {
                $str = "SELECT Product_SKU_Auto_ID, SKU, MODELCODE, ProductTypeID FROM product_skus WHERE SKU='" . $value . "'";
                $cmd = mysqli_query($link_db, $str);
                $result = mysqli_fetch_row($cmd);
                $arrPID .= $result[0] . ",";
                $arrPTID .= $result[3] . ",";
                $arrSKU .= $result[1] . ",";
                $arrMODEL .= $result[2] . ",";
                if ($result[3] == 107) { //Industrial Panel PC
                    $mail = "sales_client@mitacmdt.com";
                } elseif ($result[3] == 108) {  //Embedded System
                    $mail = "sales_client@mitacmdt.com";
                } elseif ($result[3] == 109) {  //Industrial Motherboard
                    $mail = "sales_client@mitacmdt.com";
                } elseif ($result[3] == 110) {  //OCP Server
                    $mail = "Sales_enterprise@mic.com.tw";
                } elseif ($result[3] == 111) {  //OCP Mezz
                    $mail = "Sales_enterprise@mic.com.tw";
                } elseif ($result[3] == 112) {  //JBOD / JBOF
                    $mail = "Sales_enterprise@mic.com.tw";
                } elseif ($result[3] == 113) {  //OCP Rack
                    $mail = "Sales_enterprise@mic.com.tw";
                } elseif ($result[3] == 114) {  //POS
                    $mail = "sales_client@mitacmdt.com";
                } elseif ($result[3] == 115) {  //5G Edge Computing
                    $mail = "Sales_enterprise@mic.com.tw";
                }
                if (in_array($mail, $arrMail)) {
                    //重複
                } else {
                    array_push($arrMail, $mail);
                }
            }
            $j++;
        }
        $strQuoteID = "SELECT ID FROM partner_leads_quote WHERE 1 ORDER BY ID DESC";
        $cmdQuoteID = mysqli_query($link_db, $strQuoteID);
        $resultQuoteID = mysqli_fetch_row($cmdQuoteID);
        if ($resultQuoteID[0] == "") {
            $QuoteID = "LD1000001";
        } else {
            $arr_ID = explode("LD", $resultQuoteID[0]);
            $QuoteID = $arr_ID[1] + 1;
            $QuoteID = "LD" . $QuoteID;
        }
        $str_inst_sq = "INSERT INTO partner_leads_quote(ID, SalesID, UserID, CompanyID, Product_ID, ProductTypeID, MODEL, SKU, QuoteQty, Verification, STATUS, FEregister, C_DATE)";
        $str_inst_sq .= " VALUES ('" . $QuoteID . "','0','" . $UserID . "','" . $CompanyID . "','" . $arrPID . "','" . $arrPTID . "','" . $arrMODEL . "','" . $arrSKU . "','" . $arrQty . "','" . $Verification . "','Processing','1','" . $now . "')";
        $cmd_sq = mysqli_query($link_db, $str_inst_sq);
        $result = mysqli_affected_rows($link_db);
        if ($result > 0) {
            //setcookie("RFQsku","",time()-3600*24*7, "/");
        } else {
            echo "Insert partner_leads_quote error";
            mysqli_close($link_db);
            exit();
        }
        $user_content = "
      <body style='margin: 0;padding: 0;'>
        <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
          <tr>
            <td align='center'>
              <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                  <td style='padding: 25px 0;'>
                    <table  align='center'>
                     <tr>
                       <td style='width:220px'><img src='https://ipc.mitacmdt.com/images/mct-logo-email.png' style='border:0px;' /></td>
                       <td vlign='middle' align='center'> <div style='font-family: Arial; line-height:100%; font-size:20px; font-weight:bold; color:#434343;'> Partner Zone <br /><span style=' font-size:12px; font-weight:normal'>MiTAC Digital Technology</span></div></td>
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
                        <h2 style='font-family: Arial; line-height:130%; text-align:left; font-size:14px'>Hi " . $username . ",</h2>
                        <!-- Action -->
                        <table style='width: 100%;  margin: 10px auto;  padding: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                          <tr>
                            <td align='center'>
                              <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
                                Thank you for your interest in MiTAC Digital Technology. <br />
                                We will contact with you shortly to check your requirements.
                                <br />
                                Here are the request info.<br /><br />
                                =============================<br />
                                Lead ID: " . $QuoteID . "<br />
                                Company Name: " . $companyname . " (" . $CompanyID . ")
                              </p>
                              <!--if there is RFQ, then show this-->
                              <table style='width: 100%;  padding: 0px;  text-align: left; font-family: arial;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                                <tr><th colspan='2' ><h3>RFQ:</h3></th></tr>
                                <tr style='background:#eee'><th style='padding:5px'>Product</th><!--<th style='padding:5px'>Qty</th>--></tr>
                                ";
        $tmp_sku = explode(",", $arrSKU);
        $tmp_MODEL = explode(",", $arrMODEL);
        foreach ($tmp_sku as $key => $value) {
            if ($value != "") {
                $user_content .= "<tr><td style='padding:5px; border-bottom:1px solid #eee'>" . $value . " (" . $tmp_MODEL[$key] . ")</td><td style='padding:5px; border-bottom:1px solid #eee'>" . $new_arrQty[$value] . "</td></tr>";
            }
        }
        $user_content .= "
                              </table>
                              <!--end RFQ-->
                              <br /><br />
                            </p><p style='font-family: arial; line-height:130%; font-size:12px; text-align:left;'>With Regards<br />Partner Zone | MiTAC Digital Technology</p>
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
        $mail = mail_setting($mail_host, $mail_port, $mail_user, $mail_pwd,
            'business@mitacmdt.com', 'Partner Zone | MiTAC Digital Technology',
            $email, $username,
            'Thank you for interesting in MiTAC Digital Technology', $user_content
        );
        if (!$mail->Send()) {
            $errorMail = $mail->ErrorInfo;
            $adminMail = mail_setting('10.88.0.58', '25', null, null,
                'no-reply@mitacmdt.com', 'MiTAC Digital Technology',
                null, null,
                'MDT IPC contact us send customer error', $errorMail,
                true
            );
            $adminMail->Send();
            echo "Mailer Error(Mapped): " . $errorMail;
            mysqli_close($link_db);
            exit();
        } else {
        }
        //****** To USER END*******
        //****** To Sales *******
        $str_country = "SELECT ID, Regions, CountryCode, CountryName, CodeNumber FROM partner_countrycode WHERE CountryCode='" . $countryCode . "'";
        $cmd_country = mysqli_query($link_db, $str_country);
        $CodeNumber = mysqli_fetch_row($cmd_country);
        $Sales_content = "
      <body style='margin: 0;padding: 0;'>
      <table style='width: 100%;margin: 0;padding: 0;-premailer-width: 100%;-premailer-cellpadding: 0;-premailer-cellspacing: 0;background-color: #F2F4F6;' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
          <td align='center'>
            <table style='width: 100%; margin: 0; padding: 0; -premailer-width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0;' width='100%' cellpadding='0' cellspacing='0'>
              <tr>
                <td style='padding: 25px 0;'>
                  <table  align='center'>
                    <tr>
                      <td style='width:220px'><img src='https://ipc.mitacmdt.com/images/mct-logo-email.png' style='border:0px;' /></td>
                      <td vlign='middle' align='center'> <div style='font-family: Arial; line-height:100%; font-size:20px; font-weight:bold; color:#434343;'> Partner Zone <br /><span style=' font-size:12px; font-weight:normal'>MiTAC Digital Technology</span></div></td>
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
                        <h2 style='font-family: Arial; line-height:130%; text-align:left; font-size:14px'>Hi,</h2>
                        <!-- Action -->
                        <table style='width: 100%;  margin: 10px auto;  padding: 0;  text-align: center;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                          <tr>
                            <td align='center'>
                              <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
                              There is a new request from MCT Partner Zone.
                              <br />
                              Here are the details.<br /><br />
                              =============================<br />
                              Lead ID: " . $QuoteID . "<br />
                              Name: " . $username . "<br />
                              Company Name: " . $companyname . " (" . $CompanyID . ")<br />
                              Email Address: " . $email . "<br />
                              Contact Tel: " . $tel . "<br />
                              Region: " . country($countryCode) . "<br />
                              Message: " . $Msg . "
                              </p>
                              <!--RFQ show here-->
                              <table style='width: 100%;  padding: 0px;  text-align: left; font-family: arial;' align='center' width='100%' cellpadding='0' cellspacing='0'>
                                <tr><th colspan='2' ><h3>RFQ:</h3></th></tr>
                                <tr style='background:#eee'><th style='padding:5px'>Product</th><!--<th style='padding:5px'>Qty</th>--></tr>";
        $tmp_sku = explode(",", $arrSKU);
        $tmp_MODEL = explode(",", $arrMODEL);
        foreach ($tmp_sku as $key => $value) {
            if ($value != "") {
                $Sales_content .= "<tr><td style='padding:5px; border-bottom:1px solid #eee'>" . $value . " (" . $tmp_MODEL[$key] . ")</td><td style='padding:5px; border-bottom:1px solid #eee'>" . $tmp_Qty[$key] . "</td></tr>";
            }
        }
        $Sales_content .= "
                              </table>
                            <!--end RFQ-->
                            <br /><br />
                            <p style='font-family: arial; line-height:130%;  text-align:left; font-size:14px'>
                              Please contact with the client ASAP. If there is no action for this request after 3 days, the system will update it to 'Invalid' status automatically. <br /><br />
                              You can <a href='https://ipc.mitacmdt.com/partner-backend/login' />log into MCT Partner Zone Back-end</a> and go to <strong>'Leads Mgt'</strong> to check / proceed this request.
                            </p>
                            <br /><br />
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                              <tr>
                                <td align='center'>
                                  <table border='0' cellspacing='0' cellpadding='0'>
                                    <tr> <td>
                                      <a href='https://ipc.mitacmdt.com/partner-backend/login' style='font-family: arial; line-height:130%; background-color: #3869D4; border-top: 10px solid #3869D4; border-right: 18px solid #3869D4;border-bottom: 10px solid #3869D4;border-left: 18px solid #3869D4;display: inline-block;color: #FFF;text-decoration: none;border-radius: 3px;box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);-webkit-text-size-adjust: none;' >LOG IN</a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                          <br /><br />
                          <p style='font-family: arial; line-height:130%; font-size:12px; text-align:left;'>MCT Partner Zone</p>
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
        # ***************20240628 窗口通知信 *******************
            $mail = mail_setting($mail_host, $mail_port, $mail_user, $mail_pwd,
                'business@mitacmdt.com', 'MCT Partner Zone',
                'sales_client@mitacmdt.com', 'Mitac computer',
                'New lead notification', $Sales_content
            );

            if (!$mail->Send()) {
                echo "Failed to send your message. Please check your input and try again.";
                $errorMail = $mail->ErrorInfo;
                $adminMail = mail_setting('10.88.0.58', '25', null, null,
                    'business@mitacmdt.com', 'MCT Partner Zone',
                    null, null,
                    'New lead notification(TO Sales)', 'Insert data failed.',
                    true
                );
                $adminMail->Send();
                echo "Mailer Error(Mapped): " . $errorMail;
                mysqli_close($link_db);
                exit();
            }
        # ***************20240628 窗口通知信 End *******************
        echo "success";
        mysqli_close($link_db);
        exit();
    }
}
