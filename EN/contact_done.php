<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');
require "../config.php";

include("./PHPMailer-master/PHPMailerAutoload.php"); //匯入PHPMailer類別
//require_once __DIR__ . '/includes/recaptcha/autoload.php';

session_cache_limiter('private, must-revalidate');
session_start();

if (isset($_SESSION["Checknum"]) != '') {
    if ($_SESSION["Checknum"] == $_POST['Checknum1']) {
        //$msg = "You enter the correct verification code！";
        //echo "susses";
    } else {
        //$msg = "Wrong Security Code! Please enter again.";
        //echo "<script>alert('".$msg."');history.go(-1);</script>";
        echo "Wrong Security Code! Please enter again.";
        exit();
    }
}

$link_db = mysqli_connect($db_host, $db_user, $db_pwd, $dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');
//$select=mysqli_select_db($dataBase,$link_db);

function dowith_sql($str)
{
    //$str = str_replace("and","",$str);
    //$str = str_replace("execute","",$str);
    //$str = str_replace("update","",$str);
    //$str = str_replace("count","",$str);
    //$str = str_replace("chr","",$str);
    //$str = str_replace("mid","",$str);
    //$str = str_replace("master","",$str);
    //$str = str_replace("truncate","",$str);
    //$str = str_replace("char","",$str);
    //$str = str_replace("declare","",$str);
    //$str = str_replace("select","",$str);
    //$str = str_replace("create","",$str);
    //$str = str_replace("delete","",$str);
    //$str = str_replace("insert","",$str);
    //$str = str_replace("'","&#39;",$str);
    //$str = str_replace('"',"&#34;",$str);
    //$str = str_replace(".","",$str);
    //$str = str_replace("or","",$str);
    $str = str_replace("=", "", $str);
    //$str = str_replace("?","",$str);
    $str = str_replace("%", "", $str);
    $str = str_replace("0x02BC", "", $str);
    //$str = str_replace("%20","",$str);
    $str = str_replace("<script", "", $str);
    $str = str_replace("/script>", "", $str);
    $str = str_replace("<style>", "", $str);
    $str = str_replace("</style>", "", $str);
    //$str = str_replace("<","&lt;",$str);
    //$str = str_replace(">","&gt;",$str);
    //$str = str_replace("/","&#x2F;",$str);
    //$str = str_replace("&","&amp;",$str);
    $str = str_replace("<img", "", $str);
    $str = str_replace("/img>", "", $str);
    $str = str_replace("<a", "", $str);
    $str = str_replace("/a>", "", $str);
    return $str;
}

if ($_POST['fName'] != "") {
    $f_Name = dowith_sql($_POST['fName']);
} else {
    echo "Required field!";
    exit();
}
if ($_REQUEST['fCName'] != "") {
    $f_cName = dowith_sql($_REQUEST['fCName']);
} else {
    echo "Required field!";
    exit();
}
if ($_POST['fEmail'] != "") {
    $f_Email = preg_replace("/['\"\~\%\$ \r\n\t;<>\?]/i", '', $_POST['fEmail']);
} else {
    echo "Invalid e-mail address!";
    exit();
}
if ($_REQUEST['fPhone'] != "") {
    $f_Phone = dowith_sql($_REQUEST['fPhone']);
    $f_Phone = htmlspecialchars($f_Phone, ENT_QUOTES);
} else {
    echo "Required field!";
    exit();
}
if ($_POST['nlang'] != "") {
    $nlang = dowith_sql($_POST['nlang']);
} else {
    echo "Please select your region.";
    exit();
}
if ($_POST['PType'] != "") {
    $PType = dowith_sql($_POST['PType']);
} else {
    echo "Please select your product type.";
    exit();
}
if ($_POST['s_Type'] != "") {
    $s_Type = dowith_sql($_POST['s_Type']);
} else {
    echo "Please select your type.";
    exit();
}
if ($_POST['fMessage'] != "") {
    $f_Message = $_POST['fMessage'];
} else {
    echo "Please leave your message.";
    exit();
}

$f_Name1 = $f_Name;
$f_Name2 = htmlspecialchars($f_Name1, ENT_QUOTES);

$f_cName1 = $f_cName;
$f_cName2 = htmlspecialchars($f_cName1, ENT_QUOTES);

$message1 = $f_Message;
$message2 = htmlspecialchars($message1, ENT_QUOTES);


$Mcount = "600000000";

switch ($PType) {
    case "MB":
        $PType1 = "Motherboard";
        break;
    case "Embedded":
        $PType1 = "Embedded System";
        break;
    case "PanelPC":
        $PType1 = "Panel PC";
        break;
    case "TB":
        $PType1 = "Tablet/Kiosk";
        break;
    default:
}

putenv("TZ=Asia/Taipei");
$now = date("Y/m/d H:i:s");
$now1 = date("Y/m/d");

$str_New = "select `ID` from `contact_us_new` order by `ID` desc limit 1";
$check_New = mysqli_query($link_db, $str_New);
$Max_ID = mysqli_fetch_row($check_New);
if (empty($Max_ID)) {
    $Mcount = $Mcount + 1;
} else {
    $Mcount = $Max_ID[0] + 1;
}

$str_inst = "INSERT INTO `contact_us_new`(`ID`, `NAME`, `COMPANYNAME`, `EMAIL`, `PHONE`, `REGION`, `ProductType`, `Type`, `MESSAGE`, `CREATEDATE`) VALUES ('" . $Mcount . "','" . $f_Name2 . "','" . $f_cName2 . "','" . $f_Email . "','" . $f_Phone . "','" . $nlang . "','" . $PType1 . "', '" . $s_Type . "', '" . $message2 . "','" . $now . "')";

if (mysqli_query($link_db, $str_inst)) {
    if ($nlang == "en-US") {
        $nlang01 = "United States";
    } else if ($nlang == "SA") {
        $nlang01 = "Central / South America";
    } else if ($nlang == "EUR") {
        $nlang01 = "Europe";
    } else if ($nlang == "ME") {
        $nlang01 = "Middle East / Africa";
    } else if ($nlang == "ASIA") {
        $nlang01 = "Asia";
    } else if ($nlang == "NA") {
        $nlang01 = "North America";
    } else if ($nlang == "Oceania") {
        $nlang01 = "Oceania";
    }

    if ($s_Type == "enquiry") {
        $type = "Enquiry";
    } else if ($s_Type == "TS") {
        $type = "Technical Support";
    } else if ($s_Type == "other") {
        $type = "Others";
    }

    $name = "NAME : " . $f_Name . "<br>";
    $company = "Company Name : " . $f_cName . "<br>";
    $email = "Email : " . $f_Email . "<br>";
    $phone = "Phone : " . $f_Phone . "<br>";
    $Region = "Region : " . $nlang01 . "<br>";
    $P_type = "Product Type : " . $PType1 . "<br>";
    $Type = "Request Type : " . $type . "<br>";
    $message = "Message : " . $f_Message . "<br>";

    $body = $name . $company . $email . $phone . $Region . $P_type . $Type . $message;

    $cus_header = "<table border=0 cellpadding=20 cellspacing=0 width=100% id=templateHeader>
                  <tr>
                    <td align=center valign=top style=padding-bottom:0px;>
                      <table border=0 cellpadding=0 cellspacing=0 width=560>
                        <tr>
                          <td class=headerContent>
                            <img src =/images/mct_logo_404.png />
                            <p><h1>#" . $Mcount . "-" . $now1 . "</h1></p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>";

    $cus_content = "<table border=0 cellpadding=20 cellspacing=0 width=100% id=templateBody>
                    <tr>
                      <td align=center valign=top>
                        <table border=0 cellpadding=0 cellspacing=0 width=560>
                          <tr><td></td></tr>
                            <tr mc:repeatable>
                              <td align=center colspan=2 style=padding-bottom:20px;>
                                <table border=0 cellpadding=20 cellspacing=0 width=560 class=couponBlock>
                                  <tr>
                                    <td align=left valign=top>
                                      <table border=0 cellpadding=0 cellspacing=0>
                                        <tr>
                                          <td colspan=2 valign=top  class=couponContent >
                                            <div>
                                              Dear [" . $f_Name . "],<br /><br />
                                              Thank you for contacting us. Your message ID is <strong>#" . $Mcount . "</strong>. Your message has been received and we will respond to you as soon as possible.
                                              <br /><br />
                                              Here is your submitted information:<br /><br />
                                            </div>
                                            <table style=width:100%>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Name:</strong>" . $f_Name . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Company Name:</strong>" . $f_cName . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Email:</strong>" . $f_Email . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Phone:</strong>" . $f_Phone . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Region:</strong>" . $nlang01 . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Product Type:</strong>" . $PType1 . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Request Type:</strong>" . $type . "<hr></td></tr>
                                              <tr><td style=border-bottom:1px dotted #ccc; padding:4px><strong>Message:</strong> <br /><br />" . $f_Message . "<hr></td></tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </table><br />
                                    </td>
                                  </tr>
                                </table>
                                <img src=http://gallery.mailchimp.com/27aac8a65e64c994c4416d6b8/images/coupon_shadow_b.png height=15 width=560 style=display:block;>
                                <div class=couponContent style=color:#c00><center>** This is an automated response by an unmonitored mail account.</center></div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>";

    $cus_body = $cus_header . $cus_content;

    //***************20180312 客戶通知信 *******************
    $cus_mail = new PHPMailer(); //建立新物件
    $cus_mail->IsSMTP(); //設定使用SMTP方式寄信
    $cus_mail->SMTPAuth = false; //設定SMTP需要驗證
    //$mail->SMTPSecure = "ssl"; //ssl tls
    //$mail->SMTPDebug = 2;
    $cus_mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
    $cus_mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
    $cus_mail->CharSet = "utf-8"; //設定郵件編碼

    $cus_mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
    $cus_mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

    $cus_mail->From = "noreply@mct.com"; //設定寄件者信箱
    $cus_mail->FromName = "MiTAC Computing Technology"; //設定寄件者姓名

    $cus_mail->Subject = "We have received your message"; //設定郵件標題
    $cus_mail->Body = $cus_body; //設定郵件內容
    $cus_mail->IsHTML(true); //設定郵件內容為HTML
    $cus_mail->SMTPAutoTLS = false;
    $cus_mail->AddAddress($f_Email, $f_Name); //設定收件者郵件及名稱
    if (!$cus_mail->Send()) {
        $mail = new PHPMailer(); //建立新物件
        $mail->IsSMTP(); //設定使用SMTP方式寄信
        $mail->SMTPAuth = false; //設定SMTP需要驗證
        //$mail->SMTPSecure = "ssl"; //ssl tls
        //$mail->SMTPDebug = 2;
        $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
        $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
        $mail->CharSet = "utf-8"; //設定郵件編碼

        $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
        $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

        $mail->From = "noreply@tyan.com"; //設定寄件者信箱
        $mail->FromName = "Tyan Computer"; //設定寄件者姓名

        $mail->Subject = "MCT contact us send customer error"; //設定郵件標題
        $mail->Body = $cus_body; //設定郵件內容
        $mail->IsHTML(true); //設定郵件內容為HTML
        $mail->SMTPAutoTLS = false;
        $mail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱
        $mail->AddCC("even.syao@tyan.com.tw", "even.syao");
        $mail->Send();
    } else {
    }
    //***************20180312 客戶通知信 End *******************

    $mail = new PHPMailer(); //建立新物件
    $mail->IsSMTP(); //設定使用SMTP方式寄信
    $mail->SMTPAuth = false; //設定SMTP需要驗證
    //$mail->SMTPSecure = "ssl"; //ssl tls
    //$mail->SMTPDebug = 2;
    $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
    $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
    $mail->CharSet = "utf-8"; //設定郵件編碼

    $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
    $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

    $mail->From = "Sales_client@mic.com.tw"; //設定寄件者信箱
    $mail->FromName = "MiTAC Computing Technology"; //設定寄件者姓名

    $mail->Subject = "Contact Us Notification - #" . $Mcount . " " . $now1; //設定郵件標題
    $mail->Body = $body; //設定郵件內容
    $mail->IsHTML(true); //設定郵件內容為HTML
    $mail->SMTPAutoTLS = false;

    $mail->AddAddress("sales_client@mic.com.tw", "Mitac computer"); //設定收件者郵件及名稱
    //$mail->AddAddress("nick.t@tyan.com.tw", "nick.t"); //設定收件者郵件及名稱
    if (!$mail->Send()) {
        $data = $now . " - Mail - error\n";
        $fp = fopen("../Files/maillog.txt", "a");
        fwrite($fp, $data);
        fclose($fp);
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "susses";
        //echo "<script>alert('Thank you for contacting with us. We will respond to you shortly.');</script>";
        //echo "<script>document.location.href='http://www.tyan.com/EN/contact/'</script>";
    }
} else {
    echo "Failed to send your message. Please check your input and try again.";
    $mail = new PHPMailer(); //建立新物件
    $mail->IsSMTP(); //設定使用SMTP方式寄信
    $mail->SMTPAuth = false; //設定SMTP需要驗證
    //$mail->SMTPSecure = "ssl"; //ssl tls
    //$mail->SMTPDebug = 2;
    $mail->Host = "10.88.0.58"; //設定SMTP主機   smtp.gmail.com
    $mail->Port = 25; //設定SMTP埠位，預設為25埠   587 80
    $mail->CharSet = "utf-8"; //設定郵件編碼

    $mail->Username = "global-marketing@tyan.com"; //設定驗證帳號   tyanwebsite@gmail.com
    $mail->Password = "Tyan1989@"; //設定驗證密碼   9ijnmklp0

    $mail->From = "noreply@tyan.com"; //設定寄件者信箱
    $mail->FromName = "Tyan Computer"; //設定寄件者姓名

    $mail->Subject = "MCT contact us error"; //設定郵件標題
    $mail->Body = "Insert data failed."; //設定郵件內容
    $mail->IsHTML(true); //設定郵件內容為HTML
    $mail->SMTPAutoTLS = false;
    $mail->AddAddress("nick.t@tyan.com.tw", "Nick.t"); //設定收件者郵件及名稱
    $mail->AddCC("even.syao@tyan.com.tw", "even.syao");
    $mail->Send();
}

mysqli_close($link_db);
