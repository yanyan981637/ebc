<?php
header("X-Frame-Options: DENY");
//header("Content-Security-Policy-Report-Only: default-src *; img-src https:; frame-src 'none'; report-uri http://www.tyan.com");
header("Content-Security-Policy-Report-Only: default-src *; img-src *; frame-src *; script-src * 'unsafe-inline'; style-src * 'unsafe-inline'; report-uri https://ipc.mitacmdt.com/");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header('Content-Type: text/html; charset=utf-8');

if(strpos(trim(getenv('REQUEST_URI')),'?')!='' || strpos(trim(getenv('REQUEST_URI')),'?')===0 || strpos(trim(getenv('REQUEST_URI')),"'")!='' || strpos(trim(getenv('REQUEST_URI')),"'")===0 || strpos(trim(getenv('REQUEST_URI')),"script")!='' || strpos(trim(getenv('REQUEST_URI')),".php")!=''){
echo "<script language='javascript'>self.location='/404.htm'</script>";
exit;
}

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
   $str = str_replace("'","",$str);
   $str = str_replace('"',"",$str);
   $str = str_replace(".","",$str);
   $str = str_replace("or","",$str);
   $str = str_replace("=","",$str);
   $str = str_replace("?","",$str);
   $str = str_replace("%","",$str);
   $str = str_replace("0x02BC","",$str);
   return $str;
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/images/ico/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!-- Stylesheets
============================================= -->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="/css/style.css" type="text/css" />
<link rel="stylesheet" href="/css/swiper.css" type="text/css" />
<link rel="stylesheet" href="/css/dark.css" type="text/css" />
<link rel="stylesheet" href="/css/font-icons.css" type="text/css" />
<link rel="stylesheet" href="/css/animate.css" type="text/css" />
<link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" />
<link rel="stylesheet" href="/css/responsive.css" type="text/css" />
<link rel="stylesheet" href="/css/colors.css" type="text/css" />
<link rel="stylesheet" href="/css/custom.css" type="text/css" />
<script src="/js/jquery.js"></script>
<!-- Document Title
============================================= -->
<title>TYAN SERVER MANAGEMENT (TSM ) SOFTWARE - EULA</title>

</head>

<body class="stretched">


<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

<?php
include("../top.htm");
?>





<!-- Page Title & breadcrumb
		============================================= -->
		<!--<section id="page-title">

			<div class="container clearfix">
				<h1>Privacy Policy</h1>
					<span></span>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
				</ol>
			</div>

		</section><!-- #page-title & breadcrumb end -->
		<!--<div id="page-title-btm-border"><p>&nbsp;&nbsp;</p></div>-->




		<!-- Content
		============================================= -->


		<section id="content" >

			<div class="content-wrap">
				<div class="container clearfix">

				<h1 style="text-align:center">TYAN SERVER MANAGEMENT (TSM SOFTWARE) SOFTWARE
END USER LICENSE AGREEMENT</h1>

<p style="color:#707070; font-style: italic; text-align:center">UPDATED: 2021/05/12</p>

					<div class="box" style="background:#fff">





			IMPORTANT, PLEASE READ CAREFULLY: THIS END USER LICENSE AGREEMENT "EULA" IS A LEGAL AGREEMENT BETWEEN YOU (AS AN INDIVIDUAL OR ENTITY, "YOU" THE "CUSTOMER") AND MiTAC Digital Technology Corporation ( "MITAC", "TYAN", OR "WE") FOR USE OF THE TYAN SERVER MANAGEMENT SOFTWARE ("TSM SOFTWARE"), AND IT’S APPLICATION PROGRAM INTERFACES ("APIs") PROVIDED. IF YOU ACCEPT THIS AGREEMENT ON BEHALF OF AN ENTITY, YOU REPRESENT AND WARRANT TO MITAC THAT YOU HAVE LEGAL AUTHORITY TO BIND THAT ENTITY. BY INSTALLING, COPYING, OR OTHERWISE USING THE TSM SOFTWARE, YOU AGREE TO BE BOUND BY THE TERMS OF THIS EULA. IF YOU DO NOT AGREE WITH THE TERMS OF THIS EULA, DO NOT USE THE TSM SOFTWARE. <br><br>

