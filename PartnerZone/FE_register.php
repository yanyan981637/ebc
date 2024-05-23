<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src 'none'; img-src *; frame-src *; script-src 'strict-dynamic' 'nonce-rAnd0m123' 'unsafe-inline' http: https:; style-src * 'unsafe-inline'; object-src 'none'; base-uri 'self'; report-uri https://www.mitacmct.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

require "config.php";

$link_db=mysqli_connect($db_host,$db_user,$db_pwd,$dataBase);
mysqli_query($link_db, 'SET NAMES utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_CLIENT=utf8');
mysqli_query($link_db, 'SET CHARACTER_SET_RESULTS=utf8');

function dowith_sql($str){
  $str = str_replace("and","",$str);
  $str = str_replace("execute","",$str);
  $str = str_replace("update","",$str);
  $str = str_replace("count","",$str);
  $str = str_replace("chr","",$str);
  $str = str_replace("<script>","",$str);
  $str = str_replace("</script>","",$str);
  $str = str_replace("javascript","",$str);
  $str = str_replace("mid","",$str);
  $str = str_replace("master","",$str);
  $str = str_replace("truncate","",$str);
  $str = str_replace("char","",$str);
  $str = str_replace("declare","",$str);
  $str = str_replace("select","",$str);
  $str = str_replace("create","",$str);
  $str = str_replace("delete","",$str);
  $str = str_replace("insert","",$str);
  $str = str_replace("'","",$str);
  $str = str_replace('"',"",$str);
//$str = str_replace("or","",$str); //2017.05.23 因舊資料SKU關係, 暫時註解
  $str = str_replace("=","~",$str);
  return $str;
}
if(isset($_GET['rfq'])!=''){
  $rfq=dowith_sql($_GET['rfq']);
  $rfq=filter_var($rfq);
}else{
  $rfq="";
}
if(isset($_GET['qty'])!=''){
  $qty=dowith_sql($_GET['qty']);
  $qty=filter_var($qty);
}else{
  $qty="";
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">


  <title>MiTAC Partner Zone - Registration</title>


  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
  <link rel="shortcut icon" href="/images/ico/favicon.ico">
  <link rel="manifest" href="images/favicon/site.webmanifest">
  <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">

  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/selects/select2.min.css">

  <!-- END VENDOR CSS-->
  <!-- BEGIN ROBUST CSS-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/app.css">
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/font-awesome/css/fontawesome.css" >
  <link rel="stylesheet" type="text/css" href="app-assets/fonts/feather/fonts/style.min.css" >  
  <!-- END ROBUST CSS-->
  <!-- BEGIN Page Level CSS-->
  <!--<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">-->
  <link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/register.css">
  <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-content-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-content-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-12 col-12 box-shadow-2 p-0" >
              <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div ><a href="index.html" /><img src="app-assets/images/logo/tyan-logo-register.png" /></a></div>
                    <h1>MiTAC Partner Zone</h1>
                    <h2>Registration</h2>
                    <p>Please fill out the form below. <span style="color:#c00">All fields are required.</span> <br />We will contact you soon after receiving your application.</p>
                    <div style="font-size:1.4rem; font-weight:bold;">
                      <a href="index.html" />If you already have an account on MiTAC Partner Zone, please log in</a>.
                    </div>
                  </div>

                </div>
                <div class="card-content">  
                  <div class="card-body">

                    <form id="form1" name="form1">
                      <div class="row">
                        <div class="col-md-6"><div class="form-group">
                          <label for="username"><span class="red">* </span>Name:</label>
                          <input type="" class="form-control" id="username" placeholder="" required>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">
                          <label for="companyname"><span class="red">* </span>Company Name:</label>
                          <input type="" class="form-control" id="companyname" placeholder="" required>
                        </div></div>
                      </div>
                      <div class="row">
                        <div class="col-md-12"><div class="form-group">
                          <label for="email"><span class="red">* </span>Email Address:</label>
                          <input type="" class="form-control" id="email" placeholder="" required>
                          <div id="err_Email" class="alert alert-danger mb-1" role="alert" style="display:none">
                            Please enter a valid email.
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="countryCode"><span class="red">* </span>Tel:</label>
                          <select id="countryCode" class="select2 form-control">
                            <option value=''>Please select…</option>
                            <?php
                            include("countryCode.php");
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="tel">&nbsp;</label>
                          <input id="tel"  type="text" class="form-control" placeholder="" required>
                        </div>
                      </div>
                    </div>
      


                  <!--if there is RFQ, then show this-->
                  <input id="Quote" type="hidden" value="<?=$rfq;?>">
                  <input id="QuoteQty" type="hidden" value="<?=$qty;?>">
                  <?php
                  if($rfq!=""){
                  ?>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card" style="background: rgba(219, 232, 252, 0.8)">
                        <div class="card-body">
                          <h4 class=""><i class="fa fa-usd"></i> Quote:</h4>
                          <table class="table table-sm" style="background:#fff" >
                            <tr>
                              <th>Product</th>
                              <th>Qty</th>
                            </tr>
                            <?php 
                            $arr_sku=explode(" ", $rfq);
                            $arr_qty=explode(" ", $qty);
                            $i=0;
                            foreach ($arr_sku as $key => $value) {
                              $value=filter_var($value);
                              if($value!=""){
                                $str="SELECT `Product_SKU_Auto_ID`, `SKU`, `MODELCODE`, `Quote` FROM `product_skus` WHERE SKU='".$value."' AND Quote=1 AND Product_SKU_Auto_ID>'700000000'";
                                $cmd=mysqli_query($link_db,$str);
                                $result=mysqli_fetch_row($cmd);
                                if($result[0]!=""){
                                  echo "<tr>";
                                  echo "<td>".$result[1]." (".$result[2].")</td>";
                                  echo "<td>".$arr_qty[$key]."</td>";
                                  echo "<input id='Q_prID_".$i."' type=hidden value=".$result[0].">";
                                  echo "</tr>";
                                  $tmpID.=$result[0].",";
                                  $i++;
                                }
                              }
                            }
                            ?>
                            <input id="total" type="hidden" value="<?=$tmpID;?>">
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  }
                  ?>
                  
                  <!--end RFQ-->



                  <div class="row">
                    <div class="col-md-12"><div class="form-group">
                      <label for="email">Message:</label>
                      <textarea id="Msg" class="form-control" rows="2"></textarea>

                    </div>

                  </div>
                </div>








                <div style="margin:1% 0">&nbsp;</div>
                <h4 style="color:#004898">Terms of Use, Privacy Policy and Cookie Policy</h4>
                <p style="font-size:0.9em">Before you proceed with registration, please review our Terms of Use, Privacy Policy and Cookie Policy in full to ensure that you understand the contents.</p>
                <div id="term" >


                  <h4 style="color:#004898">Privacy Policy</h4>
                  <br />


                  This privacy policy explains how MiTAC Computing Technology Corporation and its affiliates, including but without limitation to Tyan Computer Corporation (collectively "MiTAC", "Tyan" or "We") use personal data from and about you, on the portal site operated by MiTAC, by phone, email, or otherwise when you visit our website (the "Website"), or use the services provided on and through our Website, including providing after-sales services.<br /><br />
                  MiTAC is committed to protecting your personal data and being transparent about what information it holds. MiTAC understands its obligations to help you understand how and why MiTAC processes your personal data. This policy tells you about the why, what, how, and when in relation to MiTAC’s collection and processing of your personal data.  
                  <br /><br />


                  <h4>PURPOSE AND BASIS OF MITAC'S COLLECTION, PROCESSING AND USE OF YOUR PERSONAL DATA</h4>
                  We collect and process your personal data for purpose of performing our obligations under the applicable agreement(s) with you or providing our services based on your request. <br /><br />
                  We use the personal data collected from you for purpose of delivering our services to you, rendering of repair and maintenance services, and, upon receipt of your consent, providing you with updated news and marketing information.  <br /><br />
                  We also use your personal data to respond to you when you contact us. <br />


                  <br />
                  <h4>TYPE OF DATA MITAC MAY COLLECT FROM YOU</h4>
                  The types of personal data we may collect and process about you include: <br />
                  <ul style="margin-left:30px">
                    <li>Your name and contact information (e.g., email and phone number(s));</li>
                    <li>Business information details such as information provided in the course of the contractual relationship between you and MiTAC, or otherwise voluntarily provided by you;</li>
                    <li>Information that is collected  when you visit on of our Website such as cookies;</li> 
                    <li>Persistent identifier such as a customer number or other information held in a cookie or IP address; and</li>
                    <li>Other information alike that helps fulfill the purpose for which it was collected.</li>
                  </ul>
                  <br />
                  <h4>MAJOR SYSTEMS WHICH MAY COLLECT YOUR PERSONAL DATA</h4><br />
                  <h3>1.  Technical Support System</h3>

                  Upon your registration to our technical support system, we may ask you to provide personal data such as your e-mail address, name, telephone number, or persistent identifier (such as a customer number held in a cookie) which is associated with individually identifiable information.  We may combine the information you provide on the Website with other information we may collect from you offline or from third parties so that we can tailor the Website, services, and offerings to you more effectively.<br />

                  <br />
                  <br />
                  <h4>COOKIES</h4><br />
                  <ol style="margin-left:30px">
                    <li>A "Cookie" is a small file, typically of letters and numbers, downloaded on to a device (such as desktop, laptop, tablet) when the user accesses certain websites. Cookies are then sent back to the originating website on each subsequent visit. Cookies are useful because they allow a website to recognize a user’s device. The information below explains the cookies we use on our Website and why we use them:</li>
                    <li>Cookies and similar technologies allow us to provide you with, for example, customized information from our Website and to make our Website more user-friendly through customer recognition, understanding and facilitation of the customer browsing. This may include, for example, remembering your language selection so you don’t have to re-enter it every time you visit our Website.</li>
                    <li>In addition, cookies allow us to understand which pages you have visited and to determine how frequently particular pages are visited and to determine the most popular areas of our Website. This enables us to improve our Website and apps to offer the best browsing experience for you.</li>
                    <li>Our Website also employs cookies and similar technologies placed by our carefully selected third party partners.</li>
                    <li>You can enable or disable cookies by modifying the settings in your browser. However, to make full use of our Website, cookies need to be enabled on your browser or device. If you choose not to allow cookies you will not be able to browse parts of our Website. </li>
                    <li>We may have a variety of pages on social networking sites. If you use these pages, the hosting sites may store cookies onto your device. We do not control the setting of, and accept no liability in connection with these cookies. Please look at the third-party websites for more information about the cookies they use and how you can manage them. Please read the terms of the applicable application for more information.</li>
                    <li>Third party cookies are those that are set by a domain different to the one that the user is visiting. MiTAC uses some carefully selected third parties to provide certain services to improve the services we offer to you. Some of these third parties use cookies. Information about how we use third parties and what cookies they use and why, is given below.</li>
                    <li>MiTAC also provides links to external third party websites and you may choose to click through to these sites. If you do so, these third party sites may send cookies to your browser. We do not control the setting of, and accept no liability in connection with, these cookies. Please look at the cookies policies on the respective Websites for more information about what they do with cookies and how you can manage them.</li>

                    <li>Below list includes cookies deployed by such third parties on our Website.<br />

                      <h3>Google Analytics</h3>
                      At MiTAC, we use Google Analytics to help us understand how our customers navigate to and through our Website. These cookies enable the function of Google analytics. This service helps us understand how long customers spend visiting different pages and how often they return to our Website. Google Analytics also helps our marketing colleagues to work out the effectiveness of our digital marketing campaigns. You can find out how to opt out of these cookies here: <a href="https://tools.google.com/dlpage/gaoptout" target="aa" />https://tools.google.com/dlpage/gaoptout</a><br /><br />
                      To know more information about Cookie, please see <a href="/EN/legal/cookie_policy/" target="aa" />Cookie Policy</a>.
                    </li>
                  </ol>

                  <br />
                  <h4>SHARING OF YOUR PERSONAL INFORMATION</h4>

                  <ol style="margin-left:30px">
                    <li>Your personal data collected by MiTAC may be shared with Tyan Computer Corporation and companies within MiTAC group so as to allow MiTAC to carry out the purposes stated above. </li>
                    <li>MiTAC is required to disclose certain personal data collected from you to third parties (e.g.  logistic service provider(s), maintenance service provider(s), email delivery service provider(s), marketing service provider(s) and cloud service provider(s)) we have chosen to support us  for carrying out the purposes stated above. </li>
                    <li>With your prior consent, we may share information about you for publicity and marketing purposes online, in print and on social media. </li>
                    <li>We reassure you that, MiTAC will, under no circumstances, sell your personal data to third parties or permit third parties to sell the data we have shared with them. </li>
                  </ol>

                  <br />
                  <h4>TRANSFERRING PERSONAL DATA OUTSIDE THE COUNTRY</h4>
                  Where transfers are to be made outside of the European Economic Area, MiTAC will ensure that the destination country(ies) has data protection laws assessed as adequate by the European Commission or where adequate safeguards are in place. <br /> 

                  <br />
                  <h4>YOUR RIGHTS</h4>
                  <ol style="margin-left:30px">
                    <li>Right to withdraw consent. Where MiTAC is collecting or/and processing data based on your consent, you have the right to withdraw that consent at any time. </li>
                    <li>In addition, you have the right to:
                      <ul style="margin-left:50px">
                        <li>access your personal data;</li>
                        <li>copy or transfer your personal data;</li>
                        <li>demand rectification of incorrect or incomplete data;</li>
                        <li>require deletion or removal of your personal data; </li>
                        <li>request not to be subject to entirely automatic profiling algorithms;</li>
                        <li>impose restriction on processing of your personal data; and </li>
                        <li>object to the processing of your personal data based on grounds other than your express consent.</li>
                      </ul>
                    </li>
                    <li>We may use automated processing with your personal data to allow us to provide you with service and product information that is most suited for your interests. If you are unhappy with the automated decision, you can <a href="https://www.mitacmct.com/EN/contact/" target="aa" />contact us</a> and request a manual review. </li>
                  </ol>

                  <br />
                  <h4>CHILDREN'S PRIVACY</h4>
                  We encourage parents and guardians to take an active role in their children's online activities. We do not knowingly collect personal information from children without appropriate parental or guardian consent. If you believe that we might have collected personal information from someone under the applicable age of consent without proper consent, please let us know using the methods described below and we will take appropriate measures to investigate and address the issue promptly.<br />

                  <br />
                  <h4>SECURITY OF YOUR PERSONAL INFORMATION</h4>
                  <ol style="margin-left:30px">

                    <li>MiTAC is committed to protecting the information you provide us. We take the information and system security very seriously and we strive to comply with our obligations at all times. MiTAC will take great care in maintaining the security of your personal data and in preventing unauthorized access to it through the use of appropriate technology and internal safeguards.  Your information is protected by controls designed to minimize loss or damage through accident, negligence or deliberate actions. </li>
                    <li>We suggest that you do not share your password information with anyone. If you are sharing a computer with others you should always choose to log out before leaving a site or service to protect access to your information from subsequent users.</li>
                  </ol>
                  <br />
                  <h4>DATA RETENTION PERIOD </h4>
                  <ol style="margin-left:30px">
                    <li>Except as otherwise required by applicable law, MiTAC endeavors to retain your personal data only for as long as is necessary for MiTAC to fulfill the aforementioned purposes. After the data retention period, we will destroy or delete your personal information or make it anonymous such that it cannot be identified or traced back to you.</li>
                    <li>If in the future we intend to process your personal data for a purpose other than that which it was collected, we will notify you of that purpose together with any other relevant information.</li>
                  </ol>

                  <br />



                  <h4>CHANGES TO THIS PRIVACY POLICY</h4>
                  MiTAC may change the terms of the Privacy Policy from time to time. In case of any changes, we will post those changes. When we change the policy in a material way, a notice will be posted on our Website along with the updated Privacy Policy.
                  <br /><br />







                  <h4>CONTACTING US</h4>
                  If you have any concerns as to how your personal data is collected or processed or your rights, or any question about our Privacy Policy, you can contact us via the link below.<br />
                  <a href="/EN/contact/" target="aa" />https://www.mitacmct.com/EN/contact/</a>
                  <br /><br />
                  <p style="color:#707070; font-style: italic;">( Last updated on Aug 2, 2018. )</p>
                  <br /><br />


                  <hr> 
                  <h2 style="color:#004898">Cookie Policy</h2>
                  <br />







                  This cookie policy ("Cookie Policy") applies to <a href="https://www.tyan.com/" />https://www.tyan.com/</a> (the "Website"). The Website is hosted by MiTAC Computing Technology Corporation ("MiTAC"/"we"/"our"/"us") a company incorporated in Taiwan (Company Number28113764 ) with registered office at 3F., No.1, R&D Road 2, Hsinchu Science Park, Hsinchu, Taiwan, R.O.C.<br /><br />
                  As user of the Website ("you"/"your"), you acknowledge that any use of this Website (including any transactions you make) is subject to this Cookie Policy together with other legal documents, such as the Privacy Policy and the Terms of Use ("Terms").<br /><br />
                  MiTAC does not knowingly collect data from any unsupervised person under the age of eighteen (18). If you are under the age of eighteen (18), you are not allowed to use the Website or submit any personal data to us unless you have the consent of, and are supervised by, a parent or guardian.<br /><br />
                  As we are required to provide you with clear and comprehensive information about the cookies which we use on the Website, we provide you with our Cookie Policy which sets out information about cookies and details the cookies we use. By using the Website, mobile website and Apps, you are agreeing to our Privacy Policy and Cookie Policy and you consent to the use of cookies and similar technologies by us and our carefully selected third party partners as described in these policies.
                  <br />

                  <br />
                  <h2>Definitions and Interpretation</h2>
                  A <strong>"Cookie"</strong> is a small file, typically of letters and numbers, downloaded on to a device (such as desktop, laptop, tablet) when the user accesses certain websites. Cookies are then sent back to the originating website on each subsequent visit. Cookies are useful because they allow a website to recognize a user’s device.<br /><br />
                  Cookies are designed to assist your device to remember something the user has done within that website e.g. remembering that the user has logged in, or which buttons have been clicked.
                  <br />
                  <ul style="margin-left:30px">

                    <li><strong>"Session cookies"</strong> allow websites to link the actions of a user only during a browser session to remember items that have been put in a shopping basket or for security reason when a user is accessing internet banking. These session cookies expire after a browser session and are not stored longer term.</li>
                    <li><strong>"Persistent cookies"</strong> are stored on a users’ device in between browser sessions which allows preferences or actions of the user to be remembered. They may be used for a variety of purposes including remembering users’ preferences and choices when using a site to remember your preferred language.</li>
                    <li>For example <strong>"Authentication cookies"</strong> are specific Session cookies related to knowing a user is logged in or not. Authentication cookies are important for the website to know what information to show you, or if it needs to ask you to log in.</li>
                    <li><strong>"First party cookies"</strong> are cookies set by a website visited by the user i.e. the website displayed in the address bar.</li>
                    <li><strong>"Third party cookies"</strong> are cookies that are set by a domain other than the one being visited by the user. If a user visits a website and a separate company sets a cookie through that website. They are used for a variety of reasons.</li>

                    <li><strong>"Essential cookies"</strong> are the cookies which are necessary for the website to function properly and cannot be refused if user wants to visit the website. These cookies are usually only set in response to actions made by you which amount to a request for services, such as setting your privacy preferences, logging in or filling in forms. You can set your browser to block or alert you about these cookies, but some parts of the site will not then work. These cookies do not store any personally identifiable information.</li>
                    <li><strong>"Analytics cookies"</strong> are the cookies to gather information on how you use our website to help us understand how our website is used and improve the user experience (such as understanding which pages are most visited, how long people spend on each page, etc.). The cookies collect information in a way that does not directly identify anyone, it is used for statistical purposes, and we don’t use this information for any advertising or profiling purposes.</li>
                  </ul>
                  If you wish to find out more about cookies, we find this website quite helpful <a href="http://www.allaboutcookies.org/" target="aa" />www.allaboutcookies.org</a> and <a href="http://www.youronlinechoices.eu/" target="aa" />www.youronlinechoices.eu</a>.

                  <br />
                  <br />
                  <h1>Frequently Asked Questions</h1>

                  <h3>WHY USE COOKIES ON THIS WEBSITE?</h3>
                  Cookies and similar technologies allow us to provide you with, for example, customized information from our Website and to make our Website more user-friendly through customer recognition, understanding and facilitation of the customer browsing and shopping behavior. This may include, for example, remembering your language selection so you don’t have to re-enter it every time you visit our Website.<br /><br />
                  In addition, cookies allow us to understand which pages you have visited and to determine how frequently particular pages are visited and to determine the most popular areas of our Website. This enables us to improve our Website and apps to offer the best browsing experience for you.<br /><br />
                  Our Website also employs cookies and similar technologies placed by our carefully selected third party partners to manage our commercial relationship with those partners.<br /><br />


                  <h3>DO I HAVE TO ACCEPT COOKIES?</h3>
                  To make full use of the MiTAC Website, cookies need to be enabled on your browser or device. If you reject cookies, certain features will not work. Cookies are used to offer a personalized experience when browsing the Website on your computer, tablet, mobile phone, and by using apps. If you choose not to allow cookies you will not be able to browse parts of the Website. <br /><br />

                  <h3>HOW LONG DO YOU KEEP COOKIES FOR?</h3>
                  Most of the cookies we use, are Session Cookies thus in most cases we only keep cookies for the duration of your visit to one of our websites. Cookies placed by our carefully selected third party partners may be retained for longer.<br /><br />

                  <h3>DO COOKIES CONTAIN MY PERSONAL INFORMATION?</h3>
                  No, cookies do not contain confidential information such as your home address, telephone number or credit card details. MiTAC does not control what information is stored by third party cookies. <br /><br />


                  <h2>MiTAC on Social Networks</h2>
                  We may have a variety of pages on social networking sites such as Facebook and Twitter. If you use these pages, the hosting sites may store cookies onto your device. We do not control the setting of, and accept no liability in connection with these cookies. Please look at the third-party websites for more information about the cookies they use and how you can manage them.
                  <br />
                  <br />
                  <h2>Third Party Cookies</h2>


                  Third party cookies are those that are set by a domain different to the one that the user is visiting. MiTAC uses some carefully selected third parties to provide certain services to improve the service we offer to you. Some of these third parties use cookies. Information about how we use third parties and what cookies they use and why, is given below.<br /><br />
                  MiTAC also provides links to external third party websites and you may choose to click through to these sites. If you do so, these third party sites may send cookies to your browser. We do not control the setting of, and accept no liability in connection with, these cookies. Please look at the cookies policies on the respective websites for more information about what they do with cookies and how you can manage them.<br /><br />
                  Below list includes cookies deployed by such third parties on our Website: <br />

                  <h3>Google Analytics</h3>

                  <table >
                    <tr><th style="padding:15px; width:25%; vertical-align: top">Purpose and functionality relying on the cookie</th><td>At MiTAC, we use Google Analytics to help us understand how our customers navigate to and through our Website. These cookies enable the function of Google analytics. This service helps us understand how long customers spend visiting different pages and how often they return to our Website. Google Analytics also helps our marketing colleagues to work out the effectiveness of our digital marketing campaigns.
                      You can find out how to opt out of these cookies here: <a href="https://tools.google.com/dlpage/gaoptout" target="aa" />https://tools.google.com/dlpage/gaoptout</a></td></tr>
                    </table>

                    <br /><br />
                    <h2>Changes to this Cookie Policy</h2>

                    We reserve the right to change and update the Cookie Policy at any time. Any such changes will be posted on this Website. The date of the latest update to the Cookie Policy is set out at the top of the Cookie Policy. Changes to the Cookie Policy are effective at the time they are posted to this Website, and your continued use of this Website shall signify your acceptance of, and agreement to be bound by, those changes.

                    <br /><br />
                    <h2>Contact Details</h2>
                    If you have any comments or queries, please contact us via the link below:<br />
                    <a href="https://www.mitacmct.com/EN/contact/"  />https://www.mitacmct.com/EN/contact/</a>


                    <br /><br />

                    <p style="color:#707070; font-style: italic;">( Last updated on Feb 1, 2021. )</p>


                    <hr> 
                    <h2 style="color:#004898">Terms of Use</h2>
                    <br />
                    <p style="font-size:1.1em">
                      PLEASE READ THESE TERMS AND CONDITIONS CAREFULLY BEFORE USING THIS WEBSITE. ACCESSING OR USING THIS WEBSITE INDICATES THAT YOU ACCEPT THE FOLLOWING TERMS AND ALL TERMS AND CONDITIONS CONTAINED AND/OR REFERENCED HEREIN OR ANY ADDITIONAL TERMS AND CONDITIONS SET FORTH ON THIS WEBSITE ("TERMS").  IF YOU DO NOT ACCEPT THESE TERMS, DO NOT USE THIS WEBSITE.</p>
                      <br /><br />
                      MiTAC Computing Technology Corporation and its affiliates, including but without limitation to Tyan Computer Corporation (collectively "MiTAC", "Tyan" or "We") reserves the right to update or amend the Terms at any time without notice to you. Such updated or amended Terms shall be effective upon posting on this Website.
                      <br />

                      <h4>USE OF WEBSITE AND CONTENT</h4>
                      This Website and all the designs, layouts, formats, contents, products, materials, services or information contained on or available through this Website (the "Content") are only for your personal and noncommercial use, provided that you keep intact all copyright and other proprietary notices contained in the original materials on any copies of the Content. You may not in any way modify, reproduce, distribute, transmit, display, perform, publish, license, create derivative works from, transfer, or sell information, software, products or services obtained from the Content. Any use of the Content on any other website or networked computer environment for any purpose is prohibited. You agree not to interrupt or attempt to interrupt the operation of this Website in any way.<br /><br />
                      The Content at this Website is protected by copyright under the relevant copyright laws and international conventions. If you breach any of the Terms, your authorization to use this Website automatically terminates and you must immediately destroy any downloaded or printed materials.<br /><br />
                      MiTAC reserves the right to make deletions, changes or updates with respect to or in the Content or the format thereof at any time without notice to you. MiTAC reserves the right to terminate or restrict the access to or use of the Website for any reason whatsoever at its sole discretion.

                      <br />
                      <h4>DISCLAIMERS</h4>
                      YOUR USE OF THIS WEBSITE IS AT YOUR OWN RISK. THE CONTENT (INCLUDING ALL SOFTWARE) AND SERVICES AT THIS WEBSITE ARE PROVIDED “AS IS” WITHOUT WARRANTIES OF ANY KIND INCLUDING WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT OF INTELLECTUAL PROPERTY. MiTAC's obligations with respect to its products and services are governed solely by the agreements under which they are provided and nothing on this Website shall be construed to alter such agreements. Further, MiTAC does not warrant (i) the accuracy and completeness of the materials, software or services at this Website; or (ii) the server that makes this Website available is free of viruses or other components that may infect, harm, or cause damage to your computer equipment or any other property when you access, browse, download from or otherwise use this Website. The Content, including but not limited to all software, at this Website may be out of date, and MiTAC makes no commitment to update the Content at this Website.


                      <br />
                      <h4>LIMITATION OF LIABILITY</h4>
                      IN NO EVENT WILL MITAC, ITS SUPPLIERS, SUBSIDIARIES, AFFILIATED COMPANIES, OR OTHER THIRD PARTIES MENTIONED AT THIS WEBSITE BE LIABLE FOR ANY DIRECT, INDIRECT, CONSEQUENTIAL, INCIDENTAL, PUNITIVE, OR SPECIAL DAMAGES OR DAMAGES WHATSOEVER (INCLUDING, WITHOUT LIMITATION, THOSE RESULTING FROM LOST PROFITS, LOST DATA OR BUSINESS INTERRUPTION) ARISING OUT OF THE USE, INABILITY TO USE, OR THE RESULTS OF USE OF THIS WEBSITE, ANY WEBSITES LINKED TO THIS WEBSITE, OR THE MATERIALS OR INFORMATION OR SERVICES CONTAINED AT ANY OR ALL SUCH WEBSITES, WHETHER BASED ON WARRANTY, CONTRACT, TORT OR ANY OTHER LEGAL THEORY AND WHETHER OR NOT MiTAC HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. IF YOUR USE OF THE MATERIALS, INFORMATION OR SERVICES FROM THIS WEBSITE OR THE CONTENT RESULTS IN THE NEED FOR SERVICING, REPAIR OR CORRECTION OF EQUIPMENT OR DATA, YOU ASSUME ALL COSTS THEREOF.


                      <br />
                      <h4>USE OF SOFTWARE</h4>
                      Any software that is made available to download from this Website is the copyrighted work of MiTAC and/or its suppliers. Use of the software is governed by the terms of the end user license agreement, if any, which accompanies or is included with the software ("License Agreement"). You may not download or install any Software that is accompanied by or includes a License Agreement unless you have first read and accepted the terms of the License Agreement. REPRODUCTION OR REDISTRIBUTION OF THE SOFTWARE IS PROHIBITED EXCEPT AS PROVIDED FOR IN THE APPLICABLE LICENSE AGREEMENT.<br /><br />
                      Without limiting the foregoing, copying or reproduction of the software to any other server or location for further reproduction or redistribution is expressly prohibited except as provided for in the applicable License Agreement accompanying such software. EXCEPT AS WARRANTED IN THE LICENSE AGREEMENT, MiTAC HEREBY DISCLAIMS ALL WARRANTIES AND CONDITIONS WITH REGARD TO THE SOFTWARE, INCLUDING ALL WARRANTIES AND CONDITIONS OF MERCHANTABILITY, WHETHER EXPRESS, IMPLIED OR STATUTORY, FITNESS FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT.


                      <br />
                      <h4>USER'S MATERIALS</h4>
                      MiTAC does not want to receive confidential or proprietary information from you through this Website. Any material, information or other communication ("Submissions") you provide, send, upload, submit, transmit or post ("Submit") to this Website will be considered non-confidential and non-proprietary. MiTAC will have no obligations with respect to the Submissions.  By Submitting your Submissions you are granting MiTAC and its parent company, subsidiaries, affiliated companies and necessary sublicensees a perpetual and irrevocable permission to copy, disclose, transmit, display, reproduce, edit, reform, distribute, incorporate, translate and otherwise use the Submissions and all data, images, sounds, text, and other things embodied therein for any and all commercial or non-commercial purposes. No compensation will be paid with respect to the use of your Submissions, as provided herein. MiTAC is not obligated to post or use any Submissions you may provide and MiTAC may remove any Submission at any time at its sole discretion. By submitting your Submissions, you warrant and represent that you own or otherwise control all of the rights to your Submissions as described in the Terms including, without limitation, all the rights necessary for you to Submit your Submissions.<br /><br />
                      You are prohibited from posting or transmitting to or from this Website any unlawful, threatening, libelous, defamatory, obscene, pornographic, or other material that would violate any law.


                      <br />
                      <h4>COLLECTION, PROCESSING AND USE OF PERSONAL INFORMATION</h4>
                      The personal information that you provide, enter into or store through this Website, in order to receive products or services or for any other reasons, will be handled by MiTAC in accordance with the Privacy Policy. See the <a href="https://www.tyan.com/EN/legal/privacy_policy/" target="aa" />Privacy Policy</a>.

                      <br />
                      <h4>BULLETIN BOARDS AND OTHER USER FORUMS</h4>
                      MiTAC may, but is not obligated to, monitor or review any areas on the Website where users transmit or post Submissions or communicate solely with each other, including but not limited to chat rooms, bulletin boards or other user forums, and the content of any such Submissions. MiTAC, however, will have no liability related to the content of any such Submissions, whether or not arising under the laws of copyright, libel, privacy, obscenity, or otherwise. MiTAC retains the right to remove messages that include any material MiTAC deems abusive, defamatory, obscene or otherwise unacceptable.

                      <br />
                      <h4>LINKS TO THIRD-PARTY WEBSITES</h4>
                      Links on this Website to third-party websites are provided solely as a convenience to you. If you use these links, you will leave this Website. MiTAC has not reviewed all of these third-party sites and does not control and is not responsible for any of these sites or their content. Thus, MiTAC does not endorse or make any representations about them, or any information, software or other products or materials found there, or any results that may be obtained from using them. If you decide to access any of the third-party websites linked to this Website, you do this entirely at your own risk.

                      <br />
                      <h4>LINKING TO THIS SITE</h4>
                      You may create links to this Website from other sites, but only under MiTAC's permission and in accordance with the terms of the guidelines for linking MiTAC's Website, including but not limited to the follows:<br />
                      <ul style="margin-left:30px">
                        <li>You may not add or modify the frame of this Website.</li>
                        <li>MiTAC is not liable to any liability resulted from any removal or change of the Website directory that causes issues to such linking. MiTAC may make deletions or modifications to the Website, or make relocations or changes of the Website's directory without notice.</li>
                        <li>You may not use any of MiTAC's trademarks, logos or trade-dresses without MiTAC's prior written permission.</li>
                        <li>You may not present any material that is unpleasant, offensive or controversial.</li>
                        <li>You shall present materials that are suitable for all ages.</li>
                        <li>You shall comply with all applicable laws and regulations.</li>


                      </ul>
                      <br />
                      <h4>PRIVACY POLICY</h4>
                      See the <a href="https://www.tyan.com/EN/legal/privacy_policy/" target="aa" />Privacy Policy</a>.



                      <br />
                      <h4>GENERAL PROVISIONS</h4>
                      The Terms and any additional terms and conditions posted on the Website constitute the entire agreement between MiTAC and you with respect to your access or use of this Website. Certain provisions of the Terms may be superseded by expressly designated legal notices or terms located on particular pages at this Website. If for any reason a court of competent jurisdiction finds any provision of the Terms, or portion thereof, to be unenforceable, that provision shall be enforced to the maximum extent permissible so as to affect the intent of it, and the remainder of the Terms shall continue in full force and effect. MiTAC makes no representation that the Content in the Website is appropriate or available for use in any or all locations, and access to them from territories where their content is illegal is prohibited. Your decision and choice to access this Website from any location is on your own initiative and you are responsible for compliance with applicable local laws.

                      <br />



                      <h4>Modern Slavery and Human Trafficking Statement</h4>
                      We are committed to improving our practices to combat slavery and human trafficking. We have implemented EICC (Electronic Industry Code of Conduct) internally and also carried on a project to implement into the sub-tier suppliers by several phases. The program is to ensure MiTAC and its suppliers comply with EICC policy and regulation for a safe, eco-friendly and humane supply chain environment.<br /><br />

                      By accessing or using this Website, you agree to be bound by the Terms and any of its revisions updated or amended by MiTAC.
                      Any rights not expressly granted herein are reserved 

                      <br />
                      <h4>CONTACT US</h4>

                      If you have any concerns as to how your personal data is collected or processed or your rights, or any question about our Terms of Use, you can contact us via the link below.<br />
                      <a href="https://www.mitacmct.com/EN/contact/" target="aa" />https://www.mitacmct.com/EN/contact/</a>

                      <br /><br />
                      <p style="color:#707070; font-style: italic;">( Last updated on Aug 2, 2018. )</p>


                      <br /><br />

                    </div>

                    <div class="checkmark-reg" >
                      <label for="terms"><input id="terms" type="checkbox"><span class="tp-checkmark"></span> I acknowledge and confirm that I have read, understood and agree to MiTAC's <a href="https://www.tyan.com/EN/legal/terms_of_use/" target="TOS">Terms of Use</a> and <a href="https://www.tyan.com/EN/legal/privacy_policy/" target="TOS">Privacy Policy</a>.</label>
                    </div>
                    <div class="text-center">
                      <button id="Submit" type="button"  class="btn btn-lg btn-outline-light btn-primary btn-block" disabled>Submit</button>
                    </div>
                  </form>


                </div>
                <p class="text-center">Already have an account ? <a href="index.html" >Login</a></p>

                <div style="margin:5% 0">&nbsp;</div>
                <div class="copyrightText text-center">Copyright&copy; 2021-2022 MiTAC Computing Technology Corporation (MiTAC Group). All Rights Reserved. <br />Please use the latest version of Firefox or Chrome to view this site.<br />
                  <a href="https://www.tyan.com/EN/legal/terms_of_use/" target="tos" />Terms of Use</a>&nbsp;·&nbsp;
                  <a href="https://www.tyan.com/EN/legal/privacy_policy/" target="tos" />Privacy Policy</a>&nbsp;·&nbsp;
                  <a href="https://www.tyan.com/EN/legal/cookie_policy/" target="tos" />Cookie Policy</a>
                </div>


              </div>
            </div>




          </div>



        </div>
      </section>
    </div>
  </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->








<!-- Repeated Company name msg Modal -->
<div class="modal fade text-left" id="Mydialog" name="Mydialog" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="modal-title text-text-bold-600" ><h1 class="red"><i class="ft-alert-circle"></i></h1></label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            This email is existed. Please log in MiTAC Partner Zone or <a href="https://www.mitacmct.com/EN/contact/" target="_blank ">contact us</a>.
            
          </div>
        </div>                 
      </div>
      <div class="modal-footer">
        <a href="index.html" ><input type="submit" class="btn btn-info btn-lg" value="LOGIN"></a>             
      </div>
      
    </div>
  </div>
</div>
<!-- end Repeated Company name msg Modal -->


  

<script src="app-assets/js/jquery-3.5.1.min.js"></script>
<!-- BEGIN VENDOR JS-->
<script src="app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="app-assets/vendors/js/ui/headroom.min.js"></script>
<script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="app-assets/js/core/app-menu.js"></script>
<script src="app-assets/js/core/app.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="app-assets/js/scripts/forms/form-login-register.js"></script>
<script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- END PAGE LEVEL JS-->

<script src="app-assets/js/functions.js"></script>
<script>
$(function(){
  $("#Submit").click(function(){

    if($("#username").val()==""){
      eval("document.form1['username'].focus()");
      $("#err_Email").hide();
      exit;
    }
    if($("#companyname").val()==""){
      eval("document.form1['companyname'].focus()");
      $("#err_Email").hide();
      exit;
    }
    if($("#email").val()!=""){
      
      var search_str = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
      var mail_val = $("#email").val();
      if(search_str.test(mail_val)){

        $("#err_Email").hide();
      }else{
        $("#err_Email").show();
        eval("document.form1['email'].focus()");
        exit;
      }
    }else if($("#email").val()==""){
      eval("document.form1['email'].focus()");
      $("#err_Email").show();
      exit;
    }
    if($("#countryCode").val()=="none"){
      eval("document.form1['countryCode'].focus()");
      exit;
    }
    if($("#tel").val()==""){
      eval("document.form1['tel'].focus()");
      exit;
    }
    var username = $("#username").val();
    var companyname = $("#companyname").val();
    var email = $("#email").val();
    //var countryCode = $("#countryCode").val();
    var countryCode = $("#countryCode :selected").attr("data-countryCode");
    var tel = $("#tel").val();
    var Msg = $("#Msg").val();
    var Quote = $("#Quote").val();
    var QuoteQty = $("#QuoteQty").val();
    if(Quote!=""){
      var total = $("#total").val();
    }else{
      var total = "";
    }
    
    
    var kind = "register";
    var url = "regProcess";
    $.ajax({
      type: "post",
      url: url,
      dataType: "html",
      data: {
        username : username, 
        companyname : companyname, 
        email : email,
        countryCode : countryCode,
        tel : tel, 
        Msg : Msg,
        Quote : Quote,
        QuoteQty : QuoteQty,
        total : total,
        kind : kind
      },
      success: function(message){
        if(message == "email"){
          $('#Mydialog').modal();
          exit;
        }else if(message == "company"){
          alert(message);
        }else if(message == "success"){
          document.location.href="https://www.tyan.com/RFQprocess@redone";
        }else{
           alert(message);
        }
      }
    });

  })
})

$(function(){
  $("#terms").click(function(){
    var checked = $(this).prop( "checked" );
    if(checked==true){
      $("#Submit").attr("disabled", false);
    }else{
      $("#Submit").attr("disabled", "disabled");
    }
  })
})
</script>
</body>
</html>
<?php
mysqli_close($link_db);
?>