This EULA and the Licensing Policy can be updated at any time without notice to you, in MITAC's sole discretion and will be made available at https://www.tyan.com/TSM/EULA/.<br><br>

<h2>1. License Grant</h2>
Subject to the terms and restrictions set forth in this EULA, MITAC grants to you a limited, non-transferable and non-exclusive license to execute one copy of the TSM SOFTWARE solely for the non-commercial use.  <br><br>

You may use the TSM SOFTWARE for the licenses that you have purchased. You are permitted to make copies of the TSM SOFTWARE for your own use in accordance to EULA and Licensing Policy. Any copies or partial copies of the TSM SOFTWARE that you make must incorporate all patent, copyright and trademark notices.
<br><br>
<h2>2. License Limitations</h2>
You may not, and may not authorize or permit to: (a) use the TSM SOFTWARE for any purpose in a manner inconsistent with the design or documentations of the TSM SOFTWARE; (b) license, distribute, lease, rent, lend, transfer, assign or otherwise dispose of the entirety or part of the TSM SOFTWARE or use the TSM SOFTWARE for any commercial purpose; (c) reverse engineer, decompile, disassemble, or any trade secrets related to the TSM SOFTWARE, except and only to the extent that such activity is expressly permitted by applicable law or open source license notwithstanding this limitation; (d) adapt, modify, alter, or translate the TSM SOFTWARE, or create any derivative works of the TSM SOFTWARE except and only to the extent that such activity is expressly permitted by applicable law or open source license; (e) remove, alter or obscure any trademark, logo, copyright notice and other rights notice, legends, symbols or labels on the TSM SOFTWARE; (f) use the TSM SOFTWARE in violation of any applicable laws or regulations, such as hacking or spamming, or abuse it in any way or (g) circumvent or attempt to circumvent any methods employed by MITAC or TYAN to control access to the components, features or functions of the TSM SOFTWARE.
<br><br>
<h2>3. Intellectual Property Right</h2>
The all worldwide copyright and other intellectual property rights in the TSM SOFTWARE are the exclusive property of MITAC and/or its supplier(s) or licensor(s). Any rights not expressly granted in this Agreement are reserved to MITAC. No transfer of ownership of any intellectual property will occur under this Agreement.
<br><br>
<h2>4. Open Source</h2>
Certain items included in the TSM SOFTWARE are subject to open source software  licenses ("OSS License Software"), including LGPL, CC0-1.0, CC-BY-3.0, CC-BY-4.0, MPL 2.0, Apache 2, Expat license, ZPL 2.1 ,ISC, WTFPL, BSD-2, BSD-3, MIT, Python style, PSFL, DBAD license etc. The OSS License Software is licensed under the terms of the applicable open source software licenses that accompanies such OSS License Software. Nothing in this EULA limits your rights under, or grants you rights that supersede, the terms and conditions of any applicable open source software licenses.
<br><br>

<h2>5. APIs Agreement</h2>
The application programming interface software provided by MITAC to you (the "APIs") will provide you with the ability to customize your applications for the functions of the TSM SOFTWARE. Your license to access our APIs and documentation is limited and subject to your compliance with the terms and conditions of the EULA and related license terms and conditions of the APIs. Further, you have to agree to the following limitations on using the APIs of the TSM SOFTWARE.
<ul style="margin-left:20px">
<li>Do Not use the APIs on behalf of any third party.</li>
<li>Do Not use the APIs to violate of any law or regulation.</li>
<li>Do Not use the APIs in a product or service that competes with products or services offered by MITAC.</li>
<li>Do not use the APIs to perform an action with the intent of introducing to products and services any viruses, worms, defects, Trojan horses, malware, or any items of a destructive nature.</li>
<li>MITAC reserve the rights to charge fees for your use the APIs for certain commercial uses. </li>

<ul>
<br><br>

<h2>6. Updates</h2>
MITAC may at any time and from time to time modify or release subsequent versions  of TSM SOFTWARE and its APIs and require that you use those subsequent versions. You acknowledge that once MITAC releases a subsequent version of the APIs, the prior version of the APIs may stop working at any time or may no longer work in the same manner. Your continued use of the TSM SOFTWARE and the APIs following a subsequent release will be deemed your acceptance of modifications.
<br><br>
<h2>7. Disclaimer</h2>
MITAC may offer free or trial version of the TSM SOFTWARE. During the free or trial period, no express or implied warranties shall apply to the TSM SOFTWARE, all services and TSM SOFTWARE are provided "as-is" with all defects, and no technical or other support is included.<br><br>

MITAC MAKES NO WARRANTY AND REPRESENTATIONS ABOUT THE SUITABILITY, RELIABILITY, AVAILABILITY, TIMELINESS, LACK OF VIRUSES OR OTHER HARMFUL COMPONENTS AND ACCURACY OF THE INFORMATION, TSM SOFTWARE, APIS AND RELATED GRAPHICS CONTAINED WITHIN THE TSM SOFTWARE FOR ANY PURPOSE. ALL SUCH INFORMATION, TSM SOFTWARE, APIS AND RELATED GRAPHICS ARE PROVIDED "AS IS" AND "AS AVAILABLE" WITHOUT WARRANTY OF ANY KIND. MITAC HEREBY DISCLAIMS ALL WARRANTIES AND CONDITIONS WITH REGARD TO THIS INFORMATION, TSM SOFTWARE, APIS AND RELATED GRAPHICS, INCLUDING ALL IMPLIED WARRANTIES AND CONDITIONS OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, WORKMANLIKE EFFORT, TITLE, LEGAL STATUS, AND NON-INFRINGEMENT.<br><br>

IN NO EVENT SHALL MITAC BE LIABLE FOR ANY DIRECT, INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL, CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS OF USE, DATA OR PROFITS, ARISING OUT OF OR IN ANY WAY CONNECTION WITH THE USE, PERFORMANCE OR ACCURACY OF THE TSM SOFTWARE, APIS AND RELATED GRAPHICS OR WITH THE DELAY OR INABILITY TO USE THE TSM SOFTWARE, APIS AND RELATED GRAPHICS, OR THE PRODUCT WITH WHICH THE TSM SOFTWARE, APIS AND RELATED GRAPHICS　ARE ASSOCIATED, WHETHER BASED ON CONTRACT, TORT, NEGLIGENCE, STRICT LIABILITY OR OTHERWISE, EVEN IF MITAC HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.<br><br>


<h2>8. Limitations of Liability</h2>
IN ANY CASE, MITAC'S LIABILITY ARISING OUT OF OR IN CONNECTION WITH THIS AGREEMENT WILL BE LIMITED TO THE AMOUNT OF DAMAGES FORESEEABLE AT THE TIME OF ENTERING INTO THIS AGREEMENT, IN NO EVENT SHALL THE LIABILITY OF MITAC TO YOU UNDER THIS AGREEMENT EXCEED AN AMOUNT EQUAL TO THAT PAID BY YOU TO MITAC IN CONNECTION WITH YOUR USE OF THE TSM SOFTWARE IN TWELVE-MONTH PERIOD IMMEDIATELY PRECEDING THE DATE ON WHICH YOUR WRITTEN DEMAND FOR DAMAGES IS MADE. THE FOREGOING DISCLAIMER AND LIMITATION OF LIABILITY WILL APPLY TO THE MAXIMUM EXTENT PERMITTED BY THE APPLICABLE LAW IN JURISDICTION.
<br><br>

<h2>9. Maintenance and Support</h2>
Subject to CUSTOMER's payment of the corresponding fees (if any), MITAC shall provide reasonable technical support. You shall provide MITAC with such technical information and assistance as MITAC may reasonably request in order for it to provide support. Subject to CUSTOMER's payment of the corresponding fees (if any), MITAC shall provide the TSM SOFTWARE's updates, enhancements and maintenance modifications as they become available.
<br><br>

<h2>10. Security</h2>
Access credentials of the TSM SOFTWARE (such as account information and license key) are intended to be used by you. You will keep your credentials confidential. MITAC shall not be responsible for any losses or damages caused by missing or disclosing your confidential credentials.
<br><br>


<h2>11. Assignment</h2>
MITAC may assign its rights under this Agreement without cause. This Agreement will be binding upon and will inure to the benefit of the parties, their successors and permitted assigns.
<br><br>



<h2>12. Export</h2>
You agree that the TSM SOFTWARE will not be shipped, transferred, exported, or re-exported into any country or used in any manner prohibited by the United States Export Administration Act or any other applicable export laws, restriction or regulations (collectively, the "Export Laws"). If the TSM SOFTWARE, APIS or related graphics, or any component thereof, is identified as an export controlled item under the Export Laws, you represent and warrant that you are not a citizen, or otherwise located within, an embargoed nation and that you are not otherwise prohibited under the Export Laws from receiving the TSM SOFTWARE, APIS or related graphics, or any component thereof. All rights to use the TSM SOFTWARE, APIS or related graphics, or any component thereof under this Agreement are granted on the condition that such rights are forfeited if your representations and warranties in this section are not true.
<br><br>


<h2>13. Governing Law</h2>
Except to the extent applicable law, if any, provides otherwise, this EULA will be governed by the law of the Republic of China, excluding its conflict of law provisions.
<br><br>

<h2>14. Audit</h2>
MITAC reserves the right to audit you for compliance with this EULA and your applications to ensure it does not violate this EULA. You agree that you will cooperate with inquiries related to such an audit and provide MITAC with proof that you and your applications comply with this EULA.
<br><br>

<h2>15. Indemnification</h2>
You shall indemnify MITAC and its third party suppliers against any claims related to the use of the TSM SOFTWARE, APIS or related graphics, or any component thereof.
<br><br>

<h2>16. Waiver</h2>
A waiver by either party of any term or condition of this EULA or any breach thereof, in any one instance, will not waive such term or condition or any subsequent breach thereof.
<br><br>

<h2>17. Termination</h2>
This EULA is effective on the date you first use the TSM SOFTWARE. MITAC may terminate this EULA at any time if (a) you fail to comply with any term(s) hereof, or (b) you become bankrupt or insolvent under the applicable bankruptcy laws or other governmental authority. Upon termination of this EULA, the license granted hereunder will terminate and you must stop all use of the TSM SOFTWARE, delete and/or destroy the TSM SOFTWARE and any copies thereof, but the terms of Sections 1 through 17 (inclusive) shall remain effective after any such termination.
<br><br>

<h2>18. Miscellaneous</h2>
<ul style="margin-left:20px">
<li>The TSM SOFTWARE and the APIs are intended for use by businesses and organizations and not for consumer purposes. To the maximum extent permitted by law, you hereby acknowledge and agree that consumer laws do not apply.</li>
<li>Force Majeure: Neither WE nor YOU will be liable by reason of any failure or delay in the performance of its obligations on account of events beyond the reasonable control of a party, which may include strikes, shortages, riots, fires, acts of God, war, terrorism, and governmental actions.</li>
</ul><br><br>




















<br /><br /><br /><br />






					</div>


					</div>


					<div class="clear"></div>



				</div>

		</section><!-- #content end -->






















<?php
include("../foot.htm");
?>

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts
============================================= -->
<script src="/js/plugins.js"></script>


<!-- Footer Scripts
============================================= -->
<script src="/js/functions.js"></script>

</body>
</html>